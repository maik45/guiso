//  =>   Respalda todos los datos ACTUALES de la tabla
function respaldarTabla()
{
  //  =>   Todas las celdas dentro de la tabla
  $("div[data-respaldo]").each( function()
  {
    //  =>   Respalda el dato de esta celda
    $(this).attr("data-respaldo", $(this).text());
    $(this).attr("data-editado", "false");
  });   //  =>  each

  switch ( __contenedor_menu__.attr("data-menu-actual") )
  {
    case "menu-base":
    case "menu-grupo":
    case "menu-linea":
    case "menu-precioprov":
      $(document).on("click", "table.editable tr td:nth-child(2) > div", function()
      {
        $(this).attr("contenteditable", "true");
      });

      $(document).on("keyup", "table.editable tr td:nth-child(2) > div",function(event)
      {
        if ( $(this).attr("data-respaldo") != $(this).text() )
        {
          $(this).attr("data-editado", "true");
          $(this).css("background-color", "#ffff00");
          $(this).closest("tr").attr("data-editado", "true");
          $(this).closest("tr").css("background-color", "#ffff99");
        }

        mostrarBotonGuardarCambios();
      });

      textoAyuda("Solo los datos de la segunda columna pueden ser modificados");

    break;

    case "menu-cliente":
    case "menu-proveedor":
      $(document).on("click", "table.editable tr :not(td:nth-child(1)) > div", function()
      {
        $(this).attr("contenteditable", "true");
      });

      $(document).on("keyup", "table.editable tr :not(td:nth-child(1)) > div",function(event)
      {
        if ( $(this).attr("data-respaldo") != $(this).text() )
        {
          $(this).attr("data-editado", "true");
          $(this).css("background-color", "#ffff00");
          $(this).closest("tr").attr("data-editado", "true");
          $(this).closest("tr").css("background-color", "#ffff99");
        }
        else
        {
          $(this).attr("data-editado", "false");
          $(this).css("background-color", "#fefefe");
          $(this).closest("tr").attr("data-editado", "false");
          $(this).closest("tr").css("background-color", "#fefefe");
        }

        mostrarBotonGuardarCambios();
        mostrarBotonCancelarCambios();
      });

      textoAyuda("Los datos de la columna clave no pueden ser modificados");
    break;

    case "menu-subunidad":
    case "menu-unidad":
      $(document).on("click", "table.editable tr td:nth-child(3) > div", function()
      {
        $(this).attr("contenteditable", "true");
      });

      $(document).on("keyup", "table.editable tr :not(td:nth-child(1)) > div",function(event)
      {
        if ( $(this).attr("data-respaldo") != $(this).text() )
        {
          $(this).attr("data-editado", "true");
          $(this).css("background-color", "#ffff00");
          $(this).closest("tr").attr("data-editado", "true");
          $(this).closest("tr").css("background-color", "#ffff99");
        }
        else
        {
          $(this).attr("data-editado", "false");
          $(this).css("background-color", "#fefefe");
          $(this).closest("tr").attr("data-editado", "false");
          $(this).closest("tr").css("background-color", "#fefefe");
        }

        mostrarBotonGuardarCambios();
        mostrarBotonCancelarCambios();
      });

      textoAyuda("Solo los datos de la tercera columna pueden ser modificados");
    break;
  }
} //  =>  respaldarTabla

//  =>   Restablece los datos RESPALDADOS de la tabla
function restaurarRespaldo()
{
  //  =>   Todas las celdas dentro de la tabla
  $("div[data-respaldo]").each( function()
  {
    //  =>   Cargar respaldo
    $(this).text( $(this).attr("data-respaldo") );
  
    //  =>   Editado : No
    $(this).attr("data-editado", "false");

    //  =>   Editado : No
    $(this).css("background-color", "#fefefe");
    $(this).closest("tr").attr("data-editado", "false");
    $(this).closest("tr").css("background-color", "#fefefe");
  });

  mostrarBotonCancelarCambios();
  mostrarBotonGuardarCambios();
} //  =>  restaurarRespaldo

function mostrarBotonGuardarCambios()
{
  var filas_editadas = $("tr[data-editado='true']");

  if ( filas_editadas.length > 0 )
  {
    textoAyuda("Para guardar los cambios realizados, filas en color amarillo, pulse el botón 'Guardar cambios'", "text-danger", "Precaución");
    $("#1").css("visibility", "visible");
  }
  else
  {
    textoAyuda("");
    $("#1").css("visibility", "hidden");
  }
}

function mostrarBotonCancelarCambios()
{
  var filas_editadas = $("tr[data-editado='true']");

  if ( filas_editadas.length > 0 )
    $("#0").css("visibility", "visible");
  else
    $("#0").css("visibility", "hidden");
}

// respaldarTabla();