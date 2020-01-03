<?php

include '../../db/conexion.php';

$nombre=$_POST['nombre'];
$id=$_POST['id'];

$consulta = "SELECT idReceta,costo,porciones FROM receta WHERE nombre = '$nombre' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$idreceta=$columna['idReceta'];
$costo=$columna['costo']/$columna['porciones'];
}

echo $id.','.$idreceta.','.ROUND($costo,2);

?>