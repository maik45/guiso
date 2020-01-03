<?php
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
// $spreadsheet = new Spreadsheet();

//recupera las fechas que se desean consultar
$start = filter_input(INPUT_GET, 'start', FILTER_SANITIZE_STRING);
$end = filter_input(INPUT_GET, 'end', FILTER_SANITIZE_STRING);

// Se crea el número de páginas necesarias
// $sql = "SELECT COUNT(*) as hojas FROM menu as me join menurec as mr on mr.idMenu=me.idMenu WHERE ( mr.fecha between '{$start}' AND '$end' ) AND activo = 1";
// $r = $db->query($sql);
// $db->affected_rows > 0 or die('Error en la consulta, intente nuevamente');

// $hojas = $r->fetch_object()->hojas;

// $hojas > 0 or die('No hay información en ese rango de fechas');


// echo $hojas;

//aqui crea esa cantidad de numero de hojas en excel, que son muchismias , asi que hay que optimizarlo
//hace un bucle y en cada iteracion crea una hojas de eexcel nueva


//dice que trae toda la informacion de menu que corresponda al rango de fecha
$sql = "SELECT me.idMenu, me.cliente, me.unidad, mr.receta, mr.fecha, me.grupo, mr.personas, mr.pos, mr.precio FROM menu as me inner join menurec as mr on me.idMenu = mr.idMenu WHERE ( mr.fecha between '{$start}' AND '$end' ) AND activo = 1";
$r = $db->query($sql);

$db->affected_rows > 0 or die('No hay información en ese rango de fechas');

$rows = [];
while( $row = $r->fetch_object() ){

  // en row tengo disponibles las propiedades
  //idMenu (String)
  //cliente (int)
  //unidad (String) //numerico
  //receta (String) //nombre de receta
  //fecha (string) //datetime
  //grupo (String) //numerico
  //personas (float)
  //pos (int)
  //precio (float)

  //aqui de una vez recupero nombre de unidad, nombre de clietne, y grupo
  
  // //getGrupo, rslt = abbr de result
  // $rslt = $db->query("SELECT descripcion FROM grupo WHERE idGrupo = '{$row->grupo}' LIMIT 1");
  // $row->grupoName = $db->affected_rows > 0 ? $rslt->fetch_object()->descripcion : '';

  // //get name client and unit
  // $rslt = $db->query("SELECT cli.nombre, un.unidad FROM unidad AS un JOIN cliente AS cli ON un.cliente=cli.idCliente WHERE un.idUnidad = '{$row->unidad}' LIMIT 1");
  // $row->unidadName =  $row->clienteName = '';
  // if( $db->affected_rows > 0 ){
  //   $rslt = $rslt->fetch_object();
  //   $row->unidadName = $rslt->unidad;
  //   $row->clienteName = $rslt->nombre;
  // }

  $rows[$row->unidad][$row->grupo][$row->fecha][$row->receta][] = $row;

  //esto me creara un array de la forma
  //aqui key seria el idUNidad, tal ves me sirva
  // $rows = [
  //   'unidad1'=> [
  //     'grupo1'=> [
  //       '2015-01-01'=>[
  //         '0001' => [
  //           {}, {}, {}//recetas, fecha no importa
  //         ]
  //       ]
  //     ],
  //     'grupo2' => [
  //       '2015-01-02'=>[
  //         '0002'=>[
  //           {},{}
  //         ]
  //       ]
  //     ],
  //   ],

  //   'unidad2'=> [
  //     'grupo1'=> [
  //       '2015-01-01'=>[
  //         '0078' => [
  //           {}, {}, {}//recetas, fecha no importa
  //         ]
  //       ]
  //     ],
  //     'grupo3' => [
  //       '2015-01-04'=>[
  //         '0002'=>[
  //           {},{}
  //         ]
  //       ]
  //     ],
  //   ],
  // ];



}

//en el proceso en cada hoja pone una receta diferente, y su condicional para hacer una nueva hoja de excel es
// si la fecha es diferente nueva hoja
//si el cliente es diferente, nueva hoja
//si la unidad es difetente nueva hoja
//si la receta es diferente nueva hoja
//si el grupo es diferente nueva hoja


// entonces para hacer un  proceso mas atractivo y flexible para los usuarios del excel

//voy a agrupar por hoja una unidad, el cliente de descargtar
// por que una unidad pertecne a un cliente osea que cada que cambie una unidad, el cliente puede cambiar , pero si el cliente cambia la unidad definitivamente cambia
//asi que podemos omitir la agrupacion de clientes.

//primero debo agrupar por unidad

function headerExcel( $unidad, $cliente, &$indexRow ){
  global $sheet;

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

  //titulo
  $sheet->mergeCells("B{$indexRow}:F{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "GUISOPAK");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  $indexRow++;
  $sheet->mergeCells("B{$indexRow}:F{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "Hoja de Producción");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  //cliente
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Cliente:");//semana
  $sheet->setCellValue("B{$indexRow}", $cliente);//semana

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Unidad:");
  $sheet->setCellValue("B{$indexRow}", $unidad);

  $indexRow += 2;
}

function headerGrupo($grupo, &$indexRow){
  global $sheet;

  $sheet->mergeCells("A{$indexRow}:F{$indexRow}");
  $sheet->setCellValue("A{$indexRow}", $grupo);
  $sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("A{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('5DADE2');

  $indexRow++;
}

function headerFecha($fecha, &$indexRow){
  global $sheet;

  $sheet->mergeCells("A{$indexRow}:F{$indexRow}");
  $sheet->setCellValue("A{$indexRow}", $fecha);
  $sheet->getStyle("A{$indexRow}")->getFont()->setSize(12);
  // $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("A{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6DBDF');

  $indexRow++;
}

function headerReceta($receta, $porciones, &$indexRow){
  global $sheet;

  $sheet->mergeCells("A{$indexRow}:F{$indexRow}");
  $sheet->setCellValue("A{$indexRow}", $receta);
  $sheet->getStyle("A{$indexRow}")->getFont()->setSize(12);
  // $sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("A{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  $indexRow++;

  $sheet->setCellValue("A{$indexRow}", "Número de Comensales:");
  $sheet->setCellValue("B{$indexRow}", $porciones);

  $indexRow++;

  $titulos = ['A'=> 'ID Artìculo', 'B'=> 'Artículo', 'C'=> 'Unidad', 'D'=> 'Cantidad', 'E'=> 'Costo Unitario', 'F'=> 'Costo Total'];
  $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  foreach ($titulos as $key => $title){
    $sheet->getColumnDimension($key)->setWidth(16);
    $sheet->setCellValue("{$key}{$indexRow}", "$title");
  }

  $indexRow++;
}


$dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado'];
//aqui comenzamos a generar el excel


//instanciamos el objeto 
$spreadsheet = new Spreadsheet();
$hoja = 0;

foreach ($rows as $key => $unidad) {

  //por cada unidad creo una hoja de excel, a excepcion de la primera vez, ya que cera por defecto una hoja
  if( $hoja !== 0 )
    $spreadsheet->createSheet();//crea una nueva hoja de calculo

  //establecemos la hoja de calculo activa
  $spreadsheet->setActiveSheetIndex( $hoja );
  $sheet = $spreadsheet->getActiveSheet();//recuperamos esa hoja activa
  $hoja++;

  $indexRow = 1;

  //get name client and unit
  $unidadName =  $clienteName = '';
  $rslt = $db->query("SELECT cli.nombre, un.unidad FROM unidad AS un JOIN cliente AS cli ON un.cliente=cli.idCliente WHERE un.idUnidad = '{$key}' LIMIT 1");
  if( $db->affected_rows > 0 ){
    $rslt = $rslt->fetch_object();
    $unidadName = $rslt->unidad;
    $clienteName = $rslt->nombre;
  }
  headerExcel( $unidadName, $clienteName, $indexRow );
  
  foreach ($unidad as $key=> $grupo) {
    //por cada grupo creo un header en el hoja del grupo alimenticio
    //getGrupo, rslt = abbr de result
    $rslt = $db->query("SELECT descripcion FROM grupo WHERE idGrupo = '{$key}' LIMIT 1");
    $grupoName = $db->affected_rows > 0 ? $rslt->fetch_object()->descripcion : '';

    headerGrupo( $grupoName, $indexRow );
    
    foreach ($grupo as $key=>$fecha) {

      //por fecha agrego las recetas
      // agrego un header de la fecha
      $dt = new DateTime($key);
      headerFecha( $dias[(int) $dt->format('w')] . ' '. $dt->format('d-m-Y'), $indexRow );
  
      foreach ($fecha as $recetas) {
        //aqui puede haber varias recetas
        //entonces aqui tengo que sumar las personas de esas recetas
        $porciones = 0;
        foreach ($recetas as $receta)
          $porciones += $receta->personas;//sumatoria de las porciones de esa receta en esa fecha
        //end foreach

        //ahora aqui debo consultar los aspectos basicos del articulo dado por la receta
        $sql = "SELECT art.idArticulo, art.nombre, art.unidad, reart.cantidad, art.costo, re.porciones FROM receta AS re JOIN recetaart AS reart ON re.idReceta=reart.receta JOIN articulo AS art ON art.idArticulo=reart.articulo WHERE re.nombre = '{$recetas[0]->receta}'";
        $rslt = $db->query($sql);
        // echo $sql. ' - cantidad:' . $porciones . "<br>";
        if( $db->affected_rows > 0 ){

        //   //si la receta tiene articulos que dibujar entonces dibujo su header
          headerReceta( $recetas[0]->receta, $porciones, $indexRow );

          while($articulo = $rslt->fetch_object() ){

            $cantidad = ( $articulo->cantidad / $articulo->porciones) * $porciones;

            $sheet->setCellValue("A{$indexRow}", $articulo->idArticulo);
            $sheet->setCellValue("B{$indexRow}", $articulo->nombre);
            $sheet->setCellValue("C{$indexRow}", $articulo->unidad);
            $sheet->setCellValue("D{$indexRow}", $cantidad);
            $sheet->setCellValue("E{$indexRow}", $articulo->costo);
            $sheet->setCellValue("F{$indexRow}", "=D{$indexRow}*E{$indexRow}" );
            // $sheet->getCell("F{$indexRow}")->getCalculatedValue();//ejecuta la formula

            $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getAlignment()->setWrapText(true);

            $indexRow++;

          }

        }

      }
  
    }
  
  }

}


header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=minuta.xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');