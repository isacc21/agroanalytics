<?php
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
	include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
	require '../../../models/contabilidad/bancos.php';
	require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
	$bancos = new bancos($datosConexionBD);
	$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################

	$bancos->id = $_REQUEST['banco'];
	$lista_bancos = $bancos->estadoCuenta();


###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################

	$bancos->id = $_REQUEST['banco'];
	$consultaModal = $bancos->estadoCuenta();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
	$usuarios->id=$_SESSION['idUsuario'];

	$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
	foreach ($result as $row){
		$banco = $row['bancosPermiso'];
  }## LLAVE DE FOREACH ###############################################################


  $bancos->id=$_REQUEST['banco'];
  $ingresos = $bancos->consultarIngresos();

  foreach($ingresos as $row){
  	$monto_ingresos = $row['ingresos'];
  }

  $bancos->id=$_REQUEST['banco'];
  $egresos = $bancos->consultarEgresos();

  foreach($egresos as $row){
  	$monto_egresos = $row['egresos'];
  }

  $balance_gral = $monto_ingresos - $monto_egresos;

  $total = number_format($balance_gral,2, '.', ',');

  if($balance_gral<0){
  	$color = "red-thunderbird";
  }
  else{
  	$color="green-jungle";
  }
  $html_balance='<div class="text-center">
  
  <a data-toggle="modal" href="#modalBalance"><p class="btn '.$color.'">Balance: $ '.$total.'</p></a>
</div>';

$html_nuevo='<button id="gotoBancos" class="btn green-seagreen"><i class="fa fa-plus"></i>&nbsp;Nuevo</button>';
?>

<!-- INICIA LINK PARA ASSETS DE SWEET ALERTS -->
<link href="../../../../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
<!-- TERMINA LINK PARA ASSETS DE SWEET ALERTS -->


<!--INICIA ESTILOS PARA RADIO BUTTONS Y LABELS IMPROVISADOS -->
<style>
	input[type=radio] { display: none }
	label {cursor: pointer}   
</style>
<!--TERMINA ESTILOS PARA RADIO BUTTONS Y LABELS IMPROVISADOS -->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box grey-steel">
			<div class="portlet-title">

				<div class="caption"><div class="font-grey-mint"> <b>Catálogo</b> </div>

			</div>
			<div class="actions btn-set">
				<?php 
				if($banco[1]=='2'){
					echo $html_nuevo;
				} ?>
				<button type="button" name="back" id="back_cat_acre" class="btn green-seagreen">
					<i class="fa fa-arrow-left"></i>&nbsp;Regresar
				</button>


			</div>

		</div>
		<div class="portlet-body">
			<!-- INICIA ENCABEZADO DE CUERPO DE PORTLET-->
			<div class="table-toolbar">

				<?php

				if($banco[0]=='1'){
      //echo $html_filtros;
					echo $html_balance;
				}
				?>



			</div>
			<!-- INICIA ENCABEZADO DE CUERPO DE PORTLET-->

			<!-- TERMINA ENCABEZADO DE CUERPO DE PORTLET-->
			<table class="table table-striped table-bordered table-hover order-column" id="sample_1">
				<thead>
					<tr>
						<th> Fecha <small>[AAAA/MM/DD]</small> </th>
						<th> Mét. Pago </th>
						<th> Cargo </th>
						<th> Abono </th>
						<th> Balance</th>
						<th> Concepto </th>
						<th> Descripción </th>
						<th> Acciones </th>
					</tr>
				</thead>
				<tbody>

					<!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
					<?php
					foreach($lista_bancos as $row){
						$folio = $row['folioBanco'];
						$fecha = $row['yyyyBanco']."/".$row['mmBanco']."/".$row['ddBanco'];
						$metpago = $row['pagoBanco'];
						$tipo = $row['tipoBanco'];
						$monto = $row['montoBanco'];
						$concepto = $row['conceptoBanco'];
						$descripcion = $row['descBanco'];

						$monto_cf = number_format($monto,2, '.', ',');
						$noes = number_format(0,2, '.', ',');
						if($tipo == 1){
							$balance += $monto;
						}
						else{
							if($tipo == 2){
								$balance -= $monto;
							}
						}

						$balance_cf = number_format($balance,2, '.', ',');
						?>
						<!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

						<!-- INICIA FILA CON VARIABLES DE FOREACH-->
						<tr class="odd gradeX">
							<td><?php echo $fecha; ?></td>
							<td><?php echo $metpago; ?></td>
							<td><?php if($tipo==1){echo "$ ".$monto_cf;}else{echo "$ ".$noes;} ?></td>
							<td><?php if($tipo==2){echo "$ ".$monto_cf;}else{echo "$ ".$noes;} ?></td>
							<td><?php echo "$ ".$balance_cf; ?></td>
							<td><?php echo $concepto; ?></td>
							<td><?php echo $descripcion; ?></td>
							<td>
								<?php

								$html_inicio_actions='<div class="text-center"><div class="btn-group">
								<button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 
									&nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
									&nbsp; Elegir&nbsp;&nbsp;
								</button><ul class="dropdown-menu pull-right" role="menu">';

								$html_final_actions='</ul></div></div>';

								$html_moreInfo='<li>
								<a data-toggle="modal" href="#modal'.$folio.'">
									<i class="icon-magnifier"></i> Ver info.<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></a>
								</li>';

								$html_editar='<li><a><input type="radio" id="editar'.$folio.'" class="editar" name="editar" value="'.$folio.'">
								<label for="editar'.$folio.'">  <i class="fa fa-edit"></i>&nbsp;Modificar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';


								if($banco[0]=='1'||$banco[1]=='2'||$banco[2]=='3'||$banco[3]=='4'){
									echo $html_inicio_actions;
								}
								if($banco[0]=='1'){
									echo $html_moreInfo; 
								}
								if($banco[2]=='3'){
									echo $html_editar;
								}
								if($banco[3]=='4'){
									echo $html_eliminar;
								}
								if($banco[0]=='1'||$banco[1]=='2'||$banco[2]=='3'||$banco[3]=='4'){
									echo $html_final_actions;
								}
								?>
							</td>
						</tr>
						<!-- TERMINA FILAS CON VARIABLES DE FOREACH-->

						<!-- INICIA LLAVE DE FOREACH PARA TABLA DE ACREEDORES-->
						<?php 
					}
					?>
					<!-- TERMINA LLAVE DE FOREACH PARA TABLA DE ACREEDORES-->
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($consultaModal as $row){
	$folio = $row['folioBanco'];
	$fecha = $row['yyyyBanco']."/".$row['mmBanco']."/".$row['ddBanco'];
	$metpago = $row['pagoBanco'];
	$tipo = $row['tipoBanco'];
	$monto = $row['montoBanco'];
	$concepto = $row['conceptoBanco'];
	$descripcion = $row['descBanco'];
	$usuario = $row['idUsuario'];

	$monto_cf = number_format($monto,2, '.', ',');
	$noes = number_format(0,2, '.', ',');
	if($tipo == 1){
		$balance += $monto;
	}
	else{
		if($tipo == 2){
			$balance -= $monto;
		}
	}

	$balance_cf = number_format($balance,2, '.', ',');

	$usuarios->id=$usuario;
	$cnombres = $usuarios->consultarUsuariosID();

	foreach ($cnombres as $row){
		$nombreUser = $row['nombreUsuario']." ".$row['apellidosUsuario'];
	}


	?>
	<!-- INICIO DE VENTANA MODAL -->
	<div class="modal fade" id="modal<?=$folio;?>" tabindex="-1" role="basic" aria-hidden="true">

		<!-- INICIO DE VENTANA MODAL -->
		<div class="modal-dialog">

			<!-- INCIO DE DEFINICIO DE CONTENIDO DE VENTANA MODAL -->
			<div class="modal-content">

				<!-- INICIO DE CABECERA DE VENTANA MODAL -->
				<div class="modal-header">

					<!-- BONTON DE CIERRE DE VENTANA MODAL-->
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

					<!-- ENCABEZADO DE VENTANA MODAL-->
					<h4 class="modal-title">Información completa</h4>
				</div>
				<!-- TERMINA CABECERA DE VENTANA MODAL -->

				<!-- INICIA CUERPO DE VENTANA MODAL-->
				<div class="modal-body">

					<!-- INICIA TABLA SIMPLE PARA MOSTRAR DETALLES DE ACREEDORES-->
					<table class="table table-hover">
						<tr>
							<td><b>Código de operación: </b></td>
							<td><b><?php echo $folio;?></b></td>
						</tr>

						<tr>
							<td>Fecha: </td>
							<td><?php echo $fecha;?></td>
						</tr>

						<tr>
							<td>Método de Pago: </td>
							<td><?php echo $metpago;?></td>
						</tr>
						<tr>
							<td>Tipo de registro:</td>
							<td><?php if($tipo==1){echo "Ingreso";}else{echo '"Egreso';} ?></td>
						</tr>
						<tr>
							<td>Monto: </td>
							<td><?php echo "$ ".$monto_cf; ?></td>
						</tr>

						<tr>
							<td>Concepto: </td>
							<td><?php echo $concepto;?></td>
						</tr>

						<tr>
							<td>Descripción: </td>
							<td><?php echo $descripcion;?></td>
						</tr>

						<tr>
							<td>Registrado por:</td>
							<td><?php echo $nombreUser; ?></td>
						</tr>
					</table>
				</div>
				<!-- TERMINA TABLA SIMPLE PARA DETALLES DE ACREEDORES-->

				<!-- INICIA PIE DE VENTANA MODAL-->
				<div class="modal-footer">

					<!-- BOTON DE CIERRE PARA VENTANA MODAL-->
					<button type="button" class="btn green-seagreen btn-outline" data-dismiss="modal">Cerrar</button>
				</div>
				<!-- TERMINA PIE DE VENTANA MODAL-->
			</div>
			<!-- TERMINO DE DEFINICION DE CONTENIDO DE VENTANA MODAL -->
		</div>
		<!-- TERMINO DE VENTANA MODAL  -->
	</div>
	<!-- TERMINO DE VENTANA MODAL -->
	<?
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE ACREEDORES #############################################
?>

<!-- INICIO DE VENTANA MODAL -->
<div class="modal fade" id="modalBalance" tabindex="-1" role="basic" aria-hidden="true">

	<!-- INICIO DE VENTANA MODAL -->
	<div class="modal-dialog">

		<!-- INCIO DE DEFINICIO DE CONTENIDO DE VENTANA MODAL -->
		<div class="modal-content">

			<!-- INICIO DE CABECERA DE VENTANA MODAL -->
			<div class="modal-header">

				<!-- BONTON DE CIERRE DE VENTANA MODAL-->
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

				<!-- ENCABEZADO DE VENTANA MODAL-->
				<h4 class="modal-title">Balance general</h4>
			</div>
			<!-- TERMINA CABECERA DE VENTANA MODAL -->

			<!-- INICIA CUERPO DE VENTANA MODAL-->
			<div class="modal-body">
				<?php 
				if($total<0){
					$color="font-red-mint";
				}
				else{
					$color="";
				}
				$ingreso = number_format($monto_ingresos,2, '.', ',');
				$egreso = number_format($monto_egresos,2, '.', ',');
				?>
				<h1><p class="text-center <?php echo $color;?>"><?php echo '$ '.$total;?></p></h1>
				<table class="table table-hover">
					<tr>
						<td><h4>Ingresos:</h4> </td>
						<td><h4><?php echo '$ '.$ingreso?></h4></td>
					</tr>
					<tr>
						<td><h4>Egresos: </h4></td>
						<td><h4><?php echo '$ '.$egreso?></h4></td>
					</tr>
				</table>
			</div>
			<!-- TERMINA TABLA SIMPLE PARA DETALLES DE ACREEDORES-->

			<!-- INICIA PIE DE VENTANA MODAL-->
			<div class="modal-footer">

				<!-- BOTON DE CIERRE PARA VENTANA MODAL-->
				<button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
			</div>
			<!-- TERMINA PIE DE VENTANA MODAL-->
		</div>
		<!-- TERMINO DE DEFINICION DE CONTENIDO DE VENTANA MODAL -->
	</div>
	<!-- TERMINO DE VENTANA MODAL  -->
</div>
<!-- TERMINO DE VENTANA MODAL -->

<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
	$(document).ready(function(){

		$("#back_cat_acre").click(function(){
			window.location = "";
		});

		/* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
		$("#gotoBancos").click(function(){
			$("#mainContent").load( "form_bancos.php?banco="+<?=$_REQUEST['banco'];?> );
		});


		/* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
		$('.editar').click(function() {
			$("#mainContent").load( "form_bancos.php?folio="+$(this).val() );

		});

		/* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
		$(".borrar").click(function(){

			var rfcAcreedor = $(this).val();

			swal({
				title: "¿Eliminar acreedor?",
				text: "Se eliminará permanentemente",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Eliminar",
				cancelButtonText: "Cancelar",
				closeOnConfirm: false,
				closeOnCancel: false
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
						type: "POST",
						url: "../../../controllers/administracion/acreedores/eliminarAcreedor.php",
						data:"rfc="+ rfcAcreedor
					}).done(function(result){
						swal({
							title: "Eliminado",
							text: "El acreedor ha sido eliminado",
							type: "success",
							showCloseButton: true,
							confirmButtonText:'Cerrar'
						});
						$("#mainContent").load( "cat_acreedores.php" );
					});

				} else {
					swal({
						title: "Cancelado",
						text: "Se ha conservado el acreedor",
						type: "error",
						showCloseButton: true,
						confirmButtonText:'Cerrar'
					});
				}
			});
		});
	});
</script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>


<!-- TERMINAN SCRIPTS PARA EL FUNCIONAMIENTO DE DATA TABLES-->
<?php
}else{
	header("LOCATION: ../../../../index.php");
}
?>