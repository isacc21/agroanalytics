<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 03 Abril 2017 : 12:15                                                              #
#                                                                                    #
###### saldarCXC.php #################################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 03-ABR-17: 12:15                                                                   #
# IJLM - Se copia CONTROLLER eliminar de bancos                                      #
# IJLM - Se realizan los cambios pertinentes a cancelar registro en cxc              #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../../models/contabilidad/dolares/cuentasCobrar.php';

###### SI SE RECIBE EL RFC DEL ACREEDOR, SE PROCESA LA INFORMACION ####################
if(isset($_POST['folio'])){


###### SE CREA EL OBJETO "ACREEDORES" PARA UTILIZAR LOS METODOS #######################
	$usdCuentasC = new usdCuentasC($datosConexionBD);


	if(md5($_POST['pass'])==$_SESSION['password']){
		$usdCuentasC->folio = $_POST['folio'];
		$usdCuentasC->id = $_SESSION['idUsuario'];
		echo $usdCuentasC->saldarCuentaC();

	}
	else{
		echo "Password no corresponde al usuario activo";
	}

}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró folio";
}##LLAVE DE ELSE ######################################################################
?>
