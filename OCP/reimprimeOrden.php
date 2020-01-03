<?php
session_start();
if( empty( $_SESSION['usuario_comedor'] ) ):
  echo "<h1 style='text-align:center;color: #af4040;position: absolute;top: 40%;left: 50%;transform: translate(-50%, -50%) skewX(15deg);font-size: 60px;'>Acceso denegado!!</h1>";
  http_response_code(403);
  exit;
endif;

define('KEY', 'JACE');

require '../db/db.php';
require '../db/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

//recupera las fechas que se desean consultar
// $client = filter_input(INPUT_POST, 'cliente', FILTER_VALIDATE_INT) or die(toJson(0, 'El cliente es inválido'));
// $start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING) or die(toJson(0, 'La fecha inicial es inválida'));
// $end = filter_input(INPUT_POST, 'end', FILTER_SANITIZE_STRING) or die(toJson(0, 'La fecha final es inválida'));
// $orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING) or die(toJson(0, 'La orden es inválida'));

$orden = filter_input(INPUT_POST, 'orden', FILTER_SANITIZE_STRING) or die(toJson(0, 'La orden es inválida'));

$sql = "SELECT cliente, fechaI, fechaF FROM oc WHERE idOC = '{$orden}' LIMIT 1";
// echo $sql;
$r = $db->query($sql);
$db->affected_rows > 0 or die( toJson(0, 'Hubo un error al generar el reporte, por favor reintente elaborando otra OC') );

$r = $r->fetch_object();
$client = $r->cliente;
$dt = new DateTime($r->fechaI);
$start = $dt->format('Y-m-d');
$sem1 = $dt->format('W');
$dt = new DateTime($r->fechaF);
$end = $dt->format('Y-m-d');
$sem2 = $dt->format('W');

$uidUser = $_SESSION['uid_comedor'];

// $dt = new DateTime($start);
// $sem1 = $dt->format('W');
// $dt = new DateTime($end);
// $sem2 = $dt->format('W');
$semana = $sem1 === $sem2 ? $sem1 : "$sem1 - $sem2";

$nameClient = $db->query("SELECT nombre FROM cliente WHERE idCliente = '{$client}' LIMIT 1");
$nameClient = $nameClient->fetch_object()->nombre;

//dice que trae toda la informacion de menu que corresponda al rango de fecha
// $sql = "SELECT me.idMenu, me.unidad, (SELECT unidad FROM unidad WHERE idUnidad = me.unidad) AS unidadName, mr.receta, mr.fecha, me.grupo, mr.personas, mr.pos, mr.precio FROM menu as me inner join menurec as mr on me.idMenu = mr.idMenu WHERE ( date(mr.fecha) between '{$start}' AND '{$end}' ) AND me.activo = 1 AND me.cliente = '{$client}'";
// $r = $db->query($sql);

// $db->affected_rows > 0 or die('No hay información en ese rango de fechas para generar la orden');

$articulosVendidos = [];
$proveedores = [];
// while( $menu = $r->fetch_object() ){

  //el menu aqui se duplica ya que trae la relacion de los menus con las recetas, osea trae la correspondencia de menu con menurec, el idMenu se puede repetir pero el campo receta siempre es diferente

  // en menu tengo disponibles las propiedades
  //idMenu (String)
  //unidad (String) //numerico unidad del cliente
  //unidadName (String) //nombre de la unidad del cliente
  //receta (String) //nombre de receta
  //fecha (string) //datetime
  //grupo (String) //numerico
  //personas (float)
  //pos (int)
  //precio (float)
  //cliente (int) //este ya no esta disponible

  //en menu debo consultar la receta con la tabla receta por el campo menu.receta = receta.nombre
  //despues que trae el idReceta vuelve a traer las porciones de la tabla de recetas.

  // $sql = "SELECT re.idReceta, re.porciones, reart.cantidad, art.idArticulo, art.nombre, art.linea, art.unidad as artUnidad, art.unidadA, art.costo, art.factor FROM receta AS re JOIN recetaart AS reart ON reart.receta=re.idReceta JOIN articulo AS art ON art.idArticulo=reart.articulo WHERE re.nombre = '{$menu->receta}'";
  // $itemsReceta = $db->query($sql);
  
  // if( $db->affected_rows <= 0 )
    // continue;//si la query no trajo nada, saltamos al siguiente elemento de menu

  //aqui tenemos los articulo de la receta que se le asigno al menu
  
  $items = $db->query("SELECT *, (SELECT nombre FROM articulo WHERE idArticulo = articulo LIMIT 1) AS nombre FROM bomoc WHERE 1 AND OC = '{$orden}'");
  
  // $items = $db->query("SELECT COUNT(*) AS total FROM bomoc WHERE 1 AND OC = '{$orden}'");

  // var_dump( $items->fetch_object()->total );

  // exit;

  // "OC"  "varchar(50)" "YES" "MUL" \N  ""
  // "fechaI"  "datetime"  "YES" "MUL" \N  ""
  // "fechaF"  "datetime"  "YES" "MUL" \N  ""
  // "hoja"  "int(11)" "YES" ""  \N  ""
  // "cliente" "int(11)" "YES" ""  \N  ""
  // "unidad"  "varchar(50)" "YES" ""  \N  ""
  // "articulo"  "varchar(50)" "YES" ""  \N  ""
  // "linea" "varchar(50)" "YES" ""  \N  ""
  // "cantidad"  "float" "YES" ""  \N  ""
  // "proveedor" "int(11)" "YES" ""  \N  ""
  // "presentacion"  "varchar(150)"  "YES" ""  \N  ""
  // "factor"  "float" "YES" ""  \N  ""
  // "costoU"  "float" "YES" ""  \N  ""
  // "costoT"  "float" "YES" ""  \N  ""
  // "fecha" "datetime"  "YES" ""  \N  ""
  // "nombre" "STRING"  "YES" ""  \N  ""

  // while( $articulo = $itemsReceta->fetch_object() ){
  while( $articulo = $items->fetch_object() ){

    // $cantidad = $articulo->cantidad;//sale de recetaart

    // $cantidad = ( $articulo->cantidad / $articulo->porciones ) * $menu->personas;
    // $cantidad = $articulo->cantidad;
    // $costoU = $articulo->costo;
    // $costoT = $articulo->costoU * $cantidad;

    //despues qui hace otro query para recuperar el proveedor del articulo
    $sql = "SELECT proveedor FROM precioprov WHERE articulo = '{$articulo->articulo}' AND precio = '{$articulo->costoU}' LIMIT 1";
    $proveedorResult = $db->query($sql);
    
    if( $db->affected_rows <= 0 )
      continue;

    $proveedorId = $proveedorResult->fetch_object()->proveedor;
    // $proveedorName = $proveedorResult->nombre;
    // $proveedorId = $proveedorResult->proveedor;

    // $sql = "INSERT INTO bomoc (OC, fechaI, fechaF, hoja, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, factor, costoU, costoT, fecha) VALUES ('{$orden}', '{$start}', '{$end}', '0', '{$client}', '{$menu->unidad}', '{$articulo->idArticulo}', '{$articulo->linea}', '{$cantidad}', '{$proveedorId}', '{$articulo->unidadA}', '{$articulo->factor}', '{$articulo->costo}', '{$costoT}', now() )";

    // $db->query($sql);

    // ESTE CODIGO ERA FUNCIONAL PERO LO DEJO COMO ESTABA EN EL ATERIOR PROGRAMA
    $r = $db->query("SELECT unidad as unidadName FROM unidad WHERE idUnidad = '{$articulo->unidad}' LIMIT 1");

    $articulo->unidad = $articulo->unidad;
    $articulo->unidadName = $db->affected_rows > 0 ? $r->fetch_object()->unidadName : '';
    // $articulo->proveedor = $proveedorName;
    $articulo->proveedorId = $proveedorId;
    $articulo->costoT = $articulo->costoT;
    $articulo->cantidadCalc = $articulo->cantidad;
    // $articulo->personas = $menu->personas;
    // $articulo->items = 1;

    //array con todos los articulos vendidos en el menu a ese cliente
    
    //voy agrupar los articulos por cantidad
    // si el proveedor existe en el array

    if( array_key_exists( $proveedorId, $articulosVendidos ) ){
      if( array_key_exists($articulo->unidad, $articulosVendidos[$proveedorId]) ){//si existe la unidad en el proveedor
        if( array_key_exists( $articulo->articulo, $articulosVendidos[$proveedorId][$articulo->unidad] ) ){
          //si existe acumulalo
          $articulosVendidos[$proveedorId][$articulo->unidad][$articulo->articulo]->cantidadCalc += $articulo->cantidadCalc;
        }
        else{
          //si no existe el articulo en la unidad agregalo
          $articulosVendidos[$proveedorId][$articulo->unidad][$articulo->articulo] = $articulo;
        }
      }
      else{
        //si no existe la unidad en el proveedor, lo agregamos
        $articulosVendidos[$proveedorId][$articulo->unidad][$articulo->articulo] = $articulo;
      }
    }
    else{
      // si el proveedor no existe lo añadimso 
      $articulosVendidos[$proveedorId][$articulo->unidad][$articulo->articulo] = $articulo;
    }

    /*
    
      $array = [
        'proveedorId'=> [
          'unidadID'=> [
            'idArticulo'=> {}
            'idArticulo'=> {}
          ],
          'unidadID'=> [
            'idArticulo'=> {}
            'idArticulo'=> {}
          ]
        ],

      ];

    */
    
    $unidades[$articulo->unidad] = ['id'=> $articulo->unidad, 'name'=> $articulo->unidadName];

  }//endWhileReceta

// }//endWhileCliente

// var_dump($proveedores);

// echo "<pre>";
// var_dump($articulosVendidos);

// exit;


function headerExcel( $data, &$indexRow ){
  global $sheet, $orden, $semana, $start, $end;

  // $data = proveedorId, proveedorName, (array) unidades, clienteName, clienteId

  $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  $drawing->setName('Logo');
  $drawing->setDescription('Logo');
  $drawing->setPath('../img/logo_guisopak.png');
  $drawing->setHeight(55);
  $drawing->setCoordinates('A1');
  // $drawing->setOffsetX(10);
  
  $sheet->mergeCells("A1:A2");
  //add logo
  $drawing->setWorksheet($sheet);

  //necesito saber cuantas unidades son, y a partir de ahi unidad 1 = D, unidad 2 = E, unidad3 = F unidad4 = G , y asi 

  //esto funcionara siempre y cuando no existan mas de 23 unidades en el rango de fechas, si pasa eso no mostrare las demas
  $columns = ['D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

  $sizeUnidades = count($data->unidades) + 1;//el mas uno, es de mi ultima columna que sera total
  $columnsUnidades = [];
  for( $i=0; $i < $sizeUnidades && $i < 22; $i++ ){
    $columnsUnidades[] = $columns[$i];
  }

  $columnsSheet = array_merge( ['A', 'B', 'C'], $columnsUnidades );
  $titles = ['A'=> 'Producto', 'B'=> 'Presentación', 'C'=> 'Precio'];
  $j = 0;
  foreach ($data->unidades as $key => $unidad) {
    $titles[ $columnsUnidades[$j] ] = $unidad['name'];
    $j++;
  }
  $titles[ end($columnsUnidades) ] = 'Total';


  //columnsSheet es el array de letras
  //columnsUnidades es un array que tiene las diferentes unidades en el periodo, es associativo (idUnidad=> ['id'=> idUnidad, 'name'=> nombre])
  //titles, el arrray con pares letra => texto

  //la ultima letra de mis colunas sera lo que devuelva $columnsSheet
  $endLetter = end($columnsSheet);

  // //titulo
  $sheet->mergeCells("B{$indexRow}:{$endLetter}{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "GUISOPAK");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

  $indexRow++;
 
  $sheet->mergeCells("B{$indexRow}:{$endLetter}{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", "ORDEN DE COMPRA");
  $sheet->getStyle("B{$indexRow}")->getFont()->setBold(true)->setSize(14);
  $sheet->getStyle("B{$indexRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
  $sheet->getStyle("B{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('EE7561');

  // //cliente
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Orden:");//semana
  $sheet->mergeCells("B{$indexRow}:C{$indexRow}");
  $sheet->setCellValue("B{$indexRow}", $orden);//semana

  // $indexRow++;
  $sheet->setCellValue("D{$indexRow}", "Semana:");//semana
  $sheet->setCellValue("E{$indexRow}", $semana);//semana

  $indexRow++;
  $sheet->setCellValue("D{$indexRow}", "Fecha:");//semana
  $sheet->setCellValue("E{$indexRow}", "$start - $end");//semana

  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Cliente:");
  $sheet->setCellValue("B{$indexRow}", $data->clienteName .'/'.$data->clienteId);

  // //unidades
  $indexRow++;
  $sheet->setCellValue("A{$indexRow}", "Unidades:");
  $sheet->setCellValue("B{$indexRow}", implode(', ', array_column($data->unidades, 'name' ) ) );

  $indexRow++;
  $three = $indexRow + 2;
  $sheet->mergeCells("A{$indexRow}:{$endLetter}{$three}");
  $sheet->setCellValue("A{$indexRow}", 'Especificaciones: Todos los productos y facturas deben ser aprobadas en este formulario. Cada responsable debe firmar las líneas correspondientes y dar fe de que día dado es verdadero y correcto antes de pasar la ORDEN a la siguiente persona');
  $sheet->getStyle("A{$indexRow}")->getAlignment()->setWrapText(true);

  $indexRow += 3;
  
  $sheet->setCellValue("A{$indexRow}", "Proveedor:");
  $sheet->setCellValue("B{$indexRow}", $data->proveedorName .'/'.$data->proveedorId);

  $indexRow+=2;

  $sheet->getStyle("A{$indexRow}:{$endLetter}{$indexRow}")->getFont()->setBold(true);
  $sheet->getStyle("A{$indexRow}:{$endLetter}{$indexRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('33FF64');

  foreach ($titles as $key => $title){
    $sheet->getColumnDimension($key)->setWidth(16);
    $sheet->setCellValue("{$key}{$indexRow}", "$title");
  }

  $sheet->getStyle("A{$indexRow}:{$endLetter}{$indexRow}")->getAlignment()->setWrapText(true);

  $indexRow ++;

  return $titles;
}

//por cada proveedor hace una hoja

//articulosVendidos ya esta agrupados por proveedores
//cada proveedor es una hoja de excel

// instanciamos el objeto 
$spreadsheet = new Spreadsheet();
$hoja = 0;

// echo "<pre>";
// var_dump($articulosVendidos);
$itemsToExcel = [];

foreach ($articulosVendidos as $key => $proveedor) {

  //cada proveedor genera una hojas de excel

  if( $hoja !== 0 )
    $spreadsheet->createSheet();//crea una nueva hoja de calculo

  //establecemos la hoja de calculo activa
  $spreadsheet->setActiveSheetIndex( $hoja );
  $sheet = $spreadsheet->getActiveSheet();//recuperamos esa hoja activa
  $hoja++;

  $indexRow = 1;

  // //seleccionamos el nombre del proveedor
  $r = $db->query("SELECT nombre FROM proveedor WHERE idProveedor = '{$key}' LIMIT 1");
  $proveedorName = $db->affected_rows > 0 ? $r->fetch_object()->nombre : 'OTROS';

  // var_dump($key, $proveedorName);
  $metaData = new stdClass();
  $metaData->proveedorId = $key;
  $metaData->proveedorName = $proveedorName;
  $metaData->clienteName = $nameClient;
  $metaData->unidades = $unidades;
  $metaData->clienteId = $client;

  $columnsSheet = headerExcel($metaData, $indexRow);

  //esta contiene
  // ['A'=> 'articulo', 'B'=> 'presentacion', 'C'=> 'precio', 'D'=> 'unidadName', 'E'=> 'unidadName', 'N'=> 'unidadanameN'...., 'N + 1'=> 'total'];

  $itemsToDraw = [];
  foreach ($proveedor as $unidadesProveedor) {    
 
    //entonces diria que del proveedor uno tengo un array de las unidades a las que le surtio y en esas unodades tengo el articulo, ya acumulado sus cantidades

    //entonces tengo que hacer otro array, con costos de cada unidad por articulo//DESCARTADO

    foreach ($unidadesProveedor as $articulo) {
      
      //sobre cada articulo calculamos su costo

      // ["idReceta"]=> string(5) "08001" 
      // ["porciones"]=> string(3) "100" 
      // ["cantidad"]=> float(4.5) 
      // ["idArticulo"]=> string(4) "5056" 
      // ["nombre"]=> string(14) "Canela en rama" 
      // ["linea"]=> string(1) "5" 
      // ["artUnidad"]=> string(10) "KILOGRAMOS" 
      // ["unidadA"]=> string(0) "" 
      // ["costo"]=> string(3) "141" 
      // ["factor"]=> string(1) "0" 
      // ["unidad"]=> string(2) "01" 
      // ["unidadName"]=> string(15) "CERESO TLAXCALA" 
      // ["proveedorId"]=> string(3) "128" 
      // ["costoT"]=> float(239.7) 
      // ["cantidadCalc"]=> float(1.7) 
      // ["personas"]=> string(3) "340" 
      
      $sql = "SELECT cantidad FROM excedente WHERE articulo = '{$articulo->articulo}' AND unidad = '{$articulo->unidad}' LIMIT 1";
      $exd = $db->query($sql);
      $exd = $db->affected_rows > 0 ? $exd->fetch_object()->cantidad : 0;

      $cantidad = $articulo->cantidadCalc - $exd;
      $costoT = $articulo->costoU * $cantidad;

      if( $costoT < 0 ) $costoT = 0;//si el costo es negativo lo igualamos a 0

      //ESTA ES LA DIFERENCIA qUE ENCUENTRO EN OC con PRESENTACION

      if( $articulo->factor != 0 ){
        $cantidad = ( $cantidad / $articulo->factor );
        $articulo->costoU *= $articulo->factor;
      }
      //tengo que poner en el excel
      //articulo nombre, presentacion, precio, unidadN....., total(suma de unidades)

      //debo verificar que si existe el articulo, entonces ahora buscamos si existe la unidad, y si existe la unidad acumulamos los valores
      //si no existe la unidad agregamos ese valor y esa unidad
      if( array_key_exists($articulo->articulo, $itemsToDraw) ){

        if( array_key_exists( $articulo->unidadName, $itemsToDraw[$articulo->articulo] ) ){
          //si existe esa unidad en el array asocc acumulamos valores
          $itemsToDraw[$articulo->articulo][$articulo->unidadName] += $cantidad;
        }
        else{
          //si no existe esa unodad en el articulo lo agregamos
          $itemsToDraw[$articulo->articulo][$articulo->unidadName] = $cantidad;
        }

      }
      else{
        $art = [];
        $art['articulo'] = $articulo->nombre;

        //TAMBIEN AQUI ESTA ALGO DIFENTE EN PRESENTACION
        $artUnidad = $db->query("SELECT unidad FROM articulo WHERE idArticulo = '{$articulo->articulo}' LIMIT 1");
        $articulo->artUnidad = $db->affected_rows > 0 ? $artUnidad->fetch_object()->unidad : 'OTROS'; 

        if( $articulo->factor == 0 )
          $art['presentacion'] = $articulo->artUnidad;
        else
          $art['presentacion'] = "$articulo->presentacion de $articulo->factor $articulo->artUnidad";

        $art['precio'] = $articulo->costoU;
        // $art['factor'] = $articulo->costo;

        $art[$articulo->unidadName] = $cantidad;
        
        $itemsToDraw[$articulo->articulo] = $art;
      
      }

    }

  }

  // var_dump($itemsToDraw);
  ///ya cree las filas de cada articulo y las sumatorias de las unidades entonces una vez que tengo solo me falta dibujarlo, que ya es lo mas facil

  foreach ($itemsToDraw as $key2 => $value){

    //value es esto, un array asociativo
    // array(6) {
    //   ["articulo"]=>
    //   string(21) "Tortilla de maiz INDT"
    //   ["presentacion"]=>
    //   string(0) ""
    //   ["precio"]=>
    //   string(3) "8.5"
    //   ["CERESO TLAXCALA"]=>
    //   float(76.5)
    //   ["CERESO APIZACO"]=>
    //   float(76.5)
    //   ["TUTELAR APIZACO"]=>
    //   float(76.5)
    // }

    //$columnsSheet tiene en este momento la forma
    // ['A'=> 'articulo', 'B'=> 'presentación', 'C'=> 'precio', 'D'=> 'CEREZO TLAXCALA', 'E'=> 'CEREZO APIZACO', 'F'=> 'TUTELAR TLAXCALA', 'G'=> 'total'];

    $sheet->setCellValue("A{$indexRow}", $value['articulo']);
    $sheet->setCellValue("B{$indexRow}", $value['presentacion']);
    $sheet->setCellValue("C{$indexRow}", $value['precio']);

    $last = 'Z';//por si fallara
    foreach ($columnsSheet as $AxisY => $title) {
      
      //entonces en $value busco las claves que esten en $columns, a excepcion de articulo, presenteción y precio
      if( in_array($title, ['Producto', 'Presentación', 'Precio'] ) )
        continue;
      //no hacemos nada cuando el eje y sea igual a alguno de esos ya que ya los puse arriba
     
      //pero tambien cuando title sea Total, estamos en la ultima columna entonces ahi aplicamos la formula 
      //sabemos que siempre empieza en D, y donde acaba es el problema, pero tenemos AxisY, que es la letra de la ultima columna, entonces a esa letra le restamos uno en ASCII, y otenemso la ultima letra de unidades
      if( $title === 'Total' ){

        $a = ord($AxisY);//convertimos a su numero ascii
        $last = chr(--$a);//le restamos uno y lo convertimos a caracter otra vez
        //colocamos la formula para sumar
        $sheet->setCellValue("{$AxisY}{$indexRow}", "=SUM(D{$indexRow}:{$last}{$indexRow})*C{$indexRow}" );
        continue;

      }

      //pero cuando sean diferentes, debo rescatar ese ejey y buscarlo en value
      $sheet->setCellValue("{$AxisY}{$indexRow}", empty($value[$title]) ? '' : $value[$title] );

    }
  
    $sheet->getStyle("A{$indexRow}:{$last}{$indexRow}")->getAlignment()->setWrapText(true);

    $indexRow++;

  }


}

header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-disposition: attachment; filename=OC $orden con Presentacion $start - $end.xlsx");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

