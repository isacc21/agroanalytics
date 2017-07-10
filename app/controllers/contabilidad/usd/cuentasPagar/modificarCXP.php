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
require '../../../../models/contabilidad/dolares/cuentasPagar.php';

###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$usdCuentasP = new usdCuentasP($datosConexionBD);
$proveedor = $_POST['proveedor'];
$acreedor = $_POST['acreedor'];

if($proveedor!="null"&&$acreedor!="null"){
	echo "Seleccione solo Proveedor o Acreedor\n".$proveedor." ".$acreedor;
}
else{
	if(md5($_POST['pass'])==$_SESSION['password']){
		$fechaCXP = $_POST['fechaCXP'];

		$diaCXP = $fechaCXP[0].$fechaCXP[1];
		$mesCXP = $fechaCXP[3].$fechaCXP[4];
		$anioCXP = $fechaCXP[6].$fechaCXP[7].$fechaCXP[8].$fechaCXP[9];


		if($proveedor=="null"){
			$proveedor ="";
		}
		if($acreedor == "null"){
			$acreedor ="";
		}

		$usdCuentasP->viejo = $_POST['viejo'];
		$usdCuentasP->dd = $diaCXP;
		$usdCuentasP->mm = $mesCXP;
		$usdCuentasP->yyyy = $anioCXP;
		$usdCuentasP->proveedor = $proveedor;
		$usdCuentasP->acreedor = $acreedor;
		$usdCuentasP->factura = $_POST['factura'];
		$usdCuentasP->monto = $_POST['monto'];
		$usdCuentasP->comentario = $_POST['comentario'];
		$usdCuentasP->id = $_SESSION['idUsuario'];

		echo $usdCuentasP->modificarCuentaP();
	}
	else{
		echo "Password incorrecta\n".md5($_POST['pass'])."\n@".$_SESSION['password']."@";
	}
}


?>
