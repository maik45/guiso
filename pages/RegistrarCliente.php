<?php
    session_start();
?>

<form role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Nombre del cliente"></label>
                <input id="nombre" class="form-control" name="nombre" value="" type="text" require maxlength="32" title="Ingrese el nombre del cliente" placeholder="Ejemplo: Nombre1 Nombre2">
            </div>
            <div class="form-group">
                <label data-texto="* R.F.C. del cliente"></label>
                <input class="form-control" name="rfc" value="" type="text" require maxlength="14" placeholder="Ejemplo: ABC 123456 ABC" title="Ingrese el R.F.C del cliente">
            </div>
            <div class="form-group">
                <label data-texto="Dirección"></label>
                <input class="form-control" name="direccion" value="" type="text" maxlength="128" title="Ingrese la dirección del cliente en este orden calle numero, colonia" placeholder="Ejemplo: Calle nombre de la calle #777, col. nombre de la colonia">
            </div>
            <div class="form-group">
                <label data-texto="Teléfono"></label>
                <input class="form-control" name="telefono" value="" type="text" maxlength="14" title="Ingrese el número de teléfono del cliente" placeholder="Formato: (xxx) xxx-xxxx" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 13 || event.keyCode === 173 || event.keyCode === 57 || event.keyCode === 48  ? true : !isNaN(Number(event.key))">
            </div>
            <div class="form-group">
                <label data-texto="Nombre del contacto"></label>
                <input class="form-control" name="contacto" value="" type="text" maxlength="32" placeholder="Ejemplo: Juan Paco Pedro De La Mar" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === Space || ( event.keyCode >= 65 && event.keyCode <= 90 ) ? isNaN( Number(event.key) ) : false ">
            </div>
            <div class="form-group">
                <label data-texto="Plazo"></label>
                <input class="form-control" name="plazo" value="" type="text" maxlength="2" title="Ingrese como máximo dos digitos" placeholder="Ejemplo: 1" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 13 ? true : !isNaN(Number(event.key))">
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Crédito"></label>
                <input class="form-control" name="credito" value="" type="text" maxlength="2" title="Ingrese como máximo dos digitos" placeholder="Ejemplo: 1" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 13 ? true : !isNaN(Number(event.key))">
            </div>
            <div class="form-group">
                <label data-texto="Correo"></label>
                <input class="form-control" name="correo" value="" type="email" maxlength="32" title="Usted puede ingresar números, letras y guión bajo" placeholder="Ejemplo: ejemplo@mail.com">
            </div>
            <div class="form-group">
                <label data-texto="Estado"></label>
                <input class="form-control" name="estado" value="" type="text" maxlength="16" placeholder="Ejemplo: Nombre de Estado" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === Space || ( event.keyCode >= 65 && event.keyCode <= 90 ) ? isNaN( Number(event.key) ) : false ">
            </div>
            <div class="form-group">
                <label data-texto="Ciudad"></label>
                <input class="form-control" name="ciudad" value="" type="text" maxlength="16" placeholder="Ejemplo: Nombre de Ciudad" title="Ingrese únicamente letras" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === Space || ( event.keyCode >= 65 && event.keyCode <= 90 ) ? isNaN( Number(event.key) ) : false ">
            </div>
            <div class="form-group">
                <label data-texto="Código postal"></label>
                <input class="form-control" name="cp" value="" type="text" maxlength="5" title="Ingrese únicamente cinco digitos" placeholder="Ejemplo: 12345" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 13 ? true : !isNaN(Number(event.key))">
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="" type="text" maxlength="32">
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?>></script>
<script type="text/javascript">
    $("[name='telefono']").on({change : esNumeroDeTelefono, focus : mostrarFormatoNumeroTelefonico});
    $("[name='cp']").on({change : esCP});
    $("[name='nombre']").on({change : soloPalabras});
    $("[name='direccion']").on({change : esDireccion});
    $("[name='estado']").on({change : esEstado});
    $("[name='info']").on({change : esInformacion});
    $("[name='ciudad']").on({change : soloPalabras});
    $("[name='plazo']").on({change : esPlazoOCredito});
    $("[name='credito']").on({change : esPlazoOCredito});
    $("[name='contacto']").on({change : soloPalabras});
    $("[name='rfc']").on({change : rfc});
    $("[name='correo']").on({change : email});
    $("form [name]").on({change : checarCamposRequire});
    $("form [name]").on({change : mostrarBotonResetear});
</script>