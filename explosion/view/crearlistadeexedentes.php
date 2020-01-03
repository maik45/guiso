<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Crear Lista de Excedentes</h3>
  </div>
</div> -->


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
              <p>Crea una lista de los artículos a los cuales se les desea aplicar una cantidad excedente a la unidad del cliente en el reporte de generar explosión.
              Esta lista descargar un documento de office excel, el cual tendra la cantidad que ingrese en el formulario de abajo.
              Para reflejar el excedente a la unidad, debe se cargar la lista en la opción de <b>cargar lista de excedentes </b> del menu lateral izquierdo.</p>
            </div>
            <div class="alert alert-warning">
              Por favor evite modificar el nombre del cliente, unidad e idArticulo de la hoja de calculo, asi como ingresar una cantidad valida en la columna cantidad de la hoja de calculo, esto para evitar errores e inconsistencias en el sistema.
            </div>
          </div>
        </div>

        <form action="#" method="get" name="form_excedente" id="form_excedente">
            

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
                    
                    <div class="panel panel-primary" id="panel_ingredientes" >
                      <div class="panel-heading text-center">
                        Ingresar Artículo
                      </div>
                      
                      <div class="panel-body">

                        <fieldset id="card_articulo" name="card_articulo" disabled >
                          
                          <div class="row">
                            
                            <div class="col-sm-4">
                              <div class="form-group">
                                <label class="text-blue">ID Artículo</label>
                                <input type="text" name="idArticulo" id="idArticulo" class="form-control input-sm" placeholder="ID Artículo" list="listIdArticulo" required />
                                <datalist id="listIdArticulo"> </datalist>
                              </div>
                            </div>

                            <div class="col-sm-8">
                              <div class="form-group">
                                <label class="text-blue">Artículo</label>
                                <input type="text" name="articulo" id="articulo" class="form-control input-sm" placeholder="Artículo" readonly required />
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                              <div class="form-group">
                                <label class="text-blue">Cantidad</label>
                                <input type="number" min="1" step="any" name="cantidad" id="cantidad" class="form-control input-sm" placeholder="Cantidad" required />
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                              <div class="form-group">
                                <label class="text-blue">Unidad</label>
                                <input type="text" name="unidad" id="unidad" class="form-control input-sm" placeholder="Unidad" required readonly />
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                              <div class="form-group">
                                <label class="text-blue">Costo Unitario</label>
                                <input type="number" min=".01" step="any" name="costoUni" id="costoUni" class="form-control input-sm" placeholder="Costo Unitario" required readonly />
                              </div>
                            </div>

                            <div class="col-md-3 col-sm-6">
                              <div class="form-group">
                                <label class="text-blue">Costo Total</label>
                                <input type="number" step="any" name="costoTot" id="costoTot" class="form-control input-sm" placeholder="Costo Total" readonly />
                              </div>
                            </div>

                          </div>

                          <div class="row">
                            <div class="col-xs-12 text-right">
                              <button class="btn btn-success" type="submit">Agregar Artículo</button>
                            </div>
                          </div>
                          

                        </filedset>

                      </div>

                    </div>
                    <!-- end Panel -->

                </div>

            </div>
          
        </form>

        <div class="row">
            <div class="col-xs-12">
                
                <div class="panel panel-default">
           
                  <div class="table-responsive">
                    <table class="table table-bordered" id="table_articulos">
                      <thead>
                        <tr>
                          <th>ID. Articulo</th>
                          <th>Nombre</th>
                          <th>Cantidad</th>
                          <th>Unidad</th>
                          <th>Costo U</th>
                          <th>Costo T</th>
                          <th>Acciones</th>
                        </tr>
                      </thead>
                      <tbody> </tbody>
                    </table>
                  </div>
                
                </div>

            </div>

            <div class="col-xs-12">
              <button type="button" class="btn btn-primary" id="export_excel"> <i class="fa fa-file-excel-o"></i> Generar Excel </button>
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

    $.post('recetas/controller/Articulos.php', {method: 'getAllArticulos'}, (data, textStatus, xhr)=> {

      stockArticulos = data;//global

      var doc = _.createDocumentFragment();
      for( let item of data ){
        let option = _.createElement('option');
        option.value = item.idArticulo;
        option.textContent = item.nombre;
        
        doc.appendChild( option );
      }
      var listArticulo = form_excedente.idArticulo.nextElementSibling;
      listArticulo.innerHTML = '';
      listArticulo.appendChild( doc );

    }, 'json');

  };

  init();//agrega los articulos, clientes al formulario


  //obtener las unidades del cliente
  var getUnitsByClient = function(ev){

    //siempre que se cambie de cliente realiamos estas acciones
    oTable.clear().draw();//limpimos la tabla
    //eliminamos las opciones de unidad menos la primera
    form_excedente.unidadCliente.querySelectorAll('option:not(:first-child)').forEach( option => {
      option.parentNode.removeChild(option);
    });
    
    var value = this.value;//get value input

    //si no se selecciona nada
    if(value === ''){
      //bloqueamos el select de unidadCliente
      form_excedente.unidadCliente.disabled = true;
      form_excedente.card_articulo.disabled = true;//bloqueamos los campos de articulo
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

  var changeUnidad = function(ev){
    //si no se selecciona nada
    let value = this.value;
    if( value === '' ){//si la unidad es vacio entonces bloqueamos los inoputs de articulo
      form_excedente.card_articulo.disabled = true;
      oTable.clear().draw();
      //limpiamos los valores de articulo
      form_excedente.idArticulo.value =
      form_excedente.articulo.value =
      form_excedente.cantidad.value =
      form_excedente.unidad.value = 
      form_excedente.costoUni.value = 
      form_excedente.costoTot.value = '';
      return;
    }
    form_excedente.card_articulo.disabled = false;//desbloqueamos lso inputs de articulos
  }
  form_excedente.unidadCliente.addEventListener('change', changeUnidad);


  //llenado del formualrio cuando escriban un articulo en el campo idArticulo
    // llenado del articulo
  var fillForm = function(ev){
    let value = this.value.trim();
    var item = stockArticulos.find( articulo => articulo.idArticulo === value );//regresa el objeto donde coincida el idArticulo con el que ingresaron en el input
    console.log(item);
    if( ! item ){//si item es vacio (undefined) limpiamos los campos
      form_excedente.articulo.value =
      form_excedente.cantidad.value =
      form_excedente.unidad.value = 
      form_excedente.costoUni.value = 
      form_excedente.costoTot.value = '';
      return;//termina el codigo
    }
    //si existe agregamos los valores al formulario
    form_excedente.articulo.value = item.nombre;
    form_excedente.unidad.value = item.unidad;
    form_excedente.costoUni.value = item.costo;
  }

  form_excedente.idArticulo.addEventListener('input', fillForm); 


  // matematicas de los articulos
  var calcularTotalArticulo = function(ev){
    var form = this.closest('form');//recuperamos el formulario al que pertenece, esta de mas, pero es por si se quiere usar la misma funcion para otros formularios
    var costo = form.costoUni.valueAsNumber;//recuperamos el valor del input costoUni
    var cantidad = form.cantidad.valueAsNumber;//recuperamos el valor del input cantidad
    if( ! cantidad ){//si cantidad es 0 costoTotal lo dejamos vacio
      form.costoTot.value = '';
      return;//termina el codigo
    }
    form.costoTot.value = ( costo * cantidad ).toFixed(2);//si existe cantidad, multiplicamos
  }

  form_excedente.cantidad.addEventListener('input', calcularTotalArticulo);


  //aqui aparte de crear la relacion debe  de agregarlo a la tabla
  //aqui aparte de crear la relacion debe  de agregarlo a la tabla
  //aqui aparte de crear la relacion debe  de agregarlo a la tabla
  var submitArticulo = function(ev){
    if(ev) ev.preventDefault();

    let value = this.idArticulo.value.trim();
    var item = stockArticulos.find( articulo => articulo.idArticulo === value );
    if( ! item ){
      Swal.fire("", 'El articulo no existe', 'warning');
      return;
    }

    //creamos nuestro objeto con los datos del formulario
    // var data = {};
    // for( let item of $(this).serializeArray() )
      // data[item.name] = item.value.trim();

    item.cantidad = this.cantidad.valueAsNumber;
    item.costoTot = this.costoTot.valueAsNumber;

    //buscamos que ese articulo no este agregado previamente
    var check = Array.from( oTable.rows().data() ).find( row => row.idArticulo === item.idArticulo );
    if( check ){//si regresa el elemento, no se agrega
      Swal.fire('Articulo Existente', 'El articulo ya fue agregado', 'info');
    }
    else{
      // en el codigo original no hace nada mas que agregarlo en la tabla
      // en el codigo original no hace nada mas que agregarlo en la tabla
      // en el codigo original no hace nada mas que agregarlo en la tabla

      oTable.row.add( item ).draw();
      Toast.fire({ icon: 'success', title: 'Articulo Agregado a la lista de Excedente'});

      //aqui tambien lo agrego a la base de datos, la relacion
      // $.post('recetas/controller/Articulos.php', {method: 'relacionArticuloReceta', idArticulo: data.idArticulo, idReceta: idReceta, cantidad: data.cantidad }, (resp, textStatus, xhr)=> {

      //   if( resp.status === 1 ){
      //     oTable.row.add( data ).draw();
      //     Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
      //       calcularTotalReceta();//debe ir despues de agregar la tabla
      //     });
      //   }
      //   else{
      //     Toast.fire({ icon: 'error', title: resp.msg});
      //   }

      // }, 'json');

      //limpiamos los valores de articulo
      form_excedente.idArticulo.value =
      form_excedente.articulo.value =
      form_excedente.cantidad.value =
      form_excedente.unidad.value = 
      form_excedente.costoUni.value = 
      form_excedente.costoTot.value = '';
    }

    // form_excedente.reset();//limpiamos el formulario


  }
  form_excedente.addEventListener('submit', submitArticulo);


  //configuracion de la tabla de articulos
  //configuracion de la tabla de articulos
  //configuracion de la tabla de articulos
  var table_articulos = $$('#table_articulos');

  var oTable = $(table_articulos).DataTable({
    columns: [
      {data: 'idArticulo', defaultContent: ''},
      {data: 'nombre', defaultContent: ''},
      {data: 'cantidad', defaultContent: ''},
      {data: 'unidad', defaultContent: ''},
      {data: 'costo', defaultContent: ''},
      {data: 'costoTot', defaultContent: ''},
      // {data: (row, type, set, meta)=> (Number(row.costoUni) * Number(row.cantidad)).toFixed(2) },
      {
        data: null, defaultContent: `
        <button class="btn btn-danger btn-xs delete"> <i class="fa fa-trash"></i> </button>
        `,
        orderable: false
      }
    ]
  });

  $(table_articulos).on('click', '.delete', function(ev){

    let data = oTable.row( $(this).parents('tr').eq(0) ).data();

    Swal.fire({
      title: 'Eliminar Articulo',
      text: '¿Desea eliminar ' + data.articulo + '?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar'
    }).then((result) => {
      if (result.value) {
        
        oTable.row( $(this).parents('tr').eq(0) ).remove().draw();
        Toast.fire({ icon: 'success', title: 'Atticulo Eliminado'});
        // let idReceta = formReceta.idReceta.value.trim();
        // $.post('recetas/controller/Articulos.php', {method: 'relacionArticuloRecetaDelete', idArticulo: data.idArticulo, idReceta: idReceta }, (resp, textStatus, xhr)=> {

        //   if( resp.status === 1 ){
        //     oTable.row( $(this).parents('tr').eq(0) ).remove().draw();
        //     Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
        //       calcularTotalReceta();//debe ir despues de agregar la tabla
        //     });
        //   }
        //   else{
        //     Toast.fire({ icon: 'error', title: resp.msg});
        //   }

        // }, 'json');

      }//endIf

    });

  });


  //utilidad del toast de Swal
  //utilidad del toast de Swal
  //utilidad del toast de Swal
  //utilidad del toast de Swal
  const Toast = Swal.mixin({
    toast: true,
    position: 'bottom',
    showConfirmButton: false,
    timer: 3000,
    onOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

  //exporta a excel los datos que estan en la tabla
  $$('#export_excel').addEventListener('click', function(ev){

    let data = Array.from( oTable.rows().data() );

    if( ! data.length ){
      Swal.fire('No hay nada que exportar', '', 'info');
      return;
    }

    var form = _.createElement('form');
    form.target = '_blank';
    form.method = 'post';
    form.action = 'explosion/listExcedente.php';
    form.className = 'hide';
    form.id = 'form_export';

    let input;
    input = _.createElement('input');
    input.name = 'cliente';
    input.type = 'text';
    input.value = form_excedente.cliente.options[form_excedente.cliente.selectedIndex].text + '\/' + form_excedente.cliente.value;

    form.appendChild(input);

    input = _.createElement('input');
    input.name = 'unidad';
    input.type = 'text';
    input.value = form_excedente.unidadCliente.options[form_excedente.unidadCliente.selectedIndex].text + '\/'+ form_excedente.unidadCliente.value;

    form.appendChild(input);

    for( let item of data ){
      input = _.createElement('input');
      input.name = 'articulos[]';
      input.type = 'text';
      input.value = JSON.stringify(item);

      form.appendChild(input);
    }

    _.body.appendChild(form);
    form.submit();
    $$('#form_export').parentNode.removeChild( $$('#form_export') );

  });


})();
  

</script>