<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

class Linea{

  private $db;

  public function __construct(){
    global $db;
    $this->db = $db; 
  }

  public function getLineas(){

    $sql = "SELECT idLinea, descripcion FROM linea WHERE 1 AND activo = 1 ORDER BY descripcion";
    $r = $this->db->query( $sql );
    while( $items[] = $r->fetch_object() );
    array_pop( $items );
    echo json_encode($items);

  }


  public function __destruct(){
    $this->db->close();
  }



}

$Linea = new Linea();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($Linea, $method) or die( 'Method not found' );

$Linea->{$method}();//llama a la funcion existente