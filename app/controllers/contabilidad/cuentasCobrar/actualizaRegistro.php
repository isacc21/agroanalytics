<?php

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/contabilidad/cuentasCobrar.php';

session_start();
###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$cuentasCobrar = new cuentasCobrar($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){


###### FECHA PARA REGISTRO COFEPRIS ##################################################
	$fecha = $_POST['fecha'];

	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];

	$cuentasCobrar->folio = $_POST['folio'];
	$cuentasCobrar->dd = $dia;
	$cuentasCobrar->mm = $mes;
	$cuentasCobrar->yyyy = $anio;
	$cuentasCobrar->cliente = $_POST['cliente'];
	$cuentasCobrar->factura = $_POST['factura'];
	$cuentasCobrar->remision = $_POST['remision'];
	$cuentasCobrar->monto = $_POST['monto'];
	$cuentasCobrar->comentario = $_POST['comentario'];
	$cuentasCobrar->moneda = $_POST['moneda'];
	$cuentasCobrar->usuario = $_SESSION['idUsuario'];

###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ##################
	echo $cuentasCobrar->actualizarcxc();

	if($_POST['remision']!=$_POST['vieja']){
		$cuentasCobrar->remision = $_POST['remision'];
		$result = $cuentasCobrar->facturarRemision();

		$cuentasCobrar->remision = $_POST['vieja'];
		$result = $cuentasCobrar->arreglarRemision();
	}
	
			//echo $diaCof.$mesCof.$anioCof;
//echo $folio."-".$_POST['cliente']."-".$_POST['factura']."-".$_POST['remision']."-".$_POST['monto']."-".$_POST['comentario']."-".$_POST['moneda']."-".$_SESSION['idUsuario'];



}
else{
	echo "Contraseña incorrecta";
}



###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################

?>
