<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Marzo 2017 : 12:17                                                              #
#                                                                                    #
###### eliminarCliente.php ###########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 01-MAR-17: 12:18                                                                   #
# IJLM - Se copia CONTROLLER eliminar de proveedores                                 #
# IJLM - Se realizan los cambios pertinentes a la sección clientes                   #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/administracion/clientes.php';


###### SI SE RECIBE EL RFC DEL PROVEEDOR, SE PROCESA LA INFORMACION ##################
if(isset($_POST['rfc'])){


###### SE CREA EL OBJETO "PROVEEDORES" PARA UTILIZAR LOS METODOS #####################
	$clientes = new clientes($datosConexionBD);


###### SE RECIBE VARIABLE "POST" PARA ENVIARLAS AL METODO ############################
	$clientes->rfc = $_POST['rfc'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
	echo $clientes->eliminarCliente();
}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Cliente";
}##LLAVE DE ELSE ######################################################################
?>
