<?php
session_start();

! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires
require "../db/db.php";

require '../db/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

echo '<link href="../css/bootstrap.min.css" rel="stylesheet">';

! empty($_FILES) or die('<p class="text-danger">No se subio ningun archivo</p>');

$allow = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];

in_array( $_FILES['file']['type'], $allow ) or die('<p class="text-danger">El archivo no es una extensión permitida</p>');

// $rutaArchivo = "LibroParaLeerConPHP.xlsx";
$excel = IOFactory::load($_FILES['file']['tmp_name']);

$sheet = $excel->getSheet(0);//obtener solo la primera hoja de excel


//recuperamos la unidad y el cliente
//recuperamos la unidad y el cliente
$cliente = $sheet->getCell('B3')->getValue();
$unidad = $sheet->getCell('B4')->getValue();

$clientArry = explode('/', $cliente);
$unitArry = explode('/', $unidad);

$db->query("SELECT unidad.unidad, cliente.nombre FROM unidad JOIN cliente ON cliente.idCliente=unidad.cliente WHERE unidad.idUnidad = '{$unitArry[1]}' AND cliente.idCliente = '{$clientArry[1]}' LIMIT 1");

$db->affected_rows > 0 or die('<p class="text-danger">El cliente es invalido, por favor intente nuevamente</p>');

$lastRows = $sheet->getHighestRow(); // Numérico, obtener la fila mas alta
// $columns = ['B', 'C', 'F']; estas columnas son las que ocupamos, son idArticulo y F debe ser un entero.

for( $i = 7; $i <= $lastRows; $i++ ){

  $cantidad = $sheet->getCell("F{$i}")->getValue();
  //si la cantidad es mayor a 0, se va a actualizar en la base de datos, si no no tiene caso seguir recolectando datos
  if( $cantidad > 0 ){
    $id = $sheet->getCell("B{$i}")->getValue();
    $articulo = $sheet->getCell("C{$i}")->getValue();

    //primero vemos que el idArticulo exista
    $r = $db->query("SELECT idArticulo, linea FROM articulo WHERE idArticulo = '{$id}' LIMIT 1");
    if( $db->affected_rows <= 0 ){
      //el articulo no existe
      echo "<p class='text-danger'>El articulo con id $id y nombre $articulo no existe <p>";
      continue;
    }

    $linea = $r->fetch_object()->linea;//obtenemos linea

    //verificamos si existe ese excedente, si existe hacemos update si no existe hacemos insert
    $r = $db->query("SELECT cantidad FROM excedente WHERE unidad = '{$unitArry[1]}' AND articulo = '{$id}'");

    if( $db->affected_rows > 0 ){//update
      $cantidadDB = $r->fetch_object()->cantidad;
      if( $cantidad != $cantidadDB ){//si son diferentes actualizamos
        $sql = "UPDATE excedente SET cantidad = '{$cantidad}', fecha = now() WHERE unidad = '{$unitArry[1]}' AND articulo = '{$id}'";
        $db->query($sql);
        if( $db->affected_rows > 0 )
          echo "<p class='text-success'>Articulo $articulo($id), cantidad actualizada de $cantidadDB a $cantidad <p>";
        else
          echo "<p class='text-danger'>Articulo $articulo($id), error al actualizar cantidad de $cantidadDB a $cantidad <p>";
      }
      else{
        echo "<p class='text-info'>Articulo $articulo($id) con cantidad $cantidad, ya registrado <p>";
        continue;
      }
    }
    else{//insert
      $sql = "INSERT INTO excedente (cliente, unidad, articulo, linea, cantidad, fecha) VALUES('{$clientArry[1]}', '{$unitArry[1]}', '{$id}', '{$linea}', '{$cantidad}', now() )";
      $db->query($sql);
      if( $db->affected_rows > 0 )
        echo "<p class='text-success'>Articulo $articulo($id) con cantidad $cantidad, registrado <p>";
      else
        echo "<p class='text-danger'>Articulo $articulo($id) con cantidad $cantidad, error, no se pudo registrar <p>";
    }

  }//if cantidad

}