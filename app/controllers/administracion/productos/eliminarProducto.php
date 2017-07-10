<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 22 Febrero 2017 : 12:28                                                            #
#                                                                                    #
###### eliminarProducto.php ##########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 22-FEB-17: 12:29                                                                   #
# IJLM - Se copia CONTROLLER ELIMINAR de usuarios                                    #
# IJLM - Se realizan los cambios pertinentes a la sección productos.                 #
# 																																									 #
# 23-FEB-17: 15:17                                                                   #
# IJLM - Se agrega ELSE a proceso de recepcion de FOLIO en caso de no envio          #
# IJLM - Se documento código existente para mejor entendimiento a futuro             #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/administracion/productos.php';


###### SI SE RECIBE EL FOLIO DEL PRODUCTO, SE PROCESA LA INFORMACION #################
if(isset($_POST['codigo'])){


###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
	$productos = new productos($datosConexionBD);


###### SE RECIBE VARIABLE "POST" PARA ENVIARLAS AL METODO ############################
	$productos->codigo = $_POST['codigo'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
	echo $productos->eliminarProducto();
}##LLAVE DE IF QUE RECIBE FOLIO #######################################################


###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################
else{
	echo "No se encontró Código de Producto";
}##LLAVE DE ELSE ######################################################################
?>
