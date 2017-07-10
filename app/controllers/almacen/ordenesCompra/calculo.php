<?php
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/almacen/ordenesCompra.php';

$ordenesCompra = new ordenesCompra($datosConexionBD);

$ordenesCompra->folio = $_POST['codigo'];
$consulta = $ordenesCompra->consultarOrdenesxID();
foreach($consulta as $row){
	$codigoConsulta = $row['folioOrdenCompra'];
}

if($_POST['codigo']==$codigoConsulta){
	echo "Error";
}
else{

	$recProductos = explode("*hola*",$_POST['codigos']);
	$recCantidades = explode("*hola*",$_POST['cantidades']);

	$recibidos = count($recProductos);
	$contador = $recibidos - 1;

	$total = 0;
	$hola = 0;

	for ($i=0; $i < $contador ; $i++) {
		if($recProductos!=""){ 
			$ordenesCompra->producto = $recProductos[$i];
			$precios = $ordenesCompra->consultarProductosxID();
			
			foreach($precios as $row){
				$precio = $row['compraProducto'];
			}
			$total += ($precio * $recCantidades[$i]);
		}
	}
	$final = number_format($total,2, '.', ',');
	echo "$ ". $final;
	//echo $ordenesCompra->registrarCotizacion();

}

//echo $_POST['fecha'].$_POST['cliente'].$_POST['codigo'];

?>
