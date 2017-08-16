<?php
session_start();
date_default_timezone_set('America/Tijuana');

include '../../../../config.php';
require "../../../models/aduanas/declaraciones.php";
require "../../../../resources/fpdf/fpdf.php";
require "../../../../resources/fpdf/font/segoeuisl.php";
require "../../../../resources/fpdf/font/segoeuib.php";
require "../../../../resources/fpdf/font/segoeuil.php";
require "../../../../resources/fpdf/font/seguisb.php";


$declaraciones = new declaraciones($datosConexionBD);

$declaraciones->folio = $_REQUEST['codigo'];
$lista = $declaraciones->consultarDeclaracionesxID();
foreach($lista as $row){
	$fecha = $row['ddDeclaracion']."/".$row['mmDeclaracion']."/".$row['yyyyDeclaracion'];
}

$_SESSION['fecha'] = $fecha;

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
		
		
		$this->Image('../../../../resources/gologo.jpg',7,6,42);
		$this->AddFont('segoeuisl','');
		$this->AddFont('segoeuib','');
		$this->AddFont('segoeuil','');
		$this->AddFont('seguisb','');
		$this->Ln(4);


		$this->setFont('Arial', '', 16);
		$this->setX(55);
		$this->Cell(60,0,utf8_decode('GO PRODUCTS S DE RL DE CV'),0,0,'L');
		$this->setX(137);
		$this->Ln(7);

		$this->setFont('Arial', '', 10);
		$this->setX(55);
		$this->Cell(60,0,utf8_decode('Fco. I. Madero #1219-8. Local 8 2DO Piso'),0,0,'L');
		$this->setX(137);
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(55);
		$this->Cell(60,0,utf8_decode('Colonia Segunda Sección'),0,0,'L');
		$this->setX(137);
		$this->Ln(5);

		$this->setX(55);
		$this->setFont('Arial', '', 10);
		$this->Cell(60,0,utf8_decode('Mexicali, Baja California 21100'),0,0,'L');
		$this->Ln(5);

		$this->setFont('Arial', '', 10);
		$this->setX(55);
		$this->Cell(60,0,utf8_decode('México'),0,0,'L');
		$this->Ln(10);

		$this->setX(10);
		$this->setFont('Arial', 'B', 14);
		$this->Cell(18,7.8,utf8_decode('FECHA: '),0,0,'L');
		$this->setFont('Arial', '', 10);
		$this->setX(40);
		$this->Cell(30,7,utf8_decode($_SESSION['fecha']),1,0,'C');
		$this->Ln(10);

		$this->setX(10);
		$this->SetFillColor(228,223,236);
		$this->SetFont('Arial','',18);
		$this->Cell(99);
		$this->Cell(60,10,utf8_decode(' DECLARACIÓN '),0,0,'C',1);
		$this->SetFillColor(255,255,255);
		$this->SetFont('Arial','',12);
		$this->Cell(35,9.8,utf8_decode($_REQUEST['codigo']),1,0,'C',1);
		$this->Ln(25);
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

$declaraciones = new declaraciones($datosConexionBD);

$declaraciones->folio = $_REQUEST['codigo'];
$lista = $declaraciones->consultarDeclaracionesxID();


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->Addpage();

foreach($lista as $row){
	$rfc_transportista = $row['rfcTransportista'];
	
	$tipo_extra = $row['tipoTransporte'];
	
	$placasmx_tracto = $row['placasMXDeclaracion'];
	$placasus_tracto = $row['placasUSDeclaracion'];
	$eco_tracto = $row['noEcoTractoDeclaracion'];

	$placas_extra = $row['placasXtraDeclaracion'];
	$eco_extra = $row['noEcoXtraDeclaracion'];

	$peso = $row['pesoTotalDeclaracion'];

	$folio_importacion = $row['folioImportacion'];

	$declaraciones->transportista = $rfc_transportista;
	$result = $declaraciones->consultarTransportistaxID();

	foreach($result as $row){
		$nombre_transp = $row['razonSocTransportista'];
		$id_fiscal = $row['idFiscalTransportista'];
		$sccac = $row['sccacTransportista'];
		$caat = $row['caatTransportista'];
	}


	switch($tipo_extra){
		case 1: 
		$remolque = 'Tanque';
		break;
		case 2:
		$remolque = 'Plataforma';
		break;
		case 3:
		$remolque = ' ';
		break;
	}

	$pdf->setX(10);
	$pdf->setFont('Arial', 'B', 12);
	$pdf->Cell(18,0,utf8_decode('INFORMACIÓN DEL TRANSPORTISTA '),0,0,'L');
	$pdf->Ln(5);

	$pdf->setX(10);
	$pdf->setFont('Arial', 'B', 12);
	$pdf->Cell(18,7.8,utf8_decode('CHOFER: '),0,0,'L');
	$pdf->setFont('Arial', '', 10);
	$pdf->setX(40);
	$pdf->Cell(70,7,utf8_decode($nombre_transp),1,0,'C');
	$pdf->Ln(15);

	$pdf->setFont('Arial', '', 10);
	$pdf->setX(46);
	$pdf->Cell(68,5,utf8_decode('Tractocamión'),1,0,'C');
	$pdf->setX(115);
	$pdf->Cell(45,5,utf8_decode($remolque),1,0,'C');
	$pdf->Ln(6);

	$pdf->SetFillColor(240,240,240);
	$pdf->SetFont('Arial','B',10);
	$pdf->SetX(10);
	$pdf->Cell(35,6,' Nombre',0,0,'L',1);
	$pdf->Cell(23,6,'Placas',0,0,'C',1);
	$pdf->Cell(23,6,'Placas',0,0,'C',1);
	$pdf->Cell(23,6,utf8_decode('Número'),0,0,'C',1);
	$pdf->Cell(23,6,'Placas',0,0,'C',1);
	$pdf->Cell(23,6,utf8_decode('Número'),0,0,'C',1);
	$pdf->Cell(20,11, 'CAAT',0,0,'C',1);
	$pdf->Cell(20,11, 'SCCAC' ,0,0,'C',1);
	$pdf->Ln(5);

	$pdf->SetX(10);
	$pdf->Cell(35,6,' Transportista',0,0,'L',1);
	$pdf->Cell(23,6,'MX',0,0,'C',1);
	$pdf->Cell(23,6,'US',0,0,'C',1);
	$pdf->Cell(23,6, utf8_decode('Económico'),0,0,'C',1);
	$pdf->Cell(23,6,'US',0,0,'C',1);
	$pdf->Cell(23,6, utf8_decode('Económico'),0,0,'C',1);
	
	$pdf->Ln(7);

	$pdf->SetFillColor(255,255,255);
	$pdf->SetFont('Arial','',9);
	$pdf->SetX(10);
	$pdf->Cell(35,6,utf8_decode($nombre_transp),0,0,'L',1);
	$pdf->Cell(23,6,utf8_decode($placasmx_tracto),0,0,'C',1);
	$pdf->Cell(23,6,utf8_decode($placasus_tracto),0,0,'C',1);
	$pdf->Cell(23,6,utf8_decode($eco_tracto),0,0,'C',1);
	$pdf->Cell(23,6,utf8_decode($placas_extra),0,0,'C',1);
	$pdf->Cell(23,6,utf8_decode($eco_extra),0,0,'C',1);
	$pdf->Cell(20,6,utf8_decode($caat),0,0,'C',1);
	$pdf->Cell(20,6,utf8_decode($sccac) ,0,0,'C',1);
	$pdf->Ln(20);

}

$pdf->setX(10);
$pdf->setFont('Arial', 'B', 12);
$pdf->Cell(18,0,utf8_decode('PESO TOTAL POR PRODUCTO '),0,0,'L');
$pdf->Ln(5);

$pdf->SetFillColor(240,240,240);
$pdf->SetFont('Arial','B',10);
$pdf->SetX(10);
$pdf->Cell(45,8,'Nombre',0,0,'L',1);
$pdf->Cell(23,8,'Cant',0,0,'C',1);
$pdf->Cell(23,8,'Unidad',0,0,'C',1);
$pdf->Cell(18,8,utf8_decode('Peso'),0,0,'C',1);
$pdf->Cell(23,8,'Unidad',0,0,'C',1);
$pdf->Cell(18,8,utf8_decode('Peso'),0,0,'C',1);
$pdf->Cell(20,8, 'Unidad',0,0,'C',1);
$pdf->Cell(20,8, 'Factura' ,0,0,'C',1);
$pdf->Ln(8);


$declaraciones->importacion = $folio_importacion;
$result = $declaraciones->consultaodcs();

foreach($result as $row){
	$factura = $row['folioFactura'];

	$declaraciones->folio = $row['folioOrdenCompra'];
	$lista_productos = $declaraciones->consultarDetalleOC();

	foreach($lista_productos as $row){
		$cantidad = $row['cantidadOrdenCompra'];

		$declaraciones->producto = $row['codigoProducto'];
		$detalle_producto = $declaraciones->consultarProductosxID();

		foreach($detalle_producto as $row){
			$nombre_producto = $row['nombreProducto'];
			$presentacion_producto = $row['presentacionProducto'];
			$densidad_producto = $row['densidadProducto'];

			switch($presentacion_producto){
				case 1:
				case 2:
				case 3:
				case 4:
				$pres = 'Galón';
				break;
				case 5:
				case 6:
				$pres = 'Libra';
				break;
			}
			$peso_producto = $densidad_producto * $cantidad;
			$peso_metrico = $peso_producto * 0.4536;
			
			$pdf->SetFillColor(255,255,255);
			$pdf->SetFont('Arial','',9);
			$pdf->SetX(10);
			$pdf->Cell(52,6,utf8_decode($nombre_producto),0,0,'L',1);
			$pdf->Cell(20,6,utf8_decode(number_format($cantidad,2,'.',',')."   "),0,0,'R',1);
			$pdf->Cell(19,6,utf8_decode($pres),0,0,'C',1);
			$pdf->Cell(18,6,utf8_decode(number_format($peso_producto,2, '.', ',')),0,0,'R',1);
			$pdf->Cell(23,6,utf8_decode('Libras'),0,0,'C',1);
			$pdf->Cell(18,6,utf8_decode(number_format($peso_metrico,2, '.', ',')),0,0,'R',1);
			$pdf->Cell(20,6,utf8_decode('Kilos'),0,0,'C',1);
			$pdf->Cell(20,6,utf8_decode($factura) ,0,0,'C',1);
			$pdf->Ln(5);
			$peso_kilos +=$peso_metrico;
		}
	}
}

$ptotal = number_format($peso_kilos,2, '.', ',');
$pdf->Ln(15);
$pdf->SetFillColor(242,242,242);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(130,8,utf8_decode('Total: '),0,0,'R',1);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','',12);
$pdf->Cell(34,8, $ptotal,1,0,'R',1);
$pdf->SetFillColor(242,242,242);
$pdf->SetX(174.5);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(30,8,utf8_decode('Kilos'),0,0,'C',1);
$pdf->Ln(15);



$pdf->Output($_REQUEST['codigo'].".pdf","I");
?>
