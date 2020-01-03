<div class="row">
    <div class="col-xs-12">
        <h4>Agregar nuevo tiempo</h4>
    </div>
    <div class="col-xs-12">
      <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Descripción</th>
                        <th>Registrado desde</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
      </div>  
    </div>
</div>

<script>

var oTable = $('#dataTables-example').DataTable({
    ajax: {
        url: 'tiempo/php/consultartiempoclave.php',
        type: 'post',
        dataSrc: ''
    },
    columns: [
        {data: 'idTiempo', defaultContent: ''},
        {data: 'descripcion', defaultContent: ''},
        {data: 'fecha', defaultContent: ''},
    ]
});

// $.ajax({
// url: 'tiempo/php/consultartiempoclave.php',
// type: 'POST',
// dataType:"JSON",
// data:{},
// async: false,
// success: function(respuesta){
// respuesta="["+respuesta+"]";
// res=JSON.parse(respuesta);
// tabla="";
// $.each(res,function(key,value){
// tabla+="<tr>";
// tabla+="<td>"+value.idTiempo+"</td>";
// tabla+="<td>"+value.descripcion+"</td>";
// tabla+="<td>"+value.fecha+"</td>";
// tabla+="</tr>";
// });
// $('#tabla').html(tabla);
// },
// });

</script>