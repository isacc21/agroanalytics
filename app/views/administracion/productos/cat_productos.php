<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 21 Febrero 2017 : 13:01                                                            #
#                                                                                    #
###### productos/cat_productos.php ###################################################
#                                                                                    #
# Archivo sin estructura del formuario de productos para ser recibido por            #  
# JQuery en index de "Productos"                                                     #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 21-FEB-17: 13:02                                                                   #
# IJLM - Se copia CATALOGO de usuarios                                               #
# IJLM - Se realizan los cambios pertinentes a la sección productos.                 #
#                                                                                    #
# 23-FEB-17: 14:48                                                                   #
# IJLM - Se cambiaron los parametros de recepción de variables para productos        #
# IJLM - Se cambio la tabla para recibir los datos de la tabla BD.PRODUCTOS          #
# IJLM - Se agregó código para MODAL con información completa de productos           #
# IJLM - Se agregó botón en ACCIONES para ver más información de productos           #
#                                                                                    #
# 24-FEB-17: 16:36                                                                   #
# IJLM - Se documento el código completo para su mejor entendimiento                 #
#                                                                                    #
# 27-FEB-17: 13:38                                                                   #
# IJLM - Se cambio el campo FOLIO por CODIGO                                         #
#                                                                                    #
# 28-FEB-17: 00:00                                                                   #
# IJLM - Se adaptaron los nuevos datos de Productos a Modal y Datatable              #
#                                                                                    #
# 15-MAR-17: 01:53                                                                   #
# IJLM - Se cambiaron los colores de los botones de ACCIONES                         #
######################################################################################


###### DEFINICION DE ZONA HORARIO ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/productos.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO PRODUCTOS PARA UTILIZAR METODOS ###########################
$productos = new productos($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE PRODUCTOS PARA DATA TABLE #########################################
$listaProductos = $productos->consultarProductos();


###### CONSULTA DE PRODUCTOS PARA VENTANAS MODALES ###################################
$consultaModal = $productos->consultarProductos();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $permiso = $row['productosPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_nuevo='<button id="gotoProducts" class="btn sbold green"> 
  Nuevo <i class="fa fa-plus"></i></button>';

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
            <span class="caption-subject bold uppercase"> Catálogo</span>
          </div>
          <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->

          <div class="actions btn-set">
            <?php 
            if($permiso[1]=='2'){
              echo $html_nuevo;
            } ?>
            <button type="button" name="back" id="back_cat_prod" class="btn default green-stripe">
              <i class="fa fa-arrow-left"></i> Regresar
            </button>
          </div>


        </div>
        <!-- TERMINA TITULO DE PORTLET-->

        <!-- INICIA CUERPO DE PORTLET-->
        <div class="portlet-body">

          <table class="table table-striped table-bordered table-hover order-column" id="sample_1">

            <!-- INICIAN ENCABEZADOS PARA DATATALBE -->
            <thead>
              <tr>

                <th> Código </th>
                <th> Nombre </th>
                <th> Presentación </th>
                <th> Precio compra </th>
                <th> Dist. Ing.</th>
                <th> Dist. Mét.</th>
                <th> Grw. Ing.</th>
                <th> Grw. Mét.</th>
                <th> Acciones </th>
              </tr>
            </thead>
            <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

            <!-- INICIA CUERPO DE DATA TABLE-->
            <tbody>

              <!--INICIO DE FOREACH PARA TABLA DE PRODUCTOS-->
              <?php
              foreach($listaProductos as $row){
                $codigo = $row['codigoProducto'];
                $nombre = $row['nombreProducto'];
                $presentacion = $row['presentacionProducto'];
                $tipo = $row['tipoProducto'];
                $dis = $row['iVentaDisProducto'];
                $dism = $row['mVentaDisProducto'];
                $grower = $row['iVentaGrwProducto'];
                $growerm = $row['mVentaGrwProducto'];
                $compra = $row['compraProducto'];
                ?>
                <!--TERMINO DE FOREACH PARA TABLA DE PRODUCTOS-->

                <!-- INICIA FILA CON VARIABLES DE FOREACH-->
                <tr class="odd gradeX">

                  <td> <?php echo $codigo;?> </td>
                  <td> <?php echo $nombre;?> </td>
                  <td> <?php 
                    switch($presentacion){
                      case 1:
                      echo "Cubeta";
                      break;

                      case 2:
                      echo "Tibor";
                      break;

                      case 3: 
                      echo "Tote";
                      break;

                      case 4: 
                      echo "Granel";
                      break;

                      case 5:
                      echo "Saco";
                      break;

                      case 6: 
                      echo "Súper saco";
                      break;
                    }
                    ?></td>
                    
                    <td> <?php echo "$ ".$compra;?></td>
                    <td> <?php echo "$ ".$dis;?></td>
                    <td> <?php echo "$ ".$dism;?></td>
                    <td> <?php echo "$ ".$grower;?></td>
                    <td> <?php echo "$ ".$growerm;?></td>
                    <td>
                      <?php

                      $html_inicio_actions='<div class="text-center"><div class="btn-group">
                      <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 
                        &nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
                        &nbsp; Elegir&nbsp;&nbsp;
                      </button><ul class="dropdown-menu pull-right" role="menu">';

                      $html_final_actions='</ul></div>';

                      $html_moreInfo='<li><a><a data-toggle="modal" href="#modal'.$codigo.'"> <i class="fa fa-search"></i>&nbsp;Info. </a></li></a>';

                      $html_editar='<li><a><input type="radio" id="editar'.$codigo.'" class="editar" name="editar" value="'.$codigo.'">
                      <label for="editar'.$codigo.'">  <i class="fa fa-edit"></i>&nbsp;Modificar </label></a></li>';

                      $html_eliminar='<li><a><input type="radio" id="borrar'.$codigo.'" class="borrar" name="borrar" value="'.$codigo.'">
                      <label for="borrar'.$codigo.'" data-toggle="modal" href="#basic">  <i class="fa fa-trash-o"></i>&nbsp;Eliminar </label></a></li>';



                      if($permiso[0]=='1'||$permiso[1]=='2'||$permiso[2]=='3'||$permiso[3]=='4'){
                        echo $html_inicio_actions;
                      }
                      if($permiso[0]=='1'){
                       echo $html_moreInfo;
                     }
                     if($permiso[2]=='3'){
                      echo $html_editar;
                    }
                    if($permiso[3]=='4'){
                      echo $html_eliminar;
                    }
                    if($permiso[0]=='1'||$permiso[1]=='2'||$permiso[2]=='3'||$permiso[3]=='4'){
                      echo $html_final_actions;
                    }
                    ?>
                  </td>
                </tr>
                <!-- TERMINA FILAS CON VARIABLES DE FOREACH-->

                <!-- INICIA LLAVE DE FOREACH PARA TABLA DE USUARIOS-->
                <?php 
              }
              ?>
              <!-- TERMINA LLAVE DE FOREACH PARA TABLA DE USUARIOS-->

            </tbody>
            <!-- TERMINA CUERPO DE DATA TABLE -->

          </table>
          <!-- TERMINA DATA TABLE PARA TABLA DE PRODUCTOS-->
        </div>
        <!-- TERMINA CUERPO DE PORTLET -->
      </div>
      <!-- TERMINA PORTLET-->
    </div>
    <!-- TERMINAR COLUMNA DE 12 PARA PORTLET-->
  </div>
  <!-- TERMINA ROW PARA PORTLET-->


  <?php

###### FOREACH PARA CONSULTA DE DETALLES DE PRODUCTOS PARA VENTANA MODAL #########
  foreach($consultaModal as $row){
    $codigo = $row['codigoProducto'];
    $nombre = $row['nombreProducto'];
    $presentacion = $row['presentacionProducto'];
    $tipo = $row['tipoProducto'];
    $caducidad = $row['caducidadProducto'];
    $compra = $row['compraProducto'];
    $dis = $row['ventaDisProducto'];
    $grower = $row['ventaGrwProducto'];
    $cofepris = $row['cofeprisProducto'];
    $ddCof = $row['ddCofProducto'];
    $mmCof = $row['mmCofProducto'];
    $yyyyCof = $row['yyyyCofProducto'];
    $cicoplafest = $row['cicoplafestProducto'];
    $ddCic = $row['ddCicProducto'];
    $mmCic = $row['mmCicProducto'];
    $yyyyCic = $row['yyyyCicProducto'];
    $semarnat = $row['semarnatProducto'];
    $ddSem = $row['ddSemProducto'];
    $mmSem = $row['mmSemProducto'];
    $yyyySem = $row['yyyySemProducto'];
    $arancel = $row['arancelProducto'];
    $densidad = $row['densidadProducto'];


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

            <!-- INICIA TABLA SIMPLE PARA MOSTRAR DETALLES DE PRODUCTOS-->
            <table class="table table-hover">
              <tr>
                <td>Código: </td>
                <td><?php echo $codigo;?></td>
              </tr>

              <tr>
                <td>Nombre: </td>
                <td><?php echo $nombre;?></td>
              </tr>

              <tr>
                <td>Presentación: </td>
                <td><?php
                  switch($presentacion){
                    case 1:
                    echo "Cubeta";
                    break;

                    case 2:
                    echo "Tibor";
                    break;

                    case 3: 
                    echo "Tote";
                    break;

                    case 4: 
                    echo "Granel";
                    break;

                    case 5:
                    echo "Saco";
                    break;

                    case 6: 
                    echo "Súper saco";
                    break;
                  }
                  ?></td>
                </tr>

                <tr>
                  <td>Tipo: </td>
                  <td><?php
                    if($tipo==1){
                      echo "Orgánico";
                    }
                    else{
                      if($tipo==2){
                        echo "Convencional";
                      }
                      else{
                        echo "Ambos";
                      }
                    }
                    ?></td>
                  </tr>

                  <tr>
                    <td>Caducidad: </td>
                    <td><?php echo $caducidad . " Meses";?></td>
                  </tr>

                  <tr>
                    <td>Precio de compra: </td>
                    <td><?php echo "$ ".$compra;?></td>
                  </tr>

                  <tr>
                    <td>Precio de venta a Dist.: </td>
                    <td><?php echo "$ ". $dis;?></td>
                  </tr>

                  <tr>
                    <td>Precio de venta a Grower: </td>
                    <td><?php echo "$ ". $grower;?></td>
                  </tr>

                  <tr>
                    <td>Registro COFEPRIS: </td>
                    <td><?php echo $cofepris;?></td>
                  </tr>

                  <tr>
                    <td>Vencimiento COFEPRIS: </td>
                    <td><?php echo $ddCof."/".$mmCof."/".$yyyyCof;?></td>
                  </tr>

                  <tr>
                    <td>Registro CICOPLAFEST: </td>
                    <td><?php echo $cicoplafest;?></td>
                  </tr>

                  <tr>
                    <td>Vencimiento CICOPLAFEST: </td>
                    <td><?php echo $ddCic."/".$mmCic."/".$yyyyCic;?></td>
                  </tr>

                  <tr>
                    <td>Registro SEMARNAT: </td>
                    <td><?php echo $semarnat;?></td>
                  </tr>

                  <tr>
                    <td>Vencimiento SEMARNAT: </td>
                    <td><?php echo $ddSem."/".$mmSem."/".$yyyySem;?></td>
                  </tr>

                  <tr>
                    <td>Arancel: </td>
                    <td><?php echo $arancel;?></td>
                  </tr>

                  <tr>
                    <td>Densidad: </td>
                    <td><?php echo $densidad;?></td>
                  </tr>
                </table>
              </div>
              <!-- TERMINA TABLA SIMPLE PARA DETALLES DE PRODUCTOS-->

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
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE PRODUCTOS #############################################
?>


<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
  $(document).ready(function(){

    $("#back_cat_prod").click(function(){
      window.location = "";
    });

    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#gotoProducts").click(function(){
      $("#mainContent").load( "form_productos.php" );
    });


    /* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
    $('.editar').click(function() {
      $("#mainContent").load( "form_productos.php?codigo="+$(this).val() );

    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL PRODUCTO EN CUESTION*/ 
    $(".borrar").click(function(){

      var codigoProducto = $(this).val();

      swal({
        title: "¿Eliminar producto?",
        text: "Se eliminará permanentemente",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí, Eliminarlo",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
          $.ajax({
            type: "POST",
            url: "../../../controllers/administracion/productos/eliminarProducto.php",
            data:"codigo="+ codigoProducto
          }).done(function(result){
            swal("Eliminado", "El producto ha sido eliminado", "success");
            $("#mainContent").load( "cat_productos.php" );
          });

        } else {
          swal("Cancelado", "Se ha conservado el producto", "error");
        }
      });
    });
  });
</script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.js" type="text/javascript"></script>

<!-- TERMINAN SCRIPTS PARA EL FUNCIONAMIENTO DE DATA TABLES-->