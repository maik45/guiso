<div id="panel-1-contenedor" class="panel panel-default" style="color:#23527c;">
    <div class="panel-heading" style="padding-bottom:1.5em;padding-top:1.5em;background-color: #ff6200;color:#f5f5f5;">
        <h4 id="opcion">Elije una opción</h4>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li>
                <a id="agregar-usuario" href="#" data-toggle="tab" data-texto="Agregar usuario" data-nombre-archivo="RegistrarUsuario.php" style="background-color:#ff6200;color:#f5f5f5;">Agregar</a>
            </li>
            <li>
                <a id="eliminar-usuario" href="#" data-toggle="tab" data-texto="Eliminar usuario" data-nombre-archivo="EliminarUsuario.php" style="background-color:#ff6200;color:#f5f5f5;">Eliminar</a>
            </li>
            <li>
                <a id="consultar-usuario" href="#" data-toggle="tab" data-texto="Consultar usuarios" data-nombre-archivo="ConsultarUsuario.php" style="background-color:#ff6200;color:#f5f5f5;">Consultar</a>
            </li>
            <li>
                <a id="modificar-usuario" href="#" data-toggle="tab" data-texto="Modificar los datos de un usuario" data-nombre-archivo="ModificarUsuario.php" style="background-color:#ff6200;color:#f5f5f5;">Modificar</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div id="tab-contenedor" class="tab-content">

        </div>
    </div>

    <script type="text/javascript">
        function cargarContenido(id, archivo)
        {
          var obj = $("a[id=\'" + id + "\']");

          console.log("id: " + id);
          console.log("archivo: " + archivo);

            if (obj.parent().attr("class") != "active")
            {
              // Cargamos formulario o tabla
                $("div[id='tab-contenedor']").load(archivo);

              // Actualizamos el nombre de la operacion
                $("h4[id='opcion']").text(obj.attr("data-texto"));
            }
            else
                console.log("El menu para esta opcion ya esta cargado.");
        }

        $("a[id='agregar-usuario']").click(function(){
            cargarContenido($(this).attr("id"), $("a[id='agregar-usuario']").attr("data-nombre-archivo"));
        });

        $("a[id='eliminar-usuario']").click(function(){
            cargarContenido($(this).attr("id"), $("a[id='eliminar-usuario']").attr("data-nombre-archivo"));
        });

        $("a[id='consultar-usuario']").click(function(){
            cargarContenido($(this).attr("id"), $("a[id='consultar-usuario']").attr("data-nombre-archivo"));
        });

        $("a[id='modificar-usuario']").click(function(){
            cargarContenido($(this).attr("id"), $("a[id='modificar-usuario']").attr("data-nombre-archivo"));
        });
    </script>
</div>