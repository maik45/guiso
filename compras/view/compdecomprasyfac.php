<style>
.grid-container {
  display: grid;
  grid-template-columns: 20% 80%;
   margin-top: 40px;
}
.grid-container1{
  display: grid;
  grid-template-columns: 100%;
  margin-top: 80px;
  margin-bottom: 10px;
}
</style>

<div class="row">
    <div class="col-xs-12">
        <h3 class="page-header text-blue"></h3>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">

        <div class="panel panel-default">
            <div class="panel-heading bg-coral text-white" style="height: 42px;text-align: left;font-size: 16px">
            Comparativo de compras y facturación
            </div>
            <div class="panel-body">
                
                <div class="grid-container">
                  <div style="padding-left:64%;padding-top: 4px;color:#337ab7;">*OC</div>
                  <div><input list='oc' id="idoc" style="width: 80%" ><datalist id='oc' required autocomplete='off'></datalist></div>
                </div>
                <div class="grid-container1" style="padding-left: 60%">
                  <button style="width: 60%;" class="btn-default" id="agregar"><b>Generar comparativo de compra</b></button>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
$.ajax({
url : 'compras/php/presupuestodec.php',
data : {},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
respuesta="["+respuesta+"]";
res=JSON.parse(respuesta);
oc="";
$.each(res,function(key,value){
oc+="<option>"+value.idOC+"</option>";
});
$('#oc').html(oc);
},
});

$("#agregar").click(function(){

$.ajax({
url : 'compras/php/existe.php',
data : {clave:$('#idoc').val()},
type : 'POST',
dataType: 'json',
async:false,
success:function(respuesta){
band=respuesta;
},
});
if(band==1){

salida=$('#idoc').val();
if(salida!=''){
$.ajax({
data : {},
type : 'POST',
success:function(respuesta){
window.open('compras/php/compcomprasyfac.php?id='+salida,'_blank');
},
});
}else{
alert('La *OC esta vacio');
}
}else{
alert('no existe la : OC');
}

});

</script>