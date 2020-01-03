<?php

include '../../db/conexion.php';

$fecha=$_POST["fecha"];

$cliente=$_POST["cliente"];
//$costo=$_POST["costo"];
//$fecha=$_POST["fecha"];
//$unidad=$_POST["unidad"];
//$elaboro=$_POST["elaboro"];
//$tiem=$_POST["tiemp"];
//$subunidad=$_POST["subunidad"];
//$grupo=$_POST["grupo"];

$date = new DateTime($fecha);
$week = $date->format("W");
$year = date("Y", strtotime($fecha));

$menu = $year."_".$week."_".$cliente;

//$sql = "INSERT INTO tiempo ('idMenu') VALUES ()";
//mysqli_query($conexion,$sql);

echo $menu;
?>