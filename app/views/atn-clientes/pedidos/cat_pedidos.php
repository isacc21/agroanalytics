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
require '../../../models/atn-cliente/pedidos.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$pedidos = new pedidos($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$listaPedidos = $pedidos->consultarPedidos();



###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $pedidos->consultarPedidos();
$consultarProductos = $pedidos->consultarPedidos();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $pPedidos = $row['cotizacionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_inicio_head_dt='<div class="row">';
  $html_final_head_dt='</div>';
  $html_nuevo='
  <div class="col-md-6">
  	<div class="btn-group">
  		<button id="gotoPedido" class="btn sbold green"> 
  			Nuevo <i class="fa fa-plus"></i>
  		</button>
  	</div>
  </div>';


  $html_entregado='<span class="label label-sm label-success"> Entregado </span>';
  $html_camino='<span class="label label-sm label-warning"> En camino </span>';
  //$html_utilizada='<span class="label label-sm label-info"> Utilizada </span>';
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
       <i class="fa fa-list-alt font-dark"></i>

       <!-- TEXTO DE TITULO DE PORTLET-->
       <span class="caption-subject bold uppercase"> Pedidos</span>
     </div>

     <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

     <div class="actions btn-set">
       <button type="button" name="back" id="back_cat_pedi" class="btn default green-stripe">
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
    foreach($listaPedidos as $row){
     $codigo = $row['folioPedido'];
     $cliente = $row['rfcCliente'];
     $dd = $row['ddPedido'];
     $mm = $row['mmPedido'];
     $yyyy = $row['yyyyPedido'];
     $total = $row['totalPedido'];
     $status = $row['statusPedido'];
     $num = number_format($total,2, '.', ',');
     ?>
     <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

     <!-- INICIA FILA CON VARIABLES DE FOREACH-->
     <tr class="odd gradeX">


      <td> <?php echo $codigo;?> </td>
      <td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>
      <?php
      $pedidos->cliente = $cliente;
      $consultaClientes = $pedidos->consultarClientes();
      foreach($consultaClientes as $row){
        $name_cliente = $row['razonSocCliente'];
      }
      ?>
      <td> <?php echo $name_cliente; ?></td>
      <td> <?php echo '$ '.$num;?></td>
      <td>
        <?php 
        if($status==1){
          echo $html_camino;
        }
        else{
          if($status==2){
            echo $html_entregado;
          }
          else{
            if($status==3){
              echo $html_cancelado;
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
        <i class="icon-magnifier"></i> Ver info. </a>
      </li>';

      $html_productos='<li>
      <a data-toggle="modal" href="#productos'.$codigo.'">
        <i class="icon-magnifier"></i> Productos </a>
      </li>';
      $html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
      <label for="cancelar'.$codigo.'" ">  <i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Cancelar </label></a></li>';
  /*$html_editar='<li><a><input type="radio" id="editar'.$codigo.'" class="editar" name="editar" value="'.$codigo.'">
  <label for="editar'.$codigo.'">  <i class="fa fa-edit"></i>&nbsp;Modificar </label></a></li>';

  $html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
  <label for="cancelar'.$codigo.'">  <i class="fa fa-times-circle"></i>&nbsp;Cancelar </label></a></li>';*/


  if($pPedidos[0]=='1'||$pPedidos[1]=='2'||$pPedidos[2]=='3'||$pPedidos[3]=='4'){
    echo $html_inicio_action;
  }
  if($pPedidos[0]=='1'){
    echo $html_moreInfo; 
    echo $html_productos;
  }
  if($pPedidos[2]=='3'&&$status==1){
    //echo $html_editar;
  }
  if($pPedidos[3]=='4'&&$status==1){
    echo $html_cancelar;
  }
  if($pPedidos[0]=='1'||$pPedidos[1]=='2'||$pPedidos[2]=='3'||$pPedidos[3]=='4'){
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
 $codigo = $row['folioPedido'];
 $cliente = $row['rfcCliente'];
 $dd = $row['ddPedido'];
 $mm = $row['mmPedido'];
 $yyyy = $row['yyyyPedido'];
 $usuario = $row['idUsuario'];
 $pedido = $row['fPedido'];
 $num = number_format($total,2, '.', ',');

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
      ############# REVISAR COTIZACIÓN DE ORIGEN ############################
      $pedidos->pedido = $codigo;
      $pedidosEC = $pedidos->consultarPedidosEnCotizaciones();
      foreach($pedidosEC as $row){
        $cotizacion = $row['folioCotizacion'];
      }
      if($cotizacion!=""){
        echo "<tr><td>Cotización: </td><td>".$cotizacion."11</td></tr>";  
      }
      ############# REVISAR COTIZACION DE ORIGEN ############################

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
 $codigo = $row['folioPedido'];
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
       $total_pedido = 0;
       $pedidos->folio = $codigo;
       $detalles = $pedidos->consultarDetalle();

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

        $pedidos->producto = $producto;
        $cProducto = $pedidos->consultarProductosxID();

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

          $pedidos->cliente = $cliente;
          $lista_clientes = $pedidos->consultarClientes();
          foreach($lista_clientes as $row){
           $cliente_tipo = $row['tipoCliente'];
         }

         if($cliente_tipo == 1){ 
          if($precio_unidad == 1){ 
            $precio_unitario = $distriM;
          } 
          else{
            if($precio_unidad == 2){
              $precio_unitario = $distri;
            }
          }
        } 
        else{
          if($cliente_tipo == 2){
            if($precio_unidad == 1){
              $precio_unitario = $growerM;
            }
            else{
              if($precio_unidad == 2){
                $precio_unitario = $grower;
              }
            }
          }
          else{
            if($cliente_tipo==3){
              $pedidos->cliente = $cliente;
              $pedidos->producto = $producto;
              $lista_preciosespe = $pedidos->consultarPrecios();

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
          }
        }

        ?>
        <tr>
          <td><?php echo $nombreProducto.$pres;?></td>
          <td><?php echo number_format( $cantidad,2, '.', ',').$typep;?></td>
          <td><?php echo "$ ".number_format($precio_unitario,2, '.', ','); ?></td>
          <td><?php echo "$ ".number_format($monto,2, '.', ','); ?></td>
          <td>
            <?php 

            $pedidos->producto =$producto;
            $num_inventario = $pedidos->inventarioEsp();

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

    $("#back_cat_pedi").click(function(){
      window.location = ""
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.cancelar').click(function() {
      $("#mainContent").load( "conf_cancel.php?codigo="+$(this).val());
    });

    $('#gotoPedido').click(function() {
      $("#mainContent").load( "form_pedidos.php");
    });
  });
</script>

<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.js" type="text/javascript"></script>