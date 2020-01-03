<style type="text/css">
div#contenedor label, div#contenedor li, div#contenedor h5, div#contenedor p, div#contenedor td, div#contenedor th {
color: black;
}
</style>

<div class="row" style="margin-top: 31px;">
    <div class="col-lg-12">
        <div class="panel panel-default" style="margin-bottom: 8px;">
            <div class="panel-heading" style="text-align: center; background-color: #EE7561; color: white;">
            Ingresar encabezado
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
                    <input class="form-control" placeholder="0" id="costo" style="height: 24px;background-color: white" disabled="">
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                    <!-- /.col-lg-6 (nested) -->
                    </div>
                    
                    <div class="row" style="margin-bottom: 5px;">
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Fecha:</label>
                    </div>
                    <div class="col-md-3 col-sm-12">
                    <input class="form-control" placeholder="Ingrese fecha" id="fecha" style="height: 24px;" readonly>
                    </div>
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*Unidad:</label>
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
                    <input class="form-control" placeholder="Ingrese nombre de quien Elaboro" id="elaboro" style="height: 24px;">
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
                    <div class="col-md-1 col-sm-12" style="margin-top: 6px;">
                    <label style="color: #337ab7;">*SubUnidad:</label>
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
                    <div class="col-md- col-sm-12" style='color:#337ab7;'>
                    <label style="color: #337ab7;margin-right: 8px;margin-left: 0px;">Todos</label>
                    <input type="checkbox" name="" id="todos">
                    <label style="color: #337ab7;margin-right: 8px;">Ninguno</label>
                    <input type="checkbox" name="" id="ninguno">
                    <label style="color: #337ab7;margin-right: 8px;">*dias:</label>
                    lunes
                    <input type="checkbox" name="" id="lunes">
                    martes
                    <input type="checkbox" name="" id="martes">
                    miercoles
                    <input type="checkbox" name="" id="miercoles">
                    jueves
                    <input type="checkbox" name="" id="jueves">
                    viernes
                    <input type="checkbox" name="" id="viernes">
                    sabado
                    <input type="checkbox" name="" id="sabado">
                    domingo
                    <input type="checkbox" name="" id="domingo">
                    <button type="submit" class="btn btn-default" style="color: #337ab7;height: 32px;margin-left: 242px;" id="agregar">Agregar Tiempo</button>
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
<form id="form">
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

<BUTTON type='submit' style="float: right;margin-bottom: 20px background-color:#337ab7;" class="btn btn-primary" id="agregarmenu" disabled> Agregar menu </BUTTON>
<BUTTON type='button' style="float: right;margin-bottom: 20px; background-color:#337ab7; margin-right: 5px" class="btn btn-primary" id="sumatoria"> REALIZAR SUMATORIA</BUTTON>

</div>
<!-- /.col-lg-12 -->
</div>
</form>

<script>

band1=0;band2=0;band3=0;band4=0;band5=0;band6=0;band7=0;
lunes="";martes="";miercoles="";jueves="";viernes="";sabado="";domingo="";

$("#todos").click(function() { 
if ($("#todos").is( ":checked")){ 
$("#ninguno").prop("checked", false);
$("#lunes").prop("checked", true); 
$("#martes").prop("checked", true); 
$("#miercoles").prop("checked", true); 
$("#jueves").prop("checked", true); 
$("#viernes").prop("checked", true); 
$("#sabado").prop("checked", true); 
$("#domingo").prop("checked", true); 
band1=1;band2=1;band3=1;band4=1;band5=1;band6=1;band7=1;
}
});

$("#ninguno").click(function() { 
if ($("#ninguno").is( ":checked")){
$("#todos").prop("checked", false); 
$("#lunes").prop("checked", false); 
$("#martes").prop("checked", false); 
$("#miercoles").prop("checked", false); 
$("#jueves").prop("checked", false); 
$("#viernes").prop("checked", false); 
$("#sabado").prop("checked", false); 
$("#domingo").prop("checked", false); 
band1=0;band2=0;band3=0;band4=0;band5=0;band6=0;band7=0;
}
});

$("#lunes").click(function() { 
if ($("#lunes").is( ":checked")){ 
band1=1;
}else{
band1=0;
} 
});
$("#martes").click(function() { 
if ($("#martes").is( ":checked")){ 
band2=1;
}else{
band2=0;
} 
}); 
$("#miercoles").click(function() { 
if ($("#miercoles").is( ":checked")){ 
band3=1;
}else{
band3=0;
} 
}); 
$("#jueves").click(function() { 
if ($("#jueves").is( ":checked")){ 
band4=1;
}else{
band4=0;
} 
}); 
$("#viernes").click(function() { 
if ($("#viernes").is( ":checked")){ 
band5=1;
}else{
band5=0;
} 
}); 
$("#sabado").click(function() { 
if ($("#sabado").is( ":checked")){ 
band6=1;
}else{
band6=0;
} 
}); 
$("#domingo").click(function() { 
if ($("#domingo").is( ":checked")){ 
band7=1;
}else{
band7=0;
} 
});

(function(){
$('#datetimepicker1').datepicker({
format: "dd-mm-yyyy",
language: 'es',
autoclose: true,
});
})();

$.ajax({
url : 'menu/php/agregarmenu.php',
data : {},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
idTiempo="";
idTiempo+="<option disabled selected> -- Seleccione id tiempo -- </option>";
$.each(res,function(key,value){
idTiempo+="<option>"+value.idTiempo+"</option>";
});
$('#tiemp').html(idTiempo);
},
});

$.ajax({
url : 'menu/php/agregarmenu1.php',
data : {},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
descripcion="";
descripcion+="<option disabled selected> -- Selecione Grupo -- </option>";
$.each(res,function(key,value){
descripcion+="<option value="+value.idgrupo+">"+value.descripcion+"</option>";
});
$('#grupo').html(descripcion);
},
});

$.ajax({
url : 'menu/php/agregarmenu2.php',
data : {},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
unidad="";
unidad+="<option disabled selected> -- Selecione Cliente -- </option>";
$.each(res,function(key,value){
unidad+="<option value="+value.idcliente+">"+value.nombre+"</option>";
});
$('#cliente').html(unidad);
},
});

$('#cliente').on('change',function(){

$.ajax({
url : 'menu/php/agregarmenu3.php',
data : {nombre:$('#cliente').val()},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
unidad="";
$.each(res,function(key,value){
unidad+="<option value="+value.idunidad+">"+value.unidad+"</option>";
});
$('#unidad').html(unidad);

$.ajax({
url : 'menu/php/agregarmenu4.php',
data : {nombre:$('#unidad').val()},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
unidad="";
$.each(res,function(key,value){
unidad+="<option value="+value.idsubunidad+">"+value.subunidad+"</option>";
});
$('#subunidad').html(unidad);
},
});

},
});
});

$('#unidad').on('change',function(){
$.ajax({
url : 'menu/php/agregarmenu4.php',
data : {nombre:$('#unidad').val()},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
unidad="";
$.each(res,function(key,value){
unidad+="<option value="+value.idsubunidad+">"+value.subunidad+"</option>";
});
$('#subunidad').html(unidad);
},
});
});

$('#semana').on('change',function(){
fecha=$('#semana').val();
$.ajax({
url : 'menu/php/agregarmenu5.php',
data : {semana:$('#semana').val()},
type : 'POST',
success:function(respuesta){
vector=respuesta.split(",");
$('#semana').val(vector[0]);
$('#fecha').val(vector[1]);

$.ajax({
url : 'menu/php/agregarmenu10.php',
data : {fecha:fecha},
type : 'POST',
success:function(respuesta){
vector=respuesta.split(",");
lunes=vector[1];
martes=vector[2];
miercoles=vector[3];
jueves=vector[4];
viernes=vector[5];
sabado=vector[6];
domingo=vector[7];
},
});

},
});
});

$('#tiemp').on('change',function(){
tiemp=parseInt($('#tiemp').val());
});

$("#agregar").click(function(){
$('#agregarmenu')[0].disabled=false;

bandf=0;

if($("#semana").val()==""){
alert("no hay semana");
bandf=1;
}
if($("#tiemp").val()==null){
alert("Seleccione un tiempo");
bandf=1;
}
if($("#cliente").val()==null){
alert("Seleccione un cliente");
bandf=1;
}
if($("#unidad").val()==null){
alert("Seleccione unidad");
bandf=1;
}
if($("#subunidad").val()==null){
alert("Seleccione subunidad");
bandf=1;
}
if($("#elaboro").val()==""){
alert("Falta quien elaboro");
bandf=1;
}
if($("#grupo").val()==null){
alert("Seleccione un grupo");
bandf=1;
}
if(band1==0&&band2==0&&band3==0&&band4==0&&band5==0&&band6==0&&band7==0){
alert("Seleccione un dia");
bandf=1;
}

if(bandf==0){

tabla="";
cont=0;

for (i=0;i<tiemp;i++){
tabla+="<tr>";

if (band1==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7;'>Id</label><label style='color:#337ab7'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;color:#337ab7;' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7;' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;color:#337ab7;'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;color:#337ab7;' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7;' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3' >"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7;' value="+lunes+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band1==0){
tabla+=
"<td style='height:24px'></td>";    
}

if (band2==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7'>Id</label><label style='color:#337ab7'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;color:#337ab7' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;;color:#337ab7'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;;color:#337ab7' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7;color:#337ab7' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7' value="+martes+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band2==0){
tabla+=
"<td style='height:24px'></td>";    
}

if (band3==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7'>Id</label><label style='color:#337ab7'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;color:#337ab7' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;;color:#337ab7'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;;color:#337ab7' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7' value="+miercoles+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band3==0){
tabla+=
"<td style='height:24px'></td>";    
}

if (band4==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7;'>Id</label><label style='color:#337ab7;'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;;color:#337ab7' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7;' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;;color:#337ab7;'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;color:#337ab7;' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7;' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7;' value="+jueves+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band4==0){
tabla+=
"<td style='height:24px;width:14%;'></td>";    
}

if (band5==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7;'>Id</label><label style='color:#337ab7'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;color:#337ab7;' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7;x' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;color:#337ab7;'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;color:#337ab7;' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7;' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7;' value="+viernes+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band5==0){
tabla+=
"<td style='height:24px'></td>";    
}

if (band6==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7;'>Id</label><label style='color:#337ab7'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;color:#337ab7;' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7;' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;color:#337ab7;'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;color:#337ab7;' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7;' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7;' value="+sabado+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band6==0){
tabla+=
"<td style='height:24px'></td>";    
}

if (band7==1){
cont=cont+1;
tabla+=
"<td style='height:24px;width:14%;'>"+
"<label style='margin-right:40px;color:#337ab7'>Id</label><label style='color:#337ab7'>Receta</label>"+
"<br>"+
"<input style='width:20%;margin-right:10px;color:#337ab7;' class="+"id"+cont+" disabled>"+
"<input list='browsers' style='width:60%;color:#337ab7;' class='receta1' id="+cont+" autocomplete='off' required>"+
"<datalist id='browsers' class='receta2'></datalist>"+
"<br>"+
"<label style='margin-right:15px;margin-top:10px;color:#337ab7'>Costo</label><label style='color:#337ab7'>Personas</label>"+
"<br>"+
"<input style='width:20%;margin-top:2px;margin-right:10px;color:#337ab7' class="+"costo"+cont+" disabled>"+
"<input style='width:60%;color:#337ab7' class="+"cantidad"+cont+" name='cantidad' required pattern='^[0-9]{0,3}$' maxlength='3'>"+
"<br>"+
"<input style='width:80px;margin-top:10px;color:#337ab7' value="+domingo+" class="+"fecha"+cont+" disabled>"+
"</td>";
}
if (band7==0){
tabla+=
"<td style='height:24px'></td>";    
}

tabla+="</tr>";
}
$('#tabla').html(tabla);

$.ajax({
url : 'menu/php/agregarmenu7.php',
data : {},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
nombre="";
$.each(res,function(key,value){
nombre+="<option>"+value.nombre+"</option>";
});
$('.receta2').html(nombre);
},
});

$('.receta1').on('input',function(){
$.ajax({
url : 'menu/php/agregarmenu8.php',
data : {
nombre:$(this).val(),
id:$(this).attr('id')
},
type : 'POST',
success:function(respuesta){
res=respuesta.split(",");
$('.id'+res[0]).val(res[1]);
$('.costo'+res[0]).val(res[2]);
},
});
});
}
});

$("#sumatoria").click(function(){
for (var i=1;i<=cont;i++){
if(i==1){
costosunidad=Number($('.costo'+i).val())*Number($('.cantidad'+i).val());
}
if(i>1){
costosunidad=costosunidad+Number($('.costo'+i).val())*Number($('.cantidad'+i).val());
}
}
alert('costo/Total: '+costosunidad.toFixed(2));
$('#costo').val(costosunidad.toFixed(2));
});

$("#form").on('submit',function(evt){
evt.preventDefault();
band=0;

for (var i=1;i<=cont;i++){

if(i==1){
temp1=$('.id'+i).val();
}
if(i>1){
temp1+=','+$('.id'+i).val();
}

if(i==1){
temp2=$('.fecha'+i).val();
}
if(i>1){
temp2+=','+$('.fecha'+i).val();
}

if(i==1){
cantidad=$('.cantidad'+i).val();
}
if(i>1){
cantidad+=','+$('.cantidad'+i).val();
}

if(i==1){
precio=$('.costo'+i).val();
}
if(i>1){
precio+=','+$('.costo'+i).val();
}

}

for (var i=1;i<=cont;i++){
if(i==1){
costosunidad=Number($('.costo'+i).val())*Number($('.cantidad'+i).val());
}
if(i>1){
costosunidad=costosunidad+Number($('.costo'+i).val())*Number($('.cantidad'+i).val());
}
}

res=$('#elaboro').val().replace("'","");
res=res.replace('"',"");

for (var i=1;i<=cont;i++){
$.ajax({
url : 'menu/php/existe.php',
data : {
clave:$('#'+i).val()
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
alert("receta no existe");
}
if(band==0){
$.ajax({
url : 'menu/php/agregarmenu9.php',
type : 'POST',
data :{
idrecetas:temp1,
fecharecetas:temp2,
fecha:fecha,
cantidad:cantidad,
precio:precio,
semana:$('#semana').val(),
tiemp:$('#tiemp').val(),
cliente:$('#cliente').val(),
unidad:$('#unidad').val(),
subunidad:$('#subunidad').val(),
costo:costosunidad.toFixed(2),
elaboro:res,
grupo:$('#grupo').val(),
lunes:band1,
martes:band2,
miercoles:band3,
jueves:band4,
viernes:band5,
sabado:band6,
domingo:band7
},
success:function(respuesta){
Swal.fire("Exito", 'Menu agregado correctamente', 'success');
var fecha = new Date();
var ano = fecha.getFullYear();
alert('Guarde el id de receta '+ano+'_'+$('#semana').val()+'_'+$('#cliente').val()+'_'+$('#unidad').val()+'_'+$('#subunidad').val()+'_'+$('#grupo').val());
$("#contenedor").load('menu/view/menu.php');
},
});
}

});

</script>