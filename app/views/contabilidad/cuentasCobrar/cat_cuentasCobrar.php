<?php
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
	include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
	require '../../../models/contabilidad/cuentasCobrar.php';
	require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
	$cuentasCobrar = new cuentasCobrar($datosConexionBD);
	$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################

	$cuentasCobrar->moneda = $_REQUEST['moneda'];
	$lista_cxc = $cuentasCobrar->cuentasCobrarxMoneda();


###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################

	$cuentasCobrar->moneda = $_REQUEST['moneda'];
	$consultaModal = $cuentasCobrar->cuentasCobrarxMoneda();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
	$usuarios->id=$_SESSION['idUsuario'];

	$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
	foreach ($result as $row){
		$cxc = $row['cxcPermiso'];
  }## LLAVE DE FOREACH ###############################################################
  $html_pendiente='<div class="text-center"><span class="label label-sm label-warning"> Pendiente a pago </span></div>';
  $html_pagada='<div class="text-center"><span class="label label-sm label-default"> Saldada </span></div>';
  $html_vencida='<div class="text-center"><span class="label label-sm label-danger"> Vencida </span></div>';
  $html_cancelada='<div class="text-center"><span class="label label-sm label-danger"> Cancelada </span></div>';


  $html_pendiente_left='<div class="text-left"><span class="label label-sm label-warning"> Pendiente a pago </span></div>';
  $html_pagada_left='<div class="text-left"><span class="label label-sm label-default"> Saldada </span></div>';
  $html_vencida_left='<div class="text-left"><span class="label label-sm label-danger"> Vencida </span></div>';
  $html_cancelada_left='<div class="text-left"><span class="label label-sm label-danger"> Cancelada </span></div>';


  $html_nuevo='<button id="gotoCXC" class="btn green-seagreen"><i class="fa fa-plus"></i>&nbsp;Nuevo</button>';
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

    <div class="caption"><div class="font-grey-mint"> <b>Catálogo <?php if($_REQUEST['moneda']==1){echo 'dólares';}else{echo 'pesos';} ?></b> </div>

  </div>
  <div class="actions btn-set">
    <?php 
    if($cxc[1]=='2'){
     echo $html_nuevo;
   } ?>
   <button type="button" name="back" id="rep_cxc" class="btn green-seagreen">
    <i class="fa fa-print"></i> Reporte
  </button>
  <button type="button" name="back" id="back_cat_acre" class="btn green-seagreen">
   <i class="fa fa-arrow-left"></i>&nbsp;Regresar
 </button>


</div>

</div>
<div class="portlet-body">

 <!-- TERMINA ENCABEZADO DE CUERPO DE PORTLET-->
 <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
  <thead>
   <tr>
    <th> Fecha <small>[AAAA/MM/DD]</small> </th>
    <th> Cliente </th>
    <th> Factura </th>
    <th> Monto</th>
    <th> Estatus </th>
    <th> Acciones </th>
  </tr>
</thead>
<tbody>

 <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
 <?php
 foreach($lista_cxc as $row){
  $folio = $row['folioCuentaC'];
  $fecha = $row['yyyyCuentaC']."/".$row['mmCuentaC']."/".$row['ddCuentaC'];
  $rfc = $row['rfcCliente'];
  $factura = $row['folioFactura'];
  $remision = $row['remisionFactura'];
  $monto = $row['importeCuentaC'];
  $comentario = $row['comentarioCuentaC'];
  $status = $row['statusCuentaC'];


  $monto_cf = number_format($monto,2, '.', ',');

  $balance_cf = number_format($balance,2, '.', ',');

  $cuentasCobrar->cliente = $rfc;
  $cliente = $cuentasCobrar->consultarClientesxID();
  foreach($cliente as $row){
   $nombre_cliente = $row['razonSocCliente'];
 }
 ?>
 <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

 <!-- INICIA FILA CON VARIABLES DE FOREACH-->
 <tr class="odd gradeX">
   <td><?php echo $fecha; ?></td>
   <td><?php echo $nombre_cliente; ?></td>
   <td><?php echo $factura; ?></td>
   <td><?php echo "$ ".$monto_cf; ?></td>
   <td><?php 
   switch($status){
     case 1:
     echo $html_pendiente;
     break;
     case 2: 
     echo $html_pagada;
     break;
     case 3: 
     echo $html_vencida;
     break;
     case 4:
     echo $html_cancelada;
     break;
   } ?></td>
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

     $html_cancelar='<li><a><input type="radio" id="cancelar'.$folio.'" class="cancelar" name="cancelar" value="'.$folio.'">
     <label for="cancelar'.$folio.'" ">  <i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Cancelar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

     $html_saldar='<li><a><input type="radio" id="saldar'.$folio.'" class="saldar" name="saldar" value="'.$folio.'">
     <label for="saldar'.$folio.'" ">  <i class="glyphicon glyphicon-ok-circle"></i>&nbsp;Saldar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';


     if($cxc[0]=='1'||$cxc[1]=='2'||$cxc[2]=='3'||$cxc[3]=='4'){
      echo $html_inicio_actions;
    }
    if($cxc[0]=='1'){
      echo $html_moreInfo; 
    }
    if($cxc[2]=='3'&&$status==1){
      echo $html_editar;
    }
    if($cxc[3]=='4'&&$status==1||$status==3){
      echo $html_saldar;
      echo $html_cancelar;
    }

    if($cxc[0]=='1'||$cxc[1]=='2'||$cxc[2]=='3'||$cxc[3]=='4'){
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
 $folio = $row['folioCuentaC'];
 $fecha = $row['yyyyCuentaC']."/".$row['mmCuentaC']."/".$row['ddCuentaC'];
 $rfc = $row['rfcCliente'];
 $factura = $row['folioFactura'];
 $remision = $row['remisionFactura'];
 $monto = $row['importeCuentaC'];
 $comentario = $row['comentarioCuentaC'];
 $status = $row['statusCuentaC'];
 $usuario = $row['idUsuario'];

 $monto_cf = number_format($monto,2, '.', ',');

 $usuarios->id=$usuario;
 $cnombres = $usuarios->consultarUsuariosID();

 foreach ($cnombres as $row){
  $nombreUser = $row['nombreUsuario']." ".$row['apellidosUsuario'];
}

$cuentasCobrar->cliente = $rfc;
$cliente = $cuentasCobrar->consultarClientesxID();
foreach($cliente as $row){
  $nombre_cliente = $row['razonSocCliente'];
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
       <td>Cliente: </td>
       <td><?php echo $nombre_cliente;?></td>
     </tr>
     <tr>
       <td>Factura:</td>
       <td><?php echo $factura;?></td>
     </tr>
     <tr>
      <?php if($remision != 'null'){
        echo '<td>Remisión: </td><td>'.$remision.'</td>';
      } ?>

    </tr>

    <tr>
     <td>Monto: </td>
     <td><?php echo "$ ".$monto_cf;;?></td>
   </tr>

   <tr>
     <td>Comentario: </td>
     <td><?php echo $comentario;?></td>
   </tr>

   <tr>
     <td>Estatus:</td>
     <td><?php 
     switch($status){
       case 1:
       echo $html_pendiente_left;
       break;
       case 2: 
       echo $html_pagada_left;
       break;
       case 3: 
       echo $html_vencida_left;
       break;
       case 4:
       echo $html_cancelada_left;
       break;
     } ?></td>
   </tr>

   <tr>
    <td><?php if($status!=4){echo 'Última modificación por:';}else{echo 'Cancelada por';} ?></td>
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

<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
	$(document).ready(function(){

		$("#back_cat_acre").click(function(){
			window.location = "";
		});

		/* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
		$("#gotoCXC").click(function(){
			$("#mainContent").load( "form_cuentasCobrar.php?moneda="+<?=$_REQUEST['moneda'];?> );
		});


		/* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
		$('.editar').click(function() {
			$("#mainContent").load( "form_cuentasCobrar.php?folio="+$(this).val()+"&moneda="+<?=$_REQUEST['moneda'];?> );

		});

		$('.saldar').click(function() {
			$("#mainContent").load( "form_saldar.php?folio="+$(this).val()+"&moneda="+<?=$_REQUEST['moneda'];?>);
		});

		$('.cancelar').click(function() {
			$("#mainContent").load( "form_cancelar.php?folio="+$(this).val()+"&moneda="+<?=$_REQUEST['moneda'];?>);
		});


    $('#rep_cxc').click(function() {
      window.open("cuentas_cobrar.php", "_blank");
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