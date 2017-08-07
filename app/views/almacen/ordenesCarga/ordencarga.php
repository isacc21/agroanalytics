<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/almacen/ordenesCarga.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";

$ordenesCarga = new ordenesCarga($datosConexionBD);

$ordenesCarga->folio = $_REQUEST['codigo'];
$result = $ordenesCarga->consultarRemision();

foreach($result as $row){
	$_SESSION['fecha'] = $row['ddOrdenCarga']."/".$row['mmOrdenCarga']."/".$row['yyyyOrdenCarga'];

	$ordenesCarga->folio = $row['folioPedido'];
	$pedido = $ordenesCarga->consultarPedidosID();

	foreach($pedido as $row){
		$_SESSION['cliente'] = $row['rfcCliente'];
		$ordenesCarga->cliente = $row['rfcCliente'];
		$cliente = $ordenesCarga->consultarClientes();

		foreach($cliente as $row){
			$_SESSION['linea_uno']  = $row['razonSocCliente'];
			$_SESSION['linea_dos']  = $row['calleCliente']." No. ".$row['numeroExtCliente']."-".$row['numeroIntCliente'];
			$_SESSION['linea_tres'] = $row['ciudadCliente'].", ".$row['estadoCliente'];
			$_SESSION['tipo_cliente']= $row['tipoCliente'];
			
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
		
		
		$this->Image('../../../../resources/gologo.jpg',7,10,38);
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Ln(4);

		$this->setFont('Arial', 'B', 12);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('REMITENTE'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('ALMACEN | RECOLECCIÓN'),0,0,'L');
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode('OPEN WAREHOUSE'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219-8. Local 8 2DO Piso'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('Calz. Gustavo Vindósola Castro No. 2001'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('Colonia Ex-Ejido Coahuila'),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', 'B', 10);
		$this->Cell(18,0,utf8_decode('Contacto:'),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode('Jorge Sing'),0,0,'L');
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('Tel: 686.561.9932'),0,0,'L');
		$this->Ln(10);

		$this->setX(45);
		$this->setFont('Arial', 'B', 12);
		$this->Cell(18,0,utf8_decode('TRANSPORTISTA'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', 'B', 12);
		$this->Cell(85,0,utf8_decode('CLIENTE | DESTINATARIO'),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->setFont('Arial', '', 10);
		$this->Cell(18,0,utf8_decode('Paquetexpress'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode($_SESSION['linea_uno']),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->setFont('Arial', '', 10);
		$this->Cell(18,0,utf8_decode('Impulsora de Transportes Mexicanos SA de CV'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode($_SESSION['linea_dos']),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->setFont('Arial', '', 10);
		$this->Cell(18,0,utf8_decode('RFC: ITM-801201-3N0'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode($_SESSION['linea_tres']),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->setFont('Arial', '', 10);
		$this->Cell(18,0,utf8_decode('Tel. (686) 566.8588'),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->setFont('Arial', 'B', 10);
		$this->Cell(18,0,utf8_decode('Contacto:'),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode('Lic. Sergio Sarabia'),0,0,'L');
		$this->Ln(5);

		$this->setX(125);
		$this->setFont('Arial', 'B', 12);
		$this->Cell(18,0,utf8_decode('FECHA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(20,0,utf8_decode($_SESSION['fecha']),0,0,'L');
		$this->Ln(5);



		$this->setX(10);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(79);
		$this->Cell(80,10,utf8_decode(' ORDEN DE CARGA '),0,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','',12);
		$this->Cell(35,9.8,utf8_decode($_REQUEST['codigo']),1,0,'C',1);
		$this->Ln(12);
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
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(67,6,'PRODUCTO',0,0,'L',1);
$pdf->Cell(18,6,utf8_decode('CÓDIGO'),0,0,'L',1);
$pdf->Cell(20,6,'CONT',0,0,'C',1);
$pdf->Cell(25,6,'CANT',0,0,'C',1);
$pdf->Cell(19,6,'UNIDAD',0,0,'C',1);
$pdf->Cell(20,6,'PRECIO',0,0,'C',1);
$pdf->Cell(25,6,'TOTAL',0,0,'C',1);
$pdf->Ln();

$ordenesCarga = new ordenesCarga($datosConexionBD);

$ordenesCarga->folio = $_REQUEST['codigo'];
$result = $ordenesCarga->consultarRemision();

foreach($result as $row){
	$pedido = $row['folioPedido'];
	$total_sf = $row['totalPedido'];
	$ordenesCarga->folio = $row['folioPedido'];
	$pedidos = $ordenesCarga->consultarPedidosID();

	foreach($pedidos as $row){
		$total_sf = $row['totalPedido'];

		$ordenesCarga->pedido = $pedido;
		$detalles = $ordenesCarga->consultarDetalle();

		foreach($detalles as $row){
			$cantidad = $row['cantidadDetallePedido'];
			$unidad_sf = $row['unidadDetallePedido'];
			$monto_sf = $row['montoDetallePedido'];

			$codigo_producto = $row['codigoProducto'];

			$ordenesCarga->producto = $codigo_producto;
			$result_pro = $ordenesCarga->consultarProductosID();

			foreach($result_pro as $row){
				$nombre_producto = $row['nombreProducto'];
				$presentacion_producto = $row['presentacionProducto'];

				if($_SESSION['tipo_cliente'] != 2){
					if($_SESSION['tipo_cliente']==1){
						$precio_ingles = $row['iVentaDisProducto'];
						$precio_metrico = $row['mVentaDisProducto'];
					}
					else{
						if($_SESSION['tipo_cliente'] == 3){
							$precio_ingles = $row['iVentaGrwProducto'];
							$precio_metrico = $row['mVentaGrwProducto'];		
						}
					}
				}
				else{
					if($_SESSION['tipo_cliente'] == 2){
						$ordenesCarga->cliente = $_SESSION['cliente'];
						$ordenesCarga->producto = $codigo_producto;
						$lista_precios = $ordenesCarga->consultarPrecios();

						foreach($lista_precios as $row){
							$precio_ingles = $row['iPrecioEspecial'];
							$precio_metrico = $row['mPrecioEspecial'];
						}
					}
				}
				$presentacion = "hola";
				switch($presentacion_producto){
					case 1:
					$presentacion = 'Cubeta';
					break;
					case 2: 
					$presentacion = 'Tibor';
					break;
					case 3: 
					$presentacion = 'Tote';
					break;
					case 4:
					$presentacion = 'Granel';
					break;
					case 5:
					$presentacion = 'Saco';
					break;
					case 6: 
					$presentacion = 'S.Saco';
					break;
				}

				switch($unidad_sf){
					case "Litros":
					$unidad = 'Lt.';
					$precio_usar = $precio_metrico;
					break;
					case "Galones":
					$unidad = 'Gal.';
					$precio_usar = $precio_ingles;
					break;
					case "Ton_Metrica": 
					$unidad = 'Ton.Met.';
					$precio_usar = $precio_metrico;
					break;
					case "Ton_Corta": 
					$unidad = 'Ton.Cor.';
					$precio_usar = $precio_ingles;
					break;
				}

				$unitario = number_format($precio_usar,2, '.', ',');
				$monto = number_format($monto_sf,2, '.', ',');

				$pdf->SetFont('Arial','',10);
				$pdf->SetX(10);
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(67,7,utf8_decode($nombre_producto),0,0,'L',1);
				$pdf->Cell(18,7,"  ",0,0,'L',1);
				$pdf->Cell(20,7,$presentacion,0,0,'C',1);
				$pdf->Cell(25,7,$cantidad,0,0,'C',1);
				$pdf->Cell(19,7,$unidad,0,0,'C',1);
				$pdf->Cell(20,7,"$ ".$unitario."  ",0,0,'R',1);
				$pdf->Cell(25,7,"$ ".$monto."  ",0,0,'R',1);
				$pdf->Ln();
			}
		}
	}
}





$pdf->Ln();



$pdf->SetFont('Arial','',10);
$pdf->SetX(5);
$pdf->SetFillColor(255,255,255);








$total = number_format($total_sf,2, '.', ',');
$pdf->Ln(15);
$pdf->SetFillColor(242,242,242);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(160,8,utf8_decode('Total: '),0,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',12);
$pdf->Cell(34,8,"$ ".$total."  ",1,0,'R',1);
$pdf->Ln(15);


$pdf->Output($_REQUEST['codigo'].".pdf","I");
?>
