<?php

include '../../db/conexion.php';

$idmenu=$_POST['idmenu'];
$id=strval($idmenu);

$costosunidad=$_POST['costosunidad'];

$recetas=$_POST['recetas'];
$precio=$_POST['precio'];
$fecharecetas=$_POST['fecharecetas'];
$personas=$_POST['numpersonas'];

$fecharecetas = explode(",",$fecharecetas);
$recetas = explode(",",$recetas);
$precio = explode(",",$precio);
$personas = explode(",",$personas);

$sql1 = "UPDATE menu SET costoTot='$costosunidad' WHERE idMenu='$id' ";
mysqli_query($conexion,$sql1);

$sql2="DELETE FROM menurec WHERE idMenu = '$idmenu' ";
mysqli_query($conexion,$sql2);
for ($i=0;$i<count($recetas);$i++){
$vec1[$i]=$recetas[$i];
$vec2[$i]=$precio[$i];
$vec3[$i]=$personas[$i];
$vec4[$i]=$fecharecetas[$i];
}

for ($i=0;$i<count($recetas);$i++){
$sql3 = "INSERT INTO menurec (idMenu,pos,receta,precio,personas,fecha) VALUES ('$id','','$vec1[$i]','$vec2[$i]','$vec3[$i]','$vec4[$i]')";
mysqli_query($conexion,$sql3);
}

?>