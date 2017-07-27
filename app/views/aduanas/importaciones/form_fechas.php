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


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

##### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ###############################
require '../../../models/aduanas/importaciones.php';

$importaciones = new importaciones($datosConexionBD);

$dd = date('d');
$mm = date('m');
$yyyy = date('Y');
$listaProductos = "";
$listaFacturas="";


$nombreSubmit = 'Guardar';
//echo $_REQUEST['codigo'];

$folio = $_REQUEST['codigo']; /*DESCOMENTAR Y COMENTAR LA LINEA DE ABAJO CUANDO QUEDE CORRECTO. */
//$folio = "I270717-01";

$importaciones->folio = $folio;
$consultar_facturas = $importaciones->consultarFacturas();
?>
<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
	$(document).ready(function(){

		/* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
		if ($("#accionBoton").val() == 'Guardar'){
			var urlCont = "../../../controllers/aduanas/importaciones/guardarFechas.php";
		} /* LLAVE DE IF */

		/* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
		$("#agregarFechas").submit(function(e){
			var fechasM ="";
			var fechasC ="";
			var lotes ="";
			var separacion = ":";
			var vueltas = $("#vueltas").val();

			for (var i = 0; i < vueltas; i++) {
				fechasM = fechasM + $("#fechaM"+i).val() + separacion;
				fechasC = fechasC + $("#fechaC"+i).val() + separacion;
				lotes = lotes + $("#lote"+i).val() + separacion;
			}
			//alert(fechasM+fechasC+lotes);

			$.ajax({
				type: "POST",
				url: urlCont,
				data: "productos="+$("#productos").val()+
				"&facturas="+$("#facturas").val()+
				"&fechasM="+fechasM+
				"&fechasC="+fechasC+
				"&lotes="+lotes+
				"&folio="+$("#folio").val()
			}).done(function(result){
				if(result=="RFC existente"){
					swal (result, "", "warning");
				}else{
					swal (result, "", "success");
				}
				$("#mainContent").load( "cat_importaciones.php" );
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
	<div class="portlet box blue-hoki">

		<!--INICIA TITULO DE PORTLET-->
		<div class="portlet-title">

			<!--INICIAN ESTILOS DE TITULO DE PORTLET-->
			<div class="caption">
				<!-- ICONO Y TEXTO DE TITULO-->
				<i class="fa fa-save"></i> Detalle importación
			</div>
			<!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

		</div>
		<!-- TERMINA TITULO DE PORTLET -->

		<!--INICIA CUERPO DE PORTLET-->
		<div class="portlet-body form">

			<!--INICIA FORM-->
			<form class="form-horizontal save-user" id="agregarFechas" >

				<!--INICIAN ESTILOS DE FORM-->
				<div class="form-body">
					<?php 
					$x=0;
					foreach($consultar_facturas as $row){
						$factura=$row['facturaImportacion'];
						echo '<label class="col-md-12 black"><strong> Productos de factura: '.$factura.'</strong></label><br><br>';
						$importaciones->factura=$factura;
						$consultar_ordenes=$importaciones->consultarCompras();
						foreach($consultar_ordenes as $row){
							$orden = $row['folioOrdenCompra'];
							$importaciones->orden = $orden;
							//echo $importaciones->orden;
							$consultar_productos = $importaciones->consultarProductosOC();
							foreach($consultar_productos as $row){
								$producto = $row['codigoProducto'];
								$importaciones->producto = $producto;
								$nombre_producto =$importaciones->consultarNombreProducto();
								$nombre = "";
								foreach($nombre_producto as $row){
									$nombre = $row['nombreProducto'];
									$presentacion = $row['presentacionProducto'];

									switch($presentacion){
										case 1:
										$pres = " | Cubeta";
										break;
										case 2:
										$pres = " | Tibor";
										break;
										case 3:
										$pres = " | Tote";
										break;
										case 4:
										$pres = " | Granel";
										break;
										case 5:
										$pres = " | Saco";
										break;
										case 6:
										$pres = " | Súper saco";
										break;
									}
								}

								?>
								<!-- INICIA INPUT PRODUCTO-->
								<div class="form-group">
									<label class="col-md-1 control-label"></label>
									<label class="col-md-8 black"><u><?echo $nombre.$pres;?></u></label><br>
								</div>
								<div class="form-group">
									<label class="control-label col-md-3">Fecha de Manufactura</label>
									<label class="control-label col-md-3">Fecha de Caducidad&nbsp;&nbsp;&nbsp;</label>
									<label class="col-md-3 control-label">Lote de producción&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
								</div>
								<div class="form-group">
									<div class="col-md-1"></div>
									<div class="col-md-3">
										<div class="input-group  date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
											<input type="text" class="form-control readonly"  id="fechaM<?=$x;?>" required placeholder="Seleccione fecha">
											<span class="input-group-btn">
												<button class="btn default" type="button">
													<i class="fa fa-calendar"></i>
												</button>
											</span>
										</div></div>

										
										<div class="col-md-3">
											<div class="input-group  date date-picker" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
												<input type="text" class="form-control readonly"  id="fechaC<?=$x;?>" required placeholder="Seleccione fecha">
												<span class="input-group-btn">
													<button class="btn default" type="button">
														<i class="fa fa-calendar"></i>
													</button>
												</span>
											</div></div>
											<div class="col-md-4">
												<input type="text" class="form-control" id="lote<?=$x;?>" name="lote" required>
												<input type="hidden" id="folio" value="<?=$_REQUEST['codigo'];?>">
											</div>
										</div>
										<!-- TERMINA INPUT PRODUCTO-->
										<?php
										$listaProductos = $listaProductos .$producto. ":";
										$listaFacturas = $listaFacturas . $factura.":";

										$x++;
									}
								}
							}

							?>


						</div>
						<input type="hidden" id="productos" name="productos" value="<?= $listaProductos;?>">
						<input type="hidden" id="facturas" name="facturas" value="<?= $listaFacturas;?>">
						<input type="hidden" id="vueltas" name="vueltas" value="<?= $x;?>">
						<input type="hidden" id="folio" value="<?=$folio;?>">




						<!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-4 col-md-12">

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



		<script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
		<script src="../../../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
		<script src="../../../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
		<script src="../../../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
		<script src="../../../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
		<script src="../../../../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript">
