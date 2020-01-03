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
        Creación de Hojas de Producción por Unidad
      </div>
      
      <div class="panel-body text-blue">
    
        <form action="minutas/hojaProduccionUnidad.php" method="get" target="_blank" name="form_fechas" id="form_fechas">
            

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="cliente">Cliente *</label>
                        <select name="cliente" id="cliente" class="form-control input-sm" required>
                            <option value="">Seleccione un cliente</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="unidadCliente">Unidad *</label>
                        <select name="unidadCliente" id="unidadCliente" class="form-control input-sm" required disabled >
                            <option value="">Seleccione la unidad</option>
                        </select>
                    </div>
                </div>
            </div>

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


            <div class="row my-1">
                
                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i> Generar Hoja de Producción</button>
                </div>

            </div>
          
        </form>
    

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

(function(){

  let _ = document;
  let $$ = _.querySelector.bind(_);

  let form_fechas = _.form_fechas;

  var stockArticulos, stockClientes;

  var init = ()=>{

    $.ajax({
      url: 'explosion/php/explosion.php',
      type: 'POST',
      dataType: 'json',
      data: {method: 'getClienteUnidad'},
      beforeSend: ()=>{
        Swal.fire({
          title: 'Cargando', 
          onOpen: ()=>{
            Swal.showLoading();
          },
          allowOutsideClick: false,
          allowEscapeKey: false
        });
      }
    })
    .done((response)=> {

      stockClientes = response;

      var doc = _.createDocumentFragment();
      for( let item of response ){
        let option = _.createElement('option');
        option.value = item.idCliente;
        option.textContent = item.nombre;
        doc.appendChild( option );
      }
      form_fechas.cliente.appendChild( doc );

      Swal.close();
    })
    .fail((a, b, c)=> {
        console.log(a, b, c);
    });

  };

  init();//agrega los articulos, clientes al formulario


  //obtener las unidades del cliente
  var getUnitsByClient = function(ev){

    //siempre que se cambie de cliente realiamos estas acciones
    //eliminamos las opciones de unidad menos la primera
    form_fechas.unidadCliente.querySelectorAll('option:not(:first-child)').forEach( option => {
      option.parentNode.removeChild(option);
    });
    
    var value = this.value;//get value input

    //si no se selecciona nada
    if(value === ''){
      //bloqueamos el select de unidadCliente
      form_fechas.unidadCliente.disabled = true;
      form_fechas.reset();//reseteamos el formulario
      return;
    }

    var row = stockClientes.find( client => client.idCliente === value );//get object with id client of global array stockClient
    //creamos la lista de unidades del cliente
    var doc = _.createDocumentFragment();
    for( let item of row.unidades ){
      let option = _.createElement('option');
      option.value = item.idUnidad;
      option.textContent = item.unidad;
      doc.appendChild( option );
    }

    //añadimos las unidades del cliente seleccionado
    form_fechas.unidadCliente.appendChild( doc );
    form_fechas.unidadCliente.disabled = false;//desbloqueamos el select de unidadCLiente

  }

  form_fechas.cliente.addEventListener('change', getUnitsByClient);


  $('.input-daterange').datepicker({
    format: "yyyy-mm-dd",
    language: 'es',
    autoclose: true,
    // endDate: '0d',
  });


  // var form_fechas = document.form_fechas;


  form_fechas.addEventListener('submit', function(ev){

    if( this.start.value === '' || this.end.value === '' ){
      ev.preventDefault();
      Swal.fire('Las Fechas son requeridas', '', 'info');
    }

    console.log( $(this).serialize() );

  });

})();
  

</script>