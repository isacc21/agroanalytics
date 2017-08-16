<?php

include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/contabilidad/bancos.php';


###### SI SE RECIBE EL RFC DEL ACREEDOR, SE PROCESA LA INFORMACION ###################
if(isset($_POST['nombre'])){


###### SE CREA EL OBJETO "ACREEDORES" PARA UTILIZAR LOS METODOS ######################
	$bancos = new bancos($datosConexionBD);

	if($_POST['codigosa']==""){
		$codigosa = 'NULL';
	}
	else{
		$codigosa = $_POST['codigosa'];
	}
	$bancos->id = $_POST['id'];
	$bancos->nombre = $_POST['nombre'];
	$bancos->moneda = $_POST['moneda'];
	$bancos->cuenta = $_POST['cuenta'];
	$bancos->clabe = $_POST['clabe'];
	$bancos->numsuc = $_POST['numsucursal'];
	$bancos->nomsuc = $_POST['nomsucursal'];
	$bancos->numpla = $_POST['numplaza'];
	$bancos->nompla = $_POST['nomplaza'];
	$bancos->codigosa = $codigosa;
	


###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ###################
	echo $bancos->modificarBanco();
}
###### SI NO SE RECIBE RFC, SE ENVIA UN ERROR #########################################
else{
	echo "No se encontró nombre de Bancos";
}##LLAVE DE ELSE ######################################################################
?>