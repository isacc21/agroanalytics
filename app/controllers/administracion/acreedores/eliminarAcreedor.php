<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 11:21                                                            #
#                                                                                    #
###### eliminarAcreedor.php ##########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 11:21                                                                   #
# IJLM - Se copia CONTROLLER eliminar de productos                                   #
# IJLM - Se realizan los cambios pertinentes a la sección acreedores.                #
#                                                                                    #
# 24-FEB-17: 11:24                                                                   #
# IJLM - Se completaron los cambios                                                  #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ################################
require '../../../models/administracion/acreedores.php';


###### SI SE RECIBE EL RFC DEL ACREEDOR, SE PROCESA LA INFORMACION ####################
if(isset($_POST['rfc'])){


###### SE CREA EL OBJETO "ACREEDORES" PARA UTILIZAR LOS METODOS #######################
	$acreedores = new acreedores($datosConexionBD);


###### SE RECIBE VARIABLE "POST" PARA ENVIARLAS AL METODO ############################
	$acreedores->rfc = $_POST['rfc'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
	echo $acreedores->eliminarAcreedor();
}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Acreedor";
}##LLAVE DE ELSE ######################################################################
?>
