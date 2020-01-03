<?php

set_time_limit(500);

require_once 'excel/Classes/PHPExcel.php';
$objPHPExcel = new PHPExcel();

include '../../db/conexion.php';

$id=$_GET['ident'];

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

$objPHPExcel->
getProperties()
->setCreator("TEDnologia.com")
->setLastModifiedBy("TEDnologia.com")
->setTitle("Exportar Excel con PHP")
->setSubject("Documento de prueba")
->setDescription("Documento generado con PHPExcel")
->setKeywords("usuarios phpexcel")
->setCategory("reportes");

$objPHPExcel->setActiveSheetIndex(0)

->setCellValue('B2','Presupuesto de Compras')
->setCellValue('B3','OC:')
->setCellValue('B4','Fecha')
->setCellValue('B5','Semana')
->setCellValue('C3',$id)
->setCellValue('C4',$fecha)
->setCellValue('C5',$semana)
->setCellValue('F1','Proceso:Compras')
->setCellValue('F2','Formato CO-3.1')
->setCellValue('F3','CLIENTE')
->setCellValue('G3',$nombre)
->setCellValue('F4','Unidad(es)')
->setCellValue('G4',$unidadnom1.','.$unidadnom2)
->setCellValue('G5',$unidadnom3.','.$unidadnom4)
->setCellValue('G6',$unidadnom5)

->setCellValue('D10',$unidadnom1)
->setCellValue('E10',$unidadnom2)
->setCellValue('F10',$unidadnom3)
->setCellValue('G10',$unidadnom4)
->setCellValue('H10',$unidadnom5)

->setCellValue('B10','Proveedor');

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

$objPHPExcel->getActiveSheet()->setTitle('Usuarios');
$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
$objWriter->save('php://output');

exit;

?>