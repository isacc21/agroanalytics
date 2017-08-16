<?php

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/contabilidad/bancos.php';

session_start();
###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$bancos = new bancos($datosConexionBD);

$bancos->folio = $_POST['folio'];
echo $bancos->eliminarBanco();

//echo $_POST['folio'];;


###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################

?>
