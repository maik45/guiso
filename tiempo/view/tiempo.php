
<div class="row">
    <div class="col-xs-12">
        <h4>Agregar nuevo Tiempo</h4>
    </div>
    <div class="col-xs-12">
        
        <form id="formulario">
            <div class="form-group">
                <label style="color: #337ab7;">*Clave</label>
                <input class="form-control" placeholder="Ingrese clave" id="clave" required pattern="[0-9]{1,15}" autocomplete="off" maxlength="15">
            </div>
            <div class="form-group">
                <label style="color: #337ab7;">*Descripción</label>
                <input class="form-control" placeholder="Ingrese descripción" id="descripcion" required maxlength="60" autocomplete="off" pattern="[ A-Za-zÁÉÍÓÚáéíóúÑ]{1,60}">
            </div>
            <button type="submit" class="btn btn-default" style="color: #337ab7; margin-top: 30px;" id="agregar">Agregar</button>
        </form>

    </div>
    <div class="col-xs-12 my-1" style="margin-top: 20px">
        <div id="alerta"></div>
    </div>
</div>

<script>

$("#formulario").on('submit', function(evt){
evt.preventDefault();

$.ajax({
url: 'tiempo/php/existe.php',
type: 'POST',
async:false,
data:{
clave:$('#clave').val()
},
success: function(respuesta){
band=respuesta;
},
});

if(band==0){
$.ajax({
url: 'tiempo/php/agregartiempo.php',
type: 'POST',
data:{
clave:$('#clave').val(),
descripcion:$('#descripcion').val()
},
success: function(respuesta){
Swal.fire('Exito', 'Tiempo agregado correctamente !', 'success');
$("#subContainer").load('tiempo/view/tiempo.php');
},
});
}
else{
alert('Tiempo ya existe');
}

});

</script>