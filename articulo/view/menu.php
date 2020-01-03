<!-- <div class="row">
    <div class="col-lg-12">
        <h3 class="page-header text-blue"> <i class="fa fa-glass"></i> Administración de Artículos</h3>
    </div>
</div>
 -->
<div class="row mt-20-px">
    
    <div class="col-xs-12">
        
        <div class="panel panel-default">
            <div class="panel-heading bg-coral text-white text-center">
              <h3 class="panel-title"> <i class="fa fa-glass"></i> Administración de Artículos</h3>
            </div>
            <div class="panel-body">
                
                <ul class="nav nav-tabs" id="misTabs">
                  <li class="active"><a data-toggle="tab" href="#consultararticulosclave.php">Consultar</a></li>
                  <li><a data-toggle="tab" href="#articulos.php">Crear</a></li>
                  <li><a data-toggle="tab" href="#modificararticulos.php">Modificar</a></li>
                  <li><a data-toggle="tab" href="#eliminararticulos.php">Eliminar</a></li>
                  <!-- <li><a data-toggle="tab" href="#consultararticulosnombre.php">Eliminar</a></li> -->
                </ul>

                <div class="tab-content" id="subContainer">
                  <div id="consultararticulosclave.php" class="tab-pane fade in active">
                    
                  </div>
                  <div id="articulos.php" class="tab-pane fade">

                  </div>
                  <div id="modificararticulos.php" class="tab-pane fade">

                  </div>
                  <div id="eliminararticulos.php" class="tab-pane fade">

                  </div>
                  <!-- <div id="consultararticulosnombre.php" class="tab-pane fade">

                  </div> -->
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
    $.post('articulo/view/' + this.getAttribute('href').substring(1), {}, (data)=>{
      $('#subContainer').html(data);
      Swal.close();
    }, 'html');
  });

  $('#misTabs li.active a').trigger('click');


})();

</script>