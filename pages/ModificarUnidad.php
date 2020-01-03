<form role="form">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
                <label data-texto="* Id unidad"></label>
                <input class="form-control" name="id_unidad" value="" autofocus="true" required="true" type="number" step="1">
                <p class="help-block">Campo obligatorio</p>
            </div>
            <div class="form-group">
                <label data-texto="* Cliente"></label>
                <select class="form-control" name="cliente" value="" required="true">
                	<option value=""></option>
                	<option value="">1</option>
                	<option value="">2</option>
                	<option value="">3</option>
                	<option value="">4</option>
                	<option value="">5</option>
                </select>
                <p class="help-block">Campo obligatorio</p>
            </div>
            <div class="form-group">
                <label data-texto="* Unidad"></label>
                <select class="form-control" name="unidad" value="" required="true">
                	<option value=""></option>
                	<option value="">1</option>
                	<option value="">2</option>
                	<option value="">3</option>
                	<option value="">4</option>
                	<option value="">5</option>
                </select>
                <p class="help-block">Campo obligatorio</p>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="informacion" value="" type="text">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Unidad registrada desde"></label>
                <input class="form-control" name="fecha_registro" value="" type="date">
                <p class="help-block"></p>
            </div>
	    </div>
    </div>
</form>

<script type="text/javascript" src="../js/global-menu.js"></script>