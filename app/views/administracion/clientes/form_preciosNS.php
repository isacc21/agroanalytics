<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 10 Marzo 2017 : 08:22                                                              #
#                                                                                    #
###### clientes/form_precios.php #####################################################
#                                                                                    #
# Archivo sin estructura de la lista de precios para clientes para ser recibidos     #  
# JQuery en index de "CLIENTES"                                                      #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 10-MAR-17: 08:23                                                                   #
# IJLM - Se copia FORMULARIO de proveedores                                          #
# IJLM - Se realizan los cambios pertinentes a la sección precios de clientes        #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

##### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ###############################
require '../../../models/administracion/clientes.php';

$clientes = new clientes($datosConexionBD);

$precios = $clientes->consultarProductos();

$nombreSubmit = 'Guardar';

$listaProductos = "";
$listaPrecios = ""; 	
$listaID = ""; 	
$ppecial="";
$row['precioEspecial']="";
$row['rfcCliente']="";

$rfc=(isset($_REQUEST['rfc']))?$_REQUEST['rfc']:"";

###### SE DETERMINA SI SE ENCUENTRA UN RFC ###########################################
if (isset($_REQUEST['rfc'])){

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
	$nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
	$(document).ready(function(){

		/* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
		if ($("#accionBoton").val() == 'Guardar'){
			var urlCont = "../../../controllers/administracion/clientes/nvosPrecios.php";
		} /* LLAVE DE IF */


		else{
			if($("#accionBoton").val() == 'Actualizar'){
				var urlCont = "../../../controllers/administracion/clientes/actualizarPrecios.php";
			} /* LLAVE DE ELSE */
		} 


		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */

		
		$("#preciosProductos").submit(function(e){
			swal(urlCont);
			var precios ="";
			var separacion = ":";
			var vueltas = $("#vueltas").val();

			for (var i = 0; i < vueltas; i++) {
				precios = precios + $("#precio"+i).val() + separacion;
			}

			$.ajax({
				type: "POST",
				url: urlCont,
				data: "productos="+$("#productos").val()+
				"&precios="+precios+
				"&id="+$("#id").val()+
				"&rfc="+$("#rfc").val()
			}).done(function(result){
				if(result=="RFC existente"){
					swal (result, "", "warning");
				}else{
					swal (result, "", "success");
				}
				$("#mainContent").load( "cat_clientes.php" );
			});
			return false;
		});
	});
</script>

<style>
	input[type=number]::-webkit-outer-spin-button,
	input[type=number]::-webkit-inner-spin-button{
		-webkit-appearance: none;
		margin: 0;
	}
	input[type=number] {
		-moz-appearance:textfield;
	}
</style>

<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-12">

	<!--INICIA PORTLET-->
	<div class="portlet box grey-mint">

		<!--INICIA TITULO DE PORTLET-->
		<div class="portlet-title">

			<!--INICIAN ESTILOS DE TITULO DE PORTLET-->
			<div class="caption">
				<!-- ICONO Y TEXTO DE TITULO-->
				<i class="fa fa-save"></i> Lista de Precios
			</div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

		</div>
		<!-- TERMINA TITULO DE PORTLET -->

		<!--INICIA CUERPO DE PORTLET-->
		<div class="portlet-body form">


			<!--INICIA FORM-->
			<form class="form-horizontal save-user" id="preciosProductos" >

				<!--INICIAN ESTILOS DE FORM-->
				<div class="form-body">
					<?php 

					$x=0;

					$clientes->rfc = $_REQUEST['rfc'];
					$count_precios = $clientes->cuenta();
					//echo $count_precios;
					foreach($precios as $row){
						$producto = $row['nombreProducto'];
						$idProducto = $row['codigoProducto'];

						?>
						<!-- INICIA INPUT PRODUCTO-->
						<div class="form-group">
							<label class="col-md-3 control-label"><?echo $producto;?></label>
							<div class="col-md-3">
								<?php
								$precio =0;
								if($count_precios!=0){


									$clientes->codigo = $idProducto;
									$clientes->rfc = $_REQUEST['rfc'];
									$lista_precios = $clientes->consultarEspeciales();

									foreach($lista_precios as $row){
										$precioEspecial = $row['precioEspecial'];
										if($precioEspecial != 0 || $precioEspeciales != null){
											$final = $precioEspecial;
										}
									}
								}
								else{
									$final = "0.00";
								}

								?>

								<input type="number" class="form-control input-circle" id="precio<?=$x;?>" name="precio<?=$x;?>" step="0.01" min="0" value="<?=$final;?>">
								<input type="hidden" id="idProducto" name="idProducto" value="<?=$idProducto;?>">
							</div>
						</div>
						<!-- TERMINA INPUT PRODUCTO-->
						<?php
						$listaProductos = $listaProductos .$producto. ":";
						$listaPrecios = $listaPrecios .$precio. ":";
						$listaID = $listaID .$idProducto. ":";

						$x++;
					}




					?>
					<input type="hidden" id="productos" name="productos" value="<?= $listaProductos;?>">
					<input type="hidden" id="precios" name="precios" value="<?= $listaPrecios;?>">
					<input type="hidden" id="id" name="id" value="<?= $listaID;?>">
					<input type="hidden" id="vueltas" name="vueltas" value="<?= $x;?>">
					<input type="hidden" id="rfc" value="<?=$rfc;?>">




					<!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
					<div class="form-actions">
						<div class="row">
							<div class="col-md-offset-3 col-md-12">

								<!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
								<input type="submit" id="accionBoton" class="btn btn-circle green" value="<?=$nombreSubmit;?>"> 

								<!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
								<a href="../clientes" class="btn btn-circle grey-salsa btn-outline">Cancelar</a>
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

	<script src="../../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>

	<script src="../../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>

	<script src="../../../../assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>



	<script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL PLUGINS -->
	<!-- BEGIN THEME GLOBAL SCRIPTS -->
	<script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
	<!-- END THEME GLOBAL SCRIPTS -->
	<!-- BEGIN PAGE LEVEL SCRIPTS -->
	<script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
	<!-- END PAGE LEVEL SCRIPTS -->
	<!-- BEGIN THEME LAYOUT SCRIPTS -->

