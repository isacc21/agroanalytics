<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 11:25                                                            #
#                                                                                    #
###### actualizarAcreedor.php ########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 11:25                                                                   #
# IJLM - Se copia CONTROLLER MODIFICAR de productos                                  #
# IJLM - Se realizan los cambios pertinentes a la sección acreedores.                #
#                                                                                    #
# 24-FEB-17: 11:32                                                                   #
# IJLM - Se completaron los cambios                                                  #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/administracion/acreedores.php';


###### SI SE RECIBE EL RFC DEL ACREEDOR, SE PROCESA LA INFORMACION ###################
if(isset($_POST['rfc'])){


###### SE CREA EL OBJETO "ACREEDORES" PARA UTILIZAR LOS METODOS ######################
	$acreedores = new acreedores($datosConexionBD);

	if($_POST['viejo']==$_POST['rfc']){

###### SE RECIBEN VARIABLES "POST" PARA ENVIARLAS AL METODO ##########################

		if($_POST['estadoMexico']!="null"){
			$estado=$_POST['estadoMexico'];
		}
		else{
			if($_POST['estadoMexico']=="null"){
				$estado=$_POST['estado'];
			}
		}

		$acreedores->rfc = $_POST['rfc'];
		$acreedores->viejo = $_POST['viejo'];
		$acreedores->razon = $_POST['nombre'];
		$acreedores->calle = $_POST['calle'];
		$acreedores->numeroExterior = $_POST['exterior'];
		$acreedores->numeroInterior = $_POST['interior'];
		$acreedores->colonia = $_POST['colonia'];
		$acreedores->codigoPostal = $_POST['cPostal'];
		$acreedores->ciudad = $_POST['ciudad'];
		$acreedores->estado = $estado;
		$acreedores->pais = $_POST['pais'];
		$acreedores->contacto = $_POST['contacto'];
		$acreedores->email = $_POST['email'];
		$acreedores->telefono = $_POST['telefono'];
		$acreedores->celular = $_POST['celular'];
		$acreedores->pagina = $_POST['pagina'];


###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
		echo $acreedores->modificarAcreedor();
	}
	else{

		$acreedores->rfc = $_POST['rfc'];

		$consulta = $acreedores->consultarAcreedoresID();


###### SE PONE EN UNA VARIABLE EL RFC ENCONTRADO #####################################
		foreach ($consulta as $row) {
			$rfc = $row['rfcAcreedor'];
		}##LLAVE DE FOREACH DEL METODO consultarAcreedoresID() #############################


###### COMPARACION DEL FOLIO ENCONTRADO CON EL FOLIO REGISTRADO EN FORMULARIO ########
		if($rfc===$_POST['rfc']){
			echo "RFC existente";
		}## LLAVE DE IF DE COMPARACION DE FOLIOS
		else{
			###### SE RECIBEN VARIABLES "POST" PARA ENVIARLAS AL METODO ##########################

			if($_POST['estadoMexico']!="null"){
				$estado=$_POST['estadoMexico'];
			}
			else{
				if($_POST['estadoMexico']=="null"){
					$estado=$_POST['estado'];
				}
			}

			$acreedores->rfc = $_POST['rfc'];
			$acreedores->viejo = $_POST['viejo'];
			$acreedores->razon = $_POST['nombre'];
			$acreedores->calle = $_POST['calle'];
			$acreedores->numeroExterior = $_POST['exterior'];
			$acreedores->numeroInterior = $_POST['interior'];
			$acreedores->colonia = $_POST['colonia'];
			$acreedores->codigoPostal = $_POST['cPostal'];
			$acreedores->ciudad = $_POST['ciudad'];
			$acreedores->estado = $estado;
			$acreedores->pais = $_POST['pais'];
			$acreedores->contacto = $_POST['contacto'];
			$acreedores->email = $_POST['email'];
			$acreedores->telefono = $_POST['telefono'];
			$acreedores->celular = $_POST['celular'];
			$acreedores->pagina = $_POST['pagina'];


###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
			echo $acreedores->modificarAcreedor();
		}
	}
}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Acreedor";
}##LLAVE DE ELSE ######################################################################
?>
