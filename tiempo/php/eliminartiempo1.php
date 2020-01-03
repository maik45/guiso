<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];
$descripcion=$_POST['descripcion'];

$sql="DELETE FROM tiempo WHERE idTiempo ='$clave' ";

mysqli_query($conexion,$sql);
?>