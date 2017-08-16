<?php

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/contabilidad/cuentasPagar.php';

session_start();
###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$cuentasPagar = new cuentasPagar($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){


###### FECHA PARA REGISTRO COFEPRIS ##################################################
	$fecha = $_POST['fecha'];

	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;


	$fechaCodigo = "C".$dia.$mes.$anio[2].$anio[3];
	$cuentasPagar->folio = $fechaCodigo."%";
	$encontrados = $cuentasPagar->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioCuentaP']!=""){
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


	$cuentasPagar->folio = $folio;
	$cuentasPagar->dd = $dia;
	$cuentasPagar->mm = $mes;
	$cuentasPagar->yyyy = $anio;
	$cuentasPagar->proveedor = $_POST['proveedor'];
	$cuentasPagar->acreedor = $_POST['acreedor'];
	$cuentasPagar->factura = $_POST['factura'];
	$cuentasPagar->monto = $_POST['monto'];
	$cuentasPagar->comentario = $_POST['comentario'];
	$cuentasPagar->moneda = $_POST['moneda'];
	$cuentasPagar->usuario = $_SESSION['idUsuario'];

###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ##################
	echo $cuentasPagar->registrocxp();

			//echo $diaCof.$mesCof.$anioCof;
//echo $folio."-".$_POST['proveedor']."-".$_POST['acreedor']."-".$_POST['factura']."-".$_POST['monto']."-".$_POST['comentario']."-".$_POST['moneda']."-".$_SESSION['idUsuario'];



}
else{
	echo "Contraseña incorrecta";
}



###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################

?>
