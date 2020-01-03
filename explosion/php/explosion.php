<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

class Explosion{

  private $db;

  public function __construct(){
    global $db;
    $this->db = $db; 
  }

  public function getClienteUnidad(){

    $items = [];
    $sql = "SELECT idCliente, nombre FROM cliente WHERE 1 AND activo = 1 ORDER BY nombre";
    $r = $this->db->query( $sql );
    
    $clientes = [];
    while( $row = $r->fetch_object() ){

      $items = [];
      $sql = "SELECT idUnidad, unidad FROM unidad WHERE 1 AND activo = 1 AND cliente = '{$row->idCliente}' ORDER BY unidad";
      $r2 = $this->db->query( $sql );
      while( $items[] = $r2->fetch_object() );
      array_pop( $items );
      $row->unidades = $items;

      $clientes[] = $row;

    }
    echo json_encode($clientes);
  }

  public function deleteExcedente(){

    $sql = "DELETE FROM excedente WHERE 1";
    $r = $this->db->query( $sql );
    echo $this->db->affected_rows;
    // if( $r )
    //   echo 1;
    // else
    //   echo 0;
  }

  public function __destruct(){
    $this->db->close();
  }



}

$Explosion = new Explosion();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($Explosion, $method) or die( 'Method not found' );

$Explosion->{$method}();//llama a la funcion existente