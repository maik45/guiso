<?php

include '../../db/conexion.php';

$idmenu=$_POST['idmenu'];
$idmenu=strval($idmenu);
$temp='';

$consulta = "SELECT lapso FROM menu WHERE idMenu = '$idmenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$cadena=$columna['lapso'];
}

$resultado = str_replace(" - ", ",", $cadena);
$porciones = explode(",",$resultado);

$porciones[0] = str_replace("/","-",$porciones[0]);
$porciones[0] = date("Y-m-d", strtotime($porciones[0]));

$porciones[1] = str_replace("/","-",$porciones[1]);
$porciones[1] = date("Y-m-d", strtotime($porciones[1]));

$period = new DatePeriod(new DateTime($porciones[0]), new DateInterval('P1D'), new DateTime($porciones[1]));
foreach ($period as $date) {
$temp.=",".$date->format("Y-m-d");
}

$temp.=",".$porciones[1];

$consulta = "SELECT cliente,unidad,subUnidad,grupo FROM menu WHERE idMenu = '$idmenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$id1=$columna['cliente'];
$id2=$columna['unidad'];
$id3=$columna['subUnidad'];
$id4=$columna['grupo'];
}

$consulta = "SELECT nombre FROM cliente WHERE idCliente = '$id1' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$nombre=$columna['nombre'];
}

$consulta = "SELECT unidad FROM unidad WHERE idUnidad = '$id2' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$unidad=$columna['unidad'];
}

$consulta = "SELECT subUnidad FROM subunidad WHERE idSUnidad = '$id3' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$subunidad=$columna['subUnidad'];
}

$consulta = "SELECT descripcion FROM grupo WHERE idGrupo = '$id4' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$descripcion=$columna['descripcion'];
}

$consulta = "SELECT anio,numTiempos,cliente,unidad,subUnidad,grupo,elaboro,costoTot,semana,lunes,martes,miercoles,jueves,viernes,sabado,domingo 
FROM menu WHERE idMenu = '$idmenu' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$json='{"semana": "'.$columna['semana'].'","anio": "'.$columna['anio'].'","numTiempos": "'.$columna['numTiempos'].'","cliente": "'.$nombre.'",
		"unidad": "'.$unidad.'","subunidad": "'.$subunidad.'","grupo": "'.$descripcion.'","elaboro": "'.$columna['elaboro'].'",
		"costo": "'.$columna['costoTot'].'","lapso": "'.$temp.'","lapsoi": "'.$cadena.'","lunes": "'.$columna['lunes'].'",
		"martes": "'.$columna['martes'].'","miercoles": "'.$columna['miercoles'].'","jueves": "'.$columna['jueves'].'",
		"viernes": "'.$columna['viernes'].'","sabado": "'.$columna['sabado'].'","domingo": "'.$columna['domingo'].'"}';
}

echo json_encode($json);
?>