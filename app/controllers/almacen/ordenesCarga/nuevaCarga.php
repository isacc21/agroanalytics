<?php


session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/almacen/ordenesCarga.php';

$ordenesCarga = new ordenesCarga($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;

	$fechaCodigo = "M".date('d').date('m').date('y');
	$ordenesCarga->codigo = $fechaCodigo."%";
	$encontrados = $ordenesCarga->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioOrdenCarga']!=""){
			$zahler++;
		}
	}

	if($zahler==0){
		$folio = $fechaCodigo."-1";
	}
	else{
		$folio = $fechaCodigo."-".($zahler+1);
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

	$ordenesCarga->pedido = $_POST['folio'];
	$ordenesCarga->id = $_SESSION['idUsuario'];
	$quemar = $ordenesCarga->quemarPedido();

	if($quemar == "listo"){

		$ordenesCarga->folio = $folio;
		$ordenesCarga->pedido = $_POST['folio'];
		$ordenesCarga->remision = "Pendiente";
		$ordenesCarga->id = $_SESSION['idUsuario'];
		echo $ordenesCarga->generarOrdenCarga();

	}
}
else{
	echo "Password incorrecta";
}

?>
