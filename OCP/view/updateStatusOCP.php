<?php @session_start(); ?>
<div class="row mt-20-px">
  
  <div class="col-xs-12">
        
    <div class="panel panel-default">
            
      <div class="panel-heading text-center bg-coral text-white"> Modificar Status de las Ordenes de Compra </div>

      <div class="panel-body">
        
        <div class="my-1 text-right">
          <button type="button" class="btn btn-info btn-sm" data-toggle="collapse" data-target="#nomen">Nomenclatura</button>
          <div class="collapse my-1" id="nomen">
            <button type="button" class="btn btn-xs btn-success"> <i class="fa fa-check"></i> </button> Autorizar y Cerrar <abbr title="Orden de Compra">O.C.</abbr>
            <button type="button" class="btn btn-xs btn-primary"> <i class="fa fa-folder-open"></i> </button> Reabrir  <abbr title="Orden de Compra">O.C.</abbr>
            <button type="button" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i> </button> Eliminar <abbr title="Orden de Compra">O.C.</abbr>
          </div>  
        </div>


        <div class="table-responsive">
          
          <table class="table table-condensed" id="oTable">
            <thead>
              <tr>
                <th>Orden</th>
                <th>Cliente</th>
                <th>Creación</th>
                <th>Elaboró</th>
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
        url: 'OCP/php/OCP.php',
        data: d=>{
          d.method = 'getOrdenes';
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
          data: (row)=>{
            let btnAuth = `<button type="button" class="btn btn-success btn-xs auth" title="autorizar y cerrar OC"> <i class="fa fa-check"></i> </button> `,
            btnReOpen = `<button type="button" class="btn btn-primary btn-xs reOpen" title="Abrir Nuevamente OC "> <i class="fa fa-folder-open"></i> </button> `,
            btnRemove = `<button type="button" class="btn btn-danger btn-xs remove" title="Eliminar OC"> <i class="fa fa-trash"></i> </button> `;
            if( row.status === '2' )
              return btnReOpen;
            else
              return btnAuth + btnRemove;
          }
        },
      ]

    });


    $('#oTable').on('click', 'button', function(ev){

      const rowData = oTable.row( $(this).parents('tr').eq(0) ).data();
      console.log(rowData);

      var textos = {};

      if( this.classList.contains('auth') ){
        textos = {
          title: 'Autorizar',
          text: '¿Desea autorizar y cerrar la orden de compra ' + rowData.idOC + '?',
          btnConfirm: 'Si, autorizar',
          method: 'authOC',
        };
      }
      else if( this.classList.contains('reOpen') ){
        textos = {
          title: 'Reabrir',
          text: '¿Desea Re abrir la orden de compra ' + rowData.idOC + '?',
          btnConfirm: 'Si, reabrir',
          method: 'reOpenOC',
        };
      }
      else if( this.classList.contains('remove') ){
        textos = {
          title: 'Cuidado, ¿Eliminar?',
          text: '¿Desea Eliminar la orden de compra ' + rowData.idOC + '?, Esta acción es irreversible, y la OC sera descartada del sistema permanentemente',
          btnConfirm: 'Si, Eliminar',
          method: 'removeOC',
          icon: 'error'
        };
      }

      if( Object.keys(textos).length ){//verificar que si entro en alguna condicional
        Swal.fire({
          title: textos.title,
          text: textos.text,
          icon: textos.icon || 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: textos.btnConfirm
        }).then((result) => {
          if (result.value) {
            
            $.post('OCP/php/OCP.php', {method: textos.method, orden: rowData.idOC}, function(data, textStatus, xhr) {
              
              if( data.status === 1)
                Swal.fire('Exito', data.msg, 'success').then( r=>{oTable.ajax.reload();} );
              else
                Swal.fire('Error', data.msg, 'error').then( r=>{oTable.ajax.reload();} );


            }, 'json');

          }//endIf

        });

      }

    });

  })();
</script>