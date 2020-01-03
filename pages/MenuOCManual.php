<div id="panel-1-contenedor" class="panel panel-default mt-20-px">
<div class="panel-heading bg-coral text-white text-center">Menú órdenes de compra manual</div>
    <div class="panel-body">

        <ul class="nav nav-tabs">
            <li>
                <a data-botones="Modifica-catidad-de-articulo:modificarOrdenDeCompra() Elimina-articulo:eliminarPrecios() Agregar-artículo:agregarArticuloAOrdenDeCompra()" data-toggle="tab" data-texto="Menú órdenes de compra manual: Generar" data-archivo="GenerarOCManual.php">Generar</a>
            </li>
            <li>
                <a data-botones="Elimina-artículo:eliminarPrecios() Modifica-cantidad-de-artículo:modificarOrdenDeCompra() Agregar-artículo:agregarArticuloAOrdenDeCompra()" data-toggle="tab" data-texto="Menú órdenes de compra manual: Modificar" data-archivo="ModificarOCManual.php">Modificar</a>
            </li>
            <li>
                <a data-botones="Autorizar-y-cerrar-O.C.M.:autorizarCerrarOCM()" data-toggle="tab" data-texto="Modificar órden de compra manual" data-archivo="updateStatusOCP.php">Estado</a>
            </li>
        </ul>

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
                <div id="botones" class="row"></div>
            </div>
        </div>
    </div>
    <!-- /.panel-footer -->

</div>