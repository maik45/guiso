<div class="row">
<div class="col-lg-12">
    <h1 class="page-header" style="color: #337ab7;">Consultar articulo</h1>
</div>
<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: right; background-color: #EE7561;">
        <a style="cursor: pointer; text-decoration: none; color: #FFFFFF;" id="agregar">Agregar articulo |</a>      
        <a style="cursor: pointer; text-decoration: none; color: #FFFFFF;" id="consultarartc">Consultar articulo por clave |</a> 
        <a style="cursor: pointer; text-decoration: none; color: #FFFFFF;" id="modificar">Modificar articulo |</a> 
        <a style="cursor: pointer; text-decoration:none; color: #FFFFFF;" id="eliminarart">Eliminar articulos</a>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive" style="height: 570px;overflow-x: auto;">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>ID. articulo</th>
                            <th>Nombre</th>
                            <th>Linea</th>
                            <th>Unidad</th>
                            <th>Presentación</th>
                            <th>Cantdad de unidad</th>
                            <th>Minimo</th>
                            <th>Maximo</th>
                            <th>Costo</th>
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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script>
$("#agregar").click(function(){
$("#contenedor").load('articulo/view/articulos.php');
});
$("#consultarartc").click(function(){
$("#contenedor").load('articulo/view/consultararticulosclave.php');
});
$("#modificar").click(function(){
$("#contenedor").load('articulo/view/modificararticulos.php');
});
$("#eliminarart").click(function(){
$("#contenedor").load('articulo/view/eliminararticulos.php');
});


//datatables desde el servidor
//datatables desde el servidor
//datatables desde el servidor
var oTable = $("#dataTables-example").DataTable({
  "processing": true,
  "serverSide": true,
  order: [ [1, 'asc'] ],
  ajax: {
    url: "articulo/php/consultararticulosclave.php",
    type: 'POST',
  },
  columns: [
    {data: 'idArticulo', defaultContent: ''},
    {data: 'nombre', defaultContent: ''},
    {data: 'descripcion', defaultContent: ''},
    {data: 'unidad', defaultContent: ''},
    {data: 'unidadA', defaultContent: ''},
    {data: 'factor', defaultContent: ''},
    {data: 'minimo', defaultContent: ''},
    {data: 'maximo', defaultContent: ''},
    {data: 'costo', defaultContent: ''},
  ]

});



// Swal.fire({
//   title: 'Cargando', 
//   onOpen: ()=>{
//     Swal.showLoading();
//   },
//   allowOutsideClick: false,
//   allowEscapeKey: false
// });
// $.ajax({
// url: 'articulo/php/consultararticulosnombre.php',
// data:{},
// type: 'POST',
// dataType: 'json',
// // async:false,
// success: function(respuesta){
// // respuesta="["+respuesta+"]";
// tabla="";
// // res=JSON.parse(respuesta);
// $.each(respuesta,function(key,value){
// tabla+="<tr>";
// tabla+="<td>"+value.idArticulo+"</td>";
// tabla+="<td>"+value.nombre+"</td>";
// tabla+="<td>"+value.linea+"</td>";
// tabla+="<td>"+value.unidad+"</td>";
// tabla+="<td>"+value.unidadA+"</td>";
// tabla+="<td>"+value.factor+"</td>";
// tabla+="<td>"+value.minimo+"</td>";
// tabla+="<td>"+value.maximo+"</td>";
// tabla+="<td>"+value.costo+"</td>";
// tabla+="</tr>";
// });
// $('#tabla').html(tabla);
// tabla="";
// $('#dataTables-example').DataTable();
// Swal.close();
// },
// });

</script>