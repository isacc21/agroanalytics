<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Marzo 2017 : 12:13                                                              #
#                                                                                    #
###### actualizarCliente.php #########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 12-MAR-17: 12:14                                                                   #
# IJLM - Se copia CONTROLLER MODIFICAR de proveedores                                #
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

		$clientes->rfc = $_POST['rfc'];
		$clientes->viejo = $_POST['viejo'];
		$clientes->razon = $_POST['nombre'];
		$clientes->comercial = $_POST['comercial'];
		$clientes->calle = $_POST['calle'];
		$clientes->numeroExterior = $_POST['exterior'];
		$clientes->numeroInterior = $_POST['interior'];
		$clientes->colonia = $_POST['colonia'];
		$clientes->codigoPostal = $_POST['cPostal'];
		$clientes->ciudad = $_POST['ciudad'];
		$clientes->estado = $estado;
		$clientes->pais = $_POST['pais'];
		$clientes->contacto = $_POST['contacto'];
		$clientes->email = $_POST['email'];
		$clientes->telefono = "(".$_POST['ladafijo'].")".$_POST['telefono'];
		$clientes->celular = "(".$_POST['ladamovil'].")".$_POST['celular'];
		$clientes->pagina = $_POST['pagina'];
		$clientes->tipo = $_POST['tipo'];


###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
		echo $clientes->modificarCliente();
	}
	else{
		###### SE RECIBE RFC PARA EVITAR REPETIDOS PARA ENVIARLAS AL METODO ##################
		$clientes->rfc = $_POST['rfc'];


###### SE CONSULTA EN BD POR MEDIO DE RFC ############################################
		$consulta = $clientes->consultarClienteID();


###### SE PONE EN UNA VARIABLE EL RFC ENCONTRADO #####################################
		foreach ($consulta as $row) {
			$rfc = $row['rfcCliente'];
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

		$clientes->rfc = $_POST['rfc'];
		$clientes->viejo = $_POST['viejo'];
		$clientes->razon = $_POST['nombre'];
		$clientes->comercial = $_POST['comercial'];
		$clientes->calle = $_POST['calle'];
		$clientes->numeroExterior = $_POST['exterior'];
		$clientes->numeroInterior = $_POST['interior'];
		$clientes->colonia = $_POST['colonia'];
		$clientes->codigoPostal = $_POST['cPostal'];
		$clientes->ciudad = $_POST['ciudad'];
		$clientes->estado = $estado;
		$clientes->pais = $_POST['pais'];
		$clientes->contacto = $_POST['contacto'];
		$clientes->email = $_POST['email'];
		$clientes->telefono = "(".$_POST['ladafijo'].")".$_POST['telefono'];
		$clientes->celular = "(".$_POST['ladamovil'].")".$_POST['celular'];
		$clientes->pagina = $_POST['pagina'];
		$clientes->tipo = $_POST['tipo'];



###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS ##############
		echo $clientes->modificarCliente();
	}
}
}##LLAVE DE IF QUE RECIBE RFC #########################################################


###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Cliente";
}##LLAVE DE ELSE ######################################################################
?>
