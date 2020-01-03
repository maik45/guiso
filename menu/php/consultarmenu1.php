<?php

include '../../db/conexion.php';

$consulta = "SELECT receta FROM menurec WHERE idMenu = '2011_11_3_01_01_03' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json.=",".$columna['receta'];
}

echo json_encode($json);
?>