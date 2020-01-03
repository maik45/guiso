//  =>   El usuario da clic en una fila de la tabla
$(document).on("click", "table.eliminar tbody tr", function(event)
{
  event.stopImmediatePropagation();
  $(this).toggleClass("alert alert-danger elegido");

  //	=>	Si hay al menos una fila seleccionada; mostrar boton
    var filas_elegidas = $("tr[class*='elegido']");

    if ( filas_elegidas.length > 0 )
    {
	  $("button[id='0']").css("visibility", "visible");
	  textoAyuda("Si esta realmente seguro de eliminar los elementos seleccionados, filas en color rojo, haga clic en el botón 'Eliminar'",
      "text-danger", "Precaución");
    }
  	else
  	{
  	  $("button[id='0']").css("visibility", "hidden");
  	  textoAyuda("Haga clic sobre los registros que deseé eliminar", "text-blue", "¿Cómo eliminar?");
  	}
    //  =>  Fin de mostrar boton
}); //  Funcion on