<?php

include '../../db/conexion.php';

$dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');

$json="";$cont1=1;$cont2=1;$cont3=1;$cont4=1;$cont5=1;$cont6=1;$cont7=1;

$idMenu=$_POST['idmenu'];
$tiem=$_POST['tiem'];

$consulta = "SELECT receta,precio,personas,fecha FROM menurec WHERE idMenu = '$idMenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){

$nombre=$columna['receta'];

$consulta1 = "SELECT idReceta FROM receta WHERE nombre = '$nombre' ";
$resultado1 = mysqli_query($conexion,$consulta1);
while($columna1=mysqli_fetch_array($resultado1)){
$idreceta=$columna1['idReceta'];
}

$fecha = $columna['fecha'];
$fecha = str_replace(" 00:00:00","",$fecha);
$dia = $dias[date('N', strtotime($fecha))];

if("Lunes"==$dia){
$matriz[$cont1][1]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont1=$cont1+1;
}
if("Martes"==$dia){
$matriz[$cont2][2]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont2=$cont2+1;
}
if("Miercoles"==$dia){
$matriz[$cont3][3]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont3=$cont3+1;
}
if("Jueves"==$dia){
$matriz[$cont4][4]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont4=$cont4+1;
}
if("Viernes"==$dia){
$matriz[$cont5][5]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont5=$cont5+1;
}
if("Sabado"==$dia){
$matriz[$cont6][6]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont6=$cont6+1;
}
if("Domingo"==$dia){
$matriz[$cont7][7]=$nombre.",".$columna['precio'].",".$columna['personas'].",".$idreceta;
$cont7=$cont7+1;
}

}

$tiem=$tiem+1;

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