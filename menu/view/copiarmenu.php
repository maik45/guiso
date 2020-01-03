<style type="text/css">
div#contenedor label, div#contenedor li, div#contenedor h5, div#contenedor p, div#contenedor td, div#contenedor th {
color: black;
}
</style>

<div class="row" style="margin-top: 31px;">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-bottom: 8px;">
            <div class="panel-heading" style="text-align: center; background-color: #EE7561; color: white;">
            Copia de menus
            </div>
            <div class="panel-body" style="padding: 10px; padding-bottom: 4px;">
                    
                    <div class="row" style="margin-bottom: 5px;"> 
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Semana:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="semana" style="height: 24px;" disabled>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Cliente:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="cliente" style="height: 28px;" disabled>
                    <option disabled selected></option>
                    </select>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Costo/Total:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="0" id="costo" style="height: 24px;" disabled>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>
                    
                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Año:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="lapso" style="height: 24px;" disabled>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Unidad:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="unidad" style="height: 28px;" disabled>
                    <option disabled selected></option>
                    </select>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Elaboro:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="" id="elaboro" style="height: 24px;" disabled>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>


                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*ID menu:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input list="idmenu" class="form-control" id="idm" placeholder=" -- Seleccione menu --" style="height: 28px;">
                    <datalist id="idmenu">
                    </datalist>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*SubUnidad:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input type="" class="form-control" id="subunidad" disabled>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Grupo:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="grupo" style="height: 28px;" disabled>
                    <option disabled selected></option>
                    </select>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>


                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*# Tiempos:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="tiem" style="height: 28px;" disabled>
                    <option disabled selected></option>
                    </select>
                    </div>
                    <div class="col-md-5 col-sm-12" style='color:#337ab7;'>
                    <label style="color: #337ab7;margin-right: 8px;">*dias:</label>
                    lunes
                    <input type="checkbox" name=""  id="checkbox1" disabled>
                    martes
                    <input type="checkbox" name=""  id="checkbox2" disabled>
                    miercoles
                    <input type="checkbox" name=""  id="checkbox3" disabled>
                    jueves
                    <input type="checkbox" name=""  id="checkbox4" disabled>
                    viernes
                    <input type="checkbox" name=""  id="checkbox5" disabled>
                    sabando
                    <input type="checkbox" name=""  id="checkbox6" disabled>
                    domingo
                    <input type="checkbox" name=""  id="checkbox7" disabled>
                    </div>
                    <div class="col-md-2 col-sm-12">
                    <button type="submit" class="btn btn-default" style="color: #337ab7;height: 32px;" id="agregar">Agregar Tiempo</button>
                    </div>
                    </div>

                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<!-- /.row -->
<div class="row" style="margin-top: 20px;">
<div class="col-lg-12">
    <div class="panel panel-default">
        <!-- /.panel-heading -->
        <div class="panel-body" style="padding-bottom: 2px;">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th style='color:#337ab7'>Lunes</th>
                            <th style='color:#337ab7'>Martes</th>
                            <th style='color:#337ab7'>Miercoles</th>
                            <th style='color:#337ab7'>Jueves</th>
                            <th style='color:#337ab7'>Viernes</th>
                            <th style='color:#337ab7'>Sabado</th>
                            <th style='color:#337ab7'>Domingo</th>
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

<script>


temp=0;

$.ajax({
url : 'menu/php/imprimirmenu.php',
data : {},
type : 'POST',
dataType: 'json',
beforeSend:function(){
Swal.fire({
title: 'Cargando', 
onOpen: ()=>{
Swal.showLoading();
},
allowOutsideClick: false,
allowEscapeKey: false
});
},
success:function(respuesta){
Swal.close();
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
$.each(res,function(key,value){
tabla+="<option>"+value.idMenu+"</option>";
});
$('#idmenu').html(tabla);
},
});


$('#idm').on('input',function(){
$.ajax({
url : 'menu/php/consultarmenu2.php',
data : {idmenu:$('#idm').val()},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
$.each(res,function(key,value){
$('#semana').val(value.semana);
$('#tiem').html("<option>"+value.numTiempos+"</option>");
temp=value.numTiempos;
$('#lapso').val(value.lapso);
$('#elaboro').val(value.elaboro);
$('#grupo').html("<option>"+value.descripcion+"</option>");
$('#cliente').html("<option>"+value.nombre+"</option>");
$('#unidad').html("<option>"+value.unidad+"</option>");
$('#subunidad').val(value.subUnidad);
$('#costo').val(value.costoTot);
});

$.ajax({
url : 'menu/php/consultarmenu3.php',
data : {
idmenu:$('#idm').val(),
tiem:temp
},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
$.each(res,function(key,value){
tabla+="<tr>";
tabla+="<td style='color:#337ab7'>"+value.lunes+"</td>";
if(value.lunes!=""){
$('#checkbox1').attr('checked', true);
}
tabla+="<td style='color:#337ab7'>"+value.martes+"</td>";
if(value.martes!=""){
$('#checkbox2').attr('checked', true);
}
tabla+="<td style='color:#337ab7'>"+value.miercoles+"</td>";
if(value.miercoles!=""){
$('#checkbox3').attr('checked', true);
}
tabla+="<td style='color:#337ab7'>"+value.jueves+"</td>";
if(value.jueves!=""){
$('#checkbox4').attr('checked', true);
}
tabla+="<td style='color:#337ab7'>"+value.viernes+"</td>";
if(value.viernes!=""){
$('#checkbox5').attr('checked', true);
}
tabla+="<td style='color:#337ab7'>"+value.sabado+"</td>";
if(value.sabado!=""){
$('#checkbox6').attr('checked', true);
}
tabla+="<td style='color:#337ab7'>"+value.domingo+"</td>";
if(value.domingo!=""){
$('#checkbox7').attr('checked', true);
}
tabla+="</tr>";
});
$('#tabla').html(tabla);
},
});

},
});
});



</script>