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



$recProductos = explode("*hola*",$_POST['codigos']);

$recibidos = count($recProductos);
$contador = $recibidos - 1;

$final = "";
for ($i=0; $i < $contador ; $i++) {
	if($recProductos!=""){ 
		$cotizaciones->producto = $recProductos[$i];
		$productos = $cotizaciones->consultarProductosxNom();

		foreach($productos as $row){
			$presentacion = $row['presentacionProducto'];
			switch($presentacion){
				case 1:
				$final = $final.'<option value="'.$presentacion.'">Cubeta</option>';
				break;
				case 2:
				$final = $final.'<option value="'.$presentacion.'">Tibor</option>';
				break;
				case 3:
				$final = $final.'<option value="'.$presentacion.'">Tote</option>';
				break;
				case 4:
				$final = $final.'<option value="'.$presentacion.'">Granel</option>';
				break;
				case 5:
				$final = $final.'<option value="'.$presentacion.'">Saco</option>';
				break;
				case 6:
				$final = $final.'<option value="'.$presentacion.'">Super Saco</option>';
				break;
			}
			
		}
	}
}

echo $final;


?>
