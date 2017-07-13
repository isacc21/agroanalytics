<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 11:35                                                            #
#                                                                                    #
###### proveedores/index.php #########################################################
#                                                                                    #
# Archivo de Inicio sección acreedores                                               #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 11:35                                                                   #
# IJLM - Se copia CATALOGO de acreedores                                             #
# IJLM - Se realizan los cambios pertinentes a la sección proveedores                #
#                                                                                    #
# 24-FEB-17: 12:00                                                                   #
# IJLM - Se terminó de revisar el correcto funcionamiento de cada elemento           #
#																		                                                 #
# 25-FEB-17: 07:43																                                   # 
# IJLM - Se modificó el formato de fecha de US a MX.                                 #
#                                                                                    #
# 28-FEB-17: 14:05                                                                   #
# IJLM - Se cambiaron los modulos del sidebar                                        #
######################################################################################


###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){

	###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
	include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
	require '../../../models/administracion/proveedores.php';
	require '../../../models/administracion/usuarios.php';

###### CREACION DEL METODO USUARIOS ##################################################
	$proveedores = new proveedores($datosConexionBD);
	$usuarios = new usuarios($datosConexionBD);


###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
	$usuarios->id=$_SESSION['idUsuario'];
	$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
	foreach ($result as $row){
		$permiso = $row['proveedoresPermiso'];
		$acreedores = $row['acreedoresPermiso'];
		$transportistas = $row['transportistasPermiso'];
		$clientes = $row['clientesPermiso'];
		$productos = $row['productosPermiso'];
		$usuarios = $row['usuariosPermiso'];
		$pedidos = $row['pedidosPermiso'];
		$cotizaciones = $row['cotizacionesPermiso'];
		$importaciones = $row['importacionesPermiso'];
		$declaraciones = $row['declaracionesPermiso'];
		$inventario = $row['inventarioPermiso'];
		$carga = $row['cargaPermiso'];
		$compra = $row['compraPermiso'];
		$remisiones = $row['remisionesPermiso'];
		$bancos = $row['bancosPermiso'];
		$cxc = $row['cxcPermiso'];
		$cxp = $row['cxpPermiso'];
		$idUsuario = $row['idUsuario'];
	}## LLAVE DE FOREACH ###############################################################



	###### MODULO DE ADMINISTRACION #####################################################
	$html_inicio_administracion='<li class="nav-item start active open">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="fa fa-building"></i>
		<span class="title">Catálogos</span>
		<span class="selected"></span>
	</a><ul class="sub-menu">';

	$html_final_administracion = '</ul></li>';


	$html_proveedores = '<li class="nav-item active open">
	<a href="../../../views/administracion/proveedores" class="nav-link ">
		<span class="title">1 | Proveedores</span>
	</a></li>';

	$html_acreedores = '<li class="nav-item ">
	<a href="../../../views/administracion/acreedores" class="nav-link ">
		<span class="title">2 | Acreedores</span>
	</a></li>';

	$html_transportistas = '<li class="nav-item  ">
	<a href="../../../views/administracion/transportistas" class="nav-link ">
		<span class="title">3 | Transportistas</span>
	</a></li>';

	$html_clientes= '<li class="nav-item  ">
	<a href="../../../views/administracion/clientes" class="nav-link ">
		<span class="title">5 | Clientes</span>
	</a></li>';

	$html_productos = '<li class="nav-item">
	<a href="../../../views/administracion/productos" class="nav-link ">
		<span class="title">4 | Productos</span>
	</a></li>';


	###### MODULO DE ADMINISTRADOR ###############################################

	$html_inicio_administrador='<li class="nav-item">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="glyphicon glyphicon-eye-open"></i>
		<span class="title">Administrador</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_administrador = '</ul></li>';

	$html_usuarios = '<li class="nav-item">
	<a href="../../../views/administracion/usuarios" class="nav-link ">
		<i class="fa fa-desktop"></i>
		<span class="title">Usuarios</span>
	</a></li>';

	###### MODULO DE ATENCION AL CLIENTE ###############################################

	$html_inicio_atnCliente='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="icon-earphones-alt"></i>
		<span class="title">Atención a Clientes</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_atnCliente='</ul></li>';

	$html_pedidos='<li class="nav-item  ">
	<a href="../../../views/atn-clientes/pedidos" class="nav-link ">
		<span class="title">2 | Pedidos</span>
	</a></li>';

	$html_cotizaciones='<li class="nav-item  ">
	<a href="../../../views/atn-clientes/cotizaciones" class="nav-link ">
		<span class="title">1 | Cotizaciones</span>
	</a></li>';

	###### MODULO DE ADUANAS ###########################################################

	$html_inicio_aduanas='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="fa fa-map-signs"></i>
		<span class="title">Aduanas</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_aduanas='</ul></li>';

	$html_importaciones='<li class="nav-item  ">
	<a href="../../../views/aduanas/importaciones" class="nav-link ">
		<span class="title">1 | Importaciones</span>
	</a></li>';

	$html_declaraciones='<li class="nav-item  ">
	<a href="../../../views/aduanas/declaraciones" class="nav-link ">
		<span class="title">2 | Declaración de Aduanas</span>
	</a></li>';

	###### MODULO DE ALMACEN ###########################################################
	$html_inicio_almacen='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="fa fa-industry"></i>
		<span class="title">Almacén</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_almacen='</ul></li>';

	$html_inventario='<li class="nav-item  ">
	<a href="../../../views/almacen/inventario" class="nav-link ">
		<span class="title">2 | Inventario</span>
	</a></li>';

	$html_compra='<li class="nav-item  ">
	<a href="../../../views/almacen/ordenesCompra" class="nav-link ">
		<span class="title">1 | Órdenes de Compra</span>
	</a></li>';

	$html_carga='<li class="nav-item  ">
	<a href="../../../views/almacen/ordenesCarga" class="nav-link ">
		<span class="title">3 | Órdenes de Carga</span>
	</a></li>';

	$html_remisiones='<li class="nav-item  ">
	<a href="../../../views/almacen/remisiones" class="nav-link ">
		<span class="title">4 | Remisiones</span>
	</a></li>';

	###### MODULO DE CONTABILIDAD ######################################################

	$html_inicio_conta='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="fa fa-money"></i>
		<span class="title">Contabilidad</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_conta='</ul></li>';

	$html_bancos='<li class="nav-item  ">
	<a href="../../../views/contabilidad/bancos" class="nav-link ">
		<span class="title">1 | Bancos</span>
	</a></li>';

	$html_cxc='<li class="nav-item  ">
	<a href="../../../views/contabilidad/cuentasCobrar" class="nav-link ">
		<span class="title">2 | Cuentas por Cobrar</span>
	</a></li>';

	$html_cxp='<li class="nav-item  ">
	<a href="../../../views/contabilidad/cuentasPagar" class="nav-link ">
		<span class="title">3 | Cuentas por Pagar</span>
	</a></li>';

	$html_registro='<div class="col-md-4">
	<div class="mt-widget-3 bg-red">
		<div class="mt-head bg-red">
			<div class="mt-head-icon">
				<i class="icon-user-follow"></i>
			</div>
			<div class="mt-head-desc"> Registrar un nuevo proveedor</div>
			<div class="mt-head-button">
				<button type="button" id="add_prov" class="btn btn-circle btn-outline white btn-sm">Registro</button>
			</div>
		</div>
	</div></div>';

	$html_consulta='<div class="col-md-4">
	<div class="mt-widget-3 bg-blue-hoki">
		<div class="mt-head bg-blue-hoki">
			<div class="mt-head-icon">
				<i class=" icon-users"></i>
			</div>
			<div class="mt-head-desc"> Lista de proveedores registrados</div>
			<div class="mt-head-button">
				<button type="button" id="list_prov" class="btn btn-circle btn-outline white btn-sm">Consultar</button>
			</div>
		</div>
	</div></div>';

	$html_reporte='<div class="col-md-4">
	<div class="mt-widget-3 bg-green">
		<div class="mt-head bg-green">
			<div class="mt-head-icon">
				<i class=" icon-notebook"></i>
			</div>
			<div class="mt-head-desc"> Reporte de proveedores </div>
			<div class="mt-head-button">
				<button type="button" id="rep_prov" class="btn btn-circle btn-outline white btn-sm">Generar</button>
			</div>
		</div>
	</div></div>';
	?>

	<!DOCTYPE html>
	<!--[if IE 8]> <html lang ="en" class="ie8 no-js"> <![endif]-->
	<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
	<!--[if !IE]><!-->
	<html lang ="es">
	<!--<![endif]-->

	<!-- INICIA HEAD -->
	<head>
		<meta charset ="utf-8" />
		<title>Agroanalytics - Proveedores</title>
		<meta http-equiv ="X-UA-Compatible" content="IE=edge">
		<meta content ="width=device-width, initial-scale=1" name="viewport" />
		<meta content ="Dashboard de Agroanalytics, pantalla principal" name="description" />
		<meta content ="IJLM" name="author" />
		<!-- INICIAN ESTILOS -->
		<link href ="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href ="../../../../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href ="../../../../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
		<!-- TERMINAN ESTILOS -->


		<!-- INICIAN PLUGINS NECESARIOS PARA FUNCIONAMIENTO DE COMPONENTES -->
		<link href="../../../../assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="../../../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/layouts/layout/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
		<link href="../../../../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="favicon.ico" /> 
		<!-- TERMINAN PLUGINS NECESARIOS PARA FUNCIONAMIENTO DE COMPONENTES-->
		<script type="text/javascript">
			function ini() {
				stop = setTimeout('location="../../../../index.php"',3600000); // 30 segundos
			}

			function parar() {
				clearTimeout(stop);
				stop = setTimeout('location="../../../../index.php"',3600000); // 30 segundos
			}
		</script>
	</head>
	<!-- TERMINA HEAD-->

	<!--INICIA BODY-->
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white" onmousemove="parar()" onload="ini()" onkeypress="parar()" onclick="parar()">

		<!--INICIA PAGE WRAPPER-->
		<div class="page-wrapper">

			<!--INICIA HEADER-->
			<div class="page-header navbar navbar-fixed-top">

				<!-- INICIA HEADER INNER-->
				<div class="page-header-inner ">

					<!--INICIA LOGO-->
					<div class="page-logo">
						<!-- REDIRECCION AL CLICK LOGO-->
						<a href="index.php">
							<!-- IMAGEN-->
							<img src="../../../../assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" /> </a>
							<div class="menu-toggler sidebar-toggler">
								<span></span>
							</div>
						</div>
						<!-- TERMINA LOGO -->

						<!--INICIA COLPASO DE SIDEBAR-->
						<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
							<span></span>
						</a>
						<!-- TERMINA COLAPSO DE SIDEBAR-->

						<!-- INICIAN ACCIONES DE HEDADER-->
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">

								<!--INICIAN ACCIONES DE ICONO DE USUARIO-->
								<li class="dropdown dropdown-user">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<img alt="" class="img-circle" src="../../../../assets/layouts/layout/img/avatar.png" />
										<span class="username username-hide-on-mobile"><?echo $_SESSION['nombre']." ".$_SESSION['paterno'] ;?></span>
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-default">
										<li>
											<a href="page_user_profile_1.html">
												<i class="icon-user"></i> Mi Perfil </a>
											</li>
											<li class="divider"> </li>
											<li>
												<a href="../../../../index.php?lg=1">
													<i class="icon-key"></i> Log Out </a>
												</li>
											</ul>
										</li>
										<!-- TERMINAN ACCIONES DE ICONO DE USUARIO-->
									</ul>
								</div>
								<!-- TERMINAN ACCIONES DE HEADER -->
							</div>
							<!-- TERMINA HEADER INNER -->
						</div>
						<!-- TERMINA HEADER -->


						<!-- DIVISOR DE HEADER Y CONTENIDO -->
						<div class="clearfix"> </div>


						<!-- INICIA CONTENEDOR -->
						<div class="page-container">


							<!-- INICIA SIDEBAR -->
							<div class="page-sidebar-wrapper">

								<!--INICIA COLPASO DE SIDEBAR-->
								<div class="page-sidebar navbar-collapse collapse">


									<!-- INICIA LISTA DE OBJETOS DE SIDEBAR-->
									<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

										<!--INICIA BOTON PARA COLAPSO DE SIDEBAR-->
										<li class="sidebar-toggler-wrapper hide">
											<div class="sidebar-toggler">
												<span></span>
											</div>
										</li>
										<!-- TERMINA BOTON PARA COLAPSO DE SIDEBAR -->


										<!-- INICIA ELEMENTO DASHBOARD-->
										<li class="nav-item">
											<a href="../../../" class="nav-link nav-toggle">
												<i class="icon-home"></i>
												<span class="title">GOP Score Card</span>
											</a>
										</li>
										<!--TERMINA ELEMENTO DASHBOARD-->

										<!--INICIA MÓDULO DE ADMINISTRACIÓN-->
										<?php
										if($permiso!='0000'||$acreedores!='0000'||$transportistas!='0000'||$clientes!='0000'||$productos!='0000'||$usuarios!='0000'){

											if($usuarios!=='0000'){
												echo $html_inicio_administrador;
												echo $html_usuarios;
												echo $html_final_administrador;
											}

											echo $html_inicio_administracion;
											if($permiso!='0000'){
												echo $html_proveedores;
											}
											if($acreedores!='0000'){
												echo $html_acreedores;
											}
											if($transportistas!='0000'){
												echo $html_transportistas;
											}
											if($productos!='0000'){
												echo $html_productos;
											}
											if($clientes!='0000'){
												echo $html_clientes;
											}
											echo $html_final_administracion;
										}
										?>
										<!--TERMINA MÓDULO DE ADMINISTRACIÓN-->


										<!--INICIA MÓDULO DE ATENCIÓN A CLIENTES-->
										<?php
										if($pedidos!='0000'||$cotizaciones!='0000'){

											echo $html_inicio_atnCliente;
											if($cotizaciones!='0000'){
												echo $html_cotizaciones;
											}
											if($pedidos!='0000'){
												echo $html_pedidos;
											}
											echo $html_final_atnCliente;
										}
										?>
										<!--TERMINA MÓDULO DE ATENCIÓN A CLIENTES-->


										<!--INICIA MÓDULO DE ADUANAS-->
										<?php
										if($importaciones!='0000'||$declaraciones!='0000'){

											echo $html_inicio_aduanas;
											if($importaciones!='0000'){
												echo $html_importaciones;
											}
											if($declaraciones!='0000'){
												echo $html_declaraciones;
											}
											echo $html_final_aduanas;
										}
										?>
										<!--TERMINA MÓDULO DE ADUANAS-->


										<!--INICIA MÓDULO DE ALMACÉN-->
										<?php
										if($inventario!='0000'||$compra!='0000'||$carga!='0000'||$remisiones!='0000'){

											echo $html_inicio_almacen;
											if($compra!='0000'){
												echo $html_compra;
											}
											if($inventario!='0000'){
												echo $html_inventario;
											}
											if($carga!='0000'){
												echo $html_carga;
											}
											if($remisiones!='0000'){
												echo $html_remisiones;
											}
											echo $html_final_almacen;
										}
										?>
										<!--TERMINA MÓDULO DE ALMACÉN-->


										<!--INICIA MÓDULO DE CONTABILIDAD-->
										<?php
										if($bancos!='0000'||$cxc!='0000'||$cxp!='0000'){

											echo $html_inicio_conta;
											if($bancos!='0000'){
												echo $html_bancos;
											}
											if($cxc!='0000'){
												echo $html_cxc;
											}
											if($cxp!='0000'){
												echo $html_cxp;
											}
											echo $html_final_conta;
										}
										?>
										<!--TERMINA MÓDULO DE CONTABILIDAD-->


										<!-- TERMINA COLAPSO DE SIDEBAR MENU -->
									</div>
									<!-- TERMINA SIDEBAR -->
								</div>


								<!-- INICIA CONTENT WRAPPER -->
								<div class="page-content-wrapper">


									<!-- INICIA CONTENIDO -->
									<div class="page-content">

										<!-- INICIA TITULO DE PAGINA-->
										<h1 class="page-title"> Proveedores<br /><small>GO Products S. de R.L de C.V.</small><br /><small><?php echo date(d) ."/". date(m) ."/". date(Y); ?></small></h1>
										<!-- TERMINA TITULO DE PAGINA -->

										<!--INICIA MAIN CONTENT, CONTENEDOR PERSONALIZADO PARA AJAX-->
										<style type="text/css">
											div#mainContent {margin:0}
											body {overflow-x:hidden;}
										</style>

										<div id="mainContent" class="page-container">
											<!--INICIA ROW-->
											<div class="row">

												<!--INICIA CUADRO PARA REGISTRO DE PROVEEDOR-->
												<?php 
												if($permiso[1]=='2'){
													echo $html_registro;
												}
												?>
												<!--TERMINA CUADRO PARA REGISTRO DE PROVEEDOR-->

												<!--INICIA CUADRO PARA LISTA DE PROVEEDORES-->
												<?php 
												if($permiso[0]=='1'||$permiso[2]=='3'||$permiso[3]=='4'){
													echo $html_consulta;
												}
												?>
												<!--TERMINA CUADRO PARA LISTA DE PROVEEDORES-->

												<!--INICIA CUADRO PARA REPORTE DE PROVEEDORES-->
												<?php 
												if($permiso[0]=='1'||$permiso[2]=='3'||$permiso[3]=='4'){
													echo $html_reporte;
												}
												?>
												<!--TERMINA CUADRO PARA REPORTE DE PROVEEDORES-->
											</div>
											<!--TERMINA ROW -->
											


										</div>
										<!--TERMINA MAIN CONTENT, CONTENEDOR PERSONALIZADO PARA AJAX-->
									</div>
									<!-- TERMINA CONTENIDO -->
								</div>
								<!-- TERMINA CONTENT WRAPPER -->


								<!-- INICIA FOOTER -->
								<div class="page-footer">
									<div class="page-footer-inner"> 2017 &copy; Agroanalytics - Admin Dashboard
									</div>
									<div class="scroll-to-top">
										<i class="icon-arrow-up"></i>
									</div>
								</div>
								<!-- TERMINA FOOTER FOOTER -->
							</div>
							<!--TERMINA CONTENIDO-->

		<!--[if lt IE 9]>
<script src="../../../../assets/global/plugins/respond.min.js"></script>
<script src="../../../../assets/global/plugins/excanvas.min.js"></script> 
<script src="../../../../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
<!-- INICIAN SCRIPTS PARA FUNCIONAMIENTO DE COMPONENTES -->
<script src="../../../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/horizontal-timeline/horizontal-timeline.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<script src="../../../../assets/js/menu.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/form-samples.min.js" type="text/javascript"></script>
<script src="../../../../assets/js/envio.js" type="text/javascript"></script>
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<script src="../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>
<!-- TERMINAN SCRITPS PARA FUNCIONAMIENTO DE COMPONENTES-->

</body>
<!--TERMINA BODY-->

</html>
<?php
}else{
	header("LOCATION: ../../../../index.php");
}
?>