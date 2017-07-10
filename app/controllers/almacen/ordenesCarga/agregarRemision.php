<?php
session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/almacen/ordenesCarga.php';

$ordenesCarga = new ordenesCarga($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){

	$ordenesCarga->folio = $_POST['folio'];
	$ordenesCarga->remision = $_POST['remision'];
	$ordenesCarga->id = $_SESSION['idUsuario'];
	$remisionar = $ordenesCarga->agregarRemision();

	$soporte =0;
	$prueba = "";
	$prueba2 = "";

	if($remisionar == "listo"){
		$ordenesCarga->folio = $_POST['folio'];
		$lista_pedidos = $ordenesCarga->consultarRemision();

		foreach($lista_pedidos as $row){
			$pedido = $row['folioPedido'];

			$ordenesCarga->pedido = $pedido;
			$lista_productos = $ordenesCarga->consultarDetalle();

			foreach($lista_productos as $row){
				$producto = $row['codigoProducto'];
				$cantidad = $row['cantidadDetallePedido'];
				$soporte = $cantidad;


				$ordenesCarga->producto = $producto;
				$lista_existencia = $ordenesCarga->consultarExistencia();

				foreach($lista_existencia as $row){
					$peps = $row['barCodeInventario'];
					$existencia = $row['existenciaInventario'];


					if($soporte>=$existencia){
						$ordenesCarga->folio = $peps;
						$ordenesCarga->cantidad = "0";
						$result = $ordenesCarga->restarInventario();

						$soporte -= $existencia;
					}
					else{
						if($soporte<$existencia){
							$ordenesCarga->folio = $peps;
							$ordenesCarga->cantidad = ($existencia-$soporte);
							$result = $ordenesCarga->restarInventario();
							$soporte = 0;
						}
					}
					


				}
			}
			echo "Remisión registrada ||".$prueba."||".$prueba2."||".$_POST['folio'];
		}
	}
}
else{
	echo "Password incorrecta";
}

?>
