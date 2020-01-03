<?php

include '../../db/conexion.php';

$cont=0;
$consulta = "SELECT unidad FROM unidad ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1){
$json='{"unidad": "'.$columna['unidad'].'"}';
}
if ($cont>1){
$json.=',{"unidad": "'.$columna['unidad'].'"}';
}
}

echo json_encode($json);
?>