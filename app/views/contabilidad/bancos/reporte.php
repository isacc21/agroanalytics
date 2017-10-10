<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/contabilidad/bancos.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";

$bancos = new bancos($datosConexionBD);
		$bancos->id = $_REQUEST['banco'];
		$result = $bancos->consultarInfoBanco();

		foreach($result as $row){
			$_SESSION['nombre'] = $row['nombreBanco'];
			$_SESSION['moneda'] = $row['monedaBanco'];
		}

		switch($_SESSION['moneda']){
			case 1: 
			$_SESSION['moneda_p'] = "USD";
			break;
			case 2:
			$_SESSION['moneda_p'] = "MXN";
			break;
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
		$this->setX(144);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',15);
		$this->Cell(60,10,utf8_decode(strtoupper($_SESSION['nombre'].' - '.$_SESSION['moneda_p'])),0,0,'C',1);
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

$bancos = new bancos($datosConexionBD);


$bancos->id = $_REQUEST['banco'];
$result = $bancos->consultarInfoBanco();

foreach($result as $row){
	$nombre = $row['nombreBanco'];
	$moneda = $row['monedaBanco'];
}

switch($moneda){
	case 1: 
	$moneda_p = "USD";
	break;
	case 2:
	$moneda_p = "MXN";
	break;
}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->setX(144);
$pdf->SetFillColor(228,223,236);
$pdf->SetFont('Arial','',15);
$pdf->Cell(60,10,utf8_decode(strtoupper($nombre.' - '.$moneda_p)),0,0,'C',1);
$pdf->Ln(15);

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(20,6,'FECHA',0,0,'L',1);
$pdf->Cell(25,6,'MET. PAGO',0,0,'L',1);
$pdf->Cell(30,6,'CARGO',0,0,'L',1);
$pdf->Cell(30,6,'ABONO',0,0,'L',1);
$pdf->Cell(30,6,'BALANCE',0,0,'L',1);
$pdf->Cell(30,6,'CONCEPTO',0,0,'L',1);
$pdf->Cell(25,6,'DESCRIP.',0,0,'L',1);


$pdf->Ln(8);

$bancos->id = $_REQUEST['banco'];
$estado_cuenta = $bancos->estadoCuentaP();
$bigtotal = 0;

foreach($estado_cuenta as $row){



	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(10);
	$pdf->Cell(20,6,utf8_decode($row['ddBanco'].'/'.$row['mmBanco'].'/'.$row['yyyyBanco']),0,0,'L',1);
	$pdf->Cell(25,6,utf8_decode($row['pagoBanco']),0,0,'L',1);
	

	$cargo = 0.00;
	$abono = 0.00;

	if($row['tipoBanco']==1){
		$cargo = $row['montoBanco'];
		$bigtotal += $cargo;
	}
	else{
		$abono = $row['montoBanco'];
		$bigtotal -= $abono;
	}


	$pdf->Cell(3,6,utf8_decode('$'),0,0,'L',1);
	$pdf->Cell(27,6,number_format($cargo,2,'.',',').'    ',0,0,'R',1);
	$pdf->Cell(3,6,utf8_decode('$'),0,0,'L',1);
	$pdf->Cell(27,6,number_format($abono,2,'.',',').'    ',0,0,'R',1);
	$pdf->Cell(3,6,utf8_decode('$'),0,0,'L',1);
	$pdf->Cell(27,6,number_format($bigtotal,2,'.',',').'    ',0,0,'R',1);


	$pdf->Cell(30,6,utf8_decode($row['conceptoBanco']),0,0,'L',1);
	$pdf->Cell(25,6,utf8_decode($row['descBanco']),0,0,'L',1);
	$pdf->Ln();

	$suma += $row['importeCuentaC'];
}


$pdf->Ln(10);
$pdf->SetFillColor(242,242,242);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(160,8,utf8_decode('Total: '),0,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',12);
$pdf->Cell(34,8,"$ ".number_format($bigtotal,2,'.',',')."  ",1,0,'R',1);
$pdf->Ln(10);
$pdf->Output("estadocuenta.pdf","I");
?>
