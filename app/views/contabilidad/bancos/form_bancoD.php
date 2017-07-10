<link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />


<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 31 Marzo 2017 : 12:52                                                              #
#                                                                                    #
###### bancos/form_bancoD.php ########################################################
#                                                                                    #
# Archivo sin estructura de la lista de acreedores para ser recibido por             #  
# JQuery en index de "Bancos USD"                                                    #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 31-MAR-17: 12:52                                                                   #
# IJLM - Se copia FORMULARIO de acreedores                                           #
# IJLM - Se realizan los cambios pertinentes a la sección bancos USD.                #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/contabilidad/dolares/bancos.php';

###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
$codigo ="";
$ddBank =date('d');
$mmBank = date('m');
$yyyyBank=date('Y');
$referencia ="";
$tipo ="";
$monto ="";
$detalle ="";
$comentario ="";
$status ="";
$ingreso="";
$egreso="";

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
if (isset($_REQUEST['codigo'])){

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
	$usdBancos = new usdBancos($datosConexionBD);
	$usdBancos->folio = $_REQUEST['codigo'];
	$result = $usdBancos->consultarRegistrosBancoUSDxID();


###### FOREACH PARA CONSULTA DE ACREEDORES EN CASO DE MODIFICAR ######################
	foreach($result as $row){
		$codigo =$row['folioUSDBanco'];
		$ddBank =$row['ddUSDBanco'];
		$mmBank =$row['mmUSDBanco'];
		$yyyyBank =$row['yyyyUSDBanco'];
		$referencia =$row['referenciaUSDBanco'];
		$tipo =$row['tipoUSDBanco'];
		$monto =$row['montoUSDBanco'];
		$detalle =$row['detalleUSDBanco'];
		$comentario =$row['comentarioUSDBanco'];
		$status =$row['statusUSDBanco'];


  } ## LLAVE DE FOREACH RESULT #######################################################

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';

  if($tipo==1){
  	$ingreso="checked";
  }
  else{
  	if($tipo == 2){
  		$egreso = "checked";
  	}
  }
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
	$(document).ready(function(){

		$(".readonly").keydown(function(e){
			e.preventDefault();
		});

		/* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
		if ($("#accionBoton").val() == 'Guardar'){
			var urlCont = "../../../controllers/contabilidad/usd/bancos/guardarRegistro.php";
		} /* LLAVE DE IF */


		else if($("#accionBoton").val() == 'Actualizar'){
			var urlCont = "../../../controllers/contabilidad/usd/bancos/modificarRegistro.php";
		} /* LLAVE DE ELSE */


		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
		$("#guardarBankD").submit(function(e){

			/* CONDICIONES PARA EL TIPO DE PRODUCTO*/
			if($("#ingreso").is(':checked')){
				var tipo = "1";
			}
			else{
				if($("#egreso").is(':checked')){
					var tipo = "2";
				}
			} 

			$.ajax({
				type: "POST",
				url: urlCont,
				data: "folio="+$("#folio").val()+
				"&viejo="+$("#viejo").val()+
				"&fechaR="+$("#fechaR").val()+
				'&referencia='+$("#referencia").val()+
				'&tipo='+tipo+
				'&monto='+$("#monto").val()+
				'&detalle='+$("#detalle").val()+
				'&comentario='+$("#comentario").val()+
				'&pass='+$("#pass").val()
			}).done(function(result){
				if(result=="Registro exitoso"||result=="Modificación Exitosa"){
					swal (result, "", "success");
				}else{
					swal (result, "", "warning");
				}
				$("#mainContent").load( "cat_bancoD.php" );
			});
			return false;
		});
	});
</script>
<style>
	input[type=number]::-webkit-outer-spin-button,
	input[type=number]::-webkit-inner-spin-button,
	input[type=date]::-webkit-outer-spin-button,
	input[type=date]::-webkit-inner-spin-button{
		-webkit-appearance: none;
		margin: 0;
	}
	input[type=number] {
		-moz-appearance:textfield;
	}
</style>

<!--COLUMNA DE 2 UTILIZADA PARA CENTRAR FORMULARIO-->
<div class="col-md-2"></div>
<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-8">

	<!--INICIA PORTLET-->
	<div class="portlet box blue-hoki">

		<!--INICIA TITULO DE PORTLET-->
		<div class="portlet-title">

			<!--INICIAN ESTILOS DE TITULO DE PORTLET-->
			<div class="caption">
				<!-- ICONO Y TEXTO DE TITULO-->
				<i class="fa fa-save"></i> Registro en Banco 
			</div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

		</div>
		<!-- TERMINA TITULO DE PORTLET -->

		<!--INICIA CUERPO DE PORTLET-->
		<div class="portlet-body form">


			<!--INICIA FORM-->
			<form class="form-horizontal save-user" id="guardarBankD" >

				<!--INICIAN ESTILOS DE FORM-->
				<div class="form-body">

					<!-- INICIA INPUT FOLIO-->
					
					<input type="hidden" id="viejo" name="viejo" value="<?=$codigo;?>">

					<!-- TERMINA INPUT FOLIO-->

					<!-- INICIA INPUT FECHA-->
					<div class="form-group">
						<label class="control-label col-md-3">Fecha</label>
						<div class="col-md-7">
							<div class="input-group  date date-picker" data-date="<?=$ddBank."/".$mmBank."/".$yyyyBank;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
								<input type="text" class="form-control readonly"  id="fechaR" required value="<?=$ddBank."/".$mmBank."/".$yyyyBank;?>">
								<span class="input-group-btn">
									<button class="btn default" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
					<!-- TERMINA INPUT FECHA-->

					<!-- INICIA INPUT REFERENCIA-->
					<div class="form-group">
						<label class="col-md-3 control-label">Referencia</label>
						<div class="col-md-7">
							<input type="text" class="form-control input-circle" id="referencia" name="referencia" value="<?=$referencia;?>" required>
						</div>
					</div>
					<!-- TERMINA INPUT REFERENCIA-->

					<!-- INICIA RADIO TIPO-->
					<div class="form-group">
						<label class="control-label col-md-3" >Tipo de registro
						</label>
						<div class="input-group">
							<div class="icheck-inline col-md-12" >
								<label>
									<input type="radio" name="tipo" id="ingreso" class="icheck" data-radio="iradio_square-grey" <?echo $ingreso;?> required> Ingreso 
								</label>
								<label>
									<input type="radio" name="tipo" id="egreso" class="icheck" data-radio="iradio_square-grey"<?echo $egreso;?>> Egreso 
								</label>
							</div>
						</div>
					</div>
					<!-- TERMINA RADIO TIPO-->

					<!-- INICIA INPUT MONTO-->
					<div class="form-group">
						<label class="col-md-3 control-label">Monto</label>
						<div class="col-md-7">
							<input type="number" step="any" min="0" class="form-control input-circle" id="monto" name="monto" value="<?=$monto;?>" required>
						</div>
					</div>
					<!-- TERMINA INPUT MONTO-->

					<!--INICIA INPUT DE DETALLE -->
					<div class="form-group">
						<label class="col-md-3 control-label">Detalle</label>
						<div class="col-md-7">
							<input type="text" class="form-control input-circle" id="detalle" name="detalle" value="<?=$detalle;?>" required> 
						</div>
					</div>
					<!-- TERMINA INPUT DE DETALLE-->

					<!-- INICIA INPUT DE COMENTARIO-->
					<div class="form-group">
						<label class="col-md-3 control-label">Comentario</label>
						<div class="col-md-7">
							<input type="text" class="form-control input-circle" id="comentario" name="comentario" value="<?=$comentario;?>" required>
						</div>
					</div>
					<!-- TERMINA INPUT DE COMENTARIO-->

					<!-- INICIA INPUT PARA PAIS-->
					<div class="form-group">
						<label class="col-md-3 control-label">Password</label>
						<div class="col-md-7">
							<input type="password" class="form-control input-circle" id="pass" name="pass" required>
						</div>
					</div>
					<!-- TERMINA INPUT PARA PAIS-->

					<!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-4 col-md-12">

								<!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
								<input type="submit" id="accionBoton" class="btn btn-circle green" value="<?=$nombreSubmit;?>"> 

								<!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
								<a href="../bancos" class="btn btn-circle grey-salsa btn-outline">Cancelar</a>
							</div>
						</div>
					</div>
					<!--TERMINA GRUPO DE BOTONES DE FORMULARIO-->
				</form>
				<!-- TERMINA FORM-->
			</div>
		</div>
		<!-- TERMINA CUERPO DE PORTLET-->
	</div>
	<!-- TERMINA PORTLET-->

	<!-- COLUMNA DE 2 PARA CENTRAR FORMULARIO-->
	<div class="col-md-2"></div>





	<!-- END CORE PLUGINS -->
	<!-- BEGIN PAGE LEVEL PLUGINS -->
	<script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN THEME GLOBAL SCRIPTS -->
	<script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
	<!-- END THEME GLOBAL SCRIPTS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>

	<script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
	<script src="../../../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
	<script src="../../../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
	<script src="../../../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
	<script src="../../../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
	<script src="../../../../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript">