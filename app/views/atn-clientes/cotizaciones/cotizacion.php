<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/atn-cliente/cotizaciones.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";
$cotizaciones = new cotizaciones($datosConexionBD);

$cotizaciones->folio = $_REQUEST['codigo'];
$lista = $cotizaciones->consultarCotizacionesxID();
foreach($lista as $row){
	$rfc = $row['rfcCliente'];
	$fecha = $row['ddCotizacion']."/".$row['mmCotizacion']."/".$row['yyyyCotizacion'];
}

$cotizaciones->cliente = $rfc;
$result = $cotizaciones->consultarClientes();
foreach($result as $row){
	$cliente = $row['razonSocCliente'];
	$linea_uno = $row['calleCliente']." ".$row['numeroExtCliente']."-".$row['numeroIntCliente'];
	$linea_dos = "Colonia ".$row['coloniaCliente'];
	$linea_tres = $row['ciudadCliente'].", ".$row['estadoCliente']." ".$row['codigoPostalCliente'];
	$linea_cuatro = $row['paisCliente'];
	$linea_cinco = $row['telefonoCliente'];
	$tipo_cliente = $row['tipoCliente'];
}

$_SESSION['clientepdf']=$cliente;
$_SESSION['rfc']=$rfc;
$_SESSION['lineauno']=$linea_uno;
$_SESSION['lineados']=$linea_dos;
$_SESSION['lineados']=$linea_dos;
$_SESSION['lineatres']=$linea_tres;
$_SESSION['lineacuatro']=$linea_cuatro;
$_SESSION['lineacinco']=$linea_cinco;
$_SESSION['fecha']=$fecha;


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
		$this->Cell(60,0,utf8_decode('PROVEEDOR | VENDOR'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('CLIENTE | CUSTOMER'),0,0,'L');
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode($_SESSION['clientepdf']),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219. Local 8 2DO Piso'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['lineauno']),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['lineados']),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['lineatres']),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['lineacuatro']),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['lineacinco']),0,0,'L');
		$this->Ln(10);

		$this->setX(125);
		$this->setFont('Arial', 'B', 12);
		$this->Cell(18,0,utf8_decode('FECHA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(20,0,utf8_decode($_SESSION['fecha']),0,0,'L');
		$this->Ln(10);

		$this->setX(10);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(99);
		$this->Cell(60,10,utf8_decode(' COTIZACIÓN '),0,0,'C',1);
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

$cotizaciones = new cotizaciones($datosConexionBD);

$cotizaciones->folio = $_REQUEST['codigo'];
$lista = $cotizaciones->consultarCotizacionesxID();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(50,6,' PRODUCTO',0,0,'L',1);
$pdf->Cell(25,6,'ENVASE',0,0,'L',1);
$pdf->Cell(21,6,'CANT',0,0,'C',1);
$pdf->Cell(20,6,'UNIDAD',0,0,'C',1);
$pdf->Cell(20,6,'PRECIO',0,0,'C',1);
$pdf->Cell(28,6,'TOTAL',0,0,'C',1);
$pdf->Cell(30,6,'MONEDA',0,0,'C',1);


$pdf->Ln();

foreach($lista as $row){

	
	
	
	$cotizaciones->folio = $_REQUEST['codigo'];
	$productos = $cotizaciones->consultarDetalle();

	$pdf->SetFont('Arial','',10);
	$pdf->SetX(5);
	$pdf->SetFillColor(255,255,255);
	$supert= 0;
	foreach($productos as $row){

		$codigo_producto = $row['codigoProducto'];
		$unidad_cotizacion = $row['unidadDetalleCotizacion'];

		switch($unidad_cotizacion){
			case "Litros":
			$unidad = "LT";
			$unidad_producto = 2;
			break;
			case "Ton_Metrica":
			$unidad = "Ton. Met.";
			$unidad_producto = 2;
			break;
			case "Galones":
			$unidad = "GAL";
			$unidad_producto = 1;
			break;
			case "Ton_Corta":
			$unidad = "Ton. Cor.";
			$unidad_producto = 1;
			break;
		}
		
		$preciot = $row['montoDetalleCotizacion'];
		$qty = $row['cantidadDetalleCotizacion'];
		$supert += $preciot;

		$cotizaciones->producto = $row['codigoProducto'];
		$pf = $cotizaciones->consultarProductosxID();

		
		foreach($pf as $row){
			$nombre_producto = $row['nombreProducto'];
			$contenedor = $row['presentacionProducto'];
			$precio_ingles = $row['iVentaProducto'];

			if($unidad_producto == 1){
				$precio_unitario_dis = $row['iVentaDisProducto'];
				$precio_unitario_gwr = $row['iVentaGrwProducto'];
			}
			else{
				if($unidad_producto == 2){
					$precio_unitario_dis = $row['mVentaDisProducto'];
					$precio_unitario_gwr = $row['mVentaGrwProducto'];
				}
			}
		}
		if($tipo_cliente == 2){
			$cotizaciones->cliente = $_SESSION['rfc'];
			$cotizaciones->producto = $codigo_producto;
			$result = $cotizaciones->consultarPrecios();
			foreach($result as $row){
				if($unidad_producto==1){
					$preciou = $row['iPrecioEspecial'];
				}
				else{
					if($unidad_producto==2){
						$preciou = $row['mPrecioEspecial'];
					}
				}
			}
		}
		else{
			if($tipo_cliente == 1){
				$preciou = $precio_unitario_dis;
			}
			else{
				if($tipo_cliente == 3){
					$preciou = $precio_unitario_grw;
				}
			}
		}

		switch($contenedor){
			case 1: 
			$presentacion = "Cubeta";
			break;
			case 2:
			$presentacion = "Tibor";
			break;
			case 3: 
			$presentacion = "Tote";
			break;
			case 4: 
			$presentacion = "Granel";
			break;
			case 5: 
			$presentacion = "Saco";
			break;
			case 6: 
			$presentacion = "Super saco";
			break;
		}


		$unitario = number_format($preciou,2, '.', ',');
		$total = number_format($preciot,2, '.', ',');
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(10);
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(50,7,"  ".utf8_decode($nombre_producto),0,0,'L',1);
		$pdf->Cell(25,7,"  ".$presentacion,0,0,'L',1);
		$pdf->Cell(21,7,$qty,0,0,'C',1);
		$pdf->Cell(20,7,$unidad,0,0,'C',1);
		$pdf->Cell(20,7,"$ ".$unitario."  ",0,0,'R',1);
		$pdf->Cell(28,7,"$ ".$total."  ",0,0,'R',1);
		$pdf->Cell(30,7,utf8_decode('DÓLAR USD'),0,0,'C',1);
		$pdf->Ln();
	}
	$btotal = number_format($supert,2, '.', ',');
	$pdf->Ln(15);
	$pdf->SetFillColor(242,242,242);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(160,8,utf8_decode('Total: '),0,0,'R',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(34,8,"$ ".$btotal."  ",1,0,'R',1);
	$pdf->Ln(15);

}
$pdf->Output($_REQUEST['codigo'].".pdf","I");
?>
