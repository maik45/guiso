<?php 

include 'config.db.php';

$conexion = mysqli_connect(HOST,USER,PASS) or die ("No se ha podido conectar al servidor de Base de datos");
$db = mysqli_select_db( $conexion,DB_NAME) or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
mysqli_set_charset($conexion, "utf8");
?>