<?php
session_start();

define('KEY', 'JACE');//llave para mi script de base de datos

require 'db.php';

$user = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING) or die( toJson(0, 'Las credenciales son invalidas') );
$pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING) or die( toJson(0, 'Las credenciales son invalidas') );

$r = $db->query("SELECT idUser, usuario, nombre, telefono, rol, direccion FROM usuario WHERE usuario = '{$user}' AND password = '{$pass}' LIMIT 1");
//si no hubo errores en el query
if( ! $db->error ){
  //verificamos que nos retorne un registro
  if( $r->num_rows > 0 ){
    $row = $r->fetch_object();
    $_SESSION['usuario_comedor'] = $row->usuario;
    $_SESSION['nombre_comedor'] = $row->nombre;
    $_SESSION['telefono_comedor'] = $row->telefono;
    $_SESSION['rol_comedor'] = $row->rol;
    $_SESSION['direccion_comedor'] = $row->direccion;
    $_SESSION['uid_comedor'] = $row->idUser;
    echo toJson(1, 'Credenciales Correctas, ingresando al sistema');
  }
  else{
    echo toJson(0, 'Las credenciales son incorrectas');
  }
}
else{
  echo toJson(0, 'Error interno, reintente');
}