<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idCliente,nombre FROM cliente ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idcliente": "'.$columna['idCliente'].'","nombre": "'.$columna['nombre'].'"}';
}
if ($cont>1) {
$json.=',{"idcliente": "'.$columna['idCliente'].'","nombre": "'.$columna['nombre'].'"}';
}
}

echo json_encode($json);
?>