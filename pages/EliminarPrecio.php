<form role="form">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="* Proveedor"></label>
                <select class="form-control" name="proveedor" value="" required autofocus>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Articulo"></label>
                <select class="form-control" name="articulo" value="" required>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Precio"></label>
                <input class="form-control" name="precio" value="" required>
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Presentación"></label>
                <select class="form-control" name="presentacion" value="" required>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <div class="form-group">
                <label data-texto="Unidad de medida"></label>
                <input class="form-control" name="unidad_medida" value="">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="* Cantidad de unidades en la presentación" required></label>
                <input class="form-control" name="unidad_presentacion" value="">
                <p class="help-block"></p>
            </div>
            <div class="form-group">
                <label data-texto="Información adicional"></label>
                <input class="form-control" name="info" value="">
                <p class="help-block"></p>
            </div>
        </div>
    </div>
</form>

<script src="./pages/personal_js/formulario.js"></script>