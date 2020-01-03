<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires

require "../../db/db.php";

class Receta{

	private $db;

	public function __construct(){
		global $db;
		$this->db = $db; 
	}

  public function updateCosto(){
    $idReceta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING) or die( toJson(0, 'El ID Receta es inválido') );
    $costo = filter_input(INPUT_POST, 'costo', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'El costo es inválido') );
    
    $this->db->query("UPDATE receta SET costo = '{$costo}' WHERE idReceta = '{$idReceta}'");

    empty( $this->db->error ) or die( toJson(0, 'Error modificando el costo', ['error'=> $this->db->error] ) );
    
    if( $this->db->affected_rows > 0 )
      echo toJson(1, 'Se actualizo el costo');
    else
      echo toJson(0, 'no se actualizo el costo');

  }


  public function actualizacionMasiva(){

    $sql = "SELECT re.idReceta, re.costo as costoReceta, re.nombre, re.porciones, reart.cantidad, art.costo, art.nombre FROM receta AS re JOIN recetaart AS reart ON re.idReceta=reart.receta JOIN articulo AS art ON art.idArticulo=reart.articulo WHERE 1";
    $r = $this->db->query($sql);

    $this->db->affected_rows > 0 or die( toJson(0, 'Error obteniendo los datos, intente nuevamente') );

    $total = 0;
    $tmp = $tmpPorcion = $tmpCosto = '';
    while( $row = $r->fetch_object() ){

      if( $tmp === '' ) $tmp = $row->idReceta;//se inicia $tmp

      //comparamso que la receta cuando sea diferente, entocnes, resetear total y cambiar temporal
      if( $tmp !== $row->idReceta ){

        //cuando sean diferentes las recetas
        //hacemos un update pero primero sacamos el costo de la receta, que seria
        $costoReceta = ( $total / $tmpPorcion );
        if( $tmpCosto === $costoReceta ){//si el cossto que voy a actualizar es igual al que tiene evito el query
          $sql = sprintf("UPDATE receta SET costo = '%01.2f', fechaMod = now() WHERE idReceta = '%s'", $costoReceta, $tmp);
          $this->db->query($sql);
        }

        $tmp = $row->idReceta;//cambiamos tmp
        $tmpPorcion = $row->porciones;
        $tmpCosto = $row->costoReceta;
        $total = 0;//reseteamos total
        $total += ( $row->costo * $row->cantidad );

      }
      else{
        //si son iguales tmp y la receta actual, sumamos los costos
        $total += ( $row->costo * $row->cantidad );
        $tmpPorcion = $row->porciones;
        $tmpCosto = $row->costoReceta;
      }

    }
    echo toJson(1, 'El proceso de actualización masiva termino satisfactoriamente');
  }

	//obtener los bases, tiempo
	public function getItems(){
		
		$data = [];

		$r = $this->db->query("SELECT idBase, descripcion FROM base WHERE activo = 1 ORDER BY descripcion");
		$rows = [];
		while( $rows[] = $r->fetch_object() );
		array_pop($rows);

		$data['base'] = $rows;
	
		$r = $this->db->query("SELECT idTiempo, descripcion FROM tiempo WHERE activo = 1 ORDER BY descripcion");
		$rows = [];
		while( $rows[] = $r->fetch_object() );
		array_pop($rows);

		$data['tiempo'] = $rows;

		$r = $this->db->query("SELECT idGrupo, descripcion FROM grupo WHERE activo = 1 ORDER BY descripcion");
		$rows = [];
		while( $rows[] = $r->fetch_object() );
		array_pop($rows);

		$data['grupo'] = $rows;
		
		$r = $this->db->query("SELECT su.idSUnidad, su.subUnidad FROM subunidad AS su WHERE activo = 1 AND LENGTH(su.subUnidad) > 5 GROUP BY su.subUnidad ORDER BY su.subUnidad");
		$rows = [];
		while( $rows[] = $r->fetch_object() );
		array_pop($rows);

		$data['subunidad'] = $rows;

		echo json_encode($data);
	}

	public function addReceta(){

		//primero verificamos que la llave no exista
		$idReceta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING) or die( toJson(0, 'El ID Receta es inválido') );
		$idReceta = strtoupper($idReceta);
		
		$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING) or die( toJson(0, 'El nombre de la receta es inválido') );
		$nombre = strtoupper($nombre);
		//verifica que la receta no existe en la base de datos, por nombre y por el ID
		$check = $this->checkIdReceta( $idReceta, $nombre );
		! $check or die( toJson(0, "La ID. receta {$idReceta} o nombre {$nombre} ya existe" ) );

		//recogemos valores
		//requeridos
		$base = filter_input(INPUT_POST, 'base', FILTER_SANITIZE_STRING) or die( toJson(0, 'La base es inválida') );
		$tiempo = filter_input(INPUT_POST, 'tiempo', FILTER_SANITIZE_STRING) or die( toJson(0, 'El tiempo es inválido') );
		$grupo = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_STRING) or die( toJson(0, 'El grupo es inválido') );
		$porciones = filter_input(INPUT_POST, 'porcion', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'La porción es inválida') );
		$gramos = filter_input(INPUT_POST, 'gramos', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'Los gramos son inválidos') );
		$calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'La calificación es inválida') );
		//no requeridos
		$elaboro = filter_input(INPUT_POST, 'elaboro', FILTER_SANITIZE_STRING);
		$autorizo = filter_input(INPUT_POST, 'autorizo', FILTER_SANITIZE_STRING);
		$observacion = filter_input(INPUT_POST, 'observacion', FILTER_SANITIZE_STRING);
		$procedimiento = filter_input(INPUT_POST, 'procedimiento', FILTER_SANITIZE_STRING);
		//subunidad es un array, asi que lo unimos
		$subunidad = $_POST['subunidad'] ? implode(',', $_POST['subunidad']) : '';

		//a Mayusculas
		$elaboro = strtoupper($elaboro);
		$autorizo = strtoupper($autorizo);

		$sql = sprintf("INSERT INTO receta (idReceta, nombre, grupo, subUnidad, base, tiempo, porciones, gramos, costo, califica, info, fecha, fechaMod, revision, procedimiento, elaboro, autorizo, activo) VALUES ( '%s', '%s', '%s', '%s', '%s', '%s', %01.2f, %01.2f, 0, %01.2f, '%s', now(), now(), 1, '%s', '%s', '%s', 1 )", $idReceta, $nombre, $grupo, $subunidad, $base, $tiempo, $porciones, $gramos, $calificacion, $observacion, $procedimiento, $elaboro, $autorizo);

		$bool = $this->db->query( $sql );
    
    empty( $this->db->error ) or die( toJson(0, 'Error al almacenar la receta, intente nuevamente', ['error'=> $this->db->error] ) );
    
    if( $this->db->affected_rows > 0 )
			echo toJson(1, 'La receta se guardo correctamente', ['idReceta'=> $idReceta]);
    else
			echo toJson(0, 'Error al guardar la receta, intente nuevamente', ['error'=> $this->db->error]);

	}

  public function updateReceta(){

    //primero verificamos que la llave no exista
    $idReceta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING) or die( toJson(0, 'El ID Receta es inválido') );
    $idReceta = strtoupper($idReceta);
    $nombre = filter_input(INPUT_POST, 'receta', FILTER_SANITIZE_STRING) or die( toJson(0, 'El nombre de la receta es inválido') );
    $nombre = strtoupper($nombre);
    //verifica que la receta no existe en la base de datos, por nombre y por el ID
    // $check = $this->checkIdReceta( $idReceta, $nombre );
    // ! $check or die( toJson(0, "La ID. receta {$idReceta} o nombre {$nombre} ya existe" ) );

    //recogemos valores
    //requeridos
    $base = filter_input(INPUT_POST, 'base', FILTER_SANITIZE_STRING) or die( toJson(0, 'La base es inválida') );
    $tiempo = filter_input(INPUT_POST, 'tiempo', FILTER_SANITIZE_STRING) or die( toJson(0, 'El tiempo es inválido') );
    $grupo = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_STRING) or die( toJson(0, 'El grupo es inválido') );
    $porciones = filter_input(INPUT_POST, 'porcion', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'La porción es inválida') );
    $gramos = filter_input(INPUT_POST, 'gramos', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'Los gramos son inválidos') );
    $calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT) or die( toJson(0, 'La calificación es inválida') );
    //no requeridos
    $elaboro = filter_input(INPUT_POST, 'elaboro', FILTER_SANITIZE_STRING);
    $autorizo = filter_input(INPUT_POST, 'autorizo', FILTER_SANITIZE_STRING);
    $observacion = filter_input(INPUT_POST, 'observacion', FILTER_SANITIZE_STRING);
    $procedimiento = filter_input(INPUT_POST, 'procedimiento', FILTER_SANITIZE_STRING);
    //subunidad es un array, asi que lo unimos
    $subunidad = $_POST['subunidad'] ? implode(',', $_POST['subunidad']) : '';

    //a Mayusculas
    $elaboro = strtoupper($elaboro);
    $autorizo = strtoupper($autorizo);

    $sql = sprintf("UPDATE receta SET grupo = '%s', subUnidad = '%s', base = '%s', tiempo = '%s', porciones = %01.2f, gramos = %01.2f, califica = %01.2f, info = '%s', fechaMod = now(), procedimiento = '%s', autorizo = '%s' WHERE idReceta = '%s' ", $grupo, $subunidad, $base, $tiempo, $porciones, $gramos, $calificacion, $observacion, $procedimiento, $autorizo, $idReceta);

    $bool = $this->db->query( $sql );
    
    empty( $this->db->error ) or die( toJson(0, 'Error al modificar la receta, intente nuevamente', ['error'=> $this->db->error] ) );
    
    if( $this->db->affected_rows > 0 )
      echo toJson(1, 'La receta se modifico correctamente', ['idReceta'=> $idReceta]);
    else
      echo toJson(0, 'Error al modificar la receta, intente nuevamente', ['error'=> $this->db->error]);

  }

	public function checkIdReceta( $receta = null, $nombre = null ){

		$receta = $receta ?: filter_input(INPUT_POST, 'receta', FILTER_SANITIZE_STRING);
		$nombre = $nombre ?: filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
		$receta or die( toJson(0, 'El id es invalido') );
		$nombre or die( toJson(0, 'El nombre es invalido') );
		$this->db->query("SELECT * FROM receta WHERE idReceta = '{$receta}' OR nombre = '{$nombre}' LIMIT 1");
		return $this->db->affected_rows > 0;
	}


	 public function getRecetas(){

    $r = $this->db->query("SELECT idReceta, nombre, porciones, gramos, info, costo, califica, base, tiempo, grupo, elaboro, autorizo, subUnidad, procedimiento,
      (SELECT descripcion FROM base WHERE idBase = base) AS asBase, 
      (SELECT descripcion FROM tiempo WHERE idTiempo = tiempo) AS asTiempo, 
      (SELECT descripcion FROM grupo WHERE idGrupo = grupo) AS asGrupo
      FROM receta WHERE activo = 1 ORDER BY nombre");

    $r or die('Error interno ');
    $rows = [];
    while( $rows[] = $r->fetch_object() );
    array_pop($rows);
    echo json_encode($rows);

  }

  public function getArticulos(){

    $receta = filter_input(INPUT_POST, 'receta', FILTER_SANITIZE_STRING);

    $sql = "SELECT ra.cantidad as cantidadRel, ar.idArticulo, ar.nombre, ar.unidad, ar.costo FROM recetaart as ra left join articulo as ar on ra.articulo = ar.idArticulo WHERE ra.receta = '{$receta}'";
    $r = $this->db->query( $sql );
    
    while( $items[] = $r->fetch_object() );
    array_pop( $items );
    echo json_encode($items);

  }

  public function deleteReceta(){

    $receta = filter_input(INPUT_POST, 'idReceta', FILTER_SANITIZE_STRING);
    $r = $this->db->query("UPDATE receta SET activo = 0 WHERE idReceta = '{$receta}'");
    
    empty( $this->db->error ) or die( toJson(0, 'Error al eliminar la receta, intente nuevamente', ['error'=> $this->db->error] ) );
    
    if( $this->db->affected_rows > 0 )
      echo toJson(1, 'La receta se elimino correctamente');
    else
      echo toJson(0, 'No se elimino ninguna receta, intente nuevamente');

  }

  public function __destruct(){
    $this->db->close();
  }



}

$Receta = new Receta();

$method = filter_input(INPUT_POST, 'method', FILTER_SANITIZE_STRING);

method_exists($Receta, $method) or die( 'Method not found' );

$Receta->{$method}();//llama a la funcion existente