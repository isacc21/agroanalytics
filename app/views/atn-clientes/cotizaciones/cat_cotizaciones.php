<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Marzo 2017 : 12:07                                                              #
#                                                                                    #
###### bancos/cat_bancoD.php #########################################################
#                                                                                    #
# Archivo sin estructura del catálogo de bancos para ser recibido por                #  
# JQuery en index de "Bancos Dolares"                                                #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-MAR-17: 12:07                                                                   #
# IJLM - Se copia CATALOGO de acreedores                                             #
######################################################################################


###### DEFINICION DE ZONA HORARIO ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/atn-cliente/cotizaciones.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$cotizaciones = new cotizaciones($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$listaCotizaciones = $cotizaciones->consultarCotizaciones();


$select_meses ="";

$cancel = "";
$all = "";
$defeat = "";
$used = "";
$register = "";
$todos = "";


if(isset($_REQUEST['codigo'])&&isset($_REQUEST['mes'])){
	if($_REQUEST['codigo']=="todas"&&$_REQUEST['mes']=='00'){
		$filtro = $listaCotizaciones;
		$todos = "";
		$all = "";
	}
	if($_REQUEST['codigo']!="todas"&&$_REQUEST['mes']=='00'){
		$cotizaciones->status = $_REQUEST['codigo'];
		$filtro = $cotizaciones->consultarxStatus();

		if($_REQUEST['codigo']=="1"){
			$register = "selected";
		}
		if($_REQUEST['codigo']=="2"){
			$defeat = "selected";
		}
		if($_REQUEST['codigo']=="3"){
			$cancel = "selected";
		}
		if($_REQUEST['codigo']=="4"){
			$used = "selected";
		}

	}
	if($_REQUEST['codigo']=="todas"&&$_REQUEST['mes']!='00'){
		$cotizaciones->mm = $_REQUEST['mes'];
		$filtro = $cotizaciones->consultarxMes();

		switch($_REQUEST['mes']){
			case '01':
			$meses[0]="selected";
			break;
			case '02':
			$meses[1]="selected";
			break;
			case '03':
			$meses[2]="selected";
			break;
			case '04':
			$meses[3] = "selected";
			break;
			case '05':
			$meses[4]="selected";
			break;
			case '06':
			$meses[5]="selected";
			break;
			case '07':
			$meses[6]="selected";
			break;
			case '08':
			$meses[7]="selected";
			break;
			case '09':
			$meses[8]="selected";
			break;
			case '10':
			$meses[9]="selected";
			break;
			case '11':
			$meses[10]="selected";
			break;
			case '12':
			$meses[11]="selected";
			break;

		}
		$all = "selected";
	}


	if($_REQUEST['codigo']!="todas"&&$_REQUEST['mes']!='00'){
		$cotizaciones->status = $_REQUEST['codigo'];
		$cotizaciones->mm = $_REQUEST['mes'];
		$filtro = $cotizaciones->consultarxStatusyMes();

		if($_REQUEST['codigo']=="1"){
			$register = "selected";
		}
		if($_REQUEST['codigo']=="2"){
			$defeat = "selected";
		}
		if($_REQUEST['codigo']=="3"){
			$cancel = "selected";
		}
		if($_REQUEST['codigo']=="4"){
			$used = "selected";
		}
		switch($_REQUEST['mes']){
			case '01':
			$meses[0]="selected";
			break;
			case '02':
			$meses[1]="selected";
			break;
			case '03':
			$meses[2]="selected";
			break;
			case '04':
			$meses[3] = "selected";
			break;
			case '05':
			$meses[4]="selected";
			break;
			case '06':
			$meses[5]="selected";
			break;
			case '07':
			$meses[6]="selected";
			break;
			case '08':
			$meses[7]="selected";
			break;
			case '09':
			$meses[8]="selected";
			break;
			case '10':
			$meses[9]="selected";
			break;
			case '11':
			$meses[10]="selected";
			break;
			case '12':
			$meses[11]="selected";
			break;

		}


	}
}
else{
	if(!isset($_REQUEST['codigo'])||$_REQUEST['codigo']=="todas"||$_REQUEST['mes']){
		$filtro = $listaCotizaciones;
		$all = "selected";
	}
	else{
		$cotizaciones->status = $_REQUEST['codigo'];
		$filtro = $cotizaciones->consultarxStatus();

		if($_REQUEST['codigo']=="1"){
			$register = "selected";
		}
		if($_REQUEST['codigo']=="2"){
			$defeat = "selected";
		}
		if($_REQUEST['codigo']=="3"){
			$cancel = "selected";
		}
		if($_REQUEST['codigo']=="4"){
			$used = "selected";
		}
	}
}



###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $cotizaciones->consultarCotizaciones();
$consultarProductos = $cotizaciones->consultarCotizaciones();

$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
	$pCotizacion = $row['cotizacionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';
  $html_nuevo='<button id="gotoCotiz" class="btn sbold green">Nuevo <i class="fa fa-plus"></i></button>';


  $html_balance='<div class="col-md-6">
  <div class="btn-group pull-right">
  	<a data-toggle="modal" href="#modalBalance"><p class="btn '.$color.'">Balance: $ '.$total.'</p></a>
  </div></div>';
  $html_filtros='
  <button class="btn green  btn-outline dropdown-toggle" data-toggle="dropdown">Filtros
  	<i class="fa fa-angle-down"></i>
  </button>
  <ul class="dropdown-menu pull-right">
  	<li>
  		<a href="#" id="bank_all">
  			<i class="fa fa-ellipsis-v"></i> Todos los registros 
  		</a>
  	</li>
  	<li>
  		<a href="#" id="bank_reg">
  			<i class="fa fa-check-circle"></i> Solo registrados 
  		</a>
  	</li>
  	<li>
  		<a href="#" id="bank_cancel">
  			<i class="fa fa-times-circle"></i> Solo cancelados
  		</a>
  	</li>
  	<li>
  		<a href="#" id="bank_down">
  			<i class="fa fa-level-down"></i> Solo ingresos
  		</a>
  	</li> 
  	<li>
  		<a href="#" id="bank_up">
  			<i class="fa fa-level-up"></i> Solo egresos
  		</a>
  	</li>
  </ul>';

  $html_registrado='<div class="text-center"><span class="label label-sm label-success"> Vigente </span></div>';
  $html_vencida='<div class="text-center"><span class="label label-sm label-warning"> Vencida </span></div>';
  $html_utilizada='<div class="text-center"><span class="label label-sm label-info"> Utilizada </span></div>';
  $html_cancelado='<div class="text-center"><span class="label label-sm label-danger"> Cancelada </span></div>';

  $html_ingreso='<div class="text-center"><span class="label label-sm label-success"> Ingreso </span></div>';
  $html_egreso='<div class="text-center"><span class="label label-sm label-danger"> Egreso </span></div>';

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

  <!-- INICIA ROW PARA PORTLET Y DATA TABLE-->
  <div class="row">

  	<!-- INICIA COLUMNA DE 12 PARA PORTLET-->
  	<div class="col-md-12">
  		<!-- INICIA PORTLET -->
  		<div class="portlet light bordered">

  			<!-- INICIA TITULO DE PORTLET-->
  			<div class="portlet-title">

  				<!-- INICIAN ESTILOS PARA TITULO DE PORTLET-->
  				<div class="caption font-dark">

  					<!-- ICONO A DERECHA DE TITULO DE PORTLET-->
  					<i class="fa fa-list-alt font-dark"></i>

  					<!-- TEXTO DE TITULO DE PORTLET-->
  					<span class="caption-subject bold uppercase"> Cotizaciones</span>
  				</div>


  				<div class="actions">
  					<div class="btn-group btn-group-devided" data-toggle="buttons">

  						<select id="select_year" class="btn grey-cascade btn-outline" required >
  							<option <?php echo $todos_a;?> value="0000>">Año</option>
  							<?php 
  							$years = $cotizaciones->consultarAnios();
  							foreach ($years as $row){
  								$yyyy = $row['yyyyCotizacion'];

  								?>
  								<option <?php echo $anios[$yyyy];?> value="<?=$yyyy;?>"><? echo $yyyy;?></option>
  								<?php
  							}
  							?>
  						</select>
  					</div>
  					&nbsp;
  					<div class="btn-group btn-group-devided" data-toggle="buttons">
  						<select id="select_month" class="btn grey-cascade btn-outline" required >
  							<option <?php echo $todos;?> value="00">Mes</option>
  							<option <?php echo $meses[0];?> value="01">Enero</option>
  							<option <?php echo $meses[1];?> value="02">Febrero</option>
  							<option <?php echo $meses[2];?> value="03">Marzo</option>
  							<option <?php echo $meses[3];?> value="04">Abril</option>
  							<option <?php echo $meses[4];?> value="05">Mayo</option>
  							<option <?php echo $meses[5];?> value="06">Junio</option>
  							<option <?php echo $meses[6];?> value="07">Julio</option>
  							<option <?php echo $meses[7];?> value="08">Agosto</option>
  							<option <?php echo $meses[8];?> value="09">Septiembre</option>
  							<option <?php echo $meses[9];?> value="10">Octubre</option>
  							<option <?php echo $meses[10];?> value="11">Noviembre</option>
  							<option <?php echo $meses[11];?> value="12">Diciembre</option>
  						</select>
  					</div>
  					&nbsp;
  					<div class="btn-group btn-group-devided" data-toggle="buttons">
  						<select id="filtro" class="btn grey-cascade btn-outline" required >
  							<option <?php echo $all;?> value="todas">Todos los registros</option>
  							<option <?php echo $register;?> value="1">Registradas</option>
  							<option <?php echo $defeat;?> value="2">Vencidas</option>
  							<option <?php echo $cancel;?> value="3">Canceladas</option>
  							<option <?php echo $used;?> value="4">Utilizadas</option>
  						</select>
  					</div>
  					<?php if($pCotizacion[1]=='2'){
  						echo $html_nuevo;
  					} ?>
  					<button type="button" name="back" id="back_cat_coti" class="btn default green-stripe">
  						<i class="fa fa-arrow-left"></i> Regresar
  					</button>
  				</div>


  				<!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->
  			</div>
  			<!-- TERMINA TITULO DE PORTLET-->

  			<!-- INICIA CUERPO DE PORTLET-->
  			<div class="portlet-body">

  				<!-- INICIA DATA TABLE PARA CATALOGO DE ACREEDORES-->
  				<table class="table table-striped table-bordered table-hover order-column" id="sample_1">

  					<!-- INICIAN ENCABEZADOS PARA DATATALBE -->
  					<thead>
  						<tr>
  							<th> Código </th>
  							<th> Fecha [AAAA/MM/DD] </th>
  							<th> Cliente </th>
  							<th> Total </th>
  							<th> Estatus </th>
  							<th> Acciones </th>
  						</tr>
  					</thead>
  					<!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

  					<!-- INICIA CUERPO DE DATA TABLE-->
  					<tbody>

  						<!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
  						<?php
  						foreach($filtro as $row){
  							$codigo = $row['folioCotizacion'];
  							$cliente = $row['rfcCliente'];
  							$dd = $row['ddCotizacion'];
  							$mm = $row['mmCotizacion'];
  							$yyyy = $row['yyyyCotizacion'];
  							$total = $row['totalCotizacion'];
  							$status = $row['statusCotizacion'];
  							$num = number_format($total,2, '.', ',');
  							?>
  							<!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

  							<!-- INICIA FILA CON VARIABLES DE FOREACH-->
  							<tr class="odd gradeX">


  								<td> <?php echo $codigo;?> </td>
  								<td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>
  								<?php
  								$cotizaciones->cliente = $cliente;
  								$consultaClientes = $cotizaciones->consultarClientes();
  								foreach($consultaClientes as $row){
  									$name_cliente = $row['razonSocCliente'];
  								}
  								?>
  								<td> <?php echo $name_cliente; ?></td>
  								<td> <?php echo '$ '.$num;?></td>
  								<td>
  									<?php 
  									if($status==1){
  										echo $html_registrado;
  									}
  									else{
  										if($status==2){
  											echo $html_vencida;
  										}
  										else{
  											if($status==3){
  												echo $html_cancelado;
  											}
  											else{
  												if($status == 4){
  													echo $html_utilizada;
  												}
  											}
  										}
  									}
  									?>
  								</td>
  								<td>

  									<!-- INICIAN BOTONES DE ACCIONES-->

  									<?php

  									$html_inicio_action='<div class="text-center"><div class="btn-group">
  									<button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 
  										&nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
  										&nbsp; Elegir&nbsp;&nbsp;
  									</button><ul class="dropdown-menu pull-right" role="menu">';

  									$html_final_action='</ul></div></div>';
  									$html_moreInfo='<li>
  									<a data-toggle="modal" href="#modal'.$codigo.'">
  										<i class="icon-magnifier"></i> Ver info. </a>
  									</li>';

  									$html_productos='<li>
  									<a data-toggle="modal" href="#productos'.$codigo.'">
  										<i class="icon-magnifier"></i> Productos </a>
  									</li>';


  									$html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
  									<label for="cancelar'.$codigo.'" ">  <i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Cancelar </label></a></li>';



  									$html_imprimir='<li><a><input type="radio" id="imprimir'.$codigo.'" class="imprimir" name="imprimir" value="'.$codigo.'">
  									<label for="imprimir'.$codigo.'" ">  <i class="fa fa-print"></i>&nbsp;Imprimir </label></a></li>';
  /*$html_editar='<li><a><input type="radio" id="editar'.$codigo.'" class="editar" name="editar" value="'.$codigo.'">
  <label for="editar'.$codigo.'">  <i class="fa fa-edit"></i>&nbsp;Modificar </label></a></li>';

  $html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
  <label for="cancelar'.$codigo.'">  <i class="fa fa-times-circle"></i>&nbsp;Cancelar </label></a></li>';*/


  if($pCotizacion[0]=='1'||$pCotizacion[1]=='2'||$pCotizacion[2]=='3'||$pCotizacion[3]=='4'){
  	echo $html_inicio_action;
  }
  if($pCotizacion[0]=='1'){
  	echo $html_moreInfo; 
  	echo $html_productos;
  	echo $html_imprimir;
  }
  if($pCotizacion[2]=='3'&&$status==1){
    //echo $html_editar;
  }
  if($pCotizacion[3]=='4'&&$status==1){
  	echo $html_cancelar;
  }
  if($pCotizacion[0]=='1'||$pCotizacion[1]=='2'||$pCotizacion[2]=='3'||$pCotizacion[3]=='4'){
  	echo $html_final_action;
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
<!-- TERMINA CUERPO DE DATA TABLE -->

</table>
<!-- TERMINA DATA TABLE PARA TABLA DE ACREEDORES-->

</div>
<!-- TERMINA CUERPO DE PORTLET -->
</div>
<!-- TERMINA PORTLET-->
</div>
<!-- TERMINAR COLUMNA DE 12 PARA PORTLET-->

</div>
<!-- TERMINA ROW PARA PORTLET-->



<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($consultaModal as $row){
	$codigo = $row['folioCotizacion'];
	$cliente = $row['rfcCliente'];
	$dd = $row['ddCotizacion'];
	$mm = $row['mmCotizacion'];
	$yyyy = $row['yyyyCotizacion'];
	$usuario = $row['idUsuario'];
	$pedido = $row['folioPedido'];
	$status = $row['statusCotizacion'];
	$num = number_format($total,2, '.', ',');

	$usuarios->id=$usuario;
	$cnombres = $usuarios->consultarUsuariosID();

	foreach ($cnombres as $row){
		$nombreUser = $row['nombreUsuario']." ".$row['apellidosUsuario'];
	}


	?>
	<!-- INICIO DE VENTANA MODAL -->
	<div class="modal fade" id="modal<?=$codigo;?>" tabindex="-1" role="basic" aria-hidden="true">

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
							<td>Código de operación: </td>
							<td><?php echo $codigo;?></td>
						</tr>

						<tr>
							<td>Fecha: </td>
							<td><?php echo $dd."/".$mm."/".$yyyy;?></td>
						</tr>


						<tr>
							<td><?php 
								if($status==1||$status==2){
									echo "Última edición por:";
								}
								else{
									if($status==3){
										echo "Cancelada por:";
									}
									else{
										if($status==4){
											echo "Utilizada por:";
										}
									}
								}
								?> </td>
								<td><?php echo $nombreUser;?></td>

							</tr><?php
							if($pedido!=NULL){
								echo "<tr><td>Utilizada en pedido: </td><td>".$pedido."</td></tr>";
							}
							?>
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
		<?
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE ACREEDORES #############################################
?>


<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($consultarProductos as $row){
	$codigo = $row['folioCotizacion'];
	$cliente = $row['rfcCliente'];




	?>
	<!-- INICIO DE VENTANA MODAL -->
	<div class="modal fade" id="productos<?=$codigo;?>" tabindex="-1" role="basic" aria-hidden="true">

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
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Precio Unitario</th>
							<th>Monto</th>
							<th>En existencia</th>
						</tr>
						<?php 
						$total_coti = 0;
						$cotizaciones->folio = $codigo;
						$detalles = $cotizaciones->consultarDetalle();

						foreach($detalles as $row){
							$producto = $row['codigoProducto'];

              $cantidad = $row['cantidadDetalleCotizacion'];
              $unidad = $row['unidadDetalleCotizacion'];
              $monto = $row['montoDetalleCotizacion'];

              


              $typep="";
              switch($unidad){
                case "Litros":
                $typep = "  [Lit]";
                $precio_unidad = 1;
                break;
                case "Galones":
                $typep = "  [Gal]";
                $precio_unidad = 2;
                break;
                case "Ton_Metrica": 
                $typep = "  [Ton. Met.]";
                $precio_unidad = 1;
                break;
                case "Ton_Corta": 
                $typep = "  [Ton. Corta]";
                $precio_unidad = 2;
                break;
              }
              $cotizaciones->producto = $producto;
              $cProducto = $cotizaciones->consultarProductosxID();

              foreach($cProducto as $row){
                $nombreProducto = $row['nombreProducto'];
                $presentacion = $row['presentacionProducto'];
                $distri = $row['iVentaDisProducto'];
                $distriM = $row['mVentaDisProducto'];
                $grower = $row['iVentaGrwProducto'];
                $growerM = $row['mVentaGrwProducto'];

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

                $cotizaciones->cliente = $cliente;
                $lista_clientes = $cotizaciones->consultarClientes();
                foreach($lista_clientes as $row){
                 $cliente_tipo = $row['tipoCliente'];
               }

								if($cliente_tipo == 1){ //IF TIPO DE CLIENTE 1
									if($precio_unidad == 1){ 
										$precio_unitario = $distriM;
									} 
									else{
										if($precio_unidad == 2){
											$precio_unitario = $distri;
										}
									}
								} // IF TIPO DE CLIENTE 1
								else{// ELSE DE TIPO DE CLIENTE 1
									if($cliente_tipo == 2){// IF DE TIPO DE CLIENTE 2
										if($precio_unidad == 1){
											$precio_unitario = $growerM;
										}
										else{
											if($precio_unidad == 2){
												$precio_unitario = $grower;
											}
										}
									}//IF DE TIPO DE CLIENTE 2
									else{//ELSE DE TIPO DE CLIENTE 2
										if($cliente_tipo==3){
											$cotizaciones->cliente = $cliente;
											$cotizaciones->producto = $producto;
											$lista_preciosespe = $cotizaciones->consultarPrecios();

											foreach($lista_preciosespe as $row){
												$precio1 = $row['iPrecioEspecial'];
												$precio2 = $row['mPrecioEspecial'];
											}

											if($precio_unidad == 1){
												$precio_unitario = $precio1;
											}
											else{
												if($precio_unidad == 2){
													$precio_unitario = $precio2;
												}
											}
										}
									}// EL DE TIPO DE CLIENTE 2
								}//ELSE DE TIPO DE CLIENTE 1

								?>
								<tr>
									<td><?php echo $nombreProducto.$pres;?></td>
									<td><?php echo number_format( $cantidad,2, '.', ',').$typep;?></td>
									<td><?php echo "$ ".number_format($precio_unitario,2, '.', ','); ?></td>
									<td><?php echo "$ ".number_format($monto,2, '.', ','); ?></td>
									<td>
										<?php 

										$cotizaciones->producto =$producto;
										$num_inventario = $cotizaciones->inventarioEsp();

										foreach($num_inventario as $row){
											$existencia = $row['SUM(existenciaInventario)'];
										}
										$binExistencia = 0;

										if(is_null($existencia)){
											$binExistencia = 1;
										}
										else{
											switch($unidad){
												case "Ton_Corta";
												break;
												case "Galones":
												$qty = $cantidad;
												break;

												case "Litros":
												$qty = $cantidad*0.26417205;
												break;

												case "Ton_Metrica": 
												$qty = $cantidad*1.1023;
												break;
											}
										}

										$faltante = $qty-$existencia;
										if($faltante>0){
											$binExistencia = 1;
										}


										$positive='<div class="text-center"><span class="badge badge-success badge-roundless"> &nbsp;Sí&nbsp; </span></div>';
										$negative='<div class="text-center"><span class="badge badge-danger badge-roundless"> No </span></div>';

										if($binExistencia==1){
											echo $negative;
										}
										else{
											echo $positive;
										}
										?>
									</td>
								</tr>
								<?php
							}
							$total_coti += $monto;
						}
						?>
						<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td><div class="text-right"><strong>Total:</strong></div></td>
							<td><div class="text-center"><?php echo  "$ ".number_format($total_coti,2, '.', ','); ?></div></td>
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
	<?
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE ACREEDORES #############################################
?>


<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
	$(document).ready(function(){

		$("#back_cat_coti").click(function(){
			window.location = ""
		});


		/* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
		$('.cancelar').click(function() {
			$("#mainContent").load( "conf_cancel.php?codigo="+$(this).val());
		});

		/* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
		$('#gotoCotiz').click(function() {
			$("#mainContent").load( "form_cotizaciones.php");
		});

		$('.imprimir').click(function() {
			window.open("reportes.php?codigo="+$(this).val(), "_blank");
		});

		$('#filtro').change(function() {
			var prueba = $("#select_month").val();
			$("#mainContent").load( "cat_cotizaciones.php?codigo="+$(this).val()+"&mes="+prueba);
		});

		$('#select_month').change(function() {
			var prueba = $("#filtro").val();

			$("#mainContent").load( "cat_cotizaciones.php?mes="+$(this).val()+"&codigo="+prueba);
		});
	});
</script><!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.js" type="text/javascript"></script>