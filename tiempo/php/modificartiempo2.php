<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];
$descripcion=$_POST['descripcion'];

$sql = "UPDATE tiempo SET descripcion='$descripcion' WHERE idTiempo = '$clave' ";

mysqli_query($conexion,$sql);
?>