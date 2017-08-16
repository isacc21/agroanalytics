<?php

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/contabilidad/cuentasPagar.php';

session_start();
###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$cuentasPagar = new cuentasPagar($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){

	$cuentasPagar->folio = $_POST['folio'];
	echo $cuentasPagar->saldarCuenta();

//echo $folio;



}
else{
	echo "Contraseña incorrecta";
}



###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################

?>
