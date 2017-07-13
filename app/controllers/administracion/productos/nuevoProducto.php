<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 22 Febrero 2017 : 16:38                                                            #
#                                                                                    #
###### nuevoProducto.php #############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 22-FEB-17: 16:39                                                                   #
# IJLM - Se copia CONTROLLER AGREGAR de usuarios                                     #
# IJLM - Se realizan los cambios pertinentes a la sección productos.                 #
#                                                                                    #
# 23-FEB-17: 15:24                                                                   #
# IJLM - Se agrega ELSE a proceso de recepcion de FOLIO en caso de no envio          #
# IJLM - Se documento código existente para mejor entendimiento a futuro             #
#                                                                                    #
# 28-FEB-17: 12:57                                                                   #
# IJLM - Se implementó código para validar fechas incorrectas                        #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PRODUCTOS ################################
require '../../../models/administracion/productos.php';


###### SI SE RECIBE EL FOLIO DEL PRODUCTO, SE PROCESA LA INFORMACION #################
if(isset($_POST['codigo'])){

###### SE CREA EL OBJETO "PRODUCTOS" PARA UTILIZAR LOS METODOS #######################
	$productos = new productos($datosConexionBD);

###### SE RECIBE FOLIO PARA EVITAR REPETIDOS PARA ENVIARLAS AL METODO ################
	$productos->codigo = $_POST['codigo'];


###### SE CONSULTA EN BD POR MEDIO DE FOLIO ##########################################
	$consulta = $productos->consultarProductosID();


###### SE PONE EN UNA VARIABLE EL FOLIO ENCONTRADO ###################################
	foreach ($consulta as $row) {
		$codigo = $row['codigoProducto'];
	}##LLAVE DE FOREACH DEL METODO consultarProductosID() ##############################


###### COMPARACION DEL FOLIO ENCONTRADO CON EL FOLIO REGISTRADO EN FORMULARIO ########
	if($codigo===$_POST['codigo']){
		echo "Código existente";
	}## LLAVE DE IF DE COMPARACION DE FOLIOS

###### EN CASO DE NO COINCIDIR, SE RECIBEN TODAS LAS VARIABLES POR "POST" ############
	else{

###### FECHA PARA REGISTRO COFEPRIS ##################################################
		$fechaCof = $_POST['fechaCof'];

		$diaCof = $fechaCof[0].$fechaCof[1];
		$mesCof = $fechaCof[3].$fechaCof[4];
		$anioCof = $fechaCof[6].$fechaCof[7].$fechaCof[8].$fechaCof[9];

###### FECHA PARA REGISTRO CICOPLAFEST ###############################################
		$fechaCic = $_POST['fechaCic'];

		$diaCic = $fechaCic[0].$fechaCic[1];
		$mesCic = $fechaCic[3].$fechaCic[4];
		$anioCic = $fechaCic[6].$fechaCic[7].$fechaCic[8].$fechaCic[9];

###### FECHA PARA REGISTRO SEMARNAT ##################################################
		$fechaSem = $_POST['fechaSem'];

		$diaSem = $fechaSem[0].$fechaSem[1];
		$mesSem = $fechaSem[3].$fechaSem[4];
		$anioSem = $fechaSem[6].$fechaSem[7].$fechaSem[8].$fechaSem[9];

###### REVISA EN CASO DE NO ENCONTRAR CODIGO DE PRODUCTO #############################
		if($_POST['codigo']==""){
			echo "No se encontró Código de Producto";	
		} ## LLAVE DE IF #################################################################
		else{

			$productos->codigo = $_POST['codigo'];
			$productos->nombre = $_POST['nombre'];
			$productos->presentacion = $_POST['presentacion'];
			$productos->tipo = $_POST['tipo'];
			$productos->caducidad = $_POST['caducidad'];
			$productos->compra = $_POST['compra'];
			$productos->distribuidor = $_POST['distribuidor'];
			$productos->distribuidorM = $_POST['distribuidorM'];
			$productos->grower = $_POST['grower'];
			$productos->growerM = $_POST['growerM'];
			$productos->cofepris = $_POST['cofepris'];
			$productos->ddCof = $diaCof;
			$productos->mmCof = $mesCof;
			$productos->yyyyCof = $anioCof;
			$productos->cicoplafest = $_POST['cicoplafest'];
			$productos->ddCic = $diaCic;
			$productos->mmCic = $mesCic;
			$productos->yyyyCic = $anioCic;
			$productos->semarnat = $_POST['semarnat'];
			$productos->ddSem = $diaSem;
			$productos->mmSem = $mesSem;
			$productos->yyyySem = $anioSem;
			$productos->arancel = $_POST['arancel'];
			$productos->densidad = $_POST['densidad'];


###### SE PROCESA METODO QUE REALIZA EL PROCESO EN LA BASE DE DATOS ##################
			echo $productos->guardarProducto();
			//echo $diaCof.$mesCof.$anioCof;

		}## ELSE SI EXISTE UN CÓDIGO #####################################################

	}## LLAVE DE ELSE ################################################################### 

}## LLAVE DE IF QUE COMPARA SI SE ENVIO INCIALMENTE FOLIO O NO ########################

###### SI NO SE RECIBE FOLIO, SE ENVIA UN ERROR #######################################
else{
	if($_POST['codigo']==""){
		echo "No se encontró Código de Producto";	
	}	
}##LLAVE DE ELSE EN CASO DE NO ENCONTRAR FOLIO ########################################
?>
