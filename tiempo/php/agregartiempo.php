<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];
$descripcion=$_POST['descripcion'];

$sql = "INSERT INTO tiempo (idTiempo,descripcion, fecha, activo) VALUES ('$clave','$descripcion', now(), 1)";

mysqli_query($conexion,$sql);
echo mysqli_affected_rows($conexion);
?>