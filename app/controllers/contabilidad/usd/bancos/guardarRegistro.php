<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 31 Marzo 2017 : 12:19                                                              #
#                                                                                    #
###### guardarRegistro.php ###########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 31-MAR-17: 12:19                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de acreedires                                   #
# IJLM - Se realizan los cambios pertinentes a la sección banco dolares              #
######################################################################################

session_start();
date_default_timezone_set('America/Tijuana');

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../../models/contabilidad/dolares/bancos.php';



$folio = "";
###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$usdBancos = new usdBancos($datosConexionBD);



if(md5($_POST['pass'])==$_SESSION['password']){
	$fechaR = $_POST['fechaR'];

	$diaR = $fechaR[0].$fechaR[1];
	$mesR = $fechaR[3].$fechaR[4];
	$anioR = $fechaR[6].$fechaR[7].$fechaR[8].$fechaR[9];


	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$contador = 0;

	$fechaCodigo = "A".$diaR.$mesR.$anioR[2].$anioR[3];
	$usdBancos->codigo = $fechaCodigo."%";
	$encontrados = $usdBancos->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioUSDBanco']!=""){
			$contador++;
		}
	}

	if($contador==0){
		$folio = $fechaCodigo."-1";
	}
	else{
		$folio = $fechaCodigo."-".($contador+1);
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

	$usdBancos->folio = $folio;
	$usdBancos->dd = $diaR;
	$usdBancos->mm = $mesR;
	$usdBancos->yyyy = $anioR;
	$usdBancos->referencia = $_POST['referencia'];
	$usdBancos->tipo = $_POST['tipo'];
	$usdBancos->monto = $_POST['monto'];
	$usdBancos->detalle = $_POST['detalle'];
	$usdBancos->comentario = $_POST['comentario'];
	$usdBancos->id = $_SESSION['idUsuario'];

	echo $usdBancos->registroBancoUSD();
}
else{
	echo "Password incorrecta\n".md5($_POST['pass'])."\n@".$_SESSION['password']."@";
}

