<?php 
session_start();
include '../../../../config.php';

require '../../../models/aduanas/importaciones.php';

$importaciones = new importaciones($datosConexionBD);


if(md5($_POST['pass'])==$_SESSION['password']){



	$fecha = $_POST['fecha'];
	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];


	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;

	$fechaCodigo = "I".$dia.$mes.$anio[2].$anio[3];
	$importaciones->codigo = $fechaCodigo."%";
	$encontrados = $importaciones->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioImportacion']!=""){
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
	

	$recFacturas = explode("*hola*",$_POST['facturas']);

	$recibidos = count($recFacturas);
	$contador = $recibidos - 1;
	$varias = "";
	$supertotal = 0;

	for($i=0; $i<$contador; $i++){
		if($recFacturas!=""){
			$importaciones->factura=$recFacturas[$i];
			$importaciones->folio = $folio;
			$registro_facturas=$importaciones->agregarFacturasImportacion();

			$importaciones->factura=$recFacturas[$i];
			$importaciones->folio = $folio;
			$importaciones->id = $_SESSION['idUsuario'];
			$cancelarFacturas = $importaciones->quemarFacturas();
		}
		else{
			echo "Campos de factura vacios";
		}
		if($recFacturas!=""){
			$importaciones->factura=$recFacturas[$i];
			$lista_precios = $importaciones->consultarPreciosFactura();

			foreach($lista_precios as $row){
				$monto = $row['totalOrdenCompra'];
			}
			$supertotal += $monto;
		}
	}
	
	$importaciones->folio = $folio;
	$importaciones->dd = $dia;
	$importaciones->mm = $mes;
	$importaciones->yyyy = $anio;
	$importaciones->costo = $supertotal;
	$importaciones->id = $_SESSION['idUsuario'];
	$resultado =  $importaciones->agregarImportacion();

	echo $folio;
}

else{
	echo "Password no corresponde al usuario activo";
}

?>