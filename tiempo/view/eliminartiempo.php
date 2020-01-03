
<div class="row">
    <div class="col-xs-12">
        <h4>Eliminar Tiempos</h4>
    </div>
    <div class="col-xs-12">
        <form id="formulario">
                <div class="form-group">
                    <label style="color: #337ab7;">*Clave</label>
                    <input class="form-control" id="opcion1" readonly>
                </div>
                <div class="form-group">
                    <label style="color: #337ab7;">*Descripción</label>
                    <select class="form-control" id="opcion2" required>
                    </select>
                </div>
                <button type="submit" class="btn btn-default" style="color: #337ab7; margin-top: 30px;" id="eliminar">Eliminar</button>
        </form>
    </div>
    <div class="col-xs-12" style="margin-top: 20px">
        <div id="alerta"></div>
    </div>
</div>

<script>

$.ajax({
url: 'tiempo/php/consultartiempoclave.php',
type: 'POST',
dataType:"JSON",
data:{},
async: false,
success: function(respuesta){
// respuesta="["+respuesta+"]";
// res=JSON.parse(respuesta);
tabla="";
tabla+="<option disabled selected value=''> -- Seleccione un tiempo -- </option>";
$.each(respuesta,function(key,value){
tabla+="<option value='"+value.descripcion+"'>"+value.idTiempo+" "+value.descripcion+"</option>";
});
$('#opcion2').html(tabla);
},
});

$("#opcion2").change(function(){
$.ajax({
url: 'tiempo/php/eliminartiempo.php',
type: 'POST',
dataType:"JSON",
data:{nombre:$('#opcion2').val()},
async: false,
success: function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
$.each(res,function(key,value){
tabla+=value.idTiempo;
});
$('#opcion1').val(tabla);
},
});
});

$("#formulario").on('submit', function(evt){
evt.preventDefault();
$.ajax({
url: 'tiempo/php/eliminartiempo1.php',
type: 'POST',
data:{
clave:$('#opcion1').val(),
descripcion:$('#opcion2').val()
},
success: function(respuesta){
Swal.fire('Exito', 'Tiempo eliminado correctamente !', 'success');
$("#subContainer").load('tiempo/view/eliminartiempo.php');
},
});
});

</script>