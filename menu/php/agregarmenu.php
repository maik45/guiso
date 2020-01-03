<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idTiempo FROM tiempo ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idTiempo": "'.$columna['idTiempo'].'"}';
}
if ($cont>1) {
$json.=',{"idTiempo": "'.$columna['idTiempo'].'"}';
}
}

echo json_encode($json);
?>