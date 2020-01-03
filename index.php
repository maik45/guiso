<?php
session_start();
//verificamos la variable de sessión
//si la variable de session no existe lo redireccionamos al login
if( empty( $_SESSION['usuario_comedor'] ) ){
  header('location: login');
  exit;
}

$user = $_SESSION['usuario_comedor'];
$name = $_SESSION['nombre_comedor'];
// $tel = $_SESSION['telefono_comedor'];
$rol = $_SESSION['rol_comedor'];
// $address = $_SESSION['direccion_comedor'];
// $uid = $_SESSION['uid_comedor'];

//variable que permite visualizar fragmentos dependiendo el Rol
$allowed = $rol === '0' ? true : false;//0 es admin 1 es un vil mortal
// var_dump ($rol);
// var_dump ($allowed);
//variables de Angel
//  =>  Mis variablas de sesion
//  =>  Funciona para archivo eliminar, modificar
$_SESSION['__js_form__'] = "./pages/personal_js/formulario.js";
$_SESSION['__js_del_tab__'] = "./pages/personal_js/tabla-eliminar.js";
$_SESSION['__js_edt_tab__'] = "./pages/personal_js/tabla-modificar.js";
$_SESSION['__js_menu__'] = "./pages/personal_js/menu.js";

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
    
  <link rel="shortcut icon" href="img/favicon.png" />

  <title>Guisopak - Sistema Control de Comedores</title>
  

  <!-- Bootstrap Core CSS -->
  <link href="css/bootstrap/bootstrap.min.css" rel="stylesheet">
  <!-- MetisMenu CSS -->
  <link href="css/metisMenu.min.css" rel="stylesheet">
  <!-- Timeline CSS -->
  <!-- <link href="css/timeline.css" rel="stylesheet"> -->
  <!-- Custom CSS -->
  <link href="css/startmin.css" rel="stylesheet">
  <!-- Custom Fonts -->
  <link href="css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">

  <!-- Michael Agrego Sweet Alert y DataTables -->
  <link rel="stylesheet" href="js/DataTables/datatables.min.css">
  <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.20/datatables.min.css"/> -->
  <link rel="stylesheet" href="js/bootstrap-datepicker-1.9.0/css/bootstrap-datepicker3.min.css">

  <link rel="stylesheet" href="js/perfect-scrollbar-1.4.0/css/perfect-scrollbar.css">

  <link rel="stylesheet" type="text/css" href="css/custom.css">
  <link rel="stylesheet" type="text/css" href="css/pages.css">
  
  <style>

    overflow-y{
      /*opacity: 0;*/
      overflow-y: hidden;
    }
    overflow-y:hover, .sidebaraaaa:hover{
      overflow-y: auto;
      /*animation-name: example;*/
      /*animation-duration: 4s;*/
    }

    @keyframes example {
    from {opacity: 0;}
    to {opacity: 0.9;}
    }

  </style>

</head>
<body style="display: none">

  <div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar bg-blue navbar-fixed-top" role="navigation">
    
      <div class="navbar-header">
        <a class="navbar-brand text-white" href="javascript://">GuisoPak</a>
      </div>

      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="fa fa-bars text-white"></span>
      </button>

      <ul class="nav navbar-nav navbar-left navbar-top-links">
        <li><a href="javascript://" class="text-white"><i class="fa fa-home fa-fw"></i> Sistema Control de Comedores</a></li>
      </ul>

      <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
          <a class="dropdown-toggle text-white" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i> <?= $_SESSION['nombre_comedor'] ?> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li>
              <a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
            </li>
          </ul>
        </li>
      </ul>
      <!-- /.navbar-top-links -->

      <div class="navbar-default sidebar" role="navigation">
        
        <div class="sidebar-nav navbar-collapse">
          
          <ul class="nav" id="side-menu" >
            
            <li>
                <a href="index"><i class="fa fa-dashboard fa-fw"></i> Inicio</a>
            </li>
            
            <?php if( $allowed ): ?>
            <li>
              <a href="javascript://">
                <i class="fa fa-list fa-fw"></i> Catálogo <i class="fa arrow"></i>
              </a>
              <ul class="nav nav-second-level">
                <li>
                  <a href="usuarios/view/menu.php" class="ajaxLink">Usuarios</a>
                </li>
                <li>
                  <a href="articulo/view/menu.php" class="ajaxLink" >Artículos</a>
                </li>
                <li>
                  <a href="tiempo/view/menu.php" class="ajaxLink" >Tiempos</a>
                </li>
                <li>
                  <a href="javascript://" data-archivo="MenuProveedor.php" data-menu="menu-proveedor">Proveedores </a>
                </li>
                <li>
                  <a href="javascript://" data-archivo="MenuClientes.php" data-menu="menu-cliente">Clientes </a>
                </li>
                <li>
                  <a href="javascript://" data-archivo="MenuLinea.php" data-menu="menu-linea">Líneas </a>
                </li>
                <li>
                  <a href="javascript://" data-archivo="MenuGrupos.php" data-menu="menu-grupo">Grupos </a>
                </li>
                <li>
                  <a href="javascript://" data-archivo="MenuBases.php" data-menu="menu-base">Bases </a>
                </li>
              </ul>
              <!-- /.nav-second-level -->
            </li>
            <?php endif; ?>

            
            <li>
              <a href="javascript://">
                <i class="fa fa-book fa-fw"></i> Recetas <span class="fa arrow"></span>
              </a>
              <ul class="nav nav-second-level">
                <li>
                  <a href="recetas/view/addRecetas.php" class="ajaxLink">Agregar receta</a>
                </li>
                <li>
                  <a href="recetas/view/consultaRecetas.php" class="ajaxLink">Consultar receta</a>
                </li>
                <li>
                  <a href="recetas/view/modificaRecetas.php" class="ajaxLink">Modificar receta</a>
                </li>
                <?php if( $allowed ): ?>
                <li>
                  <a href="recetas/view/eliminaRecetas.php" class="ajaxLink">Eliminar receta</a>
                </li>
                <?php endif; ?>
                <!-- <li>
                  <a href="recetas/view/masivoRecetas.php" class="ajaxLink">Actualización masiva de costos de receta</a>
                </li> -->
              </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
              <a href="javascript://"><i class="fa fa-cutlery fa-fw"></i> Menú <span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                <li>
                  <a href="menu/view/menu.php" class="ajaxLink">Agregar menu</a>
                </li>
                <?php if( $allowed ): ?>
                <li>
                  <a href="menu/view/eliminarmenu.php" class="ajaxLink">Eliminar menu</a>
                </li>
                <?php endif; ?>
                <li>
                  <a href="menu/view/consultarmenu.php" class="ajaxLink">Consultar menu</a>
                </li>
                <li>
                  <a href="menu/view/modificarmenu.php" class="ajaxLink">Modificar menu</a>
                </li>
                <!-- <li>
                  <a href="menu/view/copiarmenu.php" class="ajaxLink">Copiar de menu</a>
                </li>
                <li>
                  <a href="menu/view/imprimirmenu.php" class="ajaxLink">Imprimir menu</a>
                </li> -->
              </ul>
            </li>
            <!-- Explosion -->
            <li>
              <a href="javascript://"><i class="fa fa-bar-chart-o fa-fw"></i> Explosión de materiales<span class="fa arrow"></span></a>
              <!-- /.nav-second-level -->
              <ul class="nav nav-second-level">
                <li>
                  <a href="explosion/view/generarexplosion.php" class="ajaxLink">Generar explosión</a>
                </li>
                <li>
                    <a href="explosion/view/generarexplosionporlinea.php" class="ajaxLink">Generar explosión por linea</a>
                </li>
                <li>
                  <a href="explosion/view/generarexplosionporproveedor.php" class="ajaxLink">Generar explosión por proveedor</a>
                </li>
                <li>
                  <a href="explosion/view/crearlistadeexedentes.php" class="ajaxLink">Crear lista de excedentes</a>
                </li>
                <li>
                  <a href="explosion/view/creararchivodeexcelparalistadeexcedentes.php" class="ajaxLink">Crear archivos de Excel para lista de Excedentes</a>
                </li>
                <li>
                  <a href="explosion/view/cargarlistadeexedentes.php" class="ajaxLink">Cargar lista de excedentes</a>
                </li>

              </ul>
            </li>

            <li>
              <a href="javascript://"><i class="fa fa-file fa-fw"></i> Minutas<span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                <li>
                  <a href="minutas/view/hojasdeproduccion.php" class="ajaxLink">Hojas de producción</a>
                </li>
                <li>
                  <a href="minutas/view/hojasdeproduccionporunidad.php" class="ajaxLink">Hojas de producción por unidad</a>
                </li>
              </ul>
            </li>
                    
            <li>
              <a href="javascript://"><i class="fa fa-area-chart fa-fw"></i> Órdenes de compra<span class="fa arrow"></span></a>
              <!-- /.nav-second-level -->
              <ul class="nav nav-second-level">
                <li>
                  <a href="OC/view/generaciondeoc.php" class="ajaxLink">Generación de <abbr title="Orden de Compra">OC</abbr></a>
                </li>
                <li>
                  <a href="OC/view/generaciondeocgeneral.php" class="ajaxLink">Generación de <abbr title="Orden de Compra">OC</abbr> General</a>
                </li>
                <li>
                  <a href="OC/view/generaciondereportedecomprasporunidad.php" class="ajaxLink">Generación de materia prima por unidad</a>
                </li>
              </ul>
            </li>

            <li>
              <a href="javascript://"><i class="fa fa-pie-chart fa-fw"></i> <abbr title="Orden de Compra">OC</abbr> con Presentación <span class="fa arrow"></span></a>
              <!-- /.nav-second-level -->
              <ul class="nav nav-second-level">
                <li>
                  <a href="OCP/view/generaciondeoc.php" class="ajaxLink">Generación de <abbr title="Orden de Compra">OC</abbr> con Presentación</a>
                </li>
                <li>
                  <a href="OCP/view/generarOCP.php" class="ajaxLink">Generación de <abbr title="Orden de Compra">OC</abbr> General con Presentación</a>
                </li>
                <li>
                  <a href="OCP/view/updateOCP.php" class="ajaxLink">Modificación de <abbr title="Orden de Compra">OC</abbr> con Presentación</a>
                </li>
                <li>
                  <a href="OCP/view/updateStatusOCP.php" class="ajaxLink">Cambiar Estatus de <abbr title="Orden de Compra">OC</abbr> </a>
                </li>
              </ul>
            </li>

            <li>
              <!-- <a href="#"><i class="fa fa-file-excel-o"></i>Presupuesto de Compras</a> -->
              <a href="compras/view/presupuestodec.php" class="ajaxLink"> <i class="fa fa-file-excel-o"></i> Presupuesto de Compras</a>
                <!-- <ul class="nav nav-second-level"> -->
                <!-- <li>
                  <a href="compras/view/presupuestodec.php" class="ajaxLink">Presupuesto de Compras</a>
                </li> -->
                <!-- <li>
                  <a href="compras/view/compdecomprasyfac.php" class="ajaxLink">Comparativo de Compras vs Facturado</a>
                </li> -->
              <!-- </ul> -->
            </li>
            
            <li>
              <a data-archivo="MenuOCManual.php" data-menu="menu-ocm"> <i class="fa fa-line-chart"></i> OC manual</a>
              <!-- <a href="javascript://"><i class="fa fa-folder-o fa-fw"></i> OC manual<span class="fa arrow"></span></a> -->
              <!-- /.nav-second-level -->
              <!-- <ul class="nav nav-second-level">
                <li>
                  <a href="#" onclick="return false;" id="recetas">Generacion de OC manual</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="recetas">Modificacion de OC manual</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="recetas">Cambio de estatus de OC manual</a>
                </li>
              </ul> -->
            </li>
             
            <li>
              <a href="facturas/view/facturas.php" class="ajaxLink"> <i class="fa fa-money fa-fw"></i> Facturas </a>
              <!-- <a href="javascript://"><i class="fa fa-money fa-fw"></i> Facturas<span class="fa arrow"></span></a> -->
                <!-- /.nav-second-level -->
              <!-- <ul class="nav nav-second-level">
                <li>
                  <a href="#" onclick="return false;" id="recetas">Crear factura a partir de OC</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="modifcarfacturasatravesdeoc">Modificar facturas a traves de OC</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="recetas">Crear facturas a partir de OC</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="modifcarfacturasatravesdeocmanuales">Modificar facturas a traves de OC manuales</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="recetas">Cambiar estatus de facturas</a>
                </li>
                <li>
                  <a href="#" onclick="return false;" id="recetas">Cambiar estatus de factura manual</a>
                </li>
              </ul> -->
            </li>
            
          </ul>
        
        </div>
      </div>
    </nav>

    <div id="page-wrapper">
      <div class="container-fluid mt-20-px" id="contenedor">
        
        <div class="text-center">
          <img src="img/logo.jpg" style="margin-top: 50px; width: 70%;">
        </div>
      
      </div>
    </div>

  </div>
  <!-- endWrapper -->
    
  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/metisMenu.min.js"></script>
  <!-- <script src="js/raphael.min.js"></script> -->
  <script src="js/startmin.js"></script>
  
  <!-- Michael Agrego Sweet Alert y DataTables -->
  <script src="js/moment.js"></script>
  <script src="js/moment.locale.es.js"></script>
  
  <script src="js/DataTables/datatables.min.js"></script>
  
  <script src="js/bootstrap-datepicker-1.9.0/js/bootstrap-datepicker.min.js"></script>
  <script src="js/bootstrap-datepicker-1.9.0/locales/bootstrap-datepicker.es.min.js"></script>
  
  <script src="js/sweetalert2/dist/sweetalert2.all.js"></script>

  <script src="js/perfect-scrollbar-1.4.0/dist/perfect-scrollbar.min.js"></script>

  <!-- custom JS del equipo de desarollo para las redirecciones y funciones globales -->
  <script src="js/custom.js"></script>

  <script type="text/javascript" src=<?php echo $_SESSION['__js_menu__'];?>></script>
  <script type="text/javascript" src="./pages/personal_js/global.js"></script>

  <script>
  // $(document).ready( function(){
    
  //   $("a[data-menu]").click( function(){
  //     cargarMenu($(this).attr("data-menu"), $(this).attr("data-archivo"));
  //   }); //Funcion clic 
  //   // Botones que cargan menu por defecto
  //   $("a[id='GuisoPakLink']").click(function(){
  //     cargarContenido();
  //   });
  //   // Cargar el menu por defecto
  //   // cargarContenido();
  // });

  window.addEventListener('DOMContentLoaded', ()=>{ document.body.style.display = 'block' });
  </script>
<script type="text/javascript" src=<?php echo $_SESSION['__js_del_tab__'];?>></script>
<script type="text/javascript" src=<?php echo $_SESSION['__js_edt_tab__'];?>></script>

</body>
</html>