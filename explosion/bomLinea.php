<?php

set_time_limit(600);

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

//instanciamos el objeto 
$spreadsheet = new Spreadsheet();

//recupera las fechas que se desean consultar
$start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_STRING);
$lineaAconsultar = filter_input(INPUT_GET, 'linea', FILTER_VALIDATE_INT);
$conExcedente = filter_input(INPUT_GET, 'excedente', FILTER_VALIDATE_INT);

$dt = new DateTime( $start );
$semana = $dt->format('W');

function headerExcel( $cliente, $unidad, &$indexRow ){
  global $semana, $sheet, $start, $end;

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
  $sheet->setCellValue("A{$indexRow}", "Cliente:" );
  $sheet->setCellValue("B{$indexRow}", $cliente );

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Unidad:" );
  $sheet->setCellValue("B{$indexRow}", $unidad );

  $indexRow += 2;
  $titulos = ['A'=> 'Línea', 'B'=> 'ID Artículo', 'C'=> 'Descripción', 'D'=> 'Presentación', 'E'=> 'Unidad', 'F'=> 'Cantidad', 'G'=> 'Costo Unidad', 'H'=> 'Costo Total'];
  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:H{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  foreach ($titulos as $key => $title){
    // $sheet->getColumnDimension($key)->setAutoSize(true);
    $sheet->getColumnDimension($key)->setWidth(16);
    $sheet->setCellValue("{$key}{$indexRow}", " $title");
    // $sheet->getStyle("{$key}{$indexRow}:{$key}")->
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
  WHERE date(mr.fecha) between '{$start}' AND '{$end}' AND me.activo = 1 
  GROUP BY me.unidad";

//de aqui tenemos la unidad, dependiento del numero registros es una hoja de excel
$unidadResult = $db->query( $sql );

$db->affected_rows or die('No hay información en el rango consultado');

$hoja = 0;
$indexRow = 0;

while( $itemUnidad = $unidadResult->fetch_object() ){

  $unidad = $itemUnidad->idUnidad;
  $cliente = $itemUnidad->idCliente;

  if( $hoja !== 0 )
    $spreadsheet->createSheet();//crea una nueva hoja de calculo

  //establecemos la hoja de calculo activa como la primera
  $spreadsheet->setActiveSheetIndex( $hoja );
  $sheet = $spreadsheet->getActiveSheet();
  headerExcel( $itemUnidad->cliente, $itemUnidad->unidad, $indexRow );

  $hoja++;
  // recupero las recetas de los menus que pidieron las unidades
  // para que de ahi recupere los articulos 
  $menuResult = $db->query("SELECT mr.personas, mr.precio, (SELECT idReceta FROM receta WHERE nombre = mr.receta LIMIT 1) as idReceta from menurec as mr join menu as me on me.idMenu=mr.idMenu WHERE me.unidad = '{$unidad}' AND date(mr.fecha) between '{$start}' AND '{$end}'");


  $stockArticulos = [];

  while( $itemMenu = $menuResult->fetch_object() ){

    $personas = $itemMenu->personas;
    $idReceta = $itemMenu->idReceta;

    //aqui recupero los articulos de las recetas de los menus de la unidad
    $articulosResult = $db->query( "SELECT re.porciones, reart.cantidad, art.idArticulo, art.nombre, art.costo, art.unidad, art.unidadA as presentacion, art.linea AS lineaId,
     (SELECT descripcion FROM linea WHERE idLinea = art.linea LIMIT 1) as linea from receta as re join recetaart as reart on re.idReceta=reart.receta join articulo as art on art.idArticulo=reart.articulo where reart.receta = '{$idReceta}' AND art.linea = '{$lineaAconsultar}'" );

    // $db->affected_rows or die('No hay información de los articulos');
    if( $db->affected_rows <= 0 ) continue;

    while( $itemArticulo = $articulosResult->fetch_object() ){

      //tratare de agrupar los articulos
      //si el idArticulo ya existe en el stock, agregamos el item,
      //si no existe, lo creamos y agregamos en el key
      $porciones = $itemArticulo->porciones;
      $cantidad = $itemArticulo->cantidad;
      $costo = $itemArticulo->costo;

      $itemArticulo->cantidadNueva = ( $cantidad / $porciones ) * $personas;
      $itemArticulo->costoT = $costo * $itemArticulo->cantidadNueva;

      //si la llave ya existe le vamos sumando cantidad
      if( array_key_exists($itemArticulo->idArticulo, $stockArticulos) ){
        $stockArticulos[$itemArticulo->idArticulo]->cantidadNueva += $itemArticulo->cantidadNueva;
        // $stockArticulos[$itemArticulo->idArticulo] = $itemArticulo;
      }
      else{
        $stockArticulos[$itemArticulo->idArticulo] = $itemArticulo;
      }
      
    }


  }//whileMenu
  

  usort($stockArticulos, object_sorter('lineaId', 'ASC'));

  $startLinea = $indexRow;//inicio de fila de la linea del articulo
  $lineaUnidad = $stockArticulos[0]->lineaId;//comenzamos con el indicador para verificar que las lineas sean diferentes y aplicar la sumatoria

  $length = count($stockArticulos) - 1;//2
  foreach ($stockArticulos as $i => $row ) {
    if( $row->lineaId !== $lineaUnidad || $length === $i ){//si la linea es diferente o si es el ultimo elemento del array

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

  // //set autoFilter de un rango
  $sheet->setAutoFilter("A7:H{$indexRow}");

}//whileUnidad


header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=explosionPorUnidad&Linea ($start - $end).xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');