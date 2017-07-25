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
require '../../../models/almacen/remisiones.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
$remisiones = new remisiones($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
$lista_remisiones = $remisiones->consultarRemisiones();

###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $remisiones->consultarRemisiones();
$revisar_productos = $remisiones->consultarRemisiones();
$consultar_pedimentos = $remisiones->consultarRemisiones();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $remision = $row['remisionesPermiso'];
  }## LLAVE DE FOREACH ###############################################################


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
       <span class="caption-subject bold uppercase"> Remisiones</span>
     </div>

     <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->
     <div class="actions btn-set">
      <button type="button" name="back" id="back_remisiones" class="btn default green-stripe">
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
       <th> Remisión </th>
       <th> Fecha [AAAA/MM/DD] </th>
       <th> Cliente </th>
       <th> Orden de Carga </th>
       <th> Acciones </th>
     </tr>
   </thead>
   <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

   <!-- INICIA CUERPO DE DATA TABLE-->
   <tbody>

    <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
    <?php
    foreach($lista_remisiones as $row){
     $folio_rem = $row['folioRemision'];
     $dd = $row['ddRemision'];
     $mm = $row['mmRemision'];
     $yyyy = $row['yyyyRemision'];
     $ordenCarga = $row['folioOrdenCarga'];

     $remisiones->carga = $ordenCarga;
     $lista_ordenesCarga = $remisiones->consultarOrdenesCarga();

     foreach($lista_ordenesCarga as $row){
      $pedido = $row['folioPedido'];
    }

    $remisiones->pedido = $pedido;
    $lista_pedidos = $remisiones->consultarPedidosxID();

    foreach($lista_pedidos as $row){
      $rfc = $row['rfcCliente'];
    }

    $remisiones->cliente = $rfc;
    $lista_clientes = $remisiones->consultarClientesxID();

    foreach($lista_clientes as $row){
      $cliente = $row['razonSocCliente'];
    }
    ?>
    <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

    <!-- INICIA FILA CON VARIABLES DE FOREACH-->
    <tr class="odd gradeX">
      <td> <?php echo $folio_rem;?> </td>
      <td> <?php echo $yyyy."/".$mm."/".$dd; ?> </td>
      <td> <?php echo $cliente; ?></td>
      <td> <?php echo $ordenCarga;?></td>
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
      <a data-toggle="modal" href="#modal'.$folio_rem.'">
        <i class="icon-magnifier"></i> Ver info. </a>
      </li>';

      $html_productos='<li>
      <a data-toggle="modal" href="#productos'.$folio_rem.'">
        <i class="icon-social-dropbox"></i> Productos </a>
      </li>';

      $html_pedimentos='<li>
      <a data-toggle="modal" href="#pedimentos'.$folio_rem.'">
        <i class="icon-book-open"></i> Pedimentos </a>
      </li>';

      if($carga[0]=='1'||$carga[1]=='2'||$caremisionrga[2]=='3'||$remision[3]=='4'){
        echo $html_inicio_action;
      }
      if($remision[0]=='1'){
        echo $html_moreInfo; 
        echo $html_productos;
        echo $html_pedimentos;
      }
      
      if($remision[0]=='1'||$remision[1]=='2'||$remision[2]=='3'||$remision[3]=='4'){
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
  $folio_rem = $row['folioRemision'];
  $folio_oc = $row['folioOrdenCarga'];
  $adicional = $row['adicionalRemision'];
  $dd = $row['ddRemision'];
  $mm = $row['mmRemision'];
  $yyyy = $row['yyyyRemision'];
  $usuario = $row['idUsuario'];

  $usuarios->id=$usuario;
  $cnombres = $usuarios->consultarUsuariosID();

  foreach ($cnombres as $row){
    $nombreUser = $row['nombreUsuario'];
  }


  ?>
  <!-- INICIO DE VENTANA MODAL -->
  <div class="modal fade" id="modal<?=$folio_rem;?>" tabindex="-1" role="basic" aria-hidden="true">

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
         <td><?php echo $folio_rem;?></td>
       </tr>

       <tr>
         <td>Fecha: </td>
         <td><?php echo $dd."/".$mm."/".$yyyy;?></td>
       </tr>
       <tr>
         <td>Orden de Carga: </td>
         <td><?php echo $folio_oc; ?></td>
       </tr>
       <tr>
         <td>Información adicional:</td>
         <td><?php echo $adicional; ?></td>
       </tr>
       <tr>
         <td> Ultima edición por:</td>
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


<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($revisar_productos as $row){
 $folio_rem = $row['folioRemision'];

 $ordenCarga = $row['folioOrdenCarga'];

 $remisiones->carga = $ordenCarga;
 $lista_ordenesCarga = $remisiones->consultarOrdenesCarga();

 foreach($lista_ordenesCarga as $row){
  $pedido = $row['folioPedido'];
}

$remisiones->pedido = $pedido;
$lista_pedidos = $remisiones->consultarPedidosxID();

foreach($lista_pedidos as $row){
  $cliente = $row['rfcCliente'];
}

?>
<!-- INICIO DE VENTANA MODAL -->
<div class="modal fade bs-modal-lg" id="productos<?=$folio_rem;?>" tabindex="-1" role="basic" aria-hidden="true">

  <!-- INICIO DE VENTANA MODAL -->
  <div class="modal-dialog modal-lg">

   <!-- INCIO DE DEFINICIO DE CONTENIDO DE VENTANA MODAL -->
   <div class="modal-content">

    <!-- INICIO DE CABECERA DE VENTANA MODAL -->
    <div class="modal-header">

     <!-- BONTON DE CIERRE DE VENTANA MODAL-->
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

     <!-- ENCABEZADO DE VENTANA MODAL-->
     <h4 class="modal-title">Información completa </h4>
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
       $total_pedido = 0;
       $remisiones->pedido = $pedido;
       $detalles = $remisiones->consultarDetallePedido();

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

        $remisiones->producto = $producto;
        $cProducto = $remisiones->consultarProductosxID();

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

          $remisiones->cliente = $cliente;
          $lista_clientes = $remisiones->consultarClientesxID();
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
              $remisiones->cliente = $cliente;
              $remisiones->producto = $producto;
              $lista_preciosespe = $remisiones->consultarPrecios();

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
        </tr>
        <?php
      }
      $total_pedido += $monto;
    }
    ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div class="text-right"><strong>Total:</strong></div></td>
      <td><div class="text-left"><?php echo  "$ ".number_format($total_pedido,2, '.', ','); ?></div></td>    
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


<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($consultar_pedimentos as $row){
  $folio_rem = $row['folioRemision'];

  $remisiones->remision = $folio_rem;
  $lista_pedimentos = $remisiones->consultarDetalleRemision();

  ?>
  <!-- INICIO DE VENTANA MODAL -->
  <div class="modal fade" id="pedimentos<?=$folio_rem;?>" tabindex="-1" role="basic" aria-hidden="true">

    <!-- INICIO DE VENTANA MODAL -->
    <div class="modal-dialog">

     <!-- INCIO DE DEFINICIO DE CONTENIDO DE VENTANA MODAL -->
     <div class="modal-content">

      <!-- INICIO DE CABECERA DE VENTANA MODAL -->
      <div class="modal-header">

       <!-- BONTON DE CIERRE DE VENTANA MODAL-->
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

       <!-- ENCABEZADO DE VENTANA MODAL-->
       <h4 class="modal-title">Lista de pedimentos</h4>
     </div>
     <!-- TERMINA CABECERA DE VENTANA MODAL -->

     <!-- INICIA CUERPO DE VENTANA MODAL-->
     <div class="modal-body">

       <!-- INICIA TABLA SIMPLE PARA MOSTRAR DETALLES DE ACREEDORES-->
       <table class="table table-hover">
        <?php
        foreach($lista_pedimentos as $row){
          ?>
          <tr>
            <td>Folio: <?php echo $row['folioPedimento'];?></td>
          </tr> 
          <?php
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

    $("#back_remisiones").click(function(){
      window.location = ""
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