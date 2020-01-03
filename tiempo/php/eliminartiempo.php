<?php

include '../../db/conexion.php';

$nombre=$_POST['nombre'];
$nombre=strval($nombre);

$cont=0;
$consulta = "SELECT idTiempo FROM tiempo WHERE descripcion = '$nombre' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idTiempo": "'.$columna['idTiempo'].'"}';
}
if ($cont>1) {
$json.=',{"idTiempo": "'.$columna['idTiempo'].'"}';
}
}

echo json_encode($json);
?>