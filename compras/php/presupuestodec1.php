<?php

require_once 'excel/Classes/PHPExcel.php';
include '../../db/conexion.php';

$id=$_GET['id'];

$fecha="";
$semana="";
$nombre="";

$unidadnom1="";
$unidadnom2="";
$unidadnom3="";
$unidadnom4="";
$unidadnom5="";

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

if (isset($idunidad[0])){
$idunidad1=$idunidad[0];
$idunidad1=strval($idunidad1);
}
if (isset($idunidad[1])){
$idunidad2=$idunidad[1];
$idunidad2=strval($idunidad2);
}
if (isset($idunidad[2])){
$idunidad3=$idunidad[2];
$idunidad3=strval($idunidad3);
}
if (isset($idunidad[3])){
$idunidad4=$idunidad[3];
$idunidad4=strval($idunidad4);
}
if (isset($idunidad[4])){
$idunidad5=$idunidad[4];
$idunidad5=strval($idunidad5);
}

if (isset($idunidad[0])){
$consulta1 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad1' ";
$resultado = mysqli_query($conexion,$consulta1);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom1 = $columna['unidad'];
}
}
if (isset($idunidad[1])){
$consulta2 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad2' ";
$resultado = mysqli_query($conexion,$consulta2);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom2 = $columna['unidad'];
}
}
if (isset($idunidad[2])){
$consulta3 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad3' ";
$resultado = mysqli_query($conexion,$consulta3);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom3 = $columna['unidad'];
}
}
if (isset($idunidad[3])){
$consulta4 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad4' ";
$resultado = mysqli_query($conexion,$consulta4);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom4 = $columna['unidad'];
}
}
if (isset($idunidad[4])){
$consulta5 = "SELECT DISTINCT unidad FROM unidad WHERE idUnidad = '$idunidad5' ";
$resultado = mysqli_query($conexion,$consulta5);
while($columna=mysqli_fetch_array($resultado)){
$unidadnom5 = $columna['unidad'];
}
}

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()
->setCreator("Excel Office 2007")
->setLastModifiedBy("Excel Office 2007")
->setTitle("Excel Office 2007")
->setSubject("Excel Office 2007")
->setDescription("Excel Office 2007")
->setKeywords("Excel Office 2007")
->setCategory("Excel Office 2007");

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('B3','Presupuesto de Compras')
->setCellValue('B4','OC:')
->setCellValue('B5','Fecha')
->setCellValue('B6','Semana')
->setCellValue('C4',$id)
->setCellValue('C5',$fecha)
->setCellValue('C6',$semana)
->setCellValue('F2','Proceso:Compras')
->setCellValue('F3','Formato CO-3.1')
->setCellValue('F4','CLIENTE')
->setCellValue('G4',$nombre)
->setCellValue('F5','Unidad(es)')
->setCellValue('G5',$unidadnom1.','.$unidadnom2)
->setCellValue('G6',$unidadnom3.','.$unidadnom4)
->setCellValue('G7',$unidadnom5)

->setCellValue('D8',$unidadnom1)
->setCellValue('E8',$unidadnom2)
->setCellValue('F8',$unidadnom3)
->setCellValue('G8',$unidadnom4)
->setCellValue('H8',$unidadnom5)

->setCellValue('B8','Proveedor');

$objPHPExcel->getActiveSheet()
->getStyle('A1:H1')
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('FF956B');

$objPHPExcel->getActiveSheet()
->getStyle('A8:H8')
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('6DDA81');

$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

$hoja1=$objPHPExcel->getActiveSheet();

$contche=0;
$contcre=0;
$contefec=0;
$contoper=0;

if (isset($idunidad[0])){
$consulta = "SELECT proveedor,sum(costoT) as suma FROM `bomoc` WHERE unidad='$idunidad1' AND OC='$id' GROUP BY proveedor";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$proveedor=$columna['proveedor'];
$consulta1 = "SELECT nombre,pago FROM proveedor WHERE idProveedor='$proveedor' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
if($columna1['pago']=='CONTADO CON CHEQUE'){
$contche++;
$CHEQUE1[$contche]=$columna1['nombre'];
$PAGOCHEQUE1[$contche]=$columna['suma'];
}
if($columna1['pago']=='CRÉDITO'){
$contcre++;
$CREDITO1[$contcre]=$columna1['nombre'];
$PAGOCREDITO1[$contcre]=$columna['suma'];
}
if($columna1['pago']=='EFECTIVO'){
$contefec++;
$EFECTIVO1[$contefec]=$columna1['nombre'];
$PAGOEFECTIVO1[$contefec]=$columna['suma'];
}
if($columna1['pago']=='OPERACIÓN'){
$contoper++;
$OPERACION1[$contoper]=$columna1['nombre'];
$PAGOOPERACION1[$contoper]=$columna['suma'];
}
}
}
}

$contche=0;
$contcre=0;
$contefec=0;
$contoper=0;

if (isset($idunidad[1])){
$consulta = "SELECT proveedor,sum(costoT) as suma FROM `bomoc` WHERE unidad='$idunidad2' AND OC='$id' GROUP BY proveedor";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$proveedor=$columna['proveedor'];
$consulta1 = "SELECT nombre,pago FROM proveedor WHERE idProveedor='$proveedor' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
if($columna1['pago']=='CONTADO CON CHEQUE'){
$contche++;
$PAGOCHEQUE2[$contche]=$columna['suma'];
}
if($columna1['pago']=='CRÉDITO'){
$contcre++;
$PAGOCREDITO2[$contcre]=$columna['suma'];
}
if($columna1['pago']=='EFECTIVO'){
$contefec++;
$PAGOEFECTIVO2[$contefec]=$columna['suma'];
}
if($columna1['pago']=='OPERACIÓN'){
$contoper++;
$PAGOOPERACION2[$contoper]=$columna['suma'];
}
}
}
}

$contche=0;
$contcre=0;
$contefec=0;
$contoper=0;


if (isset($idunidad[2])){
$consulta = "SELECT proveedor,sum(costoT) as suma FROM `bomoc` WHERE unidad='$idunidad3' AND OC='$id' GROUP BY proveedor";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$proveedor=$columna['proveedor'];
$consulta1 = "SELECT nombre,pago FROM proveedor WHERE idProveedor='$proveedor' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
if($columna1['pago']=='CONTADO CON CHEQUE'){
$contche++;
$PAGOCHEQUE3[$contche]=$columna['suma'];
}
if($columna1['pago']=='CRÉDITO'){
$contcre++;
$PAGOCREDITO3[$contcre]=$columna['suma'];
}
if($columna1['pago']=='EFECTIVO'){
$contefec++;
$PAGOEFECTIVO3[$contefec]=$columna['suma'];
}
if($columna1['pago']=='OPERACIÓN'){
$contoper++;
$PAGOOPERACION3[$contoper]=$columna['suma'];
}
}
}
}

$contche=0;
$contcre=0;
$contefec=0;
$contoper=0;


if (isset($idunidad[3])){
$consulta = "SELECT proveedor,sum(costoT) as suma FROM `bomoc` WHERE unidad='$idunidad4' AND OC='$id' GROUP BY proveedor";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$proveedor=$columna['proveedor'];
$consulta1 = "SELECT nombre,pago FROM proveedor WHERE idProveedor='$proveedor' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
if($columna1['pago']=='CONTADO CON CHEQUE'){
$contche++;
$PAGOCHEQUE4[$contche]=$columna['suma'];
}
if($columna1['pago']=='CRÉDITO'){
$contcre++;
$PAGOCREDITO4[$contcre]=$columna['suma'];
}
if($columna1['pago']=='EFECTIVO'){
$contefec++;
$PAGOEFECTIVO4[$contefec]=$columna['suma'];
}
if($columna1['pago']=='OPERACIÓN'){
$contoper++;
$PAGOOPERACION4[$contoper]=$columna['suma'];
}
}
}
}

$contche=0;
$contcre=0;
$contefec=0;
$contoper=0;


if (isset($idunidad[4])){
$consulta = "SELECT proveedor,sum(costoT) as suma FROM `bomoc` WHERE unidad='$idunidad5' AND OC='$id' GROUP BY proveedor";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$proveedor=$columna['proveedor'];
$consulta1 = "SELECT nombre,pago FROM proveedor WHERE idProveedor='$proveedor' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
if($columna1['pago']=='CONTADO CON CHEQUE'){
$contche++;
$PAGOCHEQUE5[$contche]=$columna['suma'];
}
if($columna1['pago']=='CRÉDITO'){
$contcre++;
$PAGOCREDITO5[$contcre]=$columna['suma'];
}
if($columna1['pago']=='EFECTIVO'){
$contefec++;
$PAGOEFECTIVO5[$contefec]=$columna['suma'];
}
if($columna1['pago']=='OPERACIÓN'){
$contoper++;
$PAGOOPERACION5[$contoper]=$columna['suma'];
}
}
}
}

if (isset($idunidad[0])){
$cont=9;
if (isset($CHEQUE1)){
for ($i=1;$i<=count($CHEQUE1);$i++){
$cont++;
$hoja1->setCellValue('A'.$cont,$CHEQUE1[$i]);
if (!isset($PAGOCHEQUE1[$i])){
$hoja1->setCellValue('D'.$cont,0);
}
else{
$hoja1->setCellValue('D'.$cont,$PAGOCHEQUE1[$i]);
}
}
$cont++;
$hoja1->setCellValue('A'.$cont,'*** CONTADO CON CHEQUE ***');
}
if (isset($CREDITO1)){
for ($i=1;$i<=count($CREDITO1);$i++){
$cont++; 
$hoja1->setCellValue('A'.$cont,$CREDITO1[$i]);
if (!isset($PAGOCREDITO1[$i])){
$hoja1->setCellValue('D'.$cont,0);
}
else{
$hoja1->setCellValue('D'.$cont,$PAGOCREDITO1[$i]);
}
}
$cont++;
$hoja1->setCellValue('A'.$cont,'*** CRÉDITO ***');
}
if (isset($EFECTIVO1)){
for ($i=1;$i<=count($EFECTIVO1);$i++){
$cont++; 
$hoja1->setCellValue('A'.$cont,$EFECTIVO1[$i]);
if (!isset($PAGOEFECTIVO1[$i])){
$hoja1->setCellValue('D'.$cont,0);
}
else{
$hoja1->setCellValue('D'.$cont,$PAGOEFECTIVO1[$i]);
}
}
$cont++;
$hoja1->setCellValue('A'.$cont,'*** EFECTIVO ***');
}
if (isset($OPERACION1)){
for ($i=1;$i<=count($OPERACION1);$i++){
$cont++; 
$hoja1->setCellValue('A'.$cont,$OPERACION1[$i]);
if (!isset($PAGOOPERACION1[$i])){
$hoja1->setCellValue('D'.$cont,0);
}
else{
$hoja1->setCellValue('D'.$cont,$PAGOOPERACION1[$i]);
}
}
$cont++;
$hoja1->setCellValue('A'.$cont,'*** OPERACIÓN ***');
}
}

if (isset($idunidad[1])){
$cont=9;
if (isset($CHEQUE1)){
for ($i=1;$i<=count($CHEQUE1);$i++){
$cont++;
if (!isset($PAGOCHEQUE2[$i])){
$hoja1->setCellValue('E'.$cont,0);
}
else{
$hoja1->setCellValue('E'.$cont,$PAGOCHEQUE2[$i]);
}
}
$cont++;
$hoja1->setCellValue('E'.$cont,'');
}
if (isset($CREDITO1)){
for ($i=1;$i<=count($CREDITO1);$i++){
$cont++;
if (!isset($PAGOCREDITO2[$i])){
$hoja1->setCellValue('E'.$cont,0);
}
else{
$hoja1->setCellValue('E'.$cont,$PAGOCREDITO2[$i]);
}
}
$cont++;
$hoja1->setCellValue('E'.$cont,'');
}
if (isset($EFECTIVO1)){
for ($i=1;$i<=count($EFECTIVO1);$i++){
$cont++;
if (!isset($PAGOEFECTIVO2[$i])){
$hoja1->setCellValue('E'.$cont,0);
}
else{
$hoja1->setCellValue('E'.$cont,$PAGOEFECTIVO2[$i]);
}
}
$cont++;
$hoja1->setCellValue('E'.$cont,'');
}
if (isset($OPERACION1)){
for ($i=1;$i<=count($OPERACION1);$i++){
$cont++;
if (!isset($PAGOOPERACION2[$i])){
$hoja1->setCellValue('E'.$cont,0);
}
else{
$hoja1->setCellValue('E'.$cont,$PAGOOPERACION2[$i]);
}
}
$cont++;
$hoja1->setCellValue('E'.$cont,'');
}
}

if (isset($idunidad[2])){
$cont=9;
if (isset($CHEQUE1)){
for ($i=1;$i<=count($CHEQUE1);$i++){
$cont++;
if (!isset($PAGOCHEQUE3[$i])){
$hoja1->setCellValue('F'.$cont,0);
}
else{
$hoja1->setCellValue('F'.$cont,$PAGOCHEQUE3[$i]);
}
}
$cont++;
$hoja1->setCellValue('F'.$cont,'');
}
if (isset($CREDITO1)){
for ($i=1;$i<=count($CREDITO1);$i++){
$cont++;
if (!isset($PAGOCREDITO3[$i])){
$hoja1->setCellValue('F'.$cont,0);
}
else{
$hoja1->setCellValue('F'.$cont,$PAGOCREDITO3[$i]);
}
}
$cont++;
$hoja1->setCellValue('F'.$cont,'');
}
if (isset($EFECTIVO1)){
for ($i=1;$i<=count($EFECTIVO1);$i++){
$cont++;
if (!isset($PAGOEFECTIVO3[$i])){
$hoja1->setCellValue('F'.$cont,0);
}
else{
$hoja1->setCellValue('F'.$cont,$PAGOEFECTIVO3[$i]);
}
}
$cont++;
$hoja1->setCellValue('F'.$cont,'');
}
if (isset($OPERACION1)){
for ($i=1;$i<=count($OPERACION1);$i++){
$cont++;
if (!isset($PAGOOPERACION3[$i])){
$hoja1->setCellValue('F'.$cont,0);
}
else{
$hoja1->setCellValue('F'.$cont,$PAGOOPERACION3[$i]);
}
}
$cont++;
$hoja1->setCellValue('F'.$cont,'');
}
}

if (isset($idunidad[3])){
$cont=9;
if (isset($CHEQUE1)){
for ($i=1;$i<=count($CHEQUE1);$i++){
$cont++;
if (!isset($PAGOCHEQUE4[$i])){
$hoja1->setCellValue('G'.$cont,0);
}
else{
$hoja1->setCellValue('G'.$cont,$PAGOCHEQUE4[$i]);
}
}
$cont++;
$hoja1->setCellValue('G'.$cont,'');
}
if (isset($CREDITO1)){
for ($i=1;$i<=count($CREDITO1);$i++){
$cont++;
if (!isset($PAGOCREDITO4[$i])){
$hoja1->setCellValue('G'.$cont,0);
}
else{
$hoja1->setCellValue('G'.$cont,$PAGOCREDITO4[$i]);
}
}
$cont++;
$hoja1->setCellValue('G'.$cont,'');
}
if (isset($EFECTIVO1)){
for ($i=1;$i<=count($EFECTIVO1);$i++){
$cont++;
if (!isset($PAGOEFECTIVO4[$i])){
$hoja1->setCellValue('G'.$cont,0);
}
else{
$hoja1->setCellValue('G'.$cont,$PAGOEFECTIVO4[$i]);
}
}
$cont++;
$hoja1->setCellValue('G'.$cont,'');
}
if (isset($OPERACION1)){
for ($i=1;$i<=count($OPERACION1);$i++){
$cont++;
if (!isset($PAGOOPERACION4[$i])){
$hoja1->setCellValue('G'.$cont,0);
}
else{
$hoja1->setCellValue('G'.$cont,$PAGOOPERACION4[$i]);
}
}
$cont++;
$hoja1->setCellValue('G'.$cont,'');
}
}

if (isset($idunidad[4])){
$cont=9;
if (isset($CHEQUE1)){
for ($i=1;$i<=count($CHEQUE1);$i++){
$cont++;
if (!isset($PAGOCHEQUE5[$i])){
$hoja1->setCellValue('H'.$cont,0);
}
else{
$hoja1->setCellValue('H'.$cont,$PAGOCHEQUE5[$i]);
}
}
$cont++;
$hoja1->setCellValue('H'.$cont,'');
}
if (isset($CREDITO1)){
for ($i=1;$i<=count($CREDITO1);$i++){
$cont++;
if (!isset($PAGOCREDITO5[$i])){
$hoja1->setCellValue('H'.$cont,0);
}
else{
$hoja1->setCellValue('H'.$cont,$PAGOCREDITO5[$i]);
}
}
$cont++;
$hoja1->setCellValue('H'.$cont,'');
}
if (isset($EFECTIVO1)){
for ($i=1;$i<=count($EFECTIVO1);$i++){
$cont++;
if (!isset($PAGOEFECTIVO5[$i])){
$hoja1->setCellValue('H'.$cont,0);
}
else{
$hoja1->setCellValue('H'.$cont,$PAGOEFECTIVO5[$i]);
}
}
$cont++;
$hoja1->setCellValue('H'.$cont,'');
}
if (isset($OPERACION1)){
for ($i=1;$i<=count($OPERACION1);$i++){
$cont++;
if (!isset($PAGOOPERACION5[$i])){
$hoja1->setCellValue('H'.$cont,0);
}
else{
$hoja1->setCellValue('H'.$cont,$PAGOOPERACION5[$i]);
}
}
$cont++;
$hoja1->setCellValue('H'.$cont,'');
}
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="pruebaReal.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>