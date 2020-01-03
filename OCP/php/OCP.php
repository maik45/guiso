<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

//Orden de compra con presentacion
class OCP{

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

  public function getOrdenes(){
    //para no traer todas las oradenes de la base de datos lo limito a traer las del ultimo año
    $dt = new DateTime();
    $dt->sub( new DateInterval('P1Y') );
    $dateLimit = $dt->format('Y-m-d');

    $sql = "SELECT 
    id, 
    idOC, 
    fecha, 
    fechaI, 
    fechaF, 
    (SELECT nombre FROM cliente WHERE idCliente = cliente LIMIT 1) AS cliente, 
    status, 
    (SELECT nombre FROM usuario WHERE idUser = oc.usuario LIMIT 1) AS usuario
    FROM oc WHERE 1 AND fecha > '{$dateLimit}' ORDER BY idoc DESC";

    $r = $this->db->query( $sql );
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);
    echo json_encode($rows);
  
  }

  public function getOrden( $orden ){
    $sql = "SELECT * FROM oc WHERE idOC = '{$orden}' LIMIT 1";
    $r = $this->db->query( $sql );
    if( $this->db->affected_rows > 0 )
      return $r->fetch_object();
    else
      return false;
  }

  public function authOC(){
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);

    if( $this->getOrden($orden) ){

      $sql = "UPDATE oc SET status = '2' WHERE idOC = '{$orden}'";
      $this->db->query($sql);

      if( $this->db->affected_rows > 0 )
        echo toJson(1, 'La Orden de Compra se Autorizo y Cerro correctamente');
      else
        echo toJson(0, 'Se produjo un error al autorizar la Orden de Compra, por favor reintente');

    }
    else{
      echo toJson(0, 'La orden no existe o ya fue eliminada');
    }


  }

  public function reOpenOC(){
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);

    if( $this->getOrden($orden) ){

      $sql = "UPDATE oc SET status = '1' WHERE idOC = '{$orden}'";
      $this->db->query($sql);

      if( $this->db->affected_rows > 0 )
        echo toJson(1, 'La Orden de Compra se Abrio nuevamente');
      else
        echo toJson(0, 'Se produjo un error al abrir la Orden de Compra, por favor reintente');

    }
    else{
      echo toJson(0, 'La orden no existe o ya fue eliminada');
    }

  }

  public function removeOC(){
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);

    if( $this->getOrden($orden) ){

      $sql = "DELETE FROM oc WHERE idOC = '{$orden}'";
      $this->db->query($sql);

      if( $this->db->affected_rows > 0 ){
        $this->db->query("DELETE FROM bomoc WHERE oc = '{$orden}'");
        echo toJson(1, 'La Orden de Compra se Elimino Correctamente', ['drop'=> $this->db->affected_rows]);
      }
      else
        echo toJson(0, 'Se produjo un error al Eliminar la Orden de Compra, por favor reintente');

    }
    else{
      echo toJson(0, 'La orden no existe o ya fue eliminada');
    }

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

  public function getUnidadesClienteAndItemsOC(){
    $response = [];

    $response['unidades'] = $this->getUnidadesCliente(true);
    $response['items'] = $this->getItemsOC(true);

    echo json_encode($response);

  }

  public function getClientByName($name){
    $sql = "SELECT * FROM cliente WHERE nombre = '{$name}' LIMIT 1";
    $r = $this->db->query( $sql );
    if($this->db->affected_rows > 0)
      return $r->fetch_object();
    else
      return false;
  }

  public function addArticle(){
    $idArticulo = filter_input(INPUT_POST, 'idArticulo', FILTER_SANITIZE_STRING);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_STRING);
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_VALIDATE_INT);
    // $cliente = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT);

    // $cliente = $this->getClientByName($cliente);

    $dataOrden = $this->getOrden($orden);

    $dataOrden or die( toJson(0, 'La Orden de compra no existe, por favor reintente') );
    $cliente = $dataOrden->cliente;

    //CUando se actualize una orden regresa al status 1 se reabre por asi decirlo
    $sql = "UPDATE oc SET status = '1' WHERE idOC = '{$orden}'";
    $this->db->query($sql);


    //obtener por cada unidad es un insert
    $unidades = [];
    foreach ($_POST as $key => $value) {
      if( in_array($key, ['idArticulo', 'articulo', 'presentacion', 'precio', 'method', 'orden', 'proveedor', 'cliente'] ) )
        continue;

      if( $value ){//si value es un valor verdadero, osea si no es 0 o vacio
        $unidades[] = ['unidad'=> $key, 'cantidad'=> $value, 'total'=> 0];
      }
    }

    $unidades or die( toJson(0, 'No hay cantidades validas para las unidades') );//si unidades tiene elementos

    // var_dump($idArticulo, $presentacion, $precio, $orden);
    // var_dump($unidades);

    $sql = "SELECT fechaI, fechaF FROM oc WHERE idOC = '{$orden}' LIMIT 1";
    $r = $this->db->query($sql);
    $r = $r->fetch_object();
    $fechaI = new DateTime($r->fechaI);
    $fechaF = new DateTime($r->fechaF);
    $now = new DateTime();

    $sql = "SELECT unidadA, factor, linea FROM articulo WHERE idArticulo = '{$idArticulo}'";
    $r = $this->db->query($sql);
    $r = $r->fetch_object();

    $presentation = $r->unidadA;
    $factor = $r->factor;
    $linea = $r->linea;

    // var_dump($factor);
    foreach ($unidades as $unidad) {
      // var_dump($unidad);
      
      if( $factor > 0 ){
        $unidad['cantidad'] *= $factor;
        $precio /= $factor;
      }
      $unidad['total'] = $precio * $unidad['cantidad'];
    
      // var_dump($unidad);
    }

    // var_dump($unidades);
    // exit;

    $sql = "SELECT OC, articulo, proveedor FROM bomoc WHERE OC = '{$orden}' AND articulo = '{$idArticulo}' AND proveedor = '{$proveedor}'";
    $r = $this->db->query($sql);

    $this->db->affected_rows === 0 or die(toJson(0, 'El articulo ya existe en la orden de compra'));

    $conta = 0;
    foreach( $unidades as $unidad ){

      $sql = "INSERT INTO bomoc ( OC, fechaI, fechaF, hoja, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, factor, costoU, costoT, fecha ) VALUES ('{$orden}', '{$fechaI->format('Y-m-d')}', '{$fechaF->format('Y-m-d')}', 0, '{$cliente}', '{$unidad['unidad']}', '{$idArticulo}', '{$linea}', '{$unidad['cantidad']}', '{$proveedor}', '{$presentation}', '{$factor}', '{$precio}', '{$unidad['total']}', now() )";
      $this->db->query($sql);

      // $sqls[] = $sql;
      $conta += $this->db->affected_rows;

    }

    echo toJson(1, 'Se agrego el articulo a la orden de compra correctamente', ['affected'=> $conta]);

  }

  public function updateArticle(){
    $idArticulo = filter_input(INPUT_POST, 'idArticulo', FILTER_SANITIZE_STRING);
    $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_STRING);
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_VALIDATE_INT);
    // $cliente = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT);

    $dataOrden = $this->getOrden($orden);
    
    $dataOrden or die( toJson(0, 'La Orden de compra no existe, por favor reintente') );
    $cliente = $dataOrden->cliente;

    //CUando se actualize una orden regresa al status 1 se reabre por asi decirlo
    $sql = "UPDATE oc SET status = '1' WHERE idOC = '{$orden}'";
    $this->db->query($sql);
    
    //obtener por cada unidad es un insert
    $unidades = [];
    foreach ($_POST as $key => $value) {
      if( in_array($key, ['idArticulo', 'articulo', 'presentacion', 'precio', 'method', 'orden', 'proveedor', 'cliente'] ) )
        continue;

      if( $value ){//si value es un valor verdadero, osea si no es 0 o vacio
        $unidades[] = ['unidad'=> $key, 'cantidad'=> $value, 'total'=> 0];
      }
    }

    $unidades or die( toJson(0, 'No hay cantidades validas para las unidades') );//si unidades tiene elementos

    // var_dump($idArticulo, $presentacion, $precio, $orden);
    // var_dump($unidades);

    $sql = "SELECT fechaI, fechaF FROM oc WHERE idOC = '{$orden}' LIMIT 1";
    $r = $this->db->query($sql);
    $r = $r->fetch_object();
    $fechaI = new DateTime($r->fechaI);
    $fechaF = new DateTime($r->fechaF);
    $now = new DateTime();

    $sql = "SELECT unidadA, factor, linea FROM articulo WHERE idArticulo = '{$idArticulo}'";
    $r = $this->db->query($sql);
    $r = $r->fetch_object();

    $presentation = $r->unidadA;
    $factor = $r->factor;
    $linea = $r->linea;

    // var_dump($factor);
    foreach ($unidades as $unidad) {
      if( $factor > 0 ){
        $unidad['cantidad'] *= $factor;
        $precio /= $factor;
      }
      $unidad['total'] = $precio * $unidad['cantidad'];
    }

    $sql = "DELETE FROM bomoc WHERE OC = '{$orden}' AND articulo = '{$idArticulo}' AND proveedor = '{$proveedor}'";
    $r = $this->db->query($sql);

    $this->db->affected_rows > 0 or die(toJson(0, 'El articulo de la orden de compra no pudo actualizarse, por favor reintente'));

    $conta = 0;
    foreach( $unidades as $unidad ){

      $sql = "INSERT INTO bomoc ( OC, fechaI, fechaF, hoja, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, factor, costoU, costoT, fecha ) VALUES ('{$orden}', '{$fechaI->format('Y-m-d')}', '{$fechaF->format('Y-m-d')}', 0, '{$cliente}', '{$unidad['unidad']}', '{$idArticulo}', '{$linea}', '{$unidad['cantidad']}', '{$proveedor}', '{$presentation}', '{$factor}', '{$precio}', '{$unidad['total']}', now() )";
      $this->db->query($sql);

      // $sqls[] = $sql;
      $conta += $this->db->affected_rows;

    }

    echo toJson(1, 'Se Actualizo el articulo de la orden de compra correctamente', ['affected'=> $conta]);

  }

  public function removeArticle(){
    $idArticulo = filter_input(INPUT_POST, 'idArticulo', FILTER_SANITIZE_STRING);
    // $presentacion = filter_input(INPUT_POST, 'presentacion', FILTER_SANITIZE_STRING);
    $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING);
    // $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $proveedor = filter_input(INPUT_POST, 'proveedor', FILTER_VALIDATE_INT);
    // $cliente = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT);

    $dataOrden = $this->getOrden($orden);
    $dataOrden or die( toJson(0, 'La Orden de compra no existe, por favor reintente') );

    //CUando se actualize una orden regresa al status 1 se reabre por asi decirlo
    $sql = "UPDATE oc SET status = '1' WHERE idOC = '{$orden}'";
    $this->db->query($sql);

    // $cliente = $dataOrden->cliente;
    
    //obtener por cada unidad es un insert
    // $unidades = [];
    // foreach ($_POST as $key => $value) {
    //   if( in_array($key, ['idArticulo', 'articulo', 'presentacion', 'precio', 'method', 'orden', 'proveedor', 'cliente'] ) )
    //     continue;

    //   if( $value ){//si value es un valor verdadero, osea si no es 0 o vacio
    //     $unidades[] = ['unidad'=> $key, 'cantidad'=> $value, 'total'=> 0];
    //   }
    // }

    // $unidades or die( toJson(0, 'No hay cantidades validas para las unidades') );//si unidades tiene elementos

    // var_dump($idArticulo, $presentacion, $precio, $orden);
    // var_dump($unidades);

    // $sql = "SELECT fechaI, fechaF FROM oc WHERE idOC = '{$orden}' LIMIT 1";
    // $r = $this->db->query($sql);
    // $r = $r->fetch_object();
    // $fechaI = new DateTime($r->fechaI);
    // $fechaF = new DateTime($r->fechaF);
    // $now = new DateTime();

    // $sql = "SELECT unidadA, factor, linea FROM articulo WHERE idArticulo = '{$idArticulo}'";
    // $r = $this->db->query($sql);
    // $r = $r->fetch_object();

    // $presentation = $r->unidadA;
    // $factor = $r->factor;
    // $linea = $r->linea;

    // // var_dump($factor);
    // foreach ($unidades as $unidad) {
    //   if( $factor > 0 ){
    //     $unidad['cantidad'] *= $factor;
    //     $precio /= $factor;
    //   }
    //   $unidad['total'] = $precio * $unidad['cantidad'];
    // }

    $sql = "DELETE FROM bomoc WHERE OC = '{$orden}' AND articulo = '{$idArticulo}' AND proveedor = '{$proveedor}'";
    $r = $this->db->query($sql);

    $this->db->affected_rows > 0 or die(toJson(0, 'El articulo de la orden de compra no pudo eliminarse, por favor reintente'));

    // $conta = 0;
    // foreach( $unidades as $unidad ){

    //   $sql = "INSERT INTO bomoc ( OC, fechaI, fechaF, hoja, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, factor, costoU, costoT, fecha ) VALUES ('{$orden}', '{$fechaI->format('Y-m-d')}', '{$fechaF->format('Y-m-d')}', 0, '{$cliente}', '{$unidad['unidad']}', '{$idArticulo}', '{$linea}', '{$unidad['cantidad']}', '{$proveedor}', '{$presentation}', '{$factor}', '{$precio}', '{$unidad['total']}', now() )";
    //   $this->db->query($sql);

    //   // $sqls[] = $sql;
    //   $conta += $this->db->affected_rows;

    // }

    echo toJson(1, 'Se elimino el articulo de la orden de compra correctamente', ['affected'=> $this->db->affected_rows]);

  }

  public function __destruct(){
    $this->db->close();
  }



}

$OCP = new OCP();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($OCP, $method) or die( 'Method not found' );

$OCP->{$method}();//llama a la funcion existente