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
require '../../../models/almacen/ordenesCompra.php';

$ordenesCompra = new ordenesCompra($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){

	$fecha = $_POST['fecha'];

	$dia = $fecha[0].$fecha[1];
	$mes = $fecha[3].$fecha[4];
	$anio = $fecha[6].$fecha[7].$fecha[8].$fecha[9];

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$zahler = 0;

	$fechaCodigo = "H".$dia.$mes.$anio[2].$anio[3];
	$ordenesCompra->codigo = $fechaCodigo."%";
	$encontrados = $ordenesCompra->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioOrdenCompra']!=""){
			$zahler++;
		}
	}

	if($zahler==0){
		$folio = $fechaCodigo."-01";
	}
	else{
		if($zahler < 9){
			$folio = $fechaCodigo."-0".($zahler+1);	
		}
		else{
			$folio = $fechaCodigo."-".($zahler+1);
		}
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

	$recProductos = explode("*hola*",$_POST['codigos']);
	$recCantidades = explode("*hola*",$_POST['cantidades']);

	$recibidos = count($recProductos);
	$contador = $recibidos - 1;

	$total = 0;

	for ($i=0; $i < $contador ; $i++) {
		if($recProductos!=""){ 
			$ordenesCompra->producto = $recProductos[$i];

			$precios = $ordenesCompra->consultarProductosxID();

			foreach($precios as $row){
				$precio = $row['compraProducto'];
			}


			$total += ($precio * $recCantidades[$i]);
			$monto_producto = ($precio * $recCantidades[$i]);


			$ordenesCompra->folio=$folio;
			$ordenesCompra->producto=$recProductos[$i];
			$ordenesCompra->cantidad=$recCantidades[$i];
			$ordenesCompra->monto=$monto_producto;

			$porfin = $ordenesCompra->agregarDetalleOrden();

		}
	}


	

	$ordenesCompra->folio = $folio;
	$ordenesCompra->dd = $dia;
	$ordenesCompra->mm = $mes;
	$ordenesCompra->yyyy = $anio;
	$ordenesCompra->proveedor = $_POST['proveedor'];
	$ordenesCompra->total = $total;
	$ordenesCompra->id=$_SESSION['idUsuario'];
	echo $ordenesCompra->generarOrdenCompra();


//echo $_POST['fecha'].$_POST['cliente'].$_POST['codigo'];
}
else{
	echo "Password incorrecta";
}

?>
