<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 11:05                                                            #
#                                                                                    #
###### nuevoAcreedor.php #############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 11:05                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de productos                                    #
# IJLM - Se realizan los cambios pertinentes a la sección acreedores.                #
#                                                                                    #
# 24-FEB-17: 11:20                                                                   #
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

###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
	$acreedores = new acreedores($datosConexionBD);

###### SE RECIBE RFC PARA EVITAR REPETIDOS PARA ENVIARLAS AL METODO ##################
	$acreedores->rfc = $_POST['rfc'];


###### SE CONSULTA EN BD POR MEDIO DE RFC ############################################
	$consulta = $acreedores->consultarAcreedoresID();


###### SE PONE EN UNA VARIABLE EL RFC ENCONTRADO #####################################
	foreach ($consulta as $row) {
		$rfc = $row['rfcAcreedor'];
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

		$acreedores->rfc = $_POST['rfc'];
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


###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
		echo $acreedores->guardarAcreedor();
	}## LLAVE DE ELSE ################################################################### 


}## LLAVE DE IF QUE COMPARA SI SE ENVIO INCIALMENTE RFC O NO ##########################



###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Acreedor";
}##LLAVE DE ELSE EN CASO DE NO ENCONTRAR FOLIO ########################################
?>
