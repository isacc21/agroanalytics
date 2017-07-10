<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 31 Marzo 2017 : 21:40                                                              #
#                                                                                    #
###### cancelarRegistro.php ##########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 31-MAR-17: 21:41                                                                   #
# IJLM - Se copia CONTROLLER eliminar de acreedores                                  #
# IJLM - Se realizan los cambios pertinentes a cancelar registro en bancos           #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/almacen/ordenesCompra.php';

###### SI SE RECIBE EL RFC DEL ACREEDOR, SE PROCESA LA INFORMACION ####################
if(isset($_POST['folio'])){


###### SE CREA EL OBJETO "ACREEDORES" PARA UTILIZAR LOS METODOS #######################
	$ordenesCompra = new ordenesCompra($datosConexionBD);


	if(md5($_POST['pass'])==$_SESSION['password']){
		$ordenesCompra->folio = $_POST['folio'];
		$ordenesCompra->id = $_SESSION['idUsuario'];
		echo $ordenesCompra->cancelarOrdenCompra();

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
