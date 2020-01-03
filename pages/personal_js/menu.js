var _pestana_activa_ = null;
var _args_busqueda_ = null;
var _texto_ayuda_ = null;
var __contenedor_contenido__ = null;
var _url_args_ = null;

function destruirVariablesDeMenu()
{
    var _pestana_activa_ = null;
    var _args_busqueda_ = null;
    var _texto_ayuda_ = null;
    var __contenedor_contenido__ = null;
    var _url_args_ = "";
}

function cargarVariablesDeMenu()
{
    _pestana_activa_ = obtPestanaActiva();
    _args_busqueda_ = $("div[id='contenedor-args-busqueda']");
    _texto_ayuda_ = $("div[id='texto-ayuda']");
    __contenedor_contenido__ = $("div[id='tab-contenedor']");
    _url_args_ = "";

    $( __contenedor_contenido__ ).css("height", ( $(window).height() * 0.55) + "px" );
    $( __contenedor_contenido__ ).css("overflow-y", "scroll" );
    $( __contenedor_contenido__ ).css("overflow-x", "hidden" );
}

function consultar()
{
    var contexto = obtPestanaActiva().attr("data-contexto");

    URLArgs("clear");
    URLArgs("refresh");
    URLArgs("append", obtenerArgTabla());

    switch ( contexto )
    {
        case "consultar":
            URLArgs("append", "&operacion=consultar");
        break;

        case "eliminar":
            URLArgs("append", "&operacion=consultar-eliminar");
        break;

        case "modificar":
            URLArgs("append", "&operacion=consultar-modificar");
        break;
    }

    var mi_url = URLArgs("get");
    URLArgs("clear");

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var array_response = JSON.parse( result );
            var select_pages = $("select[id='arg-3']");
            var current_page = select_pages.val();
            var total_pages = 0;
            var i = 0;

            __contenedor_contenido__.remove( __contenedor_contenido__.children() );
            __contenedor_contenido__.html( array_response['respuesta'] );

            total_pages = ( !isNaN( array_response['contador_paginas'] ) ) ? Number( array_response['contador_paginas'] ) : 0;

            if ( total_pages > 0 )
            {
                select_pages.empty();

                for (var i = 0; i < total_pages; i++)
                    select_pages.append("<option>" + (i + 1) + "</option>");

                if ( current_page < total_pages )
                    select_pages.val( current_page );
            }
        },
        error : function(xhr, status, error)
        {
            alert ("Error: " + status + " " + error );
        },
        complete : function(xhr, status)
        {
            switch ( contexto )
            {
                case "eliminar":
                    $.getScript( __js_dir__ + "tabla-eliminar.js");
                break;

                case "modificar":
                    $.getScript( __js_dir__ + "tabla-modificar.js");
                break;
            }
        }
    }); //  =>  ajax
}

function contexto()
{
    var contexto = obtPestanaActiva().attr("data-contexto");

    //  =>   Dependiendo de la pestana activa
    if ( contexto === "eliminar" )
    {
        switch ( __contenedor_menu__.attr("data-menu-actual") )
        {
            case "menu-precioprov":
                joinPrecios();
            break;

            case "menu-subunidad":
                joinSubunidad();
            break;

            case "menu-unidad":
                joinUnidad();
            break;

            default:
                mostrarTablaParaEliminar();
        }
    }
    else if ( contexto === "modificar" )
    {
        switch ( __contenedor_menu__.attr("data-menu-actual") )
        {
            case "menu-precioprov":
                joinPrecios();
            break;

            case "menu-subunidad":
                joinSubunidad();
            break;

            case "menu-unidad":
                joinUnidad();
            break;

            default:
                mostrarTablaParaModificar();
        }
    }
    else
    {
        switch ( __contenedor_menu__.attr("data-menu-actual") )
        {
            case "menu-precioprov":
                joinPrecios();
            break;

            case "menu-subunidad":
                joinSubunidad();
            break;

            case "menu-unidad":
                joinUnidad();
            break;

            default:
                consultar();
        }
    }
}

function joinPrecios()
{
    //  =>  JSON object
    table1 = {
        table_name : "proveedor",
        index_field : [
        "nombre AS 'Nombre del proveedor'"
        ],
        key : "proveedor.idProveedor",
        foreing_key : "precioprov.proveedor"
    };

    table2 = {
        table_name : "articulo",
        index_field : [
            "nombre AS 'Nombre del artículo'"
            ],
        key : "articulo.idArticulo",
        foreing_key : "precioprov.articulo"
    };

    table3 = {
        table_name : "precioprov",
        index_field : [
        "id AS Clave",
        "precio AS Precio",
        "unidadA AS Presentación",
        "factor AS Unidades",
        ]
    };

    iJoin = {
        arg1 : {},
        arg2 : {},
        arg3 : {}
    };

    iJoin.arg3 = table1;
    iJoin.arg2 = table2;
    iJoin.arg1 = table3;

    innerJoin();
}

function joinSubunidad()
{
    //  =>  JSON object
    table1 = {
        table_name : "cliente",
        index_field : [
        "nombre AS 'Nombre del cliente'"
        ],
        key : "cliente.idCliente",
        foreing_key : "subunidad.cliente"
    };

    table2 = {
        table_name : "unidad",
        index_field : [
            "unidad AS 'Nombre de la unidad'"
            ],
        key : "unidad.idUnidad",
        foreing_key : "subunidad.unidad"
    };

    table3 = {
        table_name : "subunidad",
        index_field : [
        "idSUnidad AS Clave",
        "subUnidad AS 'Nombre de la subunidad'",
        "info AS Información"
        ]
    };

    iJoin = {
        arg1 : {},
        arg2 : {},
        arg3 : {}
    };

    iJoin.arg3 = table1;
    iJoin.arg2 = table2;
    iJoin.arg1 = table3;

    innerJoin();
}

function joinUnidad()
{
    table1 = {
        table_name : "cliente",
        index_field : [
        "nombre AS 'Nombre del cliente'"
        ],
        key : "cliente.idCliente",
        foreing_key : "unidad.cliente"
    };

    table2 = {
        table_name : "unidad",
        index_field : [
            "idUnidad AS Clave",
            "unidad AS 'Nombre de la unidad'",
            "info AS Información"
            ]
    };

    iJoin = {
        arg1 : {},
        arg3 : {}
    };

    iJoin.arg3 = table1;
    iJoin.arg1 = table2;

    innerJoin();
}

function obtPestanaActiva()
{
    return $("div.panel-body ul.nav-tabs a.active");
}

function anadirBotones(botones)
{
    var i = 0;
    var vec = botones.split(" ");
    var vec_bot_func;
    var contenedor_botones = $("div[id='botones']");

    contenedor_botones.empty();
    contenedor_botones.append("<div class=\"col-sm-12 col-md-3\"></div>");
    contenedor_botones.append("<div class=\"col-sm-12 col-md-3\"></div>");
    contenedor_botones.append("<div class=\"col-sm-12 col-md-3\"></div>");
    contenedor_botones.append("<div class=\"col-sm-12 col-md-3\"></div>");

    for (i; i < vec.length; i++)
    {
        vec[i] = vec[i].replace(/-/g, ' ');
        vec_bot_func = vec[i].split(':');
        // contenedor_botones.append("<button class=\"btn btn-primary btn-outline btn-sm\" type=\"button\" id=\"" + i + "\" onclick=\"" + vec_bot_func[1] + "\">" + vec_bot_func[0] + "</button>");
        contenedor_botones.find("div:nth-child(" + ( i + 1 ) + ")").append("<button class=\"btn btn-primary btn-block\" type=\"button\" id=\"" +
            i + "\" onclick=\"" + vec_bot_func[1] + "\">" + vec_bot_func[0] + "</button>");
    }
}

function textoAyuda(texto="Texto por defecto", clase="", encabezado="")
{
    var dom_contenedor_label = $("div#texto-ayuda");

    dom_contenedor_label.empty();
    if ( encabezado != "" )
        dom_contenedor_label.append("<h4>" + encabezado + "</h4>");

    dom_contenedor_label.attr("class", clase)
    dom_contenedor_label.append("<p>" + texto + "</p>");
}

function registrar()
{
    if( checarCamposRequire() )
    {
        serializarForm();
        URLArgs("append", obtenerArgTabla());
        URLArgs("append", "&operacion=registrar");
        var mi_url = URLArgs("get");

        $.ajax(
        {
            url : __php_dir__ + "consultas.php",
            data : mi_url,
            success : function(result, status, xhr)
            {
                if ( result.indexOf( "existe" ) > -1 )
                {
                    textoAyuda( result, "text-danger", "Error" );
                }
                else
                {
                    limpiarForm();
                    textoAyuda( "Proporcione la Información requerida por el formulario" );
                }

                alert ( result );
            }
        });//   =>  ajax
    }
    else
        textoAyuda("Por favor, rellene todos los campos obligatorios dentro del formulario", "text-danger", "Error");
}

function serializarForm()
{
    URLArgs("clear");

    $("form input:not(.excluded), form select:not(.excluded)").each(function()
    {
        var pos = $(this).val().indexOf(":");
        var value = $(this).val();
        var key = $(this).attr("name");

        if ( pos > -1 )
            value = value.slice( 0, pos );

        URLArgs("append", "&" + key + "=" + value);
    }); //  =>  each

    var pos = URLArgs("get").indexOf("&");
    URLArgs("set", URLArgs("get").slice(pos + 1));
    return (URLArgs("get"));
}

function limpiarForm()
{
    var inputs = document.getElementsByTagName('input');

    for (var i = 0; i<inputs.length; i++)
    {
        switch (inputs[i].type) {
            // case 'hidden':
            case 'email':
            case 'text':
                inputs[i].value = '';
            break;

            case 'radio':
            case 'checkbox':
                inputs[i].checked = false;   
        }
    }

    // clearing selects
    var selects = document.getElementsByTagName('select');

    for (var i = 0; i<selects.length; i++)
        selects[i].selectedIndex = 0;

    $("#0").css("visibility", "hidden");
    $("#1").css("visibility", "hidden");

    alert("Se ha limpiado el formulario");
}

//  =>   Clic en boton 'Cancelar'
function cancelar()
{
    //  =>   Restablece los datos RESPALDADOS de la tabla
    restaurarRespaldo();

    alert( "Los cambios realizados han sido descartados" );
}   //  =>  Funcion cancelar


function mostrarTablaParaEliminar()
{
    var url_args = "";

    URLArgs("clear");
    URLArgs("refresh");
    URLArgs("append", obtenerArgTabla());
    URLArgs("append", "&operacion=consultar-eliminar");
    url_args = URLArgs("get");
    URLArgs("clear");

  //  =>   Enviar peticion
    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : url_args,
        success : function(result, status, xhr)
        {
            var array_response = JSON.parse( result );
            var select_pages = $("select[id='arg-3']");
            var current_page = select_pages.val();
            var total_pages = 0;
            var i = 0;

            __contenedor_contenido__.remove( __contenedor_contenido__.children() );
            __contenedor_contenido__.html( array_response['respuesta'] );

            total_pages = ( !isNaN( array_response['contador_paginas'] ) ) ? Number( array_response['contador_paginas'] ) : 0;

            if ( total_pages > 0 )
            {
                select_pages.empty();

                for (var i = 0; i < total_pages; i++)
                    select_pages.append("<option>" + (i + 1) + "</option>");

                if ( current_page < total_pages )
                    select_pages.val( current_page );
            }
        },
        error : function(xhr, status, error)
        {
            alert ("Error: " + status + " " + error );
        },
        complete : function(xhr, status)
        {
            $.getScript( __js_dir__ + "tabla-eliminar.js");
        }
    }); //  =>  ajax
}

function mostrarTablaParaModificar()
{
    URLArgs("clear");
    URLArgs("refresh");
    URLArgs("append", obtenerArgTabla());
    URLArgs("append", "&operacion=consultar-modificar");
    var mi_url = URLArgs("get");

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var array_response = JSON.parse( result );
            var select_pages = $("select[id='arg-3']");
            var current_page = select_pages.val();
            var total_pages = 0;
            var i = 0;

            __contenedor_contenido__.remove( __contenedor_contenido__.children() );
            __contenedor_contenido__.html( array_response['respuesta'] );

            total_pages = ( !isNaN( array_response['contador_paginas'] ) ) ? Number( array_response['contador_paginas'] ) : 0;

            if ( total_pages > 0 )
            {
                select_pages.empty();

                for (var i = 0; i < total_pages; i++)
                    select_pages.append("<option>" + (i + 1) + "</option>");

                if ( current_page < total_pages )
                    select_pages.val( current_page );
            }
        },
        complete : function(xhr, status)
        {
            $.getScript( __js_dir__ + "tabla-modificar.js");
        }
    });   // =>  ajax
}

//  =>   Clic en boton 'Modificar'
function guardarCambios()
{
    var filas_editadas = $("tr[data-editado='true']");

    //  =>   Cada fila cambiada
    filas_editadas.each( function()
    {
        var campo_clave = $(this).find("td:first div");
        var campos_editados = $(this).find("div[data-editado='true']");
        var key = campo_clave.attr("data-key");
        var value = campo_clave.text();

        URLArgs("clear");
        URLArgs("append", key + "=" + value);
        campos_editados.each( function(index, element)
        {
            URLArgs("append", "&" + $(this).attr("data-key") + "=" + $(this).text());
        });
        URLArgs("append", obtenerArgTabla());
        URLArgs("append", "&operacion=update");
        mi_url = URLArgs("get");

        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data : mi_url,
            success : function(result, status, xhr)
            {
                alert( result );
            }
        }); //  =>  ajax
    }); //  =>  each

    contexto();
    respaldarTabla();
    mostrarBotonCancelarCambios();
    mostrarBotonGuardarCambios();
}   //  =>  guardarCambios

function guardarCambiosPrecio()
{
    var filas_editadas = $("tr[data-editado='true']");

    //  =>   Cada fila cambiada
    filas_editadas.each( function()
    {
        var indices = [];
        var values = [];
        var campo_clave = $("thead").find("th:first").attr("data-key");
        var campo_clave_value = $(this).find("td:first div").text();
        var tabla_ths = $("table th").toArray();
        var campos = $(this).find("td");

        URLArgs( "clear" );
        URLArgs( "append", campo_clave + "=" + campo_clave_value );
        campos.each( function(index, element)
        {
            var col = $(this).children( "div" );
            if ( col.attr("data-editado") === "true")
            {
                indices.push( index );
                values.push( col.text() );
            }
        });//   =>  each

        for ( i = 0; i < indices.length; i++ )
            URLArgs ( "append", "&" + tabla_ths[ indices[i] ].dataset.key + "=" + values[i] );

        URLArgs("append", obtenerArgTabla());
        URLArgs("append", "&operacion=update");
        var mi_url = URLArgs("get");

        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data : mi_url,
            success : function(result, status, xhr)
            {
                alert( result );
            }
        }); //  =>  ajax
    }); //  =>  each

    contexto();
}   //  =>  guardarCambiosPrecio

function eliminar()
{
    var filas_elegidas = $("tr[class*='elegido']");

    if ( filas_elegidas.length > 0 )
    {
        filas_elegidas.each( function()
        {
            var url_args = "";

            URLArgs("clear");
            URLArgs("append",  $(this).find("td:first div").attr("data-key") + "=" + $(this).find("td:first").text());
            URLArgs("append", obtenerArgTabla());
            URLArgs("append", "&operacion=delete");
            url_args = URLArgs("get");
            URLArgs("clear");
            $(this).toggleClass("alert alert-danger elegido");

            $.ajax(
            {
                async : false,
                data : url_args,
                url : __php_dir__ + "consultas.php",
                success : function(result, status, xhr)
                {
                    __contenedor_contenido__.empty();
                }
            });
        }); //  each

        calcularNumeroPaginas();
        contexto();

        //  =>  Depende del orden de aparicion en Menu*.php
        $("button[id='0']").css("visibility", "hidden");
    }
    else
        alert( "No ha seleccionado ninguna fila" );
}

function eliminarPrecio()
{
    $("tr[class*='elegido']").each( function()
    {
        var url_args = "";

        URLArgs("clear");
        URLArgs("append",  $("table").find("th").attr("data-key") + "=" + $(this).find("td:first").text());
        URLArgs("append",  "&" + $("table").find("th").next().attr("data-key") + "=" + $(this).find("td:first").next().text());
        URLArgs("append", obtenerArgTabla());

        switch ( __contenedor_menu__.attr("data-menu-actual") )
        {
            case "menu-unidad":
                URLArgs("append", "&operacion=delete");
            break;

            case "menu-precioprov":
                URLArgs("append", "&operacion=delete-precio");
            break;

            case "menu-subunidad":
                URLArgs("append", "&operacion=delete");
            break;
        }


        url_args = URLArgs("get");
        URLArgs("clear");
        $(this).toggleClass("alert alert-danger elegido");

      $.ajax(
        {
            async : false,
            data : url_args,
            url : __php_dir__ + "consultas.php",
            success : function(result, status, xhr)
            {
                __contenedor_contenido__.remove( __contenedor_contenido__.children() );
                alert ( result );
            }
        });

    }); //  each

    //  =>  Mostrar en pantalla la tabla con las funciones correspondientes al contexto
    contexto();
}

function URLArgs(operacion="", arg="")
{
    if ( operacion == "refresh" )
      window._url_args_ = $.param( $("[id|='arg']").toArray() );
    else if ( operacion == "append" )
        window._url_args_ = window._url_args_ + arg;
    else if ( operacion == "get" )
        return window._url_args_;
    else if ( operacion == "set" )
        window._url_args_ = arg;
    else if ( operacion == "clear" )
        window._url_args_ = "";
}

function obtenerArgTabla()
{
    var texto = __contenedor_menu__.attr("data-menu-actual");
    var pos = texto.indexOf('-');

    return "&table=" + texto.slice(pos + 1);
}   //Funcion principal

function calcularNumeroPaginas()
{
    URLArgs("refresh");
    URLArgs( "append", "&operacion=calcular_paginas" );
    URLArgs( "append", obtenerArgTabla() );
    var mi_url = URLArgs("get");
    URLArgs("clear");

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var i = 0;
            var total_pages = Number( result );
            var pages = $("select[id='arg-3']");

            pages.empty();

            for (var i = 0; i < total_pages; i++)
                pages.append("<option>" + (i + 1) + "</option>");
        }
    });
}   //Funcion principal

function cargarCriteriosDeOrden()
{
    URLArgs("clear");
    URLArgs("append", "operacion=obtener-criterios-orden");
    URLArgs("append", obtenerArgTabla());
    var mi_url = URLArgs("get");
    URLArgs("clear");

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var obj = JSON.parse( result );
            var mi_select = $("select[id='arg-2']");

            mi_select.empty();


            for ( key in obj )
            {
                switch ( __contenedor_menu__.attr("data-menu-actual") )
                {
                    case "menu-precioprov":
                    case "menu-subunidad":
                    case "menu-unidad":
                        mi_select.append("<option value=\"'" + obj[ key ] + "'\">" + obj[key] + "</option>");
                    break;

                    default:
                        mi_select.append("<option value=\"" + key + "\">" + obj[key] + "</option>");
                }
            }
        }
    });   // =>  ajax
}   //  =>  Fin cargarCriterioDeOrden

function limpiarContenedores()
{
    window._texto_ayuda_.empty();
    window._args_busqueda_.hide();
}

function innerJoin()
{
    URLArgs("clear");
    URLArgs("refresh");
    URLArgs("append", "&x=" + JSON.stringify( iJoin ));
    URLArgs("append", obtenerArgTabla());

    switch ( obtPestanaActiva().attr("data-contexto") )
    {
        case "consultar":
            URLArgs("append", "&operacion=inner-join-consultar");
        break;

        case "eliminar":
            URLArgs("append", "&operacion=inner-join-eliminar");
        break;

        case "modificar":
            URLArgs("append", "&operacion=inner-join-modificar");
        break;
    }

    var mi_url = URLArgs("get");

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function(result, status, xhr)
        {
            var array_response = JSON.parse( result );
            var select_pages = $("select[id='arg-3']");
            var current_page = select_pages.val();
            var total_pages = 0;
            var i = 0;

            __contenedor_contenido__.remove( __contenedor_contenido__.children() );
            __contenedor_contenido__.html( array_response['respuesta'] );

            total_pages = ( !isNaN( array_response['contador_paginas'] ) ) ? Number( array_response['contador_paginas'] ) : 0;

            if ( total_pages > 0 )
            {
                select_pages.empty();

                for (var i = 0; i < total_pages; i++)
                    select_pages.append("<option>" + (i + 1) + "</option>");

                if ( current_page < total_pages )
                    select_pages.val( current_page );
            }
        },
        complete : function(status, xhr)
        {
            switch ( obtPestanaActiva().attr("data-contexto") )
            {
                case "eliminar":
                    $.getScript( __js_dir__ + "tabla-eliminar.js" );
                break;

                case "modificar":
                    $.getScript( __js_dir__ + "tabla-modificar.js" );
                break;
            }
        }
    });
}

function registrarSubUnidad()
{
    if ( checarCamposRequire() )
    {
        serializarForm();
        URLArgs("append", obtenerArgTabla());
        URLArgs("append", "&operacion=comprobar-cliente-unidad-subunidad");
        var mi_url = URLArgs("get");

        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data : mi_url,
            success : function(result, status, xhr)
            {
                alert ( result );
            }
        }); //  =>  ajax
    }
}

function registrarPrecio()
{
    if ( checarCamposRequire() )
    {
        serializarForm();
        URLArgs("append", obtenerArgTabla());

        switch ( __contenedor_menu__.attr("data-menu-actual") )
        {
            case "menu-precioprov":
                URLArgs("append", "&operacion=registrar-precio");
            break;

            case "menu-subunidad":
                // URLArgs("append", "&operacion=comprobar-cliente-unidad-subunidad");
                URLArgs("append", "&operacion=registrar");
            break;
        }

        var mi_url = URLArgs("get");

        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data : mi_url,
            success : function(result, status, xhr)
            {
                alert ( result );
            },
            complete : function(status, xhr)
            {
                limpiarForm();
            }
        }); //  =>  ajax

        URLArgs("clear");
    }
}   //  =>  registrarPrecio

function resetearArgumentosDeBusqueda()
{
    $("#arg-2").empty();
    $("#arg-3").empty();
    $("#arg-4").val("");
    $( "#contenedor-args-busqueda" ).css( "display", "none" );
}

function mostrarArgumentosDeBusqueda()
{
    $( "#contenedor-args-busqueda" ).css( "display", "block" );
}

//  =>   Modifica algun argumento de busqueda
function cargarEventHandlers()
{
    $(document).on("change", "select[id|='arg']", function()
    {
        if ( $(this).attr("id") == "arg-1" )
            calcularNumeroPaginas();

        contexto();
    }); //  =>  on

    $(document).on( "keyup", "#arg-4", contexto );
}