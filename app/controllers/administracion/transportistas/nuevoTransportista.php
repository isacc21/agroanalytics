<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 28 Febrero 2017 : 22:37                                                            #
#                                                                                    #
###### nuevoTransportista.php ########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 28-FEB-17: 22:37                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de proveedores                                  #
# IJLM - Se realizan los cambios pertinentes a la sección transportistas             #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE TRANSPORTISTAS ###########################
require '../../../models/administracion/transportistas.php';


###### SI SE RECIBE EL RFC DEL TRANSPORTISTA, SE PROCESA LA INFORMACION ##############
if(isset($_POST['rfc'])){

###### SE CREA EL OBJETO "TRANSPORTISTAS" PARA UTILIZAR LOS METODOS ##################
	$transportistas = new transportistas($datosConexionBD);

###### SE RECIBE RFC PARA EVITAR REPETIDOS PARA ENVIARLAS AL METODO ##################
	$transportistas->rfc = $_POST['rfc'];


###### SE CONSULTA EN BD POR MEDIO DE RFC ############################################
	$consulta = $transportistas->consultarTransportistaID();


###### SE PONE EN UNA VARIABLE EL RFC ENCONTRADO #####################################
	foreach ($consulta as $row) {
		$rfc = $row['rfcTransportista'];
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

		$transportistas->rfc = $_POST['rfc'];
		$transportistas->razon = $_POST['nombre'];
		$transportistas->calle = $_POST['calle'];
		$transportistas->numeroExterior = $_POST['exterior'];
		$transportistas->numeroInterior = $_POST['interior'];
		$transportistas->colonia = $_POST['colonia'];
		$transportistas->codigoPostal = $_POST['cPostal'];
		$transportistas->ciudad = $_POST['ciudad'];
		$transportistas->estado = $estado;
		$transportistas->pais = $_POST['pais'];
		$transportistas->contacto = $_POST['contacto'];
		$transportistas->email = $_POST['email'];
		$transportistas->telefono = "(".$_POST['ladafijo'].")".$_POST['telefono'];
		$transportistas->celular = "(".$_POST['ladamovil'].")".$_POST['celular'];
		$transportistas->pagina = $_POST['pagina'];
		$transportistas->idFiscal = $_POST['idFiscal'];
		$transportistas->sccac = $_POST['sccac'];
		$transportistas->caat = $_POST['caat'];


###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
		echo $transportistas->guardarTransportista();
	}## LLAVE DE ELSE ################################################################### 


}## LLAVE DE IF QUE COMPARA SI SE ENVIO INCIALMENTE RFC O NO ##########################



###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Proveedor";
}##LLAVE DE ELSE EN CASO DE NO ENCONTRAR FOLIO ########################################
?>
