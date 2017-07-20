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
	$x = 0;

	$fechaCodigo = "M".date('d').date('m').date('y');
	$ordenesCarga->codigo = $fechaCodigo."%";
	$encontrados = $ordenesCarga->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioOrdenCarga']!=""){
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

	/*REVISAR EXISTENCIA*/

	$ordenesCarga->pedido = $_POST['folio'];
	$detalle_productos = $ordenesCarga->consultarDetalle();

	
	foreach($detalle_productos as $row){
		$producto = $row['codigoProducto'];
		$cantidad = $row['cantidadDetallePedido'];
		$unidad = $row['unidadDetallePedido'];

		$ordenesCarga->producto =$producto;
		$num_inventario = $ordenesCarga->inventarioEsp();

		foreach($num_inventario as $row){
			$existencia = $row['SUM(existenciaInventario)'];
		}
		$binExistencia = 0;

		if(is_null($existencia)){
			$binExistencia = 1;
		}
		else{
			switch($unidad){
				case "Ton_Corta";
				break;
				case "Galones":
				$qty = $cantidad;
				break;

				case "Litros":
				$qty = $cantidad*0.26417205;
				break;

				case "Ton_Metrica": 
				$qty = $cantidad*1.1023;
				break;
			}
		}

		$faltante = $qty-$existencia;
		if($faltante>0){
			$binExistencia = 1;
		}
		if($binExistencia == 1){
			$x++;
		}
	}

	/*REVISAR EXISTENCIA*/

	if($x!=0){
		echo "No se puede completar, faltan productos";
	}
	else{
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

	
}
else{
	echo "Password incorrecta";
}

?>
