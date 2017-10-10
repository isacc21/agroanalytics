<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/contabilidad/cuentasCobrar.php";
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
		$this->setX(124);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',15);
		$this->Cell(80,10,utf8_decode(' Cuentas por cobrar: Dlls '),0,0,'C',1);
		$this->Ln(15);
		$this->SetFillColor(240,240,240);
		$this->SetFont('Arial','B',10);
		$this->SetX(10);
		$this->Cell(40,6,'FECHA',0,0,'L',1);
		$this->Cell(35,6,'TIPO',0,0,'L',1);
		$this->Cell(40,6,'CONCEPTO',0,0,'L',1);
		$this->Cell(10,6,'',0,0,'L',1);
		$this->Cell(35,6,'CARGOS',0,0,'L',1);
		$this->Cell(34,6,'VENCIMIENTO',0,0,'L',1);
		$this->Ln(8);
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','',10);
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

$cuentasCobrar = new cuentasCobrar($datosConexionBD);


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->setX(124);
$pdf->SetFillColor(228,223,236);
$pdf->SetFont('Arial','',15);
$pdf->Cell(80,10,utf8_decode(' Cuentas por cobrar: Dlls '),0,0,'C',1);
$pdf->Ln(15);

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(40,6,'FECHA',0,0,'L',1);
$pdf->Cell(35,6,'TIPO',0,0,'L',1);
$pdf->Cell(40,6,'CONCEPTO',0,0,'L',1);
$pdf->Cell(10,6,'',0,0,'L',1);
$pdf->Cell(35,6,'CARGOS',0,0,'L',1);
$pdf->Cell(34,6,'VENCIMIENTO',0,0,'L',1);


$pdf->Ln(8);

$clientes = $cuentasCobrar->clientes_cuentas();
$bigtotal = 0;

foreach($clientes as $row){

	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(50);
	$pdf->Cell(48,6,utf8_decode($row['razonSocCliente']),0,0,'L',1);
	$pdf->Ln();
	
	$cuentasCobrar->cliente = $row['rfcCliente'];
	$lista_cuentas = $cuentasCobrar->lista_cuentas_rep();

	$suma = 0;

	foreach($lista_cuentas as $row){


		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','',10);
		$pdf->SetX(10);
		$pdf->Cell(40,6,utf8_decode($row['ddCuentaC'].'/'.$row['mmCuentaC'].'/'.$row['yyyyCuentaC']),0,0,'L',1);
		$pdf->Cell(35,6,utf8_decode('Ingresos A'),0,0,'L',1);
		$pdf->Cell(40,6,utf8_decode($row['folioFactura']),0,0,'L',1);
		$pdf->Cell(15,6,'$',0,0,'',1);
		$pdf->Cell(30,6,number_format($row['importeCuentaC'],2,'.',','),0,0,'R',1);
		$pdf->Cell(34,6,date('d/m/Y', strtotime('+1 month',(strtotime($row['yyyyCuentaC']."/".$row['mmCuentaC']."/".$row['ddCuentaC']))))."   ",0,0,'R',1);
		$pdf->Ln();

		$suma += $row['importeCuentaC'];
	}
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(125);
	$pdf->Cell(15,6,'$',0,0,'',1);
	$pdf->Cell(30,6,number_format($suma,2,'.',','),0,0,'R',1);
	$pdf->Ln(10);	

	$bigtotal += $suma;
}


$pdf->Ln(10);
$pdf->SetFillColor(242,242,242);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(160,8,utf8_decode('Total: '),0,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',12);
$pdf->Cell(34,8,"$ ".number_format($bigtotal,2,'.',',')."  ",1,0,'R',1);
$pdf->Ln(10);
$pdf->Output("cuentasCobrar.pdf","I");
?>
