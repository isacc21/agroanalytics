<link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Abril 2017 : 16:55                                                              #
#                                                                                    #
###### cuentasCobrar/form_cxcD.php ###################################################
#                                                                                    #
# Archivo sin estructura de la lista de acreedores para ser recibido por             #  
# JQuery en index de "Cuentas por Cobrar USD"                                        #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 02-ABR-17: 16:56                                                                   #
# IJLM - Se copia FORMULARIO de Bancos USD                                           #
# IJLM - Se realizan los cambios pertinentes a la sección Cuentas por cobrar USD.    #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/contabilidad/dolares/cuentasPagar.php';
$usdCuentasP = new usdCuentasP($datosConexionBD);

###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
$codigo ="";
$ddCXP =date('d');
$mmCXP = date('m');
$yyyyCXP=date('Y');
$factura ="";
$monto ="";
$detalle ="";
$comentario ="";
$status ="";
$ingreso="";
$egreso="";
$sel_prov="selected";
$v_prov = "none";
$sel_acre="selected";
$v_acre = "none";
$pk_acreedor ="";
$pk_proveedor = "";
$acre_r="";
$prov_r="";

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
if (isset($_REQUEST['codigo'])){


###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
	$usdCuentasP = new usdCuentasP($datosConexionBD);
	$usdCuentasP->folio = $codigo;

	$result = $usdCuentasP->consultarCuentasPxID();

###### FOREACH PARA CONSULTA DE ACREEDORES EN CASO DE MODIFICAR ######################
	foreach($result as $row){
		$codigo =$row['folioCuentaP'];
		$ddCXP =$row['ddCuentaP'];
		$mmCXP =$row['mmCuentaP'];
		$yyyyCXP =$row['yyyyCuentaP'];
		$pk_proveedor =$row['rfcProveedor'];
		$pk_acreedor =$row['rfcAcreedor'];
		$factura =$row['folioFactura'];
		$monto =$row['importeCuentaP'];
		$comentario =$row['comentarioCuentaP'];
		$status =$row['statusCuentaP'];


  } ## LLAVE DE FOREACH RESULT #######################################################

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
  if($pk_proveedor==""){
  	$sel_prov = "selected";
  	$v_prov = "none";
  }
  else{
  	$sel_prov = "";
  	$v_prov = "block";
  }

  if($pk_acreedor==""){
  	$sel_acre = "selected";
  	$v_acre = "none";
  }
  else{
  	$sel_acre = "";
  	$v_acre = "block";
  }

} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
	$(document).ready(function(){

		$(".readonly").keydown(function(e){
			e.preventDefault();
		});
		

		$('#prov_r').click(function () {
			$("#prov_select").show();
			$("#acre_select").hide();
			$("#acreedor").val("");
		});

		$('#acre_r').click(function () {
			$("#prov_select").hide();
			$("#acre_select").show();
			$("#proveedor").val("");
		});

		/* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
		if ($("#accionBoton").val() == 'Guardar'){
			var urlCont = "../../../controllers/contabilidad/usd/cuentasPagar/guardarCXP.php";
		} /* LLAVE DE IF */


		else if($("#accionBoton").val() == 'Actualizar'){
			var urlCont = "../../../controllers/contabilidad/usd/cuentasPagar/modificarCXP.php";
		} /* LLAVE DE ELSE */



		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
		$("#guardarCXP").submit(function(e){

			$.ajax({
				type: "POST",
				url: urlCont,
				data: "folio="+$("#folio").val()+
				"&viejo="+$("#viejo").val()+
				"&fechaCXP="+$("#fechaCXP").val()+
				'&proveedor='+$("#proveedor").val()+
				'&acreedor='+$("#acreedor").val()+
				'&factura='+$("#factura").val()+
				'&monto='+$("#monto").val()+
				'&comentario='+$("#comentario").val()+
				'&pass='+$("#pass").val()
			}).done(function(result){
				if(result=="Registro Exitoso"||result=="Modificación Exitosa"){
					swal (result, "", "success");
				}else{
					swal (result, "", "warning");
				}
				$("#mainContent").load( "cat_cxpD.php" );
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
				<i class="fa fa-save"></i> Nueva cuenta por pagar 
			</div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

		</div>
		<!-- TERMINA TITULO DE PORTLET -->

		<!--INICIA CUERPO DE PORTLET-->
		<div class="portlet-body form">


			<!--INICIA FORM-->
			<form class="form-horizontal save-user" id="guardarCXP" >

				<!--INICIAN ESTILOS DE FORM-->
				<div class="form-body">

					<!-- INICIA INPUT FOLIO-->
					
					<input type="hidden" id="viejo" name="viejo" value="<?=$codigo;?>">
					<!-- TERMINA INPUT FOLIO-->

					<!-- INICIA INPUT FECHA-->
					<div class="form-group">
						<label class="control-label col-md-3">Fecha</label>
						<div class="col-md-7">
							<div class="input-group  date date-picker" data-date="<?=$ddCXP."/".$mmCXP."/".$yyyyCXP;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
								<input type="text" class="form-control readonly"  id="fechaCXP" required value="<?=$ddCXP."/".$mmCXP."/".$yyyyCXP;?>">
								<span class="input-group-btn">
									<button class="btn default" type="button">
										<i class="fa fa-calendar"></i>
									</button>
								</span>
							</div>
						</div>
					</div>
					<!-- TERMINA INPUT FECHA-->

					<!-- INICIA RADIO TIPO-->
					<div class="form-group">
						<label class="control-label col-md-3" >Seleccione
						</label>
						<div class="input-group">
							<a id="prov_r" class="btn btn-circle grey-salsa">Proveedor</a>
							&nbsp;
							<a id="acre_r" class="btn btn-circle grey-salsa">Acreedor</a>
							
						</div>
					</div>
					<!-- TERMINA RADIO TIPO-->
					


					<!-- INICIA INPUT PARA ESTAD-->
					<div class="form-group content" id="prov_select" style="display:<?=$v_prov;?>;" >
						<label class="col-md-3 control-label">Proveedor</label>
						<div class="col-md-7">
							<select id="proveedor" class="form-control input-circle" >
								<option <? echo $sel_prov;?> disabled value="">Seleccione un proveedor</option>
								<?php 
								$sel_prov = "";
								$proveedor=$usdCuentasP->consultarProveedores();
								foreach($proveedor as $row){
									$rfc = $row['rfcProveedor'];
									$nombre = $row['razonSocProveedor'];

									if($rfc==$pk_proveedor){
										$sel_prov = "selected";
									}
									else{
										$sel_prov = "";
									}
									
									
									?>
									<option value="<?=$rfc;?>" <?php echo $sel_prov;?>><? echo $nombre;?></option>
									<?php }?>
								</select>
							</div>
						</div>
						<!-- TERMINA INPUT PARA ESTAD-->


						<!-- INICIA INPUT PARA ESTAD-->
						<div class="form-group content" id="acre_select" style="display:<?=$v_acre;?>;" >
							<label class="col-md-3 control-label">Acreedor</label>
							<div class="col-md-7">
								<select id="acreedor" class="form-control input-circle" >
									<option <? echo $sel_acre;?> disabled value="">Seleccione un acreedor</option>
									<?php 
									$sel_acre = "";
									$acreedor=$usdCuentasP->consultarAcreedores();
									foreach($acreedor as $row){
										$rfc = $row['rfcAcreedor'];
										$nombre = $row['razonSocAcreedor'];

										if($rfc==$pk_acreedor){
											$sel_acre = "selected";
										}
										else{
											$sel_acre = "";
										}

										?>
										<option value="<?=$rfc;?>" <?php echo $sel_acre;?>><? echo $nombre;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<!-- TERMINA INPUT PARA ESTAD-->

							<!--INICIA INPUT DE FOLIO -->
							<div class="form-group">
								<label class="col-md-3 control-label">Folio de factura</label>
								<div class="col-md-7">
									<input type="text" class="form-control input-circle" id="factura" name="factura" value="<?=$factura;?>" required> 
								</div>
							</div>
							<!-- TERMINA INPUT DE FOLIO-->


							<!-- INICIA INPUT MONTO-->
							<div class="form-group">
								<label class="col-md-3 control-label">Monto</label>
								<div class="col-md-7">
									<input type="number" step="any" min="0" class="form-control input-circle" id="monto" name="monto" value="<?=$monto;?>" required>
								</div>
							</div>
							<!-- TERMINA INPUT MONTO-->		

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
										<a href="../cuentasPagar" class="btn btn-circle grey-salsa btn-outline">Cancelar</a>
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