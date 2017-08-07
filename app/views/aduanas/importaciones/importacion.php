<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/aduanas/importaciones.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";


$importaciones = new importaciones($datosConexionBD);

$importaciones->folio = $_REQUEST['codigo'];
$lista = $importaciones->consultarImportacionesxID();
foreach($lista as $row){
	$fecha = $row['ddImportacion']."/".$row['mmImportacion']."/".$row['yyyyImportacion'];
	$pedimento = $row['folioPedimentoImportacion'];
	$entrada = $row['tipoEntradaImportacion'];
}

$_SESSION['fecha']=$fecha;

if($pedimento == NULL){
	$_SESSION['pedimento']="EN ESPERA";
}
else{
	$_SESSION['pedimento']=$pedimento;
}

if($entrada == 0){
	$_SESSION['entrada']="EN ESPERA";
}
else{
	if($entrada == 1){
		$_SESSION['entrada']="DEFINITIVA";
	}
	else{
		if($entrada == 2){
			$_SESSION['entrada']="EXPRESS";
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


		$this->setFont('Arial', '', 12);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(137);
		$this->setFont('Arial', 'B', 11);
		$this->Cell(18,0,utf8_decode('FECHA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->setX(170);
		$this->Cell(30,0,utf8_decode($_SESSION['fecha']),0,0,'R');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219-8. Local 8 2DO Piso'),0,0,'L');
		$this->setX(137);
		$this->setFont('Arial', 'B', 11);
		$this->Cell(18,0,utf8_decode('PEDIMENTO: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->setX(170);
		$this->Cell(30,0,utf8_decode($_SESSION['pedimento']),0,0,'R');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(137);
		$this->setFont('Arial', 'B', 11);
		$this->Cell(18,0,utf8_decode('ENTRADA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->setX(170);
		$this->Cell(30,0,utf8_decode($_SESSION['entrada']),0,0,'R');
		$this->Ln(5);

		$this->setX(45);
		$this->setFont('Arial', '', 10);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->Ln(5);

		
		$this->Ln(10);

		$this->setX(10);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(99);
		$this->Cell(60,10,utf8_decode(' IMPORTACIÓN '),0,0,'C',1);
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

$importaciones = new importaciones($datosConexionBD);

$importaciones->folio = $_REQUEST['codigo'];
$lista = $importaciones->consultarImportacionesxID();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(50,6,'PRODUCTO',0,0,'L',1);
$pdf->Cell(25,6,'ENVASE',0,0,'L',1);
$pdf->Cell(21,6,'CANT',0,0,'C',1);
$pdf->Cell(20,6,'UNIDAD',0,0,'C',1);
$pdf->Cell(28,6,'MONTO',0,0,'C',1);
$pdf->Cell(30,6,'MONEDA',0,0,'C',1);
$pdf->Cell(20,6,'FACTURA',0,0,'C',1);


$pdf->Ln();

foreach($lista as $row){

	$importaciones->folio = $row['folioImportacion'];
	$ordenes = $importaciones->consultarOrdenesxImportacion();

	$pdf->SetFont('Arial','',10);
	$pdf->SetX(5);
	$pdf->SetFillColor(255,255,255);
	
	$supert= 0;

	foreach($ordenes as $row){

		$odcompra = $row['folioOrdenCompra'];
		$factura = $row['folioFactura'];

		$importaciones->odc = $odcompra;
		$rel_productos = $importaciones->consultarProductosODC();

		foreach($rel_productos as $row){

			$producto = $row['codigoProducto'];
			$cantidad = $row['cantidadOrdenCompra'];
			$monto = $row['montoOrdenCompra'];

			$importaciones->producto = $producto;
			$cProductos = $importaciones->catalogoProductos();
			foreach($cProductos as $row){
				$nombreProducto = $row['nombreProducto'];
				$presentacion = $row['presentacionProducto'];
				$precio_unitario = $row['compraProducto'];

				switch($presentacion){
					case 1:
					$pres = "Cubeta";
					$typep = " Gal";
					break;
					case 2:
					$pres = "Tibor";
					$typep = " Gal";
					break;
					case 3:
					$pres = "Tote";
					$typep = " Gal";
					break;
					case 4:
					$pres = "Granel";
					$typep = " Gal";
					break;
					case 5:
					$pres = "Saco";
					$typep = " Ton. Cor.";
					break;
					case 6:
					$pres = "Súper saco";
					$typep = " Ton. Cor.";
					break;
				}

				$supert += $monto;

				$unitario = number_format($precio_unitario,2, '.', ',');
				$total = number_format($monto,2, '.', ',');
				$pdf->SetFont('Arial','',10);
				$pdf->SetX(10);
				$pdf->SetFillColor(255,255,255);
				$pdf->Cell(50,7,"  ".utf8_decode($nombreProducto),0,0,'L',1);
				$pdf->Cell(25,7,"  ".$pres,0,0,'L',1);
				$pdf->Cell(21,7,$cantidad,0,0,'C',1);
				$pdf->Cell(20,7,$typep,0,0,'C',1);
				$pdf->Cell(28,7,"$ ".$total."  ",0,0,'R',1);
				$pdf->Cell(30,7,utf8_decode('DÓLAR USD'),0,0,'C',1);
				$pdf->Cell(20,7,$factura,0,0,'C',1);
				$pdf->Ln();
			}
		}
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
