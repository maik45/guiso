<?php

include '../../db/conexion.php';

// $cont=0;

$consulta = "SELECT descripcion FROM linea ";
$resultado = mysqli_query($conexion,$consulta);

while( $rows[] = mysqli_fetch_object($resultado) );
array_pop($rows);
echo json_encode($rows);

// while($columna=mysqli_fetch_array($resultado)){
// $cont++;
// if ($cont==1) {
// $json='{"descripcion": "'.$columna['descripcion'].'"}';
// }
// if ($cont>1) {
// $json.=',{"descripcion": "'.$columna['descripcion'].'"}';
// }
// }

// echo json_encode($json);
?>