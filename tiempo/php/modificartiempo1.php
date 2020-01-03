<?php

include '../../db/conexion.php';

$id=$_POST['clave'];

$consulta = "SELECT descripcion FROM tiempo WHERE idTiempo = $id ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json=$columna['descripcion'];
}

echo $json;
?>