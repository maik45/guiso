<?php

include '../../db/conexion.php';

$id=$_POST['id'];

$consulta = "DELETE FROM articulo WHERE idArticulo = '$id' ";

mysqli_query($conexion,$consulta);

?>