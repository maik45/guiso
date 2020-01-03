<div class="row">
    
    <div class="col-xs-12">
        <h4>Modificación de Usuarios</h4>
    </div>
    <div class="col-xs-12">
     <form id="formulario">
            <div class="row">
                
                        
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;">Id del usuario</label>
                            <select class="form-control" id="id" required autocomplete="off">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;">Nombre</label>
                            <input class="form-control" placeholder="" id="nombre" required autocomplete="off" maxlength="60" pattern="[ A-Za-zÁÉÍÓÚáéíóúÑ]{1,60}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;">Usuario</label>
                            <input class="form-control" placeholder="" id="usuario" required autocomplete="off" maxlength="60" pattern="[ A-Za-z0-9ÁÉÍÓÚáéíóúÑ]{1,60}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;">Contraseña</label>
                            <input class="form-control" type="" placeholder="" id="contrasena" required autocomplete="off" maxlength="15" pattern="[ A-Za-z.,#0-9ÁÉÍÓÚáéíóúÑ]{1,15}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;">Rol</label>
                            <select class="form-control" id="rol">
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;" >Dirección</label>
                            <input class="form-control" placeholder="" id="direccion" maxlength="60" pattern="[ A-Za-z.,#0-9ÁÉÍÓÚáéíóúÑ]{1,60}">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="form-group">
                            <label style="color: #337ab7;">Teléfono</label>
                            <input type="number" class="form-control" placeholder="" id="telefono" onKeyPress="if(this.value.length==20) return false;" pattern="[0-9]{1,20}">
                        </div>
                    </div>
                    


                    <!-- <div id="alerta"></div> -->


            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-default" style="color: #337ab7;" id="modificar">Modificar</button>
                </div>
            </div>
        </form>
        <!-- /.row (nested) -->
    </div>
</div>

<script>

$.ajax({
url : 'usuarios/php/modificarusuarios.php',
data : {},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
nombre="";
nombre+="<option disabled selected value=''> -- Seleccion id -- </option>";
$.each(res,function(key,value){
nombre+="<option>"+value.id+"</option>";
});
$('#id').html(nombre);
nombre="";
},
});

$("#id").change(function() {
$.ajax({
url : 'usuarios/php/modificarusuarios1.php',
data : {id:$('#id').val()},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
$.each(res,function(key,value){
$('#nombre').val(value.nombre);
$('#usuario').val(value.usuario);
$('#contrasena').val(value.password);
if(value.rol==0){
temp='Administrador';
}
if(value.rol==1){
temp='Usuario';
}
opcion="<option selected value="+value.rol+">"+temp+"</option>";
opcion+="<option value='0'> Administrador </option>";
opcion+="<option value='1'> Usuario </option>";
$('#rol').html(opcion);
$('#direccion').val(value.direccion);
$('#telefono').val(value.telefono);
});
},
});
});

$("#formulario").on('submit', function(evt){
evt.preventDefault();
$.ajax({
url : 'usuarios/php/modificarusuarios2.php',
type : 'POST',
data : {
id:$('#id').val(),
nombre:$('#nombre').val(),
usuario:$('#usuario').val(),
contrasena:$('#contrasena').val(),
rol:$('#rol').val(),
direccion:$('#direccion').val(),
telefono:$('#telefono').val()
},
success:function(respuesta){
// $('#alerta').html("<div class='alert alert-success' role='alert'>ha sido modificado correctamente !</div>");
Swal.fire('Exito', 'Usuario ha sido modificado correctamente !', 'success');
$("#subContainer").load('usuarios/view/modificarusuarios.php');
}
});
});


</script>