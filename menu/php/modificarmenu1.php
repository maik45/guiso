<?php

include '../../db/conexion.php';

$dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');

$json="";$cont1=1;$cont2=1;$cont3=1;$cont4=1;$cont5=1;$cont6=1;$cont7=1;

$idMenu=$_POST['idmenu'];

$consulta = "SELECT numTiempos FROM menu WHERE idMenu = '$idMenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$tiempos=$columna['numTiempos'];
}

$consulta = "SELECT receta,precio,personas,fecha FROM menurec WHERE idMenu = '$idMenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){

$fecha = $columna['fecha'];
$fecha = str_replace(" 00:00:00","",$fecha);
$dia = $dias[date('N', strtotime($fecha))];

if("Lunes"==$dia){
$matriz[$cont1][1]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont1=$cont1+1;
}
if("Martes"==$dia){
$matriz[$cont2][2]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont2=$cont2+1;
}
if("Miercoles"==$dia){
$matriz[$cont3][3]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont3=$cont3+1;
}
if("Jueves"==$dia){
$matriz[$cont4][4]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont4=$cont4+1;
}
if("Viernes"==$dia){
$matriz[$cont5][5]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont5=$cont5+1;
}
if("Sabado"==$dia){
$matriz[$cont6][6]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont6=$cont6+1;
}
if("Domingo"==$dia){
$matriz[$cont7][7]=$columna['receta'].','.$columna['precio'].','.$columna['personas'];
$cont7=$cont7+1;
}

}

$tiempos=$tiempos+1;

for ($i=1;$i<$tiempos;$i++){

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

if($i==1){
$json='{"lunes": "'.$matriz[$i][1].'","martes": "'.$matriz[$i][2].'","miercoles": "'.$matriz[$i][3].'","jueves": "'.$matriz[$i][4].'"
		,"viernes": "'.$matriz[$i][5].'","sabado": "'.$matriz[$i][6].'","domingo": "'.$matriz[$i][7].'"}';	
}
if($i>1){
$json.=',{"lunes": "'.$matriz[$i][1].'","martes": "'.$matriz[$i][2].'","miercoles": "'.$matriz[$i][3].'","jueves": "'.$matriz[$i][4].'"
		,"viernes": "'.$matriz[$i][5].'","sabado": "'.$matriz[$i][6].'","domingo": "'.$matriz[$i][7].'"}';	
}
}

echo json_encode($json);

?>