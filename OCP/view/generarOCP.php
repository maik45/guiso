<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Creación de Orden de Compra General con Presentación</h3>
  </div>
</div> -->


<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white text-center">
        Creación de Orden de Compra General con Presentación
      </div>
      
      <div class="panel-body">

        <form action="OCP/generaOrdenGral.php" method="post" name="form_excedente" id="form_excedente" target="_blank">
            
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
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i> Orden de Compra Gral Con Presentación</button>
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
                Este reporte genera la Orden de Compra con Presentación para todas las unidades de todos los clientes. Se genera una hoja por proveedor. Solo genera información para Órdenes de Compra previamente creadas, es decir, si no existe una OC previamente creada para la fecha indicada no generará información. Tomará como válido todas aquellas OC que su fecha de creación este entre la fecha inicial seleccionada y la fecha en que termino este entre la fecha final. Esto es si existe una OC donde su fecha de inicio este dentro del rango seleccionado pero su fecha final este fuera del rango seleccionado, esta OC no sera considerada dentro del reporte.
                <br>
                Ejemplo:
                <br>
                Orden de compra creada con las fechas, fecha inicial = 2020-01-01 y fecha final 2020-01-10.
                <br><small>En la creación de OC la fecha inicial y final son las que se seleccionaron en los calendarios</small> 
                <br>
                Ahora si en este reporte se selecciona como fechas 2020-01-05 al 2020-01-09, la OC sera tomada en cuenta en el reporte. 
                <br>
                Si en este reporte se selecciona como fechas 2020-01-08 al 2020-01-11, esta OC no sera tomada en cuenta
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
    // endDate: '0d',
    
  });


  form_excedente.addEventListener('submit', function(ev){
    if(ev) ev.preventDefault();

    if( this.start.value === '' || this.end.value === '' ){
      Swal.fire('Las fechas son requeridas', '','info');
      return;
    }

    Swal.fire({
        title: 'Orden de Compra General',
        text: `¿Desea crear la orden de compra General? Esto puede tardar varios minutos`,
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