<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 20 Febrero 2017 : 15:16                                                            #
#                                                                                    #
###### eliminarUsuario.php ###########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 17-FEB-17: 15:17                                                                   #
# IJLM - Se agrega INCLUDE para los datos de conexión                                #
# IJLM - Se agrega REQUIRE para libreria de usuarios                                 #
# IJLM - Se agregan las variables y el metodo a ejecutar                             #
#                                                                                    #
# 23-FEB-17: 15:41                                                                   #
# IJLM - Se documento código existente para mejor entendimiento a futuro             #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/usuarios.php';


###### SI SE RECIBE EL ID DEL USUARIO, SE PROCESA LA INFORMACION #####################
if(isset($_POST['id'])){


###### SE CREA EL OBJETO "USUARIOS" PARA UTILIZAR LOS METODOS ########################
	$usuarios = new usuarios($datosConexionBD);


###### SE RECIBEN VARIABLES "POST" PARA ENVIARLAS AL METODO ##########################
	$usuarios->id = $_POST['id'];

###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS #############
	echo $usuarios->eliminarUsuario();
}## LLAVE DE IF PARA RECEPCION DE ID #################################################



###### NO NECESITA UN ELSE, PUESTO QUE EL CATALOGO MANDA SE PROCESA CON EL ID ########
###### SI NO SE MANDA EL ID, ES IMPOSIBLE ACCEDER AL DIALOGO DE ELIMINACION ##########
?>
