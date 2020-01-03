<?php
    session_start();
?>

<form id="precioXproveedor" role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Elija un proveedor"></label>
                <select class="form-control" name="proveedor" value="" required="true" data-tabla-objetivo="table=proveedor" data-campo-objetivo="campo=nombre" title="Seleccione un proveedor">
                    <option></option>
                </select>
            </div>
            <div class="form-group">
                <label id="nombre-de-articulo" data-texto="* Elija un articulo"></label>
<!--                 <select class="form-control" name="articulo" value="" required="true" data-tabla-objetivo="table=articulo" data-campo-objetivo="campo=nombre">
                    <option></option>
                </select> -->
                <input class="form-control" name="articulo" value="" type="text" required="true" list="articulos" placeholder="Escriba la clave o el nombre del artículo" title="Seleccione un artículo" />
                <datalist id="articulos"></datalist>
            </div>
            <div class="form-group">
                <label data-texto="* Ingrese precio"></label>
                <input class="form-control" name="costo" value="" required="true" placeholder="Ejemplo de formato: 10.00" title="Ingrese un precio" onkeydown="javascript: return event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 13 || event.keyCode === 190 ? true : !isNaN(Number(event.key))">
                <!-- <p class="help-block">El precio que aparece, es el precio por de la Presentación y en caso de no tener presentación es el precio por Unidad de Medida</p> -->
            </div>
            <div class="form-group">
                <label data-texto="* Presentación">* Presentación: </label>
                <label id="unidadA"></label>
                <!-- <input class="form-control" name="unidadA" value="" required="true" disabled="true"> -->
                <!-- <p class="help-block">Utilice unidad de medida "Ninguna" para asignar un precio a un producto en su Unidad de Medida Original</p> -->
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Unidad de medida">Unidad de medida: </label>
                <label id="unidad"></label>
                <!-- <input class="form-control excluded" name="unidad" value="" disabled="true" type="text"> -->
            </div>
            <div class="form-group">
                <label data-texto="* Cantidad de unidades en la presentación" required="true">* Cantidad de unidades en la presentación: </label>
                <label id="factor"></label>
                <!-- <input class="form-control" name="factor" value="" required="true" disabled="true"> -->
                <!-- <p class="help-block">Si la cantidad de unidades permanece en cero (0); la presentación se considerará como "Ninguna"</p> -->
            </div>
            <div class="form-group">
                <label data-texto="Información adicional">Información adicional: </label>
                <label id="info"></label>
                <!-- <input class="form-control" name="info" value="" disabled="true"> -->
            </div>
        </div>
    </div>
</form>

<script type="text/javascript" src=<?php echo $_SESSION['__js_form__'];?> ></script>
<script type="text/javascript">
    $("[name='costo']").on({change : esPrecio});
    $("[name='articulo']").on("change", rellenarCamposArticulo);
    $("[name='proveedor']").on("change", rellenarCamposArticulo);
    $("form [name]").on({change : checarCamposRequire});
    $("form [name]").on({change : mostrarBotonResetear});
    $("form[id='precioXproveedor']").one("mouseover", function(){datalistArticulo();selectProveedor();});
</script>