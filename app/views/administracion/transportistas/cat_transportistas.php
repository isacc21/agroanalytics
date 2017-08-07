<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 28 Febrero 2017 : 17:20                                                            #
#                                                                                    #
###### transportistas/cat_transportistas.php #########################################
#                                                                                    #
# Archivo sin estructura del formulario de acreedores para ser recibido por          #  
# JQuery en index de "TRANSPORTISTAS"                                                #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 28-FEB-17: 23:10                                                                   #
# IJLM - Se copia CATALOGO de Proveedores                                            #
# IJLM - Se realizan los cambios pertinentes a la sección Transportistas             #
#                                                                                    #
# 15-MAR-17: 02:08                                                                   #
# IJLM - Se cambiaron colores de botones de ACCION                                   #
######################################################################################


###### DEFINICION DE ZONA HORARIO ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE TRANSPORTISTAS ###########################
require '../../../models/administracion/transportistas.php';
require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO TRANSPORTISTAS PARA UTILIZAR METODOS ##########################
$transportistas = new transportistas($datosConexionBD);
$usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE TRANSPORTISTAS PARA DATA TABLE ########################################
$listaTransportistas = $transportistas->consultarTransportista();


###### CONSULTA DE TRANSPORTISTAS PARA VENTANAS MODALES ##################################
$consultaModal = $transportistas->consultarTransportista();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
$usuarios->id=$_SESSION['idUsuario'];
$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
foreach ($result as $row){
  $transportistas = $row['transportistasPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_nuevo='<button id="gotoTransportista" class="btn sbold green-seagreen"><i class="fa fa-plus"></i>&nbsp;Nuevo</button>';
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
          <div class="caption"><div class="font-grey-mint"> <b>Catálogo</b> </div>
        </div>
        <!-- TERMINAR ESTILOS PARA TITULO DE PORTLET-->
        <div class="actions btn-set">
          <?php 
          if($transportistas[1]=='2'){
            echo $html_nuevo;
          } ?>
          <button type="button" name="back" id="back_cat_trans" class="btn default green-seagreen">
            <i class="fa fa-arrow-left"></i>&nbsp;Regresar
          </button>
        </div>
      </div>
      <!-- TERMINA TITULO DE PORTLET-->

      <!-- INICIA CUERPO DE PORTLET-->
      <div class="portlet-body">

        <!-- INICIA DATA TABLE PARA CATALOGO DE TRANSPORTISTAS-->
        <table class="table table-striped table-bordered table-hover order-column" id="sample_1">

          <!-- INICIAN ENCABEZADOS PARA DATATALBE -->
          <thead>
            <tr>
              <th> Razón social </th>
              <th> RFC </th>
              <th> Teléfono </th>
              <th> Celular </th>
              <th> Acciones </th>
            </tr>
          </thead>
          <!-- TERMINAN ENCABEZADOS PARA DATA TABLE-->

          <!-- INICIA CUERPO DE DATA TABLE-->
          <tbody>

            <!--INICIO DE FOREACH PARA TABLA DE TRANSPORTISTAS-->
            <?php
            foreach($listaTransportistas as $row){
              $rfc = $row['rfcTransportista'];
              $nombre = $row['razonSocTransportista'];
              $email = $row['emailTransportista'];
              $telefono = $row['telefonoTransportista'];
              $celular = $row['celularTransportista'];

              for ($i=0; $i <(strlen($telefono)) ; $i++) { 
                if($telefono[$i]=="("){
                  $abreF = $i;
                }
                if($telefono[$i]==")"){
                  $cierraF = $i;
                }
              }

              for ($i=($abreF+1); $i < $cierraF ; $i++) { 
                $ladafijo .= $telefono[$i];
              }
              $x=0;
              for ($i=($cierraF+1); $i < (strlen($telefono)); $i++) { 
                $x++;
                $telfijo .= $telefono[$i];
                if($x==3||$x==5){
                  $telfijo .=".";
                }
              }


              for ($i=0; $i <(strlen($celular)) ; $i++) { 
                if($celular[$i]=="("){
                  $abreM = $i;
                }
                if($celular[$i]==")"){
                  $cierraM = $i;
                }
              }

              for ($i=($abreM+1); $i < $cierraM ; $i++) { 
                $ladamovil .= $celular[$i];
              }
              $x=0;
              for ($i=($cierraM+1); $i < (strlen($celular)); $i++) { 
                $x++;
                $telmovil .= $celular[$i];
                if($x==3||$x==5){
                  $telmovil .=".";
                }
              }
              ?>
              <!--TERMINO DE FOREACH PARA TABLA DE TRANSPORTISTAS-->

              <!-- INICIA FILA CON VARIABLES DE FOREACH-->
              <tr>
                <td> <?php echo $nombre;?> </td>
                <td> <?php echo $rfc;?> </td>
                <td> <?php echo "(".$ladafijo.") ".$telfijo;?></td>
                <td> <?php echo "(".$ladamovil.") ".$telmovil;?></td>
                <td>
                  <?php

                  $html_inicio_actions='<div class="text-center"><div class="btn-group">
                  <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 
                    &nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
                    &nbsp; Elegir&nbsp;&nbsp;
                  </button><ul class="dropdown-menu pull-right" role="menu">';

                  $html_final_actions='</ul></div></div>';

                  $html_moreInfo='<li>
                  <a data-toggle="modal" href="#modal'.$rfc.'">
                    <i class="icon-magnifier"></i> Ver info.<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></a>
                  </li>';

                  $html_editar='<li><a><input type="radio" id="editar'.$rfc.'" class="editar" name="editar" value="'.$rfc.'">
                  <label for="editar'.$rfc.'">  <i class="fa fa-edit"></i>&nbsp;Modificar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

                  $html_eliminar='<li><a><input type="radio" id="borrar'.$rfc.'" class="borrar" name="borrar" value="'.$rfc.'">
                  <label for="borrar'.$rfc.'" " data-toggle="modal" href="#basic">  <i class="fa fa-trash-o"></i>&nbsp;Eliminar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

                  if($transportistas[0]=='1'||$transportistas[1]=='2'||$transportistas[2]=='3'||$transportistas[3]=='4'){
                    echo $html_inicio_actions;
                  }
                  if($transportistas[0]=='1'){
                   echo $html_moreInfo; 
                 }
                 if($transportistas[2]=='3'){
                  echo $html_editar;
                }
                if($transportistas[3]=='4'){
                  echo $html_eliminar;
                }
                if($transportistas[0]=='1'||$transportistas[1]=='2'||$transportistas[2]=='3'||$transportistas[3]=='4'){
                  echo $html_final_actions;
                }
                ?>

              </td>
            </tr>
            <!-- TERMINA FILAS CON VARIABLES DE FOREACH-->

            <!-- INICIA LLAVE DE FOREACH PARA TABLA DE TRANSPORTISTAS-->
            <?php 
          }
          ?>
          <!-- TERMINA LLAVE DE FOREACH PARA TABLA DE TRANSPORTISTAS-->

        </tbody>
        <!-- TERMINA CUERPO DE DATA TABLE -->

      </table>
      <!-- TERMINA DATA TABLE PARA TABLA DE TRANSPORTISTAS-->
    </div>
    <!-- TERMINA CUERPO DE PORTLET -->
  </div>
  <!-- TERMINA PORTLET-->
</div>
<!-- TERMINAR COLUMNA DE 12 PARA PORTLET-->
</div>
<!-- TERMINA ROW PARA PORTLET-->


<?php

###### FOREACH PARA CONSULTA DE DETALLES DE TRANSPORTISTAS PARA VENTANA MODAL #########
foreach($consultaModal as $row){
  $rfc = $row['rfcTransportista'];
  $nombre = $row['razonSocTransportista'];
  $calle = $row['calleTransportista'];
  $exterior = $row['numeroExtTransportista'];
  $interior = $row['numeroIntTransportista'];
  $colonia = $row['coloniaTransportista'];
  $cPostal = $row['codigoPostalTransportista'];
  $ciudad = $row['ciudadTransportista'];
  $estado = $row['estadoTransportista'];
  $pais = $row['paisTransportista'];
  $contacto = $row['contactoTransportista'];
  $email = $row['emailTransportista'];
  $telefono = $row['telefonoTransportista'];
  $celular = $row['celularTransportista'];
  $pagina = $row['paginaWebTransportista'];
  $idFiscal = $row['idFiscalTransportista'];
  $sccac = $row['sccacTransportista'];
  $caat = $row['caatTransportista'];


  ?>
  <!-- INICIO DE VENTANA MODAL -->
  <div class="modal fade" id="modal<?=$rfc;?>" tabindex="-1" role="basic" aria-hidden="true">

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

          <!-- INICIA TABLA SIMPLE PARA MOSTRAR DETALLES DE PROVEEDORES-->
          <table class="table table-hover">
            <tr>
              <td><strong>Razón social: </strong></td>
              <td><strong><?php echo $nombre;?></strong></td>
            </tr>

            <tr>
              <td>RFC: </td>
              <td><?php echo $rfc;?></td>
            </tr>

            <tr>
              <td>Calle: </td>
              <td><?php echo $calle;?></td>
            </tr>

            <tr>
              <td>Número: </td>
              <td><?php 
                if($interior == 0){
                  echo $exterior;
                }
                else{
                  echo $exterior . "-" . $interior;
                }
                ?></td>
              </tr>

              <tr>
                <td>Colonia: </td>
                <td><?php echo $colonia;?></td>
              </tr>

              <tr>
                <td>Código postal: </td>
                <td><?php echo $cPostal;?></td>
              </tr>

              <tr>
                <td>Ciudad: </td>
                <td><?php echo $ciudad;?></td>
              </tr>

              <tr>
                <td>Estado: </td>
                <td><?php echo $estado;?></td>
              </tr>

              <tr>
                <td>País: </td>
                <td><?php echo $pais;?></td>
              </tr>

              <tr>
                <td>Contacto: </td>
                <td><?php echo $contacto;?></td>
              </tr>

              <tr>
                <td>E-mail: </td>
                <td><?php echo $email;?></td>
              </tr>

              <tr>
                <td>Tel. oficina: </td>
                <td><?php echo "(".$ladafijo.") ".$telfijo;?></td>
              </tr>

              <tr>
                <td>Celular: </td>
                <td><?php echo "(".$ladamovil.") ".$telmovil;?></td>
              </tr>

              <tr>
                <td>Página web: </td>
                <td><?php echo $pagina;?></td>
              </tr>

              <tr>
                <td>ID fiscal: </td>
                <td><?php echo $idFiscal;?></td>
              </tr>

              <tr>
                <td>SCCAC: </td>
                <td><?php echo $sccac;?></td>
              </tr>

              <tr>
                <td>CAAT: </td>
                <td><?php echo $caat;?></td>
              </tr>
            </table>
          </div>
          <!-- TERMINA TABLA SIMPLE PARA DETALLES DE PROVEEDORES-->

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
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE PROVEEDORES #############################################
?>


<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
  $(document).ready(function(){


    $("#back_cat_trans").click(function(){
      window.location = ""
    });

    /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
    $("#gotoTransportista").click(function(){
      $("#mainContent").load( "form_transportistas.php" );
    });


    /* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
    $('.editar').click(function() {
      $("#mainContent").load( "form_transportistas.php?rfc="+$(this).val() );

    });

    /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL TRANSPORTISTA EN CUESTION*/ 
    $(".borrar").click(function(){

      var rfcTransportista = $(this).val();

      swal({
        title: "¿Eliminar transportista?",
        text: "Se eliminará permanentemente",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {
          $.ajax({
            type: "POST",
            url: "../../../controllers/administracion/transportistas/eliminarTransportista.php",
            data:"rfc="+ rfcTransportista
          }).done(function(result){
            swal({
              title: "Eliminado",
              text: "El transportista ha sido eliminado",
              type: "success",
              showCloseButton: true,
              confirmButtonText:'Cerrar'
            });
            $("#mainContent").load( "cat_transportistas.php" );
          });

        } else {
          swal({
            title: "Cancelado",
            text: "Se ha conservado el transportista",
            type: "error",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
        }
      });
    });
  });
</script>

<script src="../../../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>
