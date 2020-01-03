<?php

include '../../db/conexion.php';

$codigoarticulo=$_POST['codigoarticulo'];
$nombre=$_POST['nombre'];
$linea1=$_POST['linea1'];
$linea2=$_POST['linea2'];
$unidad=$_POST['unidad'];
$minimo=$_POST['minimo'];
$maximo=$_POST['maximo'];
$cantidadpresentacion=$_POST['cantidadpresentacion'];
$presentacion=$_POST['presentacion'];
$informacion=$_POST['informacion'];

$sql = "INSERT INTO articulo (idArticulo,nombre,linea,unidad,unidadA,factor,minimo,maximo,info, activo) VALUES 
                             ('$codigoarticulo','$nombre','$linea1','$unidad','$presentacion','$cantidadpresentacion','$minimo',
                              '$maximo','$informacion', 1)";

mysqli_query($conexion,$sql);
echo mysqli_affected_rows($conexion);
// var_dump($conexion);
?>