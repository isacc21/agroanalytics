<?php 

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/aduanas/importaciones.php';

$importaciones = new importaciones($datosConexionBD);

$prueba = "--";
//echo $_POST['folio']."--".$_POST['fechasM']."--".$_POST['fechasC']."--".$_POST['productos'];

$lista_productos = explode(":",$_POST['productos']);
$lista_facturas = explode(":",$_POST['facturas']);
$lista_fechasM = explode(":",$_POST['fechasM']);
$lista_fechasC = explode(":",$_POST['fechasC']);
$lista_lotes = explode(":",$_POST['lotes']);

$numero = count($lista_productos);



$cont = $numero - 1;
//$prueba = $prueba.$_POST['folio'];

for ($i=0; $i < $cont ; $i++) { 
	$fechaM = $lista_fechasM[$i];
	$diaM = $fechaM[0].$fechaM[1];
	$mesM = $fechaM[3].$fechaM[4];
	$anoM = $fechaM[6].$fechaM[7].$fechaM[8].$fechaM[9];

	$fechaC = $lista_fechasC[$i];
	$diaC = $fechaC[0].$fechaC[1];
	$mesC = $fechaC[3].$fechaC[4];
	$anoC = $fechaC[6].$fechaC[7].$fechaC[8].$fechaC[9];



	$importaciones->folio=$_POST['folio'];
	$importaciones->factura=$lista_facturas[$i];
	$importaciones->producto = $lista_productos[$i];
	$importaciones->diaM = $diaM;
	$importaciones->mesM = $mesM;
	$importaciones->anoM =$anoM;
	$importaciones->diaC = $diaC;
	$importaciones->mesC = $mesC;
	$importaciones->anoC =$anoC;
	$importaciones->lote = $lista_lotes[$i];
	$hola = $importaciones->registrarDetalleFI();

}

echo "Registro exitoso";
?>