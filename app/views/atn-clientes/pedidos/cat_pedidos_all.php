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
$listaPedidos = $pedidos->consultarPedidos_all();

$select_meses ="";

$cancel = "";
$all = "";
$defeat = "";
$used = "";
$register = "";
$todos = "";

if(isset($_REQUEST['codigo'])&&isset($_REQUEST['mes'])){
  if($_REQUEST['codigo']=="todas"&&$_REQUEST['mes']=='00'){
    $filtro = $listaPedidos;
    $todos = "";
    $all = "";
  }
  if($_REQUEST['codigo']!="todas"&&$_REQUEST['mes']=='00'){
    $pedidos->status = $_REQUEST['codigo'];
    $filtro = $pedidos->consultarxStatus_all();

    if($_REQUEST['codigo']=="1"){
      $register = "selected";
    }
    if($_REQUEST['codigo']=="2"){
      $defeat = "selected";
    }
    if($_REQUEST['codigo']=="3"){
      $cancel = "selected";
    }
    if($_REQUEST['codigo']=="4"){
      $used = "selected";
    }

  }
  if($_REQUEST['codigo']=="todas"&&$_REQUEST['mes']!='00'){
    $pedidos->mm = $_REQUEST['mes'];
    $filtro = $pedidos->consultarxMes_all();

    switch($_REQUEST['mes']){
      case '01':
      $meses[0]="selected";
      break;
      case '02':
      $meses[1]="selected";
      break;
      case '03':
      $meses[2]="selected";
      break;
      case '04':
      $meses[3] = "selected";
      break;
      case '05':
      $meses[4]="selected";
      break;
      case '06':
      $meses[5]="selected";
      break;
      case '07':
      $meses[6]="selected";
      break;
      case '08':
      $meses[7]="selected";
      break;
      case '09':
      $meses[8]="selected";
      break;
      case '10':
      $meses[9]="selected";
      break;
      case '11':
      $meses[10]="selected";
      break;
      case '12':
      $meses[11]="selected";
      break;

    }
    $all = "selected";
  }


  if($_REQUEST['codigo']!="todas"&&$_REQUEST['mes']!='00'){
    $pedidos->status = $_REQUEST['codigo'];
    $pedidos->mm = $_REQUEST['mes'];
    $filtro = $pedidos->consultarxStatusyMes_all();

    if($_REQUEST['codigo']=="1"){
      $register = "selected";
    }
    if($_REQUEST['codigo']=="2"){
      $defeat = "selected";
    }
    if($_REQUEST['codigo']=="3"){
      $cancel = "selected";
    }
    if($_REQUEST['codigo']=="4"){
      $used = "selected";
    }
    switch($_REQUEST['mes']){
      case '01':
      $meses[0]="selected";
      break;
      case '02':
      $meses[1]="selected";
      break;
      case '03':
      $meses[2]="selected";
      break;
      case '04':
      $meses[3] = "selected";
      break;
      case '05':
      $meses[4]="selected";
      break;
      case '06':
      $meses[5]="selected";
      break;
      case '07':
      $meses[6]="selected";
      break;
      case '08':
      $meses[7]="selected";
      break;
      case '09':
      $meses[8]="selected";
      break;
      case '10':
      $meses[9]="selected";
      break;
      case '11':
      $meses[10]="selected";
      break;
      case '12':
      $meses[11]="selected";
      break;

    }


  }
}
else{
  if(!isset($_REQUEST['codigo'])||$_REQUEST['codigo']=="todas"||$_REQUEST['mes']){
    $filtro = $listaPedidos;
    $all = "selected";
  }
  else{
    $pedidos->status = $_REQUEST['codigo'];
    $filtro = $pedidos->consultarxStatus_all();

    if($_REQUEST['codigo']=="1"){
      $register = "selected";
    }
    if($_REQUEST['codigo']=="2"){
      $defeat = "selected";
    }
    if($_REQUEST['codigo']=="3"){
      $cancel = "selected";
    }
    if($_REQUEST['codigo']=="4"){
      $used = "selected";
    }
  }
}



###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
$consultaModal = $pedidos->consultarPedidos_all();
$consultarProductos = $pedidos->consultarPedidos_all();

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

  $html_entregado='<div class="text-center"><span class="label label-sm label-default"> Entregado </span></div>';
  $html_camino='<div class="text-center"><span class="label label-sm label-warning"> En camino </span></div>';
  //$html_utilizada='<span class="label label-sm label-info"> Utilizada </span>';
  $html_cancelado='<div class="text-center"><span class="label label-sm label-danger"> Cancelado </span></div>';

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
      <div class="caption"><div class="font-grey-mint"> <b>Historial</b> </div>
    </div>

    <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

    <div class="actions btn-set">

      <!-- <div class="btn-group btn-group-devided" data-toggle="buttons">

        <select id="select_year" class="btn grey-cascade btn-outline" required >
         <option <?php //echo $todos_a;?> value="0000>">Año</option>
         <?php 
         $years = $pedidos->consultarAnios();
         foreach ($years as $row){
          $yyyy = $row['yyyyPedido'];

          ?>
          <option <?php //echo $anios[$yyyy];?> value="<?=$yyyy;?>"><? //echo $yyyy;?></option>
          <?php
        }
        ?>
      </select>
    </div> -->
    &nbsp;
   <!--  <div class="btn-group btn-group-devided" data-toggle="buttons">
      <select id="select_month" class="btn grey-cascade btn-outline" required >
       <option <?php //echo $todos;?> value="00">Mes</option>
       <option <?php //echo $meses[0];?> value="01">Enero</option>
       <option <?php //echo $meses[1];?> value="02">Febrero</option>
       <option <?php //echo $meses[2];?> value="03">Marzo</option>
       <option <?php //echo $meses[3];?> value="04">Abril</option>
       <option <?php //echo $meses[4];?> value="05">Mayo</option>
       <option <?php //echo $meses[5];?> value="06">Junio</option>
       <option <?php //echo $meses[6];?> value="07">Julio</option>
       <option <?php //echo $meses[7];?> value="08">Agosto</option>
       <option <?php //echo $meses[8];?> value="09">Septiembre</option>
       <option <?php //echo $meses[9];?> value="10">Octubre</option>
       <option <?php //echo $meses[10];?> value="11">Noviembre</option>
       <option <?php //echo $meses[11];?> value="12">Diciembre</option>
     </select>
   </div> -->
   &nbsp;
   <!-- <div class="btn-group btn-group-devided" data-toggle="buttons">
    <select id="filtro" class="btn grey-cascade btn-outline" required >
     <option <?php //echo $all;?> value="todas">Todos los registros</option>
     <option <?php //echo $register;?> value="1">En camino</option>
     <option <?php //echo $defeat;?> value="2">Entregados</option>
     <option <?php //echo $cancel;?> value="3">Cancelados</option>
   </select>
 </div> -->
 <button type="button" name="back" id="back_cat_pedi" class="btn green-seagreen">
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
  foreach($filtro as $row){
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

    $html_final_action='</ul></div></div>';
    $html_moreInfo='<li>
    <a data-toggle="modal" href="#modal'.$codigo.'">
      <i class="icon-magnifier"></i> Ver info.<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></a>
    </li>';
    $html_imprimir='<li><a><input type="radio" id="imprimir'.$codigo.'" class="imprimir" name="imprimir" value="'.$codigo.'">
    <label for="imprimir'.$codigo.'" ">  <i class="fa fa-print"></i>&nbsp;Imprimir<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

    $html_cancelar='<li><a><input type="radio" id="cancelar'.$codigo.'" class="cancelar" name="cancelar" value="'.$codigo.'">
    <label for="cancelar'.$codigo.'" ">  <i class="glyphicon glyphicon-remove-circle"></i>&nbsp;Cancelar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';


    if($pPedidos[0]=='1'||$pPedidos[1]=='2'||$pPedidos[2]=='3'||$pPedidos[3]=='4'){
      echo $html_inicio_action;
    }
    if($pPedidos[0]=='1'){
      echo $html_moreInfo; 
      echo $html_imprimir;
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
  $nombreUser = $row['nombreUsuario']." ".$row['apellidosUsuario'];
}

$pedidos->cliente = $cliente;
$consultaClientes = $pedidos->consultarClientes();
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
        echo "<tr><td>Cotización: </td><td>".$cotizacion."</td></tr>";  
      }
      ############# REVISAR COTIZACION DE ORIGEN ############################

      ?>
    </table>




    <?php
    $pedidos->folio = $codigo;
    $consultarProductos = $pedidos->consultarPedidosxID();
###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
    foreach($consultarProductos as $row){
     $codigo = $row['folioPedido'];
     $cliente = $row['rfcCliente'];
     ?>

     <table class="table table-hover">
       <tr>
         <th>Producto</th>
         <th>Cantidad</th>
         <th>Precio Unitario</th>
         <th>Monto</th>
         <?php 
         if($status != 2&&$status != 3){
           ?>
           <th>En existencia</th>
           <?php 
         } 
         ?>
       </tr>
       <?php 
       $total_pedido = 0;
       $pedidos->folio = $codigo;
       $detalles = $pedidos->consultarDetalle();
       foreach($detalles as $row){
        $producto = $row['codigoProducto'];
        $cantidad = $row['cantidadDetallePedido'];
        $unidad = $row['unidadDetallePedido'];
        $monto = $row['montoDetallePedido'];
        $nombreProducto = $row['nombreProducto'];
        $presentacion = $row['presentacionProducto'];
        $tipo_cliente = $row['tipoCliente'];
        $rfc = $row['rfcCliente'];

        if($tipo_cliente == 2 || $tipo_cliente == 4){
          $pedidos->producto=$producto;
          $pedidos->cliente = $rfc;
          $result_clientes = $pedidos->consultarPrecios();
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
} 
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

    $("#back_cat_pedi").click(function(){
      window.location = ""
    });

    $('.imprimir').click(function() {
      window.open("pedido.php?codigo="+$(this).val(), "_blank");
    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
    $('.cancelar').click(function() {
      $("#mainContent").load( "conf_cancel.php?codigo="+$(this).val());
    });

    $('#gotoPedido').click(function() {
      $("#mainContent").load( "form_pedidos.php");
    });

    $('#filtro').change(function() {
      var prueba = $("#select_month").val();
      $("#mainContent").load( "cat_pedidos_all.php?codigo="+$(this).val()+"&mes="+prueba);
    });

    $('#select_month').change(function() {
      var prueba = $("#filtro").val();

      $("#mainContent").load( "cat_pedidos_all.php?mes="+$(this).val()+"&codigo="+prueba);
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
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>