<?php

require '../db/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

if( ! empty( $_FILES['file'] ) ):

  var_dump($_FILES);
  //instanciamos el objeto 
  // $spreadsheet = new Spreadsheet();
  // $sheet = $spreadsheet->getActiveSheet();

  // $rutaArchivo = "LibroParaLeerConPHP.xlsx";
  // $excel = IOFactory::load($_FILES['file']['tmp_name']);

  // echo 'Numero de hojas del documento ' . $excel->getSheetCount();

  // echo "<br>";

  // $sheet = $excel->getSheet(0);

  // $lastRows = $sheet->getHighestRow(); // Numérico
  // var_dump($lastRows);
  // $columns = ['B', 'C', 'F'];

  // for( $i = 8; $i <= $lastRows; $i++ ){

  //   $cantidad = $sheet->getCell("F{$i}")->getValue();
  //   //si la cantidad es mayor a 0, se va a actualizar en la base de datos, si no no tiene caso seguir recolectando datos
  //   if( $cantidad > 0 ){
  //     $id = $sheet->getCell("B{$i}")->getValue();
  //     $articulo = $sheet->getCell("C{$i}")->getValue();
  //     echo "id: " . $id . ' articulo: ' . $articulo . ' cantidad: '. $cantidad . '<br>';
  //   }

  // }


else:
?>

<!-- 
  <form action="" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="file" id="file" accept=".xlsx" required >
    <input type="submit" value="Upload Image" name="submit">
  </form> -->

  <form enctype="multipart/form-data" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
    <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
    <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
    Enviar este fichero: <input name="file" type="file" required accept=".xlsx" />
    <input type="submit" value="Enviar fichero" />
  </form>

<?php
endif;
?>