<!-- <div class="row mt-20-px">
    <div class="col-xs-12">
        <h3 class="page-header text-blue">Actualización Masiva de Costos de las Recetas</h3>
    </div>
</div> -->
<style>
    #megaBtn{
        border: solid 1px #2E519F;
        border-radius: 10px;
        background: white;
        transition: all .5s;
    }
    #megaBtn:hover{
        box-shadow: 0 0 3px 1px black;
        background: #2E519F;
        color: white !important;
    }
</style>

<div class="row mt-20-px">
    <div class="col-xs-12">

        <div class="panel panel-default">
            <div class="panel-heading bg-coral text-white">
                Actualización de Costos
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1 col-xs-12 col-xs-offset-0">

                        <div id="megaBtn" class="pointer text-center text-blue">
                            <h2>Realizar actualización masiva de costos</h2>
                        </div>

                    </div>
                </div>
                
                <div class="row my-1">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="alert alert-info">
                            Realiza la actualización de costos de las recetas de forma automatica, una vez que los precios de los articulos han sido modificados. Si no se ejecuta esta
                            acción de los valores del costo total de los menus podria dar un resultado no esperado ya que el costo de la recetas tomaria el valor del costo de los
                            articulos antes de haber sido modificados
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    (function(){

        $('#megaBtn').on('click', function(ev){

          Swal.fire({
            title: 'Realizar la actualizacion Masiva',
            text: '¿Desea actualizar el costo de todos los artículos?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, actualizar'
          }).then((result) => {
            if (result.value) {
             
                Swal.fire({
                  title: 'Cargando', 
                  onOpen: ()=>{
                    Swal.showLoading();
                  },
                  allowOutsideClick: false,
                  allowEscapeKey: false
                });
                $.post('recetas/controller/Recetas.php', {method: 'actualizacionMasiva'}, function(data, textStatus, xhr) {
                    /*optional stuff to do after success */
                    if( data.status )
                        Swal.fire("Correcto", data.msg, 'success');
                    else
                        Swal.fire("Error", data.msg, 'error');
                }, 'json');

            }

          });

        });

    })();
</script>