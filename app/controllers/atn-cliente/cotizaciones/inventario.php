<?php
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/atn-cliente/cotizaciones.php';

$cotizaciones = new cotizaciones($datosConexionBD);

if(isset($_POST['cliente'])){
	$cotizaciones->producto = $_POST['producto'];
	$num_inventario = $cotizaciones->inventarioEsp();

	foreach($num_inventario as $row){
		$existencia = $row['SUM(existenciaInventario)'];
	}

	if($_POST['cantidad']!=""){
		if(is_null($existencia)){
			echo "No hay producto";
		}
		else{
			switch($_POST['unidad']){
				case "Ton_Corta":
				$pres = " ton. Corta";
				break;
				case "Galones":
				$cantidad = $_POST['cantidad'];
				$press = " gal.";
				break;

				case "Litros":
				$cantidad = $_POST['cantidad']*0.26417205;
				$pres = " lt.";
				break;

				case "Ton_Metrica": 
				$cantidad = $_POST['cantidad']*1.1023;
				$pres = " Ton. Met.";
				break;
			}
			$faltante = $cantidad-$existencia;
			if($faltante<=0){
				echo "Introduce una cantidad";
			}
			else{
				echo (number_format($faltante, 2, '.', ',').$pres);	
			}
			
		}
	}
	else{
		echo "Introduce una cantidad";
	}
}
else{
	echo "Inventario insuficiente";
}

?>
