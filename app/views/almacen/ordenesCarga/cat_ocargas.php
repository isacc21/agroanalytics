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
require '../../../models/almacen/ordenesCarga.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$ordenesCarga = new ordenesCarga($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$lista_cargas = $ordenesCarga->consultarCargas();




###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $ordenesCarga->consultarCargas();


###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $carga = $row['cargaPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  

  $html_registrado='<div class="text-center"><span class="label label-sm label-warning"> Esperando remisión </span></div>';
  $html_utilizada='<div class="text-center"><span class="label label-sm label-default"> Utilizada </span></div>';
  $html_cancelado='<div class="text-center"><span class="label label-sm label-danger"> Cancelada </span></div>';

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

      <!-- INICIAN ESTILOS PARA TITULO DE PORTLET-->
      <div class="caption"><div class="font-grey-mint"><b>Catálogo</b></div></div>
      <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

      <div class="actions btn-set">
        <button type="button" name="back" id="back_cat_ocargas" class="btn green-seagreen">
          <i class="fa fa-arrow-left"></i>&nbsp;Regresar
        </button>

        <button type="button" name="back" id="goto_remisiones" class="btn green-seagreen">
          Remisiones&nbsp;<i class="fa fa-arrow-right"></i> 
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
         <th> Pedido </th>
         <th> Cliente </th>
         <th> Estatus </th>
         <th> Acciones </th>
       </tr>
     </thead>
     <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

     <!-- INICIA CUERPO DE DATA TABLE-->
     <tbody>

      <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
      <?php
      foreach($lista_cargas as $row){
       $codigo = $row['folioOrdenCarga'];
       $pedido = $row['folioPedido'];
       $dd = $row['ddOrdenCarga'];
       $mm = $row['mmOrdenCarga'];
       $yyyy = $row['yyyyOrdenCarga'];
       $status = $row['statusOrdenCarga'];

       $ordenesCarga->folio = $pedido;
       $info_pedido = $ordenesCarga->consultarPedidosID();
       foreach($info_pedido as $row){
        $rfc = $row['rfcCliente'];
      }

      $ordenesCarga->cliente = $rfc;
      $info_cliente = $ordenesCarga->consultarClientes();
      foreach($info_cliente as $row){
        $nombre_cliente = $row['razonSocCliente'];
      }

      ?>
      <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

      <!-- INICIA FILA CON VARIABLES DE FOREACH-->
      <tr class="odd gradeX">
        <td> <?php echo $codigo;?> </td>
        <td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>
        <td> <?php echo $pedido;?></td>
        <td> <?php echo $nombre_cliente;?></td>
        <td> <?php
          if($status == 1){
            echo $html_registrado;
          }
          else{
            if($status == 2){
              echo $html_utilizada;  
            }
            else{
              if($status == 3){
                echo $html_cancelado;
              }
            }

          }
          ?></td>

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
            <i class="icon-magnifier"></i> Ver info.<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></a>
          </li>';


          $html_imprimir='<li><a><input type="radio" id="imprimir'.$codigo.'" class="imprimir" name="imprimir" value="'.$codigo.'">
          <label for="imprimir'.$codigo.'" ">  <i class="fa fa-print"></i>&nbsp;Imprimir<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';


        /*$html_remision='<li><a><input type="radio" id="remisionar'.$codigo.'" class="remisionar" name="remisionar" value="'.$codigo.'">
        <label for="remisionar'.$codigo.'" ">  <i class="icon-paper-clip"></i>&nbsp;Agregar remisión </label></a></li>';*/



        if($carga[0]=='1'||$carga[1]=='2'||$carga[2]=='3'||$carga[3]=='4'){
          echo $html_inicio_action;
        }
        if($carga[0]=='1'){
          echo $html_moreInfo; 
          echo $html_imprimir;
        }
        if($carga[1]=='2'&&$status == 1){
          //echo $html_remision;
        }
        if($carga[2]=='3'&&$status==1){
    //echo $html_editar;
        }

        if($carga[0]=='1'||$carga[1]=='2'||$carga[2]=='3'||$carga[3]=='4'){
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
 $codigo = $row['folioOrdenCarga'];
 $pedido = $row['folioPedido'];
 $dd = $row['ddOrdenCarga'];
 $mm = $row['mmOrdenCarga'];
 $yyyy = $row['yyyyOrdenCarga'];
 $status = $row['statusOrdenCarga'];
 $remision = $row['remisionCarga'];
 $usuario = $row['idUsuario'];

 $usuarios->id=$usuario;
 $cnombres = $usuarios->consultarUsuariosID();

 foreach ($cnombres as $row){
  $nombreUser = $row['nombreUsuario'];
}

$ordenesCarga->folio = $pedido;
$info_pedido = $ordenesCarga->consultarPedidosID();
foreach($info_pedido as $row){
  $rfc = $row['rfcCliente'];

  $ordenesCarga->cliente = $rfc;
  $info_cliente = $ordenesCarga->consultarClientes();
  foreach($info_cliente as $row){
    $nombre_cliente = $row['razonSocCliente'];
  }
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
       <td><?php echo $nombre_cliente;?></td>
     </tr>

     <tr>
       <td>Pedido: </td>
       <td><?php echo $pedido;?></td>
     </tr>

     <?php
     if($remision!="Pendiente"){
      echo '<tr><td>Remisión: </td><td>'.$remision.'</td></tr>';
    }
    ?>

    <tr>
      <td><?php if($status==1||$status==2){echo "Última edición por:";}else{if($status==3){echo "Cancelado por:";}} ?> </td>
      <td><?php echo $nombreUser;?></td>
    </tr>
  </table>

  <?php
  $ordenesCarga->folio = $codigo;
  $consultarProductos = $ordenesCarga->consultarRemision();
###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
  foreach($consultarProductos as $row){
   $codigo = $row['folioOrdenCarga'];
   $pedido = $row['folioPedido'];

   ?>

   <table class="table table-hover">
     <tr>
       <th>Producto</th>
       <th>Cantidad</th>
       <th>Precio Unitario</th>
       <th>Monto</th>
       <?php 
       if($status != 2){
        ?>
        <th><div class="text-center">En existencia</div></th>
        <?php
      } ?>
    </tr>
    <?php 
    $total_coti = 0;
    $ordenesCarga->folio = $pedido;
    $lista_clientes = $ordenesCarga->consultarPedidosID();
    foreach($lista_clientes as $row){
      $cliente = $row['rfcCliente'];
    }

    $ordenesCarga->pedido = $pedido;
    $detalles = $ordenesCarga->consultarDetalle();

    foreach($detalles as $row){
      $producto = $row['codigoProducto'];
      $cantidad = $row['cantidadDetallePedido'];
      $unidad = $row['unidadDetallePedido'];
      $monto = $row ['montoDetallePedido'];

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

      $ordenesCarga->cliente = $cliente;
      $lista_clientes = $ordenesCarga->consultarClientes();
      foreach($lista_clientes as $row){
       $cliente_tipo = $row['tipoCliente'];
     }

     $ordenesCarga->producto = $producto;
     $cProducto = $ordenesCarga->consultarProductosID();

     foreach($cProducto as $row){
      $nombreProducto = $row['nombreProducto'];
      $presentacion = $row['presentacionProducto'];
      if($cliente_tipo != 2 || $cliente_tipo != 4){
        if($cliente_tipo==1){
          $precio_ingles = $row['iVentaDisProducto'];
          $precio_metrico = $row['mVentaDisProducto'];
        }
        else{
          if($cliente_tipo == 3){
            $precio_ingles = $row['iVentaGrwProducto'];
            $precio_metrico = $row['mVentaGrwProducto'];    
          }
        }
      }
      else{
        if($cliente_tipo == 2 || $cliente_tipo == 4){
          $ordenesCarga->cliente = $cliente;
          $ordenesCarga->producto = $producto;
          $lista_precios = $ordenesCarga->consultarPrecios();

          foreach($lista_precios as $row){
            $precio_ingles = $row['iPrecioEspecial'];
            $precio_metrico = $row['mPrecioEspecial'];
          }
        }
      }

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


      switch($unidad){
        case "Litros":
        
        $precio_usar = $precio_metrico;
        break;
        case "Galones":
        
        $precio_usar = $precio_ingles;
        break;
        case "Ton_Metrica": 
        
        $precio_usar = $precio_metrico;
        break;
        case "Ton_Corta": 
        
        $precio_usar = $precio_ingles;
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

          $ordenesCarga->producto =$producto;
          $num_inventario = $ordenesCarga->inventarioEsp();

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

          if($binExistencia==1&&$status!=2){
            echo $negative;
          }
          else{
            if($binExistencia == 0&&$status != 2){
              echo $positive;  
            }
            
          }
          ?>
        </td>
      </tr>
      <?php
    }
    $total_pedido += $monto;
  }
  ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div class="text-right"><strong>Total:</strong></div></td>
    <td><div class="text-center"><?php echo  "$ ".number_format($total_pedido,2, '.', ','); ?></div></td>    
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

    $("#back_cat_ocargas").click(function(){
      window.location = ""
    });

    $("#goto_remisiones").click(function(){
      window.location = "../remisiones"
    });

    $('.imprimir').click(function() {
      window.open("ordencarga.php?codigo="+$(this).val(), "_blank");
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.remisionar').click(function() {
      $("#mainContent").load( "conf_remision.php?codigo="+$(this).val());
    })
  });
</script>

<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>