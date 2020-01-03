<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      
      <div class="panel-heading text-white text-center bg-coral">Consultar Recetas</div>
      
      <div class="panel-body">
          
          <form action="#" method="POST" name="form_receta" id="form_receta">
            
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

              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Receta</label>
                <input type="text" name="receta" id="receta" class="form-control input-sm" placeholder="Ingrese el nombre de la receta" list="listRecetas" disabled />
                <datalist id="listRecetas"> </datalist>
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Base</label>
                <input type="text" name="base" id="base" class="form-control input-sm" placeholder="Ingrese la Base" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Tiempo</label>
                <input type="text" name="tiempo" id="tiempo" class="form-control input-sm" placeholder="Ingrese el tiempo" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Grupo</label>
                <input type="text" name="grupo" id="grupo" class="form-control input-sm" placeholder="Ingrese el Grupo" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Observación</label>
                <input type="text" name="observacion" id="observacion" class="form-control input-sm" placeholder="ingrese observaciones" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Porciones</label>
                <input type="text" name="porcion" id="porcion" class="form-control input-sm" placeholder="Ingrese la Porción" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Gramos</label>
                <input type="text" name="gramos" id="gramos" class="form-control input-sm" placeholder="Ingrese los gramos" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Costo/Unidad</label>
                <input type="text" name="costo" id="costo" class="form-control input-sm" placeholder="Ingrese el costo" disabled />
              </div>

              <div class="col-md-4 col-sm-6">
                <label class="text-blue">Calificación</label>
                <input type="text" name="calificacion" id="calificacion" class="form-control input-sm" placeholder="Ingrese la calificación" disabled />
              </div>

            </div>

            <div class="row my-1">
              <div class="col-xs-12">
                <a class="btn btn-primary" href="recetas/printReceta" target="_blank" id="printReceta" disabled> <i class="fa fa-print"></i> Descargar Receta</a>
              </div>
            </div>
          
          </form>

      </div>
      <!-- endPanelBody -->
    
    </div>
    <!-- endPanel -->

    <div class="panel panel-primary">
      <div class="panel-heading text-center">Artículos</div>
      <div class="panel-body">
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
              </tr>
            </thead>
            <tbody></tbody>
          </table>

        </div>
      </div>
    </div>


  </div>
  <!-- endColXS -->

</div>
<!-- endRow -->

<script>
(function(){

  var _ = document;
  var $$ = _.querySelector.bind(_);

  var formReceta = _.form_receta;
  var stockRecetas;

  //se debe manejar a la par el nombre de la receta y el id de la receta

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


  var fillForm = function(ev){
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
      formReceta.costo.value = '';
      formReceta.calificacion.value = '';
      $$('#printReceta').setAttribute('disabled', 'disabled');
      $$('#printReceta').setAttribute('href', '#');
      oTable.clear().draw();

      return;//si item es undefined, termina el codigo
    }

    formReceta.receta.value = item.nombre;
    formReceta.base.value = item.asBase;
    formReceta.tiempo.value = item.asTiempo;
    formReceta.grupo.value = item.asGrupo;
    formReceta.observacion.value = item.info;
    formReceta.porcion.value = item.porciones;
    formReceta.gramos.value = item.gramos;
    formReceta.costo.value = item.costo;
    formReceta.calificacion.value = item.califica;

    $$('#printReceta').removeAttribute('disabled');
    $$('#printReceta').setAttribute('href', 'recetas/printReceta?idReceta='+value);

    $.post('recetas/controller/Recetas.php', {method: 'getArticulos', receta: value}, (data, textStatus, xhr)=> {
      /*optional stuff to do after success */
      console.log(data);
      oTable.clear().draw();
      oTable.rows.add(data).draw();

    }, 'json');

  }

  formReceta.idReceta.addEventListener('input', fillForm);

  // funcionalidad de la tabla
  var tblItems = $$('#table_articulos');

  var oTable = $(tblItems).DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    pageLenth: 25,
    columns: [
      {data: 'idArticulo', defaultContent: '' },
      {data: 'nombre', defaultContent: '' },
      {data: 'cantidadRel', defaultContent: '' },
      {data: 'unidad', defaultContent: '' },
      {data: 'costo', defaultContent: '' },
      {data: (row, type, set, meta)=> (row.costo * row.cantidadRel).toFixed(2) }
    ]
  });

})();
</script>