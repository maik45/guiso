<div class="row">
    <div class="col-md-4 col-sm-12">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label>Clave</label>
            </div>
            <div class="col-md-9 col-sm-12">
                <select id="id-ocm">
                    <option>O.C.M.</option>
                </select>
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
                <label id="fechaI"></label>
            </div>
            <div class="col-md-6 col-sm-12">
                <label id="fechaF">
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
                <label name="cliente"></label>
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
    Date.prototype.getWeek = function()
    {
        var onejan = new Date(this.getFullYear(), 0, 1);
        return Math.ceil((((this - onejan) / 86400000) + onejan.getDay() + 1) / 7);
    }

    function selectOCM()
    {
        var mi_select = $("#id-ocm");
        var json_obj_ocm = null;

        iJoinTabla3 = {
            table_name : "ocm",
            index_field : [
            "id",
            "idOC"
            ]
        };

        iJoinTablas = {
            arg1 : {}
        };

        iJoinTablas.arg1 = iJoinTabla3;

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "status < 2", "vec2" );
        json_obj_ocm = _json_response_;
        _json_response_ = null;

        // var obj = JSON.parse( json_obj_ocm );

        mi_select.empty();

        for (var i = 0; i < json_obj_ocm.length; i++)
            mi_select.append( "<option value=\"" + json_obj_ocm[ i ][ 1 ] + "\">" + json_obj_ocm[ i ][ 1 ] + "</option>" );
    }

    function elegirOCM()
    {
        var json_obj_unidadesxcliente = null;
        var json_obj_articuloelegido = null;
        var unidades_diferentes = [];
        var json_obj_cliente = null;
        var json_obj_bomocm = null;
        var vec_totalxunidad = [];
        var json_obj_ocm = null;
        var totalxunidades = 0;
        var id_ocm = null;
        var fecha = null;
        var fechaI = "";
        var fechaF = "";
        var semana = 0;

        var id_ocm = $(this).val();

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

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "cliente.idCliente='" + json_obj_ocm[ 2 ] + "'", "1fila" );
        json_obj_cliente = _json_response_;
        _json_response_ = null;

        fechaI = json_obj_ocm[ 3 ].slice( 0, json_obj_ocm[ 3 ].indexOf( " " ) );
        fechaF = json_obj_ocm[ 4 ].slice( 0, json_obj_ocm[ 4 ].indexOf( " " ) );

        fecha = new Date( json_obj_ocm[ 3 ] );
        semana = fecha.getWeek();

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

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "unidad.cliente='" + json_obj_ocm[ 2 ] + "'", "vec2" );
        json_obj_unidadesxcliente = _json_response_;
        _json_response_ = null;

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

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "bomocm.OC='" + json_obj_ocm[ 1 ] + "'", "vec2" );
        json_obj_bomocm = _json_response_;
        _json_response_ = null;

        for ( var i = 0; i < json_obj_bomocm.length; i++ )
        {
            if ( !unidades_diferentes.includes( json_obj_bomocm[ i ][ 5 ] ) )
                unidades_diferentes.push( json_obj_bomocm[ i ][ 5 ] );
        }

        var dom_act = null;
        vec_totalxunidad.splice( 0, vec_totalxunidad.length );
        $("#contenedor_unidades").empty();
        $("#contenedor-cantidades").empty();
        $("#mi_thead").empty();
        $("#mi_thead").append( "<td nowrap=\"true\">Clave (Producto)</td>" );
        $("#mi_thead").append( "<td nowrap=\"true\">Nombre (Producto)</td>" );
        $("#mi_thead").append( "<td nowrap=\"true\">Presentación (Producto)</td>" );
        $("#mi_thead").append( "<td nowrap=\"true\">Precio</td>" );

        for ( var i = 0; i < unidades_diferentes.length; i++ )
        {
            $("#contenedor_unidades").append( "<label>( " + unidades_diferentes[ i ] + " )</label>");

            vec_totalxunidad.push( 0.0 );

            if ( ( i % 2 ) == 0)
                $("#contenedor-cantidades").append( "<div class=\"row\"><div class=\"col-md-6 col-sm-12\"></div><div class=\"col-md-6 col-sm-12\"></div></div>" );

            dom_act = $("#contenedor-cantidades > div:last-child");

            if ( ( i % 2 ) == 0 )
            {
                dom_act.find("div:first-child").append( "<label>Ingrese cantidad para (" + unidades_diferentes[ i ] + " ) " +  json_obj_unidadesxcliente[ i ][ 1 ] + ": </label>");
                dom_act.find("div:first-child").append( "<input value=\"" + vec_totalxunidad[ i ] + "\" name=\"cantidad-" + i + "\" type=\"number\">");
                dom_act.find("div:first-child").append( "<br>");
            }
            else
            {
                dom_act.find("div:last-child").append( "<label>Ingrese cantidad para (" + unidades_diferentes[ i ] + " ) " +  json_obj_unidadesxcliente[ i ][ 1 ] + ": </label>");
                dom_act.find("div:last-child").append( "<input value=\"" + vec_totalxunidad[ i ] + "\" name=\"cantidad-" + i + "\" type=\"number\">");
                dom_act.find("div:last-child").append( "<br>");
            }

            $("#mi_thead").append( "<td nowrap=\"true\">( " + unidades_diferentes[ i ] + " ) " + json_obj_unidadesxcliente[ i ][ 1 ] + "</td>" );
        }

        $("#mi_thead").append( "<td nowrap=\"true\">Total</td>" );

        var articulo_anterior = "";
        var ii = 0;
        $("#mi_tbody").empty();

        for ( var i = 0; i < json_obj_bomocm.length; i++ )
        {
            if ( articulo_anterior != json_obj_bomocm[ i ][ 6 ] )
            {
                articulo_anterior = json_obj_bomocm[ i ][ 6 ];


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

                peticionInnerJoin( iJoinTablas, "inner-join-consultar", "articulo.idArticulo='" + json_obj_bomocm[ i ][ 6 ] + "'", "1fila" );
                json_obj_articuloelegido = _json_response_;
                _json_response_ = null;


                $("#mi_tbody").append( "<tr id=\"" + json_obj_articuloelegido[ 1 ] + "\"></tr>" );
                var mi_fila = $("#mi_tbody tr:last-child");

                mi_fila.append( "<td>" + json_obj_articuloelegido[ 0 ] + "</td>" );
                mi_fila.append( "<td>" + json_obj_articuloelegido[ 1 ] + "</td>" );
                mi_fila.append( "<td>" + json_obj_articuloelegido[ 3 ] + "</td>" );
                mi_fila.append( "<td>" + json_obj_bomocm[ i ][ 12 ] + "</td>" );

                totalxunidades = 0;

                for ( var j = 0; j < unidades_diferentes.length; j++ )
                {
                    mi_fila.append( "<td>" + json_obj_bomocm[ ( ii * unidades_diferentes.length ) + j ][ 8 ] + "</td>" );
                    totalxunidades += Number( json_obj_bomocm[ ( ii * unidades_diferentes.length ) + j ][ 13 ] );
                }

                mi_fila.append( "<td>" + totalxunidades + "</td>" );
                ii += 1;
            }
        }
    }

    function seleccionarFila()
    {
        $(this).toggleClass("danger elegido");

        if ( $(this).attr( "class" ) == "danger elegido" )
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

            id_ocm = $("#id-ocm").val();

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
            $("[name='unidadA']").text( presentacion );
            $("[name='proveedor']").val( json_obj_bomocm[ 9 ] );
        }
    }

    function selectDadoProveedor()
    {
        if ( $("#id-ocm").val() != "O.C.M." )
        {
            var json_obj_ocm = null;
            var idCliente = null;
            var semana = null;
            var fecha = null;
            var idOCM = null;

            idProveedor = $(this).val();

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
        }
        else
            alert( "Primero elija una orden de compra" );
    }

    function eliminarPrecios()
    {
        var filas_elegidas = $("tr[class*='elegido']");
        var id_ocm = null;
        var idCliente = 0;

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
            var presentacion = "";
            var cantidades = [];
            var idProveedor = 0;
            var idArticulo = 0;
            var articulo = "";
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

            id_ocm = $("#id-ocm").val();

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

            idCliente = json_obj_ocm[ 2 ];
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
    }

    function agregarArticuloAOrdenDeCompra()
    {
        var json_obj_unidadesxcliente = null;
        var json_obj_articuloelegido = null;
        var vec_totalxunidad = [];
        var json_obj_ocm = null;
        var idArticulo = null;
        var unidadA = null;
        var factor = null;
        var linea = null;
        var cantidades = [];

        var idCliente = null;
        var id_ocm = null;
        var bandera = true;
        var fechaI = "";
        var fechaF = "";
        var fecha = new Date();
        var totalxunidades = 0;
        var costo = 0;

        fecha = fecha.getFullYear() + "-" + ( fecha.getMonth() + 1 ) + "-" + fecha.getDate();

        //  =>  Debe haber clave asignada a la orden de compra
        id_ocm = $("#id-ocm").val();

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

        //  =>  Debe haber un proveedor elegido
        if ( $("[name='proveedor']").val() )
            idProveedor = $("select[name='proveedor']").val();

        idCliente = json_obj_ocm[ 2 ];

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

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "precioprov.articulo='" + $("[name='articulo']").val() + "' AND precioprov.proveedor='" + idProveedor + "'", "1fila" );
        json_obj_articuloelegido = _json_response_;
        _json_response_ = null;

        $("[name='consto']").text( json_obj_articuloelegido[ 0 ] );


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

        //  =>  Debe haber articulo
        if ( $("[name='articulo']").val() )
        {
            var cantidad_valor = 0;

            idArticulo = $("select[name='articulo']").val();
            factor = ( isNaN( json_obj_articuloelegido[ 5 ] ) ) ? Number( json_obj_articuloelegido[ 5 ] ) : 1;

            //  =>  Recuperar las cantidades
            $("input[name|='cantidad']").each( function(index)
            {
                cantidad_valor = ( !isNaN( $(this).val() ) ) ? Number( $(this).val() ) : 0;
                cantidades.push( cantidad_valor );
            });//    =>  each

            for ( i = 0; i < cantidades.length; i++ )
            {
                if ( factor > 0 )
                {
                    cantidades[ i ] = cantidades[ i ] * factor;

                    if ( cantidades[ i ] <= 0)
                        return;
                }
            }

            costo = ( !isNaN( json_obj_articuloelegido[ 0 ] ) ) ? Number( json_obj_articuloelegido[ 0 ] ) : 0;

            if ( factor > 0 )
                costo = costo / factor;

            for ( i = 0; i < cantidades.length; i++ )
                if ( cantidades[ i ] )
                    vec_totalxunidad.push( cantidades[ i ] * costo );
        }
        else
        {
            alert ( "Ingrese un articulo" );
            bandera = false;
        }

        URLArgs( "clear" );
        URLArgs( "append", "idOC=" + id_ocm );
        URLArgs( "append", "&cliente=" + idCliente );
        URLArgs( "append", "&fechaI=" + json_obj_ocm[ 3 ] );
        URLArgs( "append", "&fechaF=" + json_obj_ocm[ 4 ] );
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
            URLArgs( "append", "OC=" + id_ocm );
            URLArgs( "append", "&fechaI=" + json_obj_ocm[ 3 ] );
            URLArgs( "append", "&fechaF=" + json_obj_ocm[ 4 ] );
            URLArgs( "append", "&hoja=0" );
            URLArgs( "append", "&cliente=" + idCliente );
            URLArgs( "append", "&unidad=" + json_obj_unidadesxcliente[ i ][ 0 ] );
            URLArgs( "append", "&articulo=" + json_obj_articuloelegido[ 1 ] );
            URLArgs( "append", "&linea=" + json_obj_articuloelegido[ 6 ] );
            URLArgs( "append", "&cantidad=" + cantidades[ i ] );
            URLArgs( "append", "&proveedor=" + idProveedor );
            URLArgs( "append", "&presentacion=" + json_obj_articuloelegido[ 4 ] );
            URLArgs( "append", "&factor=" + json_obj_articuloelegido[ 5 ] );
            URLArgs( "append", "&costoU=" + json_obj_articuloelegido[ 0 ] );
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

        if ( bandera )
        {
            $("#mi_tbody").append( "<tr id=\"" + json_obj_articuloelegido[ 1 ] + "\"></tr>" );
            var mi_fila = $("#mi_tbody tr:last-child");

            mi_fila.append( "<td>" + json_obj_articuloelegido[ 1 ] + "</td>" );
            mi_fila.append( "<td>" + json_obj_articuloelegido[ 2 ] + "</td>" );
            mi_fila.append( "<td>" + json_obj_articuloelegido[ 3 ] + "</td>" );
            mi_fila.append( "<td>" + json_obj_articuloelegido[ 0 ] + "</td>" );

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
        }
    }

    function modificarOrdenDeCompra()
    {
        var filas_elegidas = $("tr[class*='elegido']");
        var id_ocm = null;
        var idCliente = "";

        if ( filas_elegidas.length == 1 )
        {
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

                id_ocm = $("#id-ocm").val();

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
                fechaA = json_obj_ocm[ 6 ];

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

                idCliente = json_obj_ocm[ 2 ];
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
        }
        else
            alert( "Para modificar las cantidades es necesario que solo haya una fila seleccionada ( fila en color rojo )" );
    }

    $("#id-ocm").one( "click", selectOCM );
    $("#id-ocm").on( "change", elegirOCM );
    $("#mi_tbody").on("click", "tr", seleccionarFila);
    $("[name='proveedor']").on( "change", selectDadoProveedor );
</script>