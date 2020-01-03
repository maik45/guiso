<form role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Nombre o razón"></label>
                <input id="nombre" class="form-control" name="nombre" value="" type="text" require maxlength="32" title="Ingrese el nombre de la empresa" placeholder="La Empresa INVENTADA S.A de CV">
            </div>
            <div class="form-group">
                <label data-texto="* Tipo de proveedor"></label>
                <select class="form-control" name="tipo" value="" required="true">
                    <option></option>
                    <option>Mayoreo</option>
                    <option>Menudeo</option>
                </select>
            </div>
            <div class="form-group">
                <label data-texto="* RFC"></label>
                <input class="form-control" name="rfc" value="" type="text" require maxlength="14" placeholder="Ejemplo: ABC 123456 ABC" title="Ingrese el R.F.C del cliente">
            </div>
            <div class="form-group">
                <label data-texto="* Tipo de pago"></label>
                <select class="form-control" name="pago" value="" required="true">
                    <option></option>
                    <option>Contado con cheque</option>
                    <option>Crédito</option>
                    <option>Efectivo</option>
                    <option>Operación</option>
                    <option>Unidades</option>
                </select>
            </div>
            <div class="form-group">
                <label data-texto="Dirección"></label>
                <input class="form-control" name="direccion" value="" type="text" maxlength="128" title="Formato: Calle num., colonia" placeholder="Ejemplo: Calle nombre de la calle #777, col. nombre de la colonia">
            </div>
            <div class="form-group">
                <label data-texto="Teléfono"></label>
                <input class="form-control" name="telefono" value="" type="text" maxlength="14" title="Ingrese el número de teléfono del proveedor" placeholder="Formato: (xxx) xxx-xxxx" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 46 || event.keyCode === 13 || event.keyCode === 173 || event.keyCode === 57 || event.keyCode === 48  ? true : !isNaN(Number(event.key))">
            </div>  
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Nombre del contacto"></label>
                <input class="form-control" name="contacto" value="" type="text" maxlength="32" placeholder="Ejemplo: Juan Paco Pedro De La Mar" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === Space || ( event.keyCode >= 65 && event.keyCode <= 90 ) ? isNaN( Number(event.key) ) : false ">
            </div>
            <div class="form-group">
                <label data-texto="Correo electrónico"></label>
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

<script type="text/javascript" src="pages/personal_js/formulario.js"></script>
<script type="text/javascript">
    $("[name='telefono']").on({change : esNumeroDeTelefono, focus : mostrarFormatoNumeroTelefonico});
    $("[name='cp']").on({change : esCP});
    $("[name='nombre']").on({change : esNombreDeEmpresa});
    $("[name='direccion']").on({change : esDireccion});
    $("[name='contacto']").on({change : soloPalabras});
    $("[name='estado']").on({change : esEstado});
    $("[name='info']").on({change : esInformacion});
    $("[name='ciudad']").on({change : soloPalabras});
    $("[name='rfc']").on({change : rfc});
    $("[name='correo']").on({change : email});
    $("form [name]").on({change : checarCamposRequire});
    $("form [name]").on({change : mostrarBotonResetear});
</script>