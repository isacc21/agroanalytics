<?php
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
		$this->Image('../../../../resources/gologo.jpg',7,6,60);
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Ln(4);

		$this->setFont('segoeuisl', '', 15);
		$this->setX(70);
		$this->Cell(120,0,utf8_decode('GO Products S. de R.L. de C.V.'),0,0,'L');
		$this->Ln(6);

		$this->setFont('segoeuil', '', 12);
		$this->setX(70);
		$this->Cell(178,0,utf8_decode('Fco. I. Madero #1219-8. Local 8 2DO Piso'),0,0,'L');
		$this->Ln(5);

		$this->setFont('segoeuil', '', 12);
		$this->setX(70);
		$this->Cell(178,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->Ln(5);

		$this->setX(70);
		$this->Cell(178,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->Ln(5);

		$this->setFont('segoeuil', '', 12);
		$this->setX(70);
		$this->Cell(178,0,utf8_decode('México'),0,0,'L');
		$this->Ln(7);

		$this->setX(70);
		$this->Cell(178,0,utf8_decode('Fecha: '.date('d/m/Y')),0,0,'L');
		$this->Ln(10);

		$this->setX(10);
		$this->SetFillColor(235,235,235);
		$this->SetFont('segoeuisl','',14);
		$this->Cell(115);
		$this->Cell(45,8,utf8_decode('Orden de compra: '),0,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont('segoeuisl','',12);
		$this->Cell(25,8,utf8_decode($_REQUEST['codigo']),1,0,'C',1);
		$this->Ln(15);
	}

	function Footer()
	{
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->SetY(-15);
		$this->SetFont('segoeuisl','',8);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$cotizaciones = new cotizaciones($datosConexionBD);

$cotizaciones->folio = $_REQUEST['codigo'];
$lista = $cotizaciones->consultarCotizacionesxID();



$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('seguisb','',12);
$pdf->SetX(10);
$pdf->Cell(61,6,' Producto',0,0,'L',1);
$pdf->Cell(24,6,'Contenedor',0,0,'C',1);
$pdf->Cell(15,6,'CTD',0,0,'C',1);
$pdf->Cell(20,6,'Unidad',0,0,'C',1);
$pdf->Cell(25,6,'Precio',0,0,'C',1);
$pdf->Cell(40,6,'Total',0,0,'C',1);


$pdf->Ln();

foreach($lista as $row){

	
	
	
	$cotizaciones->folio = $_REQUEST['codigo'];
	$productos = $cotizaciones->consultarDetalle();

	$pdf->SetFont('segoeuil','',11);
	$pdf->SetX(5);
	$pdf->SetFillColor(255,255,255);
	$supert= 0;
	foreach($productos as $row){		
		
		$preciou = $row['montoDetalleCotizacion'] / $row['cantidadDetalleCotizacion'];
		$preciot = $row['montoDetalleCotizacion'];
		$qty = $row['cantidadDetalleCotizacion'];
		$supert += $preciot;

		$cotizaciones->producto = $row['codigoProducto'];
		$pf = $cotizaciones->consultarProductosxID();

		foreach($pf as $row){
			$nombre_producto = $row['nombreProducto'];
			$contenedor = $row['presentacionProducto'];
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
		$pdf->SetFont('segoeuil','',10);
		$pdf->SetX(10);
		$pdf->SetFillColor(255,255,255);
		$pdf->Cell(60,7,"  ".$nombre_producto,1,0,'L',1);
		$pdf->Cell(25,7,"  ".$presentacion,1,0,'L',1);
		$pdf->Cell(15,7,$qty,1,0,'C',1);
		$pdf->Cell(20,7,'GAL',1,0,'C',1);
		$pdf->Cell(25,7,"$ ".$unitario."  ",1,0,'R',1);
		$pdf->Cell(40,7,"$ ".$total."  ",1,0,'R',1);
		$pdf->Ln();
	}
	$pdf->Ln(15);
	$pdf->SetFont('segoeuisl','',14);
	$pdf->Cell(115);
	$pdf->Cell(45,8,utf8_decode('Orden de compra: '),0,0,'C',1);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('segoeuisl','',12);
	$pdf->Cell(25,8,utf8_decode($supert),1,0,'C',1);
	$pdf->Ln(15);

}
$pdf->Output("C:/Users/Isacc/Desktop/".$_REQUEST['codigo'].".pdf","F");
?>
