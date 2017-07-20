<?php 

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/atn-cliente/pedidos.php';
session_start();

$mostrar = "";
$detalles = 0;

if(md5($_POST['pass'])==$_SESSION['password']){


	$pedidos = new pedidos($datosConexionBD);



	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;

	$fechaCodigo = "G".date('d').date('m').date('y');
	$pedidos->codigo = $fechaCodigo."%";
	$encontrados = $pedidos->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioPedido']!=""){
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


		$pedidos->folio = $_POST['coti'];
		$lista_cotizaciones = $pedidos->consultarCotizacionesxID();
		foreach($lista_cotizaciones as $row){
			$cliente = $row['rfcCliente'];
			$total = $row['totalCotizacion'];
		}

		$pedidos->folio = $_POST['coti'];
		$pedidos->id = $_SESSION['idUsuario'];
		$pedidos->pedido = $folio;
		$usada = $pedidos->usarCotizacion();
		if($usada == "Listo"){
			$pedidos->folio = $_POST['coti'];
			$detalle_cotizacion = $pedidos->consultarDetallesCoti();
			foreach($detalle_cotizacion as $row){
				$producto = $row['codigoProducto'];
				$cantidad = $row['cantidadDetalleCotizacion'];
				$monto = $row['montoDetalleCotizacion'];
				$unidad = $row['unidadDetalleCotizacion'];

				$pedidos->folio = $folio;
				$pedidos->producto = $producto;
				$pedidos->cantidad = $cantidad;
				$pedidos->unidad = $unidad;
				$pedidos->monto = $monto;
				$detalle = $pedidos->registrarDetalle();
				if($detalle=="Registro detalle exitoso"){
					$detalles ++;
				}
			}

			$pedidos->folio = $folio;
			$pedidos->cliente = $cliente;
			$pedidos->total = $total;
			$pedidos->dd = date('d');
			$pedidos->mm = date('m');
			$pedidos->yyyy = date('Y');
			$pedidos->id = $_SESSION['idUsuario'];
			echo $pedidos->registrarPedido();	
		}	
	
//echo $_POST['coti']."--".$_POST['pedido'];
}
else{
	echo "Password no corresponde al usuario";
}
?>