<?php

include '../../db/conexion.php';

$cont=0;
$consulta = "SELECT nombre FROM cliente ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1){
$json='{"nombre": "'.$columna['nombre'].'"}';
}
if ($cont>1){
$json.=',{"nombre": "'.$columna['nombre'].'"}';
}
}

echo json_encode($json);
?>