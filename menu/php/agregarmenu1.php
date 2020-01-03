<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idGrupo,descripcion FROM grupo ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"idgrupo": "'.$columna['idGrupo'].'","descripcion": "'.$columna['descripcion'].'"}';
}
if ($cont>1) {
$json.=',{"idgrupo": "'.$columna['idGrupo'].'","descripcion": "'.$columna['descripcion'].'"}';
}
}

echo json_encode($json);
?>