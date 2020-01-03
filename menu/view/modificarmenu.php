<style type="text/css">
div#contenedor label, div#contenedor li, div#contenedor h5, div#contenedor p, div#contenedor td, div#contenedor th {
color: black;
}
</style>

<div class="row" style="margin-top: 31px;">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-bottom: 8px;">
            <div class="panel-heading" style="text-align: center; background-color: #EE7561; color: white;">
            Modificar menu
            </div>
            <div class="panel-body" style="padding: 10px; padding-bottom: 4px;">
                    <div class="row" style="margin-bottom: 5px;"> 
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Semana:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" style="height: 24px" id="semana" autocomplete="off" readonly />
                    <span class="input-group-addon" style="padding: 3px 16px;">
                    <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Cliente:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="cliente" style="height: 28px;">
                    </select>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Costo/Total:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="0" id="costo" style="height: 24px;background-color: white" disabled>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>
                    
                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Año:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="Ingrese año" id="anio" style="height: 24px;" readonly>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Unidad:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="unidad" style="height: 28px;">
                    <option disabled selected> -- Seleccione Unidad -- </option>
                    </select>
                    </div>          
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">Elaboro:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="Ingrese nombre de quien Elaboro" id="elaboro" style="height: 24px;background-color: white;" disabled="">
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>


                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;" >* id Menu:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input list="idmenu" class="idmenup form-control" style="height: 24px;" >
                    <datalist id="idmenu">
                    </datalist>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">SubUnidad:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="subunidad" style="height: 28px;">
                    <option disabled selected> -- Seleccione subunidad -- </option>
                    </select>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Grupo:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <select class="form-control" id="grupo" style="height: 28px;">
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
                    <select class="form-control" id="tiemp" style="height: 28px;">
                    <option disabled selected> -- Seleccione id tiempo -- </option>
                    </select>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>


                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md- col-sm-12" style='color:#337ab7;'>
                    <label style="color: #337ab7;margin-right: 8px;">*dias:</label>
                    lunes
                    <input type="checkbox" name="" id="checkbox1" disabled> 
                    martes
                    <input type="checkbox" name="" id="checkbox2" disabled>
                    miercoles
                    <input type="checkbox" name="" id="checkbox3" disabled>
                    jueves
                    <input type="checkbox" name="" id="checkbox4" disabled>
                    viernes
                    <input type="checkbox" name="" id="checkbox5" disabled>
                    sabado
                    <input type="checkbox" name="" id="checkbox6" disabled>
                    domingo
                    <input type="checkbox" name="" id="checkbox7" disabled>
                     <!-- <button type="submit" class="btn btn-default" style="color: #337ab7;height: 32px;margin-left: 242px;" id="agregar">Agregar Tiempo</button> -->
                    <BUTTON type='submit' form='formulario' style="float: right;margin-bottom: 20px; background-color:#337ab7;" class="btn btn-primary" id="agregarmenu"> Agregar modificación </BUTTON>
                    <BUTTON style="float: right;margin-bottom: 20px; background-color:#337ab7;" class="btn btn-primary" id="sumar"> Realizar Sumatoria</BUTTON>
                    
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

<form id="formulario">
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
<!-- /.col-lg-12 -->
</div>
</form>

<script>

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
tabla1="";
$.each(res,function(key,value){
tabla1+="<option>"+value.idMenu+"</option>";
});
$('#idmenu').html(tabla1);
},
});

$('.idmenup').on('input',function(){
$.ajax({
url : 'menu/php/modificarmenu.php',
data : {idmenu:$('.idmenup').val()},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
$.each(res,function(key,value){
$('#semana').val(value.semana);
$('#anio').val(value.anio);
$('#tiemp').html("<option>"+value.numTiempos+"</option>");
$('#cliente').html("<option>"+value.cliente+"</option>");
$('#unidad').html("<option>"+value.unidad+"</option>");
$('#subunidad').html("<option>"+value.subunidad+"</option>");
$('#grupo').html("<option>"+value.grupo+"</option>");
$('#elaboro').val(value.elaboro);
$('#costo').val(value.costo);
lapsoi=value.lapsoi;
lapso=value.lapso;
res=lapso.split(",");
lapsolunes=res[1];
lapsomartes=res[2];
lapsomiercoles=res[3];
lapsojueves=res[4];
lapsoviernes=res[5];
lapsosabado=res[6];
lapsodomingo=res[7];
lunes=value.lunes;
martes=value.martes;
miercoles=value.miercoles;
jueves=value.jueves;
viernes=value.viernes;
sabado=value.sabado;
domingo=value.domingo;
if(lunes==1){
$('#checkbox1').attr('checked', true);
}
if(martes==1){
$('#checkbox2').attr('checked', true);
}
if(miercoles==1){
$('#checkbox3').attr('checked', true);
}
if(jueves==1){
$('#checkbox4').attr('checked', true);
}
if(viernes==1){
$('#checkbox5').attr('checked', true);
}
if(sabado==1){
$('#checkbox6').attr('checked', true);
}
if(domingo==1){
$('#checkbox7').attr('checked', true);
}
});
},
});
});

$('.idmenup').on('input',function(){

$.ajax({
url : 'menu/php/modificarmenu1.php',
data : {idmenu:$('.idmenup').val()},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
tabla="";
cont=0;

$('#checkbox1').attr('checked', false);
$('#checkbox2').attr('checked', false);
$('#checkbox3').attr('checked', false);
$('#checkbox4').attr('checked', false);
$('#checkbox5').attr('checked', false);
$('#checkbox6').attr('checked', false);
$('#checkbox7').attr('checked', false);

$.each(res,function(key,value){
tabla+="<tr>";
reslunes=value.lunes;
reslunes=reslunes.split(",");
resmartes=value.martes;
resmartes=resmartes.split(",");
resmiercoles=value.miercoles;
resmiercoles=resmiercoles.split(",");
resjueves=value.jueves;
resjueves=resjueves.split(",");
resviernes=value.viernes;
resviernes=resviernes.split(",");
ressabado=value.sabado;
ressabado=ressabado.split(",");
resdomingo=value.domingo;
resdomingo=resdomingo.split(",");
if(lunes==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+reslunes[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+reslunes[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+reslunes[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsolunes+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(lunes==0){
tabla+="<td style='height:24px'></td>";    
}
if(martes==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+resmartes[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+resmartes[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+resmartes[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsomartes+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(martes==0){
tabla+="<td style='height:24px'></td>";    
}
if(miercoles==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+resmiercoles[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+resmiercoles[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+resmiercoles[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsomiercoles+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(miercoles==0){
tabla+="<td style='height:24px'></td>";    
}
if(jueves==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+resjueves[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+resjueves[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+resjueves[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsojueves+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(jueves==0){
tabla+="<td style='height:24px'></td>";    
}
if(viernes==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+resviernes[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+resviernes[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+resviernes[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsoviernes+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(viernes==0){
tabla+="<td style='height:24px'></td>";    
}
if(sabado==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+ressabado[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+ressabado[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+ressabado[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsosabado+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(sabado==0){
tabla+="<td style='height:24px'></td>";    
}
if(domingo==1){
cont=cont+1;
tabla+=
"<td style='height:24px;color:#337ab7;width:14%;'>"+
"Receta"+
"<br>"+
"<input list='browsers' style='width:130px;margin-bottom:5px' value='"+resdomingo[0]+"' id="+"recetas"+cont+" class='recetasj' autocomplete='off' required>"+
"<datalist id='browsers' class='recetasg'></datalist>"+
"<br>"+
"<label style='margin-right:30px;color:#337ab7;'>Costo</label><label style='color:#337ab7;'>Personas</label>"+
"<br>"+
"<input style='width:65px;background-color:white;margin-bottom:5px' value='"+resdomingo[1]+"' id="+"precior"+cont+" disabled>"+
"<input style='width:65px' value='"+resdomingo[2]+"' id="+"personas"+cont+" required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"Fecha"+
"<br>"+
"<input style='width:80px;background-color:white;' value='"+lapsodomingo+"' class="+"fecha"+cont+" disabled>"+
"</td>";
}
if(domingo==0){
tabla+="<td style='height:24px'></td>";    
}
tabla+="</tr>";
});

$('#tabla').html(tabla);

$.ajax({
url : 'menu/php/agregarmenu7.php',
data : {},
type : 'POST',
dataType: 'json',
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
nombre="";
$.each(res,function(key,value){
nombre+="<option>"+value.nombre+" , "+value.idReceta+"</option>";
});
$('.recetasg').html(nombre);
},
});

$('.recetasj').on('input',function(){
aux=$(this).val().split(' , ');
aux1=$(this).attr('id');
aux2=aux1.replace("recetas","precior");
if(aux!=""){
$.ajax({
url : 'menu/php/agregarmenu11.php',
data : {clave:aux[1]},
type : 'POST',
success:function(respuesta){
$('#'+aux2).val(respuesta);
},
});
}
});

}, 
});
});

$("#sumar").click(function(){
for (var i=1;i<=cont;i++){
if(i==1){
costosunidad=Number($('#precior'+i).val())*Number($('#personas'+i).val());
}
if(i>1){
costosunidad=costosunidad+Number($('#precior'+i).val())*Number($('#personas'+i).val());
}
}
alert('costo/Total: '+costosunidad.toFixed(2));
$('#costo').val(costosunidad.toFixed(2));
});

$("#formulario").on('submit',function(evt){
evt.preventDefault();
//$("#agregarmenu")[0].disabled=true;

costosunidad=0;
temp1='';
temp2='';
temp3='';
temp4='';
band=0;

for (var i=1;i<=cont;i++){

if(i==1){
temp1=$('.fecha'+i).val();
}
if(i>1){
temp1+=','+$('.fecha'+i).val();
}
if(i==1){
aux=$('#recetas'+i).val().split(",");
temp2=aux[0];
}
if(i>1){
aux=$('#recetas'+i).val().split(",");
temp2+=','+aux[0];
}
if(i==1){
temp3=$('#precior'+i).val();
}
if(i>1){
temp3+=','+$('#precior'+i).val();
}
if(i==1){
temp4=$('#personas'+i).val();
}
if(i>1){
temp4+=','+$('#personas'+i).val();
}
}

for (var i=1;i<=cont;i++){
if(i==1){
costosunidad=Number($('#precior'+i).val())*Number($('#personas'+i).val());
}
if(i>1){
costosunidad=costosunidad+Number($('#precior'+i).val())*Number($('#personas'+i).val());
}
}

for (var i=1;i<=cont;i++){
aux3=$('#recetas'+i).val().split(",");
$.ajax({
url : 'menu/php/existe.php',
data : {
clave:aux3[0]
},
type : 'POST',
async:false,
success:function(respuesta){
if(respuesta==0){
band=1;
}
},
});
}

if(band==1){
alert("receta no se existe");
}
if(band==0){
$.ajax({
url : 'menu/php/modificarmenu2.php',
type : 'POST',
data : {
idmenu:$('.idmenup').val(),
fecharecetas:temp1,
recetas:temp2,
precio:temp3,
numpersonas:temp4,
costosunidad:costosunidad.toFixed(2)
},
success:function(respuesta){
Swal.fire("Exito", 'Menu agregado correctamente', 'success');
$("#agregarmenu")[0].disabled=false;
$("#contenedor").load('menu/view/modificarmenu.php');
},
});
}

});

</script>