<div class="row">
    
    <div class="col-xs-12">
        <h4>Agregar nuevos artículos</h4>
    </div>
    <div class="col-xs-12">
        <div class="row">
            <form id="formulario">

                    <div class="col-md-6">

                            <div class="form-group">
                                <label style="color: #337ab7;">*Código del articulo</label>
                                <input class="form-control" placeholder="Ingrese codigo del articulo" id="codigoarticulo" required autocomplete="off" maxlength="60" pattern="[ A-Za-z0-9]{1,60}">
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">*Nombre</label>
                                <input class="form-control" placeholder="Ingrese nombre del articulo" id="nombre" required maxlength="60" autocomplete="off" maxlength="60" pattern="[ A-Za-z0-9ÁÉÍÓÚáéíóúÑ]{1,60}">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="linea1" style="display: none;">
                                </select>
                                <label style="color: #337ab7;">*Linea</label>
                                <select class="form-control" id="linea2" required>
                                </select >
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">*Unidad</label>
                                <select class="form-control" id="unidad" required>
                                <option disabled selected value=''>-- Selecciones una opción --</option>
                                <option value="OTROS">OTROS</option>
                                <option value="KILOGRAMOS">KILOGRAMOS</option>
                                <option value="LITROS">LITROS</option>
                                <option value="PIEZAS">PIEZAS</option>
                                <option value="METROS">METROS</option>
                                <option value="BULTOS">BULTOS</option>
                                <option value="PAQUETES">PAQUETES</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Presentación</label>
                                <select class="form-control" id="presentacion">
                                <option disabled selected value=''>-- Selecciones una opción --</option>
                                <option value="OTROS">OTROS</option>
                                <option value="KILOGRAMOS">KILOGRAMOS</option>
                                <option value="LITROS">LITROS</option>
                                <option value="PIEZAS">PIEZAS</option>
                                <option value="METROS">METROS</option>
                                <option value="BULTOS">BULTOS</option>
                                <option value="PAQUETES">PAQUETES</option>
                                </select>
                            </div>
 
                            <div class="form-group">
                                <label style="color: #337ab7;">Cantidad de unidades en la presentación</label>
                                <input type="text" class="form-control" placeholder="Ingrese cantidad de unidades" id="cantidadpresentacion" onKeyPress="if(this.value.length==6) return false;" 
                                pattern="[0-9].[0-9]|[0-9]{1,6}">
                            </div>
                    </div>

                    <div class="col-md-6">
                            <div class="form-group">
                                <label style="color: #337ab7;">Cantidad minima</label>
                                <input type="text" class="form-control" placeholder="Ingrese minimo" id="minimo" onKeyPress="if(this.value.length==8) return false;" pattern="[0-9].[0-9]|[0-9]{1,6}">
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Cantidad maxima</label>
                                <input type="text" class="form-control" placeholder="Ingrese maximo" id="maximo" onKeyPress="if(this.value.length==8) return false;" pattern="[0-9].[0-9]|[0-9]{1,6}">
                            </div>
                            <div class="form-group">
                                <label style="color: #337ab7;">Información adicional</label>
                                <input class="form-control" placeholder="Ingrese información adicional" id="informacion" maxlength="120" pattern="[ A-Za-z.,#0-9ÁÉÍÓÚáéíóúÑ]{1,120}">
                            </div>

                            <button type="submit" class="btn btn-default" style="color: #337ab7;" id="agregar">Agregar</button>
                    </div>

                    </form>
        </div>
    </div>

    <div class="col-xs-12 my-1">
        <div id="alerta"></div>
    </div>

</div>

<script>

$.ajax({
url : 'articulo/php/agregararticulo.php',
data : {},
type : 'POST',
dataType: 'json',
success:function(respuesta){
tabla="";
tabla="<option disabled selected value='' > -- Seleccione linea -- </option>";
$.each(respuesta,function(key,value){
tabla+="<option>"+value.descripcion+"</option>";
});
$('#linea2').html(tabla);
},
});

$("#linea2").change(function(){
$.ajax({
url : 'articulo/php/agregararticulo1.php',
data : {nombre:$('#linea2').val()},
type : 'POST',
async:false,
success:function(respuesta){
tabla="";
tabla+="<option>"+respuesta+"</option>";
$('#linea1').html(tabla);
},
});
});

$("#formulario").on('submit',function(evt){
evt.preventDefault();
$.ajax({
url: 'articulo/php/existe.php',
type: 'POST',
async:false,
data:{
clave:$('#codigoarticulo').val()
},
success: function(respuesta){
band=respuesta;
},
});
if(band==0){
$.ajax({
url:'articulo/php/agregararticulo2.php',
type:'POST',
data:{
codigoarticulo:$('#codigoarticulo').val(),
nombre:$('#nombre').val(),
linea1:$('#linea1').val(),
linea2:$('#linea2').val(),
unidad:$('#unidad').val(),
minimo:$('#minimo').val(),
maximo:$('#maximo').val(),
cantidadpresentacion:$('#cantidadpresentacion').val(),
presentacion:$('#presentacion').val(),
informacion:$('#informacion').val()
},
success:function(respuesta){
Swal.fire('Exito', 'Articulo agregado correctamente !', 'success');
$("#subContainer").load('articulo/view/articulos.php');
},
});
}else{
alert('articulo ya existe');
}
});

</script>