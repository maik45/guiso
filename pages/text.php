<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-registrar-proveedor" type="button" class="btn btn-primary btn-outline btn-block" >Agregar proveedor</button>
<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-eliminar-proveedor" type="button" class="btn btn-primary btn-outline btn-block">Eliminar proveedor</button>
<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-consultar-nombre-proveedor" type="button" class="btn btn-primary btn-outline btn-block">Consultar por nombre</button>
<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-consultar-clave-proveedor" type="button" class="btn btn-primary btn-outline btn-block">Consultar por clave</button>
<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-modificar-datos-proveedor" type="button" class="btn btn-primary btn-outline btn-block">Modificar datos del proveedor</button>
<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-modificar-pago-proveedor" type="button" class="btn btn-primary btn-outline btn-block">Modificar tipo de pago de proveedor</button>
<button style="margin:0.5em;width:100%;color:#000;overflow-y: hidden;text-overflow: ellipsis;border-width: 0.15em;padding-top: 1em;padding-bottom: 1em;" id="boton-lista-precios" type="button" class="btn btn-primary btn-outline btn-block">Lista de precios</button>

<script type="text/javascript">
	$("button[id='boton-eliminar-proveedor']").click(function(){
		$("div[id='contenedor-formulario']").load("EliminarProveedor.php");
	});

	$("button[id='boton-registrar-proveedor']").click(function(){
		$("div[id='contenedor-formulario']").load("RegistrarProveedor.php");
	});

	$("button[id='boton-consultar-nombre-proveedor']").click(function(){
		$("div[id='contenedor-formulario']").load("ConsultarProveedoresPorNombre.php");
	});

	$("button[id='boton-consultar-clave-proveedor']").click(function(){
		$("div[id='contenedor-formulario']").load("ConsultarProveedoresPorClave.php");
	});

	$("button[id='boton-modificar-datos-proveedor']").click(function(){
		$("div[id='contenedor-formulario']").load("ModificarDatosProveedor.php");
	});

	$("button[id='boton-modificar-pago-proveedor']").click(function(){
		$("div[id='contenedor-formulario']").load("ModificarTipoPagoProveedor.php");
	});

	$("button[id='boton-lista-precios']").click(function(){
		alert("Verificar que hacer aqui");
	});
</script>