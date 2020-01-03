<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Creación de Hojas de Producción</h3>
  </div>
</div>
 -->

<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white">
        Creación de Hojas de Producción de todas las unidades
    </div>
      
      <div class="panel-body text-blue">
        
        <form action="minutas/hojaProduccion" target="_blank" method="get" name="form_fechas" id="form_fechas">
          
          <div class="row">
          
            <div class="col-xs-12">
              Seleccione el rango de fechas para las hojas de producción
              <div class="input-daterange input-group" id="datepicker">
                <input type="text" class="form-control" name="start" id="start" placeholder="Fecha Inicial" readonly />
                <span class="input-group-addon"> hasta </span>
                <input type="text" class="form-control" name="end" id="end" placeholder="Fecha Final" readonly />
              </div>

            </div>
            
          
          </div>
        
          <div class="row">
            <div class="col-md-12 my-1 text-center">
              <button type="submit" class="btn btn-primary"> Generar Hojas de Producción </button>
            </div>
          </div>

        </form>

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

(function(){

  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: 'es',
    autoclose: true,
    // endDate: '0d',
  });


  var form_fechas = document.form_fechas;


  form_fechas.addEventListener('submit', function(ev){

    if( this.start.value === '' || this.end.value === '' ){
      ev.preventDefault();
      Swal.fire('Las Fechas son requeridas', '', 'info');
    }

    console.log( $(this).serialize() );

  });

})();
  

</script>