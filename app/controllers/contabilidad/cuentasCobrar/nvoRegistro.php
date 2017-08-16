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

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;


	$fechaCodigo = "B".$dia.$mes.$anio[2].$anio[3];
	$cuentasCobrar->folio = $fechaCodigo."%";
	$encontrados = $cuentasCobrar->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioCuentaC']!=""){
			$zahler++;
		}
	}

	if($zahler==0){
		$folio = $fechaCodigo."-01";
	}
	else{
		if($zahler<9){
			$folio = $fechaCodigo."-0".($zahler+1);
		}
		else{
			$folio = $fechaCodigo."-".($zahler+1);
		}
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/


	$cuentasCobrar->folio = $folio;
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
	echo $cuentasCobrar->registrocxc();

	$cuentasCobrar->remision = $_POST['remision'];
	$result = $cuentasCobrar->facturarRemision();
			//echo $diaCof.$mesCof.$anioCof;
//echo $folio."-".$_POST['cliente']."-".$_POST['factura']."-".$_POST['remision']."-".$_POST['monto']."-".$_POST['comentario']."-".$_POST['moneda']."-".$_SESSION['idUsuario'];



}
else{
	echo "Contraseña incorrecta";
}



###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################

?>
