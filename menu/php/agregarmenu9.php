<?php

include '../../db/conexion.php';

$nombre="";

$fecha=$_POST['fecha'];
$anio=date("Y", strtotime($fecha));
$semana=$_POST['semana'];
$tiem=$_POST['tiemp'];
$cliente=$_POST['cliente'];
$unidad=$_POST['unidad'];
$subunidad=$_POST['subunidad'];
$grupo=$_POST['grupo'];
$costo=floatval($_POST['costo']);
$elaboro=$_POST['elaboro'];

$idrecetas=$_POST['idrecetas'];
$fecharecetas=$_POST['fecharecetas'];
$cantidad=$_POST['cantidad'];
$precio=$_POST['precio'];

$lunes=$_POST['lunes'];
$martes=$_POST['martes'];
$miercoles=$_POST['miercoles'];
$jueves=$_POST['jueves'];
$viernes=$_POST['viernes'];
$sabado=$_POST['sabado'];
$domingo=$_POST['domingo'];

$idMenu=$anio."_".$semana."_".$cliente."_".$unidad."_".$subunidad."_".$grupo;

//$sql = "INSERT INTO menu (idMenu,anio,semana) VALUES ('$idMenu','$anio','$semana')";
//mysqli_query($conexion,$sql);

$date = new DateTime($fecha);
$week = $date->format("W");
$year = date("Y", strtotime($fecha)); 
$dto = new DateTime();
$ret['week_start'] = $dto->setISODate($year,$week)->format('Y-m-d');
$ret['week_end'] = $dto->modify('+6 days')->format('Y-m-d');
echo $lapso=$ret['week_start'].' - '.$ret['week_end'];

$sql = "INSERT INTO menu (idMenu,anio,semana,lapso,numTiempos,cliente,unidad,subunidad,costoTot,elaboro,grupo,
					      lunes,martes,miercoles,jueves,viernes,sabado,domingo,status,fecha,activo) VALUES 
						 ('$idMenu','$anio','$semana','$lapso','$tiem','$cliente','$unidad','$subunidad','$costo','$elaboro','$grupo',
					      '$lunes','$martes','$miercoles','$jueves','$viernes','$sabado','$domingo',1,now(),1)";

mysqli_query($conexion,$sql);

$fecharecetas = explode(",",$fecharecetas);
$idrecetas = explode(",",$idrecetas);
$cantidad = explode(",",$cantidad);
$precio = explode(",",$precio);

for ($i=0;$i<count($fecharecetas);$i++){

$consulta = "SELECT nombre FROM receta WHERE idReceta = '$idrecetas[$i]' ";
$resultado = mysqli_query($conexion,$consulta);
while($columna=mysqli_fetch_array($resultado)){
$nombre=$columna['nombre'];
}

$sql = "INSERT INTO menurec (idMenu,pos,receta,precio,personas,fecha) VALUES ('$idMenu','','$nombre','$precio[$i]','$cantidad[$i]','$fecharecetas[$i]')";
mysqli_query($conexion,$sql);
}

?>