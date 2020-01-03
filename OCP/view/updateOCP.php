<?php @session_start(); ?>
<div class="row mt-20-px">
  
  <div class="col-xs-12">
        
    <div class="panel panel-default">
            
      <div class="panel-heading text-center bg-coral text-white"> Modificar Orden de Compra </div>

      <div class="panel-body">

        <form action="#" method="POST" name="form_receta" id="form_receta" >

          <div class="row">
            
            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">ID. Orden</label>
                <select name="idOrden" id="idOrden" class="form-control input-sm" required >
                  <option value="" selected>Seleccione la Orden</option>
                </select>
                <!-- <input type="text" name="idOrden" id="idOrden" class="form-control input-sm" placeholder="Ingrese el id de la Orden" list="listIdOrdenes" required /> -->
              </div>
              <!-- <datalist id="listIdOrdenes"> </datalist> -->
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Cliente</label>
                <input type="text" name="cliente" id="cliente" class="form-control input-sm" placeholder="nombre del cliente" list="listRecetas" readonly />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Semana</label>
                <input type="text" name="semana" id="semana" class="form-control input-sm" placeholder="# de la semana del la orden" readonly />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Proveedor</label>
                <select name="proveedor" id="proveedor" class="form-control input-sm" required disabled >
                  <option value="" selected>Seleccione el proveedor</option>
                </select>
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Unidades</label>
                <input type="text" name="unidades" id="unidades" class="form-control input-sm" placeholder="Unidades en la Orden" required />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Fecha</label>
                <input type="text" name="fecha" id="fecha" class="form-control input-sm" placeholder="fecha de creación" required readonly />
              </div>
            </div>
          
          </div>

          <!-- <div class="row">
            <div class="col-xs-12 text-right">
              <button type="submit" class="btn btn-primary"> <i class="fa fa-edit"></i> Modificar Orden de Compra</button>
            </div>
          </div> -->
          <!-- endRow -->

        </form>

      </div>
      <!-- /.panel-body -->
    </div>
      <!-- /.panel -->

    <div class="panel panel-primary" id="panel_ingredientes" >
      <div class="panel-heading text-center">
        Agregar Ingredientes
      </div>
      
      <div class="panel-body">

        <form action="#" method="post" id="form_ingredientes" name="form_ingredientes" >

          <fieldset disabled>
            
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

            </div>

            <div class="row">
              
              <div class="col-md-4 col-sm-6">
                <div class="form-group">
                  <label class="text-blue">Unidad / Presentación</label>
                  <input type="text" name="presentacion" id="presentacion" class="form-control input-sm" placeholder="Unidad" required readonly />
                </div>
              </div>

              <div class="col-md-4 col-sm-6">
                <div class="form-group">
                  <label class="text-blue">Costo</label>
                  <input type="number" min=".01" step="any" name="precio" id="precio" class="form-control input-sm" placeholder="Costo Unitario" required readonly />
                </div>
              </div>

            </div>

            <div class="row addInputUnits">
              
              <!-- <div class="col-md-2 col-sm-4 col-xs-6">
                <div class="form-group">
                  <label class="text-blue">Costo 1</label>
                  <input type="number" min=".01" step="any" name="01" id="01" class="form-control input-sm" placeholder="Costo Unitario" required readonly />
                </div>
              </div> -->

            </div>

            <div class="row">
              <div class="col-xs-12 text-right">
                <button class="btn btn-success" type="submit"> <i class="fa fa-save"></i> Agregar </button>
              </div>
            </div>

          </fieldset>

        </form>

      </div>

    </div>
    <!-- end Panel -->
  
    <!-- tabla de los articulos -->

    <div class="panel panel-default hide">
      
      <form action="OCP/reimprimeOrden.php" class="my-1" method="POST" target="_blank">
        <input type="hidden" name="orden" value="" id="reimprimir" />
        <button type="submit" class="btn btn-primary btn-sm"> Reimprimir Orden </button>
      </form>

      <div class="table-responsive">
        <table class="table table-bordered" id="table_articulos">
          <thead>
            <tr>
              <th>ID. <abbr title="Producto">P.</abbr></th>
              <th>Producto</th>
              <th>Presentación</th>
  
              <th>Precio</th>
              <th>Total</th>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modificar Articulo</h4>
      </div>
      <div class="modal-body">
        <form action="#" method="POST" name="updateArticulo" id="updateArticulo" >
          
          <input type="hidden" name="idArticulo" >
          <div class="row">

            <div class="col-xs-12">
              <div class="form-group">
                <label class="text-blue">Artículo</label>
                <input type="text" name="articulo" class="form-control input-sm" placeholder="Artículo" list="listArticulo" readonly required />
              </div>
            </div>

          </div>

          <div class="row">
            
            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Unidad / Presentación</label>
                <input type="text" name="presentacion" class="form-control input-sm" placeholder="Unidad" required readonly />
              </div>
            </div>

            <div class="col-md-4 col-sm-6">
              <div class="form-group">
                <label class="text-blue">Costo</label>
                <input type="number" min=".01" step="any" name="precio" class="form-control input-sm" placeholder="Costo Unitario" required readonly />
              </div>
            </div>

          </div>

          <div class="row addInputUnits">

          </div>

          <div class="row">
            <div class="col-xs-12 text-center">
              <button type="submit" class="btn btn-success"> Modificar Articulo </button>
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


  var G_clientId;//variable global que guarda el id del cliente

  var stockArticulos;
  // var stockRecetas;

  // $(formArticulos).find('input, select, button[type="submit"], textarea').prop('disabled', true);//bloqueamos controles


  var getOrdenes = ()=>{

    Swal.fire({
      title: 'Cargando', 
      onOpen: ()=>{
        Swal.showLoading();
      },
      allowOutsideClick: false,
      allowEscapeKey: false
    });

    //recuperar las ordenes
    $.post('OCP/php/OCP.php', {method: 'getOrdenes'}, (data, textStatus, xhr)=> {

      var doc = _.createDocumentFragment();
      for( let item of data ){
        let option = _.createElement('option');
        option.value = item.idOC;
        option.textContent = item.idOC;
        doc.appendChild( option );
      }

      // formReceta.innerHTML = '';
      formReceta.idOrden.appendChild( doc );

      Swal.close();

    }, 'json');

    //recuperar los proveedores
    $.post('OCP/php/OCP.php', {method: 'getProveedores'}, function(data, textStatus, xhr) {
      var doc = _.createDocumentFragment();
      for( let item of data ){
        let option = _.createElement('option');
        option.value = item.idProveedor;
        option.textContent = item.nombre;
        doc.appendChild( option );
      }

      formReceta.proveedor.appendChild( doc );
      
    }, 'json');
  
  }//endGetRecetas

  getOrdenes();


  //cuando cambie el identificador de la orden recuperamos los datos generales de esa orden
  var getInfoOrden = function(ev){
    let orden = this.value;

    // formReceta.proveedor.querySelectorAll('option:not(:first-child)').forEach(opt=>{
    //   opt.parentNode.removeChild(opt);
    // });//eliminamos los proveedores

    formArticulos.reset();//limpiamos
    oTable.clear().draw();//limpiamos la tabla
    tblItems.closest('.panel').classList.add('hide');//ocultamos la tabla
    $('.addInputUnits').empty();

    if( orden === '' ){
      formReceta.reset();//limpiamos
      formArticulos.querySelector('fieldset').disabled = true;//bloqueado
      formReceta.proveedor.disabled = true;
      formReceta.unidades.title = '';//ya que esta bloqueado el input, le colocamos un title
      $$('#reimprimir').value = '';
      return;

    }

    $$('#reimprimir').value = orden;
    formReceta.proveedor.disabled = false;
    formReceta.proveedor.value = '';//resetamos el proveedor cuando cambie el cliente

    //recuperamos los datos de esta orden
    $.post('OCP/php/OCP.php', {method: 'getInfoOrden', orden}, function(data, textStatus, xhr) {

      formReceta.cliente.value = data.cliente;
      formReceta.unidades.value = data.unidades;
      formReceta.unidades.title = data.unidades;//ya que esta bloqueado el input, le colocamos un title
      formReceta.fecha.value = data.fecha;
      formReceta.semana.value = data.semana;
      G_clientId = data.clienteId;

    }, 'json');

  }
  formReceta.idOrden.addEventListener('change', getInfoOrden);


  //funcion que crea y agrega los inputs nesarios de cada orden, al cliente, crear un input por unidad del cliente en la cual se colocara la cantidad vendida a esa unidad
  //recibe un parametro que son las unidade que tiene cada cliente, es un array de objecto y cada objeto posee idUnidad(id) y unidad(nombre)
  const addInputUnits = (unidades)=>{
    let inputs = '';

    for( let [i, item] of unidades.entries() ){//index, value

      inputs += `<div class="col-md-3 col-sm-6">
        <div class="form-group">
          <label class="text-blue">Cantidad ${i+1}<abbr title="${item.unidad}"> ${abbr(item.unidad)} </abbr></label>
          <input type="number" min=".01" step="any" name="${item.idUnidad}" class="form-control input-sm" placeholder="Cantidad" />
        </div>
      </div>`;
    }
    $('.addInputUnits').html(inputs);

  }

  //function que regresa la abreviacion de una cadena
  //example str = 'Organizacion Mundial de las Naciones Unidas' return O.M.D.L.N.U
  const abbr = str=> str.toUpperCase().match(/(^[A-Z0-9]{1}|\s[A-Z0-9]{1})/g).reduce( (str, val)=>str += `${val.trim()}.`, '' );

  //controlaar el cambio de proveedor en el formulario
  //esta debe decidir si se muestra la tabla o no y ademas modifica la tabla, en cuanto el numeo d e columnas que se deben visualizar
  var changeProveedor = function(ev){

    Swal.fire({
      title: 'Cargando', 
      onOpen: ()=>{
        Swal.showLoading();
      },
      allowOutsideClick: false,
      allowEscapeKey: false
    });

    let orden = formReceta.idOrden.value;
    // let client = formReceta.cliente.value;
    let proveedorId = this.value;

    formArticulos.reset();
    oTable.clear().draw();//limpiamos la tabla
    
    //si proveedor esta vacio
    if( proveedor === '' ){
      tblItems.closest('.panel').classList.add('hide');//ocultamos la tabla
      formArticulos.querySelector('fieldset').disabled = true;
      return;
    }

    //aqui la logica mas fea
    tblItems.closest('.panel').classList.remove('hide');//mostramos la tabla
    formArticulos.querySelector('fieldset').disabled = false;

    // console.log(G_clientId, proveedorId);

    try{
      //rescatamos las unidades y cin ello agregamos a la tabla las unidades en cada columna
      $.post('OCP/php/OCP.php', {method: 'getUnidadesClienteAndItemsOC', cliente: G_clientId, orden, proveedorId}, (data, textStatus, xhr)=> {
        //IF ERROR
        if(xhr.status >= 400)
          Swal.close('Error', 'Error en el servidor por favor reintente', 'error');

        // console.log(data);
        // let columns = makeDT( data.map(item=>item.unidad) );
        let columns = makeDT( data.unidades );

        addInputUnits(data.unidades);
        //este me trae un array de articulos divididos en unidades, osea cada articulo es de una unidad, lo que puedo hacer es crear un nuevo array con los mismo articulos creando su columna

        const rows = {};
        for( let item of data.items ){

          if( item.articulo in rows ){
            rows[item.articulo][item.unidad] = item.quantity;
          }
          else{
            const tmp = {
              idArticulo: item.articulo,
              articulo: item.nombre,
              presentacion: item.unidadText,
              precio: item.costoU,
              costoTotal: item.costoTotal
            }
            
            tmp[item.unidad] = item.quantity;
            rows[item.articulo] = tmp;
          }
          // OC: "19-48-2231"
          // artUnidad: "KILOGRAMOS"
          // articulo: "5073"
          // cliente: "1"
          // costoTotal: 830
          // costoU: "80"
          // factor: "0"
          // linea: "5"
          // nombre: "Charal seco"
          // presentacion: ""
          // proveedor: "24"
          // quantity: "10.38"
          // unidad: "01"
          // unidadText: "KILOGRAMOS"
        }

        oTable.rows.add( Object.values(rows) ).draw();
        Swal.close();

      }, 'json');


      $.post('OCP/php/OCP.php', {method: 'getArticulos', proveedorId}, (data, textStatus, xhr)=> {
        
        stockArticulos = data;//global

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

        //dibujar los datalist en articulo

      }, 'json');
    
    }catch(e){
      console.log(e);
      Swal.close('Error', 'reintente', 'error');
    }

  }

  formReceta.proveedor.addEventListener('change', changeProveedor);


  // llenado del articulo
  // llenado del articulo
  // art.idArticulo, art.nombre, art.unidad, art.unidadA, art.factor, pre.precio
  var fillForm = function(ev){
    let value = this.value.trim();

    // console.log(stockArticulos);

    var item = stockArticulos.find( articulo => articulo.idArticulo === value );
    console.log(item);

    if( ! item ){
      formArticulos.articulo.value = '';
      formArticulos.presentacion.value = '';
      formArticulos.precio.value = '';
      return;//si item es undefined, termina el codigo
    }

    //colocamos valores en el formulario
    formArticulos.articulo.value = item.nombre;
    if( item.factor == 0 ){
      formArticulos.presentacion.value = item.unidad;
      formArticulos.precio.value = item.precio;
    }
    else{
      formArticulos.presentacion.value = `${item.unidadA} de ${item.factor} ${item.unidad}`;
      formArticulos.precio.value = ( item.precio * item.factor ).toFixed(2);
    }

  }

  formArticulos.idArticulo.addEventListener('input', fillForm);


  const addArticle = function(ev){
    if(ev)ev.preventDefault();

    // console.log( $(this).serializeArray() );

    let data = $(this).serializeArray();
    const row = {};
    for( let item of data ){
      // console.log(item);
      row[item.name] = item.value; 
    }

    Swal.fire({
      title: 'Agregar Articulo',
      text: '¿Desea agregar ' + this.articulo.value + ' a la Orden de Compra?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, agregar'
    }).then((result) => {
      if (result.value) {
        
        data.push({name: 'method', value: 'addArticle'});//agregamos el metodo
        data.push({name: 'orden', value: formReceta.idOrden.value});//agregamos la orden
        data.push({name: 'proveedor', value: formReceta.proveedor.value});//agregamos el proveedor
        data.push({name: 'cliente', value: formReceta.cliente.value});//agregamos el cliente


        $.post('OCP/php/OCP.php', data, (resp, textStatus, xhr)=> {

          if( resp.status === 1 ){
            this.reset();
            Swal.fire("Exito", resp.msg, 'success').then(r=>{
              changeProveedor.call(formReceta.proveedor);
            });
            // oTable.row.add(row).draw();
            // Toast.fire({ icon: 'success', title: resp.msg}).then( r=>{
              // makeDT();
            // });
          }
          else{
            Toast.fire({ icon: 'error', title: resp.msg});
          }

        }, 'json');

      }//endIf

    });


  }

  formArticulos.addEventListener('submit', addArticle);


  //config de la tabla
  var tblItems = $$('#table_articulos');
  var oTable;




  const updateArticle = function(ev){
    if(ev)ev.preventDefault();

    let data = $(this).serializeArray();
    // const row = {};
    // for( let item of data ){
    //   row[item.name] = item.value; 
    // }

    // console.log(row);
    Swal.fire({
      title: 'Actualizar Cantidades',
      text: '¿Desea modificar las cantidades del artículo ' + this.articulo.value + ' de la orden de compra?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, actualizar'
    }).then((result) => {
      if (result.value) {
        
        data.push({name: 'method', value: 'updateArticle'});//agregamos el metodo
        data.push({name: 'orden', value: formReceta.idOrden.value});//agregamos la orden
        data.push({name: 'proveedor', value: formReceta.proveedor.value});//agregamos el proveedor
        data.push({name: 'cliente', value: formReceta.cliente.value});//agregamos el cliente


        console.log( data );
        $.post('OCP/php/OCP.php', data, (resp, textStatus, xhr)=> {

          if( resp.status === 1 ){
            this.reset();
            $('#myModal').modal('hide');
            Swal.fire('Exito', resp.msg, 'success').then(r=>{
              changeProveedor.call(formReceta.proveedor);
            });
          }
          else{
            // Toast.fire({ icon: 'error', title: resp.msg});
            Swal.fire('Error', resp.msg, 'error').then(r=>{
              changeProveedor.call(formReceta.proveedor);
            });
          }

        }, 'json');

      }//endIf

    });

  }

  updateArticulo.addEventListener('submit', updateArticle);

  $(tblItems).on('click', 'button', function(ev){

    let rowData = oTable.row( $(this).parents('tr').eq(0) ).data();
    console.log("rowData", rowData);
    // console.log("rowData", );

    if( this.classList.contains('edit') ){

      $('#myModal').modal();

      for( let prop in rowData  ){
        if( prop !== 'costoTotal' ){
          console.log(prop, updateArticulo[prop], rowData[prop] );
          // updateArticulo[prop].value = rowData[prop];
          updateArticulo.querySelector(`[name="${prop}"]`).value = rowData[prop];

        }

      }

    }
    else if( this.classList.contains('delete') ){

      Swal.fire({
        title: 'Eliminar Articulo',
        text: '¿Desea Eliminar el artículo ' + rowData.articulo + ' de la orden de compra?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar'
      }).then((result) => {
        if (result.value) {
          
          var data = [];
          data.push({name: 'method', value: 'removeArticle'});//agregamos el metodo
          data.push({name: 'orden', value: formReceta.idOrden.value});//agregamos la orden
          data.push({name: 'proveedor', value: formReceta.proveedor.value});//agregamos el proveedor
          data.push({name: 'idArticulo', value: rowData.idArticulo});//agregamos el cliente


          $.post('OCP/php/OCP.php', data, (resp, textStatus, xhr)=> {

            if( resp.status === 1 ){
              Swal.fire('Exito', resp.msg, 'success').then(r=>{
                changeProveedor.call(formReceta.proveedor);
              });
            }
            else{
              // Toast.fire({ icon: 'error', title: resp.msg});
              Swal.fire('Error', resp.msg, 'error').then(r=>{
                changeProveedor.call(formReceta.proveedor);
              });
            }

          }, 'json');

        }//endIf

      });

    }

  });

  //crar la tabla
  //col debe ser un array de objetos con el idUnidad y su nombre de unidad
  // example col = [ 
  //   {idUnidad: 'unitID1', unidad: 'unitName1'}, 
  //   {idUnidad: 'unitID2', unidad: 'unitName2'}, 
  //   {idUnidad: 'unitIDN', unidad: 'unitNameN'}, 
  // ];

  //return: retorna un array con los valores que se estan colocando en cada columna
  var makeDT = (col = null)=>{
    let columns, moreColumns = [];

    if( oTable !== undefined )//si es undefined el object DT no existe asi que no hacemos nada, si es diferente destruimos la DT
      oTable.destroy();

    //si es diferente de  null, es por que vamos a agregar mas columnas
    if(col !== null){

      for( let item of col ){
        moreColumns.push( {data: item.idUnidad, defaultContent: '', title: item.unidad} );
      }

    }

    //hasta aqui debo aplicar una formula en la columna antepenultima
    //que me sume los data de moreColumns

    // ( row.unidad1 + row.unidad2 + row.unidad3 ) * row.precio
    columns = [
      {data: 'idArticulo', defaultContent: '', title: 'ID Prod.'},
      {data: 'articulo', defaultContent: '', title: 'Producto'},
      {data: 'presentacion', defaultContent: '', title: 'Presentación'},
      {data: 'precio', defaultContent: '', title: 'Precio'},
      //aqui irian mis columas dinamicas
      ...moreColumns,//spread Operador ES6
      // {data: 'total', defaultContent: '', title: 'Total'},
      { data: (row, type, set, meta)=>{
          //creo un clousure
          // console.log(row, col);
          var sum = 0;
          for( let item of col ){
            if( item.idUnidad in row )
              sum += Number( row[item.idUnidad] );
          }
          return (sum * row.precio).toFixed(2);
        }, 
        title: 'Total'
      },
      {
        data: null, defaultContent: `
        <button class="btn btn-primary btn-xs edit"> <i class="fa fa-edit"></i> </button>
        <button class="btn btn-danger btn-xs delete"> <i class="fa fa-trash"></i> </button>
        `,
        orderable: false,
        title: 'Acciones'
      }
    ];

    let thead = '<tr>';
    for( let item of columns )
      thead += `<th>${item.title}</th>`;
    thead += '</tr>';

    tblItems.querySelector('thead').innerHTML = thead;//modificamos el dom thead

    oTable = $( tblItems ).DataTable({
      language: {
        url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'
      },
      columns,
      pageLength: 25,

    });

    return columns.map( item=> item.data );

  }

  makeDT();

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


  formReceta.unidades.addEventListener('keypress', ev=>{ev.preventDefault()});


})();

</script>