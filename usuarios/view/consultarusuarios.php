<div class="row">
    <div class="col-xs-12">
        <h4>Usuarios Registrados</h4>
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
                    </tr>
                </thead>
                <tbody id="tabla">
                </tbody>
            </table>
        </div>

    </div>
<!-- /.col-lg-12 -->
</div>

<script>

$.ajax({
url : 'usuarios/php/consultarusuarios.php',
data : {},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
$.each(res,function(key,value){
tabla+="<tr>";
tabla+="<td>"+value.id+"</td>";
tabla+="<td>"+value.nombre+"</td>";
tabla+="<td>"+value.usuario+"</td>";
tabla+="<td>"+value.password+"</td>";
tabla+="<td>"+value.rol+"</td>";
tabla+="<td>"+value.direccion+"</td>";
tabla+="<td>"+value.telefono+"</td>";
tabla+="</tr>";
});
$('#tabla').html(tabla);
tabla="";
$('#dataTables-example').DataTable();
},
});

</script>