<?php
###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');



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

		$("#back_form_import").click(function(){
			window.location = "";
		});

		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
		$("#agregarFact").submit(function(e){ 

			/* CONDICIONES PARA EL TIPO DE PRODUCTO*/
			if($("#definitiva").is(':checked')){
				var tipo = "1";
			}
			else{
				if($("#express").is(':checked')){
					var tipo = "2";
				}
			} 

			$.ajax({
				type: "POST",
				url: "../../../controllers/aduanas/importaciones/agregarPedimento.php",
				data: "pedimento="+$("#pedimento").val()+
				'&importacion='+$("#importacion").val()+
				'&entrada='+tipo+
				'&pass='+$("#pass").val()
			}).done(function(result){
				if(result!="Password no corresponde al usuario activo"){
					swal({
						title: result,
						type: "success",
						showCloseButton: true,
						confirmButtonText:'Cerrar'
					});
					$("#mainContent").load( "cat_importaciones.php" );
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


<div class="col-md-12">

	<!--INICIA PORTLET-->
	<div class="portlet box grey-steel">

		<!--INICIA TITULO DE PORTLET-->
		<div class="portlet-title">

			<!--INICIAN ESTILOS DE TITULO DE PORTLET-->
			<div class="caption"><div class="font-grey-mint"><b>Agregar pedimento	</b></div></div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
			<div class="actions btn-set">
				<button type="button" name="back" id="back_form_import" class="btn green-seagreen">
					<i class="fa fa-arrow-left"></i>&nbsp;Regresar
				</button>
			</div>
		</div>
		<!-- TERMINA TITULO DE PORTLET -->

		<!--INICIA CUERPO DE PORTLET-->
		<div class="portlet-body form">


			<!--INICIA FORM-->
			<form class="form-horizontal save-user" id="agregarFact" >

				<!--INICIAN ESTILOS DE FORM-->
				<div class="form-body">


					<!-- INICIA INPUT FOLIO-->
					<div class="form-group">
						<label class="col-md-3 control-label">No. Pedimento</label>
						<div class="col-md-6">
							<input type="text" class="form-control" id="pedimento" name="pedimento" required>
							<input type="hidden" id="importacion" value="<?=$codigo;?>">
						</div>
					</div>
					<!-- TERMINA INPUT FOLIO-->

					<!-- INICIA RADIO PRESENTACION-->
					<div class="form-group">
						<label class="control-label col-md-3" >Tipo de entrada
						</label>
						<div class="input-group">
							<div class="icheck-inline col-md-12" >
								<label>
									<input type="radio" name="presentacion" id="definitiva" class="icheck" data-radio="iradio_square-grey" required> Definitiva 
								</label>
								<label>
									<input type="radio" name="presentacion" id="express" class="icheck" data-radio="iradio_square-grey"> Exprés 
								</label>
							</div>
						</div>
					</div>
					<!-- TERMINA RADIO PRESENTACION-->

					<!-- INICIA INPUT FOLIO-->
					<div class="form-group">
						<label class="col-md-3 control-label">Autorización</label>
						<div class="col-md-6">
							<input type="password" class="form-control" id="pass" name="pass" required placeholder="Ingrese su contraseña">
							
						</div>
					</div>
					<!-- TERMINA INPUT FOLIO-->



					<div class="text-center">
						<hr>
						<!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
						<input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>"> 

						<!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
						<a href="../importaciones" class="btn grey-salsa btn-outline">Cancelar</a>
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