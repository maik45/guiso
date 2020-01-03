<?php
@session_start(); 

$idOC    = $_POST['idOC'];
$tipo    = $_POST['tipo'];
$cliente = $_POST['cliente'];
$fecha   = $_POST['fecha'];
$usuario = $_POST['usuario'];
$fechaI  = new DateTime($_POST['fechaI']);
$fechaF  = new DateTime($_POST['fechaF']);

?>
<div class="row mt-20-px">
  
  <div class="col-xs-12 text-right my-1">
    <button type="button" class="btn btn-info btn-sm" onclick="$('#contenedor').load('facturas/view/facturas.php')"> <i class="fa fa-arrow-left"></i> Regresar </button>
  </div>

  <div class="col-xs-12">
        
    <div class="panel panel-default">
            
      <div class="panel-heading text-center bg-coral text-white"> Detalles de la Orden <?= $idOC ?> por facturar </div>

      <div class="panel-body text-blue">


        <div class="row">
          <div class="col-sm-4">Orden: <?= $idOC ?></div>
          <div class="col-sm-4">Cliente: <?= $cliente ?></div>
          <div class="col-sm-4">Fechas: <?= $fechaI->format('Y-m-d') . ' al ' . $fechaF->format('Y-m-d') ?></div>
        </div>

        <div class="row my-1"> 
          <div class="col-xs-12 text-center">
            <a class="btn btn-primary" href="facturas/PDF.php?orden=<?=$idOC?>&tipo=<?=$tipo?>" target="_blank" >Facturar Orden</a>
          </div>
        </div>

        <hr>
        
        <div class="table-responsive">
          
          <table class="table table-condensed" id="oTable">
            <thead>
              <tr>
                <th>Unidad</th>
                <th>Artículo</th>
                <th>Linea</th>
                <th>Proveedor</th>
                <th>Presentación</th>
                <th>factor</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Costo Total</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>

        </div>
  
      </div>
      <!-- /.panel-body -->
    </div>
    <!-- /.panel -->

  </div>

</div>

<script>
  (function(){

    // var oTable = $("#oTable").DataTable({
    //   "processing": true,
    //   "serverSide": true,
    //   order: [ [0, 'asc'] ],
    //   ajax: {
    //     url: "facturas/php/Facturas.php",
    //     type: 'POST',
    //     data: d=>{
    //       d.method = 'getArticuloOC';
    //       d.orden = '<?= $idOC ?>';//server
    //     }
    //   },
    //   columns: [
    //     {data: 'unidadName', defaultContent: ''},
    //     {data: 'nombre', defaultContent: ''},
    //     {data: 'lineaName', defaultContent: ''},
    //     {data: 'proveedorName', defaultContent: ''},
    //     {data: 'presentacion', defaultContent: ''},
    //     {data: 'factor', defaultContent: ''},
    //     {data: 'cantidad', defaultContent: ''},
    //     {data: 'costoU', defaultContent: ''},
    //     {data: 'costoT', defaultContent: ''},
    //   ]
    // });

  })();
</script>