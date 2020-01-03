<?php
defined('KEY') or die('Script not Allowed DB');

require "config.db.php";

$db = new mysqli(HOST, USER, PASS, DB_NAME);

/*
 * Esta es la forma OO "oficial" de hacerlo,
 * AUNQUE $connect_error estaba averiado hasta PHP 5.2.9 y 5.3.0.
 */
if ($db->connect_error) {
  die('Error de Conexión (' . $db->connect_errno . ') '
          . $db->connect_error);
}
//set utf-8
$db->set_charset("utf8");


function toJson($status, $msg, $extra = [] ){

	$data = ['status'=> $status, 'msg'=> $msg];
	if( $extra ){
		$data = array_merge($data, $extra);
	}
	return json_encode( $data );
}

function object_sorter($clave,$orden=null) {
  return function ($a, $b) use ($clave,$orden) {
    $result = ($orden=="DESC") ? strnatcmp($b->$clave, $a->$clave) :  strnatcmp($a->$clave, $b->$clave);
    return $result;
  };
}