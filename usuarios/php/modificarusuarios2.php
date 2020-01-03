<?php

include '../../db/conexion.php';

$id=$_POST['id'];
$nombre=$_POST['nombre'];
$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];
$rol=$_POST['rol'];
$direccion=$_POST['direccion'];
$telefono=$_POST['telefono'];

$sql = "UPDATE usuario SET nombre='$nombre',usuario='$usuario',password='$contrasena',rol='$rol',direccion='$direccion',telefono='$telefono' WHERE idUser = '$id' ";

mysqli_query($conexion,$sql);
?>