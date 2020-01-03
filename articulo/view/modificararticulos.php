<div class="row">
    <div class="col-xs-12">
        <h4>Modificar Artículos</h4>
    </div>
    <div class="col-xs-12">
        <div class="row">

            <form id="formulario">

            <div class="col-md-6">
                    <div class="form-group">
                        <label style="color: #337ab7;">*Nombre</label>
                        <input list="nombre" class="form-control" id="art" placeholder=" -- Seleccione nombre -- " required maxlength="60" pattern="[ A-Za-z0-9ÁÉÍÓÚáéíóúÑ]{1,60}" autocomplete="off">
                        <datalist id="nombre">
                        </datalist>
                    </div>
                    <div class="form-group">
                    <label style="color: #337ab7;">*Tiempo</label>
                        <select class="form-control" id="linea1" style="display: none;">
                        </select>
                        <select class="form-control" id="linea2" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="color: #337ab7;">*Unidad</label>
                        <select class="form-control" id="unidad" required>
                        <option disabled selected> -- Unidad -- </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="color: #337ab7;">Presentación</label>
                        <select class="form-control" id="presentacion">
                        <option disabled selected>-- Presentación --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="color: #337ab7;">Cantidad de unidades en la presentación</label>
                        <input type="text" class="form-control" placeholder="" id="factor" onKeyPress="if(this.value.length==6) return false;" pattern="[0-9].[0-9]|[0-9]{1,6}">
                    </div>
            </div>

            <div class="col-md-6">
                    <div class="form-group">
                        <label style="color: #337ab7;">Cantidad minima</label>
                        <input type="text" class="form-control" placeholder="" id="minimo" onKeyPress="if(this.value.length==8) return false;" pattern="[0-9].[0-9]|[0-9]{1,6}">
                    </div>
                    <div class="form-group">
                        <label style="color: #337ab7;">Cantidad maxima</label>
                        <input type="text" class="form-control" placeholder="" id="maximo" onKeyPress="if(this.value.length==8) return false;" pattern="[0-9].[0-9]|[0-9]{1,6}">
                    </div>
                    <div class="form-group">
                        <label style="color: #337ab7;">Información adicional</label>
                        <input class="form-control" placeholder="" id="info" maxlength="120" pattern="[ A-Za-z.,#0-9ÁÉÍÓÚáéíóúÑ]{1,120}">
                    </div>
                    <button type="submit" class="btn btn-default" style="color: #337ab7;" id="agregar">Modificar</button>
            </div>

            </form>
            <!-- /.col-lg-6 (nested) -->
            <!-- /.col-lg-6 (nested) -->
        </div>

        <div class="col-md-12">
            <div id="alerta"></div>
        </div>

    </div>
</div>

<script>

$.ajax({
url: 'articulo/php/modificararticulos.php',
data:{},
type: 'POST',
dataType: 'json',
async:false,
success: function(respuesta){
respuesta="["+respuesta+"]";
tabla="";
res=JSON.parse(respuesta);
cont=0;
$.each(res,function(key,value){
tabla+="<option selected value="+value.idArticulo+">"+value.nombre+"</option>";
cont++;
});
$('#nombre').html(tabla);
},
});

$('#art').on('input',function(){

$.ajax({
url: 'articulo/php/modificararticulos1.php',
data:{clave:$('#art').val()},
type: 'POST',
dataType: 'json',
async:false,
success: function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla1="";
tabla2="";
$.each(res,function(key,value){
$('#codigoarticulo').val(value.idArticulo);
$('#linea1').html("<option>"+value.linea+"</option>");

tabla1+="<option selected>"+value.unidad+"</option>";
tabla1+="<option>OTROS</option>";
tabla1+="<option>KILOGRAMOS</option>";
tabla1+="<option>LITROS</option>";
tabla1+="<option>PIEZAS</option>";
tabla1+="<option>METROS</option>";
tabla1+="<option>BULTOS</option>";
tabla1+="<option>PAQUETES</option>";
$('#unidad').html(tabla1);

tabla2="<option selected>"+value.unidadA+"</option>";
tabla2+="<option>OTROS</option>";
tabla2+="<option>KILOGRAMOS</option>";
tabla2+="<option>LITROS</option>";
tabla2+="<option>PIEZAS</option>";
tabla2+="<option>METROS</option>";
tabla2+="<option>BULTOS</option>";
tabla2+="<option>PAQUETES</option>";
$('#presentacion').html(tabla2);

$('#factor').val(value.factor);
$('#minimo').val(value.minimo);
$('#maximo').val(value.maximo);
$('#info').val(value.info);

});
},
});
});

$('#art').on('input',function(){
$.ajax({
url: 'articulo/php/modificararticulos2.php',
type: 'POST',
dataType: 'json',
data:{id:$('#linea1').val()},
async:false,
success: function(respuesta){
respuesta="["+respuesta+"]";
tabla="";
res=JSON.parse(respuesta);
$.each(res,function(key,value){
tabla+="<option>"+value.descripcion+"</option>";
});
$('#linea2').html(tabla);
},
});
});

$("#linea2").change(function(){
$.ajax({
url: 'articulo/php/modificararticulos4.php',
type: 'POST',
data:{nombre:$('#linea2').val()},
success: function(respuesta){
$('#linea1').html("<option>"+respuesta+"</option>");
},
});
});

$("#formulario").on('submit',function(evt){
evt.preventDefault();
$.ajax({
url: 'articulo/php/modificararticulos3.php',
type: 'POST',
data:{
clave:$('#art').val(),
linea1:$('#linea1').val(),
unidad:$('#unidad').val(),
presentacion:$('#presentacion').val(),
factor:$('#factor').val(),
minimo:$('#minimo').val(),
maximo:$('#maximo').val(),
info:$('#info').val()
},
success: function(respuesta){
Swal.fire('Exito', 'Articulo modificado correctamente !', 'success');
$("#subContainer").load('articulo/view/modificararticulos.php');
},
});
});

</script>