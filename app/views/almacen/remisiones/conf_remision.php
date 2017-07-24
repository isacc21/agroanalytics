 <link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

 <?php
###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
 error_reporting(E_ALL);
 Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
 date_default_timezone_set('America/Tijuana');

 $dd = date('d');
 $mm =date('m');
 $yyyy = date('Y');

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
 $codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";

###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
 if (isset($_REQUEST['codigo'])){

 	$nombreSubmit = 'Confirmar';
 }
 ?>

 <!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
 <script type="text/javascript">
 	$(document).ready(function(){



 		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
 		$("#cancelarBankD").submit(function(e){ 

 			$.ajax({
 				type: "POST",
 				url: "../../../controllers/almacen/remisiones/agregarRemision.php",
 				data: "carga="+$("#carga").val()+
 				'&fecha='+$("#fecha").val()+
 				'&adicional='+$("#adicional").val()+
 				'&pass='+$("#pass").val()
 			}).done(function(result){
 				if(result=="Remisión registrada"){
 					swal (result, "", "success");
 					$("#mainContent").load( "cat_remisiones.php" );
 				}else{
 					swal (result, "", "warning");
 				}

 			});
 			return false;
 		});
 	});
 </script>


 <div class="col-md-12">

 	<!--INICIA PORTLET-->
 	<div class="portlet box grey-mint">

 		<!--INICIA TITULO DE PORTLET-->
 		<div class="portlet-title">

 			<!--INICIAN ESTILOS DE TITULO DE PORTLET-->
 			<div class="caption">
 				<!-- ICONO Y TEXTO DE TITULO-->
 				<i class="fa fa-save"></i> Procesar órden de carga: "<?php echo $codigo;?>" 
 			</div>
 			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

 		</div>
 		<!-- TERMINA TITULO DE PORTLET -->

 		<!--INICIA CUERPO DE PORTLET-->
 		<div class="portlet-body form">


 			<!--INICIA FORM-->
 			<form class="form-horizontal save-user" id="cancelarBankD" >

 				<!--INICIAN ESTILOS DE FORM-->
 				<div class="form-body">

 					<div class="form-group">
 						<label class="control-label col-md-3">Fecha</label>
 						<div class="col-md-7">
 							<div class="input-group  date date-picker" data-date="<?=$dd."/".$mm."/".$yyyy;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
 								<input type="text" class="form-control readonly"  id="fecha" required value="<?=$dd."/".$mm."/".$yyyy;?>">
 								<span class="input-group-btn">
 									<button class="btn default" type="button">
 										<i class="fa fa-calendar"></i>
 									</button>
 								</span>
 							</div>
 						</div>
 					</div>

 					<div class="form-group">
 						<label class="col-md-3 control-label">Información adicional</label>
 						<div class="col-md-7">
 							<textarea class="form-control" rows="3" id="adicional"></textarea>
 						</div>
 					</div>

 					<!-- INICIA INPUT FOLIO-->
 					<div class="form-group">
 						<label class="col-md-3 control-label">Confirmar contraseña</label>
 						<div class="col-md-7">
 							<input type="password" class="form-control" id="pass" name="pass" required>
 							<input type="hidden" id="carga" name="carga" value="<?=$codigo;?>">
 						</div>
 					</div>
 					<!-- TERMINA INPUT FOLIO-->


 					<!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
 					<div class="form-actions">
 						<div class="row">
 							<div class="col-md-offset-4 col-md-12">

 								<!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
 								<input type="submit" id="accionBoton" class="btn green" value="<?=$nombreSubmit;?>"> 

 								<!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
 								<a href="../remisiones" class="btn grey-salsa btn-outline">Cancelar</a>
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
