<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Marzo 2017 : 12:35                                                              #
#                                                                                    #
###### usuarios/form_permisos.php ####################################################
#                                                                                    #
# Archivo sin estructura del formuario de permisos de usuario para ser recibido por  #
# JQuery en index de "Usuarios"                                                      #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 01-MAR-17: 12:34                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
# IJLM - Se agrega INCLUDE para los datos de conexión                                #
# IJLM - Se agrega REQUIRE para libreria de usuarios                                 #
#                                                                                    #
# 02-MAR-17: 12:23                                                                   #
# IJLM - Se crearon variables PHP para checked de checkboxex.                        #
# IJLM - Se crearon grupos de checked con variables, name y ID                       # 
#                                                                                    # 
# 07-MAR-17: 10:55                                                                   #
# IJLM - Se cambian valores para hacer más de una acción                             #
#                                                                                    #
# 15-MAR-17: 03:53                                                                   #
# IJLM - Se eliminaron plugins por mal funcionamiento de dropdown de usuario         #
######################################################################################

###### ESTRUCTURA DE CODIGO PARA IMPRIMIR ERRORES ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/usuarios.php';


###### VARIABLES PARA REALIZAR EL CHECKED DE PERMISOS EN MODIFICACION ################
$sesionAc=$_SESSION['tipo'];

$provConsulta="";
$provCrear="";
$provModificar="";
$provEliminar="";

$acreConsulta="";
$acreCrear="";
$acreModificar="";
$acreEliminar="";

$transConsulta="";
$transCrear="";
$transModificar="";
$transEliminar="";

$clientConsulta="";
$clientCrear="";
$clientModificar="";
$clientEliminar="";

$productConsulta="";
$productCrear="";
$productModificar="";
$productEliminar="";

$aduanalConsulta="";
$aduanalCrear="";
$aduanalModificar="";
$aduanalEliminar="";

$userConsulta="";
$userCrear="";
$userModificar="";
$userEliminar="";

$pedidoConsulta="";
$pedidoCrear="";
$pedidoModificar="";
$pedidoEliminar="";

$cotizacionConsulta="";
$cotizacionCrear="";
$cotizacionModificar="";
$cotizacionEliminar="";

$importacionConsulta="";
$importacionCrear="";
$importacionModificar="";
$importacionEliminar="";

$declaracionConsulta="";
$declaracionCrear="";
$declaracionModificar="";
$declaracionEliminar="";

$inventarioConsulta="";
$inventarioCrear="";
$inventarioModificar="";
$inventarioEliminar="";

$cargaConsulta="";
$cargaCrear="";
$cargaModificar="";
$cargaEliminar="";

$compraConsulta="";
$compraCrear="";
$compraModificar="";
$compraEliminar="";

$remisionConsulta="";
$remisionCrear="";
$remisionModificar="";
$remisionEliminar="";

$bancosConsulta="";
$bancosCrear="";
$bancosModificar="";
$bancosEliminar="";

$cxcConsulta="";
$cxcCrear="";
$cxcModificar="";
$cxcEliminar="";

$cxpConsulta="";
$cxpCrear="";
$cxpModificar="";
$cxpEliminar="";

$proveedores = "";
$acreedores = "";
$transportistas = "";
$clientes = "";
$productos = "";
$aduanal = "";
$usuario = "";
$pedidos = "";
$cotizaciones = "";
$importaciones = "";
$declaraciones = "";
$inventario = "";
$carga = "";
$compra = "";
$remisiones = "";
$bancos = "";
$cxc = "";
$cxp = "";
$idPermiso="";
$idUsuario="";


###### RECEPCION DE ID USUARIO #######################################################
$idUsuario=(isset($_REQUEST['idUsuario']))?$_REQUEST['idUsuario']:"";

###### VALOR DE BOTON DE FORMULARIO ##################################################
$_SESSION['boton']=1;

###### IF EN CASO DE QUE SE RECIBA UN DATO ###########################################
if (isset($idUsuario)){

###### CREACION DEL OBJETO USUARIOS ##################################################
	$usuarios = new usuarios($datosConexionBD);

	$usuarios->id=$idUsuario;

###### RESULTADO DE CONSULTA DEL METODO CONSULTAR USUARIOS POR ID ####################
	$result = $usuarios->consultarPermisos();


###### FOREACH DE CONSULTA EN BASE DE DATOS ##########################################
	foreach($result as $row){
		$idPermiso = $row['idPermiso'];
		$proveedores = $row['proveedoresPermiso'];
		$acreedores = $row['acreedoresPermiso'];
		$transportistas = $row['transportistasPermiso'];
		$clientes = $row['clientesPermiso'];
		$productos = $row['productosPermiso'];
    $aduanal = $row['aduanalPermiso'];
    $usuario = $row['usuariosPermiso'];
    $pedidos = $row['pedidosPermiso'];
    $cotizaciones = $row['cotizacionesPermiso'];
    $importaciones = $row['importacionesPermiso'];
    $declaraciones = $row['declaracionesPermiso'];
    $inventario = $row['inventarioPermiso'];
    $carga = $row['cargaPermiso'];
    $compra = $row['compraPermiso'];
    $remisiones = $row['remisionesPermiso'];
    $bancos = $row['bancosPermiso'];
    $cxc = $row['cxcPermiso'];
    $cxp = $row['cxpPermiso'];

  }## LLAVE DE FOREACH ###############################################################
  //echo $aduanal;

  
#### CHECKED DE PROVEEDORES ##########################################################
  if($proveedores!=""){
    if($proveedores[0]=="1"){
      $provConsulta="checked";    
    }
    if($proveedores[1]=="2"){
      $provCrear="checked";  
    }
    if($proveedores[2]=="3"){
      $provModificar="checked";
    }
    if($proveedores[3]=="4"){
      $provEliminar="checked";  
    }
  }
  

#### CHECKED DE ACREEDORES ##########################################################

  if($acreedores!=""){
    if($acreedores[0]=="1"){
      $acreConsulta="checked";    
    }
    if($acreedores[1]=="2"){
      $acreCrear="checked";  
    }
    if($acreedores[2]=="3"){
      $acreModificar="checked";
    }
    if($acreedores[3]=="4"){
      $acreEliminar="checked";  
    }
  }

#### CHECKED DE TRANSPORTISTAS ##########################################################
  if($transportistas!=""){
    if($transportistas[0]=="1"){
      $transConsulta="checked";    
    }
    if($transportistas[1]=="2"){
      $transCrear="checked";  
    }
    if($transportistas[2]=="3"){
      $transModificar="checked";
    }
    if($transportistas[3]=="4"){
      $transEliminar="checked";  
    }
  }

#### CHECKED DE CLIENTES ##########################################################

  if($clientes!=""){
    if($clientes[0]=="1"){
      $clientConsulta="checked";    
    }
    if($clientes[1]=="2"){
      $clientCrear="checked";  
    }
    if($clientes[2]=="3"){
      $clientModificar="checked";
    }
    if($clientes[3]=="4"){
      $clientEliminar="checked";  
    }
  }

#### CHECKED DE PRODUCTOS ##########################################################

  if($productos!=""){
    if($productos[0]=="1"){
      $productConsulta="checked";    
    }
    if($productos[1]=="2"){
      $productCrear="checked";  
    }
    if($productos[2]=="3"){
      $productModificar="checked";
    }
    if($productos[3]=="4"){
      $productEliminar="checked";  
    }
  }

#### CHECKED DE AGENCIA ADUANAL ##########################################################

  if($aduanal!=""){
    if($aduanal[0]=="1"){
      $aduanalConsulta="checked";    
    }
    if($aduanal[1]=="2"){
      $aduanalCrear="checked";  
    }
    if($aduanal[2]=="3"){
      $aduanalModificar="checked";
    }
    if($aduanal[3]=="4"){
      $aduanalEliminar="checked";  
    }
  }

#### CHECKED DE PEDIDOS ##########################################################
  if($pedidos!=""){
    if($pedidos[0]=="1"){
      $pedidoConsulta="checked";    
    }
    if($pedidos[1]=="2"){
      $pedidoCrear="checked";  
    }
    if($pedidos[2]=="3"){
      $pedidoModificar="checked";
    }
    if($pedidos[3]=="4"){
      $pedidoEliminar="checked";  
    }
  }

#### CHECKED DE COTIZACIONES ##########################################################
  if($cotizaciones!=""){
    if($cotizaciones[0]=="1"){
      $cotizacionConsulta="checked";    
    }
    if($cotizaciones[1]=="2"){
      $cotizacionCrear="checked";  
    }
    if($cotizaciones[2]=="3"){
      $cotizacionModificar="checked";
    }
    if($cotizaciones[3]=="4"){
      $cotizacionEliminar="checked";  
    }
  }

#### CHECKED DE IMPORTACIONES ##########################################################
  if($importaciones!=""){
    if($importaciones[0]=="1"){
      $importacionConsulta="checked";    
    }
    if($importaciones[1]=="2"){
      $importacionCrear="checked";  
    }
    if($importaciones[2]=="3"){
      $importacionModificar="checked";
    }
    if($importaciones[3]=="4"){
      $importacionEliminar="checked";  
    }
  }

#### CHECKED DE DECLARACIONES ##########################################################
  if($declaraciones!=""){
    if($declaraciones[0]=="1"){
      $declaracionConsulta="checked";    
    }
    if($declaraciones[1]=="2"){
      $declaracionCrear="checked";  
    }
    if($declaraciones[2]=="3"){
      $declaracionModificar="checked";
    }
    if($declaraciones[3]=="4"){
      $declaracionEliminar="checked";  
    }
  }

#### CHECKED DE INVENTARIO ##########################################################
  if($inventario!=""){
    if($inventario[0]=="1"){
      $inventarioConsulta="checked";    
    }
    if($inventario[1]=="2"){
      $inventarioCrear="checked";  
    }
    if($inventario[2]=="3"){
      $inventarioModificar="checked";
    }
    if($inventario[3]=="4"){
      $inventarioEliminar="checked";  
    }
  }

#### CHECKED DE ORDENES DE CARGA ##########################################################
  if($carga!=""){
    if($carga[0]=="1"){
      $cargaConsulta="checked";    
    }
    if($carga[1]=="2"){
      $cargaCrear="checked";  
    }
    if($carga[2]=="3"){
      $cargaModificar="checked";
    }
    if($carga[3]=="4"){
      $cargaEliminar="checked";  
    }
  }

#### CHECKED DE ORDENES DE COMPRA ##########################################################
  if($compra!=""){
    if($compra[0]=="1"){
      $compraConsulta="checked";    
    }
    if($compra[1]=="2"){
      $compraCrear="checked";  
    }
    if($compra[2]=="3"){
      $compraModificar="checked";
    }
    if($compra[3]=="4"){
      $compraEliminar="checked";  
    }
  }

#### CHECKED DE REMISIONES ##########################################################
  if($remisiones!=""){
    if($remisiones[0]=="1"){
      $remisionConsulta="checked";    
    }
    if($remisiones[1]=="2"){
      $remisionCrear="checked";  
    }
    if($remisiones[2]=="3"){
      $remisionModificar="checked";
    }
    if($remisiones[3]=="4"){
      $remisionEliminar="checked";  
    }
  }

#### CHECKED DE BANCOS ##########################################################
  if($bancos!=""){
    if($bancos[0]=="1"){
      $bancosConsulta="checked";    
    }
    if($bancos[1]=="2"){
      $bancosCrear="checked";  
    }
    if($bancos[2]=="3"){
      $bancosModificar="checked";
    }
    if($bancos[3]=="4"){
      $bancosEliminar="checked";  
    }
  }

#### CHECKED DE CUENTAS POR COBRAR ##########################################################
  if($cxc!=""){
    if($cxc[0]=="1"){
      $cxcConsulta="checked";    
    }
    if($cxc[1]=="2"){
      $cxcCrear="checked";  
    }
    if($cxc[2]=="3"){
      $cxcModificar="checked";
    }
    if($cxc[3]=="4"){
      $cxcEliminar="checked";  
    }
  }

#### CHECKED DE CUENTAS POR PAGAR ##########################################################
  if($cxp!=""){
    if($cxp[0]=="1"){
      $cxpConsulta="checked";    
    }
    if($cxp[1]=="2"){
      $cxpCrear="checked";  
    }
    if($cxp[2]=="3"){
      $cxpModificar="checked";
    }
    if($cxp[3]=="4"){
      $cxpEliminar="checked";  
    }
  }
  


###### NOMBRE DE BOTON EN CASO DE QUE LO ANTERIOR SE CUMPLA ##########################
} ## LLAVE DE IF DE RECEPCION ########################################################


###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################



?>

<!-- SCRIPTS NECESIARIOS PARA ENVIO DE INFO-->
<script type="text/javascript">
  $(document).ready(function(){

    /*VARIABLES DE URL PARA ENVIO DE INFO */
    if ($("#accionBoton").val() == 'Guardar'){
     var urlCont = "../../../controllers/administracion/usuarios/nuevosPermisos.php";
   } /* LLAVE DE IF */
   else if($("#accionBoton").val() == 'Actualizar'){
     var urlCont = "../../../controllers/administracion/usuarios/actualizarPermisos.php";
   } /* LLAVE DE ELSE */



   /* AJAX PARA ENVIO DE INFORMACION DE ACUERDO A LA RUTA*/
   $("#guardarPermisos").submit(function(e){

     /*CONDICIONES PARA VALORES DE CHECKBOX PROVEEDORES*/
     if($("#provConsulta").is(":checked")){
      var provConsulta = 1;
    }
    else{
      var provConsulta = 0;
    }

    if($("#provCrear").is(":checked")){
      var provCrear = 2;
    }
    else{
      var provCrear = 0;
    }

    if($("#provModificar").is(":checked")){
      var provModificar = 3;
    }
    else{
      var provModificar = 0;
    }

    if($("#provEliminar").is(":checked")){
      var provEliminar = 4;
    }
    else{
      var provEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX ACREEDORES*/
    if($("#acreConsulta").is(":checked")){
      var acreConsulta = 1;
    }
    else{
      var acreConsulta = 0;
    }

    if($("#acreCrear").is(":checked")){
      var acreCrear = 2;
    }
    else{
      var acreCrear = 0;
    }

    if($("#acreModificar").is(":checked")){
      var acreModificar = 3;
    }
    else{
      var acreModificar = 0;
    }

    if($("#acreEliminar").is(":checked")){
      var acreEliminar = 4;
    }
    else{
      var acreEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX TRANSPORTISTA*/
    if($("#transConsulta").is(":checked")){
      var transConsulta = 1;
    }
    else{
      var transConsulta = 0;
    }

    if($("#transCrear").is(":checked")){
      var transCrear = 2;
    }
    else{
      var transCrear = 0;
    }

    if($("#transModificar").is(":checked")){
      var transModificar = 3;
    }
    else{
      var transModificar = 0;
    }

    if($("#transEliminar").is(":checked")){
      var transEliminar = 4;
    }
    else{
      var transEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX CLIENTES*/
    if($("#clientConsulta").is(":checked")){
      var clientConsulta = 1;
    }
    else{
      var clientConsulta = 0;
    }

    if($("#clientCrear").is(":checked")){
      var clientCrear = 2;
    }
    else{
      var clientCrear = 0;
    }

    if($("#clientModificar").is(":checked")){
      var clientModificar = 3;
    }
    else{
      var clientModificar = 0;
    }

    if($("#clientEliminar").is(":checked")){
      var clientEliminar = 4;
    }
    else{
      var clientEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX PRODUCTOS*/
    if($("#productConsulta").is(":checked")){
      var productConsulta = 1;
    }
    else{
      var productConsulta = 0;
    }

    if($("#productCrear").is(":checked")){
      var productCrear = 2;
    }
    else{
      var productCrear = 0;
    }

    if($("#productModificar").is(":checked")){
      var productModificar = 3;
    }
    else{
      var productModificar = 0;
    }

    if($("#productEliminar").is(":checked")){
      var productEliminar = 4;
    }
    else{
      var productEliminar = 0;
    }


    /*CONDICIONES PARA VALORES DE CHECKBOX AGENTE ADUANAL*/
    if($("#aduanalConsulta").is(":checked")){
      var aduanalConsulta = 1;
    }
    else{
      var aduanalConsulta = 0;
    }

    if($("#aduanalCrear").is(":checked")){
      var aduanalCrear = 2;
    }
    else{
      var aduanalCrear = 0;
    }

    if($("#aduanalModificar").is(":checked")){
      var aduanalModificar = 3;
    }
    else{
      var aduanalModificar = 0;
    }

    if($("#aduanalEliminar").is(":checked")){
      var aduanalEliminar = 4;
    }
    else{
      var aduanalEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX USUARIOS*/
    if($("#userConsulta").is(":checked")){
      var userConsulta = 1;
    }
    else{
      var userConsulta = 0;
    }

    if($("#userCrear").is(":checked")){
      var userCrear = 2;
    }
    else{
      var userCrear = 0;
    }

    if($("#userModificar").is(":checked")){
      var userModificar = 3;
    }
    else{
      var userModificar = 0;
    }

    if($("#userEliminar").is(":checked")){
      var userEliminar = 4;
    }
    else{
      var userEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX PEDIDOS*/
    if($("#pedidoConsulta").is(":checked")){
      var pedidoConsulta = 1;
    }
    else{
      var pedidoConsulta = 0;
    }

    if($("#pedidoCrear").is(":checked")){
      var pedidoCrear = 2;
    }
    else{
      var pedidoCrear = 0;
    }

    if($("#pedidoModificar").is(":checked")){
      var pedidoModificar = 3;
    }
    else{
      var pedidoModificar = 0;
    }

    if($("#pedidoEliminar").is(":checked")){
      var pedidoEliminar = 4;
    }
    else{
      var pedidoEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX COTIZACIONES*/
    if($("#cotizacionConsulta").is(":checked")){
      var cotizacionConsulta = 1;
    }
    else{
      var cotizacionConsulta = 0;
    }

    if($("#cotizacionCrear").is(":checked")){
      var cotizacionCrear = 2;
    }
    else{
      var cotizacionCrear = 0;
    }

    if($("#cotizacionModificar").is(":checked")){
      var cotizacionModificar = 3;
    }
    else{
      var cotizacionModificar = 0;
    }

    if($("#cotizacionEliminar").is(":checked")){
      var cotizacionEliminar = 4;
    }
    else{
      var cotizacionEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX IMPORTACIONES*/
    if($("#importacionConsulta").is(":checked")){
      var importacionConsulta = 1;
    }
    else{
      var importacionConsulta = 0;
    }

    if($("#importacionCrear").is(":checked")){
      var importacionCrear = 2;
    }
    else{
      var importacionCrear = 0;
    }

    if($("#importacionModificar").is(":checked")){
      var importacionModificar = 3;
    }
    else{
      var importacionModificar = 0;
    }

    if($("#importacionEliminar").is(":checked")){
      var importacionEliminar = 4;
    }
    else{
      var importacionEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX DECLARACIONES DE ADUANAS*/
    if($("#declaracionConsulta").is(":checked")){
      var declaracionConsulta = 1;
    }
    else{
      var declaracionConsulta = 0;
    }

    if($("#declaracionCrear").is(":checked")){
      var declaracionCrear = 2;
    }
    else{
      var declaracionCrear = 0;
    }

    if($("#declaracionModificar").is(":checked")){
      var declaracionModificar = 3;
    }
    else{
      var declaracionModificar = 0;
    }

    if($("#declaracionEliminar").is(":checked")){
      var declaracionEliminar = 4;
    }
    else{
      var declaracionEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX INVENTARIO*/
    if($("#inventarioConsulta").is(":checked")){
      var inventarioConsulta = 1;
    }
    else{
      var inventarioConsulta = 0;
    }

    if($("#inventarioCrear").is(":checked")){
      var inventarioCrear = 2;
    }
    else{
      var inventarioCrear = 0;
    }

    if($("#inventarioModificar").is(":checked")){
      var inventarioModificar = 3;
    }
    else{
      var inventarioModificar = 0;
    }

    if($("#inventarioEliminar").is(":checked")){
      var inventarioEliminar = 4;
    }
    else{
      var inventarioEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX ORDENES DE CARGA*/
    if($("#cargaConsulta").is(":checked")){
      var cargaConsulta = 1;
    }
    else{
      var cargaConsulta = 0;
    }

    if($("#cargaCrear").is(":checked")){
      var cargaCrear = 2;
    }
    else{
      var cargaCrear = 0;
    }

    if($("#cargaModificar").is(":checked")){
      var cargaModificar = 3;
    }
    else{
      var cargaModificar = 0;
    }

    if($("#cargaEliminar").is(":checked")){
      var cargaEliminar = 4;
    }
    else{
      var cargaEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX ORDENES DE COMPRA*/
    if($("#compraConsulta").is(":checked")){
      var compraConsulta = 1;
    }
    else{
      var compraConsulta = 0;
    }

    if($("#compraCrear").is(":checked")){
      var compraCrear = 2;
    }
    else{
      var compraCrear = 0;
    }

    if($("#compraModificar").is(":checked")){
      var compraModificar = 3;
    }
    else{
      var compraModificar = 0;
    }

    if($("#compraEliminar").is(":checked")){
      var compraEliminar = 4;
    }
    else{
      var compraEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX REMISIONES*/
    if($("#remisionConsulta").is(":checked")){
      var remisionConsulta = 1;
    }
    else{
      var remisionConsulta = 0;
    }

    if($("#remisionCrear").is(":checked")){
      var remisionCrear = 2;
    }
    else{
      var remisionCrear = 0;
    }

    if($("#remisionModificar").is(":checked")){
      var remisionModificar = 3;
    }
    else{
      var remisionModificar = 0;
    }

    if($("#remisionEliminar").is(":checked")){
      var remisionEliminar = 4;
    }
    else{
      var remisionEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX BANCOS*/
    if($("#bancosConsulta").is(":checked")){
      var bancosConsulta = 1;
    }
    else{
      var bancosConsulta = 0;
    }

    if($("#bancosCrear").is(":checked")){
      var bancosCrear = 2;
    }
    else{
      var bancosCrear = 0;
    }

    if($("#bancosModificar").is(":checked")){
      var bancosModificar = 3;
    }
    else{
      var bancosModificar = 0;
    }

    if($("#bancosEliminar").is(":checked")){
      var bancosEliminar = 4;
    }
    else{
      var bancosEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX CUENTAS POR COBRAR*/
    if($("#cxcConsulta").is(":checked")){
      var cxcConsulta = 1;
    }
    else{
      var cxcConsulta = 0;
    }

    if($("#cxcCrear").is(":checked")){
      var cxcCrear = 2;
    }
    else{
      var cxcCrear = 0;
    }

    if($("#cxcModificar").is(":checked")){
      var cxcModificar = 3;
    }
    else{
      var cxcModificar = 0;
    }

    if($("#cxcEliminar").is(":checked")){
      var cxcEliminar = 4;
    }
    else{
      var cxcEliminar = 0;
    }

    /*CONDICIONES PARA VALORES DE CHECKBOX CUENTAS POR PAGAR*/
    if($("#cxpConsulta").is(":checked")){
      var cxpConsulta = 1;
    }
    else{
      var cxpConsulta = 0;
    }

    if($("#cxpCrear").is(":checked")){
      var cxpCrear = 2;
    }
    else{
      var cxpCrear = 0;
    }

    if($("#cxpModificar").is(":checked")){
      var cxpModificar = 3;
    }
    else{
      var cxpModificar = 0;
    }

    if($("#cxpEliminar").is(":checked")){
      var cxpEliminar = 4;
    }
    else{
      var cxpEliminar = 0;
    }




    $.ajax({
      type: "POST",
      url: urlCont,
      data: "provConsulta="+ provConsulta+
      "&provCrear="+ provCrear+
      "&provModificar="+ provModificar+
      "&provEliminar="+ provEliminar+
      "&acreConsulta="+ acreConsulta+
      "&acreCrear="+ acreCrear+
      "&acreModificar="+ acreModificar+
      "&acreEliminar="+ acreEliminar+
      "&transConsulta="+ transConsulta+
      "&transCrear="+ transCrear+
      "&transModificar="+ transModificar+
      "&transEliminar="+ transEliminar+
      "&clientConsulta="+ clientConsulta+
      "&clientCrear="+ clientCrear+
      "&clientModificar="+ clientModificar+
      "&clientEliminar="+ clientEliminar+
      "&productConsulta="+ productConsulta+
      "&productCrear="+ productCrear+
      "&productModificar="+ productModificar+
      "&productEliminar="+ productEliminar+
      "&aduanalConsulta="+ aduanalConsulta+
      "&aduanalCrear="+ aduanalCrear+
      "&aduanalModificar="+ aduanalModificar+
      "&aduanalEliminar="+ aduanalEliminar+
      "&personaConsulta="+ userConsulta+
      "&personaCrear="+ userCrear+
      "&personaModificar="+ userModificar+
      "&personaEliminar="+ userEliminar+
      "&pedidoConsulta="+ pedidoConsulta+
      "&pedidoCrear="+ pedidoCrear+
      "&pedidoModificar="+ pedidoModificar+
      "&pedidoEliminar="+ pedidoEliminar+
      "&cotizacionConsulta="+ cotizacionConsulta+
      "&cotizacionCrear="+ cotizacionCrear+
      "&cotizacionModificar="+ cotizacionModificar+
      "&cotizacionEliminar="+ cotizacionEliminar+
      "&importacionConsulta="+ importacionConsulta+
      "&importacionCrear="+ importacionCrear+
      "&importacionModificar="+ importacionModificar+
      "&importacionEliminar="+ importacionEliminar+
      "&declaracionConsulta="+ declaracionConsulta+
      "&declaracionCrear="+ declaracionCrear+
      "&declaracionModificar="+ declaracionModificar+
      "&declaracionEliminar="+ declaracionEliminar+
      "&inventarioConsulta="+ inventarioConsulta+
      "&inventarioCrear="+ inventarioCrear+
      "&inventarioModificar="+ inventarioModificar+
      "&inventarioEliminar="+ inventarioEliminar+
      "&cargaConsulta="+ cargaConsulta+
      "&cargaCrear="+ cargaCrear+
      "&cargaModificar="+ cargaModificar+
      "&cargaEliminar="+ cargaEliminar+
      "&compraConsulta="+ compraConsulta+
      "&compraCrear="+ compraCrear+
      "&compraModificar="+ compraModificar+
      "&compraEliminar="+ compraEliminar+
      "&remisionConsulta="+ remisionConsulta+
      "&remisionCrear="+ remisionCrear+
      "&remisionModificar="+ remisionModificar+
      "&remisionEliminar="+ remisionEliminar+
      "&bancosConsulta="+ bancosConsulta+
      "&bancosCrear="+ bancosCrear+
      "&bancosModificar="+ bancosModificar+
      "&bancosEliminar="+ bancosEliminar+
      "&cxcConsulta="+ cxcConsulta+
      "&cxcCrear="+ cxcCrear+
      "&cxcModificar="+ cxcModificar+
      "&cxcEliminar="+ cxcEliminar+
      "&cxpConsulta="+ cxpConsulta+
      "&cxpCrear="+ cxpCrear+
      "&cxpModificar="+ cxpModificar+
      "&cxpEliminar="+ cxpEliminar+
      "&idPermiso=" + $("#idPermiso").val()
    }).done(function(result){
      if(result=="Nickname no corresponde"||result=="Usuario existente"){
        swal({
          title: result,
          type: "warning",
          showCloseButton: true,
          confirmButtonText:'Cerrar'
        });
      }else{
       swal({
        title: result,
        type: "success",
        showCloseButton: true,
        confirmButtonText:'Cerrar'
      });
     }
     $("#mainContent").load( "catAD_usuarios.php" );
   });
    return false;
  });

$("#back_pusers").click(function(){
  window.location = ""
});
});
</script>




<!-- COLUMNA DE 8 -->
<div class="col-md-12">

	<!-- INICIA PORTLET -->
	<div class="portlet box grey-steel">

		<!-- INICIA TITULO DE PORTLET-->
		<div class="portlet-title">
			<div class="caption"><div class="font-grey-mint"> <b>Permisos</b> </div> </div>

      <div class="actions btn-set">
        <button type="button" name="back" id="back_pusers" class="btn default green-seagreen">
          <i class="fa fa-arrow-left"></i>&nbsp;Regresar
        </button>
      </div>
    </div>
    <!-- TERMINA TITULO DE PORTLET-->




    <!-- INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


     <!-- INICIO DE  FORM-->
     <form class="form-horizontal save-user" id="guardarPermisos" >
       <div class="col-md-1"></div>
       <div class="col-md-10">
         <div class="table-scrollable table-scrollable-borderless">
           <table class="table table-hover table-light">

             <!-- INICIA TITULO SECCION CATALOGOS-->
             <tr>
               <td width="28%">
                 <div class="text-left font-grey-mint"> 
                   <h4>
                     <b>Catálogos</b>
                   </h4> 
                 </div>
               </td>
               
             </tr>
             <!-- TERMINA TITULO SECCION CATALOGOS-->

             <!-- INICIA TITULO CHECKBOXES -->
             <tr>
               <th>&nbsp;</th>
               <th class="text-center" width="100px">Consulta</th>
               <th class="text-center" width="100px">Registro</th>
               <th class="text-center" width="100px">Modificación</th>
               <th class="text-center" width="100px">Eliminación</th>
             </tr>
             <!-- TERMINA TITULO CHECKBOXES -->

             <tbody>
               <!-- INICIO PROVEEDORES-->
               <tr>
                 <td class="text-left">
                   <div class="col-md-12 font-grey-mint"><h5>Proveedores</h5></div>
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="provConsulta" <?echo $provConsulta;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="provCrear" <?echo $provCrear;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="provModificar" class="md-check" <?echo $provModificar;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="provEliminar" <?echo $provEliminar;?> />
                 </td>
               </tr>
               <!--TERMINA PROVEEDORES-->

               <!-- INICIA ACREEDORES -->
               <tr>
                 <td class="text-left">
                   <div class="col-md-12 font-grey-mint"><h5>Acreedores</h5></div>
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="acreConsulta" <?echo $acreConsulta;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="acreCrear" <?echo $acreCrear;?> /> 
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="acreModificar" class="md-check" <?echo $acreModificar;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="acreEliminar" <?echo $acreEliminar;?> />
                 </td>
               </tr>
               <!-- TERMINA ACREEDORES -->

               <!-- INICIA TRANSPORTISTAS -->
               <tr>
                 <td class="text-left">
                   <div class="col-md-12 font-grey-mint"><h5>Transportistas</h5></div>
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="transConsulta" <?echo $transConsulta;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="transCrear" <?echo $transCrear;?> />  
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="transModificar" class="md-check" <?echo $transModificar;?> /> 
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="transEliminar" <?echo $transEliminar;?> />
                 </td>
               </tr>
               <!-- TERMINA TRANSPORTISTAS -->

               <!-- INICIA PRODUCTOS -->
               <tr>
                 <td class="text-left">
                   <div class="col-md-12 font-grey-mint"><h5>Productos</h5></div>
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="productConsulta" <?echo $productConsulta;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="productCrear" <?echo $productCrear;?> /> 
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="productModificar" class="md-check" <?echo $productModificar;?> /> 
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="productEliminar" <?echo $productEliminar;?> />
                 </td>
               </tr>
               <!-- TERMINA PRODUCTOS -->

               <!-- INICIA CLIENTES -->
               <tr>
                 <td class="text-left">
                   <div class="col-md-12 font-grey-mint"><h5>Clientes</h5></div>
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="clientConsulta" <?echo $clientConsulta;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="clientCrear" <?echo $clientCrear;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="clientModificar" class="md-check" <?echo $clientModificar;?> />
                 </td>
                 <td class="text-center">
                   <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="clientEliminar" <?echo $clientEliminar;?> />
                 </td>
               </tr>
               <!-- TERMINA CLIENTES -->

               <!-- INICIA AGENCIA ADUANAL -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Agencia aduanal</h5></div>
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="aduanalConsulta" <?echo $aduanalConsulta;?> />
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="aduanalCrear" <?echo $aduanalCrear;?> />
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="aduanalModificar" class="md-check" <?echo $aduanalModificar;?> /> 
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="aduanalEliminar" <?echo $aduanalEliminar;?> />
                </td>
              </tr>
              <!-- TERMINA AGENCIA ADUANAL -->

              <!-- INICIA TITULO SECCION ATENCION AL CLIENTE -->

              <tr>
               <td>
                 <div class="text-left font-grey-mint"> 
                   <h4>
                     <b>Atención al cliente</b>
                   </h4> 
                 </div>
               </td>
             </tr>
             <!-- TERMINA TITULO SECCION ATENCION AL CLIENTE -->

             <!-- INICIA TITULO CHECKBOXES -->
             <tr>
               <th>&nbsp;</th>
               <th class="text-center">Consulta</th>
               <th class="text-center">Registro</th>
               <th class="text-center">Modificación</th>
               <th class="text-center">Eliminación</th>
             </tr>
             <!-- TERMINA TITULO CHECKBOXES -->

             <!-- INICIA COTIZACIONES-->
             <tr>
               <td class="text-left">
                 <div class="col-md-12 font-grey-mint"><h5>Cotizaciones</h5></div>
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cotizacionConsulta" <?echo $cotizacionConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cotizacionCrear" <?echo $cotizacionCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cotizacionModificar" class="md-check" <?echo $cotizacionModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cotizacionEliminar" <?echo $cotizacionEliminar;?> /></td>
               </tr>
               <!-- TERMINA COTIZACIONES -->

               <!-- INICIA PEDIDOS -->
               <tr>
                <td class="text-left">
                 <div class="col-md-12 font-grey-mint"><h5>Pedidos</h5></div>
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="pedidoConsulta" <?echo $pedidoConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="pedidoCrear" <?echo $pedidoCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="pedidoModificar" class="md-check" <?echo $pedidoModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="pedidoEliminar" <?echo $pedidoEliminar;?> /></td>
               </tr>
               <!-- TERMINA PEDIDOS -->

               <!-- INICIA TITULO SECCION ADUANAS -->

               <tr>
                 <td>
                   <div class="text-left font-grey-mint"> 
                     <h4>
                       <b>Aduanas</b>
                     </h4> 
                   </div>
                 </td>
               </tr>
               <!-- TERMINA TITULO SECCION ADUANAS -->

               <!-- INICIA TITULO CHECKBOXES -->
               <tr>
                 <th>&nbsp;</th>
                 <th class="text-center">Consulta</th>
                 <th class="text-center">Registro</th>
                 <th class="text-center">Modificación</th>
                 <th class="text-center">Eliminación</th>
               </tr>
               <!-- TERMINA TITULO CHECKBOXES -->

               <!-- INICIA IMPORTACIONES -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Importaciones</h5></div>
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="importacionConsulta" <?echo $importacionConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="importacionCrear" <?echo $importacionCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="importacionModificar" class="md-check" <?echo $importacionModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="importacionEliminar" <?echo $importacionEliminar;?> /></td>
               </tr>
               <!-- TERMINA IMPORTACIONES -->

               <!-- INICIA DECLARACIONES DE ADUANAS -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Declaración de aduanas</h5></div>
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="declaracionConsulta" <?echo $declaracionConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="declaracionCrear" <?echo $declaracionCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="declaracionModificar" class="md-check" <?echo $declaracionModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="declaracionEliminar" <?echo $declaracionEliminar;?> /> </td>
               </tr>
               <!-- TERMINA DECLARACIONES DE ADUANAS -->

               <!-- INICIA TITULO SECCION ALMACEN -->

               <tr>
                 <td>
                   <div class="text-left font-grey-mint"> 
                     <h4>
                       <b>Almacén</b>
                     </h4> 
                   </div>
                 </td>
               </tr>
               <!-- TERMINA TITULO SECCION ALMACEN -->

               <!-- INICIA TITULO CHECKBOXES -->
               <tr>
                 <th>&nbsp;</th>
                 <th class="text-center">Consulta</th>
                 <th class="text-center">Registro</th>
                 <th class="text-center">Modificación</th>
                 <th class="text-center">Eliminación</th>
               </tr>
               <!-- TERMINA TITULO CHECKBOXES -->

               <!-- INICIA ORDENES DE COMPRA -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Órdenes de compra</h5></div>
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="compraConsulta" <?echo $compraConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="compraCrear" <?echo $compraCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="compraModificar" class="md-check" <?echo $compraModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="compraEliminar" <?echo $compraEliminar;?> /></td>
               </tr>
               <!-- TERMINA ORDENES DE COMPRA -->

               <!-- INICIA INVENTARIO -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Inventario</h5></div>
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="inventarioConsulta" <?echo $inventarioConsulta;?> />
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="inventarioCrear" <?echo $inventarioCrear;?> />
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="inventarioModificar" class="md-check" <?echo $inventarioModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="inventarioEliminar" <?echo $inventarioEliminar;?> /></td>
               </tr>
               <!-- TERMINA INVENTARIO -->

               <!-- INICIA ORDENES DE CARGA -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Órdenes de carga</h5></div>
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cargaConsulta" <?echo $cargaConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cargaCrear" <?echo $cargaCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cargaModificar" class="md-check" <?echo $cargaModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cargaEliminar" <?echo $cargaEliminar;?> /></td>
               </tr>
               <!-- TERMINA ORDENES DE CARGA -->

               <!-- INICIA REMISIONES -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Remisiones</h5></div>
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="remisionConsulta" <?echo $remisionConsulta;?> />
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="remisionCrear" <?echo $remisionCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="remisionModificar" class="md-check" <?echo $remisionModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="remisionEliminar" <?echo $remisionEliminar;?> /></td>
               </tr>
               <!-- TERMINA REMISIONES -->

               <!-- INICIA TITULO SECCION CONTABILIDAD -->

               <tr>
                 <td>
                   <div class="text-left font-grey-mint"> 
                     <h4>
                       <b>Contabilidad</b>
                     </h4> 
                   </div>
                 </td>
               </tr>
               <!-- TERMINA TITULO SECCION CONTABILIDAD -->

               <!-- INICIA TITULO CHECKBOXES -->
               <tr>
                 <th>&nbsp;</th>
                 <th class="text-center">Consulta</th>
                 <th class="text-center">Registro</th>
                 <th class="text-center">Modificación</th>
                 <th class="text-center">Eliminación</th>
               </tr>
               <!-- TERMINA TITULO CHECKBOXES -->

               <!-- INICIA BANCOS -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Bancos</h5></div>
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="bancosConsulta" <?echo $bancosConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="bancosCrear" <?echo $bancosCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="bancosModificar" class="md-check" <?echo $bancosModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="bancosEliminar" <?echo $bancosEliminar;?> /></td>
               </tr>
               <!-- TERMINA BANCOS -->

               <!-- INICIA CUENTAS POR COBRAR -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Cuentas por cobrar</h5></div>
                </td>
                <td class="text-center">
                  <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxcConsulta" <?echo $cxcConsulta;?> />
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxcCrear" <?echo $cxcCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxcModificar" class="md-check" <?echo $cxcModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxcEliminar" <?echo $cxcEliminar;?> /></td>
               </tr>
               <!-- TERMINA CUENTAS POR COBRAR -->

               <!-- INICIA CUENTAS POR PAGAR -->
               <tr>
                <td class="text-left">
                  <div class="col-md-12 font-grey-mint"><h5>Cuentas por pagar</h5></div>
                </td>
                <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxpConsulta" <?echo $cxpConsulta;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxpCrear" <?echo $cxpCrear;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxpModificar" class="md-check" <?echo $cxpModificar;?> />
               </td>
               <td class="text-center">
                 <input type="checkbox" class="icheck" data-checkbox="icheckbox_square-grey" id="cxpEliminar" <?echo $cxpEliminar;?> /></td>
               </tr>
               <!-- TERMINA CUENTAS POR PAGAR -->

             </tbody>
           </table>

           <input type="hidden" id="idPermiso" value="<?=$idPermiso; ?>">


           <div class="text-center">
            <hr>
            <!--BOTON DE GUARDAR O ACTUALIZAR-->
            <?php
            if($idUsuario!=""){
              $nombreSubmit="Actualizar";
            }
            else{
              $nombreSubmit="Guardar";
            }
            $html_guardar='<input type="submit" id="accionBoton" class="btn green" value='.$nombreSubmit.'>';
            if($_SESSION['boton']==1){

              echo $html_guardar;
            }
            ?>
            <!--BOTON PARA REGRESAR AL INICIO-->
            <a href="../usuarios" class="btn grey-salsa btn-outline">Cancelar</a>
          </div>
          <!--TERMINA SECCION DE BOTONES-->
        </div>

      </div>
      

    </form>
    <!-- TERMINA FORM-->
  </div>
  <!--TERMINA CUERPO DE PORTLET-->

</div>
<!-- TERMINA PORTLET-->
</div>
<!--TERMINA COLUMNA DE 8-->




<script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
