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
require '../../../models/aduanas/importaciones.php';

$importaciones = new importaciones($datosConexionBD);


$recFacturas = explode("*hola*",$_POST['facturas']);

$recibidos = count($recFacturas);
$contador = $recibidos - 1;

$total = 0;
$hola = 0;
$prueba = "";

for ($i=0; $i < $contador ; $i++) {
	if($recFacturas!=""){ 
		$importaciones->factura = $recFacturas[$i];
		$lista_facturas = $importaciones->consultarMontosFac();
		foreach($lista_facturas as $row){
			$monto_factura = $row['totalOrdenCompra'];	
		}


		$total += $monto_factura;	
	}
}
$final = number_format($total,2, '.', ',');
echo $final;

?>
