
<div class="row">
    <div class="col-xs-12">
        <h4>Consultar Artículos</h4>
    </div>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>ID. articulo</th>
                        <th>Nombre</th>
                        <th>Linea</th>
                        <th>Unidad</th>
                        <th>Presentación</th>
                        <th>Cantidad de unidad</th>
                        <th>Minimo</th>
                        <th>Maximo</th>
                        <th>Costo</th>
                    </tr>
                </thead>
                <tbody id="tabla">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
//datatables desde el servidor
//datatables desde el servidor
//datatables desde el servidor
var oTable = $("#dataTables-example").DataTable({
  "processing": true,
  "serverSide": true,
  order: [ [0, 'asc'] ],
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




// $.ajax({
// url: 'articulo/php/consultararticulosclave.php',
// data:{},
// type: 'POST',
// dataType: 'json',
// async:false,
// success: function(respuesta){
// respuesta="["+respuesta+"]";
// tabla="";
// res=JSON.parse(respuesta);
// $.each(res,function(key,value){
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
// },
// });

</script>