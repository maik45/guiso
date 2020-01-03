<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];

$consulta = "SELECT cantidad FROM recetaart where receta = '$clave' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$costo=$columna['cantidad'];
}

echo $costo;

?>