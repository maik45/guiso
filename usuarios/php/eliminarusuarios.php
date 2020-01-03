<?php

include '../../db/conexion.php';

$id=$_POST['id'];

$sql="DELETE FROM usuario WHERE idUser ='$id' ";

mysqli_query($conexion,$sql);
?>