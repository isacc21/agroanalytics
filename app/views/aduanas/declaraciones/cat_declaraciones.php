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
require '../../../models/aduanas/declaraciones.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$declaraciones = new declaraciones($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$lista_declaraciones = $declaraciones->consultarDeclaraciones();






###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $declaraciones->consultarDeclaraciones();


###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $declaracion = $row['declaracionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';



  $html_finalizada='<span class="label label-sm label-success"> Finalizada </span>';
  $html_camino='<div class="text-center"><span class="label label-sm label-success"> Declarada </span></div>';
  $html_cancelado='<span class="label label-sm label-danger"> Declarado </span>';
  $html_usado='<span class="label label-sm label-info"> Espera pedimento </span>';

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

       <div class="caption"><div class="font-grey-mint"><b>Catálogo</b></div></div>

       <div class="actions btn-set">
         <button type="button" name="back" id="back_cat_decl" class="btn green-seagreen">
          <i class="fa fa-arrow-left"></i>&nbsp;Regresar
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
         <th> Peso Total </th>
         <th> Estatus </th>
         <th> Acciones </th>
       </tr>
     </thead>
     <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

     <!-- INICIA CUERPO DE DATA TABLE-->
     <tbody>

      <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
      <?php
      foreach($lista_declaraciones as $row){
       $codigo = $row['folioDeclaracion'];
       $dd = $row['ddDeclaracion'];
       $mm = $row['mmDeclaracion'];
       $yyyy = $row['yyyyDeclaracion'];
       $total = $row['pesoTotalDeclaracion'];
       $status = $row['statusDeclaracion'];
       $num = number_format($total,2, '.', ',');
       ?>
       <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

       <!-- INICIA FILA CON VARIABLES DE FOREACH-->
       <tr class="odd gradeX">

        <td> <?php echo $codigo;?> </td>
        <td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>

        <td> <?php echo $num;?> [LIBRAS]</td>
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
        $html_imprimir='<li><a><input type="radio" id="imprimir'.$codigo.'" class="imprimir" name="imprimir" value="'.$codigo.'">
        <label for="imprimir'.$codigo.'" ">  <i class="fa fa-print"></i>&nbsp;Imprimir<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';



        if($declaracion[0]=='1'||$declaracion[1]=='2'||$declaracion[2]=='3'||$declaracion[3]=='4'){
          echo $html_inicio_action;
        }
        if($declaracion[0]=='1'){
          echo $html_moreInfo; 
          echo $html_imprimir;
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
  $codigo = $row['folioDeclaracion'];
  $importacion = $row['folioImportacion'];
  $transportista = $row['rfcTransportista'];
  $dd = $row['ddDeclaracion'];
  $mm = $row['mmDeclaracion'];
  $yyyy = $row['yyyyDeclaracion'];
  $tipo = $row['tipoTransporte'];
  $placasmx = $row['placasMXDeclaracion'];
  $placasus = $row['placasUSDeclaracion'];
  $noeco = $row['noEcoTractoDeclaracion'];
  $placasxtra = $row['placasXtraDeclaracion'];
  $noecoxtra = $row['noEcoXtraDeclaracion'];
  $peso = $row['pesoTotalDeclaracion'];
  $usuario = $row['idUsuario'];

  $declaraciones->transportista = $transportista;
  $result = $declaraciones->consultarTransportistaxID();
  foreach($result as $row){
    $nombre_transp = $row['razonSocTransportista'];
  }


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
         <td>Folio importación:</td>
         <td><?php echo $importacion; ?></td>
       </tr>
       <tr>
         <td>Transportista:</td>
         <td><?php echo $nombre_transp; ?></td>
       </tr>
       <tr>
         <td>Tipo de transporte:</td>
         <?php 
         switch($tipo){
          case 1:
          $transporte = "Tanque";
          break;
          case 2:
          $transporte = "Plataforma";
          break;
          case 3:
          $transporte = "Rabón";
          break;
        } 
        ?>

        <td><?php echo $transporte; ?></td>
      </tr>
      <tr>
       <td>Placas MX Tractocamión:</td>
       <td><?php echo $placasmx; ?></td>
     </tr>
     <tr>
       <td>Placas US Tractocamión:</td>
       <td><?php echo $placasus; ?></td>
     </tr>
     <tr>
       <td>No. económico Tractocamión:</td>
       <td><?php echo $noeco; ?></td>
     </tr>
     <?php 
     if($tipo!=3){
      ?>
      <tr>
        <td>Placas <?php echo $transporte; ?>:</td>
        <td><?php echo $placasxtra; ?></td>
      </tr>
      <tr>
        <td>No. económico <?php echo $transporte; ?>:</td>
        <td><?php echo $noecoxtra; ?></td>
      </tr>
      <?php
    }
    ?>
    <tr>
      <td>Peso total:</td>
      <td><?php echo $peso; ?> [LIBRAS]</td>
    </tr>
    <tr>
      <td>Realizada por: </td>
      <td><?php echo $nombreUser; ?></td>
    </tr>
    <?php 
    $declaraciones->importacion = $importacion;
    $lista_facturas = $declaraciones->consultaodcs();
    $x=0;
    foreach($lista_facturas as $row){
      $x++;
      echo "<tr><td>Factura #".$x.":</td><td>".$row['folioFactura']."</td></tr>";
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

<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
	$(document).ready(function(){

    $("#back_cat_decl").click(function(){
      window.location = ""
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.cancelar').click(function() {
      $("#mainContent").load( "conf_cancel.php?codigo="+$(this).val());
    });

    
    $('.imprimir').click(function() {
      window.open("hdi.php?codigo="+$(this).val(), "_blank");
    });

    $('.pedimento').click(function() {
      $("#mainContent").load( "agr_pedimento.php?codigo="+$(this).val());
    });

    $('#gotoImportacion').click(function() {
      $("#mainContent").load( "form_importaciones.php");
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