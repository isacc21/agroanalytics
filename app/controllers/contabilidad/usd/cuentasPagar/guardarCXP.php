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
require '../../../../models/contabilidad/dolares/cuentasPagar.php';



###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
$usdCuentasP = new usdCuentasP($datosConexionBD);


$proveedor = $_POST['proveedor'];
$acreedor = $_POST['acreedor'];
if($proveedor!="null"&&$acreedor!="null"){
	echo "Seleccione solo Proveedor o Acreedor\n".$proveedor." ".$acreedor;
}
else{
	if(md5($_POST['pass'])==$_SESSION['password']){
		$fechaCXP = $_POST['fechaCXP'];

		$diaCXP = $fechaCXP[0].$fechaCXP[1];
		$mesCXP = $fechaCXP[3].$fechaCXP[4];
		$anioCXP = $fechaCXP[6].$fechaCXP[7].$fechaCXP[8].$fechaCXP[9];

		/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
		$contador = 0;

		$fechaCodigo = "E".$diaCXP.$mesCXP.$anioCXP[2].$anioCXP[3];
		$usdCuentasP->codigo = $fechaCodigo."%";
		$encontrados = $usdCuentasP->consultarCodigos();
		foreach($encontrados as $row){
			if($row['folioCuentaP']!=""){
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



		if($proveedor=="null"){
			$proveedor ="";
		}
		if($acreedor == "null"){
			$acreedor ="";
		}
		$usdCuentasP->folio = $folio;
		$usdCuentasP->dd = $diaCXP;
		$usdCuentasP->mm = $mesCXP;
		$usdCuentasP->yyyy = $anioCXP;
		$usdCuentasP->proveedor = $proveedor;
		$usdCuentasP->acreedor = $acreedor;
		$usdCuentasP->factura = $_POST['factura'];
		$usdCuentasP->monto = $_POST['monto'];
		$usdCuentasP->comentario = $_POST['comentario'];
		$usdCuentasP->id = $_SESSION['idUsuario'];

		echo $usdCuentasP->crearCuentaP();
	}
	else{
		echo "Password incorrecta\n".md5($_POST['pass'])."\n@".$_SESSION['password']."@";
	}
}

?>
