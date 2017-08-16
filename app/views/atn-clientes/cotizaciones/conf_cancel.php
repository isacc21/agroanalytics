<?php
###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/atn-cliente/cotizaciones.php';


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

		$("#back_form_cotiz").click(function(){
			window.location = "";
		});

		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
		$("#cancelarBankD").submit(function(e){ 

			$.ajax({
				type: "POST",
				url: "../../../controllers/atn-cliente/cotizaciones/cancelarCoti.php",
				data: "folio="+$("#folio").val()+
				'&pass='+$("#pass").val()
			}).done(function(result){
				if(result=="Cancelación Exitosa"){
					swal({
						title: result,
						type: "success",
						showCloseButton: true,
						confirmButtonText:'Cerrar'
					});
					$("#mainContent").load( "cat_cotizaciones.php" );
				}else{
					swal({
						title: result,
						type: "warning",
						showCloseButton: true,
						confirmButtonText:'Cerrar'
					});
				}
				
			});
			return false;
		});
	});
</script>

<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-12">

	<!--INICIA PORTLET-->
	<div class="portlet  box grey-steel">

		<!--INICIA TITULO DE PORTLET-->
		<div class="portlet-title">

			<!--INICIAN ESTILOS DE TITULO DE PORTLET-->
			<div class="caption"><div class="font-grey-mint"> <b>Confirmar cancelación: "<?php echo $codigo;?>"</b> </div></div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
			<div class="actions btn-set">
				<button type="button" name="back" id="back_form_cotiz" class="btn green-seagreen">
					<i class="fa fa-arrow-left"></i>&nbsp;Regresar
				</button>
			</div>
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
						<label class="col-md-4 control-label">Autorización</label>
						<div class="col-md-6">
							<input type="password" class="form-control" id="pass" name="pass" required placeholder="Ingresa tu contraseña">
							<input type="hidden" id="folio" name="folio" value="<?=$codigo;?>">
						</div>
					</div>
					<!-- TERMINA INPUT FOLIO-->

					<div class="text-center">
						<hr>
						<!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
						<input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>"> 

						<!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
						<a href="../cotizaciones" class="btn grey-salsa btn-outline">Cancelar</a>
					</div>
					
					<!--TERMINA GRUPO DE BOTONES DE FORMULARIO-->
				</form>
				<!-- TERMINA FORM-->
			</div>
		</div>
		<!-- TERMINA CUERPO DE PORTLET-->
	</div>



