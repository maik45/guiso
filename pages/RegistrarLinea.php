<?php
    session_start();
?>

<form role="form">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label data-texto="* Clave de la linea"></label>
                <input class="form-control" name="idLinea" value="" required="true" type="text" autofocus="true" maxlength="3" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 || event.keyCode === 9 ? true : !isNaN(Number(event.key))">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Descripción"></label>
                <input class="form-control" name="descripcion" value="" required="true" type="text" maxlength="32">
                <p class="help-block"></p>
            </div>
	    </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?>></script>
<script type="text/javascript">
    $("[name='idLinea']").on({change : esClave});
    $("[name='descripcion']").on({change : esInformacion});
    $("form [name]").on({change : checarCamposRequire});
    $("form [name]").on({change : mostrarBotonResetear});
</script>