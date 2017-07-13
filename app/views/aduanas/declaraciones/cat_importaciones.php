<?php



###### DEFINICION DE ZONA HORARIO ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/aduanas/importaciones.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$importaciones = new importaciones($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$listaImportaciones = $importaciones->consultarImportacionesNV();






###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $importaciones->consultarImportaciones();
$consultarProductos = $importaciones->consultarImportaciones();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $declaracion = $row['declaracionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';
  $html_nuevo='
  <div class="col-md-6">
  	<div class="btn-group">
  		<button id="gotoDeclaracion" class="btn sbold green"> 
  			Nuevo <i class="fa fa-plus"></i>
  		</button>
  	</div>
  </div>';


  $html_finalizada='<span class="label label-sm label-success"> Finalizada </span>';
  $html_camino='<span class="label label-sm label-warning"> En camino </span>';
  $html_cancelado='<span class="label label-sm label-danger"> Cancelada </span>';

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
       <i class="icon-settings font-dark"></i>

       <!-- TEXTO DE TITULO DE PORTLET-->
       <span class="caption-subject bold uppercase"> Importaciones</span>
     </div>
     <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

     <div class="actions btn-set">
      <button type="button" name="back" id="back_cat_impord" class="btn btn-secondary-outline">
        <i class="fa fa-arrow-left"></i> Regresar
      </button>
    </div>
  </div>
  <!-- TERMINA TITULO DE PORTLET-->

  <!-- INICIA CUERPO DE PORTLET-->
  <div class="portlet-body">
  <!-- TERMINA ENCABEZADO DE CUERPO DE PORTLET-->

  <!-- INICIA DATA TABLE PARA CATALOGO DE ACREEDORES-->
  <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">

   <!-- INICIAN ENCABEZADOS PARA DATATALBE -->
   <thead>
    <tr>
     <th>
      <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
       <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
       <span></span>
     </label>
   </th>
   <th> Código </th>
   <th> Fecha [AAAA/MM/DD] </th>
   <th> Total </th>
   <th> Acciones </th>
 </tr>
</thead>
<!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

<!-- INICIA CUERPO DE DATA TABLE-->
<tbody>

  <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
  <?php
  foreach($listaImportaciones as $row){
   $codigo = $row['folioImportacion'];
   $dd = $row['ddImportacion'];
   $mm = $row['mmImportacion'];
   $yyyy = $row['yyyyImportacion'];
   $total = $row['costoImportacion'];
   $status = $row['statusImportacion'];
   $num = number_format($total,2, '.', ',');
   ?>
   <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

   <!-- INICIA FILA CON VARIABLES DE FOREACH-->
   <tr class="odd gradeX">
    <td>
     <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
      <input type="checkbox" class="checkboxes" value="1" />
      <span></span>
    </label>
  </td>

  <td> <?php echo $codigo;?> </td>
  <td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>

  <td> <?php echo '$ '.$num;?></td>
  
  <td>

   <!-- INICIAN BOTONES DE ACCIONES-->

   <?php

   $html_inicio_action='<div class="btn-group">
   <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
    <i class="fa fa-angle-down"></i>
  </button><ul class="dropdown-menu pull-right" role="menu">';

  $html_final_action='</ul></div>';
  $html_moreInfo='<li>
  <a data-toggle="modal" href="#modal'.$codigo.'">
    <i class="icon-magnifier"></i> Ver info. </a>
  </li>';

  $html_productos='<li>
  <a data-toggle="modal" href="#productos'.$codigo.'">
    <i class="icon-magnifier"></i> Productos </a>
  </li>';
  $html_utilizar='<li><a><input type="radio" id="usar'.$codigo.'" class="usar" name="usar" value="'.$codigo.'">
  <label for="usar'.$codigo.'" ">  <i class="fa fa-paperclip"></i>&nbsp;Utilizar </label></a></li>';





  if($declaracion[0]=='1'||$declaracion[1]=='2'||$declaracion[2]=='3'||$declaracion[3]=='4'){
    echo $html_inicio_action;
  }
  if($declaracion[0]=='1'){
    echo $html_moreInfo; 
    echo $html_productos;
  }
  if($declaracion[2]=='3'&&$status==1){
    echo $html_utilizar;
  }
  if($declaracion[3]=='4'&&$status==1){

  }
  if($declaracion[0]=='1'||$declaracion[1]=='2'||$declaracion[2]=='3'||$declaracion[3]=='4'){
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
 $codigo = $row['folioImportacion'];
 $dd = $row['ddImportacion'];
 $mm = $row['mmImportacion'];
 $yyyy = $row['yyyyImportacion'];
 $usuario = $row['idUsuario'];
 $pedimento = $row['folioPedimentoImportacion'];
 $entrada = $row['tipoEntradaImportacion'];
 $num = number_format($total,2, '.', ',');
 $mensaje ="";

 $usuarios->id=$usuario;
 $cnombres = $usuarios->consultarUsuariosID();

 foreach ($cnombres as $row){
  $nombreUser = $row['nombreUsuario'];
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
            echo "Cancelado por:";
          }
        }
        ?> </td>
        <td><?php echo $nombreUser;?></td>

      </tr>
      <?php 
      if($pedimento!=NULL){
        echo '<tr><td>No. Pedimento</td><td>'.$pedimento.'</td></tr>';
      }

      if($entrada != 0){
        if($entrada == 1){
          $mensaje = "Definitiva";
        }
        else{
          if($entrada == 2){
            $mensaje = "Express";
          }        
        }
        echo '<tr><td>Tipo de entrada</td><td>'.$mensaje.'</td></tr>';
      }?>
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
 $codigo = $row['folioImportacion'];




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
       </tr>
       <?php 
       $total_coti = 0;
       $importaciones->folio = $codigo;
       $ordenes = $importaciones->consultarOrdenesxImportacion();

       foreach($ordenes as $row){
        $odcompra = $row['folioOrdenCompra'];
        
        $importaciones->odc = $odcompra;
        $rel_productos = $importaciones->consultarProductosODC();

        foreach($rel_productos as $row){
          $producto = $row['codigoProducto'];
          $cantidad = $row['cantidadOrdenCompra'];
          $monto = $row['montoOrdenCompra'];

          $importaciones->producto = $producto;
          $cProductos = $importaciones->catalogoProductos();
          foreach($cProductos as $row){
            $nombreProducto = $row['nombreProducto'];

            ?>
            <tr>
              <td><?php echo $nombreProducto;?></td>
              <td><?php echo number_format( $cantidad,2, '.', ',');?></td>
              <td><?php echo "$ ".number_format(($monto / $cantidad),2, '.', ','); ?></td>
              <td><?php echo "$ ".number_format($monto,2, '.', ','); ?></td>
            </tr>
            <?php
          }
          $total_coti += $monto;
        }
      }
      ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><strong>Total</strong></td>
        <td><?php echo  "$ ".number_format($total_coti,2, '.', ','); ?></td>
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

    $("#back_cat_impord").click(function(){
      window.location = ""
    });
    //SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION
    $('.usar').click(function() {
      $("#mainContent").load( "form_declaracion.php?codigo="+$(this).val());
    });

    $('#gotoImportacion').click(function() {
      $("#mainContent").load( "form_declaracion.php");
    });
  });
</script>

<!--INICIAN SCRITPS PARA EL FUNCIONAMIENTO DE DATA TABLES-->
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>

<!-- TERMINAN SCRIPTS PARA EL FUNCIONAMIENTO DE DATA TABLES-->