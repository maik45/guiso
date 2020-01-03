<?php

include '../../db/conexion.php';

$consulta = "SELECT idTiempo,descripcion,fecha FROM tiempo";
$resultado = mysqli_query($conexion, $consulta);
while( $row = mysqli_fetch_object($resultado) ){
  $rows[] = $row;
}
// array_pop($rows);
echo json_encode($rows);
