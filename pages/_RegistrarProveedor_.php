<form role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Nombre o razón"></label>
                <input id="nombre" class="form-control" name="nombre" value="" type="text" require maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Tipo de proveedor"></label>
                <select class="form-control" name="tipo" value="" required="true">
                    <option>Mayoreo</option>
                    <option>Menudeo</option>
                </select>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* RFC"></label>
                <input class="form-control" name="rfc" value="" type="text" require maxlength="14" placeholder="ABC 123456 ABC">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Tipo de pago"></label>
                <select class="form-control" name="pago" value="" required="true">
                    <option>Contado con cheque</option>
                    <option>Crédito</option>
                    <option>Efectivo</option>
                    <option>Operación</option>
                    <option>Unidades</option>
                </select>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Dirección"></label>
                <input class="form-control" name="direccion" value="" type="text" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Teléfono"></label>
                <input class="form-control" name="telefono" value="" type="text" maxlength="14" placeholder="Formato (xxx) xxx-xxxx">
                <p class="help-block"></p>
            </div>  
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Nombre del contacto"></label>
                <input class="form-control" name="contacto" value="" type="text" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Correo"></label>
                <input class="form-control" name="correo" value="" type="email" maxlength="32">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Estado"></label>
                <input class="form-control" name="estado" value="" type="text" maxlength="16">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Ciudad"></label>
                <input class="form-control" name="ciudad" value="" type="text" maxlength="16">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Código postal"></label>
                <input class="form-control" name="cp" value="" type="text" maxlength="5" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 ? true : !isNaN(Number(event.key))">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="" type="text" maxlength="32">
                <p class="help-block"></p>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src="pages/personal_js/formulario.js"></script>
<script type="text/javascript">
    $("[name='telefono']").on({change : esNumeroDeTelefono, focus : mostrarFormatoNumeroTelefonico});
    $("[name='cp']").on({change : soloNumeros});
    $("[name='nombre']").on({change : soloPalabras});
    $("[name='contacto']").on({change : soloPalabras});
    $("[name='estado']").on({change : soloPalabras});
    $("[name='info']").on({change : soloPalabras});
    $("[name='ciudad']").on({change : soloPalabras});
    $("[name='rfc']").on({change : rfc});
</script>