<div class="row">
<div class="col-lg-12">
    <h1 class="page-header" style="color: #337ab7;">Consulta de tiempos</h1>
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: right; background-color: #EE7561;">
        <a style="cursor: pointer; text-decoration: none; color: #FFFFFF;" id="agregar">Agregar tiempo |</a> 
        <a style="cursor: pointer; text-decoration: none; color: #FFFFFF;" id="contiemc">Consultar por clave |</a> 
        <a style="cursor: pointer; text-decoration: none; color: #FFFFFF;" id="modificardt">Modificar tiempo |</a>  
        <a style="cursor: pointer; text-decoration:none; color: #FFFFFF;" id="eliminart">Eliminar tiempo</a>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>Clave</th>
                            <th>Descripción</th>
                            <th>Registrado desde</th>
                        </tr>
                    </thead>
                    <tbody id="tabla">
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- /.row -->
<!-- /.row -->

<script>

$("#agregar").click(function(){
$("#contenedor").load('tiempo/view/tiempo.php');
});
$("#contiemc").click(function(){
$("#contenedor").load('tiempo/view/consultartiempoclave.php');
});
$("#modificardt").click(function(){
$("#contenedor").load('tiempo/view/modificartiempo.php');
});
$("#eliminart").click(function(){
$("#contenedor").load('tiempo/view/eliminartiempo.php');
});

$.ajax({
url: 'tiempo/php/consultartiemponombre.php',
type: 'POST',
dataType:"JSON",
data:{},
async: false,
success: function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
$.each(res,function(key,value){
tabla+="<tr>";
tabla+="<td>"+value.idTiempo+"</td>";
tabla+="<td>"+value.descripcion+"</td>";
tabla+="<td>"+value.fecha+"</td>";
tabla+="</tr>";
});
$('#tabla').html(tabla);
},
});

</script>