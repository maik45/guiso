<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css'>
    <link rel="stylesheet" href="../css/calendar.css">

		<title>GuisoPak</title>

		<!-- Bootstrap Core CSS -->
		<link href="../css/bootstrap.min.css" rel="stylesheet">

		<!-- MetisMenu CSS -->
		<link href="../css/metisMenu.min.css" rel="stylesheet">

		<!-- Custom CSS -->
		<link href="../css/startmin.css" rel="stylesheet">

		<!-- Custom Fonts -->
		<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

		<style type="text/css">

			div.panel-default{
				background-color: #fefefe;
				/*border: 0.25em solid orange;*/
				min-height: 43em;
				margin: 0;
				padding: 0.25em;
			}

			div.panel-default > div.panel-heading{
				/*background-color: inherit;*/
				/*border: 0.25em solid blue;*/
				background-color: inherit;
				border: none;
				padding: 0.25em;
			}

			div.panel-default h4{
				background-color: inherit;
				color: #23527c;
				margin: 0;
				padding-bottom: 0.5em;
				text-align: left;
			}

			div.panel-default .form-control{
				height: 1.25em;
				padding: 0;
			}

			table.table-hover tr:hover{
				background-color: #dddddd;
			}

			table.table tbody > tr.elegido, table.table tbody > tr.elegido:nth-child(odd){
				background-color: #ffb3b3;
			}

			table.table{
				margin: 0;
			}

			table.table > thead > tr > th, table.table > tbody > tr > td{
				border-bottom-width: 0.125em;
				padding: 0.125em 0.5em;
				white-space: nowrap;
				width: 15em;
				text-align: center;
			}

			div.td_data{
				height: 1.25em;
			}

			.div-input-focus{
				background-color: #fefefe;
				border-color: orange;
				color: #000000;
			}

			div.panel-default table{
				color: #23527c;
			}

			div.panel-default h5{
				color: #23527c;
				margin: 0.25em;
			}

			div.panel-default label{
				color: #23527c;
				font-size: small;
			}

			div[class*="col"] > div.row{
				margin: 0;
			}

			div.panel-default > div.panel-body{
				/*border: 0.25em solid black;*/
				height: 80%;
				padding: 0em 0.25em;
			}

			div.panel-body > ul.nav-tabs{
				background-color: #ff3300;
			}

			div.panel-body > ul.nav-tabs li{
				/*border: 0.25em solid yellow;*/
				border: none;
				padding: 0;
			}

			div.panel-body > ul.nav-tabs li.active a{
				background-color: #e62e00;
			}

			div.panel > div.panel-body > ul.nav-tabs a{
				/*border: 0.25em solid black;*/
				color: #fefefe;
				cursor: pointer;
				display: block;
				font-size: normal;
				margin: 0;
				overflow: hidden;
				padding: 0.25em 0.3em;
				text-overflow: ellipsis;
				width: 100%;
			}

			div.panel > div.panel-body > ul.nav-tabs a:hover{
				background-color: #e62e00;
			}

			/*
			div.panel > div.panel-body > ul.nav-tabs a.active{
				border: 0.25em solid #ff6600;
				border-bottom: none;
			}*/

			div.panel-body > div.tab-content{
				/*border: 0.25em solid green;*/
				/*border-bottom: 0.25em solid #23527c;*/
				height: 32em;
				overflow-x: hidden;
				overflow-y: auto;
				padding: 0.25em;
			}

			form.mini-form{
				padding:10em 5em;
			}

			form.mini-form label{
				font-size: normal;
			}

			div.form-group{
				margin: 0;
			}


			div.panel-default > div.panel-footer{
				/*border: 0.25em solid red;*/
				border: none;
				padding: 0.25em;
			}

			.container-fluid{
				background-color: transparent;
				padding-top: 3em;
			}

			nav.navbar-blue div.navbar-header a, nav.navbar-blue ul.navbar-top-links a{
				color: #fdfdfd;
			}

			.navbar-top-links > li.navbar-blue > a:focus{
				background-color: #23527c;
			}

			nav.navbar-blue{
				background-color: #23527c;
				border: none;
				color: #fdfdfd;
			}

			@media only screen and (max-width: 1280px){
				.nav-tabs > li{
					display: block;
					width: 50%;
				}

				div.panel > div.panel-body > ul.nav-tabs a{
					background-color: none;
					/*border-bottom: 0.25em solid #23527c;*/
					cursor: pointer;
					display: inline;
					font-size: small;
					margin: 0;
					overflow: hidden;
					padding: 0;
					/*text-align: center;*/
					text-overflow: ellipsis;
				}

				div.panel > div.panel-body div.form-group label{
					color: #23527c;
					cursor: default;
					font-size: small;
					margin: 0;
					padding: 0;
				}
			}
		</style>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<script type="text/javascript" src="../js/personal_js/global.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<!-- Navigation -->
			<nav class="navbar navbar-blue navbar-fixed-top" role="navigation">
				<div class="navbar-header">
								<a class="navbar-brand" href="#" id="GuisoPakLink">GuisoPak</a>
				</div>

				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<ul class="nav navbar-nav navbar-left navbar-top-links">
					<li><a href="#"><i class="fa fa-home fa-fw"></i> Website</a></li>
				</ul>

				<ul class="nav navbar-right navbar-top-links">
					<li class="dropdown navbar-blue">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-alerts">
							<li>
								<a href="#">
									<div>
										<i class="fa fa-comment fa-fw"></i> New Comment
										<span class="pull-right text-muted small">4 minutes ago</span>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<div>
										<i class="fa fa-twitter fa-fw"></i> 3 New Followers
										<span class="pull-right text-muted small">12 minutes ago</span>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<div>
										<i class="fa fa-envelope fa-fw"></i> Message Sent
										<span class="pull-right text-muted small">4 minutes ago</span>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<div>
										<i class="fa fa-tasks fa-fw"></i> New Task
										<span class="pull-right text-muted small">4 minutes ago</span>
									</div>
								</a>
							</li>
							<li>
								<a href="#">
									<div>
										<i class="fa fa-upload fa-fw"></i> Server Rebooted
										<span class="pull-right text-muted small">4 minutes ago</span>
									</div>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a class="text-center" href="#">
									<strong>See All Alerts</strong>
									<i class="fa fa-angle-right"></i>
								</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
							</li>
							<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
							</li>
							<li class="divider"></li>
							<li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
							</li>
						</ul>
					</li>
				</ul>
				<!-- /.navbar-top-links -->

				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<ul class="nav" id="side-menu">
							<li>
								<a href="#"><i class="fa fa-sitemap fa-fw"></i> Catálogo<span class="fa arrow"></span></a>
								<ul class="nav nav-second-level">
									<li>
										<a data-archivo="MenuProveedor.php" data-menu="menu-proveedor">Proveedores<span class="fa arrow"></span></a>
									</li>
									<li>
										<a data-archivo="MenuClientes.php" data-menu="menu-cliente">Clientes<span class="fa arrow"></span></a>
									</li>
									<li>
										<a data-archivo="MenuLinea.php" data-menu="menu-linea">Líneas<span class="fa arrow"></span></a>
									</li>
									<li>
										<a data-archivo="MenuGrupos.php" data-menu="menu-grupo">Grupos<span class="fa arrow"></span></a>
									</li>
									<li>
										<a data-archivo="MenuBases.php" data-menu="menu-base">Bases<span class="fa arrow"></span></a>
									</li>
								</ul>
								<!-- /.nav-second-level -->
							</li>
							<li>
								<a data-archivo="MenuCompras.php" data-menu="menu-compra"><i class="fa fa-sitemap fa-fw"></i>Compras<span class="fa arrow"></span></a>
							</li>
							<li>
								<a data-archivo="MenuOCManual.php" data-menu="menu-ocmanual"><i class="fa fa-sitemap fa-fw"></i>OC Manual<span class="fa arrow"></span></a>
							</li>
							<li>
								<a data-archivo="MenuOCPresentacion.php" data-menu="menu-ocpresentacion"><i class="fa fa-sitemap fa-fw"></i>OC presentación<span class="fa arrow"></span></a>
							</li>
							<li>
								<a data-archivo="MenuFactura.php" data-menu="menu-factura"><i class="fa fa-sitemap fa-fw"></i>Factura<span class="fa arrow"></span></a>
							</li>
						</ul>
					</div>
					<!-- /.sidebar-collapse -->
				</div>
				<!-- /.navbar-static-side -->
			</nav>

			<div id="page-wrapper">
				<div class="container-fluid">

					<div class="row" id="row-1">
						<div class="col-lg-12" data-menu-actual="" id="row-1-contenedor">
						</div>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.container-fluid -->
			</div>
			<!-- /#page-wrapper -->
		</div>
		<!-- /#wrapper -->

								<!-- jQuery -->
								<script src="../js/jquery.min.js"></script>

								<!-- Bootstrap Core JavaScript -->
								<script src="../js/bootstrap.min.js"></script>

								<!-- Metis Menu Plugin JavaScript -->
								<script src="../js/metisMenu.min.js"></script>

								<!-- Custom Theme JavaScript -->
								<script src="../js/startmin.js"></script>

			<script>
				$(document).ready( function()
				{
					// $("a[data-menu]").css("background-color", "yellow");
					$("a[data-menu]").click( function(){
						cargarMenu($(this).attr("data-menu"), $(this).attr("data-archivo"));
					});	//Funcion clic

								// Botones que cargan menu por defecto
								$("a[id='GuisoPakLink']").click(function()
								{
									cargarContenido();
								});


								// Cargar el menu por defecto
								cargarContenido();


						});
		</script>


	</body>
</html>
