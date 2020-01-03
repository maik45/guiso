<?php

// $conexion = mysqli_connect("localhost","root","") or die ("No se ha podido conectar al servidor de Base de datos");
// $db = mysqli_select_db( $conexion,"jace") or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );

// $cont=0;

// $consulta = "SELECT idArticulo,nombre,linea,unidad,unidadA,factor,minimo,maximo,costo FROM articulo ";

// $resultado = mysqli_query($conexion,$consulta);
// while($columna=mysqli_fetch_array($resultado)){

// $cont++;

// if ($cont<100){
// if ($cont==1) {
// $json='{"idArticulo": "'.$columna['idArticulo'].'","nombre": "'.$columna['nombre'].'","linea": "'.$columna['linea'].'","unidad": "'.$columna['unidad'].'",
// "unidadA": "'.$columna['unidadA'].'","factor": "'.$columna['factor'].'","minimo": "'.$columna['minimo'].'","maximo": "'.$columna['maximo'].'",
// "costo": "'.$columna['costo'].'"}';
// }
// if ($cont>1) {
// $json.=',{"idArticulo": "'.$columna['idArticulo'].'","nombre": "'.$columna['nombre'].'","linea": "'.$columna['linea'].'","unidad": "'.$columna['unidad'].'",
// "unidadA": "'.$columna['unidadA'].'","factor": "'.$columna['factor'].'","minimo": "'.$columna['minimo'].'","maximo": "'.$columna['maximo'].'",
// "costo": "'.$columna['costo'].'"}';
// }
// }

// }

// echo json_encode($json);

session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

$requestData = $_POST;
// los indices de las columnas de datatable deben coincidir conm el nombrte en la base de datos
$columns = array(
  0 => 'idArticulo',
  1 => "nombre",
  2 => 'descripcion',
  3 => "unidad",
  4 => "unidadA",
  5 => "factor",
  6 => "minimo",
  7 => "maximo",
  8 => "costo"
);

$totalFiltered = $totalData = 0;

$sql = "SELECT art.idArticulo, art.nombre, art.unidad, art.unidadA, art.factor, art.minimo, art.maximo, art.costo, li.descripcion FROM articulo AS art LEFT JOIN linea as li ON li.idLinea = art.linea WHERE art.activo = 1 ";
$sqlCount = "SELECT COUNT(*) AS total FROM articulo AS art LEFT JOIN linea as li ON li.idLinea = art.linea WHERE art.activo = 1  ";

$result = $db->query( $sqlCount );
$totalData = $totalFiltered = $result->fetch_object()->total;

// Si exiten parametros de busqueda (provenientes del cuadro de busqueda da la datatable) se aplican
// los campos evaluados en el where se deben reemplazar por los que contenga la tabla a seleccionar
if( ! empty( $requestData['search']['value'] ) ):
  $sqlSearch = " AND ( idArticulo LIKE '%{$requestData['search']['value']}%' OR nombre LIKE '%{$requestData['search']['value']}%' )";
  $sql .= $sqlSearch;
  $sqlCount .= $sqlSearch;
  $result = $db->query( $sqlCount );
  $totalFiltered = $result->fetch_object()->total;
endif;

// Es importante declarar el array colums de esa forma la datatable podrá ordenar ascendente o descendente los registros
// start y lengt en el limit son los encargados de solicitar el numero de pagina de la data table
$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] ." {$requestData['order'][0]['dir']} LIMIT {$requestData['start']}, {$requestData['length']} ";
//ejecutamos el query Final
$result = $db->query( $sql );

while( $rows[] = $result->fetch_object() );
array_pop( $rows );

//Este array es el que recibe la datatable y convierte en el resultado deseado
$data = array(
  "draw" => intval($requestData['draw']),   // Registros por paginado
  "recordsTotal" => intval($totalData),   // Registros totales
  "recordsFiltered" => intval($totalFiltered),// Registros filtrados por el cuadro de busqueda
  "data" => $rows,  // Objeto que contiene la tabla a ser mostrada
  "sql"=> $sql
);

echo json_encode($data);
