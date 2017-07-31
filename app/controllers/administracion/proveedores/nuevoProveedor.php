<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 14:19                                                            #
#                                                                                    #
###### nuevoProveedor.php ############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 14:19                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de acreedores                                   #
# IJLM - Se realizan los cambios pertinentes a la sección proveedores                #
#                                                                                    #
# 24-FEB-17: 14:21                                                                   #
# IJLM - Se completaron los cambios                                                  #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/administracion/proveedores.php';


###### SI SE RECIBE EL RFC DEL PROVEEDOR, SE PROCESA LA INFORMACION ##################
if(isset($_POST['rfc'])){

###### SE CREA EL OBJETO "PROVEEDORES" PARA UTILIZAR LOS METODOS #####################
	$proveedores = new proveedores($datosConexionBD);

###### SE RECIBE RFC PARA EVITAR REPETIDOS PARA ENVIARLAS AL METODO ##################
	$proveedores->rfc = $_POST['rfc'];


###### SE CONSULTA EN BD POR MEDIO DE RFC ############################################
	$consulta = $proveedores->consultarProveedoresID();


###### SE PONE EN UNA VARIABLE EL RFC ENCONTRADO #####################################
	foreach ($consulta as $row) {
		$rfc = $row['rfcProveedor'];
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

		$proveedores->rfc = $_POST['rfc'];
		$proveedores->razon = $_POST['nombre'];
		$proveedores->calle = $_POST['calle'];
		$proveedores->numeroExterior = $_POST['exterior'];
		$proveedores->numeroInterior = $_POST['interior'];
		$proveedores->colonia = $_POST['colonia'];
		$proveedores->codigoPostal = $_POST['cPostal'];
		$proveedores->ciudad = $_POST['ciudad'];
		$proveedores->estado = $estado;
		$proveedores->pais = $_POST['pais'];
		$proveedores->contacto = $_POST['contacto'];
		$proveedores->email = $_POST['email'];
		$proveedores->telefono = "(".$_POST['ladafijo'].")".$_POST['telefono'];
		$proveedores->celular = "(".$_POST['ladamovil'].")".$_POST['celular'];
		$proveedores->pagina = $_POST['pagina'];


###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
		echo $proveedores->guardarProveedor();
	}## LLAVE DE ELSE ################################################################### 


}## LLAVE DE IF QUE COMPARA SI SE ENVIO INCIALMENTE RFC O NO ##########################



###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Proveedor";
}##LLAVE DE ELSE EN CASO DE NO ENCONTRAR FOLIO ########################################
?>
