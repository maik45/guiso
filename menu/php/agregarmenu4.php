<?php

include '../../db/conexion.php';

$nombre=$_POST['nombre'];

$cont=0;
$consulta = "SELECT idSUnidad,subUnidad FROM subunidad WHERE unidad = '$nombre' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if($cont==1){
$json='{"idsubunidad": "'.$columna['idSUnidad'].'","subunidad": "'.$columna['subUnidad'].'"}';
}
if($cont>1){
$json.=',{"idsubunidad": "'.$columna['idSUnidad'].'","subunidad": "'.$columna['subUnidad'].'"}';
}
}

echo json_encode($json);
?>