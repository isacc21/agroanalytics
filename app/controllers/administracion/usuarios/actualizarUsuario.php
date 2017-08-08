<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 20 Febrero 2017 : 14:50                                                            #
#                                                                                    #
###### actualizarUsuario.php #########################################################
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
#                                                                                    #
# 21-FEB-17: 17:04                                                                   #
# IJLM - Se agrega confirmación para la igualación de los campos NICK                #
#                                                                                    #
# 23-FEB-17: 15:33                                                                   #
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

	if($_POST['viejo']===$_POST['nick']){



###### SE COMPARAN LOS DOS CAMPOS NICK PARA SABER SI SON IGUALES #####################
		if($_POST['repetir']===$_POST['nick']){


###### SE RECIBEN VARIABLES "POST" PARA ENVIARLAS AL METODO ##########################
			$alert = "";
			$username = $_POST['nick'];

			$letras = strlen($_POST['nick']);

			for ($i=0; $i < $letras ; $i++) { 
				
				if($username[$i]==" "){
					$alert = 'El username contiene espacio'	;
				}
			}
			if($alert!="El username contiene espacio"){
				
				$usuarios->nombre = $_POST['nombre'];
				$usuarios->apellidos = $_POST['apellidos'];
				$usuarios->nick = $_POST['nick'];
				$usuarios->password = md5($_POST['password']);
				$usuarios->id = $_POST['id'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS #############
				echo $usuarios->modificarUsuario();
			}
			else{
				echo $alert;
			}
		}## LLAVE DE IF DE COMPARACION DE NICKS
		else{
###### EN CASO DE QUE NO COINCIDAN, SE ENVIA MENSAJE DE ALERTA #######################
			echo "Nickname no corresponde";
		}## LLAVE DE ELSE EN CASO DE QUE NICKS NO COINCIDAN EN AMBOS CAMPOS ################

	}##IF DE VIEJO VS NICK
	else{
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
		}
		else{
			###### SE RECIBEN VARIABLES "POST" PARA ENVIARLAS AL METODO ##########################
			$alert = "";
			$username = $_POST['nick'];

			$letras = strlen($_POST['nick']);

			for ($i=0; $i < $letras ; $i++) { 
				
				if($username[$i]==" "){
					$alert = 'El username contiene espacio'	;
				}
			}
			if($alert!="El username contiene espacio"){
				
				$usuarios->nombre = $_POST['nombre'];
				$usuarios->apellidos = $_POST['apellidos'];
				$usuarios->nick = $_POST['nick'];
				$usuarios->password = md5($_POST['password']);
				$usuarios->id = $_POST['id'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS #############
				echo $usuarios->modificarUsuario();
			}
			else{
				echo $alert;
			}
		}## LLAVE DE IF PARA COMPARAR NICK CON RESULTADO DE FOREACH ######################
	}
	else{
		echo "Nickname no corresponde";
	}
}

}## LLAVE DE IF EN CASO DE NO ENVIO DE NICK ##########################################

###### SI NO SE RECIBE NICK, SE ENVIA UN ERROR #######################################
else{
	echo "No se encontró Nick de Usuario";
}##LLAVE DE ELSE ######################################################################
?>
