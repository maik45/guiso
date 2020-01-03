<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idReceta,nombre FROM receta";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idReceta": "'.$columna['idReceta'].'","nombre": "'.$columna['nombre'].'"}';
}
if ($cont>1) {
$json.=',{"idReceta": "'.$columna['idReceta'].'","nombre": "'.$columna['nombre'].'"}';
}
}

echo json_encode($json);
?>