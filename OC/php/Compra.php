<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

class Compra{

  private $db;

  private $username;
  private $name;
  private $phone;
  private $rol;
  private $address;

  public function __construct(){
    global $db;
    $this->db = $db; 
    
    $this->username = $_SESSION['usuario_comedor'];
    $this->name = $_SESSION['nombre_comedor'];
    $this->phone = $_SESSION['telefono_comedor'];
    $this->rol = $_SESSION['rol_comedor'];
    $this->address = $_SESSION['direccion_comedor'];
    $this->uidUser = $_SESSION['uid_comedor'];

  }

  public function getOrden(){
    $sql = "SELECT MAX(id) AS orden FROM oc";
    $r = $this->db->query( $sql );
    $r = $r->fetch_object();
    return date('y-W').'-'.$r->orden;
  }

  public function crearOC(){


    // echo json_encode($_POST);

    //tegno el clienteId y usuario en sesion id
    $client = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT) or die(toJson(0, 'El cliente es inválido'));
    $start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING) or die(toJson(0, 'La fecha inicial es inválida'));
    $end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING) or die(toJson(0, 'La fecha final es inválida'));
    //$this->uidUser;//id usuario en sesioon

    $sql = "SELECT COUNT(*) as total FROM menu as me inner join menurec as mr on me.idMenu = mr.idMenu WHERE ( date(mr.fecha) between '{$start}' AND '{$end}' ) AND me.activo = 1 AND me.cliente = '{$client}'";
    $r = $this->db->query($sql);
    $r = $r->fetch_object()->total;

    $r > 0 or die( toJson(0, 'No hay información en ese rango de fechas para generar la orden') );

    //yo omito esta parte ya que pues es un auto incremtnable en la bd
    $orden = $this->getOrden();
    $sql = "INSERT INTO oc (idOC, cliente, fechaI, fechaF, status, fecha, usuario) VALUES ( '{$orden}', '{$client}', '{$start}', '{$end}', 0, now(), '{$this->uidUser}' )";
    $r = $this->db->query($sql);
    $this->db->affected_rows > 0 or die(toJson(0, 'Error al generar la orden de compra por favor reintente'));
    $idOrden = $this->db->insert_id;
    echo toJson(1, "Orden de compra generada con el folio {$orden}", ['orden'=> $orden]);

  }


  public function __destruct(){
    $this->db->close();
  }



}

$Compra = new Compra();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($Compra, $method) or die( 'Method not found' );

$Compra->{$method}();//llama a la funcion existente