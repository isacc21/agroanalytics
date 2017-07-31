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
# 04-MAR-17: 22:24                                                                   #
# IJLM - Creación del método SESSION_START()                                         #
# IJLM - Se agrega un UNSET a la variable de sesión que confirma el inicia           #
# IJLM - Se agrega un SESSION_DESTROY() para terminar completamente la sesión        #
######################################################################################

###### SE AGREGA PARA RECIBIR LA SESION ##############################################
session_start();
include 'config.php';
require 'app/models/administracion/usuarios.php';
$usuarios = new usuarios($datosConexionBD);
if(isset($_SESSION['login'])){
	

	$usuarios->id=$_SESSION['idUsuario'];
	$active = $usuarios->cancelarSesion();

	if($active = "Sesión cancelada"){
		$prueba = $active;
	}

	$result=$usuarios->consultarUsuarios();
	foreach($result as $row){
		$usuario = $row['idUsuario'];
		$activo = $row['statusUsuario'];
		$hora = $row['entradaUsuario'];
		$ahora = time();

		if($activo == 1){
			$periodo = $ahora - $hora;
			if($periodo>=3600000){
				$usuarios->id=$usuario;
				$active = $usuarios->cancelarSesion();

				if($active = "Sesión cancelada"){
					$prueba = $active;
					
				}
			}
		}
	}
}


$result=$usuarios->consultarUsuarios();
foreach($result as $row){
	$usuario = $row['idUsuario'];
	$activo = $row['statusUsuario'];
	$hora = $row['entradaUsuario'];
	$ahora = time();

	if($activo == 1){
		$periodo = $ahora - $hora;
		if($periodo>=60){
			$usuarios->id=$usuario;
			$active = $usuarios->cancelarSesion();

			if($active = "Sesión cancelada"){
				$prueba = $active;

			}
		}
	}
}


###### EN CASO DE QUE EXISTA UNA SESIÓN ACTIVA, SE DESACTIVA #########################
unset($_SESSION["login"]);

###### SE DESTRUYE LA SESION PARA NO ACCEDER A ARCHIVOS ADELANTE #####################
session_destroy();

###### SE CONFIGURA LA ZONA HORARIA ##################################################
date_default_timezone_set('America/Tijuana');

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
	<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

	<link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<!-- END THEME GLOBAL STYLES -->
	<!-- BEGIN THEME LAYOUT STYLES -->
	<link href="assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/layouts/layout/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
	<link href="assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

	<link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />


	<link href="assets/pages/css/login-4.min.css" rel="stylesheet" type="text/css" />

	<!--SE AGREGA JQUERY POR GOOGLE APIS PARA QUE FUNCIONE AJAX-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="shortcut icon" href="favicon.ico" /> 



	<script type="text/javascript">


		$(document).ready(function(){
			<?php if($_REQUEST['lg']!=1){
				?>
				swal({
					title: 'AVISO',
					type: 'warning',
					text: 'NO GUARDES TU USUARIO Y CONTRASEÑA EN EL NAVEGADOR',
					showCloseButton: true,
					confirmButtonText:
					'Cerrar'});
				<?}
				else{?>
					swal({
						title: 'Tu sesión ha terminado',
						type: 'success',
						/*text: 'NO GUARDES TU USUARIO Y CONTRASEÑA EN EL NAVEGADOR',*/
						showCloseButton: true,
						confirmButtonText:
						'Cerrar'});
					<?}?>
					/*AJAX PARA ENVIO DE INFORMACION A CONTROLLER PARA LOGIN*/
					$("#entrar").submit(function(e){
						$.ajax({
							type: "POST",
							url: "app/controllers/administracion/usuarios/loginUsuarios.php",
							data:'nick='+$("#nick").val() +
							'&pass='+$("#pass").val()
						}).done(function(result){
							/*SE MUESTRA ERROR EN CASO DE QUE EL PASSWORD SEA INCORRECTO*/
							if (result != true){
								swal({
									title: result,
									type: 'error',
									/*text: 'NO GUARDES TU USUARIO Y CONTRASEÑA EN EL NAVEGADOR',*/
									showCloseButton: true,
									confirmButtonText:
									'Cerrar'});
							}else{
								if(result == true){

									window.location.href = "app/index.php";
								}
							}
						});
						return false;
					});
				});
			</script>
		</head>
		<!-- END HEAD -->

		<body class="login">
			<div class="logo">
				<a href="index.php">
					<img src="assets/pages/img/logo-big.png" alt="" /> </a>
				</div>
				<!-- END LOGO -->
				<!-- BEGIN LOGIN -->
				<div class="content">
					<!-- BEGIN LOGIN FORM -->
					<form  id="entrar">
						<div class="login-form">
							<h3 class="form-title">Accede a tu cuenta</h3>

							<div class="form-group">
								<label class="control-label visible-ie8 visible-ie9">Nombre</label>
								<div class="input-icon">
									<i class="fa fa-user"></i>
									<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Nombre" id="nick" name="nick" required/> </div>
								</div>
								<div class="form-group">
									<label class="control-label visible-ie8 visible-ie9">Contraseña</label>
									<div class="input-icon">
										<i class="fa fa-lock"></i>
										<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" id="pass" name="pass"  required/> </div>
									</div>
									<div class="form-actions">
										<input type="submit" id="accionBoton" class="btn green pull-right" value="Login">
									</div>
								</div>
							</form>
							<!-- END LOGIN FORM -->
							<!-- BEGIN FORGOT PASSWORD FORM -->
						</div>
						<!-- END LOGIN -->
						<!-- BEGIN COPYRIGHT -->
						<div class="copyright"> 2017 &copy; Agroanalytics - Admin Dashboard</div>










						<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
						<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
						<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
						<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
						<!-- END CORE PLUGINS -->
						<!-- BEGIN PAGE LEVEL PLUGINS -->
						<script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>



						<!-- END PAGE LEVEL PLUGINS -->
						<!-- BEGIN THEME GLOBAL SCRIPTS -->
						<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
						<!-- END THEME GLOBAL SCRIPTS -->
						<!-- BEGIN PAGE LEVEL SCRIPTS -->
						<script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>
						<!-- END PAGE LEVEL SCRIPTS -->
						<!-- BEGIN THEME LAYOUT SCRIPTS -->
						<script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
						<script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
						<script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
						<script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>

						<script src="assets/pages/scripts/login-4.js" type="text/javascript"></script>
						<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>

						<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

						<script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

						<script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
						<script src="assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>

						<!-- END THEME LAYOUT SCRIPTS -->
					</body>

					</html>
