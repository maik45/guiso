<?php

include '../../db/conexion.php';

$nombre=$_POST['nombre'];
$usuario=$_POST['usuario'];
$contrasena=$_POST['contrasena'];
$rol=$_POST['rol'];
$direccion=$_POST['direccion'];
$telefono=$_POST['telefono'];

$sql = "INSERT INTO usuario (nombre,usuario,password,rol,direccion,telefono) VALUES ('$nombre','$usuario','$contrasena','$rol','$direccion','$telefono')";
mysqli_query($conexion,$sql);

$consulta = "SELECT max(idUser) as idUser FROM usuario ORDER BY idUser";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$idUser=$columna['idUser'];
}

echo $idUser;

?>