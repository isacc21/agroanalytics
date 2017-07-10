<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 14:37                                                            #
#                                                                                    #
###### eliminarProveedor.php #########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 14:38                                                                   #
# IJLM - Se copia CONTROLLER eliminar de acreedores                                  #
# IJLM - Se realizan los cambios pertinentes a la sección proveedores                #
#                                                                                    #
# 24-FEB-17: 14:40                                                                   #
# IJLM - Se completaron los cambios                                                  #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/administracion/proveedores.php';


###### SI SE RECIBE EL RFC DEL PROVEEDOR, SE PROCESA LA INFORMACION ##################
if(isset($_POST['rfc'])){


###### SE CREA EL OBJETO "PROVEEDORES" PARA UTILIZAR LOS METODOS #####################
	$proveedores = new proveedores($datosConexionBD);


###### SE RECIBE VARIABLE "POST" PARA ENVIARLAS AL METODO ############################
	$proveedores->rfc = $_POST['rfc'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
	echo $proveedores->eliminarProveedor();
}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Proveedor";
}##LLAVE DE ELSE ######################################################################
?>
