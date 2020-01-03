<div class="row">
    <div class="col-xs-12">
        <h4>Eliminar Usuarios</h4>
    </div>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>ID. usuario</th>
                        <th>Nombre</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody id="tabla">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>


function imprimir(){
$.ajax({
url : 'usuarios/php/consultarusuarios.php',
data : {},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
if ( $.fn.DataTable.isDataTable('#dataTables-example') ) {
  $('#dataTables-example').DataTable().destroy();
}
$('#tabla').html('');
$.each(res,function(key,value){
tabla+="<tr>";
tabla+="<td>"+value.id+"</td>";
tabla+="<td>"+value.nombre+"</td>";
tabla+="<td>"+value.usuario+"</td>";
tabla+="<td>"+value.password+"</td>";
tabla+="<td>"+value.rol+"</td>";
tabla+="<td>"+value.direccion+"</td>";
tabla+="<td>"+value.telefono+"</td>";
tabla+="<td><button style='margin-left:auto;margin-right:auto;display:block' class='btn btn-danger' id="+value.id+" name='boton'>Eliminar</button></td>";
tabla+="</tr>";
});
$('#tabla').html(tabla);
tabla="";

$('#dataTables-example').DataTable({destroy: true});

$('button[name="boton"]').click(function(){
temp=$(this).attr("id");
$.ajax({
url : 'usuarios/php/eliminarusuarios.php',
type : 'POST',
data : {id:temp},
success:function(respuesta){
Swal.fire('Exito', 'Usuario eliminado correctamente !', 'success');
$("#subContainer").load('usuarios/view/eliminarusuarios.php');
},
});
});
},
});
}

imprimir();

</script>