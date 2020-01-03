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

$unidad = filter_input(INPUT_POST, 'unidadCliente', FILTER_SANITIZE_STRING);
$cliente = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT);


$sql = "SELECT unidad.unidad, cliente.nombre FROM unidad JOIN cliente ON cliente.idCliente=unidad.cliente WHERE unidad.idUnidad = '{$unidad}' LIMIT 1";
$r = $db->query($sql);

// var_dump( $db->affected_rows );

$db->affected_rows > 0 or die('El cliente es invalido');
$itemUniCli = $r->fetch_object();

//instanciamos el objeto 
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

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
$sheet->mergeCells("B{$indexRow}:F{$indexRow}");
$sheet->setCellValue("B{$indexRow}", "GUISOPAK");
$sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
$sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

$indexRow++;
//receta nombre
$sheet->mergeCells("B{$indexRow}:F{$indexRow}");
$sheet->setCellValue("B{$indexRow}", "Reporte de Excedentes/Pedido");
$sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
$sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
$sheet->getStyle("B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

$indexRow++;
$sheet->setCellValue("A{$indexRow}", "Cliente:" );
$sheet->setCellValue("B{$indexRow}", $itemUniCli->nombre ."/". $cliente );

$indexRow++;
$sheet->setCellValue("A{$indexRow}", "Unidad:" );
$sheet->setCellValue("B{$indexRow}", $itemUniCli->unidad ."/" . $unidad );

$indexRow += 2;
$titulos = ['A'=> 'Línea', 'B'=> 'ID Artículo', 'C'=> 'Descripción', 'D'=> 'Presentación', 'E'=> 'Unidad', 'F'=> 'Cantidad'];
$sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFont()->setBold(true);
$sheet->getStyle("A{$indexRow}:F{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

foreach ($titulos as $key => $title){
  // $sheet->getColumnDimension($key)->setAutoSize(true);
  $sheet->getColumnDimension($key)->setWidth(18);
  $sheet->setCellValue("{$key}{$indexRow}", " $title");
}

$indexRow++;

$r = $db->query("SELECT idArticulo, nombre, (SELECT descripcion FROM linea WHERE idLinea = linea) AS linea, unidad, unidadA FROM articulo WHERE activo = 1 ORDER BY linea, nombre");

$db->affected_rows > 0 or die('No hay articulos que imprimir');

$headIndex = $indexRow - 1;
while( $row = $r->fetch_object() ){

  $sheet->setCellValue("A{$indexRow}", $row->linea);
  $sheet->setCellValue("B{$indexRow}", $row->idArticulo);
  $sheet->setCellValue("C{$indexRow}", $row->nombre);
  $sheet->setCellValue("D{$indexRow}", $row->unidadA);
  $sheet->setCellValue("E{$indexRow}", $row->unidad);
  $sheet->setCellValue("F{$indexRow}", 0 );

  $sheet->getStyle("A{$indexRow}:F{$indexRow}")->getAlignment()->setWrapText(true);

  $indexRow++;
}

$indexRow--;
$sheet->setAutoFilter("A{$headIndex}:F{$indexRow}");

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=archivoExcedente.xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');