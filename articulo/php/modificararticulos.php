<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idArticulo,nombre FROM articulo ";

$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){

$cont++;
if ($cont==1) {
$json='{"idArticulo": "'.$columna['idArticulo'].'","nombre": "'.$columna['nombre'].'"}';
}
if ($cont>1) {
$json.=',{"idArticulo": "'.$columna['idArticulo'].'","nombre": "'.$columna['nombre'].'"}';
}

}

echo json_encode($json);
?>