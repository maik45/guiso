<div class="mt-20-px"></div>

<div id="panel-1-contenedor" class="panel panel-default">

    <div class="panel-heading text-white bg-coral">Menú para Grupos</div>

    <div class="panel-body">

        <ul class="nav nav-tabs">
            <li>
                <a data-botones="Limpiar-formulario:limpiarForm() Registrar:registrar()" data-toggle="tab" data-texto="Menú grupos: Registrar" data-archivo="RegistrarGrupo.php" data-contexto="registrar">Registrar</a>
            </li>
            <li>
                <a data-botones="Eliminar:eliminar()" data-toggle="tab" data-texto="Menú grupos: Eliminar" data-archivo="Eliminar.php" data-contexto="eliminar">Eliminar</a>
            </li>
            <li>
                <a data-toggle="tab" data-texto="Menú grupos: Consultar" data-archivo="Consultar.php" data-contexto="consultar">Consultar</a>
            </li>
            <li>
                <a data-botones="Cancelar-cambios:cancelar() Guardar-cambios:guardarCambios()" data-toggle="tab" data-texto="Menú grupos: Modificar" data-archivo="Modificar.php" data-contexto="modificar">Modificar</a>
            </li>
        </ul>

        <div class="mt-20-px"></div>

        <div class="row" id="contenedor-args-busqueda">
            <div class="col-xs-6 col-md-3">
                <label>Filas:</label>
                <select class="text-dark" id="arg-1" name="filas">
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                </select>
            </div>
            <div class="col-xs-6 col-md-3">
                <span class="glyphicon glyphicon-search"></span>
                <input id="arg-4" type="text" title="Ingrese una clave o un nombre" placeholder="Buscar" name="comodin" maxlength="8" />
            </div>
            <div class="col-xs-6 col-md-3">
                <label>Pagina</label>
                <select class="text-dark" id="arg-3" name="desface">
                    <option>Inválido</option>
                </select>
            </div>
            <div class="col-xs-6 col-md-3">
                <label>Ordenar por:</label>
                <select class="text-dark" id="arg-2" name="criterio">
                    <option>Inválido</option>
                </select>
            </div>
        </div>

        <!-- Tab panes -->
        <div id="tab-contenedor" class="tab-content"></div>

    </div>
    <!-- /.panel-body -->

    <div class="panel-footer" style="display:none;">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div id="texto-ayuda"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div id="botones"></div>
            </div>
        </div>
    </div>
    <!-- /.panel-footer -->

</div>