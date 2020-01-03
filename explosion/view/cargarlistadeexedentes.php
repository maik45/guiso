<?php @session_start(); ?>
<!-- <div class="row">
  <div class="col-xs-12">
      <h3 class="page-header text-blue">Cargar Lista de Excedentes</h3>
  </div>
</div>
 -->

<div class="row mt-20-px">
  
  <div class="col-xs-12">
    
    <div class="panel panel-default">
      <div class="panel-heading bg-coral text-white">
        Cargar Lista de Excedente de artículos
      </div>
      
      <div class="panel-body text-blue">
        
            
        <div class="row">
            
            <div class="col-xs-12">
                <div class="alert alert-info">
                  Aqui de debe cargar el documento generado en las opciones del menu lateral izquierdo, <b>Crear Lista de Excedentes</b> o <b>Crear archivo de excel para lista de excedentes</b>, sin modificar su estructura, solo la columna "Cantidad" es editable y es la que se tomara encuenta para agregar esa cantidad como excedente de la unidad del cliente que este especificado en la hoja de excel.
                </div>
                <div class="alert alert-danger">
                  La opción de eliminar excedentes, borra los excedentes de todas la unidades que se hayan ingresando con anterioridad.
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
                    <a class="btn btn-default text-blue btn-block btn-lg" data-toggle="collapse" href="#loadFile">Cargar Archivo de Excedentes</a>
                </div>
            </div>
            
            <?php if( $_SESSION['rol_comedor'] === '0' ): ?>
            <div class="col-sm-6">
                <div class="form-group">
                    <button class="btn btn-default text-blue btn-block btn-lg" type="button" id="borrar">Eliminar Excedentes</button>
                </div>
            </div>
            <?php endif; ?>

        </div>
        

        <form action="explosion/loadExcedentes.php" enctype="multipart/form-data" method="post" target="_blank" name="form_excedente" id="form_excedente">

            <div id="loadFile" class="row collapse">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label for="load">Cargar Excel con Excedentes:</label>
                        <input type="file" class="input-group" name="file" id="file" required accept=".xlsx" />
                    </div>
                </div>
                <div class="col-xs-12">
                    <button class="btn btn-primary" type="submit"> Cargar Excedentes </button>
                </div>
            </div>
          
        </form>
    

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

(function(){

  $("#borrar").on('click', function(ev){

    Swal.fire({
      title: 'Advertencia',
      text: "Desea borrar los excedentes del sistema, esta acción es irreversible!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, eliminar'
    }).then((result) => {
      if (result.value) {

        $.post('explosion/php/explosion.php', {method: 'deleteExcedente'}, function(data, textStatus, xhr) {
          if( Number(data) > 0 ){
            Swal.fire(
              'Eliminado!',
              `Los Excedentes han sido borrados, ${data} registros eliminados`,
              'success'
            );
          }
          else{
            Swal.fire('Error', 'Error al eliminar la lista, por favor reintente', 'error');
          }
        });
      }
    })
  });

  document.form_excedente.addEventListener('submit', function(ev){
    setTimeout( ()=>{this.reset()}, 1000 );
  });

})();

</script>