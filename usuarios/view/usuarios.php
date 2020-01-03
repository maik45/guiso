<div class="row">
    
    <div class="col-xs-12">
        <h4>Crear nuevo usuario</h4>
    </div>
    <div class="col-xs-12">
         <form id="formulario">
                    
                    <div class="row">
                        
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label style="color: #337ab7;">*Nombre</label>
                                <input type="text" class="form-control" placeholder="Ingrese su nombre" id="nombre" required maxlength="60" autocomplete="off" pattern="[ A-Za-zÁÉÍÓÚáéíóúÑ]{1,60}">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label style="color: #337ab7;">*Usuario</label>
                                <input type="text" class="form-control" placeholder="Ingrese su usuario" id="usuario" required maxlength="60" autocomplete="off" pattern="[ A-Za-z0-9ÁÉÍÓÚáéíóúÑ]{1,60}">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label style="color: #337ab7;">*Contraseña</label>
                                <input class="form-control" type="password" placeholder="Ingrese su Contraseña" id="contrasena" required maxlength="15" autocomplete="off" 
                                pattern="[ A-Za-z.,#0-9ÁÉÍÓÚáéíóúÑ]{1,60}">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label style="color: #337ab7;">*Rol</label>
                                <select class="form-control" id="rol" required>
                                    <option disabled selected value=""> -- Selecione Rol -- </option>
                                    <option value="0">Administrador</option>
                                    <option value="1">Usuario</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label style="color: #337ab7;">DIrección</label>
                                <input class="form-control" placeholder="Ingrese su dirección" id="direccion" maxlength="60" pattern="[ A-Za-z.,#0-9ÁÉÍÓÚáéíóúÑ]{1,60}">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label style="color: #337ab7;">Teléfono</label>
                                <input type="number" class="form-control" placeholder="Ingrese su teléfono" id="telefono" onKeyPress="if(this.value.length==20) return false;" 
                                pattern="[0-9]{1,15}">
                            </div>
                        </div>
                        <!-- <div id="alerta" style="margin-top: 20px;"></div> -->

                    </div>
                        
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <button type="submit" class="btn btn-primary" id="agregar">Registrar</button>
                        </div>
                    </div>

                </form>
    </div>

</div>
<script>

$("#formulario").on('submit', function(evt){

$.ajax({
type: 'POST',
url: 'usuarios/php/existe.php',
data:{
},
success: function(data){
}
});

evt.preventDefault();
$.ajax({
type: 'POST',
url: 'usuarios/php/agregarusuarios.php',
data:{
nombre:$("#nombre").val(),
usuario:$("#usuario").val(),
contrasena:$("#contrasena").val(),
rol:$("#rol").val(),
direccion:$("#direccion").val(),
telefono:$("#telefono").val()
},
success: function(data){
alert('El id del usuario es: '+data);
Swal.fire("Exito", 'Nuevo Usuario Registrado Correctamente', 'success');
$("#nombre").val('');
$("#usuario").val('');
$("#contrasena").val('');
$("#rol").val('');
$("#direccion").val('');
$("#telefono").val('');
$("#subContainer").load('usuarios/view/usuarios.php');
}
});
});

</script>