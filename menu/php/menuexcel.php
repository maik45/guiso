<?php

include '../../db/conexion.php';
require_once 'excel/Classes/PHPExcel.php';

$idMenu=$_GET['idMenu'];
$semana=$_GET['semana'];
$numTiempos=$_GET['numTiempos'];
$cliente=$_GET['cliente'];
$unidad=$_GET['unidad'];
$subunidad=$_GET['subunidad'];
$lapso=$_GET['lapso'];
$elaboro=$_GET['elaboro'];
$descripcion=$_GET['descripcion'];
$costoTot=$_GET['costoTot'];

$objPHPExcel = new PHPExcel();

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
$objDrawing->setCoordinates('A1');                      
// setOffsetX works properly
$objDrawing->setOffsetX(0); 
$objDrawing->setOffsetY(0);                
//set width, height
$objDrawing->setWidth(200); 
$objDrawing->setHeight(70); 
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(11);

// $objPHPExcel->getActiveSheet()->getStyle('L')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

$objPHPExcel->getActiveSheet()
->getStyle('B1:AB1')
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('FF956B');

$objPHPExcel->getActiveSheet()
->getStyle('A10:AB10')
->getFill()
->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
->getStartColor()
->setRGB('6DDA81');

// $objPHPExcel->getActiveSheet()->getStyle("G1")->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A5','Semana')
->setCellValue('B5',$semana)
->setCellValue('A6','Año')
->setCellValue('B6',$lapso)
->setCellValue('A7','ID menu')
->setCellValue('B7',$idMenu)
->setCellValue('A8','#Tiempos')
->setCellValue('B8',$numTiempos)

->setCellValue('E5','Cliente')
->setCellValue('F5',$cliente)
->setCellValue('E6','Unidad')
->setCellValue('F6',$unidad)
->setCellValue('E7','SubUnidad')
->setCellValue('F7',$subunidad)

->setCellValue('k5','Costo/Total')
->setCellValue('L5',$costoTot)
->setCellValue('k6','Elaboro')
->setCellValue('L6',$elaboro)
->setCellValue('k7','Grupo')
->setCellValue('L7',$descripcion)

->setCellValue('A10','ID')
->setCellValue('B10','Lunes')
->setCellValue('D10','Costo')

->setCellValue('E10','ID')
->setCellValue('F10','Martes')
->setCellValue('H10','Costo')

->setCellValue('I10','ID')
->setCellValue('J10','Miercoles')
->setCellValue('L10','Costo')

->setCellValue('M10','ID')
->setCellValue('N10','Jueves')
->setCellValue('P10','Costo')

->setCellValue('Q10','ID')
->setCellValue('R10','Viernes')
->setCellValue('T10','Costo')

->setCellValue('U10','ID')
->setCellValue('V10','Sabado')
->setCellValue('X10','Costo')

->setCellValue('Y10','ID')
->setCellValue('Z10','Domingo')
->setCellValue('AB10','Costo')

->setCellValue('G1','Menu Guisopak')
;

$hoja1=$objPHPExcel->getActiveSheet();
$dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
$json="";$cont1=1;$cont2=1;$cont3=1;$cont4=1;$cont5=1;$cont6=1;$cont7=1;

$consulta = "SELECT receta,precio,personas,fecha FROM menurec WHERE idMenu = '$idMenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){

$fecha = $columna['fecha'];
$fecha = str_replace(" 00:00:00","",$fecha);
$dia = $dias[date('N', strtotime($fecha))];

$nombre=$columna['receta'];

$consulta1 = "SELECT idReceta FROM receta WHERE nombre = '$nombre' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
$idreceta=$columna1['idReceta'];
}

if("Lunes"==$dia){
$matriz[$cont1][1]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont1=$cont1+1;
}
if("Martes"==$dia){
$matriz[$cont2][2]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont2=$cont2+1;
}
if("Miercoles"==$dia){
$matriz[$cont3][3]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont3=$cont3+1;
}
if("Jueves"==$dia){
$matriz[$cont4][4]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont4=$cont4+1;
}
if("Viernes"==$dia){
$matriz[$cont5][5]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont5=$cont5+1;
}
if("Sabado"==$dia){
$matriz[$cont6][6]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont6=$cont6+1;
}
if("Domingo"==$dia){
$matriz[$cont7][7]=$columna['receta'].",".$columna['precio']*$columna['personas'].",".$idreceta;
$cont7=$cont7+1;
}

}

$cont=12;
$tiem=$numTiempos+1;

for ($i=1;$i<$tiem;$i++){
if (!isset($matriz[$i][1])) {
$matriz[$i][1]="";
}
if (!isset($matriz[$i][2])) {
$matriz[$i][2]="";
}
if (!isset($matriz[$i][3])) {
$matriz[$i][3]="";
}
if (!isset($matriz[$i][4])) {
$matriz[$i][4]="";
}
if (!isset($matriz[$i][5])) {
$matriz[$i][5]="";
}
if (!isset($matriz[$i][6])) {
$matriz[$i][6]="";
}
if (!isset($matriz[$i][7])) {
$matriz[$i][7]="";
}

$vec1=explode(",",$matriz[$i][1]);
$vec2=explode(",",$matriz[$i][2]);
$vec3=explode(",",$matriz[$i][3]);
$vec4=explode(",",$matriz[$i][4]);
$vec5=explode(",",$matriz[$i][5]);
$vec6=explode(",",$matriz[$i][6]);
$vec7=explode(",",$matriz[$i][7]);

if ($vec1[0]!="") {
$hoja1
->setCellValue('A'.$cont,$vec1[2]);
$hoja1
->setCellValue('B'.$cont,$vec1[0]);
$hoja1
->setCellValue('D'.$cont,$vec1[1]);
}

if ($vec2[0]!="") {
$hoja1
->setCellValue('E'.$cont,$vec2[2]);
$hoja1
->setCellValue('F'.$cont,$vec2[0]);
$hoja1
->setCellValue('H'.$cont,$vec2[1]);
}

if ($vec3[0]!="") {
$hoja1
->setCellValue('I'.$cont,$vec3[2]);
$hoja1
->setCellValue('J'.$cont,$vec3[0]);
$hoja1
->setCellValue('L'.$cont,$vec3[1]);
}

if ($vec4[0]!="") {
$hoja1
->setCellValue('M'.$cont,$vec4[2]);
$hoja1
->setCellValue('N'.$cont,$vec4[0]);
$hoja1
->setCellValue('P'.$cont,$vec4[1]);
}

if ($vec5[0]!="") {
$hoja1
->setCellValue('Q'.$cont,$vec5[2]);
$hoja1
->setCellValue('R'.$cont,$vec5[0]);
$hoja1
->setCellValue('T'.$cont,$vec5[1]);
}

if ($vec6[0]!="") {
$hoja1
->setCellValue('U'.$cont,$vec6[2]);
$hoja1
->setCellValue('V'.$cont,$vec6[0]);
$hoja1
->setCellValue('X'.$cont,$vec6[1]);
}

if ($vec7[0]!="") {
$hoja1
->setCellValue('Y'.$cont,$vec7[2]);
$hoja1
->setCellValue('Z'.$cont,$vec7[0]);
$hoja1
->setCellValue('AB'.$cont,$vec7[1]);
}

$cont++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Menu.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>