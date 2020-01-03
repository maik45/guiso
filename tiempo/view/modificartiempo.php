
<div class="row">
    <div class="col-xs-12">
        <h4>Modificar Tiempos</h4>
    </div>
    <div class="col-xs-12">
        <form id="formulario">
            <div class="form-group">
                <label style="color: #337ab7;">*Clave</label>
                <select class="form-control" id="clave" required autocomplete="off">
                </select>
            </div>
            <div class="form-group">
                <label style="color: #337ab7;">*Descripción</label>
                <input class="form-control" id="descripcion" required autocomplete="off" pattern="[ A-Za-zÁÉÍÓÚáéíóúÑ]{1,60}">
            </div>
            <button type="submit" class="btn btn-default" style="color: #337ab7; margin-top: 30px;" id="agregar">Agregar</button>
        </form>
              
    
    </div>
    <div class="col-xs-12" style="margin-top: 20px">
        <div id="alerta"></div>
    </div>
</div>

<script>

$.ajax({
url: 'tiempo/php/modificartiempo.php',
data:{},
type: 'POST',
dataType: 'json',
success: function(respuesta){
respuesta="["+respuesta+"]";
tabla="";
tabla="<option disabled selected value=''> -- Seleccione tiempo -- </option>";
res=JSON.parse(respuesta);
$.each(res,function(key,value){
tabla+="<option value="+value.idTiempo+">"+value.idTiempo+" "+value.descripcion+"</option>";
});
$('#clave').html(tabla);
},
});

$("#clave").change(function(){
$.ajax({
url: 'tiempo/php/modificartiempo1.php',
type: 'POST',
data:{clave:$('#clave').val()},
success: function(respuesta){
$('#descripcion').val(respuesta);
},
});
});

$("#formulario").on('submit', function(evt){
evt.preventDefault();
$.ajax({
url: 'tiempo/php/modificartiempo2.php',
type: 'POST',
data:{
clave:$('#clave').val(),
descripcion:$('#descripcion').val()
},
success: function(respuesta){
Swal.fire('Exito', 'Tiempo modificado correctamente !', 'success');
$("#subContainer").load('tiempo/view/modificartiempo.php');
},
});
});

</script>