<?php
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

	require "../db/config.db.php";

	// Global scope
	$_servername_ = HOST;
	$_username_ = USER;
	$_pass_ = PASS;
	$_dbname_ = DB_NAME;
	$_table_ = "";
	$_table_type_ = "";
	$_operation_ = "";
	$_connection_ = null;
	$_sql_query_ = "";
	$_response_ = "";
	$_query_result_ = NULL;
	$_num_cols_ = 0;
	$_num_rows_ = 0;
	$_column_names_ = array();
	$_column_alias_ = array();
	$_column_types_ = array();
	$_proveedor_alias_ = array("idProveedor" => "Clave", "nombre" => "Nombre del proveedor", "pago" => "Pago", "tipo" => "Tipo", "direccion" => "Dirección", "telefono" => "Teléfono", "rfc" => "RFC", "correo" => "Correo", "contacto" => "Contacto", "ciudad" => "Ciudad", "estado" => "Estado", "info" => "Información", "cp" => "C.P.");
	$_precioprov_alias_ = array("id" => "Clave", "proveedor" => "Nombre del proveedor", "articulo" => "Nombre del artículo", "precio" => "Precio", "unidadA" => "Presentación", "factor" => "Unidades");
	$_cliente_alias_ = array("idCliente"=>"Clave","nombre"=>"Nombre del cliente","direccion"=>"Dirección","telefono"=>"Teléfono","rfc"=>"R.F.C.","plazo"=>"Plazo","credito"=>"Crédito","correo"=>"Correo electrónico","contacto"=>"Contacto","ciudad"=>"Ciudad","estado"=>"Estado","info"=>"Información","cp"=>"C.P.");
	$_unidad_alias_ = array("idUnidad"=>"Clave","unidad"=>"Nombre de la unidad","cliente"=>"Nombre del cliente","info"=>"Información");
	$_subunidad_alias_ = array("idSUnidad"=>"Clave","subUnidad"=>"Nombre de la subunidad","cliente"=>"Nombre del cliente","unidad"=>"Nombre de la unidad", "info"=>"Información");
	$_linea_alias_ = array("idLinea"=>"Clave","descripcion"=>"Descripción");
	$_grupo_alias_ = array("idGrupo"=>"Clave","descripcion"=>"Descripción");
	$_base_alias_ = array("idBase"=>"Clave","descripcion"=>"Descripción");

	require 'funciones.php';

	if ( $_SERVER['REQUEST_METHOD'] == "GET" )
	{
		if ( isset( $_GET['table'] ) )
		{
			tabla_metadatos();
			alias_para_tabla();
		}

		$_operation_ = isset( $_GET['operacion'] ) ? $_GET['operacion'] : "null";
		$dump_array = array( "operacion" => "El valor de aqui no importa" );
		$_GET = array_diff_key ( $_GET, $dump_array );

		switch ($_operation_)
		{
			case "calcular_paginas":
				paginas_por_tabla();
			break;

			case "comprobar-cliente-unidad-subunidad":
				comprobar_cliente_unidad_subunidad();
			break;

			case "checar-combinacion-articulo-proveedor":
				checar_combinacion_articulo_proveedor();
			break;

			case "consultar":
				$_table_type_ = "consultar";
				consultar();
			break;

			case "consultar-articulos":
				consultar_articulos();
			break;

			case "consultar-eliminar":
				$_table_type_ = "eliminar";
				consultar();
			break;

			case "consultar-modificar":
				$_table_type_ = "modificar";
				consultar();
			break;

			case "consultar-n-campos":
				consultar_n_campos();
			break;

			// case "consultar-precios":
			// 	consultar_precios();
			// break;

			case "consultar-proveedores":
				consultar_proveedores();
			break;

			case "consultar-unidades-dado-cliente":
				consultar_unidades_dado_cliente();
			break;

			case "delete":
				eliminar();
			break;

			case "delete-precio":
				eliminar_precio();
			break;

			case "inner-join-consultar":
				$_table_type_ = "consultar";
				inner_join();
			break;

			case "inner-join-eliminar":
				$_table_type_ = "eliminar";
				inner_join();
			break;

			case "inner-join-modificar":
				$_table_type_ = "modificar";
				inner_join();
			break;

			case "obtener-criterios-orden":
				consulta_criterios_orden();
			break;

			case "ocm-agregar-articulo":
				ocm_agregar_articulo();
			break;

			case "ocm-obtener-clave":
				ocm_obtener_clave();
			break;

			case "registrar":
				registrar();
			break;

			case "registrar-precio":
				registrar_precio();
			break;

			case "update":
				actualizar();
			break;

			case "getOrdenes":
				getOrdenes();
			break;

			case "removeOC":
				removeOC();
			break;

			case "authOC":
				authOC();
			break;

			case "reOpenOC":
				reOpenOC();
			break;

			default:
				$_response_ = "Operación inexistente o no ingresada";
		}
	}
?>