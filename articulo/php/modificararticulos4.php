<?php

include '../../db/conexion.php';

$nombre=$_POST['nombre'];

$cont=0;

$consulta = "SELECT idLinea FROM linea WHERE descripcion = '$nombre' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json=$columna['idLinea'];
}

echo $json;
?>