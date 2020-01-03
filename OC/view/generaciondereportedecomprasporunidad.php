<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Creación de Reporte de Compras Por Unidad</h3>
  </div>
</div> -->


<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white">
        Creación de Orden de Compra por Unidad
      </div>
      
      <div class="panel-body text-blue">

        <form action="OC/ordenUnidad.php" method="post" name="form_excedente" id="form_excedente" target="_blank">
            
            <div class="row">
                
                <div class="col-xs-12">
                  Seleccione el rango de fechas para la orden de compra *
                  <div class="input-daterange input-group" id="datepicker">
                    <input type="text" class="form-control" name="start" id="start" placeholder="Fecha Inicial" readonly />
                    <span class="input-group-addon"> hasta </span>
                    <input type="text" class="form-control" name="end" id="end" placeholder="Fecha Final" readonly />
                  </div>


                </div>

            </div>

            <div class="row my-1">
                
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i> Generar Reporte de Compras por Unidad</button>
                </div>

            </div>
          
        </form>

        <div class="row">
            
            <!-- <div class="col-xs-12">
                <div class="alert alert-warning">
                    Este reporte sólo acepta hasta 5 unidades por cliente, de lo contrario las demás unidades serán excluídas del reporte.
                </div>
            </div> -->

            <div class="col-xs-12">
              <div class="alert alert-info">
                Este reporte genera las compras totales por unidad. El reporte se genera para todas las unidades de todos los clientes en el rango de fechas especificado.
              </div>
            </div>

        </div>
    

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

(function(){

  let _ = document;
  let $$ = _.querySelector.bind(_);

  let form_excedente = _.form_excedente;

  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: 'es',
    autoclose: true,
    //endDate: '0d',
  });


  form_excedente.addEventListener('submit', function(ev){
    if(ev) ev.preventDefault();

    if( this.start.value === '' || this.end.value === '' ){
      Swal.fire('Las fechas son requeridas', '','info');
      return;
    }

    Swal.fire({
        title: 'Reporte de Compras',
        text: `¿Desea crear el Reporte de compra por unidad? Esto puede tardar varios minutos`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, crear'
      }).then((result) => {
        if (result.value) {

            this.submit();

        }//endIf

      });

    

  });


})();
  

</script>