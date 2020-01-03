<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

class Articulos{

  private $db;

  public function __construct(){
    global $db;
    $this->db = $db; 
  }

  public function getAllArticulos(){

    $sql = "SELECT idArticulo, nombre, unidad, costo, linea AS lineaId, (SELECT descripcion FROM linea WHERE idLinea = linea ) AS linea, unidadA FROM articulo WHERE activo = 1";
    $r = $this->db->query( $sql );
    while( $items[] = $r->fetch_object() );
    array_pop( $items );
    echo json_encode($items);

  }

  public function relacionArticuloReceta(){

    $idArticulo = filter_input(INPUT_POST, 'idArticulo', FILTER_SANITIZE_STRING) or die(toJson(0, 'El articulo es incorrecto') );
    $idReceta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING) or die(toJson(0, 'La receta es invalida') );
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_FLOAT)  or die ( toJson(0, 'La cantidad es invalida') ) ;

    $sql = "INSERT INTO recetaart (receta, articulo, cantidad, fecha) VALUES ( '{$idReceta}', '{$idArticulo}', '{$cantidad}', now() )";
    $this->db->query($sql);

    empty( $this->db->error ) or die( toJson(0, 'Error al almacenar el articulo, intente nuevamente', ['error'=> $this->db->error] ) );

    if( $this->db->affected_rows > 0 )
      echo toJson(1, 'Articulo agregado correctamente', ['idReceta'=> $idReceta]);
    else
      echo toJson(0, 'Error al guardar el articulo, intente nuevamente', ['error'=> $this->db->error]);

  }

  public function relacionArticuloRecetaDelete(){

    $idArticulo = filter_input(INPUT_POST, 'idArticulo', FILTER_SANITIZE_STRING) or die(toJson(0, 'El articulo es incorrecto') );
    $idReceta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING) or die(toJson(0, 'La receta es invalida') );

    $sql = "DELETE FROM recetaart WHERE receta = '{$idReceta}' AND articulo = '{$idArticulo}'";
    $this->db->query($sql);

    empty( $this->db->error ) or die( toJson(0, 'Error al Eliminar el articulo, intente nuevamente', ['error'=> $this->db->error] ) );

    if( $this->db->affected_rows > 0 )
      echo toJson(1, 'Articulo Eliminado correctamente', ['idReceta'=> $idReceta]);
    else
      echo toJson(0, 'Error al eliminar el articulo, intente nuevamente', ['error'=> $this->db->error]);

  }

  public function relacionArticuloRecetaUpdate(){

    $idArticulo = filter_input(INPUT_POST, 'idArticulo', FILTER_SANITIZE_STRING) or die(toJson(0, 'El articulo es incorrecto') );
    $idReceta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING) or die(toJson(0, 'La receta es invalida') );
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_STRING) or die(toJson(0, 'La cantidad es invalida') );

    $sql = "UPDATE recetaart SET cantidad = '{$cantidad}' WHERE receta = '{$idReceta}' AND articulo = '{$idArticulo}'";
    $this->db->query($sql);

    empty( $this->db->error ) or die( toJson(0, 'Error al modificar el articulo, intente nuevamente', ['error'=> $this->db->error] ) );

    if( $this->db->affected_rows > 0 )
      echo toJson(1, 'Articulo modificado correctamente', ['idReceta'=> $idReceta]);
    else
      echo toJson(0, 'Error al modificar el articulo, intente nuevamente', ['error'=> $this->db->error]);

  }


  public function __destruct(){
    $this->db->close();
  }



}

$Articulos = new Articulos();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($Articulos, $method) or die( 'Method not found' );

$Articulos->{$method}();//llama a la funcion existente