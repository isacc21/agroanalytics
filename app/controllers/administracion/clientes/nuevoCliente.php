<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Marzo 2017 : 12:08                                                              #
#                                                                                    #
###### nuevoCliente.php ##############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 01-MAR-17: 12:09                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de proveedores                                  #
# IJLM - Se realizan los cambios pertinentes a la sección clientes                   #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/administracion/clientes.php';


###### SI SE RECIBE EL RFC DEL PROVEEDOR, SE PROCESA LA INFORMACION ##################
if(isset($_POST['rfc'])){

###### SE CREA EL OBJETO "PROVEEDORES" PARA UTILIZAR LOS METODOS #####################
	$clientes = new clientes($datosConexionBD);

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

###### EN CASO DE NO COINCIDIR, SE RECIBEN TODAS LAS VARIABLES POR "POST" ############
	else{

		if($_POST['estadoMexico']!="null"){
			$estado=$_POST['estadoMexico'];
		}
		else{
			if($_POST['estadoMexico']=="null"){
				$estado=$_POST['estado'];
			}
		}

		$clientes->rfc = $_POST['rfc'];
		$clientes->razon = $_POST['nombre'];
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


###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
		echo $clientes->guardarCliente();
	}## LLAVE DE ELSE ################################################################### 


}## LLAVE DE IF QUE COMPARA SI SE ENVIO INCIALMENTE RFC O NO ##########################



###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Proveedor";
}##LLAVE DE ELSE EN CASO DE NO ENCONTRAR FOLIO ########################################
?>
