<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 11:25                                                            #
#                                                                                    #
###### actualizarAcreedor.php ########################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 11:25                                                                   #
# IJLM - Se copia CONTROLLER MODIFICAR de productos                                  #
# IJLM - Se realizan los cambios pertinentes a la sección acreedores.                #
#                                                                                    #
# 24-FEB-17: 11:32                                                                   #
# IJLM - Se completaron los cambios                                                  #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/atn-cliente/pedidos.php';

$pedidos = new pedidos($datosConexionBD);

$pedidos->folio = $_POST['codigo'];
$consulta = $pedidos->consultarPedidosxID();
foreach($consulta as $row){
	$codigoConsulta = $row['folioCotizacion'];
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
			$pedidos->producto = $recProductos[$i];
			$preciosEspe = $pedidos->consultarPrecios();
			$precios = $pedidos->consultarProductosxID();
			foreach($preciosEspe as $row){
				$precio_especial = $row['precioEspecial'];
				$rfc = $row['rfcCliente'];
			}
			foreach($precios as $row){
				$precio = $row['ventaProducto'];
			}

			if($rfc==$_POST['cliente']){
				$total += ($precio_especial * $recCantidades[$i]);
			}
			else{
				$total += ($precio * $recCantidades[$i]);
			}
		}
	}
	$final = number_format($total,2, '.', ',');
	echo "$ ". $final;
	//echo $cotizaciones->registrarCotizacion();

}

//echo $_POST['fecha'].$_POST['cliente'].$_POST['codigo'];

?>
