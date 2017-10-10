<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/almacen/inventario.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";
$inventario = new inventario($datosConexionBD);




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
		$this->setX(50);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(50);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219. Local 8 2DO Piso'),0,0,'L');
		$this->setX(125);
		
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(50);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(125);
		
		$this->Ln(5);

		$this->setX(50);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->setX(125);
		
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(50);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->setX(125);
		
		$this->Ln(10);

		$this->setX(50);
		$this->setFont('Arial', 'B', 10);
		$this->Cell(15,0,utf8_decode('FECHA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(20,0,utf8_decode(date('d/m/Y')),0,0,'L');
		$this->Ln(5);
		$this->setX(124);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(80,10,utf8_decode(' INVENTARIO '),0,0,'C',1);
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
		//$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
}

$inventario = new inventario($datosConexionBD);

$lista_inventario = $inventario->reporteInventario();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(5);
$pdf->Cell(48,6,'NOMBRE',0,0,'L',1);
$pdf->Cell(15,6,utf8_decode('PRES'),0,0,'L',1);
$pdf->Cell(25,6,'CANT',0,0,'C',1);
$pdf->Cell(28,6,'LOTE',0,0,'L',1);
$pdf->Cell(28,6,'MANUFRA',0,0,'L',1);
$pdf->Cell(28,6,'CADUCIDAD',0,0,'L',1);
$pdf->Cell(28,6,'PEDIMENTO',0,0,'L',1);


$pdf->Ln();

foreach($lista_inventario as $row){

	switch($row['presentacionProducto']){
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

	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',10);
	$pdf->SetX(5);
	$pdf->Cell(48,6,utf8_decode($row['nombreProducto']),0,0,'L',1);
	$pdf->Cell(15,6,utf8_decode($presentacion),0,0,'L',1);
	$pdf->Cell(25,6,number_format($row['existenciaInventario'],2,'.',',').'      ',0,0,'R',1);
	$pdf->Cell(28,6,utf8_decode($row['loteInventario']),0,0,'',1);
	$pdf->Cell(28,6,utf8_decode($row['ddManufactura'].'/'.$row['mmManufactura'].'/'.$row['yyyyManufactura']),0,0,'L',1);
	$pdf->Cell(28,6,utf8_decode($row['ddCaducidad'].'/'.$row['mmCaducidad'].'/'.$row['yyyyCaducidad']),0,0,'L',1);
	$pdf->Cell(2828,6,utf8_decode($row['folioPedimentoImportacion']),0,0,'L',1);
	$pdf->Ln();
}
$pdf->Output("inventario.pdf","I");
?>
