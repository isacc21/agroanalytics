<?php
session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/almacen/remisiones.php';

$remisiones = new remisiones($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;

	$fechaCodigo = "N".date('d').date('m').date('y');
	$remisiones->codigo = $fechaCodigo."%";
	$encontrados = $remisiones->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioRemision']!=""){
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

	$fecha = $_POST['fecha'];

	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];

	$remisiones->folio = $folio;
	$remisiones->adicional = $_POST['adicional'];
	$remisiones->carga = $_POST['carga'];
	$remisiones->dd = $dia;
	$remisiones->mm = $mes;
	$remisiones->yyyy = $anio;
	$remisiones->id = $_SESSION['idUsuario'];
	$remisionar = $remisiones->nuevaRemision();

	$soporte =0;
	$prueba = "";
	$prueba2 = "";

	if($remisionar == "listo"){
		
		$remisiones->folio = $_POST['carga'];
		$lista_pedidos = $remisiones->consultarOrdenesCarga();

		foreach($lista_pedidos as $row){
			$pedido = $row['folioPedido'];

			$remisiones->pedido = $pedido;
			$lista_productos = $remisiones->consultarDetallePedido();

			foreach($lista_productos as $row){
				$producto = $row['codigoProducto'];
				$cantidad = $row['cantidadDetallePedido'];
				$soporte = $cantidad;


				$remisiones->producto = $producto;
				$lista_existencia = $remisiones->consultarExistencia();

				foreach($lista_existencia as $row){
					$peps = $row['barCodeInventario'];
					$existencia = $row['existenciaInventario'];


					if($soporte>=$existencia){
						$remisiones->folio = $peps;
						$remisiones->cantidad = "0";
						$result = $remisiones->restarInventario();

						$soporte -= $existencia;
					}
					else{
						if($soporte<$existencia){
							$remisiones->folio = $peps;
							$remisiones->cantidad = ($existencia-$soporte);
							$result = $remisiones->restarInventario();
							$soporte = 0;
						}
					}
					


				}
			}
			echo "Remisión registrada";
		}
	}
}
else{
	echo "Password incorrecta";
}

?>
