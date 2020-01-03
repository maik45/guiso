<?php
session_start();
//verificamos la variable de sessión
//y si la variable de sesión existe incluimos la conexión a la base de datos
//y verificamos que el usaurio exista en la base de datos
if( ! empty( $_SESSION['usuario_comedor'] ) ){
  
  define('KEY', 'JACE');//definimos KEY para acceder al script de la base de datos

  require './db/db.php';//conexion de la base de datos
  $usuario = $_SESSION['usuario_comedor'];
  $r = $db->query("SELECT usuario FROM usuario WHERE usuario = '{$usuario}' LIMIT 1");
  //si no hubo errores en el query
  if( ! $db->error ){
    //verificamos que nos retorne un registro
    if( $r->num_rows ){
      //si lo retorna lo redireccionamos al index
      header('location: ./');
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>GuisoPak - Sistema de Comedores</title>

        <!-- Bootstrap Core CSS -->
        <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="./css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="./css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="./css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link rel="stylesheet" href="css/custom.css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading" style="background-color: #EE7561;">
                            <h3 class="panel-title text-center" style="color: #FFFFFF; font-weight: bold">Ingrese usuario y contraseña</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="#" method="POST" name="form_login" id="form_login">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control input-lg" placeholder="ingrese su usuario" name="usuario" type="text" autofocus required />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control input-lg" placeholder="Ingrese su contraseña" name="password" type="password" required>
                                    </div>
                                    <!-- <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Recordar correo
                                        </label>
                                    </div> -->
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input class="btn btn-lg btn-success btn-block" type="submit" style="color: #337ab7; background-color: #FFFFFF" value="Entrar">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery -->
        <script src="./js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="./js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="./js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="./js/startmin.js"></script>


        <script src="js/sweetalert2/dist/sweetalert2.all.js"></script>

        <script src="./js/login.js"></script>

    </body>
</html>