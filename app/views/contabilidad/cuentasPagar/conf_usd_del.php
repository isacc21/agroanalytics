<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 03 Abril 2017 : 12:17                                                              #
#                                                                                    #
###### cuentasCobrar/conf_usd.php ####################################################
#                                                                                    #
# Archivo sin estructura de la lista de acreedores para ser recibido por             #  
# JQuery en index de "Cuentas por cobrar USD"                                        #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 03-ABR-17: 12:17                                                                   #
# IJLM - Se copia FORMULARIO de registro en bancos                                   #
# IJLM - Se realizan los cambios pertinentes para confirmar contraseña.              #
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
				url: "../../../controllers/contabilidad/usd/cuentasPagar/cancelarCXP.php",
				data: "folio="+$("#folio").val()+
				'&pass='+$("#pass").val()
			}).done(function(result){
				if(result=="Cancelación Exitosa"){
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
				<i class="fa fa-save"></i> Confirmar cancelación <?php echo $codigo;?> 
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

					<!-- INICIA INPUT FOLIO-->
					<div class="form-group">
						<label class="col-md-4 control-label">Confirmar contraseña</label>
						<div class="col-md-6">
							<input type="password" class="form-control input-circle" id="pass" name="pass" required>
							<input type="hidden" id="folio" name="folio" value="<?=$codigo;?>">
						</div>
					</div>
					<!-- TERMINA INPUT FOLIO-->


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