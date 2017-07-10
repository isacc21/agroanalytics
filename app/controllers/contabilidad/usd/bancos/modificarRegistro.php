<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 31 Marzo 2017 : 13:17                                                              #
#                                                                                    #
###### modificarRegistro.php #########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 31-MAR-17: 13:17                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de acreedires                                   #
# IJLM - Se realizan los cambios pertinentes a la sección banco dolares              #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../../models/contabilidad/dolares/bancos.php';


###### SI SE RECIBE EL RFC DEL ACREEDOR, SE PROCESA LA INFORMACION ###################
if(isset($_POST['viejo'])){

###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
	$usdBancos = new usdBancos($datosConexionBD);

	if(md5($_POST['pass'])==$_SESSION['password']){
			$fechaR = $_POST['fechaR'];

			$diaR = $fechaR[0].$fechaR[1];
			$mesR = $fechaR[3].$fechaR[4];
			$anioR = $fechaR[6].$fechaR[7].$fechaR[8].$fechaR[9];


			$usdBancos->viejo = $_POST['viejo'];
			$usdBancos->dd = $diaR;
			$usdBancos->mm = $mesR;
			$usdBancos->yyyy = $anioR;
			$usdBancos->referencia = $_POST['referencia'];
			$usdBancos->tipo = $_POST['tipo'];
			$usdBancos->monto = $_POST['monto'];
			$usdBancos->detalle = $_POST['detalle'];
			$usdBancos->comentario = $_POST['comentario'];
			$usdBancos->id = $_SESSION['idUsuario'];

			echo $usdBancos->modificarRegistroBancoUSD();

	}
	else{
		echo "Password incorrecta\n".md5($_POST['pass'])."\n@".$_SESSION['password']."@";
	}
###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
		//echo $usdBancos->guardarAcreedor();

}## LLAVE DE IF QUE COMPARA SI SE ENVIO INCIALMENTE RFC O NO ##########################



###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró RFC de Acreedor";
}##LLAVE DE ELSE EN CASO DE NO ENCONTRAR FOLIO ########################################

?>
