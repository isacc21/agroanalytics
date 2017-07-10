<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 16 Febrero 2017 : 23:29                                                            #
#                                                                                    #
###### usuarios/cat_usuarios.php #####################################################
#                                                                                    #
# Archivo sin estructura de la lista de usuario para ser recibido por                #  
# JQuery en index de "Usuarios"                                                      #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 16-FEB-17: 23:32                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
# IJLM - Se agrega estructra TABLE de plantilla                                      #
# IJLM - Se agrega estructura RadioButton + Label para modificar y eliminar          #
# IJLM - Se agrega enlace a script para envio de datos en modificar y eliminar       #
#                                                                                    #
# 17-FEB-17: 13:38                                                                   #
# IJLM - Se quita enlace a script para envio de datos                                #
# IJLM - Se agrega script directo por fallo en envío                                 #
# IJLM - Se actualizaron TH's de acuerdo a la tabla Usuarios                         #
# IJLM - Se agrega INCLUDE para los datos de conexión                                #
# IJLM - Se agrega REQUIRE para libreria de usuarios                                 #
# IJLM - Se agrega objeto USUARIOS para usar métodos                                 #
# IJLM - Se agrega método "consultarUsuarios"                                        #
# IJLM - Se agrega FOREACH para traer los resultados de consulta en BD               #
#                                                                                    #
# 17-FEB-17: 14:21                                                                   #
# IJLM - Tabla Lista de Usuarios funcionando y actualizando                          #
# IJLM - Falta configurar acciones, hacerlo después de del FORM de registro          #
#                                                                                    #
# 20-FEB-17: 15:42                                                                   #
# IJLM - Se agrega AJAX para envio de Id para eliminar                               #
# IJLM - Se agrega AJAX para envio de Id para modificar                              #
# IJLM - Configuracion de javascript para mandar ID por AJAX                         #
#                                                                                    #
# 21-FEB-17: 10:59                                                                   #
# IJLM - Se cambio tabla por elemento DATATABLE, se borro el código de tabla         #
# IJLM - Se agrego script para habilitar el botón "NUEVO +" de la Datatable          #
#                                                                                    #
# 23-FEB-17: 18:08                                                                   #
# IJLM - Se documentó el código completamente para su futuro entendimiento           #
#                                                                                    #
# 27-FEB-17: 13:38                                                                   #
# IJLM - Se cambio el campo NICKNAME por USERNAME                                    #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
#                                                                                    #
# 15-MAR-17: 02:15                                                                   #
# IJLM - Se cambiaron colores de seccion ACCIONES                                    #
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
  $listaUsuarios = $usuarios->consultarUsuariosNA();

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
    $usuarios = $row['usuariosPermiso'];
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




  $html_nuevo='<div class="row">
  <div class="col-md-6">
    <div class="btn-group">
      <button id="gotoForm" class="btn sbold green"> 
        Nuevo <i class="fa fa-plus"></i>
      </button>
    </div>
  </div></div>';


  

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
      <div class="portlet light bordered">

        <!-- INICIA TITULO DE PORTLET-->
        <div class="portlet-title">
          <div class="caption font-dark">
            <i class="icon-settings font-dark"></i>
            <span class="caption-subject bold uppercase"> Catálogo de Usuarios</span>
          </div>

          <div class="actions btn-set">
            <button type="button" name="back" id="back_cat_user" class="btn btn-secondary-outline">
              <i class="fa fa-arrow-left"></i> Regresar
            </button>
          </div>
        </div>
        <!-- TERMINA TITULO DE PORTLET-->

        <!-- INICIA CUERPO DE PORTLET-->
        <div class="portlet-body">
          <div class="table-toolbar">
            <?php
            if($usuarios[1]=='2'){
              echo $html_nuevo;
            }
            ?>
          </div>

          <!-- INICIA DATA TABLE PARA CATALOGO DE USUARIOS-->
          <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
            <thead>
              <tr>
                <!-- INICIA ELEMENTOS DE CABECERA DE DATA TABLE-->
                <th>
                  <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                    <span></span>
                  </label>
                </th>
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
                $apellidoUsuario = $row['apellidosUsuario'];
                $nickname = $row['nickUsuario'];
                $tipo = $row['tipoUsuario'];


                ?>
                <!--TERMINO DE FOREACH PARA TABLA DE USUARIOS-->

                <!--INICIO DE FILA DE RECEPCION DE VALORES DE FOREACH-->
                <tr class="odd gradeX">
                  <td>
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                      <input type="checkbox" class="checkboxes" value="1" />
                      <span></span>
                    </label>
                  </td>
                  <td> <?php echo $nombreUsuario;?> </td>
                  <td> <?php echo $apellidoUsuario;?> </td>
                  <td> <?php echo $nickname;?></td>
                  <td>
                    <?php

                    $html_inicio_actions='<div class="btn-group">
                    <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Acciones
                      <i class="fa fa-angle-down"></i>
                    </button><ul class="dropdown-menu pull-right" role="menu">';

                    $html_final_actions='</ul></div>';

                    $html_permisos='<li><a><input type="radio" id="permisos'.$user.'" class="permisos" name="permisos" value="'.$user.'">
                    <label for="permisos'.$user.'" >  <i class="fa fa-unlock-alt"></i>&nbsp;Permisos </label></a></li>';

                    $html_editar='<li><a><input type="radio" id="editar'.$user.'" class="editar" name="editar" value="'.$user.'">
                    <label for="editar'.$user.'">  <i class="fa fa-edit"></i>&nbsp;Modificar </label></a></li>';

                    $html_eliminar='<li><a><input type="radio" id="borrar'.$user.'" class="borrar" name="borrar" value="'.$user.'">
                    <label for="borrar'.$user.'"> <i class="fa fa-trash-o"></i>&nbsp;Eliminar </label></a></li>';

                    

                    if($acreedores[0]=='1'||$acreedores[1]=='2'||$acreedores[2]=='3'||$acreedores[3]=='4'){
                      echo $html_inicio_actions;
                      echo $html_permisos;
                    }
                    if($usuarios[2]=='3'){
                      echo $html_editar;
                      $_SESSION['boton']=1;
                    }
                    else{
                     $_SESSION['boton']=0; 
                   }
                   if($usuarios[3]=='4'){
                    echo $html_eliminar;
                  }
                  if($acreedores[0]=='1'||$acreedores[1]=='2'||$acreedores[2]=='3'||$acreedores[3]=='4'){
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

    $("#back_cat_user").click(function(){
        window.location = ""
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
        title: "¿Estás seguro eliminar el usuario?",
        text: "Se eliminara el usuario permanentemente",
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
            url: "../../../controllers/administracion/usuarios/eliminarUsuario.php",
            data:"id="+ idUsuario
          }).done(function(result){
            swal("Eliminado", "El usuario ha sido borrado", "success");
            $("#mainContent").load( "cat_usuarios.php" );
          });

        } else {
          swal("Cancelado", "Se ha conservado el usuario", "error");
        }
      });
    });
  });
</script>
<!-- TERMINA SCRIPTS NECESARIOS PARA ENVIAR INFORMACION-->

<!--INICIAN SCRIPTS PARA USO DE DATA TABLES-->
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!--END OWN SCRIPTS-->
<script src="../../../../assets/pages/scripts/table-datatables-managed.min.js" type="text/javascript"></script>
<!-- TERMINAN SCRIPTS PARA USO DE DATA TABLES-->
<?php
}else{
  header("LOCATION: ../../../../index.php");
}
?>