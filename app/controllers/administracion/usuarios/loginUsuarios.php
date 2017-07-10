<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 04 Marzo 2017 : 20:08                                                              #
#                                                                                    #
###### loginUsuarios.php #############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 04-MAR-17: 20:08                                                                   #
# IJLM - Se copia archivo de nuevos actualizacion de permisos                        #
# IJLM - Se agrega la información necesaria para el login de los usuarios            #
#                                                                                    #
# 04-MAR-17: 20:12                                                                   #
# IJLM - Se agregan completamente los comentarios                                    #
# IJLM - NO MODIFICAR, ARCHIVO COMPLETO                                              #
######################################################################################

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/usuarios.php';

###### SE CONFIRMA QUE SE RECIBA UN NICK PARA REALIZAR EL PROCESO ####################
if(isset($_POST['nick'])){

###### SE CREA EL OBJETO USUARIOS ####################################################
	$usuarios = new usuarios($datosConexionBD);

###### SE RECIBEN LOS VALORES EN LAS VARIABLES DEL OBJETO ############################
	$usuarios->nick = $_POST['nick'];

###### SE EJECUTA EL METODO LOGIN USUARIOS ###########################################
	$result = $usuarios->consultarUsuariosNick();

	foreach($result as $row){
		$nombre = $row['nombreUsuario'];
		$apellidos = $row['apellidosUsuario'];
		$nick = $row['nickUsuario'];
		$password = $row['passwordUsuario'];
		$id = $row['idUsuario'];
		$tipo = $row['tipoUsuario'];
		$status = $row['statusUsuario'];

		$contador ++;
	}

	if($contador == 0){
		echo "El usuario no existe";
	}
	else{
		if($status==1){
			echo "Ya hay una sesión activa";
		}
		else{
			if($password != md5($_POST['pass'])){
				echo "Contraseña incorrecta";
			}
			else{
				$_SESSION['login'] = true;
				$_SESSION['nombre'] = $nombre;
				$_SESSION['paterno'] = $apellidos;
				$_SESSION['idUsuario'] = $id;
				$_SESSION['tipo'] = $tipo;
				$_SESSION['password']=$password;
				echo $_SESSION['login'];
			}
		}
	}
}## LLAVE IF PARA CONFIRMAR RECEPCION DE NICK ########################################

###### EN CASO DE NO RECIBIR NICK, SE MANDA MENSAJE ##################################
else{
	echo "Ingrese un nick";
}## LLAVE DE ELSE EN CASO DE NO RECIBIR NICK  ########################################
?>
