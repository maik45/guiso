<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

//Orden de compra con presentacion
class Facturas{

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

  public function getOrdenesAuth(){
    //para no traer todas las oradenes de la base de datos lo limito a traer las del ultimo año
    $dt = new DateTime();
    $dt->sub( new DateInterval('P1Y') );
    $dateLimit = $dt->format('Y-m-d');

    //obtener los datos de OC
    $sql = "SELECT 
    id, 
    idOC, 
    fecha, 
    fechaI, 
    fechaF, 
    (SELECT nombre FROM cliente WHERE idCliente = cliente LIMIT 1) AS cliente, 
    (SELECT nombre FROM usuario WHERE idUser = oc.usuario LIMIT 1) AS usuario,
    'oc' AS tipo
    FROM oc WHERE 1 AND fecha > '{$dateLimit}' AND status = 2";

    $r = $this->db->query( $sql );
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);

    //obtener los datos de OCM
    $sql = "SELECT 
    id, 
    idOC, 
    fecha, 
    fechaI, 
    fechaF, 
    (SELECT nombre FROM cliente WHERE idCliente = cliente LIMIT 1) AS cliente, 
    (SELECT nombre FROM usuario WHERE idUser = ocm.usuario LIMIT 1) AS usuario,
    'ocm' AS tipo
    FROM ocm WHERE 1 AND fecha > '{$dateLimit}' AND status = 2";

    $r = $this->db->query( $sql );
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);

    echo json_encode($rows);
  
  }

  public function getArticuloOC(){

    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_STRING);

    $table = $tipo === 'oc' ? 'bomoc' : 'bomocm';

    $requestData = $_POST;
    // los indices de las columnas de datatable deben coincidir conm el nombrte en la base de datos
    $columns = array(
      0 => 'unidadName',
      1 => "nombre",
      2 => 'lineaName',
      3 => "proveedorName",
      4 => "presentacion",
      5 => "factor",
      6 => "cantidad",
      7 => "costoU",
      8 => "costoT"
    );

    $totalFiltered = $totalData = 0;

    $sql = "
      SELECT unidad AS idUnidad, 
      (SELECT unidad FROM unidad WHERE idUnidad = bom.unidad LIMIT 1) AS unidadName, 
      articulo, 
      (SELECT nombre FROM articulo WHERE idArticulo = bom.articulo LIMIT 1) AS nombre,
      linea, 
      (SELECT descripcion FROM linea WHERE idLinea = bom.linea LIMIT 1) AS lineaName, 
      cantidad, 
      proveedor,
      (SELECT nombre FROM proveedor WHERE idProveedor = bom.proveedor LIMIT 1) AS proveedorName, 
      presentacion, 
      factor, 
      costoU, 
      costoT
      FROM ${table} AS bom
      WHERE OC = '{$orden}'
    ";
    $sqlCount = "SELECT COUNT(*) AS total FROM ${table} AS bom WHERE OC = '{$orden}'";

    $result = $this->db->query( $sqlCount );
    $totalData = $totalFiltered = $result->fetch_object()->total;

    // Si exiten parametros de busqueda (provenientes del cuadro de busqueda da la datatable) se aplican
    // los campos evaluados en el where se deben reemplazar por los que contenga la tabla a seleccionar
    if( ! empty( $requestData['search']['value'] ) ):
      $sqlSearch = " AND ( nombre LIKE '%{$requestData['search']['value']}%' OR unidadName LIKE '%{$requestData['search']['value']}%' OR proveedorName LIKE '%{$requestData['search']['value']}%' )";
      $sql .= $sqlSearch;
      $sqlCount .= $sqlSearch;
      $result = $this->db->query( $sqlCount );
      $totalFiltered = $result->fetch_object()->total;
    endif;

    // Es importante declarar el array colums de esa forma la datatable podrá ordenar ascendente o descendente los registros
    // start y lengt en el limit son los encargados de solicitar el numero de pagina de la data table
    $sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] ." {$requestData['order'][0]['dir']} LIMIT {$requestData['start']}, {$requestData['length']} ";
    //ejecutamos this->el query Final
    $result = $this->db->query( $sql );

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

  }


  public function getOrden( $orden ){
    $sql = "SELECT * FROM oc WHERE idOC = '{$orden}' LIMIT 1";
    $r = $this->db->query( $sql );
    if( $this->db->affected_rows > 0 )
      return $r->fetch_object();
    else
      return false;
  }

  public function getInfoOrden(){
    $oc = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);

    $orden = [];

    $sql = "SELECT (SELECT nombre FROM cliente WHERE idCliente = cliente) AS cliente, cliente as idCliente, fechaI, fechaF FROM oc WHERE idOC = '{$oc}' LIMIT 1";
    $r = $this->db->query( $sql );

    $info = $r->fetch_object();

    $dt = new DateTime($info->fechaI);
    $sem1 = $dt->format('W');
    $dt2 = new DateTime($info->fechaF);
    $sem2 = $dt2->format('W');

    $orden['fecha'] = $dt->format('Y-m-d') . ' - ' . $dt2->format('Y-m-d');
    
    $orden['semana'] = $sem1 === $sem2 ? $sem1 : "$sem1 - $sem2";

    $sql = "SELECT unidad FROM unidad WHERE cliente = '{$info->idCliente}'";
    $r = $this->db->query($sql);

    $rows = [];
    while( $row = $r->fetch_object() ){
      $rows[] = $row->unidad;
    }

    $orden['unidades'] = implode(', ', $rows);
    $orden['cliente'] = $info->cliente;
    $orden['clienteId'] = $info->idCliente;

    echo json_encode($orden);
  
  }

  public function getProveedores(){
    $sql = "SELECT idProveedor, nombre FROM proveedor ORDER BY nombre";
    $r = $this->db->query( $sql );
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);
    echo json_encode($rows);
  }

  public function getUnidadesCliente( $rtn = false ){//$rtn = return
    $cliente = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT);

    $sql = "SELECT idUnidad, unidad FROM unidad WHERE cliente = '{$cliente}' ORDER BY unidad";
    $r = $this->db->query( $sql );
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);
    if($rtn)
      return $rows;
    else
      echo json_encode($rows);
  }

  public function getItemsOC( $rtn = false ){
    $proveedorId = filter_input(INPUT_POST, 'proveedorId', FILTER_VALIDATE_INT);
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);

    // $sql = "SELECT OC, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, factor, costoU, costoT FROM bomoc WHERE OC = '{$orden}' AND proveedor = '{$proveedorId}' ORDER BY proveedor, linea, articulo, unidad";
    $sql = "SELECT OC, cliente, unidad, articulo, linea, SUM(cantidad) AS quantity, proveedor, presentacion, factor, costoU FROM bomoc WHERE OC = '{$orden}' AND proveedor = '{$proveedorId}' GROUP BY articulo, unidad ORDER BY articulo";

    // echo $sql;

    $r = $this->db->query($sql);
    $rows = [];
    while( $row = $r->fetch_object() ){

      //aqui recuperamos cada articulo
      
      $sql = "SELECT nombre, unidad FROM articulo WHERE idArticulo = '{$row->articulo}' LIMIT 1";
      $rslt = $this->db->query($sql);
      
      //si el artiulo no existe en la tabla de articulos no se coma en cuenta 
      if( $this->db->affected_rows <= 0 )
        continue;

      $rslt = $rslt->fetch_object();

      $row->artUnidad = $rslt->unidad;
      $row->nombre = $rslt->nombre;

      //y por cada articulo rescatamos su excedente
      $sql = "SELECT cantidad FROM excedente WHERE articulo = '{$row->quantity}' AND unidad = '{$row->unidad}' LIMIT 1";
      $rslt = $this->db->query($sql);
      $rslt = $this->db->affected_rows > 0 ? $rslt->fetch_object()->cantidad : 0;

      $row->quantity -= $rslt;
      $row->costoTotal = $row->quantity * $row->costoU;
      if( $row->costoTotal < 0 )
        $row->costoTotal = 0;


      if( $row->factor != 0 ){
        $row->quantity /= $row->factor;
        $row->costoU *= $row->factor;

        $row->unidadText = "{$row->presentacion} de {$row->factor} {$row->artUnidad}";
      }
      else{
        $row->unidadText = $row->artUnidad;
      }

      $row->quantity = number_format($row->quantity, 2, '.', '');

      $rows[] = $row;
    }
    // array_pop($rows);

    if( $rtn )
      return $rows;
    else
      echo json_encode($rows);
  }

  public function getArticulos( $rtn = false ){
    $proveedorId = filter_input(INPUT_POST, 'proveedorId', FILTER_VALIDATE_INT);

    $sql = "SELECT art.idArticulo, art.nombre, art.unidad, art.unidadA, art.factor, pre.precio FROM precioprov as pre inner join articulo as art on art.idArticulo = pre.articulo WHERE pre.activo = '1' AND art.activo = '1' AND pre.proveedor = '{$proveedorId}' ORDER BY art.nombre";

    $r = $this->db->query( $sql );
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);
    if($rtn)
      return $rows;
    else
      echo json_encode($rows);
  }


  public function __destruct(){
    $this->db->close();
  }



}

$Facturas = new Facturas();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($Facturas, $method) or die( 'Method not found' );

$Facturas->{$method}();//llama a la funcion existente