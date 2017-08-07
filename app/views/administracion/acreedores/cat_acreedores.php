<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 23 Febrero 2017 : 19:41                                                            #
#                                                                                    #
###### acreedores/cat_acreedores.php #################################################
#                                                                                    #
# Archivo sin estructura del formulario de acreedores para ser recibido por          #  
# JQuery en index de "Acreedores"                                                    #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 23-FEB-17: 21:27                                                                   #
# IJLM - Se copia CATALOGO de productos                                              #
# IJLM - Se realizan los cambios pertinentes a la sección acreedores.                #
#                                                                                    #
# 24-FEB-17: 10:04                                                                   #
# IJLM - Se terminó de revisar el correcto funcionamiento de cada elemento           #
#                                                                                    #
# 28-FEB-17: 12:16                                                                   #
# IJLM - Se agregaron campos y variables para CONTACTO                               #
# IJLM - Se agrego código para validar si existe número interior o no y mostrarlo    #
#                                                                                    #
# 15-MAR-17: 01:38                                                                   #
# IJLM - Se cambiaron los colores de los botones de acción.                          #
######################################################################################


###### DEFINICION DE ZONA HORARIO ####################################################
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
  include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
  require '../../../models/administracion/acreedores.php';
  require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
  $acreedores = new acreedores($datosConexionBD);
  $usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
  $listaAcreedores = $acreedores->consultarAcreedores();


###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
  $consultaModal = $acreedores->consultarAcreedores();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
  $usuarios->id=$_SESSION['idUsuario'];
  $result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
  foreach ($result as $row){
    $acreedores = $row['acreedoresPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_nuevo='<button id="gotoAcreedores" class="btn green-seagreen"><i class="fa fa-plus"></i>&nbsp;Nuevo</button>';
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
  <div class="row">
    <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet box grey-steel">
        <div class="portlet-title">

         <div class="caption"><div class="font-grey-mint"> <b>Catálogo</b> </div>

       </div>
       <div class="actions btn-set">
        <?php 
        if($acreedores[1]=='2'){
          echo $html_nuevo;
        } ?>
        <button type="button" name="back" id="back_cat_acre" class="btn green-seagreen">
          <i class="fa fa-arrow-left"></i>&nbsp;Regresar
        </button>


      </div>

    </div>
    <div class="portlet-body">
      <!-- INICIA ENCABEZADO DE CUERPO DE PORTLET-->

      <!-- TERMINA ENCABEZADO DE CUERPO DE PORTLET-->
      <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
        <thead>
          <tr>
            <th> Razón social </th>
            <th> RFC </th>
            <th> Teléfono </th>
            <th> Celular </th>
            <th> Acciones </th>
          </tr>
        </thead>
        <tbody>

          <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
          <?php
          foreach($listaAcreedores as $row){
            $rfc = $row['rfcAcreedor'];
            $nombre = $row['razonSocAcreedor'];
            $email = $row['emailAcreedor'];
            $telefono = $row['telefonoAcreedor'];
            $celular = $row['celularAcreedor'];

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
            <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

            <!-- INICIA FILA CON VARIABLES DE FOREACH-->
            <tr class="odd gradeX">


              <td> <?php echo $nombre;?> </td>
              <td> <?php echo $rfc; ?> </td>
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

                if($acreedores[0]=='1'||$acreedores[1]=='2'||$acreedores[2]=='3'||$acreedores[3]=='4'){
                  echo $html_inicio_actions;
                }
                if($acreedores[0]=='1'){
                 echo $html_moreInfo; 
               }
               if($acreedores[2]=='3'){
                echo $html_editar;
              }
              if($acreedores[3]=='4'){
                echo $html_eliminar;
              }
              if($acreedores[0]=='1'||$acreedores[1]=='2'||$acreedores[2]=='3'||$acreedores[3]=='4'){
                echo $html_final_actions;
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
    </table>
  </div>
</div>
</div>
</div>
<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($consultaModal as $row){
  $rfc = $row['rfcAcreedor'];
  $nombre = $row['razonSocAcreedor'];
  $calle = $row['calleAcreedor'];
  $exterior = $row['numeroExtAcreedor'];
  $interior = $row['numeroIntAcreedor'];
  $colonia = $row['coloniaAcreedor'];
  $cPostal = $row['codigoPostalAcreedor'];
  $ciudad = $row['ciudadAcreedor'];
  $estado = $row['estadoAcreedor'];
  $pais = $row['paisAcreedor'];
  $contacto = $row['contactoAcreedor'];
  $email = $row['emailAcreedor'];
  $telefono = $row['telefonoAcreedor'];
  $celular = $row['celularAcreedor'];
  $pagina = $row['paginaWebAcreedor'];


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

          <!-- INICIA TABLA SIMPLE PARA MOSTRAR DETALLES DE ACREEDORES-->
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
                <td> <?php echo "(".$ladafijo.") ".$telfijo;?></td>
              </tr>

              <tr>
                <td>Celular: </td>
                <td> <?php echo "(".$ladamovil.") ".$telmovil;?></td>
              </tr>

              <tr>
                <td>Página web: </td>
                <td><?php echo $pagina;?></td>
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
?>


<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
  $(document).ready(function(){

   $("#back_cat_acre").click(function(){
    window.location = ""
  });

   /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
   $("#gotoAcreedores").click(function(){
    $("#mainContent").load( "form_acreedores.php" );
  });


   /* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
   $('.editar').click(function() {
    $("#mainContent").load( "form_acreedores.php?rfc="+$(this).val() );

  });

   /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
   $(".borrar").click(function(){

    var rfcAcreedor = $(this).val();

    swal({
      title: "¿Eliminar acreedor?",
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
          url: "../../../controllers/administracion/acreedores/eliminarAcreedor.php",
          data:"rfc="+ rfcAcreedor
        }).done(function(result){
          swal({
            title: "Eliminado",
            text: "El acreedor ha sido eliminado",
            type: "success",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
          $("#mainContent").load( "cat_acreedores.php" );
        });

      } else {
       swal({
        title: "Cancelado",
        text: "Se ha conservado el acreedor",
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


<!-- TERMINAN SCRIPTS PARA EL FUNCIONAMIENTO DE DATA TABLES-->
<?php
}else{
  header("LOCATION: ../../../../index.php");
}
?>