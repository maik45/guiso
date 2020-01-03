function liberarJSONResponse()
{
	_json_response_ = null;
}

function rellenarSelectArticulo()
{
	var dom_obj = $("select[name='articulo']").empty();

	dom_obj.append( "<option>Elija una opción</option>" );

    for (var i = 0; i < _json_response_.length; i++)
        dom_obj.append( _json_response_[ i ] );

    liberarJSONResponse();
}

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

function consultaCondicionalUnidad( campo, valor )
{
    var mi_obj = {
        campos : "idUnidad",
        table : "unidad",
        condicion : campo + " = " + valor,
        salida_html : "dato",
        operacion : "consultar-n-campos"
    };

    var mi_url = jQuery.param( mi_obj );

    peticionConsultarOpcionesParaSelect( mi_url, "#contenedor_unidades", "label" );
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

$("select[name='cliente']").one("click", selectCliente);
// $("select[name='articulo']").one("click", selectArticulo);
$("select[name='proveedor']").one("click", selectProveedor);