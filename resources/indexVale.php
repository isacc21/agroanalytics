<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 14 Febrero 2017 : 10:42                                                            #
#                                                                                    #
###### index.php #####################################################################
#                                                                                    #
# Archivo para el login de usuarios                                                  #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 14-FEB-17: 10:43                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#																					 #
# 15-FEB-17: 10:09																	 #
# IJLM - Configuración básica antes de AJAX para login, completada.                  #
######################################################################################

date_default_timezone_set('America/Tijuana');

include 'config.php';

require 'app/models/administracion/usuarios.php';


$usuarios = new usuarios($datosConexionBD);

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="es">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
	<meta charset="utf-8" />
	<title>Login - Agroanalytics</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta content="Login para usuarios de Agroanalytics" name="description" />
	<meta content="IJLM" name="author" />
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN THEME GLOBAL STYLES -->
	<link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
	<link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
	<!-- END THEME GLOBAL STYLES -->
	<!-- BEGIN PAGE LEVEL STYLES -->
	<link href="assets/pages/css/login-4.min.css" rel="stylesheet" type="text/css" />
	<!-- END PAGE LEVEL STYLES -->
	<!-- BEGIN THEME LAYOUT STYLES -->
	<!-- END THEME LAYOUT STYLES -->


	<link rel="shortcut icon" href="favicon.ico" /> 

<script type="text/javascript">
	$(document).ready(function(){
		$("#entrar").submit(function(e){
			$.ajax({
				type: "POST",
				url: "app/controllers/administracion/usuarios/loginUsuarios.php",
				/*data:'username='+$("#username").val() +
				'&pass='+$("#pass").val()*/
			}).done(function(result) {
				if (result == "Password incorrecto"){
					/*swal(result);*/
					alert("MAL");
				}/*else{
					if(result == "El usuario no existe"){
						swal(result);
					}
					else{
						if(result == true){
							window.location = "app/index.php";
                  //swal(result);
                }
              }
            }*/
          //}
        });
			return false;
		});
	});
</script>
	

</head>
<!-- END HEAD -->

<body class=" login">
	<!-- BEGIN LOGO -->
	<div class="logo">
		<a href="index.php">
			<img src="assets/pages/img/logo-big.png" alt="" /> </a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN LOGIN -->
		<div class="content">
			<!-- BEGIN LOGIN FORM -->
			<form class="login-form" id="entrar">
				<h3 class="form-title">Accede a tu cuenta</h3>
				<!--<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					<span> Ingresa un nick o contraseña. </span>
				</div>-->
				<!--<div class="form-group">
					<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
					<!--<label class="control-label visible-ie8 visible-ie9">Username</label>
					<div class="input-icon">
						<i class="fa fa-user"></i>
						<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="USername" id="username" name="username" /> </div>
					</div>-->
					<div class="form-group">
						<label class="control-label visible-ie8 visible-ie9">Nombre</label>
						<div class="input-icon">
							<i class="fa fa-lock"></i>
							<input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Nombre" id="nick" name="nick"  /> </div>
						</div>
					<div class="form-group">
						<label class="control-label visible-ie8 visible-ie9">Contraseña</label>
						<div class="input-icon">
							<i class="fa fa-lock"></i>
							<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" id="pass" name="pass"  /> </div>
						</div>
						<div class="form-actions">
							<input type="submit" class="btn green pull-right" value="Login">
						</div>
					</form>
					<!-- END LOGIN FORM -->
					<!-- BEGIN FORGOT PASSWORD FORM -->
				</div>
				<!-- END LOGIN -->
				<!-- BEGIN COPYRIGHT -->
				<div class="copyright"> 2017 &copy; Agroanalytics - Admin Dashboard</div>
				<!-- END COPYRIGHT -->
		<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<script src="assets/global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="assets/pages/scripts/login-4.js" type="text/javascript"></script>
<script src="assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="assets/global/scripts/app.min.js" type="text/javascript"></script>

<script src="assets/pages/scripts/dashboard.min.js" type="text/javascript"></script>

<script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>

<script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>

<script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

<script src="assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>


<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!--<script src="assets/pages/scripts/login-4.min.js" type="text/javascript"></script>-->
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->






</body>

</html>