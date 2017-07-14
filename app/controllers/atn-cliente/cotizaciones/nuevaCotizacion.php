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

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/atn-cliente/cotizaciones.php';

$cotizaciones = new cotizaciones($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){



	$recProductos = explode("*hola*",$_POST['codigos']);
	$recCantidades = explode("*hola*",$_POST['cantidades']);
	$recUnidades = explode("*hola*",$_POST['unidades']);

	$recibidos = count($recProductos);
	$contador = $recibidos - 1;

	$total = 0;


	$fecha = $_POST['fecha'];

	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];

	

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;

	$fechaCodigo = "H".$dia.$mes.$anio[2].$anio[3];
	$cotizaciones->codigo = $fechaCodigo."%";
	$encontrados = $cotizaciones->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioCotizacion']!=""){
			$zahler++;
		}
	}

	if($zahler==0){
		$folio = $fechaCodigo."-01";
	}
	else{
		if($zahler<9){
			$folio = $fechaCodigo."-0".($zahler+1);
		}
		else{
			$folio = $fechaCodigo."-".($zahler+1);
		}
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

	for ($i=0; $i < $contador ; $i++) {
		if($recProductos!=""&&$recCantidades[$i]!=""){
			$ban = 0;


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
							$monto_producto = $distriM*$recCantidades[$i];
						}
						else{
							$total += ($distri*$recCantidades[$i]);		
							$monto_producto = $distri*$recCantidades[$i];
						}
					}
					else{
						if($recUnidades[$i]=="Litros"||$recUnidades[$i]=="Ton_Metrica"){
							$total += ($growerM*$recCantidades[$i]);
							$monto_producto = $growerM*$recCantidades[$i];	
						}
						else{
							$total += ($grower*$recCantidades[$i]);		
							$monto_producto = $grower*$recCantidades[$i];
						}
					}
					
				}
				else{
					if($tipo_cliente == 2){
						$cotizaciones->producto = $recProductos[$i];
						$cotizaciones->cliente = $_POST['cliente'];
						$precioEspe = $cotizaciones->consultarPrecios();

						foreach($precioEspe as $row){
							$monto = $row['iPrecioEspecial'];
							$montoM = $row['mPrecioEspecial'];
						}
						if($recUnidades[$i]=="Litros"||$recUnidades[$i]=="Ton_Metrica"){
							$total += ($montoM*$recCantidades[$i]);	
							$monto_producto = $montoM*$recCantidades[$i];
						}
						else{
							$total += ($monto*$recCantidades[$i]);
							$monto_producto = $monto*$recCantidades[$i];	
						}
					}
				}
			}


			$cotizaciones->folio=$folio;
			$cotizaciones->producto=$recProductos[$i];
			$cotizaciones->cantidad=$recCantidades[$i];
			$cotizaciones->unidad=$recUnidades[$i];
			$cotizaciones->monto=$monto_producto;

			$porfin = $cotizaciones->registrarDetalle();

		}
		else{
			echo "Ingrese una cantidad";
			$ban = 1;
		}
		
	}


	
	if($ban == 0){
		$cotizaciones->folio = $folio;
		$cotizaciones->dd = $dia;
		$cotizaciones->mm = $mes;
		$cotizaciones->yyyy = $anio;
		$cotizaciones->cliente = $_POST['cliente'];
		$cotizaciones->total = $total;
		$cotizaciones->id=$_SESSION['idUsuario'];
		echo $cotizaciones->registrarCotizacion();
	}
}

else{
	echo "Password incorrecta";
}

?>
