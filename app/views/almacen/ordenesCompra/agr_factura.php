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



		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
		$("#agregarFact").submit(function(e){ 

			$.ajax({
				type: "POST",
				url: "../../../controllers/almacen/ordenesCompra/agregarFactura.php",
				data: "folio="+$("#folio").val()+
				'&factura='+$("#factura").val()+
				'&pass='+$("#pass").val()
			}).done(function(result){
				if(result=="Factura procesada"){
					swal (result, "", "success");
					$("#mainContent").load( "cat_ocompras.php" );
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
			<div class="caption">Agregar factura a orden: "<?php echo $codigo;?>" </div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

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
						<label class="col-md-3 control-label">No. Factura</label>
						<div class="col-md-7">
							<input type="text" class="form-control" id="factura" name="factura" required>
						</div>
					</div>
					<!-- TERMINA INPUT FOLIO-->

					<!-- INICIA INPUT FOLIO-->
					<div class="form-group">
						<label class="col-md-3 control-label">Confirmar contraseña</label>
						<div class="col-md-7">
							<input type="password" class="form-control" id="pass" name="pass" required>
							<input type="hidden" id="folio" name="folio" value="<?=$codigo;?>">
						</div>
					</div>
					<!-- TERMINA INPUT FOLIO-->


					<!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
					<div class="form-actions">
						<div class="row">
							<div class="text-center">

								<!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
								<input type="submit" id="accionBoton" class="btn green" value="<?=$nombreSubmit;?>"> 

								<!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
								<a href="../ordenesCompra" class="btn grey-salsa btn-outline">Cancelar</a>
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