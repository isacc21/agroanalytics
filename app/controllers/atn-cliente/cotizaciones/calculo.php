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
require '../../../models/atn-cliente/cotizaciones.php';

$cotizaciones = new cotizaciones($datosConexionBD);

$cotizaciones->folio = $_POST['codigo'];
$consulta = $cotizaciones->consultarCotizacionesxID();
foreach($consulta as $row){
	$codigoConsulta = $row['folioCotizacion'];
}


if($_POST['cliente']!="null"){
	$recProductos = explode("*hola*",$_POST['codigos']);
	$recCantidades = explode("*hola*",$_POST['cantidades']);
	$recUnidades = explode("*hola*",$_POST['unidades']);

	$recibidos = count($recProductos);
	$contador = $recibidos - 1;

	$total = 0;
	$hola = 0;

	for ($i=0; $i < $contador ; $i++) {
		if($recProductos!=""){ 
			$cotizaciones->cliente = $_POST['cliente'];
			$tipos = $cotizaciones->consultarClientes();

			foreach($tipos as $row){
				$tipo_cliente = $row['tipoCliente'];

				if($tipo_cliente == 1 || $tipo_cliente == 3){
					$cotizaciones->producto = $recProductos[$i];
					$precios = $cotizaciones->consultarProductosxID();
					foreach($precios as $row){
						$grower = $row['iVentaGrwProducto'];
						$growerM = $row['mVentaGrwProducto'];
						$distri = $row['iVentaDisProducto'];
						$distriM = $row['mVentaDisProducto'];
					}
					if($tipo_cliente == 1){
						if($recUnidades[$i]=="Litros"||$recUnidades[$i]=="Ton_Metrica"){
							$total += ($distriM*$recCantidades[$i]);	
						}
						else{
							$total += ($distri*$recCantidades[$i]);		
						}
						
					}
					else{
						if($tipo_cliente == 3){
							if($recUnidades[$i]=="Litros"||$recUnidades[$i]=="Ton_Metrica"){
								$total += ($growerM*$recCantidades[$i]);	
							}
							else{
								$total += ($grower*$recCantidades[$i]);		
							}
						}
					}

				}
				else{
					if($tipo_cliente == 2 || $tipo_cliente == 4){
						$cotizaciones->producto = $recProductos[$i];
						$cotizaciones->cliente = $_POST['cliente'];
						$precioEspe = $cotizaciones->consultarPrecios();

						foreach($precioEspe as $row){
							$monto = $row['iPrecioEspecial'];
							$montoM = $row['mPrecioEspecial'];
						}
						if($recUnidades[$i]=="Litros"||$recUnidades[$i]=="Ton_Metrica"){
							$total += ($montoM*$recCantidades[$i]);	
						}
						else{
							$total += ($monto*$recCantidades[$i]);	
						}
						
					}
				}
			}
		}
	}
	$final = number_format($total,2, '.', ',');
	echo "$ ". $final;
	//echo $cotizaciones->registrarCotizacion();

}
else{
	echo "Seleccione un cliente";
}



//echo $_POST['fecha'].$_POST['cliente'].$_POST['codigo'];

?>
