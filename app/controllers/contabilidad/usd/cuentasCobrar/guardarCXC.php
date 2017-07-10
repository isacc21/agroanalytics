<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 03 Abril 2017 : 11:32                                                              #
#                                                                                    #
###### guardarCXC.php ################################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 03-ABR-17: 11:33                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de bancos                                       #
# IJLM - Se realizan los cambios pertinentes a la sección cuentas por cobrar dolares #
######################################################################################

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../../models/contabilidad/dolares/cuentasCobrar.php';

$folio = "";

###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$usdCuentasC = new usdCuentasC($datosConexionBD);

if(md5($_POST['pass'])==$_SESSION['password']){
	$fechaCXC = $_POST['fechaCXC'];

	$diaCXC = $fechaCXC[0].$fechaCXC[1];
	$mesCXC = $fechaCXC[3].$fechaCXC[4];
	$anioCXC = $fechaCXC[6].$fechaCXC[7].$fechaCXC[8].$fechaCXC[9];

	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
	$contador = 0;

	$fechaCodigo = "C".$diaCXC.$mesCXC.$anioCXC[2].$anioCXC[3];
	$usdCuentasC->codigo = $fechaCodigo."%";
	$encontrados = $usdCuentasC->consultarCodigos();
	foreach($encontrados as $row){
		if($row['folioCuentaC']!=""){
			$contador++;
		}
	}

	if($contador==0){
		$folio = $fechaCodigo."-1";
	}
	else{
		$folio = $fechaCodigo."-".($contador+1);
	}
	/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

	$usdCuentasC->folio = $folio;
	$usdCuentasC->dd = $diaCXC;
	$usdCuentasC->mm = $mesCXC;
	$usdCuentasC->yyyy = $anioCXC;
	$usdCuentasC->cliente = $_POST['cliente'];
	$usdCuentasC->factura = $_POST['factura'];
	$usdCuentasC->monto = $_POST['monto'];
	$usdCuentasC->comentario = $_POST['comentario'];
	$usdCuentasC->id = $_SESSION['idUsuario'];

	echo $usdCuentasC->crearCuentaC();
}
else{
	echo "Password incorrecta\n".md5($_POST['pass'])."\n@".$_SESSION['password']."@";
}

?>
