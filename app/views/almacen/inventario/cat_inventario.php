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
require '../../../models/almacen/inventario.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$inventario = new inventario($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$lista_existencia = $inventario->consultarExistencia();






###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $inventario->consultarExistencia();


###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $inventary = $row['inventarioPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  


  $html_registrado='<span class="label label-sm label-success"> Vigente </span>';
  $html_vencida='<span class="label label-sm label-warning"> Facturada </span>';
  $html_utilizada='<span class="label label-sm label-info"> Utilizada </span>';
  $html_cancelado='<span class="label label-sm label-danger"> Cancelada </span>';

  $html_ingreso='<span class="label label-sm label-success"> Ingreso </span>';
  $html_egreso='<span class="label label-sm label-danger"> Egreso </span>';

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

       <i class="fa fa-list-alt font-dark"></i>

       <!-- TEXTO DE TITULO DE PORTLET-->
       <span class="caption-subject bold uppercase"> Inventario en existencia</span>
     </div>
     <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

     <div class="actions btn-set">
       <button type="button" name="back" id="back_cat_inv" class="btn default green-stripe">
        <i class="fa fa-arrow-left"></i> Regresar
      </button>
    </div>
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
         <th> Producto </th>
         <th> Existencia </th>
         <th> Precio </th>
         <th> Peso </th>
         <th> Acciones </th>
       </tr>
     </thead>
     <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

     <!-- INICIA CUERPO DE DATA TABLE-->
     <tbody>

      <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
      <?php
      foreach($lista_existencia as $row){
       $codigo = $row['barCodeInventario'];
       $producto = $row['codigoProducto'];
       $existencia = $row['existenciaInventario'];
       ?>
       <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

       <!-- INICIA FILA CON VARIABLES DE FOREACH-->
       <tr class="odd gradeX">

        <td> <?php echo $codigo;?> </td>
        <?php
        $inventario->producto = $producto;
        $consultarProducto = $inventario->consultarProductosID();
        foreach($consultarProducto as $row){
          $nombre_producto = $row['nombreProducto'];
          $precio = $row['compraProducto'];
          $densidad = $row['densidadProducto'];
          $presentacion = $row['presentacionProducto'];

          switch($presentacion){
            case 1:
            $pres = " | Cubeta";
            $typep = " [GALS]";
            break;

            case 2:
            $pres = " | Tibor";
            $typep = " [GALS]";
            break;

            case 3:
            $pres = " | Tote";
            $typep = " [GALS]";
            break;

            case 4:
            $pres = " | Granel";
            $typep = " [GALS]";
            break;

            case 5:
            $pres = " | Saco";
            $typep = " [Ton. Corta]";
            break;

            case 6:
            $pres = " | Súper saco";
            $typep = " [Ton. Corta]";
            break;
          }
        }
        $total = $precio * $existencia;
        $num = number_format($total,2, '.', ',');

        $pt = number_format(($densidad * $existencia),2, '.', ',');
        ?>
        <td> <?php echo $nombre_producto.$pres; ?></td>
        <td> <?php echo $existencia.$typep; ?></td>
        <td> <?php echo '$ '.$num;?></td>
        <td> <?php echo $pt; ?> [LIBS]</td>

        <td>

         <!-- INICIAN BOTONES DE ACCIONES-->

         <?php

         $html_inicio_action='<div class="text-center"><div class="btn-group">
         <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 
          &nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
          &nbsp; Elegir&nbsp;&nbsp;
        </button><ul class="dropdown-menu pull-right" role="menu">';

        $html_final_action='</ul></div>';
        $html_moreInfo='<li>
        <a data-toggle="modal" href="#modal'.$codigo.'">
          <i class="icon-magnifier"></i> Ver info. </a>
        </li>';




        if($inventary[0]=='1'||$inventary[1]=='2'||$inventary[2]=='3'||$inventary[3]=='4'){
          echo $html_inicio_action;
        }
        if($inventary[0]=='1'){
          echo $html_moreInfo; 
        }
        if($inventary[0]=='1'||$inventary[1]=='2'||$inventary[2]=='3'||$inventary[3]=='4'){
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
 $codigo = $row['barCodeInventario'];
 $producto = $row['codigoProducto'];
 $existencia = $row['existenciaInventario'];
 $ddM = $row['ddManufactura'];
 $mmM = $row['mmManufactura'];
 $yyyyM = $row['yyyyManufactura'];
 $ddC = $row['ddCaducidad'];
 $mmC = $row['mmCaducidad'];
 $yyyyC = $row['yyyyCaducidad'];
 $lote = $row['loteInventario'];
 $num = number_format($precio,2, '.', ',');





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
       <td>Código de inventario: </td>
       <td><?php echo $codigo;?></td>
     </tr>

     <tr>
       <td>Producto: </td>
       <?php
       $inventario->producto = $producto;
       $consultarProducto = $inventario->consultarProductosID();
       foreach($consultarProducto as $row){
        $nombre_producto = $row['nombreProducto'];
        $precio = $row['compraProducto'];
        $densidad = $row['densidadProducto'];
        $presentacion = $row['presentacionProducto'];

        switch($presentacion){
          case 1:
          $pres = " | Cubeta";
          $typep = " [GALS]";
          break;

          case 2:
          $pres = " | Tibor";
          $typep = " [GALS]";
          break;

          case 3:
          $pres = " | Tote";
          $typep = " [GALS]";
          break;

          case 4:
          $pres = " | Granel";
          $typep = " [GALS]";
          break;

          case 5:
          $pres = " | Saco";
          $typep = " [Ton. Corta]";
          break;

          case 6:
          $pres = " | Súper saco";
          $typep = " [Ton. Corta]";
          break;
        }
      }
      $total = $precio * $existencia;
      $precio_total = number_format($total,2, '.', ',');
      $pt = number_format(($densidad * $existencia),2, '.', ',');
      ?>
      <td> <?php echo $nombre_producto.$pres; ?></td>
    </tr>

    <tr>
      <td>Existencia: </td>
      <td><?php echo $existencia.$typep;?></td>
    </tr>

    <tr>
      <td>Precio: </td>
      <td><?php echo "$ ".$precio_total;?></td>
    </tr>

    <tr>
     <td>Peso: </td>
     <td><?php echo $pt;?> [LIBS]</td>
   </tr>

   <tr>
     <td>Fecha de manufactura: </td>
     <td><?php echo $ddM."/".$mmM."/".$yyyyM;?></td>
   </tr>

   <tr>
     <td>Fecha de caducidad: </td>
     <td><?php echo $ddC."/".$mmC."/".$yyyyC;?></td>
   </tr>

   <tr>
     <td>Lote de manufactura: </td>
     <td><?php echo $lote;?></td>
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
    $("#back_cat_inv").click(function(){
      window.location = ""
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.cancelar').click(function() {
      $("#mainContent").load( "conf_cancel.php?codigo="+$(this).val());
    });

    $('.factura').click(function() {
      $("#mainContent").load( "agr_factura.php?codigo="+$(this).val());
    });

    $('#gotoCompras').click(function() {
      $("#mainContent").load( "form_ocompras.php");
    });
  });
</script>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.js" type="text/javascript"></script>