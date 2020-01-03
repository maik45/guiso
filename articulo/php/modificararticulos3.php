<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];
$linea1=$_POST['linea1'];
$linea1 = (string) $linea1;
$unidad=$_POST['unidad'];
$presentacion=$_POST['presentacion'];
$factor=$_POST['factor'];
$minimo=$_POST['minimo'];
$minimo = (float) $minimo;
$maximo=$_POST['maximo'];
$maximo = (float) $maximo;
$info=$_POST['info'];

$sql = "UPDATE articulo SET linea='$linea1',unidad='$unidad',unidadA='$presentacion',
factor='$factor',maximo='$maximo',minimo='$minimo',info='$info' WHERE idArticulo = '$clave' ";

mysqli_query($conexion,$sql);
?>