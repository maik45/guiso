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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

//recupera las fechas que se desean consultar
$start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING) or die(toJson(0, 'La fecha inicial es inválida'));
$end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING) or die(toJson(0, 'La fecha final es inválida'));

// $uidUser = $_SESSION['uid_comedor'];

$dt = new DateTime($start);
$sem1 = $dt->format('W');
$dt = new DateTime($end);
$sem2 = $dt->format('W');
$semana = $sem1 === $sem2 ? $sem1 : "$sem1 - $sem2";


//dice que trae toda la informacion de menu que corresponda al rango de fecha
$sql = "SELECT me.idMenu, me.cliente, me.unidad, (SELECT unidad FROM unidad WHERE idUnidad = me.unidad) AS unidadName, mr.receta, mr.fecha, mr.personas, mr.precio FROM menu as me inner join menurec as mr on me.idMenu = mr.idMenu WHERE ( date(mr.fecha) between '{$start}' AND '{$end}' ) AND me.activo = 1";
$r = $db->query($sql);

$db->affected_rows > 0 or die('No hay información en ese rango de fechas para generar la orden');

$articulosVendidos = [];
while( $menu = $r->fetch_object() ){

  // menu.idMenu (id)
  // menu.cliente (id)
  // menu.unidad (id)
  // menu.unidadName 
  // menu.receta (nombre)
  // menu.fecha
  // menu.personas
  // menu.precio

  $sql = "SELECT re.idReceta, re.porciones, reart.cantidad, art.idArticulo, art.nombre, art.linea, art.unidad as artUnidad, art.unidadA, art.costo FROM receta AS re JOIN recetaart AS reart ON reart.receta=re.idReceta JOIN articulo AS art ON art.idArticulo=reart.articulo WHERE re.nombre = '{$menu->receta}'";
  $itemsReceta = $db->query($sql);
  
  if( $db->affected_rows <= 0 )
    continue;//si la query no trajo nada, saltamos al siguiente elemento de menu

  //aqui tenemos los articulo de la receta que se le asigno al menu
  while( $articulo = $itemsReceta->fetch_object() ){

    // articulo.idReceta (id)
    // articulo.porciones
    // articulo.cantidad
    // articulo.idArticulo
    // articulo.nombre
    // articulo.linea (id)
    // articulo.artUnidad 
    // articulo.unidadA
    // articulo.costo

    // $cantidad = $articulo->cantidad;//sale de recetaart
    $cantidad = ( $articulo->cantidad / $articulo->porciones ) * $menu->personas;

    // $costoU = $articulo->costo;
    $costoT = $articulo->costo * $cantidad;

    //despues qui hace otro query para recuperar el proveedor del articulo
    $sql = "SELECT proveedor FROM precioprov WHERE articulo = '{$articulo->idArticulo}' AND precio = '{$articulo->costo}' LIMIT 1";
    $proveedorResult = $db->query($sql);
    if( $db->affected_rows <= 0 )
      continue;

    $proveedorId = $proveedorResult->fetch_object()->proveedor;

    $articulo->unidad = $menu->unidad;
    $articulo->unidadName = $menu->unidadName;
    $articulo->proveedorId = $proveedorId;
    $articulo->costoT = $costoT;
    $articulo->cantidadCalc = $cantidad;
    $articulo->personas = $menu->personas;
    $articulo->cliente = $menu->cliente;



    //hasta aqui articulo tendria
    // articulo.idReceta (id)
    // articulo.porciones
    // articulo.cantidad
    // articulo.idArticulo
    // articulo.nombre
    // articulo.linea (id)
    // articulo.artUnidad 
    // articulo.unidadA
    // articulo.costo
    
    // articulo.unidad
    // articulo.unidadName
    // articulo.proveedorId
    // articulo.costoT
    // articulo.cantidadCalc
    // articulo.personas
    // articulo.cliente

    // si el proveedor existe en el array
    // if( array_key_exists($articulo->unidad, $articulosVendidos) ){
    //   if( array_key_exists($proveedorId, $articulosVendidos[$articulo->unidad]) ){
    //     if( array_key_exists($articulo->linea, $articulosVendidos[$articulo->unidad][$proveedorId] ) ){
    //       if( array_key_exists($articulo->idArticulo, $articulosVendidos[$articulo->unidad][$proveedorId][$articulo->linea] ) ) {
    //           $articulosVendidos[$articulo->unidad][$proveedorId][$articulo->linea][$articulo->idArticulo]->cantidadCalc += $articulo->cantidadCalc;
    //       }
    //       else{
    //         $articulosVendidos[$articulo->unidad][$proveedorId][$articulo->linea][$articulo->idArticulo] = $articulo;
    //       }
    //     }
    //     else{
    //       $articulosVendidos[$articulo->unidad][$proveedorId][$articulo->linea][$articulo->idArticulo] = $articulo;
    //     }
    //   }
    //   else{
    //     $articulosVendidos[$articulo->unidad][$proveedorId][$articulo->linea][$articulo->idArticulo] = $articulo;
    //   }
    // }
    // else{
    //   $articulosVendidos[$articulo->unidad][$proveedorId][$articulo->linea][$articulo->idArticulo] = $articulo;
    // }

    //agrupamos articulos por unidades

    if( array_key_exists($articulo->unidad, $articulosVendidos) ){
      if(array_key_exists($articulo->idArticulo, $articulosVendidos[$articulo->unidad])){
        $articulosVendidos[$articulo->unidad][$articulo->idArticulo]->cantidadCalc += $articulo->cantidadCalc;
      }
      else{
        $articulosVendidos[$articulo->unidad][$articulo->idArticulo] = $articulo;
      }
    }
    else{
      $articulosVendidos[$articulo->unidad][$articulo->idArticulo] = $articulo;
    }


  }//endWhileReceta

}//endWhileCliente

function headerExcel( &$indexRow ){
  global $sheet, $semana, $start, $end;

  // $data = proveedorId, proveedorName, (array) unidades, clienteName, clienteId

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

  
  // //titulo
  $sheet->mergeCells("B{$indexRow}:C{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "GUISOPAK");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  $indexRow++;
 
  $sheet->mergeCells("B{$indexRow}:C{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "Reporte de Necesidades de Compra por Unidad");
  $sheet->getStyle("B{$indexRow}")->getFont()->setSize(12);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  $indexRow++;

  $sheet->setCellValue("A{$indexRow}", "Semana:");//semana
  $sheet->setCellValue("B{$indexRow}", $semana);//semana

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Fecha:");//semana
  $sheet->setCellValue("B{$indexRow}", "$start - $end");//semana

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Unidades:");
  $sheet->setCellValue("B{$indexRow}", 'Todas');

  $indexRow++;
  $endRowObserv = $indexRow + 1;
  $sheet->mergeCells("A{$indexRow}:C{$endRowObserv}");
  $sheet->setCellValue("A{$indexRow}", 'Este reporte se genera a partir de las OC con base en las necesidades de compra sin considerar las presentaciones de los artículos');
  $sheet->getStyle("A{$indexRow}")->getAlignment()->setWrapText(true);

  $indexRow += 3;
  $sheet->getStyle("A{$indexRow}:C{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:C{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  $titles = ['A'=> 'Unidades', 'B'=> 'Costo', 'C'=> 'Observaciones'];
  foreach ($titles as $key => $title){
    // $sheet->getColumnDimension($key)->setWidth(22);
    $sheet->setCellValue("{$key}{$indexRow}", "$title");
  }
  
  $sheet->getColumnDimension('A')->setWidth(35);
  $sheet->getColumnDimension('B')->setWidth(18);
  $sheet->getColumnDimension('C')->setWidth(35);

  // $sheet->getStyle("A{$indexRow}:C{$indexRow}")->getAlignment()->setWrapText(true);

  $indexRow ++;
}

//articulosVendidos ya esta agrupados por proveedores
//cada proveedor es una hoja de excel

// instanciamos el objeto 
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();//recuperamos esa hoja activa

$indexRow = 1;

headerExcel($indexRow);

// echo "<pre>";  
foreach ($articulosVendidos as $unidad) {

  // var_dump($unidad);
  // echo "<hr>";  
  //por unidad hago la sumatoria
  $total = 0;
  $unidadName = $descripcion = '';
  foreach ($unidad as $art) {
    
    // var_dump($art);
    // echo "<hr>";

    $sql = "SELECT cantidad FROM excedente WHERE articulo = '{$art->idArticulo}' AND unidad = '{$art->unidad}' LIMIT 1";
    $exd = $db->query($sql);
    $exd = $db->affected_rows > 0 ? $exd->fetch_object()->cantidad : 0;

    $cantidad = $art->cantidadCalc - $exd;
    $costoT = $art->costo * $cantidad;

    if( $costoT < 0 ){
      $costoT = 0;
      $descripcion = 'Existen artículos con precios cero';
    }

    $total += $costoT;

    if( empty($unidadName) )
      $unidadName = $art->unidadName;

  }


  $sheet->setCellValue("A{$indexRow}", $unidadName);//semana
  $sheet->setCellValue("B{$indexRow}", number_format( $total, 2, '.', '' ) );//semana
  $sheet->setCellValue("C{$indexRow}", $descripcion);//semana
  $indexRow++;


}

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=Reporte de Compras $start - $end.xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

