<?php

include '../../db/conexion.php';

$idmenu=$_POST['idmenu'];
$grupo="";
$cliente="";
$unidad="";
$subunidad="";

$consulta = "SELECT semana,numTiempos,lapso,elaboro,grupo,cliente,unidad,subUnidad FROM menu WHERE idMenu = '$idmenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json='{"semana": "'.$columna['semana'].'","lapso": "'.$columna['lapso'].'","numTiempos": "'.$columna['numTiempos'].'","elaboro": "'.$columna['elaboro'].'"';
$grupo=$columna['grupo'];
$cliente=$columna['cliente'];
$unidad=$columna['unidad'];
$subunidad=$columna['subUnidad'];
}

$consulta = "SELECT descripcion FROM grupo WHERE idGrupo = '$grupo' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json.=',"descripcion": "'.$columna['descripcion'].'"';
}

$consulta = "SELECT nombre FROM cliente WHERE idCliente = '$cliente' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json.=',"nombre": "'.$columna['nombre'].'"';
}

$consulta = "SELECT unidad FROM unidad WHERE idUnidad = '$unidad' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json.=',"unidad": "'.$columna['unidad'].'"';
}

$consulta = "SELECT subUnidad FROM subunidad WHERE idSUnidad = '$subunidad' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json.=',"subUnidad": "'.$columna['subUnidad'].'"';
}

$json.="}";

echo json_encode($json);
?>