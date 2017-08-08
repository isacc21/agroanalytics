<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 14 Febrero 2017 : 10:00                                                            #
#                                                                                    #
###### app/index.php #################################################################
#                                                                                    #
# Archivo de inicio posterior al inicio de sesión                                    #
# Dashboard                                                                          #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 14-FEB-17: 10:03                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#																					                                           #
# 14-FEB-17: 10:25                                                                   #
# IJLM - Revisión de código de plantilla hasta HEADER                                #
#																					                                           #
# 15-FEB-17: 19:59																                                   #
# IJLM - Se agregaron los módulos de Administración, Contabilidad y Almacén.         #
#																		                                                 #
# 16-FEB-17: 12:57																                                   # 
# IJLM - Se agregaron los módulos de Aduanas y Atención a Clientes.                  #
#																		                                                 #
# 25-FEB-17: 07:41																                                   # 
# IJLM - Se modificó el formato de fecha de US a MX.                                 #
#                                                                                    #
# 04-MAR-17: 20:32                                                                   #
# IJLM - Se agrega un session_start() para confirmar el inicio de sesión             #
# IJLM - Se agrega una condicional para confirmar el inicio de sesión                #
# IJLM - Se agrega Else en caso de no iniciar sesión, mandar al login                #
######################################################################################

###### SE CONFIGURA ZONA HORARIA #####################################################
date_default_timezone_set('America/Tijuana');

###### SE CONFIGURA UN INICIA DE SESION ##############################################
session_start();

###### EN CASO DE QUE HAYA UN LOGIN ACTIVO SE EJECUTA EL CODIGO HTML #################
if(isset($_SESSION['login'])){



###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
	include '../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
	require 'models/administracion/usuarios.php';
	require 'models/atn-cliente/cotizaciones.php';


###### CREACION DEL METODO USUARIOS ##################################################
	$usuarios = new usuarios($datosConexionBD);
	$usuarios->id=$_SESSION['idUsuario'];
	$active = $usuarios->activarSesion();

	if($active = "Sesión activa"){
		$prueba = $active;
	}

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
	$usuarios->id=$_SESSION['idUsuario'];
	$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
	foreach ($result as $row){
		$proveedores = $row['proveedoresPermiso'];
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
	$html_inicio_administracion='<li class="nav-item">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="icon-folder-alt"></i>
		<span class="title">Catálogos</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_administracion = '</ul></li>';


	$html_proveedores = '<li class="nav-item  ">
	<a href="views/administracion/proveedores" class="nav-link ">
		
		<span class="title">1 | Proveedores</span>
	</a></li>';

	$html_acreedores = '<li class="nav-item ">
	<a href="views/administracion/acreedores" class="nav-link ">
		
		<span class="title">2 | Acreedores</span>
	</a></li>';

	$html_transportistas = '<li class="nav-item  ">
	<a href="views/administracion/transportistas" class="nav-link ">
		
		<span class="title">3 | Transportistas</span>
	</a></li>';

	$html_clientes= '<li class="nav-item  ">
	<a href="views/administracion/clientes" class="nav-link ">
		
		<span class="title">5 | Clientes</span>
	</a></li>';

	$html_productos = '<li class="nav-item">
	<a href="views/administracion/productos" class="nav-link ">
		
		<span class="title">4 | Productos</span>
	</a></li>';

	###### MODULO DE ADMINISTRADOR ###############################################

	$html_inicio_administrador='<li class="nav-item">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="icon-settings"></i>
		<span class="title">Administrador</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_administrador = '</ul></li>';

	$html_usuarios = '<li class="nav-item ">
	<a href="views/administracion/usuarios" class="nav-link ">
		<i class="fa fa-user-plus"></i>
		<span class="title"> Usuarios</span>
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
	<a href="views/atn-clientes/pedidos" class="nav-link ">
		
		<span class="title">2 | Pedidos</span>
	</a></li>';

	$html_cotizaciones='<li class="nav-item  ">
	<a href="views/atn-clientes/cotizaciones" class="nav-link ">
		
		<span class="title">1 | Cotizaciones</span>
	</a></li>';

	###### MODULO DE COMPRAS ###############################################

	$html_inicio_compras='<li class="nav-item">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="icon-basket"></i>
		<span class="title">Compras</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_compras = '</ul></li>';

	$html_compra='<li class="nav-item  ">
	<a href="views/almacen/ordenesCompra" class="nav-link ">
		<span class="title">1 | Órdenes de Compra</span>
	</a></li>';


	###### MODULO DE ADUANAS ###########################################################

	$html_inicio_aduanas='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="fa fa-truck"></i>
		<span class="title">Aduanas</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_aduanas='</ul></li>';

	$html_importaciones='<li class="nav-item  ">
	<a href="views/aduanas/importaciones" class="nav-link ">
		
		<span class="title">1 | Importaciones</span>
	</a></li>';

	$html_declaraciones='<li class="nav-item  ">
	<a href="views/aduanas/declaraciones" class="nav-link ">
		
		<span class="title">2 | Declaración de Aduanas</span>
	</a></li>';

	###### MODULO DE ALMACEN ###########################################################
	$html_inicio_almacen='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="icon-social-dropbox"></i>
		<span class="title">Almacén</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_almacen='</ul></li>';

	$html_inventario='<li class="nav-item  ">
	<a href="views/almacen/inventario" class="nav-link ">
		
		<span class="title">1 | Inventario</span>
	</a></li>';

	$html_carga='<li class="nav-item  ">
	<a href="views/almacen/ordenesCarga" class="nav-link ">
		
		<span class="title">2 | Órdenes de Carga</span>
	</a></li>';

	$html_remisiones='<li class="nav-item  ">
	<a href="views/almacen/remisiones" class="nav-link ">
		
		<span class="title">3 | Remisiones</span>
	</a></li>';

	###### MODULO DE CONTABILIDAD ######################################################

	$html_inicio_conta='<li class="nav-item  ">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="glyphicon glyphicon-usd"></i>
		<span class="title">Contabilidad</span>
		<span class="arrow"></span>
	</a><ul class="sub-menu">';

	$html_final_conta='</ul></li>';

	$html_bancos='<li class="nav-item  ">
	<a href="views/contabilidad/bancos" class="nav-link ">
		
		<span class="title">1 | Bancos</span>
	</a></li>';

	$html_cxc='<li class="nav-item  ">
	<a href="views/contabilidad/cuentasCobrar" class="nav-link ">
		
		<span class="title">2 | Cuentas por Cobrar</span>
	</a></li>';

	$html_cxp='<li class="nav-item  ">
	<a href="views/contabilidad/cuentasPagar" class="nav-link ">
		
		<span class="title">3 | Cuentas por Pagar</span>
	</a></li>';
	?>

	<!DOCTYPE html>
	<!--[if IE 8]> <html lang ="en" class="ie8 no-js"> <![endif]-->
	<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
	<!--[if !IE]><!-->
	<html lang="es">
	<!--<![endif]-->

	<!-- BEGIN HEAD -->
	<head>
		<meta charset="utf-8" />
		<title>Agroanalytics - Dashboard</title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1" name="viewport" />
		<meta content="Dashboard de Agroanalytics, pantalla principal" name="description" />
		<meta content="IJLM" name="author" />
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
		<!-- END GLOBAL MANDATORY STYLES -->
		<!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />
		<!-- END PAGE LEVEL PLUGINS -->
		<!-- BEGIN THEME GLOBAL STYLES -->
		<link href="../assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
		<link href="../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		<!-- END THEME GLOBAL STYLES -->
		<!-- BEGIN THEME LAYOUT STYLES -->
		<link href="../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/layouts/layout/css/themes/grey.min.css" rel="stylesheet" type="text/css" id="style_color" />
		<link href="../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
		<link href="../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
		<!-- END THEME LAYOUT STYLES -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>




		<!-- Resources -->
		<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
		<script src="https://www.amcharts.com/lib/3/pie.js"></script>
		<script src="https://www.amcharts.com/lib/3/serial.js"></script>
		<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
		<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
		<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
		<script src="https://www.amcharts.com/lib/3/themes/dark.js"></script>
		<link rel="shortcut icon" href="favicon.ico" /> 

		<script type="text/javascript">
			function ini() {
				stop = setTimeout('location="../index.php"',3600000); // 30 segundos
			}

			function parar() {
				clearTimeout(stop);
				stop = setTimeout('location="../index.php"',3600000); // 30 segundos
			}
		</script>


		

	</head>
	<!-- END HEAD -->

	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white" id="principal" onmousemove="parar()" onload="ini()" onkeypress="parar()" onclick="parar()">
		<div class="page-wrapper">
			<!-- BEGIN HEADER -->
			<div class="page-header navbar navbar-fixed-top">
				<!-- BEGIN HEADER INNER -->
				<div class="page-header-inner ">
					<!-- BEGIN LOGO -->
					<div class="page-logo">
						<a href="index.php">
							<img src="../assets/img/agroanalytics_logo.png" alt="logo" class="logo-default" /> </a>
							<div class="menu-toggler sidebar-toggler">
								<span></span>
							</div>
						</div>
						<!-- END LOGO -->
						<!-- BEGIN RESPONSIVE MENU TOGGLER -->
						<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
							<span></span>
						</a>
						<!-- END RESPONSIVE MENU TOGGLER -->
						<!-- BEGIN TOP NAVIGATION MENU -->
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">
								<!-- BEGIN USER LOGIN DROPDOWN -->
								<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
								<li class="dropdown dropdown-user">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<img alt="" class="img-circle" src="../assets/layouts/layout/img/avatar.png" />
										<span class="username username-hide-on-mobile"><?echo $_SESSION['nombre']." ".$_SESSION['paterno'] ;?></span>
										<i class="fa fa-angle-down"></i>
									</a>
									<ul class="dropdown-menu dropdown-menu-default">
										<li>
											<a href="views/profile/info">
												<i class="icon-user"></i> Mi Perfil </a>
											</li>
											<li class="divider"> </li>
											<li>
												<a href="../index.php?lg=1">
													<i class="icon-key"></i> Log Out </a>
												</li>
											</ul>
										</li>
										<!-- END USER LOGIN DROPDOWN -->
									</ul>
								</div>
								<!-- END TOP NAVIGATION MENU -->
							</div>
							<!-- END HEADER INNER -->
						</div>
						<!-- END HEADER -->




						<!--REVISADO HASTA ESTE PUNTO - **HEADER**-->



						<!-- BEGIN HEADER & CONTENT DIVIDER -->
						<div class="clearfix"> </div>
						<!-- END HEADER & CONTENT DIVIDER -->
						<!-- BEGIN CONTAINER -->
						<div class="page-container">
							<!-- BEGIN SIDEBAR -->
							<div class="page-sidebar-wrapper">
								<!-- BEGIN SIDEBAR -->
								<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
								<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
								<div class="page-sidebar navbar-collapse collapse">
									<!-- BEGIN SIDEBAR MENU -->
									<!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
									<!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
									<!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
									<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
									<!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
									<!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
									<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
										<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
										<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
										<li class="sidebar-toggler-wrapper hide">
											<div class="sidebar-toggler">
												<span></span>
											</div>
										</li>
										<!-- END SIDEBAR TOGGLER BUTTON -->

										<li class="nav-item start active open">
											<a href="../app" class="nav-link nav-toggle">
												<i class="icon-home"></i>
												<span class="title">GOP Scorecard</span>
												<span class="selected"></span>
											</a>
										</li>
										<!--INICIA MÓDULO DE ADMINISTRACIÓN-->
										<?php

										if($proveedores!='0000'||$acreedores!='0000'||$transportistas!='0000'||$clientes!='0000'||$productos!='0000'||$usuarios!='0000'){

											
											if($usuarios!=='0000'){
												echo $html_inicio_administrador;
												echo $html_usuarios;
												echo $html_final_administrador;
											}
											

											echo $html_inicio_administracion;
											if($proveedores!='0000'){
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

										<!-- INICIA MODULO DE COMPRAS -->
										<?php 

										if($compra!='0000'){
											echo $html_inicio_compras;
											echo $html_compra;
											echo $html_final_compras;
										}

										?>
										<!-- TERMINA MODULO DE COMPRAS -->

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
										if($inventario!='0000'||$carga!='0000'||$remisiones!='0000'){

											echo $html_inicio_almacen;
											
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
										<!-- END SIDEBAR MENU -->
										<!-- END SIDEBAR MENU -->
									</div>
									<!-- END SIDEBAR -->
								</div>
								<!-- END SIDEBAR -->
								<!-- BEGIN CONTENT -->
								<div class="page-content-wrapper">
									<!-- BEGIN CONTENT BODY -->
									<div class="page-content">
										<!-- BEGIN PAGE HEADER-->

										<!-- BEGIN PAGE TITLE-->
										<h1 class="page-title"> GOP Scorecard<br /><small>GO Products S. de R.L de C.V.</small><br /><small><?php echo date(d) ."/". date(m) ."/". date(Y); ?></small></h1>
										<!-- END PAGE TITLE-->
										<!-- END PAGE HEADER-->
										<?php
###### ESTE ES UN EJEMPLO PARA EL USO DE FECHA PARA PENDIENTES SEMANALES #############
											/*echo date("jS F, Y", strtotime("-4 days")) . "<br>";
											$fecha = "14-03-2017";
											$fecha2 =  date( "d-m-Y", strtotime( " $fecha +30 days" ) );

											$hoy =  date("d-m-Y");

											if($fecha2 == $hoy){
												echo "hola";
											}
											else{
												echo "error";
											}*/

											?>
											<div id="mainContent">
												<div class="row">

													<div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
														<a class="dashboard-stat dashboard-stat-v2 purple-soft" href="views/atn-clientes/pedidos">
															<div class="visual">
																<i class="fa fa-credit-card"></i>
															</div>
															<div class="details">
																<div class="number">
																	$<span data-counter="counterup" data-value="86,039.53">0</span>&nbsp;USD
																</div>
																<div class="desc"> Monthly Sales </div>
															</div>
														</a>
													</div>

													<div class="col-lg-6 col-md-3 col-sm-6 col-xs-12">
														<a class="dashboard-stat dashboard-stat-v2 green-seagreen" href="views/aduanas/importaciones">
															<div class="visual">
																<i class="fa fa-truck"></i>
															</div>
															<div class="details">
																<div class="number">
																	$<span data-counter="counterup" data-value="72,850.53">0</span>&nbsp;USD
																</div>
																<div class="desc"> Monthly Imports </div>
															</div>
														</a>
													</div>

												</div>


												<div class="clearfix"></div>
												<div class="row">
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<a class="dashboard-stat dashboard-stat-v2 green-jungle" href="views/contabilidad/bancos">
															<div class="visual">
																<i class="fa fa-money"></i>
															</div>
															<div class="details">
																<div class="number">
																	$<span data-counter="counterup" data-value="8,457">0</span>
																</div>
																<div class="desc"> USD </div>
															</div>
														</a>
													</div>

													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<a class="dashboard-stat dashboard-stat-v2 green-soft" href="views/contabilidad/bancos">
															<div class="visual">
																<i class="fa fa-usd"></i>
															</div>
															<div class="details">
																<div class="number">
																	$<span data-counter="counterup" data-value="5,213">0</span>&nbsp;
																</div>
																<div class="desc"> MXN </div>
															</div>
														</a>
													</div>

													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<a class="dashboard-stat dashboard-stat-v2 blue-sharp" href="views/contabilidad/cuentasCobrar">
															<div class="visual">
																<i class="fa fa-arrow-down"></i>
															</div>
															<div class="details">
																<div class="number">
																	$<span data-counter="counterup" data-value="7,748">0</span>&nbsp;USD
																</div>
																<div class="desc"> Accounts receivable </div>
															</div>
														</a>
													</div>

													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
														<a class="dashboard-stat dashboard-stat-v2 red-soft" href="views/contabilidad/cuentasPagar">
															<div class="visual">
																<i class="fa fa-arrow-up"></i>
															</div>
															<div class="details">
																<div class="number">
																	$<span data-counter="counterup" data-value="2,574">0</span>&nbsp;USD
																</div>
																<div class="desc"> Accounts payable </div>
															</div>
														</a>
													</div>
												</div>


												<div class="clearfix"></div>

												<div class="row">

													<!-- Chart code -->
													<script>
														var chart = AmCharts.makeChart( "import_products", {
															"type": "pie",
															"theme": "light",
															"dataProvider": [ {
																"product": "Humega",
																"usd": 3179.20
															}, {
																"product": "IsoGreen",
																"usd": 9808.80
															}, {
																"product": "Fulvex",
																"usd": 5382.00
															}, {
																"product": "GO Isolates",
																"usd": 7334.64
															}, {
																"product": "Dry Crumbles",
																"usd": 976.27
															}],
															"valueField": "usd",
															"titleField": "product",
															"balloon":{
																"fixedPosition":true
															},

														} );
													</script>

													<!-- HTML -->
													<div class="col-lg-6 col-xs-12 col-sm-12">
														<style>
															#custom_broker {
																width		: 100%;
																height		: 300px;
																font-size	: 11px;
															}					
														</style>


														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Imports by Product</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="import_products" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>



													<script>
														var chart = AmCharts.makeChart( "custom_broker", {
															"type": "serial",
															"theme": "light",
															"dataProvider": [ {
																"product": "SAI",
																"sales": 38618.55
															}, {
																"product": "Ibarrola",
																"sales": 34231.98
															}],
															"valueAxes": [ {
																"gridColor": "#FFFFFF",
																"gridAlpha": 0.2,
																"dashLength": 0
															} ],
															"gridAboveGraphs": true,
															"startDuration": 1,
															"graphs": [ {
																"balloonText": "[[category]]: <b>$[[value]]</b>",
																"fillAlphas": 0.8,
																"lineAlpha": 0.2,
																"type": "column",
																"valueField": "sales"
															} ],
															"chartCursor": {
																"categoryBalloonEnabled": false,
																"cursorAlpha": 0,
																"zoomable": false
															},
															"categoryField": "product",
															"categoryAxis": {
																"autoGridCount": false,
																"gridPosition": "start",
																"gridAlpha": 0,
																"tickPosition": "start",
																"tickLength": 20
															},
															"export": {
																"enabled": true
															}

														} );
													</script>


													<!-- HTML -->
													<div class="col-lg-6 col-xs-12 col-sm-12">


														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Imports by Custom Broker</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="custom_broker" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>

												</div>
												<div class="clearfix"></div>

												<div class="row">


													<script>
														var chart = AmCharts.makeChart( "expenses", {
															"type": "serial",
															"theme": "light",
															"dataProvider": [ {
																"detail": "Custom Broker",
																"sales": 2093.94
															}, {
																"detail": "Border Freight",
																"sales": 633.05
															}, {
																"detail": "Freight",
																"sales": 12874.05
															}],
															"valueAxes": [ {
																"gridColor": "#FFFFFF",
																"gridAlpha": 0.2,
																"dashLength": 0
															} ],
															"gridAboveGraphs": true,
															"startDuration": 1,
															"graphs": [ {
																"balloonText": "[[category]]: <b>$[[value]]</b>",
																"fillAlphas": 0.8,
																"lineAlpha": 0.2,
																"type": "column",
																"valueField": "sales"
															} ],
															"chartCursor": {
																"categoryBalloonEnabled": false,
																"cursorAlpha": 0,
																"zoomable": false
															},
															"categoryField": "detail",
															"categoryAxis": {
																"autoGridCount": false,
																"gridPosition": "start",
																"gridAlpha": 0,
																"tickPosition": "start",
																"tickLength": 20
															},
															"export": {
																"enabled": true
															}

														} );
													</script>


													<!-- HTML -->
													<div class="col-lg-6 col-xs-12 col-sm-12">


														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Imports Expense</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="expenses" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>
													<!--END COL MD 6-->

													<!-- Chart code -->
													<script>
														var chart = AmCharts.makeChart( "sales_dc", {
															"type": "pie",
															"theme": "light",
															"dataProvider": [ {
																"directc": "V. Alta",
																"usd": 0
															}, {
																"directc": "V. Prima",
																"usd": 0
															}, {
																"directc": "Pozo Manuel",
																"usd": 0
															}, {
																"directc": "M. Bísani",
																"usd": 30658.50
															}, {
																"directc": "Las Cumbres",
																"usd": 31602.00
															}, {
																"directc": "25 Enero",
																"usd": 2898.00
															}, {
																"directc": "AgroSierraVista",
																"usd": 14420.85
															}, {
																"directc": "Altima",
																"usd": 0
															}],
															"valueField": "usd",
															"titleField": "directc",
															"balloon":{
																"fixedPosition":true
															},

														} );
													</script>

													<!-- HTML -->
													<div class="col-lg-6 col-xs-12 col-sm-12">
														<style>
															#sales_dc {
																width		: 100%;
																height		: 300px;
																font-size	: 11px;
															}					
														</style>


														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Sales by Direct Customer</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="sales_dc" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>

												</div>

												<div class="clearfix"></div>
												<!--BEGIN ROW-->
												<div class="row">
													<script>
														var chart = AmCharts.makeChart( "sales_dis", {
															"type": "pie",
															"theme": "light",
															"dataProvider": [ {
																"distri": "AGRICOM",
																"usd": 5435.10
															}, {
																"distri": "EMSA",
																"usd": 1025.08
															}],
															"valueField": "usd",
															"titleField": "distri",
															"balloon":{
																"fixedPosition":true
															},

														} );
													</script>

													<!-- HTML -->
													<div class="col-lg-6 col-xs-12 col-sm-12">



														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Sales by Distributor</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="sales_dis" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>

													<script>
														var chart = AmCharts.makeChart( "sales_pr", {
															"type": "serial",
															"theme": "light",
															"dataProvider": [{
																"product": "Humega",
																"sales": 32886.00
															}, {
																"product": "IsoGreen",
																"sales": 34500.00
															}, {
																"product": "Fulvex",
																"sales": 3207.60
															}, {
																"product": "Go Isolates",
																"sales": 14420.85
															}, {
																"product": "Dry Crumbles",
																"sales": 1025.08
															}],
															"valueAxes": [ {
																"gridColor": "#FFFFFF",
																"gridAlpha": 0.2,
																"dashLength": 0
															} ],
															"gridAboveGraphs": true,
															"startDuration": 1,
															"graphs": [ {
																"balloonText": "[[category]]: <b>$[[value]]</b>",
																"fillAlphas": 0.8,
																"lineAlpha": 0.2,
																"type": "column",
																"valueField": "sales"
															} ],
															"chartCursor": {
																"categoryBalloonEnabled": false,
																"cursorAlpha": 0,
																"zoomable": false
															},
															"categoryField": "product",
															"categoryAxis": {
																"autoGridCount": false,
																"gridPosition": "start",
																"gridAlpha": 0,
																"tickPosition": "start",
																"tickLength": 20
															},
															"export": {
																"enabled": true
															}

														} );
													</script>


													<!-- HTML -->
													<div class="col-lg-6 col-xs-12 col-sm-12">


														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Imports Expense</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="sales_pr" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>
													<!--END COL MD 6-->
												</div>
												<!--END ROW-->
												<div class="clearfix"></div>

												<div class="row">
													<script>
														var chart = AmCharts.makeChart( "meses", {
															"type": "serial",
															"addClassNames": true,
															"theme": "light",
															"autoMargins": true,
															"marginLeft": 30,
															"marginRight": 8,
															"marginTop": 10,
															"marginBottom": 26,
															"balloon": {
																"adjustBorderColor": false,
																"horizontalPadding": 10,
																"verticalPadding": 8,
																"color": "#ffffff"
															},

															"dataProvider": [ {
																"mes": "Enero",
																"presente": 25504.02,
																"pasado": 28741.15
															}, {
																"mes": "Febrero",
																"presente": 31486.25,
																"pasado": 21203.00
															}, {
																"mes": "Marzo",
																"presente": 14257.02,
																"pasado": 14200.51
															}, {
																"mes": "Abril",
																"presente": 45781.94,
																"pasado": 25149.14
															}, {
																"mes": "Mayo",
																"presente": 38215.94,
																"pasado": 27749.41
															}, {
																"mes": "Junio",
																"presente": 24152.52,
																"pasado": 47824.65
															}, {
																"mes": "Julio",
																"presente": 12000.93,
																"pasado": 17000.39
															}, {
																"mes": "Agosto",
																"presente": 11021.98,
																"pasado": 3147.45
															}, {
																"mes": "Septiembre",
																"presente": 52135.21,
																"pasado": 41002.21
															}, {
																"mes": "Octubre",
																"presente": 62478.94,
																"pasado": 55215.14
															}, {
																"mes": "Noviembre",
																"presente": 15862.94,
																"pasado": 5324.14
															}, {
																"mes": "Diciembre",
																"presente": 21247.94,
																"pasado": 15142.14
															}],
															"valueAxes": [ {
																"axisAlpha": 0,
																"position": "left"
															} ],
															"startDuration": 1,
															"graphs": [ {
																"alphaField": "alpha",
																"balloonText": "<span style='font-size:12px;'>[[category]] de [[title]]:<br><span style='font-size:20px;'>$[[value]]</span> [[additional]]</span>",
																"fillAlphas": 1,
																"title": "2017",
																"type": "column",
																"valueField": "presente",
																"dashLengthField": "dashLengthColumn"
															}, {
																"id": "graph2",
																"balloonText": "<span style='font-size:12px;'>[[category]] de [[title]]:<br><span style='font-size:20px;'>$[[value]]</span> [[additional]]</span>",
																"bullet": "round",
																"lineThickness": 3,
																"bulletSize": 7,
																"bulletBorderAlpha": 1,
																"bulletColor": "#FFFFFF",
																"useLineColorForBulletBorder": true,
																"bulletBorderThickness": 3,
																"fillAlphas": 0,
																"lineAlpha": 1,
																"title": "2016",
																"valueField": "pasado",
																"dashLengthField": "dashLengthLine"
															} ],
															"categoryField": "mes",
															"categoryAxis": {
																"gridPosition": "start",
																"axisAlpha": 0,
																"tickLength": 0
															},
															"export": {
																"enabled": true
															}
														} );
													</script>


													<!-- HTML -->
													<div class="col-lg-12 col-xs-12 col-sm-12">


														<!-- BEGIN CHART PORTLET-->
														<div class="portlet light bordered">
															<div class="portlet-title">
																<div class="caption">
																	<i class="icon-bar-chart font-green-haze"></i>
																	<span class="caption-subject bold uppercase font-green-haze"> Year to date & last year sales</span>
																</div>
															</div>
															<div class="portlet-body">

																<div id="meses" class="chart"></div>
															</div>
														</div>
														<!-- END CHART PORTLET-->

													</div>
													<!--END COL MD 6-->

												</div>
											</div>
											<!-- END CONTENT BODY -->
										</div>
										<!-- END CONTENT -->
									</div>
									<!-- END CONTAINER -->
									<!-- BEGIN FOO;TER -->
									<div class="page-footer">
										<div class="page-footer-inner"> 2017 &copy; Agroanalytics - Admin Dashboard
										</div>
										<div class="scroll-to-top">
											<i class="icon-arrow-up"></i>
										</div>
									</div>
									<!-- END FOOTER -->
								</div>


								<?php 
############## VENCER COTIZACIONES EN DESUSO ###################################################
								$cotizaciones = new cotizaciones($datosConexionBD);

								$consultar_coti = $cotizaciones->consultarCotizaciones();

								foreach($consultar_coti as $row){
									$folio = $row['folioCotizacion'];
									$ddC = $row['ddCotizacion'];
									$mmC = $row['mmCotizacion'];
									$yyyyC = $row['yyyyCotizacion'];
									$status = $row['statusCotizacion'];

									if($status == 1){
										$fecha = $ddC."-".$mmC."-".$yyyyC;
										$vencimiento =  date( "d-m-Y", strtotime( " $fecha +30 days" ) );

										$hoy =  date("d-m-Y");

										if($vencimiento == $hoy){
											$cotizaciones->folio = $folio;
											$ejecutar = $cotizaciones->vencerCotizacion();
										}
									}
								}
############## VENCER COTIZACIONES EN DESUSO ###################################################
								?>
		<!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<script src="../assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../assets/global/plugins/moment.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>


<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../assets/global/scripts/app.min.js" type="text/javascript"></script>


<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../assets/js/pruebas.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

<script src="../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>

<script src="../assets/js/logout.js" type="text/javascript"></script>

<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
<?php
###### EN CASO DE NO ENCONTRAR SESION, SE MANDA AL LOGIN #############################
}else{
	header("LOCATION: ../	index.php");
}
?>