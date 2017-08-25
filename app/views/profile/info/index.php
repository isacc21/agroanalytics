<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 16 Febrero 2017 : 13:17                                                            #
#                                                                                    #
###### usuarios/index.php ############################################################
#                                                                                    #
# Archivo de Inicio sección usuarios                                                 #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 16-FEB-17: 13:18                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
# IJLM - Se agrega plantilla Metronic con secciones al archivo                       #
#                                                                                    #
# 16-FEB-17: 20:16                                                                   #
# IJLM - Se agrega a la plantilla los módulos correspondientes y sus ligas           #
#                                                                                    #
# 16-FEB-17: 23:15                                                                   #
# IJLM - Se agrega enlace a script para menu sin redirección de página               #
#																					 																					 #
# 17-FEB-17: 09:25                                                                   #
# IJLM - Se agrega PORTLET para enlace a acciones de sección Usuarios                #
#																					 																					 #
# 17-FEB-17: 13:40                                                                   #
# IJLM - Se agregan enlaces a directorios para agregar Sweet Alerts                  #
#                                                                                    #
# 17-FEB-17: 15:53                                                                   #
# IJLM - Se agrego script de Sweet Alerts, hacia falta por error                     #
#                                                                                    #
# 21-FEB-17: 12:21                                                                   #
# IJLM - Se agrega el HIGHLIGHT de la sección en el SIDEBAR                          #
#                                                                                    #
# 23-FEB-17: 19:23                                                                   #
# IJLM - Se documentó el código para su futuro entendimiento                         #
#																		                                                 #
# 25-FEB-17: 07:41																                                   # 
# IJLM - Se modificó el formato de fecha de US a MX.                                 #
#                                                                                    #
# 28-FEB-17: 14:05                                                                   #
# IJLM - Se cambiaron los modulos del sidebar                                        #
######################################################################################


###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){
	$_SESSION['mandar']="Actualizar";
	###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
	include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
	require '../../../models/administracion/usuarios.php';
	require '../../../models/principal.php';


###### CREACION DEL METODO USUARIOS ##################################################
	$usuarios = new usuarios($datosConexionBD);

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
		$users = $row['usuariosPermiso'];
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


	$html_proveedores = '<li class="nav-item ">
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

	$html_banco = '<li class="nav-item">
	<a href="../../../views/administracion/bancos" class="nav-link ">
		<span class="title">6 | Bancos</span>
	</a></li>';



	###### MODULO DE ADMINISTRADOR ###############################################

	$html_inicio_administrador='<li class="nav-item">
	<a href="javascript:;" class="nav-link nav-toggle">
		<i class="icon-settings"></i>
		<span class="arrow"></span>
		<span class="title">Administrador</span>
		
	</a><ul class="sub-menu">';

	$html_final_administrador = '</ul></li>';

	$html_usuarios = '<li class="nav-item">
	<a href="../../../views/administracion/usuarios" class="nav-link ">
		<i class="fa fa-user-plus"></i>
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
		<i class="fa fa-truck"></i>
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
		<i class="icon-social-dropbox"></i>
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
		<i class="glyphicon glyphicon-usd"></i>
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



	

	?>

	<!DOCTYPE html>
	<!--[if IE 8]> <html lang ="en" class="ie8 no-js"> <![endif]-->
	<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
	<!--[if !IE]><!-->
	<html lang ="es">
	<!--<![endif]-->


	<!-- INICIO DE HEAD-->
	<head>
		<meta charset ="utf-8" />
		<title>Agroanalytics - Usuarios</title>
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
		<link href="../../../../assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />

		<link href="../../../../assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
		<link href="../../../../assets/layouts/layout/css/themes/grey.min.css" rel="stylesheet" type="text/css" id="style_color" />
		<link href="../../../../assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
	<!-- TERMINA HEAD -->


	<!-- INICIA HEADER -->
	<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white" onmousemove="parar()" onload="ini()" onkeypress="parar()" onclick="parar()">
		<div class="page-wrapper">
			<div class="page-header navbar navbar-fixed-top">
				<div class="page-header-inner ">

					<!--INICIA LOGO-->
					<div class="page-logo">
						<a href="index.php">
							<img src="../../../../assets/img/agroanalytics_logo.png" alt="logo" class="logo-default" /> </a>
							<div class="menu-toggler sidebar-toggler">
								<span></span>
							</div>
						</div>
						<!--TERMINA LOGO-->


						<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
							<span></span>
						</a>

						<!-- INICIAN ACCIONES DE USUARIO -->
						<div class="top-menu">
							<ul class="nav navbar-nav pull-right">

								<li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
									<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
										<i class="icon-bell"></i>
										<!-- COMIENZAN NOTIFICACIONES -->
										<?php 
										$principal = new principal($datosConexionBD);
										
										$contador_notificacion = 0;
										$notificaciones = '';
										
										// COMIENZAN NOTIFICACIONES PARA PRODUCTOS VENCIDOS EN EL INVENTARIO
										$inventario = $principal->caducidad_inventario();
										foreach($inventario as $row){
											
											$codigo_inventario = $row['barCodeInventario'];
											$codigo_producto = $row['codigoProducto'];
											$dd = $row['ddCaducidad'];
											$mm = $row['mmCaducidad'];
											$yyyy = $row['yyyyCaducidad'];
											$nombre = $row['nombreProducto'];
											$pres = $row['presentacionProducto'];
											switch($pres){
												case '1':
												$presentacion = ' | Cubeta';
												break;
												case '2':
												$presentacion = ' | Tibor';
												break;
												case '3':
												$presentacion = ' | Tote';
												break;
												case '4':
												$presentacion = ' | Granel';
												break;
												case '5':
												$presentacion = ' | Saco';
												break;
												case '6':
												$presentacion = ' | S.Saco';
												break;
											}
											$hola .= $codigo_inventario;

											
											if(
												// AVISO DE TRES MESES
												strtotime('-3 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-3 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-3 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-3 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-3 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE TRES MESES 
											{

												
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span>'.$codigo_inventario.' | '.$nombre.$presentacion.' a 3 meses de caducar</span></a></li>';
												$contador_notificacion++;
											}
											if(
												// AVISO DE DOS MESES
												strtotime('-2 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-2 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE DOS MESES
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span>'.$codigo_inventario.' | '.$nombre.$presentacion.' a 2 meses de caducar</span></a></li>';
												$contador_notificacion++;
											}
											if(
												// AVISO DE UN MES
												strtotime('-1 month',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-1 month +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-1 month +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-1 month +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-1 month +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE UN MES
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span>'.$codigo_inventario.' | '.$nombre.$presentacion.' a 1 mes de caducar</span></a></li>';
												$contador_notificacion++;
											}
											if(
												// AVISO DE CADUCADO
												strtotime('today',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('+1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE CADUCADO
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-danger"><i class="fa fa-ban"></i> </span>'.$codigo_inventario.' | '.$nombre.$presentacion.' caducado</span></a></li>';
												$contador_notificacion++;
											}
										}
										// FINALIZA NOTIFICACIONES PARA PRODUCTOS VENCIDOS EN EL INVENTARIO

										// COMIENZAN NOTIFICACIONES PARA CUENTAS POR COBRAR VENCIDAS
										$cuentasxcobrar = $principal->cxc_vencidas();
										foreach($cuentasxcobrar as $row){
											
											$folio = $row['folioCuentaC'];
											$dd = $row['ddCuentaC'];
											$mm = $row['mmCuentaC'];
											$yyyy = $row['yyyyCuentaC'];
											$cliente = $row['razonSocCliente'];

											if(
												// AVISO DE VENCIDO
												strtotime('today',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('+1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE VENCIDO
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-danger"><i class="fa fa-ban"></i> </span>Cuenta por cobrar "'.$folio.'" de "'.$cliente.'" vencida</span></a></li>';
												$contador_notificacion++;
											}
										}
										// FINALIZAN NOTIFICACIONES PARA CUENTAS POR COBRAR VENCIDAS

										// COMIENZAN NOTIFICACIONES PARA ESTADOS DE CUENTA DISPONIBLES
										if(date(d)==01 || date(d)==02 || date(d)==03 || date(d)==04 || date(d)==05){
											$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-success"><i class="fa fa-envelope-o"></i> </span>Estado de cuenta disponible</span></a></li>';
											$contador_notificacion++;
										}
										// TERMINAN NOTIFICACIONES PARA ESTADSO DE CUENTA DISPONIBLES

										// COMIENZAN NOTIFICACIONES PARA CUENTAS POR PAGAR 
										$cuentasxpagar = $principal->cxp_vencidas();
										foreach($cuentasxpagar as $row){
											$folio = $row['folioCuentaP'];
											$dd = $row['ddCuentaP'];
											$mm = $row['mmCuentaP'];
											$yyyy = $row['yyyyCuentaP'];

											if(
												// AVISO DE UNA SEMANA DE VENCER
												strtotime('-1 week -1 day',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-1 week',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-1 week +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE UNA SEMANA DE VENCER
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span>Cuenta por cobrar "'.$folio.'" a una semana de vencer</span></a></li>';
												$contador_notificacion++;
											}

											if(
												// AVISO DE UNA SEMANA DE VENCER
												strtotime('-1 day',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('today',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('+1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
												// AVISO DE UNA SEMANA DE VENCER
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-danger"><i class="fa fa-ban"></i> </span>Cuenta por cobrar "'.$folio.'" vencida</span></a></li>';
												$contador_notificacion++;
											}
										}
										// TERMINAN NOTIFICACIONES PARA CUENTAS POR PAGAR 

										// COMIENZAN NOTIFICACIONES PARA PERMISO COFEPRIS
										$permisos_cof = $principal->permisos();
										foreach($permisos_cof as $row){
											$producto = $row['nombreProducto'];
											$dd = $row['ddCofProducto'];
											$mm = $row['mmCofProducto'];
											$yyyy = $row['yyyyCofProducto'];


											if(
											// AVISO DE 18 MESES
												strtotime('-18 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-18 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-18 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-18 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-18 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
											// AVISO DE 18 MESES 
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span> Permiso COFEPRIS de "'.$producto.'" a 18 meses de vencer</span></a></li>';
												$contador_notificacion++;
											}


											if(
											// AVISO DE 12 MESES
												strtotime('-12 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-12 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-12 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-12 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-12 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
											// AVISO DE 12 MESES 
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span> Permiso COFEPRIS de "'.$producto.'" a 12 meses de vencer</span></a></li>';
												$contador_notificacion++;
											}
										}
										// TERMINAN NOTIFICACIONES PARA PERMISO COFEPRIS

										// COMIENZAN NOTIFICACIONES PARA PERMISO CICOPLAFEST
										$permisos_cic = $principal->permisos();
										foreach($permisos_cic as $row){
											$producto = $row['nombreProducto'];
											$dd = $row['ddCicProducto'];
											$mm = $row['mmCicProducto'];
											$yyyy = $row['yyyyCicProducto'];


											if(
											// AVISO DE 4 MESES
												strtotime('-4 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-4 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-4 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-4 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-4 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
											// AVISO DE 4 MESES 
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span> Permiso CICOPLAFEST de "'.$producto.'" a 4 meses de vencer</span></a></li>';
												$contador_notificacion++;
											}


											if(
											// AVISO DE 2 MESES
												strtotime('-2 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-2 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
											// AVISO DE 2 MESES 
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span> Permiso CICOPLAFEST de "'.$producto.'" a 2 meses de vencer</span></a></li>';
												$contador_notificacion++;
											}
										}
										// TERMINAN NOTIFICACIONES PARA PERMISO COFEPRIS

										// COMIENZAN NOTIFICACIONES PARA PERMISO CICOPLAFEST
										$permisos_sem = $principal->permisos();
										foreach($permisos_sem as $row){
											$producto = $row['nombreProducto'];
											$dd = $row['ddSemProducto'];
											$mm = $row['mmSemProducto'];
											$yyyy = $row['yyyySemProducto'];

											
											if(
											// AVISO DE 4 MESES
												strtotime('-4 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-4 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-4 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-4 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-4 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
											// AVISO DE 4 MESES 
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span> Permiso SEMARNAT de "'.$producto.'" a 4 meses de vencer</span></a></li>';
												$contador_notificacion++;
											}


											if(
											// AVISO DE 2 MESES
												strtotime('-2 months',(strtotime($yyyy."/".$mm."/".$dd))) == strtotime('today')||
												strtotime('-2 months +1 day',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +2 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +3 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')||
												strtotime('-2 months +4 days',(strtotime($yyyy."/".$mm."/".$dd)))==strtotime('today')
												)
											// AVISO DE 2 MESES 
											{
												$notificaciones = $notificaciones . '<li><a href="javascript:;"><span class="details"><span class="label label-sm label-icon label-warning"><i class="fa fa-warning"></i> </span> Permiso SEMARNAT de "'.$producto.'" a 2 meses de vencer</span></a></li>';
												$contador_notificacion++;
											}
										}
										// TERMINAN NOTIFICACIONES PARA PERMISO COFEPRIS



										if($contador_notificacion!=0){
											echo '<span class="badge badge-default">'.$contador_notificacion.'</span>';
										} ?>
									</a>
									<ul class="dropdown-menu">
										<li class="external">
											<h3>
												<span class="bold"><?php 
													if($contador_notificacion==1){
														echo $contador_notificacion; ?> notificación</span> pendiente</h3>
														<?php }else{
															echo $contador_notificacion; ?> notificaciones</span> pendientes</h3><?php
														} ?>


													</li>
													<li>
														<ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
															<?php echo $notificaciones; 
															?>
														</ul>
													</ul>
												</li>
												<li class="dropdown dropdown-user">
													<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
														<img alt="" class="img-circle" src="../../../../assets/layouts/layout/img/avatar.png" />
														<span class="username username-hide-on-mobile"><?echo $_SESSION['nombre']." ".$_SESSION['paterno'] ;?></span>
														<i class="fa fa-angle-down"></i>
													</a>
													<ul class="dropdown-menu dropdown-menu-default">
														<li>
															<input type="hidden" id="id" value="<?=$_SESSION['idUsuario']?>">

															<a href="#" id="profile">
																<i class="icon-user"></i> Mi Perfil </a>
																<script type="text/javascript">
																	$("#profile").click(function(){
																		var usuario = $("#id").val();
																		$("#mainContent").load( "form_usuarios.php?idUsuario="+usuario);

																	});
																</script>
															</li>
															<li class="divider"> </li>
															<li>
																<a href="../../../../index.php?lg=1">
																	<i class="icon-key"></i> Log Out </a>
																</li>
															</ul>
														</li>
													</ul>
												</div>
												<!--TERMINAN ACCIONES DE USUARIO-->
											</div>
										</div>
										<!--TERMINA HEADER-->


										<!--DIVISOR DE HEADER Y BODY-->
										<div class="clearfix"> </div>

										<!--INICIA CONTENEDOR-->
										<div class="page-container">


											<!--INICIA SIDEBAR-->
											<div class="page-sidebar-wrapper">
												<div class="page-sidebar navbar-collapse collapse">
													<ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
														<li class="sidebar-toggler-wrapper hide">
															<div class="sidebar-toggler">
																<span></span>
															</div>
														</li>

														<!--INICIA ELEMENTO DASHBOARD-->
														<li class="nav-item">
															<a href="../../../" class="nav-link nav-toggle">
																<i class="icon-home"></i>
																<span class="title">GOP Scorecard</span>
															</a>
														</li>
														<!--TERMINA ELEMENTO DASHBOARD-->

														<!--INICIA MÓDULO DE ADMINISTRACIÓN-->
														<?php
														if($proveedores!='0000'||$acreedores!='0000'||$transportistas!='0000'||$clientes!='0000'||$productos!='0000'||$users!='0000'){

															if($users!=='0000'){
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

															if($bancos!='0000'){
																echo $html_banco;
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
													</div>
												</div>
												<!--TERMINA SIDEBAR-->
												<style>
													body {overflow-x:hidden;}
												</style>


												<!--INICIA CONTENIDO DE PAGINA-->
												<div class="page-content-wrapper">

													<div class="page-content">

														<!--INICIA TITULO DE PAGINA -->
														<h1 class="page-title"> <b>Mi perfil</b><br /><small>GO Products S. de R.L de C.V.</small><br /><small><?php echo date(d) ."/". date(m) ."/". date(Y); ?></small></h1>
														<!--TERMINA TITULO DE PAGINA-->

														<!--INICIA MAIN CONTENT, CONTENEDOR PERSONALIZADO PARA AJAX-->
														<style type="text/css">
															div#mainContent {margin:0}
															body {overflow-x:hidden;}
														</style>

														<div id="mainContent" class="page-container">

															<!--INICIA PORTLET MENU DE USUARIOS-->
															<div class="clearfix"></div>
															<div class="row">
																<?php
																$usuarios = new usuarios($datosConexionBD);
																$usuarios->id = $_SESSION['idUsuario'];
																$result = $usuarios->consultarUsuariosID();



																foreach($result as $row){
																	$idUsuario = $row['idUsuario'];
																	$nombre = $row['nombreUsuario'];
																	$apellidos = $row['apellidosUsuario'];
																	$nick = $row['nickUsuario'];
																	$password = $row['passwordUsuario'];
																}


																$nombreSubmit = 'Actualizar';

																?>

																<!-- SCRIPTS NECESIARIOS PARA ENVIO DE INFO-->
																<script type="text/javascript">
																	$(document).ready(function(){

																		$("#back_form_acre").click(function(){
																			window.history.back();
																		});


																		/*VARIABLES DE URL PARA ENVIO DE INFO */
																		if ($("#accionBoton").val() == 'Guardar'){
																			var urlCont = "../../../controllers/administracion/usuarios/nuevoUsuario.php";
																		} /* LLAVE DE IF */
																		else if($("#accionBoton").val() == 'Actualizar'){
																			var urlCont = "../../../controllers/administracion/usuarios/actualizarUsuario.php";
																		} /* LLAVE DE ELSE */




																		$("#accionBoton").click(function(e){
																			if($("#password").val().length > 0){
																				$.ajax({
																					type: "POST",
																					url: "../../../controllers/administracion/usuarios/actualizarUsuario.php",
																					data: "id="+$("#id").val()+
																					"&nombre="+$("#nombre").val()+
																					'&apellidos='+$("#apellidos").val()+
																					'&nick='+$("#nick").val()+
																					'&repetir='+$("#repetir").val()+
																					'&viejo='+$("#viejo").val()+
																					'&password='+$("#password").val()
																				}).done(function(result){
																					if(result=="Usuario registrado exitósamente"||result=="Usuario modificado exitósamente"){


																						swal({
																							title: 'Modificación exitosa',
																							text: 'Los cambios se reflejarán en el siguiente inicio de sesión.',
																							type: "success",
																							showCloseButton: false,
																							confirmButtonText: 'Datos modificados',
																							showCancelButton: false,
																							confirmButtonText:'Cerrar'
																						},
																						function(){
																							window.history.back();
																						});

																					}else{
																						swal({
																							title: result,
																							type: "warning",
																							showCloseButton: true,
																							confirmButtonText:'Cerrar'
																						});
																					}

																				});
																				return false;
																			}
																			else{
																				swal({
																					title: 'Ingrese una contraseña',
																					type: "warning",
																					showCloseButton: true,
																					confirmButtonText:'Cerrar'
																				});
																			}
																		});

																	});
																</script>


																<!-- COLUMNA DE 8 -->
																<div class="col-md-12">

																	<!-- INICIA PORTLET -->
																	<div class="portlet box grey-steel">

																		<!-- INICIA TITULO DE PORTLET-->
																		<div class="portlet-title">
																			<div class="caption"><div class="font-grey-mint"> <b>Información de usuario</b> </div> </div>

																			<!-- TERMINA TITULO DE PORTLET-->
																			<div class="actions btn-set">
																				<button type="button" name="back" id="back_form_acre" class="btn default green-seagreen">
																					<i class="fa fa-arrow-left"></i>&nbsp;Regresar
																				</button>
																			</div>

																		</div>
																		<!-- INICIA CUERPO DE PORTLET-->
																		<div class="portlet-body form">


																			<!-- INICIO DE  FORM-->
																			<form class="form-horizontal save-user" id="guardarUser" >
																				<div class="form-body">
																					<!-- INICIA INPUT NOMBRE-->

																					<div class="form-group">
																						<label class="col-md-3 control-label">Nombre(s)</label>
																						<div class="col-md-6">
																							<input type="text" class="form-control " id="nombre" name="nombre" value="<?=$nombre;?>" required>
																						</div>
																					</div>
																					<!-- TERMINA INPUT NOMBRE-->

																					<!-- INICIA INPUT APELLIDOS-->
																					<div class="form-group">
																						<label class="col-md-3 control-label">Apellido(s)</label>
																						<div class="col-md-6">
																							<input type="text" class="form-control " id="apellidos" name="apellidos" value="<?=$apellidos;?>" required>
																						</div>
																					</div>
																					<!-- TERMINA INPUT APELLIDOS-->


																					<!--INICIA INPUT NICK 1-->
																					<div class="form-group">
																						<label class="col-md-3 control-label">Username</label>
																						<div class="col-md-6">
																							<input type="text" class="form-control " id="nick" name="nick" value="<?=$nick;?>" required>
																							<input type="hidden" id="viejo" value="<?=$nick;?>">
																						</div>
																					</div>
																					<!--TERMINA INPUT NICK 1-->

																					<!-- INICIA INPUT NICK 2-->
																					<div class="form-group">
																						<label class="col-md-3 control-label">Confirmar Username</label>
																						<div class="col-md-6">
																							<input type="text" class="form-control " id="repetir" name="repetir" value="<?=$nick;?>" required>
																						</div>
																					</div>
																					<!--TERMINA INPUT NICK 2-->

																					<!--INICIA INPUT CONTRASEÑA-->
																					<div class="form-group">
																						<label class="col-md-3 control-label">Contraseña</label>
																						<div class="col-md-6">
																							<input type="password" class="form-control " id="password" name="password" value="" required>
																							<input type="hidden" id="id" name="id" value="<?=$idUsuario;?>">
																						</div>
																					</div>
																					<!--TERMINA INPUT CONTRASEÑA -->


																					<div class="text-center">
																						<hr>
																						<!--BOTON DE GUARDAR O ACTUALIZAR-->
																						<button id="accionBoton" class="btn green-seagreen" > <?=$nombreSubmit;?></button>

																						<!--BOTON PARA REGRESAR AL INICIO-->
																					</div>

																					<!--TERMINA SECCION DE BOTONES-->

																				</form>

																				<!-- TERMINA FORM-->
																			</div>
																			<!--TERMINA CUERPO DE PORTLET-->

																		</div>
																		<!-- TERMINA PORTLET-->
																	</div>
																	<!--TERMINA COLUMNA DE 8-->

																</div>
															</div>
															<!--TERMINA MAIN CONTAINT PARA USO DE AJAX-->
														</div>
													</div>
													<!-- TERMINA CONTENIDO DE LA PAGINA -->
												</div>
												<!-- TERMINA CONTENEDOR -->


												<!-- INICIA FOOTER -->
												<div class="page-footer">
													<div class="page-footer-inner"> 2017 &copy; Agroanalytics - Admin Dashboard
													</div>
													<div class="scroll-to-top">
														<i class="icon-arrow-up"></i>
													</div>
												</div>
												<!-- TERMINA FOOTER -->
											</div>

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
<script src="../../../../assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
<script src="../../../../assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
<script src="../../../../assets/js/menu.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>

<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/ui-modals.min.js" type="text/javascript"></script>


<script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

<script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>

<!-- TERMINAN SCRITPS PARA FUNCIONAMIENTO DE COMPONENTES-->

</html>
<?php
}else{
	header("LOCATION: ../../../../index.php");
}
?>