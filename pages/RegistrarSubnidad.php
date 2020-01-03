<?php
    session_start();
?>
<form role="form">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label data-texto="* Clave de la sub unidad"></label>
                <input class="form-control" name="idSUnidad" value="" required="true" type="text" autofocus="true" maxlength="3" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 || event.keyCode === 9 ? true : !isNaN(Number(event.key))">
            </div>
            <div class="form-group">
                <label data-texto="Sub unidad"></label>
                <input class="form-control" name="subUnidad" value="" type="text" maxlength="32">
            </div>
            <div class="form-group">
                <label data-texto="* Cliente"></label>
                <select class="form-control" name="cliente" value="" required="true" type="number">
                	<option></option>
                </select>
            </div>
            <div class="form-group">
                <label data-texto="* Unidad"></label>
                <select class="form-control" name="unidad" value="" required="true" type="text">
                	<option></option>
                </select>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="" type="text" maxlength="32" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === Space || ( event.keyCode >= 65 && event.keyCode <= 90 ) ? isNaN( Number(event.key) ) : false">
            </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?>></script>
<script type="text/javascript">
    $("[name='idSUnidad']").on({change : esClave});
    $("[name='subunidad']").on({change : soloPalabras});
    $("[name='info']").on({change : esInformacion});
    $("form [name]").on({change : checarCamposRequire});
    $("form [name]").on({change : mostrarBotonResetear});
</script>