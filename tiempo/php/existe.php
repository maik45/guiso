<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];
$clave=strval($clave);

$consul ="SELECT idTiempo FROM tiempo WHERE idTiempo = '$clave' ";
$result = mysqli_query($conexion,$consul);
mysqli_num_rows($result);

if(mysqli_num_rows($result)>0){
$temp=1;
}else{
$temp=0;
}

echo $temp;

?>