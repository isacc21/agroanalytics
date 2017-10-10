<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/almacen/remisiones.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";

$remisiones = new remisiones($datosConexionBD);

$remisiones->folio = $_REQUEST['codigo'];
$revisar_productos = $remisiones->consultarRemisionesID();

foreach ($revisar_productos as $row) {
	$_SESSION['fecha_corta']= $row['ddRemision']."/".$row['mmRemision']."/".$row['yyyyRemision'];
	switch($row['mmRemision']){
		case 01:
		$mes = 'ENERO';
		break;
		case 02:
		$mes = 'FEBRERO';
		break;
		case 03:
		$mes = 'MARZO';
		break;
		case 04:
		$mes = 'ABRIL';
		break;
		case 05:
		$mes = 'MAYO';
		break;
		case 06:
		$mes = 'JUNIO';
		break;
		case 07:
		$mes = 'JULIO';
		break;
		case 08:
		$mes = 'AGOSTO';
		break;
		case 09:
		$mes = 'SEPTIEMBRE';
		break;
		case 10:
		$mes = 'OCTUBRE';
		break;
		case 11:
		$mes = 'NOVIEMBRE';
		break;
		case 12:
		$mes = 'DICIEMBRE';
		break;
	}
	$_SESSION['fecha'] = 'MEXICALI, BC. A '.$row['ddRemision']." DE ".$mes." DEL ".$row['yyyyRemision'];



	$ordenCarga = $row['folioOrdenCarga'];

	$remisiones->carga = $ordenCarga;
	$lista_ordenesCarga = $remisiones->consultarOrdenesCarga();

	foreach($lista_ordenesCarga as $row){
		$pedido = $row['folioPedido'];
	}

	$remisiones->pedido = $pedido;
	$lista_pedidos = $remisiones->consultarPedidosxID();

	foreach($lista_pedidos as $row){
		$cliente = $row['rfcCliente'];
	}

	$remisiones->pedido = $pedido;
	$detalles = $remisiones->consultarDetallePedido();

	foreach($detalles as $row){
		$producto = $row['codigoProducto'];
		$cantidad = $row['cantidadDetallePedido'];
		$unidad = $row['unidadDetallePedido'];
		$monto = $row ['montoDetallePedido'];

		$remisiones->producto = $producto;
		$cProducto = $remisiones->consultarProductosxID();

		foreach($cProducto as $row){
			$nombreProducto = $row['nombreProducto'];
			$presentacion = $row['presentacionProducto'];
			$distri = $row['iVentaDisProducto'];
			$distriM = $row['mVentaDisProducto'];
			$grower = $row['iVentaGrwProducto'];
			$growerM = $row['mVentaGrwProducto'];

			$remisiones->cliente = $cliente;
			$lista_clientes = $remisiones->consultarClientesxID();
			foreach($lista_clientes as $row){
				$_SESSION['cliente_tipo'] = $row['tipoCliente'];
				$_SESSION['cliente_nombre'] = $row['razonSocCliente'];
				$_SESSION['cliente_domicilio'] = $row['calleCliente']." ".$row['numeroExtCliente']."-".$row['numeroIntCliente']." ".$row['coloniaCliente'];
				$_SESSION['cliente_ciudad'] = $row['ciudadCliente'];
				$_SESSION['cliente_estado'] = $row['estadoCliente'];
				$_SESSION['cliente_rfc'] = $row['rfcCliente'];
			}

			




			if($cliente_tipo == 1){ 
				if($precio_unidad == 1){ 
					$precio_unitario = $distriM;
				} 
				else{
					if($precio_unidad == 2){
						$precio_unitario = $distri;
					}
				}
			} 
			else{
				if($cliente_tipo == 2){
					if($precio_unidad == 1){
						$precio_unitario = $growerM;
					}
					else{
						if($precio_unidad == 2){
							$precio_unitario = $grower;
						}
					}
				}
				else{
					if($cliente_tipo==3){
						$remisiones->cliente = $cliente;
						$remisiones->producto = $producto;
						$lista_preciosespe = $remisiones->consultarPrecios();

						foreach($lista_preciosespe as $row){
							$precio1 = $row['iPrecioEspecial'];
							$precio2 = $row['mPrecioEspecial'];
						}

						if($precio_unidad == 1){
							$precio_unitario = $precio1;
						}
						else{
							if($precio_unidad == 2){
								$precio_unitario = $precio2;
							}
						}
					}
				}
			}
		}
	}
}


class PDF extends FPDF
{
	function AcceptPageBreak()
	{		
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Addpage();
		$this->SetFillColor(232,232,232);
		$this->SetFont('segoeuisl','',12);
		$this->SetX(10);
		$this->Cell(70,6,'Folio',1,0,'C',1);
		$this->SetX(80);
		$this->Cell(20,6,'Producto',1,0,'C',1);
		$this->SetX(100);
		$this->Cell(70,6,'Fecha',1,0,'C',1);
		$this->Ln();
	}

	function Header()
	{
		
		
		$this->Image('../../../../resources/gologo.jpg',4,7,38);
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Ln(4);

		$this->setFont('Arial', 'B', 12);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->Cell(50);
		$this->setFont('Arial', 'B', 20);
		$this->Cell(35,5,utf8_decode('REMISIÓN'),0,0,'C');
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219-8. Local 8 2DO Piso'),0,0,'L');
		$this->Cell(50);
		$this->Cell(35,5,utf8_decode('ELECTRÓNICA'),0,0,'C');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->SetFillColor(235,241,222);
		$this->Cell(50);
		$this->Cell(35,5,utf8_decode($_REQUEST['codigo']),0,0,'C',1);
		$this->Ln(5);

		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->Ln(20);

		$this->SetFillColor(255,255,255);
		$this->setFont('Arial', 'B', 10);
		$this->setX(10);
		$this->Cell(13,0,utf8_decode('NOMBRE: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(10);
		$this->Cell(50,0,utf8_decode($_SESSION['cliente_nombre']),0,0,'L',1);
		$this->Ln(5);

		$this->setFont('Arial', 'B', 10);
		$this->setX(10);
		$this->Cell(10,0,utf8_decode('DIRECCIÓN: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(13);
		$this->Cell(50,0,utf8_decode($_SESSION['cliente_domicilio']),0,0,'L',1);
		$this->Ln(5);

		$this->setFont('Arial', 'B', 10);
		$this->setX(10);
		$this->Cell(10,0,utf8_decode('CIUDAD: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(13);
		$this->Cell(50,0,utf8_decode($_SESSION['cliente_ciudad']),0,0,'L',1);
		$this->Ln(5);

		$this->setFont('Arial', 'B', 10);
		$this->setX(10);
		$this->Cell(10,0,utf8_decode('ESTADO: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(13);
		$this->Cell(50,0,utf8_decode($_SESSION['cliente_estado']),0,0,'L',1);
		$this->Ln(5);

		$this->setFont('Arial', 'B', 10);
		$this->setX(10);
		$this->Cell(10,0,utf8_decode('RFC: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(13);
		$this->Cell(50,0,utf8_decode($_SESSION['cliente_rfc']),0,0,'L',1);
		$this->Ln(5);

		$this->setFont('Arial', 'B', 10);
		$this->setX(64.5);
		$this->SetFillColor(242,242,242);
		$this->Cell(85,7,utf8_decode($_SESSION['fecha']),0,0,'C',1);
		$this->Ln(20);
	}

	function Footer()
	{
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->SetY(-15);
		$this->SetFont('segoeuisl','',8);
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$remisiones = new remisiones($datosConexionBD);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(25,6,'FECHA',0,0,'C',1);
$pdf->Cell(22,6,'CANTIDAD',0,0,'L',1);
$pdf->Cell(25,6,'UNIDAD',0,0,'C',1);
$pdf->Cell(60,6,'PRODUCTO',0,0,'C',1);
$pdf->Cell(30,6,'CONTENEDOR',0,0,'C',1);
$pdf->Cell(28,6,'IMPORTE',0,0,'C',1);


$pdf->Ln();

$remisiones->folio = $_REQUEST['codigo'];
$revisar_productos = $remisiones->consultarRemisionesID();

foreach($revisar_productos as $row){
	$folio_rem = $row['folioRemision'];
	$adicional = $row['adicionalRemision'];
	$ordenCarga = $row['folioOrdenCarga'];

	$remisiones->carga = $ordenCarga;
	$lista_ordenesCarga = $remisiones->consultarOrdenesCarga();

	foreach($lista_ordenesCarga as $row){
		$pedido = $row['folioPedido'];
	}

	$remisiones->pedido = $pedido;
	$lista_pedidos = $remisiones->consultarPedidosxID();

	foreach($lista_pedidos as $row){
		$cliente = $row['rfcCliente'];
	}

	$remisiones->pedido = $pedido;
	$detalles = $remisiones->consultarDetallePedido();

	foreach($detalles as $row){
		$producto = $row['codigoProducto'];
		$cantidad = $row['cantidadDetallePedido'];
		$unidad = $row['unidadDetallePedido'];
		$monto = $row ['montoDetallePedido'];

		$remisiones->producto = $producto;
		$cProducto = $remisiones->consultarProductosxID();

		foreach($cProducto as $row){
			$nombreProducto = $row['nombreProducto'];
			$presentacion = $row['presentacionProducto'];
			$distri = $row['iVentaDisProducto'];
			$distriM = $row['mVentaDisProducto'];
			$grower = $row['iVentaGrwProducto'];
			$growerM = $row['mVentaGrwProducto'];

			$remisiones->cliente = $cliente;
			$lista_clientes = $remisiones->consultarClientesxID();
			foreach($lista_clientes as $row){
				$cliente_tipo = $row['tipoCliente'];
				$cliente_nombre = $orw['razonSocCliente'];
				$cliente_domicilio = $row['calleCliente']." ".$row['numeroExtCliente']."-".$row['numeroIntCliente']." ".$row['coloniaCliente'];
				$cliente_ciudad = $row['ciudadCliente'];
				$cliente_colonia = $row['coloniaCliente'];
			}




			if($cliente_tipo == 1){ 
				if($precio_unidad == 1){ 
					$precio_unitario = $distriM;
				} 
				else{
					if($precio_unidad == 2){
						$precio_unitario = $distri;
					}
				}
			} 
			else{
				if($cliente_tipo == 2 || $cliente_tipo == 4){
					if($precio_unidad == 1){
						$precio_unitario = $growerM;
					}
					else{
						if($precio_unidad == 2){
							$precio_unitario = $grower;
						}
					}
				}
				else{
					if($cliente_tipo==3){
						$remisiones->cliente = $cliente;
						$remisiones->producto = $producto;
						$lista_preciosespe = $remisiones->consultarPrecios();

						foreach($lista_preciosespe as $row){
							$precio1 = $row['iPrecioEspecial'];
							$precio2 = $row['mPrecioEspecial'];
						}

						if($precio_unidad == 1){
							$precio_unitario = $precio1;
						}
						else{
							if($precio_unidad == 2){
								$precio_unitario = $precio2;
							}
						}
					}
				}
			}

			switch($presentacion){
				case 1:
				$presentacion_cf = 'Cubeta';
				break;
				case 2:
				$presentacion_cf = 'Tibor';
				break;
				case 3:
				$presentacion_cf = 'Tote';
				break;
				case 4:
				$presentacion_cf = 'Granel';
				break;
				case 5:
				$presentacion_cf = 'Saco';
				break;
				case 6:
				$presentacion_cf = 'S.Saco';
				break;
			}

			$cantidad_cf = number_format($cantidad,2, '.', ',');
			$monto_cf = number_format($monto,2, '.', ',');

			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',10);
			$pdf->SetX(10);
			$pdf->Cell(25	,6,utf8_decode($_SESSION['fecha_corta']),0,0,'L',1);
			$pdf->Cell(22,6,$cantidad_cf."  ",0,0,'R',1);
			$pdf->Cell(25,6,utf8_decode($unidad),0,0,'C',1);
			$pdf->Cell(60,6,utf8_decode($nombreProducto),0,0,'C',1);
			$pdf->Cell(30,6,utf8_decode($presentacion_cf),0,0,'C',1);
			$pdf->Cell(28,6,'$ '.$monto_cf,0,0,'C',1);
			$pdf->Ln();
		}
	}
}





$pdf->Ln(20);
$pdf->setFont('Arial', 'B', 10);
$pdf->setX(62);
$pdf->SetFillColor(242,242,242);
$pdf->Cell(90,7,utf8_decode('MERCANCIA IMPORTADA BAJO PEDIMENTO NO.'),0,0,'C',1);
$pdf->Ln();

$remisiones->remision = $_REQUEST['codigo'];
$lista_pedimentos = $remisiones->consultarDetalleRemision();
foreach($lista_pedimentos as $row){
	$pdf->setFont('Arial', '', 10);
	$pdf->setX(62);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(90,7,utf8_decode(	$row['folioPedimento']),0,0,'C',1);
	$pdf->Ln();
}

$pdf->Ln(10);
$pdf->setFont('Arial', 'B', 10);
$pdf->setX(62);
$pdf->SetFillColor(242,242,242);
$pdf->Cell(90,7,utf8_decode('OBSERVACIONES'),0,0,'C',1);
$pdf->Ln();
$pdf->setFont('Arial', '', 10);
$pdf->setX(62);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(90,7,utf8_decode(	$adicional),0,0,'C',1);
$pdf->Ln();

$pdf->Output($_REQUEST['codigo'].".pdf","I");
?>
