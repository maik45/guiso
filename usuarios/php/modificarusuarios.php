<?php

include '../../db/conexion.php';

$cont=0;

$consulta = "SELECT idUser,nombre,usuario,password,rol,direccion,telefono FROM usuario";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cont++;
if ($cont==1) {
$json='{"id": "'.$columna['idUser'].'","nombre": "'.$columna['nombre'].'","usuario": "'.$columna['usuario'].'","password": "'.$columna['password'].'"
,"rol": "'.$columna['rol'].'","direccion": "'.$columna['direccion'].'","telefono": "'.$columna['telefono'].'"}';
}
if ($cont>1) {
$json.=',{"id": "'.$columna['idUser'].'","nombre": "'.$columna['nombre'].'","usuario": "'.$columna['usuario'].'","password": "'.$columna['password'].'"
,"rol": "'.$columna['rol'].'","direccion": "'.$columna['direccion'].'","telefono": "'.$columna['telefono'].'"}';
}
}

echo json_encode($json);
?>