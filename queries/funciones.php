<?php
	function abrir_conexion()
	{
			global $_response_, $_servername_, $_username_, $_pass_, $_dbname_,  $_connection_;

			$_connection_ = mysqli_connect($_servername_, $_username_, $_pass_, $_dbname_);

			if (!$_connection_)
				die("Conexion fallido: " . mysqli_connect_error());
			else
				mysqli_set_charset( $_connection_, "utf8" );
	}

	function actualizar()
	{
		global $_sql_query_, $_column_names_, $_table_, $_query_result_;

		$_sql_query_ ="";
		$ban = true;

		//	=>	Actualizacion general
		switch ( $_table_ )
		{
			case "base":
				$_sql_query_ = "UPDATE base ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['descripcion'] ) )
					$_sql_query_ .= "descripcion = '" . $_GET['descripcion'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idBase = " . $_GET['idBase'];

				if ( ejecutar_consulta() )
					echo "Base modificada";
			break;

			case "precioprov":
				// print_r ( $_GET );
				$idPrecioProv = $_GET['id'];
				$idProveedor = "";
				$idArticulo = "";
				$precio = isset( $_GET['precio'] ) ? filter_var( $_GET['precio'], FILTER_VALIDATE_FLOAT ) : false;

				if ( $precio !== false )
				{
					$fecha = date_create ();
					$fecha = date_format ( $fecha, "Y-m-d 00:00:00" );

					$_sql_query_ = "";
					$_sql_query_ = "SELECT proveedor, articulo FROM precioprov WHERE id = " . $idPrecioProv;

					if ( ejecutar_consulta() )
					{
						$row = mysqli_fetch_assoc ( $_query_result_ );

						if ( isset ( $row['proveedor'] ) and isset ( $row['articulo'] ) )
						{
							$idProveedor = $row['proveedor'];
							$idArticulo = $row['articulo'];
						}
					}

					$_sql_query_ = "UPDATE precioprov SET precio = " . $precio . ", fecha = '" . $fecha . "' WHERE id = " . $idPrecioProv;

					if ( ejecutar_consulta() )
					{
						echo "Precio actualizado\n";

						$_sql_query_ = "INSERT INTO precioprovbit (proveedor, articulo, precio, fecha) VALUES ($idProveedor, '$idArticulo', $precio, '$fecha')";

						if ( ejecutar_consulta() )
						{
							echo "Registro grabado en la bitacora\n";

							$_sql_query_ = "SELECT MIN(precio) AS min_precio FROM precioprov WHERE articulo = '" . $idArticulo . "' AND activo = 1";

							if ( ejecutar_consulta() )
							{
								$row = mysqli_fetch_assoc ( $_query_result_ );

								if ( isset ( $row['min_precio'] ) )
								{
									$min_precio = (float) $row['min_precio'];

									if ( $precio > $min_precio )
										$precio = $min_precio;
								}
							}

							$_sql_query_ = "UPDATE articulo SET costo = " . $precio . " WHERE idArticulo = '" . $idArticulo . "'";

							if ( ejecutar_consulta() )
								echo "El precio en articulos fue actualizado a $precio\n";
						}
					}
				}
				else
					echo "El precio ingresado no es válido";

				liberar_recursos();
			break;

			case "cliente":
				$_sql_query_ = "UPDATE cliente ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['nombre'] ) )
					$_sql_query_ .= "nombre = '" . $_GET['nombre'] . "', ";

				if ( isset ( $_GET['direccion'] ) )
					$_sql_query_ .= "direccion = '" . $_GET['direccion'] . "', ";

				if ( isset ( $_GET['telefono'] ) )
					$_sql_query_ .= "telefono = '" . $_GET['telefono'] . "', ";

				if ( isset ( $_GET['rfc'] ) )
					$_sql_query_ .= "rfc = '" . $_GET['rfc'] . "', ";

				if ( isset ( $_GET['plazo'] ) )
					$_sql_query_ .= "plazo = " . $_GET['plazo'] . ", ";

				if ( isset ( $_GET['credito'] ) )
					$_sql_query_ .= "credito = " . $_GET['credito'] . ", ";

				if ( isset ( $_GET['correo'] ) )
					$_sql_query_ .= "correo = '" . $_GET['correo'] . "', ";

				if ( isset ( $_GET['contacto'] ) )
					$_sql_query_ .= "contacto = '" . $_GET['contacto'] . "', ";

				if ( isset ( $_GET['ciudad'] ) )
					$_sql_query_ .= "ciudad = '" . $_GET['ciudad'] . "', ";

				if ( isset ( $_GET['estado'] ) )
					$_sql_query_ .= "estado = '" . $_GET['estado'] . "', ";

				if ( isset ( $_GET['info'] ) )
					$_sql_query_ .= "info = '" . $_GET['info'] . "', ";

				if ( isset ( $_GET['cp'] ) )
					$_sql_query_ .= "cp = '" . $_GET['cp'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idCliente = " . $_GET['idCliente'];

				if ( ejecutar_consulta() )
					echo "Cliente modificado";
			break;

			case "grupo":
				$_sql_query_ = "UPDATE grupo ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['descripcion'] ) )
					$_sql_query_ .= "descripcion = '" . $_GET['descripcion'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idGrupo = " . $_GET['idGrupo'];

				if ( ejecutar_consulta() )
					echo "Grupo modificado";
			break;

			case "linea":
				$_sql_query_ = "UPDATE linea ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['descripcion'] ) )
					$_sql_query_ .= "descripcion = '" . $_GET['descripcion'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idLinea = " . $_GET['idLinea'];

				if ( ejecutar_consulta() )
					echo "Linea modificada";
			break;

			case "proveedor":
				$vec_tipo = array("a" => "Mayoreo", "b" => "Menudeo");
				$vec_pago = array("a" => "Contado con cheque", "b" => "Crédito", "c" => "Efectivo", "d" => "Operación", "e" => "Unidades");
				$_sql_query_ = "UPDATE proveedor ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['nombre'] ) )
					$_sql_query_ .= "nombre = '" . $_GET['nombre'] . "', ";

				if ( isset ( $_GET['pago'] ) )
				{
					if ( array_search ( $_GET['pago'], $vec_pago ) )
						$_sql_query_ .= "pago = '" . $_GET['pago'] . "', ";
					else
					{
						echo "Ha ingresado un tipo de pago invalido, sera cambiado a un tipo valido";
						$_sql_query_ .= "pago = '" . $vec_pago['a'] . "', ";
					}
				}

				if ( isset ( $_GET['tipo'] ) )
				{
					if ( array_search ( $_GET['tipo'], $vec_tipo ) )
						$_sql_query_ .= "tipo = '" . $_GET['tipo'] . "', ";
					else
					{
						echo "Ha ingresado un tipo de proveedor no valido, sera cambiado a un tipo valido";
						$_sql_query_ .= "tipo = '" . $vec_tipo['a'] . "', ";
					}
				}

				if ( isset ( $_GET['direccion'] ) )
					$_sql_query_ .= "direccion = '" . $_GET['direccion'] . "', ";

				if ( isset ( $_GET['telefono'] ) )
					$_sql_query_ .= "telefono = '" . $_GET['telefono'] . "', ";

				if ( isset ( $_GET['rfc'] ) )
					$_sql_query_ .= "rfc = '" . $_GET['rfc'] . "', ";

				if ( isset ( $_GET['correo'] ) )
					$_sql_query_ .= "correo = '" . $_GET['correo'] . "', ";

				if ( isset ( $_GET['contacto'] ) )
					$_sql_query_ .= "contacto = '" . $_GET['contacto'] . "', ";

				if ( isset ( $_GET['ciudad'] ) )
					$_sql_query_ .= "ciudad = '" . $_GET['ciudad'] . "', ";

				if ( isset ( $_GET['estado'] ) )
					$_sql_query_ .= "estado = '" . $_GET['estado'] . "', ";

				if ( isset ( $_GET['info'] ) )
					$_sql_query_ .= "info = '" . $_GET['info'] . "', ";

				if ( isset ( $_GET['cp'] ) )
					$_sql_query_ .= "cp = '" . $_GET['cp'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idProveedor = " . $_GET['idProveedor'];

				if ( ejecutar_consulta() )
					echo "Proveedor modificado";
			break;

			case "unidad":
				$_sql_query_ = "UPDATE unidad ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['info'] ) )
					$_sql_query_ .= "info = '" . $_GET['info'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idUnidad = '" . $_GET['idUnidad'] . "'";

				if ( ejecutar_consulta() )
					echo "Unidad modificada";
			break;

			case "subunidad":
				$_sql_query_ = "UPDATE subunidad ";
				$_sql_query_ .= "SET ";

				if ( isset ( $_GET['info'] ) )
					$_sql_query_ .= "info = '" . $_GET['info'] . "', ";

				$_sql_query_ = chop ( $_sql_query_, ", " );
				$_sql_query_ .= " WHERE idSUnidad = '" . $_GET['idSUnidad'] . "'";

				if ( ejecutar_consulta() )
					echo "Subunidad modificada";
			break;

			default:
				$flip = array_flip($_column_names_);
				$intersected_array = array_intersect_key($_GET, $flip);

				array_walk($intersected_array, "test");
				$_sql_query_ = "UPDATE " . $_table_ . " SET ";

				foreach ($intersected_array as $key => $value)
					if ($key != $_column_names_[0])
						$_sql_query_ .= "$key = $value, ";

				rm_ult_n_chs(2);
				 $_sql_query_ .= " WHERE " . $_column_names_[0] . " = " . $_GET[$_column_names_[0]];

				 // if ( ejecutar_consulta() )
				 // {
					// liberar_recursos();
				 // }

				echo $_sql_query_;
		}
	}

	function alias_para_tabla()
	{
		global $_table_, $_column_alias_, $_proveedor_alias_, $_precioprov_alias_, $_cliente_alias_, $_unidad_alias_, $_subunidad_alias_, $_linea_alias_, $_grupo_alias_, $_base_alias_, $_ocm_alias_;

		switch ($_table_)
		{
			case "proveedor":
				$_column_alias_ = $_proveedor_alias_;
			break;

			case "precioprov":
				$_column_alias_ = $_precioprov_alias_;
			break;

			case "cliente":
				$_column_alias_ = $_cliente_alias_;
			break;

			case "unidad":
				$_column_alias_ = $_unidad_alias_;
			break;

			case "subunidad":
				$_column_alias_ = $_subunidad_alias_;
			break;

			case "linea":
				$_column_alias_ = $_linea_alias_;
			break;

			case "grupo":
				$_column_alias_ = $_grupo_alias_;
			break;

			case "base":
				$_column_alias_ = $_base_alias_;
			break;

			case "ocm":
				$_column_alias_ = $_ocm_alias_;
			break;
		}
	}

	function cerrar_conexion()
	{
		global $_connection_;

		if ( !$_connection_ )
		{
			mysqli_close( $_connection_ );
			$_connection_ = null;
		}
	}

	function comprobar_cliente_unidad_subunidad()
	{
		global $_sql_query_, $_num_rows_;

		//	=>	Remover los valores vacios
		$dump_array = array( "somekey" => "" );
		$_GET = array_diff ( $_GET, $dump_array );

		$_sql_query_ = "";

		$_sql_query_ .= "SELECT idSunidad, cliente, unidad ";
		$_sql_query_ .= "FROM subunidad ";
		$_sql_query_ .= "WHERE ";
		$_sql_query_ .= "idSunidad = " . $_GET['idSUnidad'];
		$_sql_query_ .= " AND ";
		$_sql_query_ .= "cliente = " . $_GET['cliente'];
		$_sql_query_ .= " AND ";
		$_sql_query_ .= "unidad = " . $_GET['unidad'];

		// echo $_sql_query_;

		if ( ejecutar_consulta() )
		{
			if ( $_num_rows_ )
				echo "La combinación cliente, unidad, subunidad ya existe o existio en el sistema";
			else
				registrar();
		}
	}

	function construir_tabla_simple()
	{
		global $_query_result_, $_response_, $_column_alias_, $_table_type_;

		$finfo = mysqli_fetch_fields ( $_query_result_ );
		$primary_key_name = "";

		foreach ( $finfo as $val )
		{
			if ( $val->flags & 2 )
				$primary_key_name = $val->orgname;
		}

		$_response_ = "";
		$_response_ .= "<div class=\"table-responsive\">";

		switch ( $_table_type_ )
		{
			case "consultar":
				$_response_ .= "<table class=\"table table-striped table-bordered table-hover\">";
			break;

			case "eliminar":
				$_response_ .= "<table class=\"table table-bordered eliminar\">";
			break;

			case "modificar":
				$_response_ .= "<table class=\"table table-striped table-bordered table-hover editable\">";
			break;
		}

		$_response_ .= "<thead>";
		$_response_ .= "<tr>";

		foreach ( $_column_alias_ as $key => $value )
		{
			if ( ( $key != "activo" ) and ( $key != "fecha" ) )
			{
				$_response_ .= "<th>";
				$_response_ .= $value;
				$_response_ .= "</th>";
			}
		}

		$_response_ .= "</tr>";
		$_response_ .= "</thead>";
		$_response_ .= "<tbody>";

		while ( $row = mysqli_fetch_assoc( $_query_result_ ) )
		{
			$_response_ .= "<tr>";

			foreach ($row as $key => $value)
			{
				$_response_ .= "<td nowrap=\"true\">";

				switch ( $_table_type_ )
				{
					case "eliminar":
						if ( ( $key == $primary_key_name ) or ( strstr( $key, "id" ) ) )
							$_response_ .= "<div data-key=\"$key\">";
						else
							$_response_ .= "<div>";
					break;

					case "modificar":
						$_response_ .= "<div class=\"td_data\" edit_type=\"click\" contenteditable=\"false\" data-editado=\"false\" data-key=\"$key\" data-respaldo=\"\">";
					break;

					default:
						$_response_ .= "<div>";
				}

				$_response_ .= $value;
				$_response_ .= "</div>";
				$_response_ .= "</td>";
			}

			$_response_ .= "</tr>";
		}

		$_response_ .= "</tbody>";
	}

	function consulta_criterios_orden()
	{
		global $_column_alias_;

		echo json_encode( array_slice( $_column_alias_, 0, 2, true ) );
	}

	function checar_combinacion_articulo_proveedor()
	{
		global $_sql_query_, $_query_result_, $_response_;

		$_sql_query_ = "SELECT unidad, unidadA, factor, info FROM articulo WHERE idArticulo = '" . $_GET['articulo'] . "'";

		if ( ejecutar_consulta() )
		{
			$row1 = mysqli_fetch_assoc( $_query_result_ );
			$precio = 0;

			//	=>	Seleccionamos el precio para la pareja (proveedor, articulo)
			$_sql_query_ = "SELECT precio FROM precioprov WHERE proveedor = " . $_GET['proveedor'] . " AND articulo = '" . $_GET['articulo'] . "' AND activo = 1";

			if ( ejecutar_consulta() )
			{
				//	=>	Consulta exitosa
				$row2 = mysqli_fetch_assoc( $_query_result_ );
				$combinacion = "La combinacion no existe, ahora puede ingresarla";

				//	=>	Pregunta: Exite precio
				if ( isset ( $row2['precio'] ) )
				{
					$combinacion = "La combinación existe, ahora puede actualizarla";

					if ( ( $row1['unidadA'] == "" ) or ( (float) $row1['factor'] == 0 ) )
						$precio = (float) $row2['precio'];
					else
						$precio = ( (float) $row2['precio'] ) * ( (float) $row1['factor'] );
				}
			}

			$vec = array("unidad" => $row1['unidad'], "unidadA" => $row1['unidadA'], "factor" => $row1['factor'], "info" => $row1['info'], "combinacion" => $combinacion, "costo" => $precio);
			echo json_encode( $vec );
		}
	}

	function consultar()
	{
		global $_response_, $_column_names_, $_sql_query_, $_table_, $_query_result_;

		$filas = (int) $_GET['filas'];
		$criterio = $_GET['criterio'];
		$desface = (int) $_GET['desface'];
		$sql_like_statement = "";
		$sql_query_count = "";
		$sql_query_backup = "";
		$array_response = null;
		$contador = 0;
		// $condicion = " WHERE activo <> 0";

		if ( isset($_GET['comodin']) && ( $_GET['comodin'] != "" ) )
		{
			$_GET['comodin'] = filter_var( $_GET['comodin'], FILTER_SANITIZE_STRING, FILTER_SANITIZE_MAGIC_QUOTES );
			$sql_like_statement .= " WHERE ";
			$sql_like_statement .= $_column_names_[ 0 ];
			$sql_like_statement .= " LIKE  '%";
			$sql_like_statement .= $_GET['comodin'];
			$sql_like_statement .= "%'";
			$sql_like_statement .= " OR ";
			$sql_like_statement .= $_column_names_[ 1 ];
			$sql_like_statement .= " LIKE '%";
			$sql_like_statement .= $_GET['comodin'];
			$sql_like_statement .= "%'";
		}

		$_sql_query_ = "";
		$_sql_query_ = "SELECT ";

		for ($i = 0; $i < count($_column_names_); $i++)
		{
			if ( ( $_column_names_[ $i ] != "activo" ) and ( $_column_names_[ $i ] != "fecha" ) )
				$_sql_query_ .= $_column_names_[$i] . ", ";
		}

		rm_ult_n_chs(2);
		$_sql_query_ .= " FROM $_table_";
		$_sql_query_ .= $sql_like_statement;
		$_sql_query_ .= " ORDER BY $criterio";
		$_sql_query_ .= " LIMIT " . $filas * ($desface - 1) . ", $filas";


		switch ( $_table_ )
		{
			case "unidad":
				$sql_query_count = "SELECT COUNT( * ) AS contador FROM ( $_table_ INNER JOIN cliente ON cliente.idCliente = unidad.cliente )";
			break;

			default:
				$sql_query_count .= "SELECT COUNT( * ) AS contador ";
				$sql_query_count .= substr( $_sql_query_, strpos( $_sql_query_, "FROM" ) );
				$sql_query_count = substr( $sql_query_count, 0, strpos( $sql_query_count, "ORDER" ) );
		}

		$sql_query_backup = $_sql_query_;
		$_sql_query_ = $sql_query_count;

		if ( ejecutar_consulta() )
		{
			$row = mysqli_fetch_assoc( $_query_result_ );
			$contador = isset( $row['contador'] ) ? (int) $row['contador'] : 0;
			$contador = ( $row['contador'] % $filas == 0 ) ? ( $row['contador'] / $filas ) : ( (int) ( $row['contador'] / $filas ) ) + 1;
		}

		$_sql_query_ = $sql_query_backup;
		$sql_query_backup = "";


		if ( ejecutar_consulta() )
		{
			construir_tabla_simple();

			$array_response = array("contador_paginas" => $contador, "respuesta" => $_response_);
			echo json_encode( $array_response );
		}

		liberar_recursos();
	}

	function consultar_articulos()
	{
		global $_sql_query_, $_query_result_, $_response_;
		$_response_ = "";
		$arr = array();

		$_sql_query_ = "SELECT idArticulo, nombre FROM articulo ORDER BY nombre";

		if ( ejecutar_consulta() )
		{
			while ( $row = mysqli_fetch_row( $_query_result_ ) )
			{
				$_response_ = $row[0] . ": " . $row[1];
				array_push( $arr, $_response_ );
			}
		}
		else
			$_response_ = "Error en la consulta: " . $_sql_query_;

		echo json_encode( $arr );
		liberar_recursos();
	}

	function consultar_n_campos()
	{
		global $_sql_query_, $_query_result_, $_response_, $_table_;

		$_response_ = "";
		$arr = array();
		$salida_html = "option";

		$_sql_query_ = "SELECT ";
		$_sql_query_ .= $_GET['campos'];
		$_sql_query_ .= " FROM ";
		$_sql_query_ .= $_table_;

		if ( isset ( $_GET['condicion'] ) )
		{
			$_sql_query_ .= " WHERE ";
			$_sql_query_ .= $_GET['condicion'];
		}

		if ( isset ( $_GET['order'] ) )
		{
			$_sql_query_ .= " ORDER BY ";
			$_sql_query_ .= $_GET['order'];
		}

		if ( isset ( $_GET['salida_html'] ) )
			$salida_html = $_GET['salida_html'];

		if ( ejecutar_consulta() )
		{
			switch ( $salida_html )
			{
				case "dato":
					while ( $row = mysqli_fetch_assoc( $_query_result_ ) )
					{
						foreach ( $row as $key => $value )
						{
							$_response_ = $value;

							array_push( $arr, $_response_ );
						}
					}
				break;

				case "label":
					while ( $row = mysqli_fetch_row( $_query_result_ ) )
					{
						$_response_ = "";
						$_response_ .= "<label data-key=\"" . $row[0] . "\">";
						$_response_ .= "( " . $row[0] . " ) " . $row[1];
						$_response_ .= "</label>";
						array_push( $arr, $_response_ );
					}
				break;

				case "vec2":
					$arr = mysqli_fetch_all( $_query_result_, MYSQLI_NUM );
				break;

				case "option":
					while ( $row = mysqli_fetch_row( $_query_result_ ) )
					{
						$_response_ = $row[0];
						$_response_ .= ":";
						$_response_ .= "<option value=\"" . $row[0] . "\">";
						$_response_ .= "( " . $row[0] . " ) " . $row[1];
						$_response_ .= "</option>";
						array_push( $arr, $_response_ );
					}
				break;
			}
		}

		echo json_encode( $arr );
		liberar_recursos();
	}

	function consultar_proveedores()
	{
		global $_sql_query_, $_query_result_, $_response_;
		$_response_ = "";

		$_sql_query_ = "SELECT idProveedor, nombre FROM proveedor ORDER BY nombre;";

		if ( ejecutar_consulta() )
		{
			while ( $row = mysqli_fetch_row( $_query_result_ ) )
				$_response_ .= "<option value=\"" . $row[0] . "\">" . $row[0] . ": " . $row[1] . "</option>";
		}
		else
			$_response_ = "Error en la consulta: " . $_sql_query_;

		echo $_response_;
		liberar_recursos();
	}

	function consultar_unidades_dado_cliente()
	{
		global $_sql_query_, $_table_, $_num_rows_, $_response_, $_query_result_;

		$_sql_query_ = "";
		$arr = array();

		$_sql_query_ .= "SELECT ";
		$_sql_query_ .= $_GET['campo1'];
		$_sql_query_ .= ", ";
		$_sql_query_ .= $_GET['campo2'];
		$_sql_query_ .= " FROM ";
		$_sql_query_ .= $_table_;
		$_sql_query_ .= " WHERE ";
		$_sql_query_ .= $_GET['condicion'];

		// echo $_sql_query_;

		if ( ejecutar_consulta() )
		{

			//	=>	Repeticion en 'consultar_n_campos'
			while ( $row = mysqli_fetch_row( $_query_result_ ) )
			{
				$_response_ = $row[0];
				$_response_ .= ":";
				$_response_ .= "<option value=\"" . $row[0] . "\">";
				$_response_ .= "( " . $row[0] . " ) " . $row[1];
				$_response_ .= "</option>";
				array_push( $arr, $_response_ );
			}
		}

		echo json_encode( $arr );
		liberar_recursos();
	}

	// No hay conexiones abiertas
	// La consulta ya esta construida
	function ejecutar_consulta()
	{
		global $_connection_, $_sql_query_, $_query_result_, $_num_rows_, $_num_cols_;
		$bandera = false;


		if ( $_sql_query_ !== "" )
		{
			abrir_conexion();

			$_query_result_ = mysqli_query($_connection_, $_sql_query_);

			cerrar_conexion();

			if ( $_query_result_ )
			{
				if ( !is_bool( $_query_result_ ) )
					$_num_rows_ = mysqli_num_rows( $_query_result_ );

				$sql_query_log = fopen("query-log.txt", "a") or die("Unable to open file!");
				fwrite($sql_query_log, "->$_sql_query_<-\n");
				fclose($sql_query_log);

				$_num_cols_ = mysqli_field_count( $_connection_ );
				$_sql_query_ = "";
				$bandera = true;
			}
			else
				echo "Error en la consulta: ->$_sql_query_<-";
		}

		return $bandera;
	}

	function eliminar()
	{
		global $_sql_query_, $_response_, $_table_, $_column_names_, $_query_result_;

		$ban = true;

		switch ( $_table_ )
		{

			case "base":
				// $_sql_query_ = "UPDATE base SET activo = 0 WHERE idBase = '" . $_GET['idBase'] . "'";
				$_sql_query_ = "DELETE FROM base WHERE idBase = '" . $_GET['idBase'] . "'";
				echo $_sql_query_;

				if ( ejecutar_consulta() )
					echo "Base eliminada";

				// $ban = false;
				return;
			break;

			case "bomocm":
				$_sql_query_ = "DELETE FROM bomocm ";
				$_sql_query_ .= "WHERE OC = '" . $_GET['OC'] . "' ";
				$_sql_query_ .= "AND proveedor = " . $_GET['proveedor'] . " ";
				$_sql_query_ .= "AND articulo = '" . $_GET['articulo'] . "'";
				echo $_sql_query_;

				if ( ejecutar_consulta() )
					echo "El artículo fue eliminado";

				// $ban = false;
				return;
			break;

			case "cliente":
				$_sql_query_ = "DELETE FROM subunidad WHERE cliente = " . $_GET['idCliente'];
				ejecutar_consulta();
				$_sql_query_ = "DELETE FROM unidad WHERE cliente = " . $_GET['idCliente'];
				ejecutar_consulta();
				$_sql_query_ = "DELETE FROM cliente WHERE idCliente = " . $_GET['idCliente'];
				// $_sql_query_ = "UPDATE cliente SET activo = 0 WHERE idCliente = " . $_GET['idCliente'];

				if ( ejecutar_consulta() )
					echo "El cliente junto con sus unidades y subunidades han sido eliminados";

				// $ban = false;
				return;
			break;

			case "grupo":
				$_sql_query_ = "DELETE FROM grupo WHERE idGrupo = '" . $_GET['idGrupo'] . "'";
				// $_sql_query_ = "UPDATE grupo SET activo = 0 WHERE idGrupo = '" . $_GET['idGrupo'] . "'";
				echo $_sql_query_;

				if ( ejecutar_consulta() )
					echo "Grupo ha sido eliminado";

				// $ban = false;
				return;
			break;

			case "linea":
				$_sql_query_ = "DELETE FROM linea WHERE idLinea = '" . $_GET['idLinea'] . "'";
				// $_sql_query_ = "UPDATE linea SET activo = 0 WHERE idLinea = '" . $_GET['idLinea'] . "'";
				echo $_sql_query_;

				if ( ejecutar_consulta() )
					echo "La linea ha sido eliminada";

				// $ban = false;
				return;
			break;

			case "proveedor":
				//	=>	Eliminar todos los precios ofertados por este proveedor
				$query_result_2 = null;
				$_sql_query_ = "SELECT articulo FROM precioprov WHERE proveedor = " . $_GET['idProveedor'];

				if ( ejecutar_consulta() )
				{
					$query_result_2 = $_query_result_;
					while ( $row = mysqli_fetch_assoc ( $query_result_2 ) )
					{
						$min_precio = 0;
						$_sql_query_ = "DELETE FROM precioprov WHERE proveedor = " . $_GET['idProveedor'] . " AND articulo = '" . $row['articulo'] . "'";

						ejecutar_consulta();

						//	=>	Verdadero devuelto si registro eliminado

						// =>	Buscar min_precio
						$_sql_query_ = "SELECT MIN(precio) AS min_precio FROM precioprov WHERE articulo = '" . $row['articulo'] . "' AND activo = 1";

						if ( ejecutar_consulta() )
						{
							// =>	Consulta exitosa
							$inner_row = mysqli_fetch_assoc ( $_query_result_ );

							// =>	Pregunta: Existen precio
							if ( isset ( $inner_row['min_precio'] ) )
								$min_precio = (float) $inner_row['min_precio'];
						}

						//	=>	Actualizar precio en 'articulo'
						$_sql_query_ = "UPDATE articulo SET costo = " . $min_precio . " WHERE idArticulo = '" . $row['articulo'] . "'";

						if ( !ejecutar_consulta() )
							echo "Hubo un problema con el articulo: " . $row['articulo'];
					}
				}
				//	=>	Por cada articulo eliminado, encontrar en precioprov el menor costo para ese articulo
				$_sql_query_ = "DELETE FROM proveedor WHERE idProveedor = " . $_GET['idProveedor'];
				// $_sql_query_ = "UPDATE proveedor SET activo = 0 WHERE idProveedor = " . $_GET['idProveedor'];

				if ( ejecutar_consulta() )
					echo "El proveedor ha sido eliminado junto con todos sus precios";

				// $ban = false;
				return;
			break;

			case "subunidad":
				$_sql_query_ = "DELETE FROM subunidad WHERE idSUnidad = '" . $_GET['idSUnidad'] . "'";
				// $_sql_query_ = "UPDATE subunidad SET activo = 0 WHERE idSUnidad = '" . $_GET['idSUnidad'] . "'";

				if ( ejecutar_consulta() )
					echo "La subunidad ha sido eliminada";

				// $ban = false;
				return;
			break;

			case "unidad":
				$_sql_query_ = "DELETE FROM subunidad WHERE unidad = '" . $_GET['idUnidad'] . "'";
				ejecutar_consulta();
				$_sql_query_ = "DELETE FROM unidad WHERE idUnidad = '" . $_GET['idUnidad'] . "'";
				// $_sql_query_ = "UPDATE unidad SET activo = 0 WHERE idUnidad = '" . $_GET['idUnidad'] . "'";

				if ( ejecutar_consulta() )
					echo "La unidad junto con sus subunidades han sido eliminadas";

				// $ban = false;
				return;
			break;
		}

		if ( !$ban )
			return;

		$flip = array_flip($_GET);
		$intersect = array_intersect($_column_names_, $flip);
		$_sql_query_ = "DELETE FROM $_table_ WHERE " . $intersect[0] . " = " . $_GET[$intersect[0]];

		if ( ejecutar_consulta() )
			$_response_ = "Registro eliminado";

		liberar_recursos();
	}

	function eliminar_precio()
	{
		global $_sql_query_, $_response_, $_table_, $_column_names_, $_query_result_;

		$_sql_query_ = "";
		$row = null;
		$idArticulo = "";
		$min_precio = 0;
		$precio = $_GET['precio'];

		$_sql_query_ = "SELECT articulo FROM precioprov WHERE id = " . $_GET['id'];

		if ( ejecutar_consulta() )
		{
			$row = mysqli_fetch_assoc ( $_query_result_ );
			$idArticulo = $row['articulo'];
		}

		$_sql_query_ = "DELETE FROM $_table_ WHERE id = " . $_GET['id'];

		if ( ejecutar_consulta() )
		{
			//	=>	Verdadero devuelto si registro eliminado
			echo "Registro eliminado";

			// =>	Buscar min_precio
			$_sql_query_ = "SELECT MIN(precio) AS min_precio FROM precioprov WHERE articulo = '" . $idArticulo . "' AND activo = 1";

			if ( ejecutar_consulta() )
			{
				// =>	Consulta exitosa
				$row = mysqli_fetch_assoc ( $_query_result_ );

				// =>	Pregunta: Existen precio
				if ( isset ( $row['min_precio'] ) )
				{
					// echo "Existe otro proveedor que oferta el mismo producto";
					$min_precio = (float) $row['min_precio'];

					if ( $precio > $min_precio )
					{
						// echo "Y lo oferta a un precio aun mas bajo";
						$precio = $min_precio;
					}
				}
			}

			$_sql_query_ = "SELECT COUNT(id) AS cont FROM precioprov WHERE articulo = '" . $idArticulo . "' AND activo = 1";

			if ( ejecutar_consulta() )
			{
				// Consulta exitosa

				$row = mysqli_fetch_assoc ( $_query_result_ );

				if ( ( (int) $row['cont'] ) == 0 )
					$precio = 0;
			}

			//	=>	Actualizar precio en 'articulo'
			$_sql_query_ = "UPDATE articulo SET costo = " . $precio . " WHERE idArticulo = '" . $idArticulo . "'";

			if ( ejecutar_consulta() )
				echo "El precio en articulos fue actualizado a " . $precio;
		}

		liberar_recursos();
	}

	function hola()
	{
		echo "Hola desde el servidor";
	}

	function inner_join()
	{
		global $_sql_query_, $_response_, $_num_cols_, $_query_result_, $_column_names_, $_table_;

		$sql_like_statement = "";
		$sql_query_backup = "";
		$sql_query_count = "";
		$inner_join = "";
		$_sql_query_ = "";
		$where = "";
		$filas = 0;
		$desface = 0;
		$order_by = "";
		$limit = "";
		$salida_html = "";
		$arr = array();
		$contador = 0;

		$json_obj = json_decode( $_GET['x'], true );

		if ( isset ( $_GET['filas'] ) )
		{
			$filas = (int) $_GET['filas'];
			$limit = " LIMIT $desface, $filas";

			if ( isset ( $_GET['desface'] ) )
			{
				$desface = ( ( (int) $_GET['desface'] ) - 1 ) * $filas;
				$limit = " LIMIT $desface, $filas";
			}
		}

		if ( isset ( $_GET['criterio'] ) )
		{
			$order_by = " ORDER BY " . $_GET['criterio'];
		}

		if ( isset ( $_GET['condicion'] ) )
		{
			if ( $_GET['condicion'] != "" )
				$where = " WHERE " . $_GET['condicion'];
		}

		if ( isset ( $_GET['salida_html'] ) )
			$salida_html = $_GET['salida_html'];

		if ( isset($_GET['comodin']) && ( $_GET['comodin'] != "" ) )
		{
			$_GET['comodin'] = filter_var( $_GET['comodin'], FILTER_SANITIZE_STRING, FILTER_SANITIZE_MAGIC_QUOTES );

			switch ( $_table_ )
			{
				case "precioprov":
					$sql_like_statement .= " WHERE ";
					$sql_like_statement .= "articulo.nombre";
					$sql_like_statement .= " LIKE  '%";
					$sql_like_statement .= $_GET['comodin'];
					$sql_like_statement .= "%'";
					$sql_like_statement .= " OR ";
					$sql_like_statement .= "proveedor.nombre";
					$sql_like_statement .= " LIKE '%";
					$sql_like_statement .= $_GET['comodin'];
					$sql_like_statement .= "%'";
				break;

				default:
					$sql_like_statement .= " WHERE ";
					$sql_like_statement .= $_column_names_[ 0 ];
					$sql_like_statement .= " LIKE  '%";
					$sql_like_statement .= $_GET['comodin'];
					$sql_like_statement .= "%'";
					$sql_like_statement .= " OR ";
					$sql_like_statement .= $_column_names_[ 1 ];
					$sql_like_statement .= " LIKE '%";
					$sql_like_statement .= $_GET['comodin'];
					$sql_like_statement .= "%'";
			}
		}

		$_sql_query_ = "SELECT ";

		//	=>	key1	:	arg*
		//	=>	key2	:	table object
		foreach ( $json_obj as $key1 => $value1 )
		{
			$table = "";

			//	=>	key2	:	table.attribute
			//	=>	value2	:	table.attribute value
			foreach ( $value1 as $table_attribute => $value2 )
			{
				if ( is_array ( $value2 ) )
				{
					for ( $i = 0; $i < count ( $value2 ); $i++ )
						$_sql_query_ .= $value1['table_name'] . "." . $value2[$i] . ", ";
				}
				else if ( $table_attribute === "foreing_key" )
				{
					$inner_join .= " INNER JOIN ";
					$inner_join .= $value1[ 'table_name' ];
					$inner_join .= " ON ";
					$inner_join .= $value1[ 'key' ];
					$inner_join .= " = ";
					$inner_join .= $value1[ 'foreing_key' ];
					$inner_join .= " ) ";
				}
			}
		}

		rm_ult_n_chs(2);
		$_sql_query_ .=  " FROM ";

		for ( $i = 1; $i < count ( $json_obj ); $i++ )
			$_sql_query_ .= "( ";

		$_sql_query_ .= $json_obj['arg1']['table_name'];
		$_sql_query_ .= $inner_join;
		$_sql_query_ .= $sql_like_statement;
		$_sql_query_ .= $where;
		$_sql_query_ .= $order_by;
		$_sql_query_ .= $limit;




		if ( isset($_GET['comodin']) && ( $_GET['comodin'] != "" ) )
		{
			switch ( $_table_ )
			{
				case "precioprov":
					$sql_query_count = "SELECT COUNT( * ) AS contador FROM ( ( $_table_ INNER JOIN articulo ON precioprov.articulo = articulo.idArticulo ) INNER JOIN proveedor ON proveedor.idProveedor = precioprov.proveedor )";
				break;

				case "subunidad":
					$sql_query_count = "SELECT COUNT( * ) AS contador FROM ( ( $_table_ INNER JOIN unidad ON unidad.idUnidad = subunidad.unidad ) INNER JOIN cliente ON cliente.idCliente = subunidad.cliente )";
				break;

				case "unidad":
					$sql_query_count = "SELECT COUNT( * ) AS contador FROM ( $_table_ INNER JOIN cliente ON cliente.idCliente = unidad.cliente )";
				break;

				default:
					$sql_query_count .= "SELECT COUNT( * ) AS contador ";
					$sql_query_count .= substr( $_sql_query_, strpos( $_sql_query_, "FROM" ) );
					$sql_query_count = substr( $sql_query_count, 0, strpos( $sql_query_count, "ORDER" ) );
			}
		}

		$sql_query_backup = $_sql_query_;
		$_sql_query_ = $sql_query_count . $sql_like_statement;

		if ( ejecutar_consulta() )
		{
			$row = mysqli_fetch_assoc( $_query_result_ );
			$contador = isset( $row['contador'] ) ? (int) $row['contador'] : 0;
			$contador = ( $row['contador'] % $filas == 0 ) ? ( $row['contador'] / $filas ) : ( (int) ( $row['contador'] / $filas ) ) + 1;
		}

		$_sql_query_ = $sql_query_backup;
		$sql_query_backup = "";


		if ( ejecutar_consulta() )
		{
			switch ( $salida_html )
			{
				case "1fila":
					$row = mysqli_fetch_row( $_query_result_ );
					$_response_ = json_encode( $row );
				break;

				case "option":
					while ( $row = mysqli_fetch_row( $_query_result_ ) )
					{
						$_response_ = $row[0];
						$_response_ .= ":";
						$_response_ .= "<option value=\"" . $row[0] . "\">";
						$_response_ .= "( " . $row[0] . " ) " . $row[1];
						$_response_ .= "</option>";
						array_push( $arr, $_response_ );
					}

					$_response_ = json_encode( $arr );
				break;

				case "vec2":
					$arr = mysqli_fetch_all( $_query_result_, MYSQLI_NUM );
					$_response_ = json_encode( $arr );
				break;

				default:
					inner_join_tabla();
					$array_response = array("contador_paginas" => $contador, "respuesta" => $_response_);
					echo json_encode( $array_response );
					liberar_recursos();

					return;
			}
		}

		echo $_response_;
		liberar_recursos();
	}

	function inner_join_tabla()
	{
		global $_query_result_, $_response_, $_table_type_;

        $finfo = mysqli_fetch_fields( $_query_result_ );
        $primary_key_name = "";

		$_response_ = "";
		$_response_ = "<div class=\"table-responsive\">";



		switch ( $_table_type_ )
		{
			case "consultar":
				$_response_ .= "<table class=\"table table-striped table-bordered table-hover\">";
			break;

			case "eliminar":
				$_response_ .= "<table class=\"table table-bordered eliminar\">";
			break;

			case "modificar":
				$_response_ .= "<table class=\"table table-striped table-bordered table-hover editable\">";
			break;
		}

		$_response_ .= "<thead>";
		$_response_ .= "<tr>";

        foreach ($finfo as $val)
        {
        	$_response_ .= "<th data-key=\"$val->orgname\">";
            $_response_ .= $val->name;
        	$_response_ .= "</th>";
        }

		$_response_ .= "</tr>";
		$_response_ .= "</thead>";
		$_response_ .= "<tbody>";

		while ( $row = mysqli_fetch_assoc( $_query_result_ ) )
		{
			$_response_ .= "<tr>";

			foreach ($row as $key => $value)
			{
				$_response_ .= "<td>";

				switch ($_table_type_)
				{
					case "consultar":
					case "eliminar":
						$_response_ .= $value;
					break;

					case "modificar":
						$_response_ .= "<div ";
						$_response_ .= "class=\"td_data\" ";
						$_response_ .= "edit_type=\"click\" ";
						$_response_ .= "contenteditable=\"false\" ";
						$_response_ .= "data-editado=\"false\" ";

						if ( $key == $primary_key_name )
							$_response_ .= "data-primary=\"$val->orgname\" ";

						$_response_ .= "data-key=\"$val->orgname\" ";
						$_response_ .= "data-respaldo=\"\"";
						$_response_ .= ">";
						$_response_ .= $value;
						$_response_ .= "</div>";
					break;
				}

				$_response_ .= "</td>";
			}

			$_response_ .= "</tr>";
		}

		$_response_ .= "</tbody>";
	}

	function liberar_recursos()
	{
		global $_sql_query_, $_response_, $_query_result_, $_num_rows_, $_num_cols_;

		$_sql_query_ = "";
		$_response_ = "";
		$_num_rows_ = 0;
		$_num_cols_ = 0;
		if ( is_null( $_query_result_ ) )
			mysqli_free_result( $_query_result_ );
	}

	function ocm_agregar_articulo()
	{
		global $_sql_query_, $_num_rows_;

		$_sql_query_ = "";

		$_sql_query_ .= "SELECT articulo.idArticulo, articulo.nombre, articulo.unidad, articulo.unidadA, articulo.factor, precioProv.precio ";
		$_sql_query_ .= " FROM articulo INNER JOIN precioProv ON articulo.idArticulo = precioProv.articulo ";
		$_sql_query_ .= " WHERE precioProv.articulo = '" . $_GET['idArticulo'] . "' ";
		$_sql_query_ .= " AND precioProv.proveedor = '" . $_GET['idProveedor'] . "' ";

		if ( ejecutar_consulta() )
		{
			if ( isset ( $row['factor'] ) )
			{
				if ( ( (int) $row['factor'] ) > 0 )
					$precio = $precio * $row['factor'];
			}
		}

		liberar_recursos();
	}

	function ocm_obtener_clave()
	{
		global $_sql_query_, $_response_, $_query_result_;

		$_sql_query_ = "";
		$_response_ = "0";

		$_sql_query_ = "SELECT MAX( id ) as last_id FROM ocm";

		if ( ejecutar_consulta() )
		{
			$row = mysqli_fetch_assoc ( $_query_result_ );

			if ( isset ( $row['last_id'] ) )
				$_response_ = $row['last_id'];
		}

		echo $_response_;
		liberar_recursos();
	}

	function paginas_por_tabla()
	{
		global $_query_result_, $_response_, $_sql_query_, $_column_names_, $_table_, $_num_rows_;

		$_sql_query_ = "";

		switch ( $_table_ )
		{
			case "unidad":
				$_sql_query_ = "SELECT idUnidad FROM ( $_table_ INNER JOIN cliente ON cliente.idCliente = unidad.cliente )";
			break;

			case "precioprov":
				$_sql_query_ = "SELECT id FROM ( ( $_table_ INNER JOIN articulo ON precioprov.articulo = articulo.idArticulo ) INNER JOIN proveedor ON proveedor.idProveedor = precioprov.proveedor )";
			break;

			case "subunidad":
				$_sql_query_ = "SELECT idSUnidad FROM ( ( $_table_ INNER JOIN unidad ON unidad.idUnidad = subunidad.unidad ) INNER JOIN cliente ON cliente.idCliente = subunidad.cliente )";
			break;

			default:
				$_sql_query_ = "SELECT " . $_column_names_[0] . " FROM " . $_table_;
		}
		$rows_per_page = (int) $_GET['filas'];
		$_response_ = 0;

		if ( ejecutar_consulta() )
		{
			if ( ( (int) ( $_num_rows_ % $rows_per_page ) ) == 0 )
				$_response_ = (int) ($_num_rows_ / $rows_per_page);
			else
				$_response_ = ( (int) ( $_num_rows_ / $rows_per_page ) ) + 1;
		}

		echo $_response_;
		liberar_recursos();
	}
	
	function registrar()
	{
		global $_response_, $_sql_query_, $_table_, $_query_result_;

		$ban = true;
		$fecha = date_create ();
		$fecha = date_format ( $fecha, "Y-m-d 00:00:00" );
		$extra_array = array ( "fecha" => $fecha , "activo" => "1" );

		switch ( $_table_ )
		{
			case "base":
				$_sql_query_ = "SELECT idBase FROM base WHERE idBase = " . $_GET['idBase'] . " OR descripcion = '" . $_GET['descripcion'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idBase'] ) )
					{
						echo "La base ya existe o existió en la Base de Datos";
						$ban = false;
					}
				}
			break;

			case "bomocm":
				$_sql_query_ = "SELECT OC FROM bomocm ";
				$_sql_query_ .= "WHERE OC = '" . $_GET['OC'] . "' ";
				$_sql_query_ .= "AND proveedor = " . $_GET['proveedor'] . " ";
				$_sql_query_ .= "AND articulo = '" . $_GET['articulo'] . "' ";
				$_sql_query_ .= "AND unidad = '" . $_GET['unidad'] . "'";
				array_splice ( $extra_array, 1 );

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['OC'] ) )
					{
						echo "La orden de compra manual para esta unidad ya existe";
						$ban = false;
					}
				}
			break;

			case "cliente":
				$_sql_query_ = "SELECT idCliente FROM cliente WHERE nombre = '" . $_GET['nombre'] . "' OR rfc = '" . $_GET['rfc'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idCliente'] ) )
					{
						echo "Ya existe este cliente";
						$ban = false;
					}
				}
			break;

			case "grupo":
				$_sql_query_ = "SELECT idGrupo FROM grupo WHERE idGrupo = " . $_GET['idGrupo'] . " OR descripcion = '" . $_GET['descripcion'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idGrupo'] ) )
					{
						echo "El grupo ya existe o existió en la base de datos";
						$ban = false;
					}
				}
			break;

			case "proveedor":
				$_sql_query_ = "SELECT idProveedor FROM proveedor WHERE nombre = '" . $_GET['nombre'] . "' OR rfc = '" . $_GET['rfc'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idProveedor'] ) )
					{
						echo "Error: Ya existe un proveedor con el mismo nombre o R.F.C.";
						$ban = false;
					}
				}
			break;

			case "unidad":
				$_sql_query_ = "SELECT idUnidad FROM unidad WHERE unidad = '" . $_GET['unidad'] . "' OR idUnidad = '" . $_GET['idUnidad'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idUnidad'] ) )
					{
						echo "El número o el nombre de la unidad ya existe o existió en la base de datos";
						$ban = false;
					}
				}
			break;

			case "subunidad":
				$_sql_query_ = "SELECT idSUnidad FROM subunidad WHERE cliente = " . $_GET['cliente'] . " AND unidad = '" . $_GET['unidad'] . "' AND idSUnidad = '" . $_GET['idSUnidad'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idSUnidad'] ) )
					{
						echo "La combinación Cliente, Unidad, SubUnidad ya existe o existió en la Base de Datos. Favor de ingresarlo con otro código de Sub-Unidad";
						$ban = false;
					}
				}
			break;

			case "linea":
				$_sql_query_ = "SELECT idLinea FROM linea WHERE idLinea = " . $_GET['idLinea'] . " OR descripcion = '" . $_GET['descripcion'] . "'";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idLinea'] ) )
					{
						echo "La línea ya existe o existió en la Base de Datos";
						$ban = false;
					}
				}
			break;

			case "ocm":
				$_sql_query_ = "SELECT idOC FROM ocm WHERE idOC = '" . $_GET['idOC'] . "'";
				array_splice ( $extra_array, 0 );

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					if ( isset ( $row['idOC'] ) )
					{
						echo "La orden de compra ya existe";
						$ban = false;
					}
				}
			break;

			default:
		}

		if ( !$ban )
			return;

		$_sql_query_ = "";

		// =>	Quitar campos vacios
		$empty_array = array("a"=>"");
		$_GET = array_merge($_GET, $extra_array);
		$_GET = array_diff($_GET, $empty_array);

		// =>	Asignar tipos
		array_walk( $_GET, "test" );

		// =>	Inicio construir consulta
		$_sql_query_ = "INSERT INTO " . $_table_ . " (";

		//	=>	GET tiene el nombre de los campos
		foreach ( $_GET as $key => $value )
			$_sql_query_ .= "$key, ";

		rm_ult_n_chs(2);
		$_sql_query_ .= " ) VALUES ( ";

		//	=>	GET tiene el valor de los campos
		foreach ( $_GET as $key => $value )
			$_sql_query_ .= "$value, ";

		rm_ult_n_chs(2);
		$_sql_query_ .= " )";
		// =>	Fin construir consulta

		// echo $_sql_query_;
		 if ( ejecutar_consulta() )
		 	echo "Registro agregado correctamente";

		liberar_recursos();
	}

	function registrar_precio()
	{
		global $_response_, $_sql_query_, $_num_rows_, $_query_result_;

		$_response_ = "";
		$_sql_query_ = "";
		$_num_rows_ = 0;
		$fecha = date_create ();
		$fecha = date_format ( $fecha, "Y-m-d 00:00:00" );
		$precio = (float) $_GET['costo'];
		$presentacion = $_GET['unidadA'];
		$factor = (int) $_GET['factor'];
		$idProveedor = (int) $_GET['proveedor'];
		$idArticulo = $_GET['articulo'];
		$info = $_GET['info'];

		// print_r ( $_GET );

		if ( $precio <= 0 )
		{
			$_response_ = "Ingrese un precio válido";
		}
		else
		{
			if ( ( $presentacion !== "Ninguna" ) and ( $factor > 0 ) )
				$precio = $precio / $factor;

			$_sql_query_ .= "SELECT count(id) AS cont";
			$_sql_query_ .= " FROM precioprov";
			$_sql_query_ .= " WHERE proveedor = " . $idProveedor;
			$_sql_query_ .= " AND ";
			$_sql_query_ .= " articulo = '" . $idArticulo . "'";

			if ( ejecutar_consulta() )
			{
				//	=>	Existe, actualiza
				$row = mysqli_fetch_assoc ( $_query_result_ );

				if ( isset ( $row['cont'] ) )
				{
					if ( $row['cont'] > 0 )
					{
						//	=>	La combinacion existe
						$_sql_query_ = "";
						$_sql_query_ .= "UPDATE precioprov";
						$_sql_query_ .= " SET ";
						$_sql_query_ .= "precio = " . $precio;
						$_sql_query_ .= ", ";
						$_sql_query_ .= "info = '" . $info . "' ";
						$_sql_query_ .= ", ";
						$_sql_query_ .= "activo = 1";
						$_sql_query_ .= ", ";
						$_sql_query_ .= "fecha = '" . $fecha . "' ";
						$_sql_query_ .= "WHERE ";
						$_sql_query_ .= "proveedor = " . $idProveedor;
						$_sql_query_ .= " AND ";
						$_sql_query_ .= "articulo = '" . $idArticulo;
						$_sql_query_ .= "'";

						if ( ejecutar_consulta() )
							echo "El precio ha sido actualizado";
					}
					else
					{
						//	=>	La combinacion no existe; debe ser ingresada
						$_sql_query_ = "";
						$_sql_query_ .= "INSERT INTO precioprov ";
						$_sql_query_ .= "(proveedor, articulo, precio, info, fecha, activo) ";
						$_sql_query_ .= "VALUES ";
						$_sql_query_ .= "( ";
						$_sql_query_ .= $idProveedor;
						$_sql_query_ .= ", '";
						$_sql_query_ .= $idArticulo;
						$_sql_query_ .= "', ";
						$_sql_query_ .= $precio;
						$_sql_query_ .= ", '";
						$_sql_query_ .= $info;
						$_sql_query_ .= "', '";
						$_sql_query_ .= $fecha;
						$_sql_query_ .= "', 1)";

						if ( ejecutar_consulta() )
							echo "El precio para el proveedor: " . $idProveedor . " y el artículo: " . $idArticulo . " ha sido registrado";
					}
				}

				$_sql_query_ = "";
				$_sql_query_ .= "INSERT INTO precioprovbit ";
				$_sql_query_ .= "(proveedor, articulo, precio, fecha) ";
				$_sql_query_ .= "VALUES ";
				$_sql_query_ .= "( ";
				$_sql_query_ .= $idProveedor;
				$_sql_query_ .= ", '";
				$_sql_query_ .= $idArticulo;
				$_sql_query_ .= "', ";
				$_sql_query_ .= $precio;
				$_sql_query_ .= ", '";
				$_sql_query_ .= $fecha;
				$_sql_query_ .= "')";

				if ( ejecutar_consulta() )
					echo "Registro guardado en la bitacora";

				//	=>	Buscamos el precio minimo
				$_sql_query_ = "";
				$_sql_query_ .= "SELECT MIN(precio) AS min_precio FROM precioprov ";
				$_sql_query_ .= "WHERE ";
				$_sql_query_ .= "articulo = '";
				$_sql_query_ .= $idArticulo;
				$_sql_query_ .= "'";
				$_sql_query_ .= " AND ";
				$_sql_query_ .= "activo = 1";

				if ( ejecutar_consulta() )
				{
					$row = mysqli_fetch_assoc ( $_query_result_ );

					//	=>	Pregunta: existe min_precio
					if ( isset ( $row['min_precio'] ) )
					{
						$min_precio = (float) $row['min_precio'];

						if ( ( $min_precio ) <= $precio )
							$precio = $min_precio;
					}

					//	=>	Actualizamos el costo minimo en la tabla articulo
					$_sql_query_ = "";
					$_sql_query_ .= "UPDATE articulo ";
					$_sql_query_ .= "SET ";
					$_sql_query_ .= "costo = " . $precio;
					$_sql_query_ .= ", ";
					$_sql_query_ .= "fechaMod = '" . $fecha . "'";
					$_sql_query_ .= "WHERE ";
					$_sql_query_ .= "idArticulo = '";
					$_sql_query_ .= $idArticulo;
					$_sql_query_ .= "'";

					if ( ejecutar_consulta() )
						echo "Costo minimo actualizado";
				}
			}
			else
				$_response_ = "Error en la consulta:" . $_sql_query_;
		}

		echo $_response_;
		liberar_recursos();
	}

	function rm_ult_n_chs($n = 1)
	{
		global $_sql_query_;

		for ($i = 0; $i < $n; $i++)
			$_sql_query_ = rtrim( $_sql_query_, ", " );
	}

	function tabla_metadatos()
	{
		global $_column_types_, $_column_names_, $_sql_query_, $_table_, $_query_result_;

		if ( isset ( $_GET['table'] ) )
		{
			$_table_ = $_GET['table'];
			$dump_array = array( "table" => "" );
			$_GET = array_diff_key ( $_GET, $dump_array );
		}

		$_sql_query_ = "";
		$_sql_query_ = "DESCRIBE $_table_";

		if ( ejecutar_consulta() )
		{
			while ( $row = mysqli_fetch_row( $_query_result_ ) )
			{
				$type = strchr( $row[1], "(", true ) ;

				if (!$type)
					$type = $row[1];

				array_push( $_column_types_, $type );
				array_push( $_column_names_, $row[0] );
			}
		}

		liberar_recursos();
	}

	function test(&$value, $key)
	{
		global $_column_types_, $_column_names_;

		switch ( $_column_types_[ array_search( $key, $_column_names_ ) ] )
		{
			case "datetime":
			case "varchar":
				$value = "'$value'";
			break;

			case "int":
				$value = (int) $value;
			break;

			case "float":
				$value = (float) $value;
			break;

			default:
				// echo $_column_types_[ array_search( $key, $_column_names_ ) ];
				$value = "no reconocido";
		}
	}	//	=>	Funcion principal

	function getOrdenes()
	{
	    //para no traer todas las oradenes de la base de datos lo limito a traer las del ultimo año
		global $_query_result_, $_sql_query_;

	    $dt = new DateTime();
	    $dt->sub( new DateInterval('P1Y') );
	    $dateLimit = $dt->format('Y-m-d');

	    $sql = "SELECT 
	    id, 
	    idOC, 
	    fecha, 
	    fechaI, 
	    fechaF, 
	    (SELECT nombre FROM cliente WHERE idCliente = cliente LIMIT 1) AS cliente, 
	    status, 
	    (SELECT nombre FROM usuario WHERE idUser = ocm.usuario LIMIT 1) AS usuario
	    FROM ocm WHERE 1 AND fecha > '{$dateLimit}' ORDER BY idoc DESC";
	    $_sql_query_ = $sql;

	    if ( ejecutar_consulta() )
	    {
		    while( $rows[] = mysqli_fetch_assoc( $_query_result_ ) );
		    array_pop($rows);
		    echo json_encode($rows);
	    }
	}


  function authOC()
  {
	global $_query_result_, $_sql_query_;
    $orden = filter_input(INPUT_GET, 'orden', FILTER_SANITIZE_STRING);

      $sql = "UPDATE ocm SET status = '2' WHERE idOC = '{$orden}'";
      $_sql_query_ = $sql;
      if ( ejecutar_consulta() )
        echo json_encode(["status" => 1, "msg" => 'La Orden de Compra se Autorizo y Cerro correctamente']);
      else
        echo json_encode(["status" => 0, "msg" => 'Se produjo un error al autorizar la Orden de Compra, por favor reintente']);


  }

  function reOpenOC()
  {
	global $_query_result_, $_sql_query_;
    $orden = filter_input(INPUT_GET, 'orden', FILTER_SANITIZE_STRING);

      $sql = "UPDATE ocm SET status = '1' WHERE idOC = '{$orden}'";

		$_sql_query_ = $sql;
      if ( ejecutar_consulta() )
        echo json_encode(["status" => 1, "msg" => 'La Orden de Compra se aperturó correctamente']);
      else
        echo json_encode(["status" => 0, "msg" => 'Se produjo un error al autorizar la Orden de Compra, por favor reintente']);

  }

  function removeOC()
  {
	global $_query_result_, $_sql_query_;
    $orden = filter_input(INPUT_GET, 'orden', FILTER_SANITIZE_STRING);

      $sql = "DELETE FROM ocm WHERE idOC = '{$orden}'";
        $_sql_query_ = $sql;
      if ( ejecutar_consulta() )
        echo json_encode(["status" => 1, "msg" => 'La Orden de Compra se eliminó correctamente']);
      else
        echo json_encode(["status" => 0, "msg" => 'Se produjo un error al autorizar la Orden de Compra, por favor reintente']);
  }
?>