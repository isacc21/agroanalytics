<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 10 Marzo 2017 : 14:49                                                              #
#                                                                                    #
###### nvosPrecios.php ###############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 10-MAR-17: 14:49                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de proveedores                                  #
# IJLM - Se realizan los cambios pertinentes a la sección clientes                   #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/administracion/clientes.php';


###### SE CREA EL OBJETO "PROVEEDORES" PARA UTILIZAR LOS METODOS #####################
$clientes = new clientes($datosConexionBD);
if(isset($_POST['rfc'])){
	$clientes->rfc = $_POST['rfc'];
	$prueba = $clientes->limpiarPE();

	if($prueba == "Limpio"){



		$envioProductos = explode(":",$_POST['id']);
		$envioPrecios = explode(":",$_POST['precios']);
		$envioPreciosM = explode(":",$_POST['preciosM']);

		$countUno = count($envioProductos);
		$countDos = count($envioPrecios);

		$listaProductos = $clientes->consultarProductos();
		$i = 0;
		$cambiados = 0;
		$iguales = 0;
		foreach ($listaProductos as $row) {
			$codigo = $row['codigoProducto'];
			$venta = $row['ventaProducto'];



			if($envioPrecios[$i]!=$venta){
				$clientes->codigo = $codigo;
				$clientes->precio = $envioPrecios[$i];
				$clientes->precioM = $envioPreciosM[$i];
				$clientes->rfc = $_POST['rfc'];

				$metodo = $clientes->guardarPrecio();

				if($metodo == "listo"){
					$cambiados ++;
				}
			}
			else{
				$iguales ++;
			}
			$i++;
		}
		echo "Productos registrados con éxito";
	}
	else{
		echo "Error";
	}
}
else{
	echo "Error";
}

//$listaProductos = $clientes->consultarProductos();

/*if($countUno === $countDos){

	$x=0;
	/*foreach ($listaProductos as $row) {
		$codigo = $row['codigoProducto'];
		$venta = $row['ventaProducto'];

		if($envioProductos[$x]==$codigo){
			echo "-".$x."-";
		}
		else{
			echo "-MAL-";
		}
		if($envioPrecios[$x]==$venta){
			echo "_".$x."_";
		}
		else{
			echo "_MAL_";
		}
		$x++;
	}*/

//echo $_POST['precios'];*/


/*}
else{
	echo "Prueba";
}*/











/*$envioProductos = explode(":",$_POST['productos']);
$envioPrecios = explode(":",$_POST['precios']);

$print=  $envioProductos[0]." ".$envioProductos[1]." ".$envioProductos[2]." ".$envioProductos[3]." ".$envioProductos[4];

$result = count($envioPrecios);

//echo $result	;
echo $_POST["id"];*/
?>