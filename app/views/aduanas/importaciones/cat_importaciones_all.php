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
require '../../../models/aduanas/importaciones.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$importaciones = new importaciones($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$listaImportaciones = $importaciones->consultarImportaciones_all();

###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $importaciones->consultarImportaciones_all();


###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $importacion = $row['importacionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';
  $html_nuevo='
  <div class="col-md-6">
  	<div class="btn-group">
  		<button id="gotoImportacion" class="btn sbold green"> 
  			Nuevo <i class="fa fa-plus"></i>
  		</button>
  	</div>
  </div>';


  $html_finalizada='<div class="text-center"><span class="label label-sm label-default"> Finalizada </span></div>';
  $html_camino='<div class="text-center"><span class="label label-sm label-warning"> En camino </span></div>';
  $html_cancelado='<div class="text-center"><span class="label label-sm label-danger"> Cancelada </span></div>';
  $html_usado='<div class="text-center"><span class="label label-sm label-info"> Espera pedimento </span></div>';

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
    <div class="portlet box grey-steel">

     <!-- INICIA TITULO DE PORTLET-->
     <div class="portlet-title">

      <!-- TEXTO DE TITULO DE PORTLET-->
      <div class="caption"><div class="font-grey-mint"><b>Historial</b></div></div>
      <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

      <div class="actions btn-set">
        <button type="button" name="back" id="back_cat_import" class="btn green-seagreen">
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
         <th> Fecha [AAAA/MM/DD] </th>
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
        <td> <?php echo $codigo;?> </td>
        <td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>

        <td> <?php echo '$ '.$num;?></td>
        <td>
          <?php 
          if($status==1){
            echo $html_camino;
          }
          else{
            if($status==2){
              echo $html_finalizada;
            }
            else{
              if($status==3){
                echo $html_cancelado;
              }
              else{
                if($status==4){
                  echo $html_usado;
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

        $html_final_action='</ul></div>';
        $html_moreInfo='<li>
        <a data-toggle="modal" href="#modal'.$codigo.'">
          <i class="icon-magnifier"></i> Ver info.<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></a>
        </li>';

        $html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
        <label for="cancelar'.$codigo.'" ">  <i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Cancelar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

        $html_pedimento='<li><a><input type="radio" id="pedimento'.$codigo.'" class="pedimento" name="pedimento" value="'.$codigo.'">
        <label for="pedimento'.$codigo.'" ">  <i class="fa fa-paperclip"></i>&nbsp;Agregar pedimento<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

        $html_imprimir='<li><a><input type="radio" id="imprimir'.$codigo.'" class="imprimir" name="imprimir" value="'.$codigo.'">
        <label for="imprimir'.$codigo.'" ">  <i class="fa fa-print"></i>&nbsp;Imprimir<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

        if($importacion[0]=='1'||$importacion[1]=='2'||$importacion[2]=='3'||$importacion[3]=='4'){
          echo $html_inicio_action;
        }
        if($importacion[0]=='1'){
          echo $html_moreInfo; 
          echo $html_imprimir;
        }
        if($importacion[2]=='3'&&$status==1){
          echo $html_factura;
        }
        if($importacion[3]=='4'&&$status==1){
          echo $html_cancelar;
        }
        if($importacion[2]=='3'&&$status==4){
          echo $html_pedimento;
        }
        if($importacion[0]=='1'||$importacion[1]=='2'||$importacion[2]=='3'||$importacion[3]=='4'){
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
<div class="modal fade bs-modal-lg" id="modal<?=$codigo;?>" tabindex="-1" role="basic" aria-hidden="true">

  <!-- INICIO DE VENTANA MODAL -->
  <div class="modal-dialog modal-lg">

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
       <td><?php echo "Última edición por:"; ?> </td>
       <td><?php echo $nombreUser;?></td>
       <?php

       $importaciones->folio = $codigo;
       $lista_odecompras = $importaciones->consultarOrdenesxImportacion();
       $x=0;
       foreach($lista_odecompras as $row){
        $x++;
        echo "<tr><td>Orden de Compra #".$x.":</td><td>".$row['folioOrdenCompra']."</td></tr>";
      }
      ?>

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



  <?php
  $importaciones->folio = $codigo;
  $consultarProductos = $importaciones->consultarImportacionesxID();

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
  foreach($consultarProductos as $row){
   $codigo = $row['folioImportacion'];

   ?>

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
          $presentacion = $row['presentacionProducto'];
          $precio_unitario = $row['compraProducto'];

          switch($presentacion){
            case 1:
            $pres = " | Cubeta";
            $typep = " [GAL]";
            break;
            case 2:
            $pres = " | Tibor";
            $typep = " [GAL]";
            break;
            case 3:
            $pres = " | Tote";
            $typep = " [GAL]";
            break;
            case 4:
            $pres = " | Granel";
            $typep = " [GAL]";
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

          ?>
          <tr>
            <td><?php echo $nombreProducto.$pres;?></td>
            <td><?php echo number_format( $cantidad,2, '.', ',').$typep;?></td>
            <td><?php echo "$ ".number_format($precio_unitario,2, '.', ','); ?></td>
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
}
?>





<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
	$(document).ready(function(){

    $("#back_cat_import").click(function(){
      window.location = ""
    });

    $("#goto_daduanas").click(function(){
      window.location = "../declaraciones";
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.cancelar').click(function() {
      $("#mainContent").load( "conf_cancel.php?codigo="+$(this).val());
    });

    /*$('.factura').click(function() {
      $("#mainContent").load( "agr_factura.php?codigo="+$(this).val());
    });*/

    $('.pedimento').click(function() {
      $("#mainContent").load( "agr_pedimento.php?codigo="+$(this).val());
    });

    $('#gotoImportacion').click(function() {
      $("#mainContent").load( "form_importaciones.php");
    });

    $('.imprimir').click(function() {
      window.open("importacion.php?codigo="+$(this).val(), "_blank");
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
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>