<?php

error_reporting(0);

include '../../db/conexion.php';

$clave=$_POST['clave'];

$consulta = "SELECT costo,porciones FROM receta where idReceta = '$clave' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$costo=$columna['costo']/$columna['porciones'];
}

echo ROUND($costo,2);

?>