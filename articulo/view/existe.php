<?php

$conexion = mysqli_connect("localhost","root","") or die ("No se ha podido conectar al servidor de Base de datos");
$db = mysqli_select_db( $conexion,"jace") or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );

$idarticulo=$_POST['clave'];
$idarticulo=strval($clave);

$consul ="SELECT idArticulo FROM articulo WHERE idArticulo = '$idarticulo' ";
$result = mysqli_query($conexion,$consul);
mysqli_num_rows($result);

if(mysqli_num_rows($result)>0){
$temp=1;
}else{
$temp=0;
}

echo $temp;

?>