<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/almacen/ordenesCompra.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";

$ordenesCompra = new ordenesCompra($datosConexionBD);

$ordenesCompra->folio = $_REQUEST['codigo'];
$result = $ordenesCompra->consultarOrdenesxID();

foreach($result as $row){
	$_SESSION['fecha'] = $row['ddOrdenCompra']."/".$row['mmOrdenCompra']."/".$row['yyyyOrdenCompra'];
	$ordenesCompra->proveedor = $row['rfcProveedor'];
	$proveedores = $ordenesCompra->consultarProveedores();

	foreach($proveedores as $row){
		$_SESSION['lineauno']= $row['razonSocProveedor'];
		$_SESSION['linea_dos']= $row['numeroExtProveedor']."-".$row['numeroIntProveedor']." ".$row['calleProveedor'];
		$_SESSION['linea_tres']= $row['ciudadProveedor']." ".$row['estadoProveedor']." ".$row['codigoPostalProveedor'];
		$_SESSION['linea_cuatro']= "T. ".$row['telefonoProveedor'];
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
		
		
		$this->Image('../../../../resources/gologo.jpg',5,8,38);
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Ln(4);

		$this->setFont('Arial', 'B', 12);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('BUYER | IMPORTER'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('VENDOR | EXPORTER'),0,0,'L');
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', '', 10);
		$this->Cell(85,0,utf8_decode($_SESSION['lineauno']),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219. Local 8 2DO Piso'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['linea_dos']),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['linea_tres']),0,0,'L');
		$this->Ln(5);

		$this->setX(45);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['linea_cuatro']),0,0,'L');
		$this->Ln(5);


		$this->setFont('Arial', '', 10);
		$this->setX(45);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->setX(125);
		$this->Cell(85,0,utf8_decode($_SESSION['lineacinco']),0,0,'L');
		$this->Ln(10);

		$this->setX(45);
		$this->setFont('Arial', 'B', 12);
		$this->Cell(18,0,utf8_decode('FECHA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->Cell(20,0,utf8_decode($_SESSION['fecha']),0,0,'L');
		$this->setX(125);
		$this->setFont('Arial', 'B', 12);
		$this->Cell(85,0,utf8_decode('SHIP TO'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('COM EX INC. / GO PRODUCTS'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('531 CLARA NOFAL RD SUITE B'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('CALEXICO, CAL 92231'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('CONTACT: CELESTINA RAMIREZ'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(125);
		$this->Cell(85,0,utf8_decode('TELEPHONE: (760) 357 4804'),0,0,'L');
		$this->Ln(15);

		$this->setX(10);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(79);
		$this->Cell(80,10,utf8_decode(' PURCHASE ORDER '),0,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','',12);
		$this->Cell(36,9.8,utf8_decode($_REQUEST['codigo']),1,0,'C',1);
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

$ordenesCompra = new ordenesCompra($datosConexionBD);

$ordenesCompra->folio = $_REQUEST['codigo'];
$result = $ordenesCompra->consultarOrdenesxID();

foreach($result as $row){
	$total_sf = $row['totalOrdenCompra'];
	$total = number_format($total_sf,2, '.', ',');
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(65,6,'PRODUCT',0,0,'L',1);
$pdf->Cell(25,6,'CODE',0,0,'L',1);
$pdf->Cell(30,6,'CONTAINER',0,0,'L',1);
$pdf->Cell(25,6,'QTY',0,0,'C',1);
$pdf->Cell(20,6,'PRICE',0,0,'C',1);
$pdf->Cell(30,6,'TOTAL',0,0,'C',1);

$pdf->Ln();



$pdf->SetFont('Arial','',10);
$pdf->SetX(5);
$pdf->SetFillColor(255,255,255);


$ordenesCompra->folio = $_REQUEST['codigo'];
$detalles = $ordenesCompra->consultarDetalle();

foreach($detalles as $row){
	$producto = $row['codigoProducto'];
	$cantidad = $row['cantidadOrdenCompra'];
	$monto = $row['montoOrdenCompra'];

	$ordenesCompra->producto = $producto;
	$cProducto = $ordenesCompra->consultarProductosxID();
	foreach($cProducto as $row){
		$nombre_producto = $row['nombreProducto'];
		$presentacion_producto = $row['presentacionProducto'];
		$precio_compra = $row['compraProducto'];

	}


	switch($presentacion_producto){
		case 1:
		$presentacion = '5 GAL';
		break;
		case 2:
		$presentacion = '55 GAL';
		break;
		case 3:
		$presentacion = '275 GAL';
		break;
		case 4: 
		$presentacion = 'BULK';
		break;
		case 5:
		$presentacion = 'BAG';
		break;
		case 6:
		$presentacion = 'S.BAG';
		break;

	}

	$unitario = number_format($precio_compra,2, '.', ',');
	$sub = number_format($monto,2, '.', ',');

	$pdf->SetFont('Arial','',10);
	$pdf->SetX(10);
	$pdf->SetFillColor(255,255,255);
	$pdf->Cell(65,7,utf8_decode($nombre_producto),0,0,'L',1);
	$pdf->Cell(25,7,$producto,0,0,'L',1);
	$pdf->Cell(30,7,$presentacion,0,0,'L',1);
	$pdf->Cell(25,7,$cantidad."        ",0,0,'R',1);
	$pdf->Cell(5,7,"$",0,0,'L',1);
	$pdf->Cell(15,7,$unitario." ",0,0,'R',1);
	$pdf->Cell(5,7,"  $",0,0,'L',1);
	$pdf->Cell(25,7,$sub,0,0,'R',1);
	$pdf->Ln();

}

$btotal = number_format($supert,2, '.', ',');
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
