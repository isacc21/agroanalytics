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
$listaCotizaciones = $cotizaciones->consultarVigentes();




###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $cotizaciones->consultarVigentes();
$consultarProductos = $cotizaciones->consultarVigentes();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $pCotizacion = $row['cotizacionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';
  $html_nuevo='
  <div class="col-md-6">
  	<div class="btn-group">
  		<button id="gotoCotiz" class="btn sbold green"> 
  			Nuevo <i class="fa fa-plus"></i>
  		</button>
  	</div>
  </div>';


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

  $html_registrado='<span class="label label-sm label-success"> Vigente </span>';
  $html_vencida='<span class="label label-sm label-warning"> Vencida </span>';
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
    <div class="portlet box grey-steel">

     <!-- INICIA TITULO DE PORTLET-->
     <div class="portlet-title">
      <div class="caption"><div class="font-grey-mint"> <b>Cotizaciones disponibles</b> </div> </div>
      <div class="actions btn-set">
        <button type="button" name="back" id="back_cat_cotd" class="btn green-seagreen">
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
         <th> Cliente </th>
         <th> Total </th>
         <th> Acciones </th>
       </tr>
     </thead>
     <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

     <!-- INICIA CUERPO DE DATA TABLE-->
     <tbody>

      <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
      <?php
      foreach($listaCotizaciones as $row){
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

        $html_usar='<li><a><input type="radio" id="usar'.$codigo.'" class="usar" name="usar" value="'.$codigo.'">
        <label for="usar'.$codigo.'" ">  <i class="icon-paper-clip"></i>&nbsp;Procesar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';



        if($pCotizacion[0]=='1'||$pCotizacion[1]=='2'||$pCotizacion[2]=='3'||$pCotizacion[3]=='4'){
          echo $html_inicio_action;
        }
        if($pCotizacion[0]=='1'){
          echo $html_moreInfo; 
          echo $html_imprimir;
        }
        if($pCotizacion[1]=='2'){
          echo $html_usar;
        }
        if($pCotizacion[2]=='3'&&$status==1){
    //echo $html_editar;
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

$cotizaciones->cliente = $cliente;
$consultaClientes = $cotizaciones->consultarClientes();
foreach($consultaClientes as $row){
 $name_cliente = $row['razonSocCliente'];
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
       <td>Cliente: </td>
       <td><?php echo $name_cliente;?></td>
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
<?php 
$cotizaciones->folio = $codigo;
$consultarProductos = $cotizaciones->consultarCotizacionesxID();
foreach($consultarProductos as $row){
  $codigo = $row['folioCotizacion'];
  $cliente = $row['rfcCliente'];
  $status = $row['statusCotizacion'];

  ?>
  <table class="table table-hover">
    <tr>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Monto</th>
      <?php 
      if($binExistencia == 0 && $status != 4&&$status != 3){
       ?>
       <th>En existencia</th>
       <?php 
     } 
     ?>
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
    $nombreProducto = $row['nombreProducto'];
    $presentacion = $row['presentacionProducto'];
    $tipo_cliente = $row['tipoCliente'];
    $rfc = $row['rfcCliente'];

    if($tipo_cliente == 2){
      $cotizaciones->producto=$producto;
      $cotizaciones->cliente = $rfc;
      $result_clientes = $cotizaciones->consultarPrecios();
      foreach($result_clientes as $row){
        $precio_ingles = $row['iPrecioEspecial'];
        $precio_metrico = $row['mPrecioEspecial'];
      }
    }
    else{
      if($tipo_cliente == 1){
        $precio_ingles = $row['iVentaDisProducto'];
        $precio_metrico = $row['iVentaGrwProducto'];
      }
      else{
        if($tipo_cliente == 3){
         $precio_ingles = $row['mVentaDisProducto'];
         $precio_metrico = $row['mVentaGrwProducto'];
       }
     }
   }

   switch($unidad){
    case 'Galones':
    $typep = '[GAL]';
    $precio_usar = $precio_ingles;
    break;
    case 'Ton_Corta':
    $typep = '[TON.CORTA]';
    $precio_usar = $precio_ingles;
    break;
    case 'Litros':
    $typep = '[LIT]';
    $precio_usar = $precio_metrico;
    break;
    case 'Ton_Metrica':
    $typep = '[TON.MET]';
    $precio_usar = $precio_metrico;
    break;
   }

   switch($presentacion){
    case 1:
    $pres = ' | Cubeta';
    break;
    case 2:
    $pres = ' | Tibor';
    break;
    case 3:
    $pres = ' | Tote';
    break;
    case 2:
    $pres = ' | Granel';
    break;
    case 5:
    $pres = ' | Saco';
    break;
    case 6:
    $pres = ' | S.Saco';
    break;
   }

   ?>
   <tr>
    <td><?php echo $nombreProducto.$pres;?></td>
    <td><?php echo number_format( $cantidad,2, '.', ',').$typep;?></td>
    <td><?php echo "$ ".number_format($precio_usar,2, '.', ','); ?></td>
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

      if($binExistencia==1&&$status != 4&&$status != 3){
        echo $negative;
      }
      else{
        if($binExistencia == 0 && $status != 4&&$status != 3){
          echo $positive;  
        }
        else{
          echo '';
        }

      }
      ?>
    </td>
  </tr>
  <?php

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

<?
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE ACREEDORES #############################################
?>

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

    $("#back_cat_cotd").click(function(){
      window.location = ""
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
   /* $('.usar').click(function() {
      $("#mainContent").load( "conf_uCotizacion.php?codigo="+$(this).val());
    });*/


    $(".usar").click(function(){

      var cotizacionActual = $(this).val();

      swal({
        title: "Procesar cotización "+cotizacionActual,
        text: "¿Que acción desea realizar?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Procesar",
        cancelButtonText: "Editar",
        closeOnConfirm: true,
        closeOnCancel: true
      },
      function(isConfirm){
        if (isConfirm) {
          $("#mainContent").load( "conf_uCotizacion.php?codigo="+cotizacionActual);
        } else {
          $("#mainContent").load( "form_pedidos.php?codigo="+cotizacionActual);
        }
      });
    });

    $('#filtro').change(function() {
      var prueba = $("#select_month").val();
      $("#mainContent").load( "cat_cotizaciones.php?codigo="+$(this).val()+"&mes="+prueba);
    });

    $('.imprimir').click(function() {
      window.open("cotizacion.php?codigo="+$(this).val(), "_blank");
    });

    $('#select_month').change(function() {
      var prueba = $("#filtro").val();

      $("#mainContent").load( "cat_cotizaciones.php?mes="+$(this).val()+"&codigo="+prueba);


    });
  });
</script>
<script src="../../../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>

<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>