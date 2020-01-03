<div class="row">
    <div class="col-xs-12">
        <h4>Eliminar Artículos</h4>
    </div>
    <div class="col-xs-12">
        
        <div class="row">
                    
                    <form id="formulario">

                    <div class="col-md-6">
                            <div class="form-group">
                                <label style="color: #337ab7;">*Nombre</label>
                                <input list="nombre" class="form-control" id="art" placeholder=" -- Seleccione nombre -- " required maxlength="60" autocomplete="off">
                                <datalist id="nombre">
                                </datalist>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="linea1" style="display: none;">
                                    <option disabled selected> -- linea -- </option>
                                </select>
                                <label style="color: #337ab7;">*Linea</label>
                                <select class="form-control" id="linea2" disabled>
                                    <option disabled selected id="linea2"> -- linea -- </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">*Unidad</label>
                                <select class="form-control" id="unidad" disabled>
                                <option disabled selected> -- Unidad -- </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Presentacion</label>
                                <select class="form-control" id="presentacion" disabled>
                                <option disabled selected>-- Presentación --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Cantidad de unidades en la presentacion</label>
                                <input class="form-control" placeholder="" id="factor" disabled>
                            </div>
                    </div>

                    <div class="col-md-6">
                            <div class="form-group">
                                <label style="color: #337ab7;">Cantidad minima</label>
                                <input class="form-control" placeholder="" id="minimo" disabled>
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Cantidad maxima</label>
                                <input class="form-control" placeholder="" id="maximo" disabled>
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Informacion adicional</label>
                                <input class="form-control" placeholder="" id="info" disabled>
                            </div>
                            <button type="submit" class="btn btn-default" style="color: #337ab7;" id="agregar">Eliminar</button>
                    </div>

                    </form>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                </div>

            <div id="alerta"></div>

    </div>

</div>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
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
tabla+="<option disabled selected> -- Seleccione nombre -- </option>";
res=JSON.parse(respuesta);
$.each(res,function(key,value){
tabla+="<option value="+value.idArticulo+">"+value.nombre+"</option>";
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
$('#idarticulo').val(value.idArticulo);
$('#linea1').html("<option>"+value.linea+"</option>");

tabla1+="<option disabled selected>"+value.unidad+"</option>";
tabla1+="<option>OTROS</option>";
tabla1+="<option>KILOGRAMOS</option>";
tabla1+="<option>LITROS</option>";
tabla1+="<option>PIEZAS</option>";
tabla1+="<option>METROS</option>";
tabla1+="<option>BULTOS</option>";
tabla1+="<option>PAQUETES</option>";
$('#unidad').html(tabla1);

tabla2="<option disabled selected>"+value.unidadA+"</option>";
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

$("#formulario").on('submit', function(evt){
evt.preventDefault();
$.ajax({
url: 'articulo/php/eliminararticulos.php',
data:{id:$('#art').val()},
type: 'POST',
success: function(respuesta){
// $('#alerta').html("<div class='alert alert-success' role='alert'>Nuevo usuario registrado correctamente!</div>");
Swal.fire('Exito', 'Articulo eliminado correctamente!', 'success');
$("#subContainer").load('articulo/view/eliminararticulos.php');
},
});
});

</script>