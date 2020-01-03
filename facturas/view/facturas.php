<?php @session_start(); ?>
<div class="row mt-20-px">
  
  <div class="col-xs-12">
        
    <div class="panel panel-default">
            
      <div class="panel-heading text-center bg-coral text-white"> Ordenes de Compra Autorizadas para Facturar </div>

      <div class="panel-body text-blue">
        
        <!-- <div class="my-1 text-right">
          <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#nomen">Nomenclatura</button>
          <div class="collapse my-1" id="nomen">
            <button type="button" class="btn btn-xs btn-success"> <i class="fa fa-check"></i> </button> Autorizar y Cerrar <abbr title="Orden de Compra">O.C.</abbr>
            <button type="button" class="btn btn-xs btn-primary"> <i class="fa fa-folder-open"></i> </button> Reabrir  <abbr title="Orden de Compra">O.C.</abbr>
            <button type="button" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> </button> Eliminar <abbr title="Orden de Compra">O.C.</abbr>
          </div>
        </div> -->


        <div class="table-responsive">
          
          <table class="table table-condensed" id="oTable">
            <thead>
              <tr>
                <th>Orden</th>
                <th>Cliente</th>
                <th>Creación</th>
                <th>Realizó</th>
                <th>Fechas Consideradas</th>
                <th>Acciones</th>
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

    var oTable = $('#oTable').DataTable({
      order: [2, 'desc'],
      ajax: {
        type: 'POST',
        url: 'facturas/php/Facturas.php',
        data: d=>{
          d.method = 'getOrdenesAuth';
        },
        beforeSend: ()=>{
          Swal.fire({
            title: 'Cargando', 
            onOpen: ()=>{
              Swal.showLoading();
            },
            allowOutsideClick: false,
            allowEscapeKey: false,
            // showConfirmButton: false,
          });
        },
        complete: ()=>{ Swal.close() },
        dataSrc: ''
      },
      columns: [
        {data: 'idOC', defaultContent: ''},
        {data: 'cliente', defaultContent: ''},
        {data: 'fecha', render: data=> moment(data).format('YYYY-MM-DD') },
        {data: 'usuario', defaultContent: ''},
        {
          data: (row)=>{
            var date1 = moment(row.fechaI);
            var date2 = moment(row.fechaF);
            return date1.format('YYYY-MM-DD') + ' - ' + date2.format('YYYY-MM-DD');
          }
        },
        {
          data: (row)=>`<button type="button" class="btn btn-primary btn-xs ver" title="detalles"> <i class="fa fa-file-code-o"></i> </button>`
        },
      ]

    });


    $('#oTable').on('click', 'button', function(ev){

      const rowData = oTable.row( $(this).parents('tr').eq(0) ).data();

      $.post('facturas/view/detallesOC.php', rowData, (data, textStatus, xhr)=> {
        document.getElementById('contenedor').innerHTML = data;

        var oTable = $("#oTable").DataTable({
          "processing": true,
          "serverSide": true,
          order: [ [0, 'asc'] ],
          ajax: {
            url: "facturas/php/Facturas.php",
            type: 'POST',
            data: d=>{
              d.method = 'getArticuloOC';
              d.orden = rowData.idOC;//server
              d.tipo = rowData.tipo;//server
            }
          },
          columns: [
            {data: 'unidadName', defaultContent: ''},
            {data: 'nombre', defaultContent: ''},
            {data: 'lineaName', defaultContent: ''},
            {data: 'proveedorName', defaultContent: ''},
            {data: 'presentacion', defaultContent: ''},
            {data: 'factor', defaultContent: ''},
            {data: 'cantidad', defaultContent: ''},
            {data: 'costoU', defaultContent: ''},
            {data: 'costoT', defaultContent: ''},
          ]
        });

      }, 'html');

    });

  })();
</script>