<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 28 Febrero 2017 : 22:34                                                            #
#                                                                                    #
###### eliminarTransportista.php #####################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 28-FEB-17: 22:35                                                                   #
# IJLM - Se copia CONTROLLER eliminar de proveedores                                 #
# IJLM - Se realizan los cambios pertinentes a la sección transportistas             #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE TRANSPORTISTAS ###########################
require '../../../models/administracion/transportistas.php';


###### SI SE RECIBE EL RFC DEL PROVEEDOR, SE PROCESA LA INFORMACION ##################
if(isset($_POST['rfc'])){


###### SE CREA EL OBJETO "TRANSPORTISTAS"RA UTILIZAR LOS METODOS #####################
	$transportistas = new transportistas($datosConexionBD);


###### SE RECIBE VARIABLE "POST" PARA ENVIARLAS AL METODO ############################
	$transportistas->rfc = $_POST['rfc'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
	echo $transportistas->eliminarTransportista();
}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Transportista";
}##LLAVE DE ELSE ######################################################################
?>
