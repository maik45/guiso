<?php

set_time_limit(500);

include ("excel/Classes/PHPExcel.php");
$objPHPExcel = new PHPExcel();

include '../../db/conexion.php';

$id=$_GET['id'];

$consulta = "SELECT fechaI,fechaF,cliente FROM oc WHERE idOC = '$id' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$fecha=str_replace(" 00:00:00","",$columna['fechaI']).' - '.str_replace(" 00:00:00","",$columna['fechaF']);
$cliente =$columna['cliente'];
$date1 = $columna['fechaI'];
$date1 = new DateTime($date1);
$week1 = $date1->format("W");
$date2 = $columna['fechaF'];
$date2 = new DateTime($date2);
$week2 = $date2->format("W");
if($week1==$week2){
$semana=$week1;
}else{
$semana=$week1.' - '.$week2;
}
}

$consulta = "SELECT DISTINCT nombre FROM cliente WHERE idCliente = '$cliente' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$nombre = $columna['nombre'];
}

$cont=0;
$consulta = "SELECT DISTINCT idUnidad FROM unidad WHERE cliente = '$cliente' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$idunidad[$cont] = $columna['idUnidad'];
$cont++;
}

$idunidad1=$idunidad[0];
$idunidad2=$idunidad[1];
$idunidad3=$idunidad[2];
$idunidad4=$idunidad[3];
$idunidad5=$idunidad[4];

$idunidad1=strval($idunidad1);
$idunidad2=strval($idunidad2);
$idunidad3=strval($idunidad3);
$idunidad4=strval($idunidad4);
$idunidad5=strval($idunidad5);

$consulta1 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad1' ";
$resultado = mysqli_query($conexion,$consulta1);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom1 = $columna['unidad'];
}
$consulta2 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad2' ";
$resultado = mysqli_query($conexion,$consulta2);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom2 = $columna['unidad'];
}
$consulta3 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad3' ";
$resultado = mysqli_query($conexion,$consulta3);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom3 = $columna['unidad'];
}
$consulta4 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad4' ";
$resultado = mysqli_query($conexion,$consulta4);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom4 = $columna['unidad'];
}
$consulta5 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad5' ";
$resultado = mysqli_query($conexion,$consulta5);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom5 = $columna['unidad'];
}

$objPHPExcel->getProperties()
->setCreator("videotutoriales.es")
->setLastModifiedBy("videotutoriales.es")
->setTitle("Documento Excel")
->setSubject("Documento Excel")
->setDescription("crear archivos de Excel desde PHP.")
->setKeywords("Excel Office 2007 php")
->setCategory("Pruebas de Excel");

$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('test_img');
$objDrawing->setDescription('test_img');
$objDrawing->setPath('imagen/logo.jpg');
$objDrawing->setCoordinates('A2');                      
//setOffsetX works properly
$objDrawing->setOffsetX(0); 
$objDrawing->setOffsetY(0);                
//set width, height
$objDrawing->setWidth(220); 
$objDrawing->setHeight(70); 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()
    ->getStyle('A1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('B1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('C1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('D1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('E1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('F1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('G1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('H1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('I1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('J1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');
$objPHPExcel->getActiveSheet()
    ->getStyle('K1')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('EA7343');

$objPHPExcel->getActiveSheet()
    ->getStyle('A10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('B10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('C10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('D10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('E10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('F10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('G10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('H10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('I10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('J10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');
$objPHPExcel->getActiveSheet()
    ->getStyle('K10')
    ->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()
    ->setRGB('7EDE9D');

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('C4','Presupuesto de Compras contra facturas')
->setCellValue('C5','OC:')
->setCellValue('C6','Fecha')
->setCellValue('C7','Semana')
->setCellValue('D5',$id)
->setCellValue('D6',$fecha)
->setCellValue('D7',$semana)
->setCellValue('G3','Proceso:Compras')
->setCellValue('G4','Formato CO-3.1')
->setCellValue('G5','CLIENTE')
->setCellValue('H5',$nombre)
->setCellValue('G6','Unidad(es)')
->setCellValue('H6',$unidadnom1.','.$unidadnom2)
->setCellValue('H7',$unidadnom3.','.$unidadnom4)
->setCellValue('H8',$unidadnom5)
->setCellValue('E12',$unidadnom1)
->setCellValue('D13',$unidadnom2)
->setCellValue('G12',$unidadnom3)
->setCellValue('F1','GuisoPak')
->setCellValue('B11','Proveedor')
;

$objPHPExcel->getActiveSheet()->getStyle("F1")->getFont()->setBold(true);

$hoja1=$objPHPExcel->getActiveSheet();

$proveedorAnt = "";
$pagoAnt = "";
$unidadAnt = "";
$idarticuloAnt = "";

$unidad1Tot = 0;
$unidad2Tot = 0;
$unidad3Tot = 0;
$unidad4Tot = 0;
$unidad5Tot = 0;

$unidad1SubTot = 0;
$unidad2SubTot = 0;
$unidad3SubTot = 0;
$unidad4SubTot = 0;
$unidad5SubTot = 0;
$costoSubTot = 0;

$ren=11;
$ren2=11;

$consulta ="SELECT boc.OC, boc.cliente, boc.unidad, boc.articulo, boc.linea, boc.cantidad, boc.proveedor, boc.presentacion, boc.factor, boc.costoU, boc.costoT, prov.pago FROM bomoc AS boc INNER JOIN proveedor AS prov ON boc.proveedor=prov.idProveedor WHERE boc.OC = '$id' ORDER BY prov.pago, boc.proveedor, boc.linea, boc.articulo, boc.unidad";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){

$existeArt = "SI";
$idproveedor=$columna['proveedor'];
$pago=$columna['pago'];
$idarticulo=$columna['articulo'];
$unidad=$columna['unidad'];
$linea=$columna['linea'];
$costou=$columna['costoU'];
$cliente=$columna['cliente'];
$presentacion=$columna['presentacion'];
$cantidad=$columna['cantidad'];

if($ren2>31){
$ren2=11;
}

if($ren<31){
$hoja1
->setCellValue('D'.$ren2,$unidad1Tot);
}
if(($ren>31)&&($ren<62)){
$hoja1
->setCellValue('E'.$ren2,$unidad1Tot);
}
if(($ren>62)&&($ren<93)){
$hoja1
->setCellValue('F'.$ren2,$unidad1Tot);
}
if(($ren>93)&&($ren<124)){
$hoja1
->setCellValue('G'.$ren2,$unidad1Tot);
}
if(($ren>124)&&($ren<155)){
$hoja1
->setCellValue('H'.$ren2,$unidad1Tot);
}

$consultacant ="SELECT SUM(cantidad) as cantot FROM bomOC WHERE OC = '$id' AND articulo = '$idarticulo' AND proveedor = '$idproveedor' 
AND linea = '$linea' AND unidad = '$unidad'";
$resultadocant = mysqli_query($conexion,$consultacant);
while($columnacant=mysqli_fetch_array($resultadocant)){
$cantot=$columnacant['cantot'];
}

$exedente=0;
$cantidad=$cantot-$exedente;
$costot = $costou*$cantidad;

if($costot<0){
$costot=0;
}

if($unidad==$idunidad1){
$unidad1Tot=$unidad1Tot+$costot;
}

$ren++;
$ren2++;

}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="comprasfac.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>