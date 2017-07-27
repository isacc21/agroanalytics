<?php 
session_start();
include '../../../../config.php';

require '../../../models/aduanas/declaraciones.php';

$declaraciones = new declaraciones($datosConexionBD);


if(md5($_POST['pass'])==$_SESSION['password']){


	$fecha = $_POST['fecha'];
	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];


	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$contador = 0;

	$fechaCodigo = "J".$dia.$mes.$anio[2].$anio[3];
	$declaraciones->codigo = $fechaCodigo."%";
	$encontrados = $declaraciones->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioDeclaracion']!=""){
			$contador++;
		}
	}

	if($contador==0){
		$folio = $fechaCodigo."-01";
	}
	else{
		if($contador < 9){
			$folio = $fechaCodigo."-0".($contador+1);	
		}
		else{
			$folio = $fechaCodigo."-".($contador+1);
		}
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

	$declaraciones->importacion = $_POST['importacion'];
	$lista_odc = $declaraciones->consultaodcs();

	$peso_total = 0;
	$peso_producto =0;

	foreach($lista_odc as $row){
		$odcompra = $row['folioOrdenCompra'];

		$declaraciones->folio = $odcompra;
		$lista_prodcant = $declaraciones->consultarProductosCant();

		foreach($lista_prodcant as $row){
			$densidad = $row['densidadProducto'];
			$qtd = $row['cantidadOrdenCompra'];

			$peso_producto = $densidad * $qtd;
			$peso_total += $peso_producto;

		}
	}
	

	
	$declaraciones->importacion = $_POST['importacion'];
	$cambiar = $declaraciones->quemarImportacion();



	if($cambiar = "listo"){

		if($_POST['tipo']==3){
			$placasextra = "NULL";
			$noecoextra = "NULL";
		}
		else{
			$placasextra = $_POST['placasplat'];
			$noecoextra = $_POST['noecoplat'];
		}
		
		

		$declaraciones->folio = $folio;
		$declaraciones->importacion = $_POST['importacion'];
		$declaraciones->transportista = $_POST['transportista'];
		$declaraciones->dd = $dia;
		$declaraciones->mm = $mes;
		$declaraciones->yyyy = $anio;
		$declaraciones->tipo = $_POST['tipo'];
		$declaraciones->placasmx = $_POST['placasmx'];
		$declaraciones->placasus = $_POST['placasus'];
		$declaraciones->noeco_tracto = $_POST['noecotracto'];
		$declaraciones->placas_plat = $placasextra;
		$declaraciones->noeco_plat = $noecoextra;
		$declaraciones->peso = $peso_total;
		$declaraciones->id = $_SESSION['idUsuario'];
		echo $declaraciones->crearDeclaracion();

	}
	
}

else{
	echo "Password no corresponde al usuario activo";
}

?>