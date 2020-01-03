<!-- <div class="row">
    <div class="col-lg-12">
        <h3 class="page-header text-blue"> <i class="fa fa-users"></i> Administración de Usuario</h3>
    </div>
</div> -->

<div class="row mt-20-px">
    
    <div class="col-xs-12">
        
        <div class="panel panel-default">
            <div class="panel-heading bg-coral text-white text-center">
              <h3 class="panel-title"> <i class="fa fa-users"></i> Administración de Usuario</h3>
            </div>
            <div class="panel-body">
                
                <ul class="nav nav-tabs" id="misTabs">
                  <li class="active"><a data-toggle="tab" href="#consultarusuarios.php">Consultar</a></li>
                  <li><a data-toggle="tab" href="#usuarios.php">Crear</a></li>
                  <li><a data-toggle="tab" href="#modificarusuarios.php">Modificar</a></li>
                  <li><a data-toggle="tab" href="#eliminarusuarios.php">Eliminar</a></li>
                </ul>

                <div class="tab-content" id="subContainer">
                  <div id="consultarusuarios.php" class="tab-pane fade in active">
                    
                  </div>
                  <div id="usuarios.php" class="tab-pane fade">

                  </div>
                  <div id="modificarusuarios.php" class="tab-pane fade">

                  </div>
                  <div id="eliminarusuarios.php" class="tab-pane fade">

                  </div>
                </div>

            </div>
        </div>
    </div>


</div>

<script>
  
(function(){

  $('#misTabs').on('click', 'a', function(ev){
    Swal.fire({
    title: 'Cargando', 
    onOpen: ()=>{
    Swal.showLoading();
    },
    allowOutsideClick: false,
    allowEscapeKey: false
    });
    $.post('usuarios/view/' + this.getAttribute('href').substring(1), {}, (data)=>{
    $('#subContainer').html(data);
    Swal.close();
    }, 'html');
  });

  $('#misTabs li.active a').trigger('click');


})();

</script>