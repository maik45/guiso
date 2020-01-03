<?php
set_time_limit(500);

session_start();
if( empty( $_SESSION['usuario_comedor'] ) ):
  echo "<h1 style='text-align:center;color: #af4040;position: absolute;top: 40%;left: 50%;transform: translate(-50%, -50%) skewX(15deg);font-size: 60px;'>Acceso denegado!!</h1>";
  http_response_code(403);
  exit;
endif;

define('KEY', 'JACE');

require '../db/db.php';

require '../db/vendor/autoload.php';
//carga l libreriia con namespace
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//carga la clase para escribir el excel
use PhpOffice\PhpSpreadsheet\IOFactory;

//recupera las fechas que se desean consultar
$start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_STRING);
$conExcedente = filter_input(INPUT_GET, 'excedente', FILTER_VALIDATE_INT);

$dt = new DateTime( $start );
$semana = $dt->format('W');

function headerExcel( $proveedor, &$indexRow ){
  global $semana, $sheet, $start, $end;

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Proveedor" );
  $sheet->mergeCells("B{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", $proveedor );
  $sheet->getStyle("A{$indexRow}:B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FDFF91');

  $indexRow ++;
  $titulos = ['A'=> 'Línea', 'B'=> 'ID Artículo', 'C'=> 'Descripción', 'D'=> 'Presentación', 'E'=> 'Unidad', 'F'=> 'Cantidad', 'G'=> 'Costo Unidad', 'H'=> 'Costo Total'];
  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  foreach ($titulos as $key => $title){
    $sheet->getColumnDimension($key)->setWidth(16);
    $sheet->setCellValue("{$key}{$indexRow}", " $title");
  }

  $indexRow++;

}

//el reporte se realiza con el total de articulos de los menus
//que adquirio un cliente y unidad,
//en cada hoja va un cliente y unidad
$sql = "SELECT un.unidad, un.idUnidad, cli.nombre as cliente, cli.idCliente 
  FROM 
  unidad as un 
  join cliente as cli on un.cliente=cli.idCliente 
  join menu as me on un.idUnidad=me.unidad 
  join menurec as mr on mr.idMenu=me.idMenu 
  WHERE mr.fecha between '{$start}' AND '{$end}' AND me.activo = 1 
  GROUP BY me.unidad";

//de aqui tenemos la unidad, dependiento del numero registros es una hoja de excel
$unidadResult = $db->query( $sql );

$db->affected_rows or die('No hay información en el rango consultado');

// $hoja = 0;
// $indexRow = 0;

$stockProveedores = [];

while( $itemUnidad = $unidadResult->fetch_object() ){

  $unidad = $itemUnidad->idUnidad;
  $cliente = $itemUnidad->idCliente;

  // recupero las recetas de los menus que pidieron las unidades
  // para que de ahi recupere los articulos 
  $menuResult = $db->query("SELECT mr.personas, mr.precio, (SELECT idReceta FROM receta WHERE nombre = mr.receta LIMIT 1) as idReceta from menurec as mr join menu as me on me.idMenu=mr.idMenu WHERE me.unidad = '{$unidad}' AND mr.fecha between '{$start}' AND '{$end}'");

  while( $itemMenu = $menuResult->fetch_object() ){

    $personas = $itemMenu->personas;
    $idReceta = $itemMenu->idReceta;

    //aqui recupero los articulos de las recetas de los menus de la unidad
    $articulosResult = $db->query( "SELECT re.porciones, reart.cantidad, art.idArticulo, art.nombre, art.costo, art.unidad, art.unidadA as presentacion, art.linea AS lineaId, (SELECT descripcion FROM linea WHERE idLinea = art.linea LIMIT 1) as linea from receta as re join recetaart as reart on re.idReceta=reart.receta join articulo as art on art.idArticulo=reart.articulo where reart.receta = '{$idReceta}'" );

    if( $db->affected_rows <= 0 ) continue;

    while( $itemArticulo = $articulosResult->fetch_object() ){

      $sql = "SELECT pro.nombre as proveedor, pro.idProveedor FROM precioprov as preprov join proveedor as pro on pro.idProveedor = preprov.proveedor WHERE preprov.articulo = '{$itemArticulo->idArticulo}' AND preprov.precio = CAST('{$itemArticulo->costo}' AS FLOAT) LIMIT 1";
      // echo $sql;

      $pro = $db->query( $sql );
      // var_dump($pro);

      $proveedor = 'Ninguno';
      $idProveedor = '0';
      if( $db->affected_rows > 0 ){
        $pro = $pro->fetch_object();
        $proveedor = $pro->proveedor;
        $idProveedor = $pro->idProveedor;
      }
      // var_dump($pro);
      // exit;
      

      // var_dump($proveedor);
      // var_dump($idProveedor);
      // exit;
      //tratare de agrupar los articulos
      //si el idArticulo ya existe en el stock, agregamos el item,
      //si no existe, lo creamos y agregamos en el key
      $porciones = $itemArticulo->porciones;
      $cantidad = $itemArticulo->cantidad;
      $costo = $itemArticulo->costo;

      $itemArticulo->proveedor = $proveedor;
      $itemArticulo->idProveedor = $idProveedor;

      $itemArticulo->cantidadNueva = ( $cantidad / $porciones ) * $personas;
      $itemArticulo->costoT = $costo * $itemArticulo->cantidadNueva;

      //si el proveedor ya existe en mi array assoc
      if( array_key_exists($idProveedor, $stockProveedores) ){

        //entonces verificamos si este articulo ya existe en ese proveedor
        if( array_key_exists($itemArticulo->idArticulo, $stockProveedores[$idProveedor] ) ){
          $stockProveedores[$idProveedor][$itemArticulo->idArticulo]->cantidadNueva += $itemArticulo->cantidadNueva;
        }
        else{
          $stockProveedores[$idProveedor][$itemArticulo->idArticulo] = $itemArticulo;
        }

      }
      else{
        // $stockProveedores[$idProveedor] = [];//inicializamos con un array vacio, ya que es la primera vez que existe
        //entonces a ese proveedor le añadimos en su array el articulo
        $stockProveedores[$idProveedor][$itemArticulo->idArticulo] = $itemArticulo;
        
      }

    }


  }//whileMenu

}//whileUnidad

//aqui comenzamos a generar el excel

//instanciamos el objeto 
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// $hoja = 0;
$indexRow = 1;

//por cada proveedor creo una hoja
// echo "<pre>";

  $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $drawing->setName('Logo');
  $drawing->setDescription('Logo');
  $drawing->setPath('../img/logo_guisopak.png');
  $drawing->setHeight(55);
  $drawing->setCoordinates('A1');
  // $drawing->setOffsetX(10);
  
  $sheet->mergeCells("A1:A2");
  //add logo
  $drawing->setWorksheet($sheet);

  $indexRow = 1;
  //titulo
  $sheet->mergeCells("B{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "GUISOPAK");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  $indexRow++;
  //receta nombre
  $sheet->mergeCells("B{$indexRow}:H{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "Explosión de materiales de artículos");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  //fecha
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Semana:");//semana
  $sheet->setCellValue("B{$indexRow}", $semana);//semana

  $sheet->setCellValue("C{$indexRow}", "Fecha");
  $sheet->setCellValue("D{$indexRow}", $start .' - ' . $end);

  $indexRow++;

  // cabecera del Excel completo
  // cabecera del Excel completo
  // cabecera del Excel completo
  // cabecera del Excel completo


foreach ($stockProveedores as $proveedor) {
  
  // //ordenamos nuestro array de articulos por linea
  usort($proveedor, object_sorter('lineaId', 'ASC'));

  // if( $hoja !== 0 )
    // $spreadsheet->createSheet();//crea una nueva hoja de calculo

  //establecemos la hoja de calculo activa
  // $spreadsheet->setActiveSheetIndex( $hoja );
  // $sheet = $spreadsheet->getActiveSheet();
  headerExcel( $proveedor[0]->proveedor, $indexRow );//da igual la posicion que tome, es el mismo proveedor
  // $hoja++;

  
  $startLinea = $indexRow;//inicio de fila de la linea del articulo

  $lineaUnidad = $proveedor[0]->lineaId;//$proveedor[0]->lineaId;//comenzamos con el indicador para verificar que las lineas sean diferentes y aplicar la sumatoria
  
  foreach ( $proveedor as $row ) {//row es articulo
    
    if( $row->lineaId !== $lineaUnidad ){

      $lineaUnidad = $row->lineaId;//hacemos el cambio de linea
      $cellTotal = "H{$startLinea}:H".($indexRow-1);//determinamos el rango
      $sheet->setCellValue("G{$indexRow}", 'Total');
      $sheet->setCellValue("H{$indexRow}", "=SUM($cellTotal)");
      $sheet->getCell("H{$indexRow}")->getCalculatedValue();//ejecuta la formula
      $startLinea = $indexRow += 2;//dejamos un espacio en blanco entre lineas de articulos
      continue;
    }

    $cantidadExcedente = 0;
    if( $conExcedente ){

      $sql = "SELECT cantidad FROM excedente WHERE articulo = '{$row->idArticulo}' AND unidad = '{$unidad}' LIMIT 1";
      $excedenteResult = $db->query($sql);
      $cantidadExcedente = $db->affected_rows > 0 ? $excedenteResult->fetch_object()->cantidad : 0;
    }


    $sheet->setCellValue("A{$indexRow}", $row->linea);
    $sheet->setCellValue("B{$indexRow}", $row->idArticulo);
    $sheet->setCellValue("C{$indexRow}", $row->nombre);
    $sheet->setCellValue("D{$indexRow}", $row->presentacion);
    $sheet->setCellValue("E{$indexRow}", $row->unidad);
    $sheet->setCellValue("F{$indexRow}", $row->cantidadNueva - $cantidadExcedente );
    $sheet->setCellValue("G{$indexRow}", $row->costo );
    $sheet->setCellValue("H{$indexRow}", "=F{$indexRow}*G{$indexRow}" );
    $sheet->getCell("H{$indexRow}")->getCalculatedValue();//ejecuta la formula

    $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getAlignment()->setWrapText(true);

    $indexRow++;

  }

}

$sheet->setAutoFilter("A6:H{$indexRow}");

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=explosionProveedor ($start - $end).xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');