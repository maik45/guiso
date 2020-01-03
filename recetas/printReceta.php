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

$idReceta = $_REQUEST['idReceta'];

$r = $db->query("SELECT *, 
  (SELECT descripcion FROM base WHERE idBase = base) AS asBase, 
  (SELECT descripcion FROM tiempo WHERE idTiempo = tiempo) AS asTiempo, 
  (SELECT descripcion FROM grupo WHERE idGrupo = grupo) AS asGrupo
  FROM receta WHERE 1 AND idReceta = '{$idReceta}' AND activo = 1 LIMIT 1");

empty( $db->error ) or die( 'Error obteniendo receta' );
$receta = $r->fetch_object();

$r = $db->query("SELECT * FROM recetaart AS reat LEFT JOIN articulo AS ar ON ar.idArticulo=reat.articulo WHERE reat.receta = '{$idReceta}'");
empty( $db->error ) or die( 'Error obteniendo articulos' );
$articulos = [];
while( $articulos[] = $r->fetch_object() );
array_pop($articulos);

//ya tengo articulos y tengo receta

//instanciamos el objeto 
$spreadsheet = new Spreadsheet();
//obtejemos la hoja de calculo activa
$sheet = $spreadsheet->getActiveSheet();

$indexRow = 1;
//titulo
$sheet->mergeCells("A{$indexRow}:F{$indexRow}");
$sheet->setCellValue("A{$indexRow}", "GUISOPAK");
$sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
$sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

$indexRow++;
//receta nombre
$sheet->mergeCells("A{$indexRow}:F{$indexRow}");
$sheet->setCellValue("A{$indexRow}", "Receta de: " . $receta->nombre);
$sheet->getStyle("A{$indexRow}")->getFont()->setBold(true)->setSize(14);
$sheet->getStyle("A{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("A{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

//porciones
$indexRow++;
$sheet->setCellValue("A{$indexRow}", "Porciones:");//porcion
$sheet->setCellValue("B{$indexRow}", $receta->porciones);//porcion

// $indexRow++;
$sheet->setCellValue("C{$indexRow}", "Costo/Unidad:");//porcion
$sheet->setCellValue("D{$indexRow}", $receta->costo);//porcion

$sheet->setCellValue("E{$indexRow}", "Costo Total:");//porcion
$sheet->setCellValue("F{$indexRow}", number_format( $receta->costo * $receta->porciones, 2, '.', '' ) );//porcion

$indexRow++;
$sheet->setCellValue("A{$indexRow}", "Tiempo:" );
$sheet->setCellValue("B{$indexRow}", $receta->asTiempo );

// $indexRow++;
$sheet->setCellValue("C{$indexRow}", "Grupo:" );
$sheet->setCellValue("D{$indexRow}", $receta->asGrupo );

// $indexRow++;
$sheet->setCellValue("E{$indexRow}", "Base:" );
$sheet->setCellValue("F{$indexRow}", $receta->asBase );

$indexRow += 2;
$indexHeader = $indexRow;

$titulos = ['A'=> 'ID Artículo', 'B'=> 'Artículo', 'C'=> 'Unidad', 'D'=> 'Cantidad', 'E'=> 'Costo Unitario', 'F'=> 'Costo Total'];
$sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFont()->setBold(true);
$sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

foreach ($titulos as $key => $title){
  $sheet->getColumnDimension($key)->setAutoSize(true);
  $sheet->setCellValue("{$key}{$indexRow}", " $title");
}


$costoTotal = 0;
$indexRow++;
foreach ($articulos as $row){

  $costoArticulo = number_format( ( $row->costo * $row->cantidad ), 2, '.', '' );
  $costoTotal += (float) $costoArticulo;

  $sheet->setCellValue("A{$indexRow}", $row->idArticulo);
  $sheet->setCellValue("B{$indexRow}", $row->nombre);
  $sheet->setCellValue("C{$indexRow}", $row->unidad);
  $sheet->setCellValue("D{$indexRow}", $row->cantidad);
  $sheet->setCellValue("E{$indexRow}", $row->costo);
  // $sheet->setCellValue("E{$indexRow}", $row->costo);
  // $sheet->setCellValue("F{$indexRow}", $costoArticulo );
  $sheet->setCellValue("F{$indexRow}", "=D{$indexRow}*E{$indexRow}");
  $sheet->getCell("F{$indexRow}")->getCalculatedValue();//ejecuta la formula

  $indexRow++;

}

$endRowForeach = ($indexRow - 1);//la ultima fila donde se dibujaron textos

$sheet->setCellValue("E{$indexRow}", "Total" );
// $sheet->setCellValue("F{$indexRow}", number_format( $costoTotal, 2, '.', '' ) );
$cell = "F".( $indexHeader + 1 ).":F".($endRowForeach);
$sheet->setCellValue("F{$indexRow}", "=SUM({$cell})" );
$sheet->getCell("F{$indexRow}")->getCalculatedValue();//ejecuta la formula

// //set autoFilter de un rango
$sheet->setAutoFilter("A{$indexHeader}:F{$endRowForeach}");


// ////////////////////////
// //agregamos´prestamos //
// ////////////////////////
// $prestamos = $db->exec("SELECT * FROM contabilidad.prestamos WHERE 1 AND codigo_dis = '{$dis}' AND status = '1'", $meta);

// $cellIndex += 2;

// $sheet->mergeCells("A{$cellIndex}:G{$cellIndex}");
// $sheet->setCellValue("A{$cellIndex}", "Préstamos Activos Solicitados");
// $sheet->getStyle("A{$cellIndex}")->getFont()->setBold(true)->setSize(14);
// $sheet->getStyle("A{$cellIndex}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// $cellIndex++;
// $titulos = ['A'=> 'Folio Préstamo', 'B'=> 'Fecha del Préstamo', 'C'=> 'Tipo', 'D'=> 'Debe', 'E'=> 'Inicio Pago', 'F'=> 'Fin del Pago', 'G'=> 'Condiciones del Pago' ];
// $sheet->getStyle("A{$cellIndex}:I{$cellIndex}")->getFont()->setBold(true);
// foreach ($titulos as $key => $title){
//   $sheet->getColumnDimension($key)->setAutoSize(true);
//   $sheet->setCellValue("{$key}{$cellIndex}", $title);
// }

// $cellIndex++;

// if( $prestamos ){

//   foreach ($prestamos as $row){
//     if( $row->tipo === '1' )
//     $tipo = 'Porcentaje';
//     else if( $row->tipo === '2' )
//     $tipo = 'Fijo';
//     else if( $row->tipo === '3' )
//     $tipo = 'Porcentaje Inversión';
//     else if( $row->tipo === '4' )
//     $tipo = 'Fijo Inversión';

//     $sheet->setCellValue("A{$cellIndex}", $row->folio);
//     $sheet->setCellValue("B{$cellIndex}", $row->fecha_captura);
//     $sheet->setCellValue("C{$cellIndex}", $tipo);
//     $sheet->setCellValue("D{$cellIndex}", $row->monto);
//     $sheet->setCellValue("E{$cellIndex}", $row->fecha_inicial);
//     $sheet->setCellValue("F{$cellIndex}", $row->fecha_final);
//     $sheet->setCellValue("G{$cellIndex}", $row->descripcion);

//     $cellIndex++;
//   }
// }
// else{

//   $sheet->mergeCells("A{$cellIndex}:G{$cellIndex}");
//   $sheet->setCellValue("A{$cellIndex}", "Sin Prestamos Solicitados");
//   $sheet->getStyle("A{$cellIndex}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// }

// ////////////////////////////////////////
// // añadir los abonos de los prestamos //
// ////////////////////////////////////////

// //abonos que esten en la  tabla de descuentos y no en inversiones
// $descuentosNormales = $db->exec("SELECT cp.folio AS cuenta_destino, cd.fecha_descuento AS fecha_inversion, 'abono por prestamo' AS banco, cd.monto, cp.descripcion FROM contabilidad.prestamos AS cp JOIN contabilidad.descuentos AS cd ON cd.folio_prestamo = cp.folio WHERE 1 AND cp.codigo_dis = '{$dis}' AND cp.tipo  IN (1,2,5) AND cd.fecha_descuento < curdate()", $meta);

// $cellIndex += 2;

// $sheet->mergeCells("A{$cellIndex}:E{$cellIndex}");
// $sheet->setCellValue("A{$cellIndex}", "Abonos de Préstamos Activos");
// $sheet->getStyle("A{$cellIndex}")->getFont()->setBold(true)->setSize(14);
// $sheet->getStyle("A{$cellIndex}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// $cellIndex++;
// $titulos = ['A'=> 'Folio Préstamo', 'B'=> 'Fecha Abono', 'C'=> 'Tipo', 'D'=> 'Monto', 'E'=> 'Descripción' ];
// $sheet->getStyle("A{$cellIndex}:E{$cellIndex}")->getFont()->setBold(true);
// foreach ($titulos as $key => $title){
//   $sheet->getColumnDimension($key)->setAutoSize(true);
//   $sheet->setCellValue("{$key}{$cellIndex}", $title);
// }


// $cellIndex++;
// $tabla_abonos = array_merge($tabla_abonos, $descuentosNormales);
// if( $tabla_abonos ){//un array no vacio es true
  
//   foreach ($tabla_abonos as $row){

//     $sheet->setCellValue("A{$cellIndex}", $row->cuenta_destino);
//     $sheet->setCellValue("B{$cellIndex}", $row->fecha_inversion);
//     $sheet->setCellValue("C{$cellIndex}", $row->banco);
//     $sheet->setCellValue("D{$cellIndex}", $row->monto);
//     $sheet->setCellValue("E{$cellIndex}", $row->descripcion);

//     $cellIndex++;
//   }

// }
// else{

//   $sheet->mergeCells("A{$cellIndex}:E{$cellIndex}");
//   $sheet->setCellValue("A{$cellIndex}", "Sin abonos por concepto de préstamos");
//   $sheet->getStyle("A{$cellIndex}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

// }


// //////////////////////////////////
// // totales del estado de cuenta //
// //////////////////////////////////

// $sheet->setCellValue('A2', 'Total');
// $sheet->setCellValue('A3', 'Inversión');
// $sheet->setCellValue('A4', 'Descuento');
// $sheet->setCellValue('A5', 'Abonos de Préstamo');

// $sheet->setCellValue('B2', ( $inversion + $abonosPrestamos - $retiro ) );
// $sheet->setCellValue('B3', $inversion);
// $sheet->setCellValue('B4', $retiro);
// $sheet->setCellValue('B5', $abonosPrestamos);

// $sheet->getStyle('A2:B2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
// $sheet->getStyle('A3:B3')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
// $sheet->getStyle('A4:B4')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
// $sheet->getStyle('A5:B5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);




header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=Receta {$receta->nombre}.xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');