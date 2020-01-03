<?php

include '../../db/conexion.php';

$descripcion = $_POST['nombre'];

$consulta = "SELECT idLinea FROM linea WHERE descripcion = '$descripcion' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json=$columna['idLinea'];
}

echo $json;
?>