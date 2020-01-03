<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Crear Lista de Excedentes</h3>
  </div>
</div>
 -->

<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white">
        Crear Lista de excedente de artículos
      </div>
      
      <div class="panel-body text-blue">

        <div class="row">
          <div class="col-xs-12">
            <div class="alert alert-info">
              Crea una lista de todos los artículos en el sistema, para que se puedan modificar las cantidades, por defecto salen todas con valor 0, asi que las cantidades que edites, seran las cantidades que se almacenarán como excedentes de la unidad seleccionada. <br>
              Una vez editado el documento, para aplicar los cambios, subir el documento en la opción del menu lateral izquierdo <b>Cargar Lista de Excedentes</b>
            </div>
            <div class="alert alert-warning">
              Por favor evite modificar el nombre del cliente, unidad e idArticulo de la hoja de calculo, asi como ingresar una cantidad valida en la columna cantidad de la hoja de calculo, esto para evitar errores e inconsistencias en el sistema.
            </div>
          </div>
        </div>
        
        <form action="explosion/excedenteArchivo.php" method="post" target="_blank" name="form_excedente" id="form_excedente">
            

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
                    <div class="alert alert-info">
                        Generar Archivo de Excel de los artículos existentes en el sistema para calcular excedentes
                    </div>
                </div>

                <div class="col-xs-12 text-center">
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-file-excel-o"></i> Generar de Archivo</button>
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

  let form_excedente = _.form_excedente;

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
      form_excedente.cliente.appendChild( doc );

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
    form_excedente.unidadCliente.querySelectorAll('option:not(:first-child)').forEach( option => {
      option.parentNode.removeChild(option);
    });
    
    var value = this.value;//get value input

    //si no se selecciona nada
    if(value === ''){
      //bloqueamos el select de unidadCliente
      form_excedente.unidadCliente.disabled = true;
      form_excedente.reset();//reseteamos el formulario
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
    form_excedente.unidadCliente.appendChild( doc );
    form_excedente.unidadCliente.disabled = false;//desbloqueamos el select de unidadCLiente

  }

  form_excedente.cliente.addEventListener('change', getUnitsByClient);

})();
  

</script>