<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idTiempo,descripcion,fecha FROM tiempo ORDER BY descripcion";

$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idTiempo": "'.$columna['idTiempo'].'","descripcion": "'.$columna['descripcion'].'","fecha": "'.$columna['fecha'].'"}';
}
if ($cont>1) {
$json.=',{"idTiempo": "'.$columna['idTiempo'].'","descripcion": "'.$columna['descripcion'].'","fecha": "'.$columna['fecha'].'"}';
}
}

echo json_encode($json);
?>