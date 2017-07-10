<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 20 Febrero 2017 : 14:50                                                            #
#                                                                                    #
###### nuevoUsuario.php ##############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 17-FEB-17: 14:52                                                                   #
# IJLM - Se agrega INCLUDE para los datos de conexión                                #
# IJLM - Se agrega REQUIRE para libreria de usuarios                                 #
# IJLM - Se agregan las variables y el metodo a ejecutar                             #
#                                                                                    #
# 21-FEB-17: 11:20                                                                   #
# IJLM - Se agrego código para evitar los nickname repetidos                         #
#																																										 #
# 21-FEB-17: 17:04                                                                   #
# IJLM - Se agrega confirmación para la igualación de los campos NICK                #
#                                                                                    #
# 23-FEB-17: 15:50                                                                   #
# IJLM - Se agrega ELSE a proceso de recepcion de NICK en caso de no envio           #
# IJLM - Se documento código existente para mejor entendimiento a futuro             #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/usuarios.php';


###### SI SE RECIBE EL NICK DEL USUARIO, SE PROCESA LA INFORMACION ###################
if(isset($_POST['nick'])){


###### SE CREA EL OBJETO "USUARIOS" PARA UTILIZAR LOS METODOS ########################
	$usuarios = new usuarios($datosConexionBD);

###### SE ENVIA EL NICK DE USUARIO MEDIANTE EL OBJETO CREADO #########################
	$usuarios->nick = $_POST['nick'];


###### SE PROCESA EL METODO consultarUsuariosNick PARA COMPARAR REPETICION DE NICK ###
	$consulta = $usuarios->consultarUsuariosNick();

###### SE COMPARAN LOS DOS CAMPOS NICK PARA SABER SI SON IGUALES #####################
	if($_POST['repetir']===$_POST['nick']){

###### FOREACH PARA COMPARAR PROCESAR LOS RESULTADOS DE consultarUsuariosNick() ######
		foreach ($consulta as $row) {
			$nick = $row['nickUsuario'];
		}## LLAVE DE FOREACH #############################################################


###### IF DE COMPARACION DE RESULTADO DE FOREACH CON CAMPO DE FORM ###################
		if($nick===$_POST['nick']){
			echo "Usuario existente";
		}## LLAVE DE IF PARA COMPARAR NICK CON RESULTADO DE FOREACH ######################
		else{

###### SE RECIBEN VARIABLES "POST" PARA ENVIARLAS AL METODO ##########################
			$usuarios->nombre = $_POST['nombre'];
			$usuarios->apellidos = $_POST['apellidos'];
			$usuarios->nick = $_POST['nick'];
			$usuarios->password = md5($_POST['password']);



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS #############
			echo $usuarios->guardarUsuario();
		} ## LLAVE DE ELSE EN CASO DE NO REPETIR NICK ####################################


	}## LLAVE IF EN CASO DE QUE LOS DOS CAMPOS NICK COINCIDAN ##########################
	else{
		echo "Nickname no corresponde";
	}## LLAVE DE ELSE EN CASO DE QUE LOS DOS CAMPOS NICK NO COINCIDAN ##################


}## LLAVE DE IF DE RECEPCION DE NICK DEL FORMULARIO ##################################


###### SI NO SE RECIBE NICK, SE ENVIA UN ERROR #######################################
else{
	echo "No se encontró Nick de Usuario";
}##LLAVE DE ELSE ######################################################################
?>
