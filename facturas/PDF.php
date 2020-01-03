<?php
session_start();
// namespace Nominas;
! empty( $_SESSION['usuario_comedor'] ) or die('Script not allowed SESSION');//verificamos que existe la sesion

define('KEY', 'JACE');//varibale para mis includes, requires
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

require '../db/vendor/autoload.php';//cargamos librerias
require "../db/db.php";
// require 'php/utils/miAutoload.php';//cargamos mis clases

use NumberToWords\NumberToWords;

/**
 * 
 */
class PDF extends TCPDF{
  
  private $empresa;
  private $conceptos;
  private $receptor;
  private $tfd;

  private $path;

  public function setData( $empresa, $receptor, $conceptos, $timbrado ){

    $this->empresa = $empresa;
    $this->conceptos = $conceptos;
    $this->receptor = $receptor;
    $this->tfd = $timbrado;

  }

  // public function setPath( $path ){
  //   $this->path = $path;
  // }

  //Page header
  public function Header() {
      // Logo
      $this->Image('logo.png', 15, 15, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      // if( $this->empresa->rfc !== 'IKA130321UU6' ){
        // $this->Image('logo.png', 15, 15, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // $this->SetAlpha(0.2);
        // $this->Image('logo.png', 40, 50, 150, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // $this->SetAlpha(1);
      // }
      // else{
      //   $this->Image('logokd.jpg', 15, 15, 30, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      //   $this->SetAlpha(0.2);
      //   $this->Image('logokd.jpg', 40, 50, 150, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
      //   $this->SetAlpha(1);
      // }
      
      // Set font
      $this->SetFont('', 'B', 8);
      // Title
      // $this->Cell(0, 15, 'Recibo de pago de nómina', 1, false, 'R', 0, '', 0, false, 'M', 'M');
      $this->SetXY( 50, 10 );
      $this->Cell( 0, 0, 'Nombre: ' . $this->empresa->nombre, 0, 1 );
      $this->SetX( 50 );
      $this->Cell( 0, 0, 'RFC: ' . $this->empresa->rfc, 0, 1 );
      $this->SetX( 50 );
      $this->MultiCell( 0, 0, 'Dirección: ' . $this->empresa->direccion, 0, 'L', 0, 1 );
      $this->SetX( 50 );
      $this->Cell( 0, 0, 'Régimen Fiscal: '. $this->empresa->regimen_fiscal .' ', 0, 1 );
      // $this->SetX( 50 );
      // $this->Cell( 0, 0, 'Registro Patronal: ' . $this->empleado->registro_patronal, 0, 1 );

      // $this->SetFont('', 'B', 7);
      $this->SetX( 50 );
      $this->Cell( 70, 0, 'Folio: ' . $this->tfd->folio, 0, 0 );
      $this->Cell( 0, 0, 'Serie: ' . $this->conceptos->serie, 0, 1 );

      $this->setCellPadding( 1 );
      $this->SetFont('', '', 6);
      
      $this->SetXY( 50, 33 );
      $this->SetX( 50 );
      $this->Cell( 70, 0, 'FOLIO FISCAL', 1, 0 );
      $this->Cell( 0, 0, 'EFECTO DE COMPROBANTE', 1, 1 );

      $this->SetX( 50 );
      $this->Cell( 70, 0, 'No DE SERIE DEL CERTIFICADO DEL SAT', 1, 0 );
      $this->Cell( 0, 0, 'FECHA Y HORA DE CERTIFICACIÓN', 1, 1 );

      $this->SetX( 50 );
      $this->Cell( 70, 0, 'No DE SERIE DEL CERTIFICADO DEL CSD', 1, 0 );
      $this->Cell( 0, 0, 'FECHA Y HORA DE EMISIÓN DEL CFDI', 1, 1 );

      $this->SetFont('', 'B', 6);
      $this->SetXY( 50, 33 );
      $this->Cell( 70, 0, $this->tfd->success->UUID, 0, 0, 'R' );
      $this->Cell( 0, 0, 'Nómina', 0, 1, 'R' );

      $this->SetX( 50 );
      $this->Cell( 70, 0, $this->tfd->success->numSerieSAT, 0, 0, 'R' );
      $this->Cell( 0, 0, $this->tfd->success->fechaCFDI, 0, 1, 'R' );

      $this->SetX( 50 );
      $this->Cell( 70, 0, $this->tfd->noCertificado, 0, 0, 'R' );
      $this->Cell( 0, 0, $this->tfd->fecha, 0, 1, 'R' );

      ///////////////////////////////
      // mi limite de altura es 70 //
      ///////////////////////////////
  }

  // Page footer
  public function Footer() {

    // Text($x, $y, $txt, $fstroke=false, $fclip=false, $ffill=true, $border=0, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M', $rtloff=false)
    // //MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)
    // //Cell     ($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
    
    $ntw = new NumberToWords();
    // $numTran = $ntw->getNumberTransformer('es');
    $currTran = $ntw->getCurrencyTransformer('es');

    $this->setCellPadding( 1 );
    $this->SetFont('', '', 6.5);

    $this->SetY( -100 );
    $this->MultiCell( 120, 12, "CANTIDAD CON LETRA\n". strtoupper( $currTran->toWords( ( $this->conceptos->total_transferencia  * 100 ), 'MXN') ) . ' 00/100 M.N.', 1, 'L', 0, 0 );
    
    $this->SetFont('', 'B', 6.5);
    $this->MultiCell( 30, 12, "SUBTOTAL\IVA\nTOTAL", 1, 'R', 0, 0 );
    $this->SetFont('', '', 6.5);
    $this->MultiCell( 0, 12, '$'.number_format( $this->conceptos->total_percepciones, 2, '.', ',' )."\n".'- $'.number_format( $this->conceptos->total_deducciones, 2, '.', ',' )."\n".'$'.number_format( $this->conceptos->total_transferencia, 2, '.', ',' ), 1, 'R', 0, 1 );

    $this->SetY( -87 );
    $this->MultiCell( 120, 20, "SELLO DIGITAL DEL SAT\n{$this->tfd->success->selloSAT}", 1, 'L', 0, 1 );
    
    $this->SetY( -66 );
    $this->MultiCell( 120, 20, "SELLO DIGITAL DEL CFDI\n" . $this->tfd->success->selloCFDI, 1, 'L', 0, 1 );
    
    $this->SetY( -45 );
    $this->MultiCell( 120, 25, "CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACIÓN DEL SAT\n{$this->tfd->success->cadenaOriginal}", 1, 'L', 0, 1 );

    $this->Cell( 0, 0, 'Este documento es una representación impresa de un CFDI', 0 );
    $style = array(
      'border' => false,
      'padding' => 0,
    );
    $fe = substr($this->tfd->success->selloCFDI, -8);
    $total = $this->twoDec( $this->twoDec( $this->conceptos->total_percepciones) - $this->twoDec( $this->conceptos->total_deducciones) );
    $this->write2DBarcode("https://verificacfdi.facturaelectronica.sat.gob.mx/default.aspx?re={$this->empresa->rfc}&rr={$this->receptor->RFC}&tt={$total}&id={$this->tfd->success->UUID}&fe={$fe}", 'QRCODE,H', 145, 215, 40, 40, $style, 'N');
    

    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('', 'I', 7);
    // Page number
    $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');

  }

  public function twoDec($val){
    return number_format($val, 2, '.', '');
  }

  public function build_PDF(){

    //meta datos
    // $this->SetCreator( 'Microtecnologías Moviles' );
    // $this->SetAuthor( 'Microtecnologías Moviles' );
    // $this->SetTitle( 'Recibo de Nómina' );
    // $this->SetTitle( 'Recibo de Nómina' );
    // $this->SetKeywords( 'Recibo de Nómina, Nomina, Nómina, Recibo de pago, quincena' );

    $this->SetMargins(PDF_MARGIN_LEFT, 52, PDF_MARGIN_RIGHT);
    $this->SetHeaderMargin(PDF_MARGIN_HEADER);
    $this->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $this->SetAutoPageBreak(TRUE, 110);
    
    $this->AddPage();

    $this->setCellPadding( .2 );

    //////////////
    // Concepto //
    //////////////
    $this->SetFont('', 'B', 9);
    $this->Cell(0, 0, 'CONCEPTOS', 'T', 1);

    $this->SetFont('', '', 7);

    $this->SetFillColor( 235, 237, 239 );

    $this->MultiCell(25.5, 7, 'Clave producto/servicio', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );
    $this->MultiCell(25.5, 7, 'Clave Unidad', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );
    $this->MultiCell(25.5, 7, 'Descripción', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );
    $this->MultiCell(25.5, 7, 'Cantidad', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );
    $this->MultiCell(25.5, 7, 'Valor Unitario', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );
    $this->MultiCell(25.5, 7, 'Descuento', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );
    $this->MultiCell(25.5, 7, 'Importe', 1, 'C', true, 0, '', '', true, 0, false, true, 7, 'M' );

    $this->Ln();

    foreach ($this->conceptos->conceptos as $concepto) {
      
      $this->MultiCell(25.5, 7, $concepto->productKey, 1, 'C', false, 0, '', '', true, 0, false, true, 7, 'M' );
      $this->MultiCell(25.5, 7, $concepto->unitKey, 1, 'C', false, 0, '', '', true, 0, false, true, 7, 'M' );
      $this->MultiCell(25.5, 7, $concepto->nombre, 1, 'C', false, 0, '', '', true, 0, false, true, 7, 'M' );
      $this->MultiCell(25.5, 7, $concepto->cantidad, 1, 'C', false, 0, '', '', true, 0, false, true, 7, 'M' );
      $this->MultiCell(25.5, 7, $concepto->costoU, 1, 'C', false, 0, '', '', true, 0, false, true, 7, 'M' );
      $this->MultiCell(25.5, 7, '0', 1, 'C', false, 0, '', '', true, 0, false, true, 7, 'M' );
      $this->MultiCell(25.5, 7, $concepto->total, 1, 'C', false, 1, '', '', true, 0, false, true, 7, 'M' );

    }

    // $this->Output( $this->path, 'F' );
    $this->Output();

  }

  public static function enc( string $cadena ){
    return utf8_encode($cadena);
  }

}

$orden = filter_input(INPUT_GET, 'orden', FILTER_SANITIZE_STRING);
$tipo = filter_input(INPUT_GET, 'tipo', FILTER_SANITIZE_STRING);

if( $tipo === 'oc' ){
  $table1 = 'bomoc';
  $table2 = 'oc';
}
else{
  $table1 = 'bomocm';
  $table2 = 'ocm';
}

$sql = "SELECT cliente FROM {$table2} WHERE idOC = '{$orden}' AND status = '2' LIMIT 1";
$r = $db->query($sql);
// var_dump($sql, $db->affected_rows);
$db->affected_rows > 0 or die('La Orden no esta autorizada o no existe');
$cliente = $r->fetch_object()->cliente;

$r = $db->query("SELECT * FROM cliente WHERE idCliente = '{$cliente}' AND activo = '1' LIMIT 1");
$db->affected_rows > 0 or die('La Cliente no existe');
$cliente = $r->fetch_object();

//cliente tiene
// "idCliente" "int(11)" "NO"  "PRI" \N  "auto_increment"
// "nombre"  "varchar(150)"  "YES" ""  \N  ""
// "direccion" "varchar(150)"  "YES" ""  \N  ""
// "rfc" "varchar(50)" "YES" ""  \N  ""
// "ciudad"  "varchar(150)"  "YES" ""  \N  ""
// "estado"  "varchar(150)"  "YES" ""  \N  ""
// "cp"  "varchar(50)" "YES" ""  \N  ""
$receptor = new stdClass();
$receptor->RFC = $cliente->rfc;


///recolectamos los datos que se van a facturar

$r = $db->query("SELECT articulo, (SELECT nombre FROM articulo WHERE idArticulo = articulo LIMIT 1 ) AS nombre, SUM(cantidad) AS cantidad, costoU FROM {$table1} AS bom WHERE OC = '{$orden}' GROUP BY articulo");

$items = [];

$total = 0;
while( $item = $r->fetch_object() ){
  //articulo, nombre, cantidad, costoU,
  $item->productKey = '456890';
  $item->unitKey = 'H29';
  $item->cantidad = number_format( $item->cantidad, 2, '.', '' );
  $item->total = number_format( $item->cantidad * $item->costoU, 2, '.', '' );
  $total += (float) $item->total;
  $items[] = $item;
}

// echo "<pre>";
// var_dump( $items );

// exit;

$pdf = new PDF();

$empresa = new stdClass();
$empresa->nombre = 'Proveedora de Productos Mexicanos Jace S.A. de C.V.';
$empresa->rfc = 'XAXX010101000';
$empresa->direccion = 'Prolongacion 27 Norte No 10248';
$empresa->regimen_fiscal = 601;


$conceptos = new stdClass();
$conceptos->serie = '99999';
$conceptos->total_percepciones = $total;
$conceptos->total_deducciones = number_format($total * 0.16, 2, '.', '' );//le saco el IVA;
$conceptos->total_transferencia = number_format($total * 1.16, 2, '.', '' );//le sumo el IVA;

$conceptos->conceptos = $items;


$timbrado = new stdClass();
$timbrado->folio = '12345';

$simulateSAT = new stdClass();
$simulateSAT->UUID = 'ASDS-ASDAS-ASDASD-QAWEQW';
$simulateSAT->numSerieSAT = '789987789654123';
$simulateSAT->fechaCFDI = date('Y-m-dTH:i:s');
$simulateSAT->noCertificado = '77777777778888888888888';
$simulateSAT->selloSAT = '363636363663636636';
$simulateSAT->selloCFDI = '4545545554545454';
$simulateSAT->cadenaOriginal = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe aperiam, quas veniam optio qui ex ea repellendus placeat vel labore odit iusto voluptate atque perspiciatis, provident ab maiores blanditiis voluptatum!';


$timbrado->fecha = date('Y-m-dTH:i:s');
$timbrado->noCertificado = '77777777778888888888888';
$timbrado->success = $simulateSAT;


$pdf->setData( $empresa, $receptor, $conceptos, $timbrado );
$pdf->build_PDF();

