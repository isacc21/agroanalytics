<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 15 Marzo 2017 : 19:55                                                              #
#                                                                                    #
###### usuarios/cat_usuariosAD.php ###################################################
#                                                                                    #
# Archivo sin estructura de la lista de usuario para ser recibido por                #  
# JQuery en index de "Usuarios" para la vista del administrador                      #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 15-MAR-17: 19:54                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
######################################################################################

session_start();
if(isset($_SESSION['login'])){
  $_SESSION['mandar']="Actualizar";

###### DEFINICION DE ZONA HORARIO ####################################################
  date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
  include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
  require '../../../models/administracion/usuarios.php';


###### CREACION DEL OBJETO USUARIOS PARA UTILIZAR METODOS ############################
  $usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE USUARIOS PARA DATA TABLE ##########################################
  $listaUsuarios = $usuarios->consultarUsuarios();

  ###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
  $usuarios->id=$_SESSION['idUsuario'];
  $result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
  foreach ($result as $row){
    $proveedores = $row['proveedoresPermiso'];
    $acreedores = $row['acreedoresPermiso'];
    $transportistas = $row['transportistasPermiso'];
    $clientes = $row['clientesPermiso'];
    $productos = $row['productosPermiso'];
    $usuario = $row['usuariosPermiso'];
    $pedidos = $row['pedidosPermiso'];
    $cotizaciones = $row['cotizacionesPermiso'];
    $importaciones = $row['importacionesPermiso'];
    $declaraciones = $row['declaracionesPermiso'];
    $inventario = $row['inventarioPermiso'];
    $carga = $row['cargaPermiso'];
    $compra = $row['compraPermiso'];
    $remisiones = $row['remisionesPermiso'];
    $bancos = $row['bancosPermiso'];
    $cxc = $row['cxcPermiso'];
    $cxp = $row['cxpPermiso'];
    $idUsuario = $row['idUsuario'];
  }## LLAVE DE FOREACH ###############################################################
  $html_nuevo='<button id="gotoForm" class="btn green-seagreen"> <i class="fa fa-plus"></i>&nbsp;Nuevo </button>'
  ?>

  <!-- SCRIPT PARA USO DE SWEET ALERTS -->
  <link href="../../../../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />

  <!--INICIA ESTILOS PARA RADIO BUTTONS Y LABELS IMPROVISADOS -->
  <style>
    input[type=radio] { display: none }
    label {cursor: pointer}   
  </style>
  <!--TERMINA ESTILOS PARA RADIO BUTTONS Y LABELS IMPROVISADOS -->


  <!--INICIA ROW-->
  <div class="row">

    <!--INICIA COLUMNA DE 12 -->
    <div class="col-md-12">

      <!-- INICIA PORTLET-->
      <div class="portlet box grey-steel">

        <!-- INICIA TITULO DE PORTLET-->
        <div class="portlet-title">
          <div class="caption"><div class="font-grey-mint"> <b>Catálogo</b> </div>
        </div>

        <div class="actions btn-set">
          <?php
          if($usuario[1]=='2'){
            echo $html_nuevo;
          }
          ?>
          <button type="button" name="back" id="back_cat_userad" class="btn default green-seagreen">
            <i class="fa fa-arrow-left"></i> Regresar
          </button>
        </div>
      </div>
      <!-- TERMINA TITULO DE PORTLET-->

      <!-- INICIA CUERPO DE PORTLET-->
      <div class="portlet-body">
        <!-- INICIA DATA TABLE PARA CATALOGO DE USUARIOS-->
        <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
          <thead>
            <tr>
              <!-- INICIA ELEMENTOS DE CABECERA DE DATA TABLE-->

              <th> Nombre(s) </th>
              <th> Apellido(s) </th>
              <th> Username </th>
              <th> Acciones </th>
              <!-- TERMINA ELEMENTOS DE CABECERA DE DATA TABLE-->

            </tr>
          </thead>

          <tbody>
            <!--INICIO DE FOREACH PARA TABLA DE USUARIOS-->
            <?php
            foreach($listaUsuarios as $row){
              $user = $row['idUsuario'];
              $nombreUsuario = $row['nombreUsuario'];
              $apellidosUsuario = $row['apellidosUsuario'];
              $nickname = $row['nickUsuario'];
              $tipo = $row['tipoUsuario'];


              ?>
              <!--TERMINO DE FOREACH PARA TABLA DE USUARIOS-->

              <!--INICIO DE FILA DE RECEPCION DE VALORES DE FOREACH-->
              <tr class="odd gradeX">

                <td> <?php echo $nombreUsuario;?> </td>
                <td> <?php echo $apellidosUsuario;?> </td>
                <td> <?php echo $nickname;?></td>
                <td>
                  <?php

                  $html_inicio_actions='<div class="text-center"><div class="btn-group">
                  <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true"> 
                    &nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
                    &nbsp; Elegir&nbsp;&nbsp;
                  </button><ul class="dropdown-menu pull-right" role="menu">';

                  $html_final_actions='</ul></div></div>';

                  $html_permisos='<li><a><input type="radio" id="permisos'.$user.'" class="permisos" name="permisos" value="'.$user.'">
                  <label for="permisos'.$user.'">  <i class="fa fa-unlock-alt"></i>&nbsp;Permisos<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

                  $html_eliminar='<li><a><input type="radio" id="borrar'.$user.'" class="borrar" name="borrar" value="'.$user.'">
                  <label for="borrar'.$user.'"> <i class="fa fa-trash-o"></i>&nbsp;Eliminar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';



                  if($usuario[0]=='1'||$usuario[1]=='2'||$usuario[2]=='3'||$usuario[3]=='4'){
                    echo $html_inicio_actions;
                    echo $html_permisos;
                  }
                  if($usuario[2]=='3'){
                    echo $html_editar;
                    $_SESSION['boton']=1;
                  }
                  else{
                   $_SESSION['boton']=0; 
                 }
                 if($usuario[3]=='4'){
                  echo $html_eliminar;
                }
                if($usuario[0]=='1'||$usuario[1]=='2'||$usuario[2]=='3'||$usuario[3]=='4'){
                  echo $html_final_actions;
                }
                ?>
              </td>
            </tr>
            <!--TERMINO DE FILA DE RECEPCION DE VALORES DE FOREACH-->

            <!--INICIA LLAVE DE FOREACH PARA TABLA DE USUARIOS-->
            <?php 
          }
          ?>
          <!-- TERMINA LLAVE DE FOREACH PARA TABLA DE USUARIOS-->
        </tbody>
      </table>
      <!-- TERMINA DATATABLE PARA CATALOGO DE USUARIOS-->
    </div>
    <!-- TERMINA CUERPO DE PORTLET-->
  </div>
  <!-- TERMINA PORTLET-->
</div>
<!--TERMINA COLUMNA DE 12-->
</div>
<!-- TERMINAA ROW-->


<!--INICIAN SCRIPTS NECESARIOS PARA ENVIO DE INFORMACION-->
<script>
  $(document).ready(function(){

    $("#back_cat_userad").click(function(){
      window.location = "";
    });

    /* ACCION PARA ENVIO A FORMULARIO EN BLANCO */
    $("#gotoForm").click(function(){
      $("#mainContent").load( "form_usuarios.php" );
    });


    /* ACCION PARA ENVIO DE ID PARA EDITAR INFO DE USUARIO*/
    $('.editar').click(function() {
      $("#mainContent").load( "form_usuarios.php?idUsuario="+$(this).val() );

    });

    /* ACCION PARA ENVIO DE ID PARA EDITAR INFO DE USUARIO*/
    $('.permisos').click(function() {
      $("#mainContent").load( "form_permisos.php?idUsuario="+$(this).val() );

    });

    /* ACCION PARA ENVIO DE ID A RUTA PARA ELIMINAR USUARIO*/
    $(".borrar").click(function(){

      var idUsuario = $(this).val();

      swal({
        title: "¿Estás seguro de eliminar el usuario?",
        text: "Se eliminará el usuario permanentemente",
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
            url: "../../../controllers/administracion/usuarios/eliminarUsuario.php",
            data:"id="+ idUsuario
          }).done(function(result){
            swal({
              title: "Eliminado",
              text: "El usuario ha sido eliminado",
              type: "success",
              showCloseButton: true,
              confirmButtonText:'Cerrar'
            });
            $("#mainContent").load( "catAD_usuarios.php" );
          });

        }
        else {
          swal({
            title: "Cancelado",
            text: "Se ha conservado el usuario",
            type: "error",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
        }
      });
    });
  });
</script>
<!-- TERMINA SCRIPTS NECESARIOS PARA ENVIAR INFORMACION-->


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
<?php
}else{
  header("LOCATION: ../../../../index.php");
}
?>