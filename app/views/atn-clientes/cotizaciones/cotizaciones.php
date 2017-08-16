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
		
		
		$this->Image('../../../../resources/gologo.jpg',5,8,38);
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Ln(4);

		$this->setFont('Arial', 'B', 12);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('PROVEEDOR | VENDOR'),0,0,'L');
		$this->setX(125);
		
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);

		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219. Local 8 2DO Piso'),0,0,'L');
		$this->setX(125);
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(125);
		$this->Ln(5);

		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->setX(125);
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->setX(125);
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Ln(10);


		$this->setX(5);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(60,10,utf8_decode(' COTIZACIONES '),0,0,'C',1);
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
$lista = $cotizaciones->consultarCotizacionesAll();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(5);
$pdf->Cell(30,6,'FOLIO',0,0,'L',1);
$pdf->Cell(30,6,'FECHA',0,0,'L',1);
$pdf->Cell(90,6,'CLIENTE',0,0,'L',1);
$pdf->Cell(45,6,'TOTAL',0,0,'R',1);


$pdf->Ln();

foreach($lista as $row){
	$folio = $row['folioCotizacion'];
	$rfc = $row['rfcCliente'];
	$fecha = $row['yyyyCotizacion']."/".$row['mmCotizacion']."/".$row['ddCotizacion'];
	$total_sf = $row['totalCotizacion'];

	$cotizaciones->cliente = $rfc;
	$result_cliente = $cotizaciones->consultarClientes();
	foreach($result_cliente  as $row){
		$cliente_nombre = $row['razonSocCliente'];
	}

	$total = number_format($total_sf,2, '.', ',');
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(5);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(30,7,utf8_decode($folio),0,0,'L',1);
	$pdf->Cell(30,7,utf8_decode($fecha),0,0,'L',1);
	$pdf->Cell(90,7,utf8_decode($cliente_nombre),0,0,'L',1);
	$pdf->Cell(15,7,"$ ",0,0,'L',1);
	$pdf->Cell(30,7,$total."  USD",0,0,'R',1);
	$pdf->Ln();
}


$pdf->Output("listado_cotizaciones.pdf","I");
?>
