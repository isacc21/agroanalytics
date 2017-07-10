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
require '../../../models/contabilidad/dolares/bancos.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$usdBancos = new usdBancos($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$listaBancos = $usdBancos->consultarEgresosUSD();


###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $usdBancos->consultarEgresosUSD();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $bancos = $row['bancosPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';
  $html_nuevo='
  <div class="col-md-6">
    <div class="btn-group">
      <button id="gotoUSD" class="btn sbold green"> 
        Nuevo <i class="fa fa-plus"></i>
      </button>
    </div>
  </div>';

  $ingresos = $usdBancos->consultarIngresosBancoUSD();
  $egresos = $usdBancos->consultarEgresosBancoUSD();

  foreach($ingresos as $row){
    $total_ingreso = $row['ingresos'];
  }

  foreach($egresos as $row){
    $total_egreso = $row['egresos'];
  }

  $balance = $total_ingreso - $total_egreso;

  $total = number_format($balance,2, '.', ',');

  if($balance<0){
    $color = "red-thunderbird";
  }
  else{
    $color="green-jungle";
  }
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

  $html_registrado='<span class="label label-sm label-success"> Registrado </span>';
  $html_pendiente='<span class="label label-sm label-warning"> Pendiente </span>';
  $html_cancelado='<span class="label label-sm label-danger"> Cancelado </span>';

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

       <!-- ICONO A DERECHA DE TITULO DE PORTLET-->
       <i class="icon-settings font-dark"></i>

       <!-- TEXTO DE TITULO DE PORTLET-->
       <span class="caption-subject bold uppercase"> Estado de Cuenta: Egresos</span>
     </div>
     <div class="actions">
      <div class="btn-group btn-group-devided" data-toggle="buttons">
        <?echo $html_filtros;?>
         <button type="button" name="back" id="back_cat_b5" class="btn btn-secondary-outline">
              <i class="fa fa-arrow-left"></i> Regresar
            </button>
      </div>
    </div>
    <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->
  </div>
  <!-- TERMINA TITULO DE PORTLET-->

  <!-- INICIA CUERPO DE PORTLET-->
  <div class="portlet-body">

    <!-- INICIA ENCABEZADO DE CUERPO DE PORTLET-->
    <div class="table-toolbar">

     <?php

     echo $html_inicio_head_dt; 
     if($bancos[1]=='2'){
      echo $html_nuevo;
    }
    if($bancos[0]=='1'){
      //echo $html_filtros;
      //echo $html_balance;
    }
    echo $html_final_head_dt; 
    ?>



  </div>
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
   <th> Operación </th>
   <th> Monto </th>
   <th> Detalle </th>
   <th> Estatus </th>
   <th> Acciones </th>
 </tr>
</thead>
<!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

<!-- INICIA CUERPO DE DATA TABLE-->
<tbody>

  <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
  <?php
  $listaBancos = $usdBancos->consultarEgresosUSD();
  foreach($listaBancos as $row){
   $codigo = $row['folioUSDBanco'];
   $dd = $row['ddUSDBanco'];
   $mm = $row['mmUSDBanco'];
   $yyyy = $row['yyyyUSDBanco'];
   $tipo = $row['tipoUSDBanco'];
   $monto = $row['montoUSDBanco'];
   $detalle = $row['detalleUSDBanco'];
   $status = $row['statusUSDBanco'];
   $hola ++;
   $num = number_format($monto,2, '.', ',');
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
  <td> <?php if($tipo==1){echo $html_ingreso;}else{echo $html_egreso;}?></td>
  <td> <?php echo '$ '.$num;?></td>
  <td> <?php echo $detalle; ?></td>
  <td>
    <?php 
    if($status==1){
      echo $html_registrado;
    }
    else{
      if($status==2){
        echo $html_cancelado;
      }
    }
    ?>
  </td>
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
  $html_editar='<li><a><input type="radio" id="editar'.$codigo.'" class="editar" name="editar" value="'.$codigo.'">
  <label for="editar'.$codigo.'">  <i class="fa fa-edit"></i>&nbsp;Modificar </label></a></li>';

  $html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
  <label for="cancelar'.$codigo.'">  <i class="fa fa-times-circle"></i>&nbsp;Cancelar </label></a></li>';


  if($bancos[0]=='1'||$bancos[1]=='2'||$bancos[2]=='3'||$bancos[3]=='4'){
    echo $html_inicio_action;
  }
  if($bancos[0]=='1'){
    echo $html_moreInfo; 
  }
  if($bancos[2]=='3'&&$status==1){
    echo $html_editar;
  }
  if($bancos[3]=='4'&&$status==1){
    echo $html_cancelar;
  }
  if($bancos[0]=='1'||$bancos[1]=='2'||$bancos[2]=='3'||$bancos[3]=='4'){
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
 $codigo = $row['folioUSDBanco'];
 $dd = $row['ddUSDBanco'];
 $mm = $row['mmUSDBanco'];
 $yyyy = $row['yyyyUSDBanco'];
 $referencia = $row['referenciaUSDBanco'];
 $tipo = $row['tipoUSDBanco'];
 $monto = $row['montoUSDBanco'];
 $detalle = $row['detalleUSDBanco'];
 $comentario = $row['comentarioUSDBanco'];
 $status = $row['statusUSDBanco'];
 $usuario = $row['idUsuario'];

 $num = number_format($monto,2, '.', ',');

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
       <td>Referencia: </td>
       <td><?php echo $referencia;?></td>
     </tr>

     <tr>
       <td>Número: </td>
       <td><?php if($tipo==1){echo "Ingreso";}else{echo "Egreso";}?></td>
     </tr>

     <tr>
      <td>Monto: </td>
      <td><?php echo "$ ".$num;?></td>
    </tr>

    <tr>
      <td>Detalle: </td>
      <td><?php echo $detalle;?></td>
    </tr>

    <tr>
      <td>Comentario: </td>
      <td><?php echo $comentario;?></td>
    </tr>

    <tr>
      <td>Estatus: </td>
      <td><?php 
        if($status==1){
          echo $html_registrado;
        }
        else{
          if($status==2){
            echo $html_cancelado;
          }
        }
        ?>

      </td>
    </tr>

    <tr>
      <td><?php if($status==1){echo "Última edición por:";}else{if($status==2){echo "Cancelado por:";}} ?> </td>
      <td><?php echo $nombreUser;?></td>
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
    $ingreso = number_format($total_ingreso,2, '.', ',');
    $egreso = number_format($total_egreso,2, '.', ',');
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


    $("#back_cat_b5").click(function(){
      window.location = ""
    });


    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#bank_cancel").click(function(){
      $("#mainContent").load( "cat_bancoD_cancel.php" );
    });

    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#bank_reg").click(function(){
      $("#mainContent").load( "cat_bancoD_reg.php" );
    });

    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#bank_all").click(function(){
      $("#mainContent").load( "cat_bancoD.php" );
    });

    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#bank_down").click(function(){
      $("#mainContent").load( "cat_bancoD_ing.php" );
    });

    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#bank_up").click(function(){
      $("#mainContent").load( "cat_bancoD_egr.php" );
    });


    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#gotoUSD").click(function(){
      $("#mainContent").load( "form_bancoD.php" );
    });


    /* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
    $('.editar').click(function() {
      $("#mainContent").load( "form_bancoD.php?codigo="+$(this).val());

    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.cancelar').click(function() {
      $("#mainContent").load( "conf_usd.php?codigo="+$(this).val());

    });
  });
</script>

<!--INICIAN SCRITPS PARA EL FUNCIONAMIENTO DE DATA TABLES-->
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="../../../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>

<!-- TERMINAN SCRIPTS PARA EL FUNCIONAMIENTO DE DATA TABLES-->