<?php

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/contabilidad/bancos.php';

session_start();
###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$bancos = new bancos($datosConexionBD);

###### FECHA PARA REGISTRO COFEPRIS ##################################################
$fecha = $_POST['fecha'];

$dia = $fecha[0].$fecha[1];
$mes = $fecha[3].$fecha[4];
$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];

/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
$zahler = 0;


$fechaCodigo = "A".$dia.$mes.$anio[2].$anio[3];
$bancos->folio = $fechaCodigo."%";
$encontrados = $bancos->consultarCodigos();
foreach($encontrados as $row){
	if($row['folioBanco']!=""){
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


$bancos->folio = $folio;
$bancos->dd = $dia;
$bancos->mm = $mes;
$bancos->yyyy = $anio;
$bancos->banco = $_POST['banco'];
$bancos->metpago = $_POST['metpago'];
$bancos->tipo = $_POST['tipo'];
$bancos->monto = $_POST['monto'];
$bancos->concepto = $_POST['concepto'];
$bancos->descripcion = $_POST['descripcion'];
$bancos->usuario = $_SESSION['idUsuario'];

###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ##################
echo $bancos->registroEstado();
			//echo $diaCof.$mesCof.$anioCof;
//echo $folio."-".$_POST['banco']."-".$_POST['metpago']."-".$_POST['tipo']."-".$_POST['monto']."-".$_POST['concepto']."-".$_POST['descripcion']."-".$_SESSION['idUsuario'];





###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################

?>
