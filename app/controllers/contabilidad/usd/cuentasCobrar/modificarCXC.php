<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 31 Marzo 2017 : 13:17                                                              #
#                                                                                    #
###### modificarRegistro.php #########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 31-MAR-17: 13:17                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de acreedires                                   #
# IJLM - Se realizan los cambios pertinentes a la sección banco dolares              #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../../models/contabilidad/dolares/cuentasCobrar.php';




###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
	$usdCuentasC = new usdCuentasC($datosConexionBD);

	if(md5($_POST['pass'])==$_SESSION['password']){
			$fechaCXC = $_POST['fechaCXC'];

			$diaCXC = $fechaCXC[0].$fechaCXC[1];
			$mesCXC = $fechaCXC[3].$fechaCXC[4];
			$anioCXC = $fechaCXC[6].$fechaCXC[7].$fechaCXC[8].$fechaCXC[9];


			$usdCuentasC->viejo = $_POST['viejo'];
			$usdCuentasC->dd = $diaCXC;
			$usdCuentasC->mm = $mesCXC;
			$usdCuentasC->yyyy = $anioCXC;
			$usdCuentasC->cliente = $_POST['cliente'];
			$usdCuentasC->factura = $_POST['factura'];
			$usdCuentasC->monto = $_POST['monto'];
			$usdCuentasC->comentario = $_POST['comentario'];
			$usdCuentasC->id = $_SESSION['idUsuario'];

			echo $usdCuentasC->modificarCuentaC();


		}
		else{
			echo "Password incorrecta\n".md5($_POST['pass'])."\n@".$_SESSION['password']."@";
		}
###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
		//echo $usdBancos->guardarAcreedor();


?>
