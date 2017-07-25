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


	/*CARGAR LA FECHA DE LA REMISION - IJLM::24/07/17::11.46*/
	$fecha = $_POST['fecha'];

	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];
	/*CARGAR LA FECHA DE LA REMISION - IJLM::24/07/17::11.46*/

	/*GUARDAR REMISION EN CURSO - IJLM::24/07/17::11.47*/
	$remisiones->folio = $folio;
	$remisiones->adicional = $_POST['adicional'];
	$remisiones->carga = $_POST['carga'];
	$remisiones->dd = $dia;
	$remisiones->mm = $mes;
	$remisiones->yyyy = $anio;
	$remisiones->id = $_SESSION['idUsuario'];
	$remisionar = $remisiones->nuevaRemision();
	/*GUARDAR REMISION EN CURSO - IJLM::24/07/17::11.47*/

	$soporte =0;
	$x=0;

	if($remisionar == "listo"){
		
		$remisiones->folio = $_POST['carga'];
		$lista_pedidos = $remisiones->consultarOrdenesCarga();

		foreach($lista_pedidos as $row){
			$pedido = $row['folioPedido'];

			$remisiones->pedido = $pedido;
			$lista_productos = $remisiones->consultarDetallePedido();

			foreach($lista_productos as $row){
				$producto = $row['codigoProducto'];
				$qty = $row['cantidadDetallePedido'];
				$unidad = $row['unidadDetallePedido'];

				switch($unidad){
					case "Litros":
					$cantidad = $qty*0.26417205;
					break;

					case "Ton_Metrica":
					$cantidad = $qty*1.1023;
					break;

					case "Galones":
					case "Ton_Corta":
					$cantidad = $qty;
					break;
				}
				$soporte = $cantidad;


				/*RESTAR INVENTARIO (ENTRADA EXPRESS) PARA SURTIR ORDEN DE CARGA - IJLM::24/07/17::11.44*/
				$remisiones->producto = $producto;
				$lista_ee=$remisiones->consultarEE();

				foreach($lista_ee as $row){

					$pepsEE = $row['barCodeInventario'];
					$existenciaEE = $row['existenciaInventario'];
					$importacionEE = $row['folioImportacion'];

					if($soporte>=$existenciaEE){
						$remisiones->folio = $pepsEE;
						$remisiones->cantidad = "0";
						$result = $remisiones->restarInventario();
						if($result == "listo"){
							
							/*REGISTRAR PEDIMENTOS EN DETALLES*/
							$remisiones->folio = $importacionEE;
							$lista_importaciones=$remisiones->consultarImportacionesxID();

							foreach($lista_importaciones as $row){
								$pedimento = $row['folioPedimentoImportacion'];
							}

							$remisiones->remision = $folio;
							$remisiones->pedimento = $importacionEE;
							$remisiones->detalleRemision();
							/*REGISTRAR PEDIMENTOS EN DETALLES*/

						}
						$soporte -= $existenciaEE;
					}
					else{

						/*EVALUAR SI ESTA EN CERO PARA EVITAR EL DOBLE REGISTRO EN DETALLE DE REMISIONES*/

						if($soporte<$existencia){
							$remisiones->folio = $pepsEE;
							$remisiones->cantidad = ($existenciaEE-$soporte);
							$result = $remisiones->restarInventario();
							if($result == "listo"){
								$x++;
								/*REGISTRAR PEDIMENTOS EN DETALLES*/
								$remisiones->folio = $importacionEE;
								$lista_importaciones=$remisiones->consultarImportacionesxID();

								foreach($lista_importaciones as $row){
									$pedimento = $row['folioPedimentoImportacion'];
								}

								$remisiones->remision = $folio;
								$remisiones->pedimento = $importacionEE;
								$remisiones->detalleRemision();
								/*REGISTRAR PEDIMENTOS EN DETALLES*/
							}
							$soporte = 0;
						}
					}
				}
				/*RESTAR INVENTARIO (ENTRADA EXPRESS) PARA SURTIR ORDEN DE CARGA - IJLM::24/07/17::11.44*/


				/*RESTAR INVENTARIO (ENTRADA DEFINITIVA) PARA SURTIR ORDEN DE CARGA - IJLM::24/07/17::11.44*/
				$remisiones->producto = $producto;
				$lista_existencia = $remisiones->consultarExistencia();

				foreach($lista_existencia as $row){
					$peps = $row['barCodeInventario'];
					$existencia = $row['existenciaInventario'];
					$importacion = $row['folioImportacion'];


					if($soporte>=$existencia){
						$remisiones->folio = $peps;
						$remisiones->cantidad = "0";
						$result = $remisiones->restarInventario();
						if($result == "listo"){
							
							/*REGISTRAR PEDIMENTOS EN DETALLES*/
							$remisiones->folio = $importacion;
							$lista_importaciones=$remisiones->consultarImportacionesxID();

							foreach($lista_importaciones as $row){
								$pedimento = $row['folioPedimentoImportacion'];
							}

							$remisiones->remision = $folio;
							$remisiones->pedimento = $importacion;
							$remisiones->detalleRemision();
							/*REGISTRAR PEDIMENTOS EN DETALLES*/
						}

						$soporte -= $existencia;
					}
					else{

						if($soporte<$existencia){
							$remisiones->folio = $peps;
							$remisiones->cantidad = ($existencia-$soporte);
							$result = $remisiones->restarInventario();
							if($result == "listo"){
								
								/*REGISTRAR PEDIMENTOS EN DETALLES*/
								$remisiones->folio = $importacion;
								$lista_importaciones=$remisiones->consultarImportacionesxID();

								foreach($lista_importaciones as $row){
									$pedimento = $row['folioPedimentoImportacion'];
								}

								$remisiones->remision = $folio;
								$remisiones->pedimento = $importacion;
								$remisiones->detalleRemision();
								/*REGISTRAR PEDIMENTOS EN DETALLES*/
							}
							$soporte = 0;
						}
					}
					
				}
			}
			/*RESTAR INVENTARIO (ENTRADA DEFINITIVA) PARA SURTIR ORDEN DE CARGA - IJLM::24/07/17::11.44*/


			/*CAMBIAR STATUS A ORDEN DE CARGA Y VINCULARLA A REMISION - IJLM::24/07/17::11.43*/
			$remisiones->remision = $folio;
			$remisiones->folio = $_POST['carga'];
			$remisiones->id = $_SESSION['idUsuario'];
			$remisiones->remisionarODCarga();
			/*CAMBIAR STATUS A ORDEN DE CARGA Y VINCULARLA A REMISION - IJLM::24/07/17::11.43*/

			echo "Remisión registrada";
		}
	}
}
else{
	echo "Password incorrecta";
}

?>
