// Para que los labels no esten vacios y se agregue el atributo required
$("[class='form-control'],[class='form-control excluded']").siblings("label").each( function()
{
    var data_texto = $(this).attr("data-texto");

    $(this).text(data_texto);

    if ( data_texto.indexOf("*") > -1 )
        $(this).next().attr("required", "true");
}); //  =>  each

//  =>   <Select> e <input> pertenecen a '.form-control'
//  =>   Estos dos elementos necesitan ser 'required'
$("[class='form-control'][required]").on(
{
    change: function()
    {
        if ( $(this).val().length == 0 )
        {
            var obj_label_ayuda = $("label[id='texto-ayuda']");

            obj_label_ayuda.text("El campo " + $(this).siblings("label").attr("data-texto") + " no puede estar vacio.");
            $(this).css("border-color", "red");
            $(this).focus();

        }
    },   // Fin de la funcion change
    focus: function()
    {
        $(this).css("border-color", "#ccc");
    },  //  =>  Funcion focus
    blur: function()
    {
        if ( $(this).val().length == 0 )
        {
            var obj_label_ayuda = $("label[id='texto-ayuda']");

            obj_label_ayuda.text("El campo " + $(this).siblings("label").attr("data-texto") + " no puede estar vacio.");
            $(this).css("border-color", "red");
            $(this).focus();
        }
    }  //  =>  Funcion blur
}); //Fin de la funcion on

function checarCamposRequire()
{
    var form_elements = $("form input[required], form select[required]");
    var bandera = true;

    form_elements.each( function()
    {
        var div_control = $(this).closest("div[class='form-group']");

        if ( $(this).val().length == 0 )
        {
            div_control.addClass("has-error");
            bandera = false;
        }
        else
        {
            div_control.removeClass("has-error");
        }
    });//    =>  Funcion each

    if ( bandera )
        $("#1").css("visibility", "visible");
    else
        $("#1").css("visibility", "hidden");

    return bandera;
}   //  =>  Funcion checarCamposRequire


function mostrarBotonResetear()
{
    var form_elements = $("form input, form select");
    var bandera = false;

    form_elements.each( function()
    {
        var div_control = $(this).closest("div[class='form-group']");

        if ( $(this).val().length > 0 )
            bandera = true;
    });//    =>  Funcion each

    if ( bandera )
        $("#0").css("visibility", "visible");
    else
        $("#0").css("visibility", "hidden");

    return bandera;
}   //  =>  Funcion checarCamposRequire


//  =>  Clic en <select> cliente
function selectCliente()
{
    var mi_obj = {
        campos : "idCliente, nombre",
        order : "nombre",
        table : "cliente",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='cliente']", "option" );
}

$("select[name='cliente']").one("click", selectCliente);
$("select[name='cliente']").on("change", function()
{
    $("select[name='unidad']").empty();
});//   =>  on

//  =>  Clic en <select> cliente
function selectConsultarUnidades()
{
    var mi_obj = {
        campos : "idUnidad, unidad",
        order : "unidad",
        table : "unidad",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='unidad']", "option" );
}

function selectConsultarUnidadesDadoCliente()
{
    var cliente =  $("select[name='cliente']").val();
    var mi_obj = {
        campos : "idUnidad, unidad",
        condicion : "cliente=" + cliente,
        order : "unidad",
        table : "unidad",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='unidad']", "option" );
}

$("select[name='unidad']").on("click", selectConsultarUnidadesDadoCliente);

//  =>  Clic en <select> articulo
function selectArticulo()
{
    var mi_obj = {
        campos : "idArticulo, nombre",
        table : "articulo",
        order : "nombre",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='articulo']", "option" );
}

//  =>  Clic en <select> articulo
function datalistArticulo()
{
    var mi_obj = {
        campos : "idArticulo, nombre",
        table : "articulo",
        order : "nombre",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "[id='articulos']", "option" );
}

// => Consulta los proveedores y los inserta en el select
function selectProveedor()
{
    var mi_obj = {
        campos : "idProveedor, nombre",
        table : "proveedor",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "select[name='proveedor']", "option" );
}

function peticionConsultarOpcionesParaSelect( datos, selector_texto, etiqueta_html = "" )
{
    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : datos,
        success : function(result, status, xhr)
        {
            switch ( etiqueta_html )
            {
                case "label":
                    var dom_obj = $( selector_texto );
                    var json_obj = JSON.parse( result );

                    dom_obj.empty();

                    for (var i = 0; i < json_obj.length; i++)
                        dom_obj.append( json_obj[ i ] );
                break;

                case "option":
                    var mi_select = $( selector_texto );
                    var obj = JSON.parse( result );

                    mi_select.empty();
                    mi_select.append("<option></option>");

                    for (var i = 0; i < obj.length; i++)
                        mi_select.append( obj[ i ] );
                break;
            }
        }
    }); //  =>  ajax 
}

function peticionInnerJoin( tablas, operacion, condicion, salida_html )
{
    URLArgs( "clear" );
    URLArgs( "append", "x=" + JSON.stringify( tablas ) );
    URLArgs( "append", "&salida_html=" + salida_html );
    URLArgs( "append", "&condicion=" + condicion );
    URLArgs( "append", "&operacion=" + operacion );
    var mi_url = URLArgs( "get" );

    $.ajax(
    {
        async : false,
        url : __php_dir__ + "consultas.php",
        data : mi_url,
        success : function( result, status, xhr )
        {
            _json_response_ = JSON.parse( result );
        }
    });
}

function rellenarCamposArticulo()
{
    if ( condicionParaPrecio() )
    {
        var id_articulo = $("[name='articulo']").val();
        var id_proveedor = $("[name='proveedor']").val();
        var json_obj_articulo = null;

        URLArgs("clear");
        URLArgs("append", $("[name='articulo']").attr("name") + "=" + id_articulo);
        URLArgs("append", "&" + $("[name='proveedor']").attr("name") + "=" + id_proveedor);
        URLArgs("append", "&table=precioprov");
        URLArgs("append", "&operacion=checar-combinacion-articulo-proveedor");
        var mi_url = URLArgs("get");
        URLArgs("clear");

        $.ajax(
        {
            async : false,
            url : __php_dir__ + "consultas.php",
            data : mi_url,
            success : function(result, status, xhr)
            {
                var obj = JSON.parse(result);

                for( key in obj )
                {
                    if (obj[key] === "")
                        obj[key] = "NINGUNA";

                    if ( key === "combinacion" )
                        textoAyuda( obj[key] );

                    // $("[name='" + key + "']").val(obj[key]);
                    $("[id='" + key + "']").text(obj[key]);
                }
            }
        }); //  =>  ajax

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

        peticionInnerJoin( iJoinTablas, "inner-join-consultar", "articulo.idArticulo='" + id_articulo + "'", "1fila" );
        json_obj_articulo = _json_response_;
        _json_response_ = null;

        console.log( json_obj_articulo );
        $("#nombre-de-articulo").text( "Datos del articulo: ( " + json_obj_articulo[ 0 ] + " ) " + json_obj_articulo[ 1 ] );
    }
    else
        textoAyuda("Primero se debe elegir un proveedor y un artículo", "text-danger", "Error");
}

function esNumeroDeTelefono()
{
    if ( this.value.search( /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im )  < 0 )
    {
        textoAyuda("El formato del número teléfonico no es válido", "", "Error");
        this.value = "";
    }
    else
        textoAyuda("");
}

function mostrarFormatoNumeroTelefonico()
{
    textoAyuda("Ingrese un número con el siguiente formato: (xxx) xxx-xxxx");
}

function mostrarFormatoNumeroTelefonico()
{
    textoAyuda("Ingrese un número con el siguiente formato: (xxx) xxx-xxxx");
}

function esCP()
{
    // javascript: return event.keyCode === 8 || event.keyCode === 46 || event.keyCode === 13 || event.keyCode === 9 ? true : !isNaN(Number(event.key))
    if ( this.value.search( /^[0-9]{5}$/ ) === -1 )
    {
        textoAyuda( "Formato inválido: El C.P. debe estar formado únicamente de cinco dígitos", "text-danger", "Error" );
        this.value = "";
    }
    else
        textoAyuda( "" );
}

function palabra(texto)
{
    if ( texto.search( /^[A-Z][a-z]+$/ )  < 0 ) 
        return false;

    return true;
}

function myTrim( texto )
{
  return texto.replace(/^\s+|\s+$/gm,'');
}

function soloPalabras()
{
    var texto = this.value;
    var palabras = [];

    texto = myTrim( texto );
    palabras = texto.split(" ");

    for ( var i = 0; i < palabras.length; i++ )
    {
        if ( !palabra( palabras[ i ] ) )
        {
            textoAyuda( "La palabra: \"" + palabras[ i ] + "\" no cumple con el formato de nombre válido" );
            this.value = "";

            break;
        }
    }
}

function estaEnRango()
{
    var mi_numero = ( isNaN( this.value ) ) ? -1 : Number( this.value );
    var min = Number( this.min );
    var max = Number( this.max );

    if ( isNaN( this.value ) || ( mi_numero < min ) || ( mi_numero > max ) )
    {
        textoAyuda( "El número debe estar dentro del rango ( " + this.min + " , " + this.max + " ). Por seguridad su valor será cambiado al mínimo valor permitido ( " + this.min + " )" );
        this.value = min;
    }
    else
        textoAyuda( "" );
}

function rfc()
{
    if ( this.value.search( /([A-Z]{3} [0-9]{6}) [A-Z]{3}$/ ) == -1 )
    {
        this.value = "";
        textoAyuda( "Formato de RFC inválido, use letras mayúsculas" );
    }
    else
        textoAyuda( "" );
}

function email()
{
    // msg4_98@hotmail.com
    if ( this.value.search( /^[A-Za-z0-9_]{7,21}@[a-z]{3,7}(.[a-z]{2,3})?$/ ) == -1 )
    {
        this.value = "";
        textoAyuda( "Formato de correo inválido" );
    }
    else
        textoAyuda( "" );
}

function esEstado()
{
    if ( this.value.search( /^[A-ZÁÉÍÓÚ][a-záéíóú]+( ^[A-ZÁÉÍÓÚ][a-záéíóú]+| de [A-ZÁÉÍÓÚ][a-záéíóú]+)?$/ ) == -1 )
    {
        textoAyuda( "Formato inválido: " + this.value + " no es válido", "text-danger", "Error" );
        this.value = "";
    }
    else
        textoAyuda( "" );
}

function esNombreDeEmpresa()
{
    if ( this.value.search( /^[A-Z][a-z]+( [A-Z][a-z]+| [A-Z]+| ([A-Z]\.)+| de)+$/ ) == -1 )
    {
        this.value = "";
        textoAyuda( "Formato inválido: " );
    }
}

function esDireccion()
{
    this.value = this.value.replace(/ +/g, " ");

    if ( this.value.search( /^(Calle|calle){1} [A-Za-z0-9 \.]+( #[0-9]+| num\. [0-9]+| numero [0-9]+){1},( colonia| col\.) [A-Za-z0-9 ]+$/ ) == -1 )
    {
        this.value = "";
        textoAyuda( "Formato inválido: " );
    }
}

function esInformacion()
{
    this.value = this.value.replace(/( +|'|")/g, " ");

    if ( this.value.search( /^[A-Za-z0-9 ,\.]+$/ ) == -1 )
    {
        this.value = "";
        textoAyuda( "Formato inválido: " );
    }
}

function esPlazoOCredito()
{
    if ( this.value.search( /^[0-9]{2}$/ ) === -1 )
    {
        textoAyuda( "Formato inválido: Este campo debe estar formado únicamente por dos dígitos", "text-danger", "Error" );
        this.value = "";
    }
    else
        textoAyuda( "" );
}

function esClave()
{
    this.value = this.value.replace(/ /g, '');

    if ( this.value.search( /^[0-9]{1,3}$/ ) === -1 )
    {
        textoAyuda( "Formato inválido: Este campo debe estar formado por uno, dos o tres dígitos", "text-danger", "Error" );
        this.value = "";
    }
    else
        textoAyuda( "" );
}

function esPrecio()
{
    if ( this.value.search( /^[0-9]{1,5}(\.[0-9]{1,2})?$/ ) === -1 )
    {
        textoAyuda( "Formato de precio inválido: Este campo debe estar formado por a lo más cinco dígitos" +
        " y opcionalmente un punto seguido de uno o dos dígitos", "text-danger", "Error" );
        this.value = "";
    }
    else
        textoAyuda( "" );
}

function condicionParaPrecio()
{
    if ( $("[name='proveedor']").val() === "")
    {
        alert ("Seleccione un proveedor");

        return false;
    }

    if ( $("[name='articulo']").val() === "" )
    {
        alert ("Seleccione un articulo");

        return false;
    }

    if ( this.value === "" )
        return false;

    return true;
}