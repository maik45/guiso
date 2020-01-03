<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Clave</label>
            </div>
            <div class="col-md-9 col-sm-12">
                <label id="id-ocm"></label>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Semana</label>
            </div>
            <div class="col-md-9 col-sm-12">
                <label name="semana"></label>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <label id="fechaI">Seleccione una fecha</label>
            </div>
            <div class="col-md-6 col-sm-12">
                <input id="fechaF" class="form-control" type="date">
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Proveedor</label>
            </div>
            <div class="col-md-9 col-sm-12">
                <select class="form-control" name="proveedor" value="">
                    <option>Elija un proveedor</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Cliente</label>
            </div>
            <div class="col-md-9 col-sm-12">
                <select class="form-control" value="" name="cliente">
                    <option>Elija un cliente</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Articulo</label>        
            </div>
            <div class="col-md-9 col-sm-12">
                <select class="form-control" name="articulo" value="">
                    <option>Elija un articulo</option>
                </select>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <label>Clave de las unidades</label>
            </div>
            <div class="col-md-8 col-sm-12" id="contenedor_unidades">
                <label name="unidades">Elija un cliente</label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Presentación</label>
            </div>
            <div class="col-md-9 col-sm-12">
                <label name="unidadA"></label>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Costo</label>        
            </div>
            <div class="col-md-9 col-sm-12">
                <label name="costo"></label>
            </div>
        </div>
    </div>
</div>

<div class="row" id="contenedor-cantidades"></div>
<!-- /.row -->

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr id="mi_thead">
            </tr>
        </thead>
        <tbody id="mi_tbody">
        </tbody>
    </table>
</div>
<!-- /.table-responsive -->

<script type="text/javascript" src="./pages/personal_js/select.js"></script>
<script type="text/javascript">
    var json_obj_unidadesxcliente = null;
    var json_obj_precioxprov = null;
    var json_obj_articuloelegido = null;
    var vec_totalxunidad = [];
    var idProveedor = null;
    var fecha = null;
    var semana = 0;
    var costo = 0;

    function ningunArticulo()
    {
        $("[name='costo']").text("");
        $("[name='unidadA']").text("");
        $("[name='articulo']").val("");
    }

    function ningunProveedor()
    {
        $("[name='proveedor']").val("");
    }

    function resetearCantidades(caso = "")
    {
        var cantidades = $("#contenedor-cantidades [type='number']");

        if ( cantidades.length > 0 )
        {
            cantidades.each( function()
            {
                $(this).val("0");

                switch ( caso )
                {
                    case "":
                        $(this).prop("disabled", true);
                    break;

                    case "habilitar":
                        $(this).prop("disabled", false);
                    break;
                }
            });

            $("#2").css("visibility", "hidden");
        }
    }

    function mouseOverBotonAgregarArticulo()
    {
        textoAyuda("Haga clic en el botón 'Agregar artículo' para añadir el artículo a la orden de compra", "text-blue", "Descripción");
    }

    function mouseOutBotonAgregarArticulo()
    {
        textoAyuda("");
    }

    function mostrarBotonAgregarArticulo()
    {
        var cantidades = $("#contenedor-cantidades [type='number']");

        if ( cantidades.length > 0 )
        {
            var bandera = false;
            cantidades.each( function()
            {
                if ( isNaN( $(this).val() ) || $(this).val() === "" )
                    $(this).val("0");

                if ( Number( $(this).val() ) > 0 )
                    bandera = true;
            });

            if ( bandera )
                $("#2").css("visibility", "visible");
            else
                $("#2").css("visibility", "hidden");
        }
    }

    function mostrarBotonEliminarArticulo()
    {
        var contador = $("tr[class*='elegido']").length;

        if ( contador > 0 )
            $("#1").css("visibility", "visible");
        else
            $("#1").css("visibility", "hidden");
    }

    function mostrarBotonModificarArticulo()
    {
        var cantidades = $("#contenedor-cantidades [type='number']");
        var contador = $("tr[class*='elegido']").length;
        var bandera = true;

        if ( cantidades.length > 0 )
        {
            var objetos = cantidades.toArray();

            for ( var i = 0; i < objetos.length; i++ )
            {
                if ( isNaN( objetos[ i ].value ) || ( objetos[ i ].value === "" ) )
                {
                    bandera = false;

                    break;
                }
            }
        }

        if ( ( contador === 1 ) && ( bandera ) )
            $("#0").css("visibility", "visible");
        else
            $("#0").css("visibility", "hidden");
    }

    Date.prototype.getWeek = function()
    {
        var onejan = new Date(this.getFullYear(), 0, 1);
        return Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
    }

    function seleccionarFila()
    {
        $(this).toggleClass("danger elegido");

        var n_filas_elegidas = $("tr[class*='elegido']").length;

        resetearCantidades("habilitar");

        if ( n_filas_elegidas === 1 )
        {
            textoAyuda("Modifique las cantidades y haga clic en el botón 'Modificar' para modificar las cantidades en la orden de compra, o elimine el artículo de la orden de compra haciendo clic en el botón 'Eliminar'");
        }
        else if ( n_filas_elegidas > 1 )
        {
            textoAyuda( "Elimine los articulos seleccionados de esta orden de compra haciendo clic botón 'Eliminar'" );
        }
        else
        {
            textoAyuda("");
            resetearCantidades();
            ningunArticulo();
        }

        if ( $(this).attr("class") == "danger elegido" )
        {
            var id_ocm = null;
            var idCliente = "";

            //  =>  Necesario
            var columnas = $(this).find( "td" );
            var numero_columnas = ( columnas.length > 0 ) ? columnas.length : 0;
            var json_obj_unidadesxcliente = null;
            var json_obj_proveedor = null;
            var json_obj_articulo = null;
            var json_obj_cliente = null;
            var cantidades_totales = [];
            var json_obj_bomocm = null;
            var json_obj_ocm = null;
            var fecha = new Date();
            var presentacion = "";
            var cantidades = [];
            var idArticulo = 0;
            var articulo = "";
            var fechaA = "";
            var fechaF = "";
            var fechaI = "";
            var factor = 0;
            var total = 0;
            var costo = 0;

            columnas.each( function(index, element)
            {
                if ( index == 0 )
                    idArticulo = $(this).text();

                if ( index == 1 )
                    articulo = $(this).text();

                if ( index == 2 )
                    presentacion = $(this).text();

                if ( index == 3 )
                    costo = $(this).text();

                if ( ( index >= 4 )  && ( index <= ( numero_columnas - 2 ) ) )
                {
                    cantidades.push( Number( $(this).text() ) );
                    $("[name='cantidad-" + ( index - 4 ) + "']").val( cantidades[ index - 4 ] );
                }

                if ( index == ( numero_columnas - 1 ) )
                    total = $(this).text();
            });//   =>  each

            id_ocm = $("#id-ocm").text();

            iJoinTabla3 = {
                table_name : "bomocm",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "bomocm.OC='" + id_ocm + "' AND articulo = '" + idArticulo + "'", "1fila" );
            json_obj_bomocm = _json_response_;
            _json_response_ = null;

            $("select[name='proveedor']").val( json_obj_bomocm[ 9 ] );

            //  =>  JSON object
            iJoinTabla1 = {
                table_name : "articulo",
                index_field : [
                "nombre"
                ],
                key : "precioprov.articulo",
                foreing_key : "articulo.idArticulo"
            };

            iJoinTabla3 = {
                table_name : "precioprov",
                index_field : [
                "articulo"
                ]
            };

            iJoinTablas = {
                arg1 : {},
                arg3 : {}
            };

            iJoinTablas.arg3 = iJoinTabla1;
            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "proveedor='" + json_obj_bomocm[ 9 ] + "'", "option" );
            rellenarSelectArticulo();

            $("[name='articulo']").val( idArticulo );
            $("[name='costo']").text( costo );
            $("[name='unidadA']").val( presentacion );
        }

        mostrarBotonEliminarArticulo();
        mostrarBotonModificarArticulo();
    }

    function rellenarPrecio()
    {
        json_obj_articuloelegido = _json_response_;

        if ( _json_response_[ 5 ] != "0" )
        {
            _json_response_[ 0 ] = ( Number( _json_response_[ 0 ] ) * Number( _json_response_[ 5 ] ) ).toPrecision( 4 ).toString();
            $("[name='costo']").text( _json_response_[ 0 ] );
            $("[name='unidadA']").text( _json_response_[ 4 ] + " de " +  _json_response_[ 5 ] + " " + _json_response_[ 3 ]);
        }
        else
        {
            $("[name='costo']").text( _json_response_[ 0 ] );
            $("[name='unidadA']").text( _json_response_[ 3 ] );
        }

        liberarJSONResponse();
    }

    function eliminarPrecios()
    {
        var filas_elegidas = $("tr[class*='elegido']");
        var id_ocm = null;
        var idCliente = 0;

        textoAyuda("");

        filas_elegidas.each( function()
        {
            var numero_columnas = $("tr[class*='elegido'] td").length;
            var columnas = $("tr[class*='elegido'] td");
            var json_obj_unidadesxcliente = null;
            var json_obj_proveedor = null;
            var json_obj_articulo = null;
            var cantidades_totales = [];
            var json_obj_bomocm = null;
            var json_obj_ocm = null;
            var fecha = new Date();
            var cantidades = [];
            var idProveedor = 0;
            var idArticulo = 0;
            var fechaI = "";
            var fechaF = "";
            var fechaA = "";
            var factor = 0;
            var costo = 0;
            var total = 0;
            var hoja = 0;

            columnas.each( function(index, element)
            {
                if ( index == 0 )
                    idArticulo = $(this).text();

                if ( index == 1 )
                    articulo = $(this).text();

                if ( index == 2 )
                    presentacion = $(this).text();

                if ( index == 3 )
                    costo = $(this).text();

                if ( ( index >= 4 )  && ( index <= ( numero_columnas - 2 ) ) )
                    cantidades.push( Number( $(this).text() ) );

                if ( index == (numero_columnas - 1 ) )
                    total = $(this).text();
            });//   =>  each

            id_ocm = $("#id-ocm").text();

            iJoinTabla3 = {
                table_name : "ocm",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "ocm.idOC='" + id_ocm + "'", "1fila" );
            json_obj_ocm = _json_response_;
            _json_response_ = null;

            fechaI = json_obj_ocm[ 3 ];
            fechaF = json_obj_ocm[ 4 ];
            fechaA = fecha.getFullYear() + "/" + ( fecha.getMonth() + 1 ) + "/" + fecha.getDate();

            iJoinTabla3 = {
                table_name : "bomocm",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "bomocm.OC='" + id_ocm + "' AND articulo = '" + idArticulo + "'", "1fila" );
            json_obj_bomocm = _json_response_;
            _json_response_ = null;

            iJoinTabla3 = {
                table_name : "proveedor",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            idProveedor = $("[name='proveedor']").val();
            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "proveedor.idProveedor=" + json_obj_bomocm[ 9 ] , "1fila" );
            json_obj_proveedor = _json_response_;
            _json_response_ = null;

            iJoinTabla3 = {
                table_name : "cliente",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            idCliente = $("[name='cliente']").val();
            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "cliente.idCliente=" + idCliente , "1fila" );
            json_obj_cliente = _json_response_;
            _json_response_ = null;

            iJoinTabla3 = {
                table_name : "articulo",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "articulo.idArticulo='" + idArticulo + "'" , "1fila" );
            json_obj_articulo = _json_response_;
            _json_response_ = null;

            factor = ( !isNaN( json_obj_articulo[ 5 ] ) ) ? Number( json_obj_articulo[ 5 ] ) : 0;

            if ( factor > 0 )
            {
                for ( var i = 0; i < cantidades.length; i++ )
                    cantidades[ i ] = cantidades[ i ] * factor;

                costo = costo / factor;
            }

            for ( var i = 0; i < cantidades.length; i++ )
            {
                if ( cantidades[ i ] > 0 )
                    cantidades_totales.push( cantidades[ i ] * costo );
            }

            iJoinTabla3 = {
                table_name : "unidad",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "unidad.cliente=" + idCliente , "vec2" );
            json_obj_unidadesxcliente = _json_response_;
            _json_response_ = null;

            URLArgs( "clear" );
            URLArgs( "append", "OC=" + id_ocm );
            URLArgs( "append", "&proveedor=" + json_obj_proveedor[ 0 ] );
            URLArgs( "append", "&articulo=" + json_obj_articulo[ 0 ] );
            URLArgs( "append", "&table=bomocm" );
            URLArgs( "append", "&operacion=delete" );
            var mi_url = URLArgs( "get" );
            URLArgs( "clear" );

            $.ajax(
            {
                async : false,
                url : __php_dir__ + "consultas.php",
                data : mi_url,
                success : function( result, status, xhr )
                {
                    alert( result );
                }
            });

            $(this).remove();
        });

        mostrarBotonAgregarArticulo();
        mostrarBotonEliminarArticulo();
        mostrarBotonModificarArticulo();
        ningunArticulo();
        resetearCantidades();
        textoAyuda("Artículo(s) eliminado(s) con éxito", "text-success", "Éxito");
    }

    function obtClaveParaOCManual()
    {
        var date = new Date();

        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data :
            {
                operacion : "ocm-obtener-clave"
            },
            success : function(result, status, xhr)
            {
                $("#id-ocm").text( ( date.getFullYear() % 2000 ) + "-" + date.getWeek() + "-" + result );
                // $("#id-ocm").text( "12-7-93" );
            }
        }); //  =>  ajax 
    }

    function agregarArticuloAOrdenDeCompra()
    {
        var idArticulo = null;
        var unidadA = null;
        var factor = null;
        var linea = null;
        var cantidades = [];

        var idCliente = null;
        var idOCM = null;
        var bandera = true;
        var fechaI = "";
        var fechaF = "";
        var totalxunidades = 0;
        var json_obj_articuloelegido = null;


        textoAyuda("");
        idArticulo = $("[name='articulo']").val();


        //  =>  Debe haber clave asignada a la orden de compra
        if ( $("#id-ocm").text() )
            idOCM = $("#id-ocm").text();

        //  =>  Debe haber cliente
        if ( $("select[name='cliente']").val() != "Elija un cliente" )
        {
            idCliente = $("select[name='cliente']").val();
            $("[name='cliente']").attr("disabled", "true" );
        }
        else
        {
            alert ( "Ingrese un cliente" );
            return;
        }

        //  =>  Debe haber un proveedor elegido
        if ( $("select[name='proveedor']").val() != "Elija un proveedor" )
            idProveedor = $("select[name='proveedor']").val();
        else
        {
            alert ( "Ingrese un proveedor" );
            return;
        }


        //  =>  Debe haber articulo
        if ( ( idArticulo != "Elija una opción" ) && ( idArticulo !== null ) )
        {
            var cantidad_valor = 0;

            iJoinTabla3 = {
                table_name : "articulo",
                index_field : [
                "*"
                ]
            };

            iJoinTablas = {
                arg1 : {}
            };

            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "articulo.idArticulo='" + idArticulo + "'" , "1fila" );
            json_obj_articuloelegido = _json_response_;
            _json_response_ = null;


            cantidades.splice(0, cantidades.length);
            vec_totalxunidad.splice(0, vec_totalxunidad.length);

            idArticulo = $("select[name='articulo']").val();
            factor = ( isNaN( json_obj_articuloelegido[ 5 ] ) ) ? Number( json_obj_articuloelegido[ 5 ] ) : 1;

            //  =>  Recuperar las cantidades
            $("input[name|='cantidad']").each( function(index)
            {
                cantidad_valor = ( !isNaN( $(this).val() ) ) ? Number( $(this).val() ) : 0;
                cantidades.push( cantidad_valor );
            });//    =>  each

            var contador = 0;

            for ( i = 0; i < cantidades.length; i++ )
            {
                if ( factor > 0 )
                {
                    cantidades[ i ] = cantidades[ i ] * factor;
                    contador += cantidades[ i ];

                    if ( cantidades[ i ] < 0)
                    {
                        alert( "Las cantidades no deben ser negativas" );
                        return;
                    }
                }
            }

            if ( contador == 0 )
            {
                alert( "Agrege cantidades a las unidades para añadirla a la orden de compra" );
                return;
            }
            else if ( contador < 0 )
            {
                alert( "Las cantidades no deben ser negativas" );
                return;
            }

            if ( $("[name='costo']").text() )
                costo = ( !isNaN( $("[name='costo']").text() ) ) ? Number( $("[name='costo']").text() ) : 0;

            if ( factor > 0 )
                costo = costo / factor;

            for ( i = 0; i < cantidades.length; i++ )
                if ( cantidades[ i ] )
                {
                    vec_totalxunidad.push( Number( ( cantidades[ i ] * costo ).toPrecision( 4 ) ) );
                }
        }
        else
        {
            alert ( "Ingrese un articulo" );
            return;
        }

        //  =>  Puede haber fecha
        fecha = new Date( $("[type='date']").val() );

        if ( fecha == "Invalid Date" )
            fecha = new Date();

        semana = fecha.getWeek();

        $("label[name='semana']").text( semana );

        fecha.setDate( fecha.getDate() - fecha.getDay() + 1 );
        fechaI = fecha.getFullYear() + "-" + ( fecha.getMonth() + 1 ) + "-" + fecha.getDate();

        fecha.setDate( fecha.getDate() + 6 );
        fechaF = fecha.getFullYear() + "-" + ( fecha.getMonth() + 1 ) + "-" + fecha.getDate();

        fecha = fecha.getFullYear() + "-" + ( fecha.getMonth() + 1 ) + "-" + fecha.getDate();
        $("#fechaI").text( "De " + fechaI );
        var semanaFParent = $("#fechaF").closest("div");
        $("#fechaF").remove();
        semanaFParent.append( "<label id=\"fechaF\">" + "a " + fechaF + "</label>" );





        URLArgs( "clear" );
        URLArgs( "append", "idOC=" + idOCM );
        URLArgs( "append", "&cliente=" + idCliente );
        URLArgs( "append", "&fechaI=" + fechaI );
        URLArgs( "append", "&fechaF=" + fechaF );
        URLArgs( "append", "&status=1" );
        URLArgs( "append", "&fecha=" + fecha );
        URLArgs( "append", "&usuario=1" );
        URLArgs( "append", "&operacion=registrar" );
        URLArgs( "append", "&table=ocm" );
        var mi_url = URLArgs( "get" );
        URLArgs( "clear" );

        //  =>  Registrar ocm
        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data : mi_url
        });//   =>  ajax

        //  =>  Por cada unidad asociada al cliente elegido
        for ( var i = 0; i < json_obj_unidadesxcliente.length; i++ )
        {
            URLArgs( "clear" );
            URLArgs( "append", "OC=" + idOCM );
            URLArgs( "append", "&fechaI=" + fechaI );
            URLArgs( "append", "&fechaF=" + fechaF );
            URLArgs( "append", "&hoja=0" );
            URLArgs( "append", "&cliente=" + idCliente );
            URLArgs( "append", "&unidad=" + json_obj_unidadesxcliente[ i ][ 0 ] );
            URLArgs( "append", "&articulo=" + json_obj_articuloelegido[ 0 ] );
            URLArgs( "append", "&linea=" + json_obj_articuloelegido[ 6 ] );
            URLArgs( "append", "&cantidad=" + cantidades[ i ] );
            URLArgs( "append", "&proveedor=" + idProveedor );
            URLArgs( "append", "&presentacion=" + json_obj_articuloelegido[ 4 ] );
            URLArgs( "append", "&factor=" + json_obj_articuloelegido[ 5 ] );
            URLArgs( "append", "&costoU=" + costo );
            URLArgs( "append", "&costoT=" + vec_totalxunidad[ i ] );
            URLArgs( "append", "&fecha=" + fecha );
            URLArgs( "append", "&operacion=registrar" );
            URLArgs( "append", "&table=bomocm" );
            var mi_url = URLArgs( "get" );
            URLArgs( "clear" );

            //  =>  Registrar ocm
            $.ajax(
            {
                async : false,
                url : __php_dir__ + "consultas.php",
                data : mi_url,
                success : function( result, status, xhr )
                {
                    // alert( result );

                    if ( result === "La orden de compra manual para esta unidad ya existe" )
                        bandera = false;
                }
            });//   =>  ajax
        }

        $("#mi_tbody").append( "<tr id=\"" + json_obj_articuloelegido[ 0 ] + "\"></tr>" );
        var mi_fila = $("#mi_tbody tr:last-child");

        mi_fila.append( "<td>" + json_obj_articuloelegido[ 0 ] + "</td>" );
        mi_fila.append( "<td>" + json_obj_articuloelegido[ 1 ] + "</td>" );
        mi_fila.append( "<td>" + $("[name='unidadA']").text() + "</td>" );
        mi_fila.append( "<td>" + costo + "</td>" );

        for ( var i = 0; i < vec_totalxunidad.length; i++ )
            totalxunidades += vec_totalxunidad[ i ];


        cantidades.splice(0, cantidades.length);
        vec_totalxunidad.splice(0, vec_totalxunidad.length);
        //  =>  Recuperar las cantidades
        $("input[name|='cantidad']").each( function(index)
        {
            mi_fila.append( "<td>" + $(this).val() + "</td>" );
            $(this).val(0);
        });//    =>  each

        mi_fila.append( "<td>" + totalxunidades + "</td>" );

        mostrarBotonAgregarArticulo();
        ningunArticulo();
        resetearCantidades();
        textoAyuda("Artículo añadido a la orden de compra actual", "text-success", "Éxito");
    }

    function modificarOrdenDeCompra()
    {
        var filas_elegidas = $("tr[class*='elegido']");
        var id_ocm = null;
        var idCliente = "";

        if ( filas_elegidas.length == 1 )
        {
            textoAyuda("");

            filas_elegidas.each( function()
            {
                //  =>  Necesario
                var columnas = $("tr[class*='elegido'] td");
                var json_obj_unidadesxcliente = null;
                var json_obj_proveedor = null;
                var json_obj_articulo = null;
                var json_obj_cliente = null;
                var cantidades_totales = [];
                var json_obj_bomocm = null;
                var json_obj_ocm = null;
                var fecha = new Date();
                var presentacion = "";
                var cantidades = [];
                var idArticulo = 0;
                var articulo = "";
                var fechaA = "";
                var fechaF = "";
                var fechaI = "";
                var factor = 0;
                var total = 0;
                var costo = 0;

                //  =>  No necesario
                var numero_columnas = $("tr[class*='elegido'] td").length;
                // var idProveedor = 0;
                var hoja = 0;

                columnas.each( function(index, element)
                {
                    if ( index == 0 )
                        idArticulo = $(this).text();

                    if ( index == 1 )
                        articulo = $(this).text();

                    if ( index == 2 )
                        presentacion = $(this).text();

                    if ( index == 3 )
                        costo = ( !isNaN( $(this).text() ) ) ? Number( $(this).text() ) : 0;

                    if ( ( index >= 4 )  && ( index <= ( numero_columnas - 2 ) ) )
                        cantidades.push( Number( $("input[name='cantidad-" + ( index - 4 ) + "']").val() ) );

                    if ( index == (numero_columnas - 1 ) )
                        total = ( !isNaN( $(this).text() ) ) ? Number( $(this).text() ) : 0;
                });//   =>  each

                id_ocm = $("#id-ocm").text();

                iJoinTabla3 = {
                    table_name : "ocm",
                    index_field : [
                    "*"
                    ]
                };

                iJoinTablas = {
                    arg1 : {}
                };

                iJoinTablas.arg1 = iJoinTabla3;

                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "ocm.idOC='" + id_ocm + "'", "1fila" );
                json_obj_ocm = _json_response_;
                _json_response_ = null;

                fechaI = json_obj_ocm[ 3 ];
                fechaF = json_obj_ocm[ 4 ];
                fechaA = fecha.getFullYear() + "/" + ( fecha.getMonth() + 1 ) + "/" + fecha.getDate();

                iJoinTabla3 = {
                    table_name : "bomocm",
                    index_field : [
                    "*"
                    ]
                };

                iJoinTablas = {
                    arg1 : {}
                };

                iJoinTablas.arg1 = iJoinTabla3;

                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "bomocm.OC='" + id_ocm + "' AND articulo = '" + idArticulo + "'", "1fila" );
                json_obj_bomocm = _json_response_;
                _json_response_ = null;

                iJoinTabla3 = {
                    table_name : "proveedor",
                    index_field : [
                    "*"
                    ]
                };

                iJoinTablas = {
                    arg1 : {}
                };

                iJoinTablas.arg1 = iJoinTabla3;

                // idProveedor = $("[name='proveedor']").val();
                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "proveedor.idProveedor=" + json_obj_bomocm[ 9 ] , "1fila" );
                json_obj_proveedor = _json_response_;
                _json_response_ = null;

                iJoinTabla3 = {
                    table_name : "cliente",
                    index_field : [
                    "*"
                    ]
                };

                iJoinTablas = {
                    arg1 : {}
                };

                iJoinTablas.arg1 = iJoinTabla3;

                idCliente = $("[name='cliente']").val();
                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "cliente.idCliente=" + idCliente , "1fila" );
                json_obj_cliente = _json_response_;
                _json_response_ = null;

                iJoinTabla3 = {
                    table_name : "articulo",
                    index_field : [
                    "*"
                    ]
                };

                iJoinTablas = {
                    arg1 : {}
                };

                iJoinTablas.arg1 = iJoinTabla3;

                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "articulo.idArticulo='" + idArticulo + "'" , "1fila" );
                json_obj_articulo = _json_response_;
                _json_response_ = null;

                factor = ( !isNaN( json_obj_articulo[ 5 ] ) ) ? Number( json_obj_articulo[ 5 ] ) : 0;

                if ( factor > 0 )
                {
                    for ( var i = 0; i < cantidades.length; i++ )
                        cantidades[ i ] = cantidades[ i ] * factor;

                    costo = costo / factor;
                }

                for ( var i = 0; i < cantidades.length; i++ )
                {
                    if ( cantidades[ i ] > 0 )
                        cantidades_totales.push( cantidades[ i ] * costo );
                }

                iJoinTabla3 = {
                    table_name : "unidad",
                    index_field : [
                    "*"
                    ]
                };

                iJoinTablas = {
                    arg1 : {}
                };

                iJoinTablas.arg1 = iJoinTabla3;

                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "unidad.cliente=" + idCliente , "vec2" );
                json_obj_unidadesxcliente = _json_response_;
                _json_response_ = null;

                URLArgs( "clear" );
                URLArgs( "append", "OC=" + id_ocm );
                URLArgs( "append", "&proveedor=" + json_obj_proveedor[ 0 ] );
                URLArgs( "append", "&articulo=" + json_obj_articulo[ 0 ] );
                URLArgs( "append", "&table=bomocm" );
                URLArgs( "append", "&operacion=delete" );
                var mi_url = URLArgs( "get" );
                URLArgs( "clear" );

                $.ajax(
                {
                    async : false,
                    url : __php_dir__ + "consultas.php",
                    data : mi_url
                });

                $(this).remove();

                //  =>  Por cada unidad asociada al cliente elegido
                for ( var i = 0; i < json_obj_unidadesxcliente.length; i++ )
                {
                    URLArgs( "clear" );
                    URLArgs( "append", "OC=" + id_ocm );
                    URLArgs( "append", "&fechaI=" + fechaI );
                    URLArgs( "append", "&fechaF=" + fechaF );
                    URLArgs( "append", "&hoja=0" );
                    URLArgs( "append", "&cliente=" + idCliente );
                    URLArgs( "append", "&unidad=" + json_obj_unidadesxcliente[ i ][ 0 ] );
                    URLArgs( "append", "&articulo=" + json_obj_bomocm[ 6 ] );
                    URLArgs( "append", "&linea=" + json_obj_bomocm[ 7 ] );
                    URLArgs( "append", "&cantidad=" + cantidades[ i ] );
                    URLArgs( "append", "&proveedor=" + json_obj_bomocm[ 9 ] );
                    URLArgs( "append", "&presentacion=" + json_obj_bomocm[ 10 ] );
                    URLArgs( "append", "&factor=" + json_obj_bomocm[ 11 ] );
                    URLArgs( "append", "&costoU=" + json_obj_bomocm[ 12 ] );
                    URLArgs( "append", "&costoT=" + cantidades_totales[ i ] );
                    URLArgs( "append", "&fecha=" + fecha );
                    URLArgs( "append", "&operacion=registrar" );
                    URLArgs( "append", "&table=bomocm" );
                    var mi_url = URLArgs( "get" );
                    URLArgs( "clear" );

                    //  =>  Registrar ocm
                    $.ajax(
                    {
                        async : false,
                        url : __php_dir__ + "consultas.php",
                        data : mi_url
                    });//   =>  ajax
                }

                $("#mi_tbody").append( "<tr id=\"" + json_obj_bomocm[ 6 ] + "\"></tr>" );
                var mi_fila = $("#mi_tbody tr:last-child");

                mi_fila.append( "<td>" + json_obj_bomocm[ 6 ] + "</td>" );
                mi_fila.append( "<td>" + json_obj_articulo[ 1 ] + "</td>" );
                mi_fila.append( "<td>" + json_obj_articulo[ 3 ] + "</td>" );
                mi_fila.append( "<td>" + json_obj_bomocm[ 12 ] + "</td>" );

                total = 0;

                for ( var i = 0; i < cantidades_totales.length; i++ )
                    total += cantidades_totales[ i ];


                cantidades_totales.splice(0, cantidades.length);
                cantidades.splice(0, cantidades.length);
                //  =>  Recuperar las cantidades
                $("input[name|='cantidad']").each( function(index)
                {
                    mi_fila.append( "<td>" + $(this).val() + "</td>" );
                    $(this).val(0);
                });//    =>  each

                mi_fila.append( "<td>" + total + "</td>" );
                total = 0;
            });

            mostrarBotonAgregarArticulo();
            mostrarBotonEliminarArticulo();
            mostrarBotonModificarArticulo();
            ningunArticulo();
            resetearCantidades();
            textoAyuda("Cantidades modificadas en la orden de compra actual", "text-success", "Éxito");
        }
    }

    function articuloOnChange()
    {
        var v_filas = $("tr[id='" + $(this).val() + "']");

        if ( v_filas.length > 0 )
        {
            textoAyuda("El articulo seleccionado ya existe en la orden de compra actual, si usted quiere modificar las cantidades asignadas para este artículo, seleccione el artículo en la orden de compra, modifique las cantidades y después haga clic en el botón 'Modificar cantidades'", "text-danger", "Observación");

            return;
        }

        textoAyuda("");
        var select_proveedor = $("select[name='proveedor']");

        if ( select_proveedor.val() )
        {
            //  =>  JSON object
            iJoinTabla1 = {
                table_name : "articulo",
                index_field : [
                "idArticulo",
                "nombre",
                "unidad",
                "unidadA",
                "factor",
                "linea",
                ],
                key : "articulo.idArticulo",
                foreing_key : "precioprov.articulo"
            };

            iJoinTabla3 = {
                table_name : "precioprov",
                index_field : [
                "precio"
                ]
            };

            iJoinTablas = {
                arg1 : {},
                arg3 : {}
            };

            iJoinTablas.arg3 = iJoinTabla1;
            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "precioprov.articulo='" + $(this).val() + "' AND precioprov.proveedor='" + select_proveedor.val() + "'", "1fila" );
            rellenarPrecio();

            $("[name*='cantidad']").prop("disabled", false);

            var cantidades = $("#contenedor-cantidades [type='number']");

            if ( cantidades.length > 0 )
            {
                cantidades.each( function()
                {
                    $(this).val("0");
                });

                $("#2").css("visibility", "hidden");
            }
        }
        else
            alert ( "Seleccione un proveedor" );

        resetearCantidades( "valoresA0" );
        mostrarBotonAgregarArticulo();
    }

    $("select[name='cliente']").on(
        "change",
        function()
        {
            consultaCondicionalUnidad( "cliente", $(this).val() );

            //  =>  Si hay cliente, buscamos las unidades para ese cliente
            var mi_obj = {
                campos : "idUnidad, unidad",
                table : "unidad",
                condicion : "cliente = " + $("select[name='cliente']").val(),
                salida_html : "vec2",
                operacion : "consultar-n-campos"
            };

            $.ajax(
            {
                async : false,
                url : __php_dir__ + "consultas.php",
                data : jQuery.param( mi_obj ),
                success : function(result, status, xhr)
                {
                    json_obj_unidadesxcliente = JSON.parse( result );

                    $("#contenedor-cantidades").empty();
                    $("#contenedor_unidades").empty();
                    $("#mi_thead").empty();
                },
                complete : function( status, xhr )
                {
                    var dom_act = null;
                    var i = 0;
                    vec_totalxunidad.splice( 0, vec_totalxunidad.length );
                    //  =>  Peticion exitosa; construimos el encabezado de la tabla
                    $("#mi_thead").append( "<td nowrap=\"true\">Clave (Producto)</td>" );
                    $("#mi_thead").append( "<td nowrap=\"true\">Nombre (Producto)</td>" );
                    $("#mi_thead").append( "<td nowrap=\"true\">Presentación (Producto)</td>" );
                    $("#mi_thead").append( "<td nowrap=\"true\">Precio</td>" );

                    for( i; i < json_obj_unidadesxcliente.length; i++ )
                    {
                        vec_totalxunidad.push( 0.0 );

                        if ( ( i % 2 ) == 0)
                            $("#contenedor-cantidades").append( "<div class=\"row\"><div class=\"col-md-6 col-sm-12\"></div><div class=\"col-md-6 col-sm-12\"></div></div>" );

                        dom_act = $("#contenedor-cantidades > div:last-child");

                        if ( ( i % 2 ) == 0 )
                        {
                            dom_act.find("div:first-child").append( "<label>Ingrese cantidad para (" + json_obj_unidadesxcliente[ i ][ 0 ] + " ) " +  json_obj_unidadesxcliente[ i ][ 1 ] + ": </label>");
                            dom_act.find("div:first-child").append( "<input min=\"0\" step=\"0.001\" disabled class=\"form-control\" value=\"" + vec_totalxunidad[ i ] + "\" name=\"cantidad-" + i + "\" type=\"number\">");
                            dom_act.find("div:first-child").append( "<br>");
                        }
                        else
                        {
                            dom_act.find("div:last-child").append( "<label>Ingrese cantidad para (" + json_obj_unidadesxcliente[ i ][ 0 ] + " ) " +  json_obj_unidadesxcliente[ i ][ 1 ] + ": </label>");
                            dom_act.find("div:last-child").append( "<input min=\"0\" step=\"0.001\" disabled class=\"form-control\" value=\"" + vec_totalxunidad[ i ] + "\" name=\"cantidad-" + i + "\" type=\"number\">");
                            dom_act.find("div:last-child").append( "<br>");
                        }

                        $("#mi_thead").append( "<td nowrap=\"true\">( " + json_obj_unidadesxcliente[ i ][ 0 ] + " ) " + json_obj_unidadesxcliente[ i ][ 1 ] + "</td>" );

                        $("#contenedor_unidades").append( "<label>( " + json_obj_unidadesxcliente[ i ][ 0 ] + " ) </label>" );
                    }

                    $("#mi_thead").append("<td nowrap=\"true\">Total</td>");
                    $("[name='articulo']").empty();
                    $("[name='proveedor']").val("");
                    $("[name='costo']").text("");
                    $("[name='unidadA']").text("");
                }
            }); //  =>  ajax 
        }
    );//    =>  on

    $("select[name='articulo']").on({change : articuloOnChange});


    $("select[name='proveedor']").on(
    {
        change : function()
        {
            var json_obj_ocm = null;
            var idCliente = null;
            var semana = null;
            var fecha = null;
            var idOCM = null;

            idProveedor = $(this).val();

            //  =>  Puede haber fecha
            fecha = new Date( $("[type='date']").val() );

            if ( fecha == "Invalid Date" )
            {
                fecha = new Date();
                $("[type='date']").text( fecha );
            }

            semana = fecha.getWeek();
            console.log( "semana: " + semana );

            //  =>  Debe haber clave asignada a la orden de compra
            if ( $("#id-ocm").text() )
                idOCM = $("#id-ocm").text();
            else
            {
                alert ( "Ingrese una clave para la órden de compra manual" );
                return;
            }


            //  =>  Debe haber cliente, para buscar las unidades por cliente
            if ( $("select[name='cliente']").val() )
            {
                idCliente = $("select[name='cliente']").val();
            }
            else
            {
                alert ( "Ingrese un cliente" );
                return;
            }

            var mi_ocm = {
                campos : "OC, cliente, unidad, articulo, linea, cantidad, proveedor, presentacion, factor, costoU, costoT",
                table : "bomocm",
                condicion : "OC = '" + idOCM + "' AND proveedor = " + idProveedor,
                order : "proveedor, linea, articulo, unidad",
                salida_html : "vec2",
                operacion : "consultar-n-campos"
            };

            $.ajax(
            {
                async : false,
                url : __php_dir__ + "consultas.php",
                data : jQuery.param( mi_ocm ),
                success : function(result, status, xhr)
                {
                    var json_obj_articulo = null;
                    var idLineaAnt = "";
                    var idProveedorAnt = "";
                    var idClientAnt = "";
                    var idUnidadAnt = "";
                    var idArticuloAnt = "";
                    var iOC = 0;
                    var iCliente = 1;
                    var iUnidad = 2;
                    var iArticulo = 3;
                    var iLinea = 4;
                    var iCantidad = 5;
                    var iProveedor = 6;
                    var iPresentacion = 7;
                    var iFactor = 8;
                    var iCostoU = 9;
                    var iCostoT = 10;
                    var total = 0.0;
                    var excedente = 0;

                    json_obj_ocm = JSON.parse( result );

                    console.log( "ocm registros: " + json_obj_ocm.length );

                    for ( var i = 0; i < json_obj_ocm.length; i++ )
                    {
                        idProveedorAnt = json_obj_ocm[ i ][ 0 ];
                        idClientAnt = json_obj_ocm[ i ][ 1 ];

                        if ( ( json_obj_ocm[ i ][ iArticulo ] != idArticuloAnt ) || ( json_obj_ocm[ i ][ iUnidad ] ) )
                        {
                            var costoT = 0;

                            if ( json_obj_ocm[ i ][ iArticulo ] != idArticuloAnt )
                            {
                                costoT = 0;
                                $("#mi_tbody").append( "<tr id=\"" + json_obj_ocm[ i ][ iArticulo ] + "\"></tr>" );
                            }// =>  if   2

                            idArticuloAnt = json_obj_ocm[ i ][ iArticulo ];
                            idUnidadAnt = json_obj_ocm[ i ][ iUnidad ];

                            var mi_total = {
                                campos : "IFNULL( SUM( cantidad ), 0 )",
                                table : "bomocm",
                                condicion : "OC = '" + idOCM + "' AND proveedor = '" + idProveedor + "'" + " AND articulo = '" + json_obj_ocm[ i ][ iArticulo ] + "'" + " AND linea = '" + json_obj_ocm[ i ][ iLinea ] + "'" + " AND unidad = '" + json_obj_ocm[ i ][ iUnidad ] + "'",
                                salida_html : "dato",
                                operacion : "consultar-n-campos"
                            };

                            //  =>  Se trae total de articulo
                            $.ajax(
                            {
                                async : false,
                                url : __php_dir__ + "consultas.php",
                                data : jQuery.param( mi_total ),
                                success : function(result, status, xhr)
                                {
                                    var json_obj_total = JSON.parse( result );
                                    var iTotal = 0;

                                    total = ( json_obj_total.length != 0 ) ? Number( json_obj_total[ iTotal ] ) : 0 ;
                                    console.log( "total: " + total );
                                }// =>  success
                            }); //  =>  ajax 

                            var mi_excedente = {
                                campos : "IFNULL( SUM( cantidad ), 0 )",
                                table : "excedente",
                                condicion : "articulo = '" + json_obj_ocm[ i ][ iArticulo ] + "'" + " AND linea = '" + json_obj_ocm[ i ][ iLinea ] + "'" + " AND unidad = '" + json_obj_ocm[ i ][ iUnidad ] + "'",
                                salida_html : "dato",
                                operacion : "consultar-n-campos"
                            };

                            //  =>  Se trae la cantidad de excedentes
                            $.ajax(
                            {
                                async : false,
                                url : __php_dir__ + "consultas.php",
                                data : jQuery.param( mi_excedente ),
                                success : function(result, status, xhr)
                                {
                                    var json_obj_excedente = JSON.parse( result );
                                    var iExcedente = 0;

                                    excedente = ( json_obj_excedente.length != 0 ) ? Number( json_obj_excedente[ iExcedente ] ) : 0;
                                    console.log( "excedente: " + excedente );
                                }// =>  success
                            }); //  =>  ajax 

                            costoT = Number( json_obj_ocm[ i ][ iCostoU ] ) * ( total - excedente );
                            costoT = ( costoT > 0 ) ? costoT : 0;

                            var mi_articulo = {
                                campos : "*",
                                table : "articulo",
                                condicion : "idArticulo = '" + json_obj_ocm[ i ][ iArticulo ] + "'",
                                salida_html : "dato",
                                operacion : "consultar-n-campos"
                            };

                            //  =>  Se recupera los datos del articulo actual
                            $.ajax(
                            {
                                async : false,
                                url : __php_dir__ + "consultas.php",
                                data : jQuery.param( mi_articulo ),
                                success : function(result, status, xhr)
                                {
                                    json_obj_articulo = JSON.parse( result );

                                    console.log( "articulo actual: " + json_obj_articulo );
                                    console.log( "factor: " + json_obj_articulo[ 5 ] );
                                }// =>  success
                            }); //  =>  ajax 


                            var mi_linea = {
                                campos : "*",
                                table : "linea",
                                condicion : "idLinea = '" + json_obj_ocm[ i ][ iLinea ] + "'",
                                salida_html : "dato",
                                operacion : "consultar-n-campos"
                            };

                            //  =>  Se recupera los datos de la linea actual
                            $.ajax(
                            {
                                async : false,
                                url : __php_dir__ + "consultas.php",
                                data : jQuery.param( mi_linea ),
                                success : function(result, status, xhr)
                                {
                                    var json_obj_linea = JSON.parse( result );

                                    console.log( "linea actual: " + json_obj_linea );
                                }// =>  success
                            }); //  =>  ajax 

                            var mi_proveedor = {
                                campos : "*",
                                table : "proveedor",
                                condicion : "idProveedor = " + json_obj_ocm[ i ][ iLinea ],
                                salida_html : "dato",
                                operacion : "consultar-n-campos"
                            };

                            //  =>  Se recupera los datos del proveedor actual
                            $.ajax(
                            {
                                async : false,
                                url : __php_dir__ + "consultas.php",
                                data : jQuery.param( mi_proveedor ),
                                success : function(result, status, xhr)
                                {
                                    var json_obj_proveedor = JSON.parse( result );

                                    console.log( "proveedor actual: " + json_obj_proveedor );
                                }// =>  success
                            }); //  =>  ajax 

                            if ( Number( json_obj_ocm[ i ][ 8 ] ) != 0 )
                            {
                                json_obj_ocm[ i ][ 9 ] = Number( json_obj_ocm[ i ][ 9 ] ) * Number( json_obj_ocm[ i ][ 8 ] );
                                json_obj_ocm[ i ][ 5 ] = Number( json_obj_ocm[ i ][ 5 ] ) / Number( json_obj_ocm[ i ][ 8 ] );
                            }

                            var fila = $("#" + json_obj_ocm[ i ][ iArticulo ]);

                            fila.append( "<td nowrap=\"true\">" + json_obj_ocm[ i ][ iArticulo ] + "</td>" );
                            fila.append( "<td nowrap=\"true\">" + json_obj_articulo[ 1 ] + "</td>" );
                            fila.append( "<td nowrap=\"true\">" + json_obj_articulo[ 3 ] + "</td>" );
                            fila.append( "<td nowrap=\"true\">" + json_obj_ocm[ i ][ iCostoU ] + "</td>" );

                            for ( ii = 0; ii < json_obj_unidadesxcliente.length; ii++ )
                            {
                                if ( json_obj_unidadesxcliente[ ii ][ 0 ] === json_obj_ocm[ i ][ iUnidad ] )
                                    fila.append( "<td nowrap=\"true\">" + json_obj_ocm[ i ][ iCantidad ] + "</td>" );
                            }
                        }// if  1
                    }// =>  for
                }
            }); //  =>  ajax 

            //  =>  JSON object
            iJoinTabla1 = {
                table_name : "articulo",
                index_field : [
                "nombre"
                ],
                key : "precioprov.articulo",
                foreing_key : "articulo.idArticulo"
            };

            iJoinTabla3 = {
                table_name : "precioprov",
                index_field : [
                "articulo"
                ]
            };

            iJoinTablas = {
                arg1 : {},
                arg3 : {}
            };

            iJoinTablas.arg3 = iJoinTabla1;
            iJoinTablas.arg1 = iJoinTabla3;

            peticionInnerJoin( iJoinTablas, "inner-join-consultar", "proveedor='" + idProveedor + "'", "option" );
            rellenarSelectArticulo();
            $("[name='unidadA']").text("");
            $("[name='costo']").text("");

            var cantidades = $("#contenedor-cantidades [type='number']");

            if ( cantidades.length > 0 )
            {
                cantidades.each( function()
                {
                    $(this).val("0");
                });

                $("#2").css("visibility", "hidden");
            }

            $("tr[class*='elegido']").each( function()
            {
                $(this).toggleClass("danger elegido");
            });

            mostrarBotonEliminarArticulo();
            mostrarBotonModificarArticulo();
        }
    });//   =>  on

    $("#mi_tbody").on("click", "tr", seleccionarFila);
    $("#contenedor-cantidades").on("change", "[type='number']", mostrarBotonAgregarArticulo);
    // $("#2").on({mouseover : mouseOverBotonAgregarArticulo, mouseout : mouseOutBotonAgregarArticulo});

    obtClaveParaOCManual();
</script>