<?php

include '../../db/conexion.php';

$clave=$_POST['clave'];

$consul ="SELECT idArticulo FROM articulo WHERE idArticulo = '".$clave."'";
$result = mysqli_query($conexion,$consul);
echo mysqli_num_rows($result);
if(mysqli_num_rows($result)>0){
$temp =1;
}else{
$temp =0;
}

echo $temp;

?>