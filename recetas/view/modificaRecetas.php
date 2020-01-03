<?php @session_start(); ?>
<div class="row mt-20-px">
  
  <div class="col-xs-12">
        
    <div class="panel panel-default">
            
      <div class="panel-heading text-center bg-coral text-white"> Modificar Receta </div>

      <div class="panel-body">

        <form action="#" method="POST" name="form_receta" id="form_receta" >
          
          <div class="row">
            <div class="col-sm-8">
              <div class="alert alert-info">En <b>ID. Receta</b> puede buscar la receta por la coincidencia de nombre o clave</div>
            </div>
          </div>

          <div class="row">

            <div class="col-md-4 col-sm-6">
                <label class="text-blue">ID. Receta</label>
                <input type="text" name="idReceta" id="idReceta" class="form-control input-sm" placeholder="Ingrese el id de la receta" list="listIdRecetas" required />
                <datalist id="listIdRecetas"> </datalist>
                <!-- <small class="help-block">Puede buscar por nombre o clave</small> -->
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Receta</label>
                <input type="text" name="receta" id="receta" class="form-control input-sm preblock" placeholder="Ingrese el nombre de la receta" list="listRecetas" readonly disabled />
                <datalist id="listRecetas"> </datalist>
              </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Base *</label>
                <select name="base" id="base" class="form-control input-sm preblock" required  disabled >
                  <option value="" selected>Ingrese la base</option>
                </select>
                <!-- <input type="text" name="base" id="base" class="form-control input-sm" placeholder="Ingresar base de la receta" required /> -->
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Tiempo *</label>
                <select name="tiempo" id="tiempo" class="form-control input-sm preblock" required disabled >
                  <option value="" selected>Ingrese los tiempos</option>
                </select>
                <!-- <input type="text" name="tiempo" id="tiempo" class="form-control input-sm" placeholder="Ingresar tiempo" required /> -->
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Calificación *</label>
                <input type="number" name="calificacion" id="calificacion" min="1" max="100" step="any" class="form-control input-sm preblock" placeholder="Ingresar calificación" required disabled />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Grupo *</label>
                <select name="grupo" id="grupo" class="form-control input-sm preblock" required disabled >
                  <option value="" selected>Ingrese el Grupo</option>
                </select>
                <!-- <input type="text" name="grupo" id="grupo" class="form-control input-sm" placeholder="Ingresar grupo" required /> -->
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Observación</label>
                <input type="text" name="observacion" id="observacion" maxlength="150" class="form-control input-sm preblock" placeholder="Observaciones" disabled />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Porciones *</label>
                <input type="number" name="porcion" id="porcion" min="1" max="999" step="any" class="form-control input-sm preblock" placeholder="Ingresar Porción" required disabled />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Gramos *</label>
                <input type="number" name="gramos" id="gramos" min="1" max="999" step="any" class="form-control input-sm preblock" placeholder="Ingresar gramos" required disabled />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">SubUnidad</label>
                <select name="subunidad[]" id="subunidad" class="form-control input-sm preblock" disabled multiple >
                  <option value="" selected>Selecciones las sub-unidades</option>
                </select>
                <small class="help-block text-muted">Puede seleccionar multiples subunidadades, presionando Ctrl + click</small>
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Elaboró</label>
                <input type="text" name="elaboro" id="elaboro" class="form-control input-sm preblock" placeholder="Ingresar nombre de quien elaboro" value="<?= $_SESSION['nombre_comedor'] ?>" readonly disabled />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Autorizó</label>
                <input type="text" name="autorizo" id="autorizo" maxlength="100" class="form-control input-sm preblock" placeholder="Autorizó" required disabled />
              </div>
            </div>

          </div>
          <!-- endRow -->

          <div class="row">
            <div class="col-xs-12">

              <button type="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#collapse_procedimiento"> <i class="fa fa-caret-down"></i> Agregar Procedimiento</button>

              <div id="collapse_procedimiento" class="collapse my-1">
                
                <div class="col-xs-12">
                  <div class="form-group">
                    <label class="text-blue sr-only">Incluir Procedimiento</label>
                    <textarea name="procedimiento" id="procedimiento" class="form-control" placeholder="Procedimiento para la elaboración de la receta, maximo 500 caracteres" maxlength="500" disabled ></textarea>
                  </div>
                </div>

              </div>
            
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 text-right">
              <button type="submit" class="btn btn-success"> <i class="fa fa-edit"></i> Modificar Receta</button>
            </div>
          </div>
          <!-- endRow -->

        </form>

      </div>
      <!-- /.panel-body -->
    </div>
      <!-- /.panel -->

    <!-- panel de costo total -->
    <!-- <div class="panel panel-default"> -->
      <!-- <div class="panel-body"> -->
        <div class="row">
          <div class="col-sm-6 col-md-4 col-sm-offset-6 col-md-offset-8 col-xs-offset-0">
            <div class="form-group">
              <label>Costo/Unidad</label>
              <input type="text" name="costoReceta" id="costoReceta" placeholder="Costo Porción" class="form-control input-lg" readonly />
            </div>
          </div>
        </div>
      <!-- </div> -->
    <!-- </div> -->


        <!-- panel de ingredientes -->

    <div class="panel panel-primary" id="panel_ingredientes" >
      <div class="panel-heading text-center">
        Agregar Ingredientes
      </div>
      
      <div class="panel-body">
        
        <div class="row">
          <div class="col-sm-8">
            <div class="alert alert-info">
              En <b>ID. Artículo</b> puede buscar artículos por la coincidencia de nombre o clave
            </div>
          </div>
        </div>

        <form action="#" method="post" id="form_ingredientes" name="form_ingredientes" >
          
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
                <input type="text" name="articulo" id="articulo" class="form-control input-sm" placeholder="Artículo" list="listArticulo" readonly required />
                <!-- <datalist id="listArticulo"> </datalist> -->
              </div>
            </div>

            <div class="col-md-3 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Cantidad</label>
                <input type="number" min="1" max="999" step="any" name="cantidad" id="cantidad" class="form-control input-sm" placeholder="Cantidad" required />
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
              <button class="btn btn-success" type="submit"> <i class="fa fa-plus"></i> Agregar Artículo</button>
            </div>
          </div>
          

        </form>

      </div>

    </div>
    <!-- end Panel -->
  
    <!-- tabla de los articulos -->

    <div class="panel panel-default">
      <div class="table-responsive">
        <table class="table table-bordered" id="table_articulos">
          <thead>
            <tr>
              <th>ID. Articulo</th>
              <th>Nombre</th>
              <th>Cantidad</th>
              <th>Unidad</th>
              <th>Costo <abbr title="Unitario">U</abbr></th>
              <th>Costo <abbr title="Total">T</abbr></th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody> </tbody>
        </table>
      </div>
    
    </div>

  </div>
  <!-- /.col-lg-12 -->
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modificar Articulo</h4>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" name="updateArticulo" id="updateArticulo" >
          <div class="row">
            
            <input type="hidden" name="idArticulo" >

            <div class="col-md-6">
              <div class="form-group">
                <label class="text-blue">Artículo</label>
                <input type="text" name="articulo" class="form-control input-sm" placeholder="Artículo" list="listArticulo" readonly required />
                <!-- <datalist id="listArticulo"> </datalist> -->
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label class="text-blue">Cantidad</label>
                <input type="number" min="1"  max="999" step="any" name="cantidad" class="form-control input-sm" placeholder="Cantidad" required />
              </div>
            </div>
          
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-blue">Unidad</label>
                <input type="text" name="unidad" class="form-control input-sm" placeholder="Unidad" required readonly />
              </div>
            </div>
          
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-blue">Costo Unitario</label>
                <input type="number" min=".01" step="any" name="costoUni" class="form-control input-sm" placeholder="Costo Unitario" required readonly />
              </div>
            </div>
          
            <div class="col-md-6">
              <div class="form-group">
                <label class="text-blue">Costo Total</label>
                <input type="number" step="any" name="costoTot" class="form-control input-sm" placeholder="Costo Total" readonly />
              </div>
            </div>

            <div class="col-xs-12">
              <button type="submit" class="btn btn-success"> Modificar Artículo </button>
            </div>
          
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>


(function(){

  var _ = document;
  var $$ = _.querySelector.bind(_);

  var formReceta = _.form_receta;
  var formArticulos = _.form_ingredientes;

  var stockArticulos;
  var stockRecetas;

  $(formArticulos).find('input, select, button[type="submit"], textarea').prop('disabled', true);//bloqueamos controles


  // plus para modificar las recetas
  // plus para modificar las recetas
  // plus para modificar las recetas
    var getRecetas = ()=>{

    Swal.fire({
      title: 'Cargando', 
      onOpen: ()=>{
        Swal.showLoading();
      },
      allowOutsideClick: false,
      allowEscapeKey: false
    });

    $.post('recetas/controller/Recetas.php', {method: 'getRecetas'}, (data, textStatus, xhr)=> {
      /*optional stuff to do after success */
      console.log(data);

      stockRecetas = data;//global

      var doc = _.createDocumentFragment();
      for( let item of data ){
        let option = _.createElement('option');
        option.value = item.idReceta;
        option.textContent = item.nombre;
        
        doc.appendChild( option );
      }
      var datalistReceta = formReceta.idReceta.nextElementSibling;
      datalistReceta.innerHTML = '';
      datalistReceta.appendChild( doc );

      Swal.close();

    }, 'json');
  
  }//endGetRecetas

  getRecetas();


  var fillFormReceta = function(ev){
    let value = this.value.trim();

    var item = stockRecetas.find( receta => receta.idReceta === value );
    console.log(item);
    if( ! item ){
      formReceta.receta.value = '';
      formReceta.base.value = '';
      formReceta.tiempo.value = '';
      formReceta.grupo.value = '';
      formReceta.observacion.value = '';
      formReceta.porcion.value = '';
      formReceta.gramos.value = '';
      formReceta.calificacion.value = '';
      // formReceta.elaboro.value = '';
      formReceta.autorizo.value = '';
      formReceta.procedimiento.value = '';
      formReceta['subunidad[]'].value = '';

      oTable.clear().draw();
      $$('#costoReceta').value = '';
      $('.preblock').prop('disabled', true);
      $(formArticulos).find('input, select, button[type="submit"], textarea').prop('disabled', true);//bloqueamos controles

      return;//si item es undefined, termina el codigo
    }

    $(formArticulos).find('input, select, button[type="submit"], textarea').prop('disabled', false);//bloqueamos controles

    $('.preblock').prop('disabled', false);
    formReceta.receta.value = item.nombre;
    formReceta.base.value = item.base;
    formReceta.tiempo.value = item.tiempo;
    formReceta.grupo.value = item.grupo;
    formReceta.observacion.value = item.info;
    formReceta.porcion.value = item.porciones;
    formReceta.gramos.value = item.gramos;
    formReceta.calificacion.value = item.califica;
    // formReceta.elaboro.value = item.elaboro;
    formReceta.autorizo.value = item.autorizo;
    formReceta.procedimiento.value = item.procedimiento;

    //subunidad
    var arry = item.subUnidad.split(',');
    var select = formReceta['subunidad[]'];
    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
      if ( arry.indexOf( o.value ) != -1 )
      {
        o.selected = true;
      }
    }
    //colocamos el costo
    $$('#costoReceta').value = item.costo;

    $.post('recetas/controller/Recetas.php', {method: 'getArticulos', receta: value}, (data, textStatus, xhr)=> {
      /*optional stuff to do after success */
      console.log(data);
      oTable.clear().draw();
      for( let item of data){
        oTable.row.add({ 
          idArticulo: item.idArticulo, 
          articulo: item.nombre, 
          costoUni: item.costo, 
          unidad: item.unidad, 
          cantidad: item.cantidadRel,
          costoTot: (Number(item.costo) * Number(item.cantidadRel)).toFixed(2)
        });
      }
      oTable.draw();
      $('[data-toggle="tooltip"]').tooltip();

    }, 'json');

  }

  formReceta.idReceta.addEventListener('input', fillFormReceta);

  // plus para modificar las recetas
  // plus para modificar las recetas
  // plus para modificar las recetas 

  // matematicas de los articulos
  var calcularTotalArticulo = function(ev){
    //vemos que formulario es
    var form = this.closest('form');
    var costo = form.costoUni.valueAsNumber;
    // if( ! costo ){
    //   form.costoTot.value = '';
    //   return;
    // }
    var cantidad = form.cantidad.valueAsNumber;
    if( ! cantidad ){
      form.costoTot.value = '';
      return;
    }
    form.costoTot.value = ( costo * cantidad ).toFixed(2);
  }

  // formArticulos.costoUni.addEventListener('input', calcularTotalArticulo);
  formArticulos.cantidad.addEventListener('input', calcularTotalArticulo);
  _.updateArticulo.cantidad.addEventListener('input', calcularTotalArticulo);



  $(formArticulos).find('input, select, button[type="submit"], textarea').prop('disabled', true);//bloqueamos controles

  var submitReceta = function(ev){
    if(ev) ev.preventDefault();
    var data = $(this).serializeArray();
    data.push({name: 'method', value: 'updateReceta'});

    for(let item of data)
      item.value = item.value.trim();

    Swal.fire({
      title: 'Modificar Receta',
      text: '¿Desea modificar la receta ' + this.receta.value.trim() + '?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, modificar'
    }).then((result) => {
      if (result.value) {
        
        $.ajax({
          url: 'recetas/controller/Recetas.php',
          type: 'POST',
          dataType: 'json',
          data: data,
          beforeSend: ()=>{
            Swal.fire({
              title: 'Guardando',
              onOpen: ()=>{
                Swal.showLoading()
              },
              allowOutsideClick: false,
              allowEscapeKey: false
            });
          }
        })
        .done((response)=>{
          // console.log(response);
          if( response.status === 1 ){
            Swal.fire('Exito', response.msg, 'success').then(r=>{
              getRecetas();
              calcularTotalReceta();
            });
            // $(formReceta).find('input, select, button[type="submit"], textarea').prop('disabled', true);//bloqueamos controles
            // $(formArticulos).find('input, select, button[type="submit"], textarea').prop('disabled', false);//bloqueamos controles
          }
          else{
            Swal.fire('Error', response.msg, 'error');
          }
        })
        .fail(()=> {
          // console.log("error");
          Swal.fire('', 'La Red no esta disponible, intente más tarde', 'error');
        });

      }//endIf

    });

  }

  formReceta.addEventListener('submit', submitReceta);


    //aqui aparte de crear la relacion debe  de agregarlo a la tabla
  var submitArticulo = function(ev){
    if(ev) ev.preventDefault();

    let value = formArticulos.idArticulo.value.trim();
    var flag = stockArticulos.find( articulo => articulo.idArticulo === value );
    if( ! flag ){
      Swal.fire("", 'El articulo no existe', 'warning');
      return;
    }

    //creamos nuestro objeto con los datos del formulario
    var data = {};
    for( let item of $(this).serializeArray() )
      data[item.name] = item.value.trim();

    //buscamos que ese articulo no este agregado previamente
    var check = Array.from( oTable.rows().data() ).find( row => row.idArticulo === data.idArticulo );
    if( check ){//si regresa el indice, no se agrega
      Swal.fire('Articulo Existente', 'El articulo ya fue agregado', 'info');
    }
    else{
      //aqui tambien lo agrego a la base de datos, la relacion
      //recuperamos el idReceta del formulario, debe estar bloqueado el input, 
      let idReceta = formReceta.idReceta.value.trim();
      $.post('recetas/controller/Articulos.php', {method: 'relacionArticuloReceta', idArticulo: data.idArticulo, idReceta: idReceta, cantidad: data.cantidad }, (resp, textStatus, xhr)=> {

        if( resp.status === 1 ){
          oTable.row.add( data ).draw();
          $('[data-toggle="tooltip"]').tooltip();
          Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
            calcularTotalReceta();//debe ir despues de agregar la tabla
          });
        }
        else{
          Toast.fire({ icon: 'error', title: resp.msg});
        }

      }, 'json');

      
    }

    formArticulos.reset();//limpiamos el formulario

  }
  formArticulos.addEventListener('submit', submitArticulo);

  // matematicas de los articulos
  var calcularTotalArticulo = function(ev){
    //vemos que formulario es
    var form = this.closest('form');
    var costo = form.costoUni.valueAsNumber;
    // if( ! costo ){
    //   form.costoTot.value = '';
    //   return;
    // }
    var cantidad = form.cantidad.valueAsNumber;
    if( ! cantidad ){
      form.costoTot.value = '';
      return;
    }
    form.costoTot.value = ( costo * cantidad ).toFixed(2);
  }
  _.updateArticulo.cantidad.addEventListener('input', calcularTotalArticulo);

  //tambien cuando se agregue correctamente, modifico el costo total de la receta entre la porcion
  var calcularTotalReceta = ()=>{

    var totalReceta = 0;
    for( let item of Array.from( oTable.rows().data() ) )
      totalReceta += Number( item.costoTot );
    
    var porcion = formReceta.porcion.valueAsNumber || 1;
    var costo = ( totalReceta / porcion ).toFixed(2);
    $$('#costoReceta').value = costo;
    //actualizmos en la base de datos
    let idReceta = formReceta.idReceta.value.trim();
    $.post('recetas/controller/Recetas.php', {method: 'updateCosto', costo: costo, idReceta }, (data, textStatus, xhr)=> {

      if( data.status )
        Toast.fire({ icon: 'info', title: data.msg}).then(r=>{ $$('#costoReceta').focus() });
    
    }, 'json');
  
  }

  // llenado del articulo
  var fillForm = function(ev){
    let value = this.value.trim();

    var item = stockArticulos.find( articulo => articulo.idArticulo === value );
    // console.log(item);

    if( ! item ){
      formArticulos.articulo.value = '';
      formArticulos.cantidad.value = '';
      formArticulos.unidad.value = '';
      formArticulos.costoUni.value = '';
      formArticulos.costoTot.value = '';
      return;//si item es undefined, termina el codigo
    }

    formArticulos.articulo.value = item.nombre;
    formArticulos.unidad.value = item.unidad;
    formArticulos.costoUni.value = item.costo;
  }

  formArticulos.idArticulo.addEventListener('input', fillForm);


  //evento para el cambio del articulo
  var updateArticulo = function(ev){
    if(ev) ev.preventDefault();

    //se actualiza en la relacion la cantidad, y se actualiza el costo de la receta
    Swal.fire({
        title: 'Modificar Articulo',
        text: '¿Desea modificar la cantidad del articulo ' + this.articulo.value + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, modificar'
      }).then((result) => {
        if (result.value) {
          
          let idReceta = formReceta.idReceta.value.trim();
          let idArticulo = _.updateArticulo.idArticulo.value.trim();
          let cantidad = _.updateArticulo.cantidad.value.trim();
          $.post('recetas/controller/Articulos.php', {method: 'relacionArticuloRecetaUpdate', idArticulo: idArticulo, idReceta: idReceta, cantidad }, (resp, textStatus, xhr)=> {

            if( resp.status === 1 ){
              
              dataRowDT.cantidad = cantidad;//actualiza cantidad
              dataRowDT.costoTot = ( cantidad * dataRowDT.costoUni ).toFixed(2);//actualiza costo
              nodeRowDT.data( dataRowDT ).draw();//lo dibuja enla tabla
              $('[data-toggle="tooltip"]').tooltip();
              $('#myModal').modal('hide');
              Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
                calcularTotalReceta();//debe ir despues de agregar la tabla
              });
            }
            else{
              Toast.fire({ icon: 'error', title: resp.msg});
            }

          }, 'json');

        }//endIf

      });

  }
  _.updateArticulo.addEventListener('submit', updateArticulo);

  //evento para el cambio del articulo
  var updateArticulo = function(ev){
    if(ev) ev.preventDefault();

    //se actualiza en la relacion la cantidad, y se actualiza el costo de la receta
    Swal.fire({
        title: 'Modificar Articulo',
        text: '¿Desea modificar la cantidad del articulo ' + this.articulo.value + '?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, modificar'
      }).then((result) => {
        if (result.value) {
          
          let idReceta = formReceta.idReceta.value.trim();
          let idArticulo = _.updateArticulo.idArticulo.value.trim();
          let cantidad = _.updateArticulo.cantidad.value.trim();
          $.post('recetas/controller/Articulos.php', {method: 'relacionArticuloRecetaUpdate', idArticulo: idArticulo, idReceta: idReceta, cantidad }, (resp, textStatus, xhr)=> {

            if( resp.status === 1 ){
              
              dataRowDT.cantidad = cantidad;//actualiza cantidad
              dataRowDT.costoTot = ( cantidad * dataRowDT.costoUni ).toFixed(2);//actualiza costo
              nodeRowDT.data( dataRowDT ).draw();//lo dibuja enla tabla
              $('[data-toggle="tooltip"]').tooltip();
              $('#myModal').modal('hide');
              Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
                calcularTotalReceta();//debe ir despues de agregar la tabla
              });
            }
            else{
              Toast.fire({ icon: 'error', title: resp.msg});
            }

          }, 'json');

        }//endIf

      });

  }
  _.updateArticulo.addEventListener('submit', updateArticulo);

  //mi tabla
  var tblItems = $$('#table_articulos');

  var nodeRowDT;//cuando se de click en los botones esta variable apuntara a ese noto del DataTAble
  var dataRowDT;

  $(tblItems).on('click', 'button', function(ev){
    //recuperamos info
    nodeRowDT = oTable.row( $(this).parents('tr').eq(0) );
    var data = nodeRowDT.data();
    dataRowDT = data;

    //boton de eliminar
    if( this.classList.contains('delete') ){

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
          
          let idReceta = formReceta.idReceta.value.trim();
          $.post('recetas/controller/Articulos.php', {method: 'relacionArticuloRecetaDelete', idArticulo: data.idArticulo, idReceta: idReceta }, (resp, textStatus, xhr)=> {

            if( resp.status === 1 ){
              oTable.row( $(this).parents('tr').eq(0) ).remove().draw();
              Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
                calcularTotalReceta();//debe ir despues de agregar la tabla
              });
            }
            else{
              Toast.fire({ icon: 'error', title: resp.msg});
            }

          }, 'json');

        }//endIf

      });

    }
    else if( this.classList.contains('edit') ){
      _.updateArticulo.idArticulo.value = data.idArticulo;
      _.updateArticulo.articulo.value = data.articulo;
      _.updateArticulo.cantidad.value = data.cantidad;
      _.updateArticulo.unidad.value = data.unidad;
      _.updateArticulo.costoUni.value = data.costoUni;
      _.updateArticulo.costoTot.value = data.costoTot;
      $("#myModal").modal();
    }

  });

  var oTable = $( tblItems ).DataTable({
    language: {
      url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
    },
    columns: [
      {data: 'idArticulo', defaultContent: ''},
      {data: 'articulo', defaultContent: ''},
      {data: 'cantidad', defaultContent: ''},
      {data: 'unidad', defaultContent: ''},
      {data: 'costoUni', defaultContent: ''},
      {data: 'costoTot', defaultContent: ''},
      // {data: (row, type, set, meta)=> (Number(row.costoUni) * Number(row.cantidad)).toFixed(2) },
      {
        data: null, defaultContent: `
        <button class="btn btn-primary btn-xs edit" data-toggle="tooltip" title="Editar Cantidad del Artículo"> <i class="fa fa-edit"></i> </button>
        <button class="btn btn-danger btn-xs delete" data-toggle="tooltip" title="Eliminar Artículo"> <i class="fa fa-trash"></i> </button>
        `,
        orderable: false
      }
    ],
    pageLength: 25,

  });


  // get datos del formulario
  var getItems = ()=>{

    Swal.fire({
      title: 'Cargando', 
      onOpen: ()=>{
        Swal.showLoading();
      },
      allowOutsideClick: false,
      allowEscapeKey: false
    });

    $.post('recetas/controller/Recetas.php', {method: 'getitems'}, function(data, textStatus, xhr) {
      // console.log(data);
      
      //dibujamos las bases
      var doc = _.createDocumentFragment();
      for( let item of data.base ){
        let option = _.createElement('option');
        option.value = item.idBase;
        option.textContent = item.descripcion;
        doc.appendChild(option);
      }
      formReceta.base.appendChild(doc);

      //dibujamos los tiempos
      doc = _.createDocumentFragment();
      for( let item of data.tiempo ){
        let option = _.createElement('option');
        option.value = item.idTiempo;
        option.textContent = item.descripcion;
        doc.appendChild(option);
      }
      formReceta.tiempo.appendChild(doc);

      //dibujamos los grupos
      doc = _.createDocumentFragment();
      for( let item of data.grupo ){
        let option = _.createElement('option');
        option.value = item.idGrupo;
        option.textContent = item.descripcion;
        doc.appendChild(option);
      }
      formReceta.grupo.appendChild(doc);

      //dibujamos las sub unidades
      doc = _.createDocumentFragment();
      for( let item of data.subunidad ){
        let option = _.createElement('option');
        option.value = item.idSUnidad;
        option.textContent = item.subUnidad;
        doc.appendChild(option);
      }
      formReceta.subunidad.appendChild(doc);

    }, 'json');


    $.post('recetas/controller/Articulos.php', {method: 'getAllArticulos'}, (data, textStatus, xhr)=> {
      /*optional stuff to do after success */

      stockArticulos = data;//global
      // console.log(data);

      var doc = _.createDocumentFragment();
      for( let item of data ){
        let option = _.createElement('option');
        option.value = item.idArticulo;
        option.textContent = item.nombre;
        
        doc.appendChild( option );
      }
      var listArticulo = formArticulos.idArticulo.nextElementSibling;
      listArticulo.innerHTML = '';
      listArticulo.appendChild( doc );

      Swal.close();//esta peticion creo es la mas pesada
    }, 'json');


  }//endGetItems
  getItems();


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

})();

</script>