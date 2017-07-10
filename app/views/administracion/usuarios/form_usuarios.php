<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 17 Febrero 2017 : 16:02                                                            #
#                                                                                    #
###### usuarios/form_usuarios.php ####################################################
#                                                                                    #
# Archivo sin estructura del formuario de usuario para ser recibido por              #  
# JQuery en index de "Usuarios"                                                      #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 17-FEB-17: 15:58                                                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
# IJLM - Se agrega estructra FORM de plantilla                                       #
# IJLM - Se agregaron los campos necesarios para registro de usuarios                #
# IJLM - Se agrega INCLUDE para los datos de conexión                                #
# IJLM - Se agrega REQUIRE para libreria de usuarios                                 #
# IJLM - Se agrega estructura para determinar si es guardar o actualizar             #
# IJLM - Se agrega estructura para recibir datos de otro archivo                     #
# IJLM - Se agrega AJAX para enviar datos para guardar o actualizar                  #
#                                                                                    #
# 20-FEB-17: 11:28                                                                   #
# IJLM - Se agrega una nueva estructura para el envio de datos                       #
# IJLM - Se modifica AJAX para envio de datos                                        #
#                                                                                    #
# 21-FEB-17: 17:03                                                                   #
# IJLM - Se agregó un campo al formulario para confirmar el NICK de usuario          #
#                                                                                    #
# 23-FEB-17: 17:31                                                                   #
# IJLM - Se documentó el código para su futuro entendimiento                         #
#                                                                                    #
# 27-FEB-17: 13:38                                                                   #
# IJLM - Se cambio el campo NICKNAME por USERNAME                                    #
#                                                                                    #
# IJLM - CODIGO COMPLETO POR EL MOMENTO, NO MODIFICAR EL CODIGO EXISTENTE            #
#                                                                                    #
# 15-MAR-17: 02:17                                                                   #
# IJLM - Se cambio codigo de mensajes AJAX
######################################################################################

###### ESTRUCTURA DE CODIGO PARA IMPRIMIR ERRORES ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/usuarios.php';


###### CREACION DE VARIABLES PARA EVITAR ERRORES #####################################
$nombre="";
$apellidos="";
$nick="";
$password="";
$repetir ="";

###### RECEPCION DE ID USUARIO #######################################################
$idUsuario=(isset($_REQUEST['idUsuario']))?$_REQUEST['idUsuario']:"";

###### VALOR DE BOTON DE FORMULARIO ##################################################
$nombreSubmit = 'Guardar';


###### IF EN CASO DE QUE SE RECIBA UN DATO ###########################################
if (isset($_REQUEST['idUsuario'])){

###### CREACION DEL OBJETO USUARIOS ##################################################
  $usuarios = new usuarios($datosConexionBD);

###### SE ENVIA VARIABLE DE ID USUARIO PARA BUSCAR ELEMENTOS REPETIDOS ###############
  $usuarios->id = $_REQUEST['idUsuario'];

###### RESULTADO DE CONSULTA DEL METODO CONSULTAR USUARIOS POR ID ####################
  $result = $usuarios->consultarUsuariosID();


###### FOREACH DE CONSULTA EN BASE DE DATOS ##########################################
  foreach($result as $row){
    $idUsuario = $row['idUsuario'];
    $nombre = $row['nombreUsuario'];
    $apellidos = $row['apellidosUsuario'];
    $nick = $row['nickUsuario'];
    $password = $row['passwordUsuario'];
  }## LLAVE DE FOREACH ###############################################################

###### NOMBRE DE BOTON EN CASO DE QUE LO ANTERIOR SE CUMPLA ##########################
  $nombreSubmit = 'Actualizar';
} ## LLAVE DE IF DE RECEPCION ########################################################
?>

<!-- SCRIPTS NECESIARIOS PARA ENVIO DE INFO-->
<script type="text/javascript">
  $(document).ready(function(){

    /*VARIABLES DE URL PARA ENVIO DE INFO */
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/administracion/usuarios/nuevoUsuario.php";
    } /* LLAVE DE IF */
    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/usuarios/actualizarUsuario.php";
    } /* LLAVE DE ELSE */


    /* AJAX PARA ENVIO DE INFORMACION DE ACUERDO A LA RUTA*/
    $("#guardarUser").submit(function(e){
      $.ajax({
        type: "POST",
        url: urlCont,
        data: "id="+$("#id").val()+
        "&nombre="+$("#nombre").val()+
        '&apellidos='+$("#apellidos").val()+
        '&nick='+$("#nick").val()+
        '&repetir='+$("#repetir").val()+
        '&viejo='+$("#viejo").val()+
        '&password='+$("#password").val()
      }).done(function(result){
       if(result=="Usuario registrado exitósamente"||result=="Usuario modificado exitósamente"){
        swal (result, "", "success");
        $("#mainContent").load( "form_permisos.php?idUsuario="+$("#id").val() );

      }else{
        swal (result, "", "warning");
      }
      
    });
      return false;
    });
  });
</script>


<!-- COLUMNA DE 8 -->
<div class="col-md-12">

  <!-- INICIA PORTLET -->
  <div class="portlet box grey-mint">

    <!-- INICIA TITULO DE PORTLET-->
    <div class="portlet-title">
      <div class="caption">Registro </div>
    </div>
    <!-- TERMINA TITULO DE PORTLET-->


    <!-- INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!-- INICIO DE  FORM-->
      <form class="form-horizontal save-user" id="guardarUser" >
        <div class="form-body">
          <!-- INICIA INPUT NOMBRE-->
          
          <div class="form-group">
            <label class="col-md-3 control-label">Nombre(s)</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="nombre" name="nombre" value="<?=$nombre;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT NOMBRE-->

          <!-- INICIA INPUT APELLIDOS-->
          <div class="form-group">
            <label class="col-md-3 control-label">Apellido(s)</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="apellidos" name="apellidos" value="<?=$apellidos;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT APELLIDOS-->


          <!--INICIA INPUT NICK 1-->
          <div class="form-group">
            <label class="col-md-3 control-label">Username</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="nick" name="nick" value="<?=$nick;?>" required>
              <input type="hidden" id="viejo" value="<?=$nick;?>">
            </div>
          </div>
          <!--TERMINA INPUT NICK 1-->

          <!-- INICIA INPUT NICK 2-->
          <div class="form-group">
            <label class="col-md-3 control-label">Confirmar Username</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="repetir" name="repetir" value="<?=$nick;?>" required>
            </div>
          </div>
          <!--TERMINA INPUT NICK 2-->

          <!--INICIA INPUT CONTRASEÑA-->
          <div class="form-group">
            <label class="col-md-3 control-label">Contraseña</label>
            <div class="col-md-6">
              <input type="password" class="form-control " id="password" name="password" value="<?=$password;?>" required>
              <input type="hidden" id="id" name="id" value="<?=$idUsuario;?>">
            </div>
          </div>
          
          <!--TERMINA INPUT CONTRASEÑA -->
        </div>
        <!--INICIA SECCION DE BOTONES-->
        <div class="form-actions">
          <div class="row">
            <div class="text-center">

              <!--BOTON DE GUARDAR O ACTUALIZAR-->
              <input type="submit" id="accionBoton" class="btn  green" value="<?=$nombreSubmit;?>"> 
              <!--BOTON PARA REGRESAR AL INICIO-->
              <a href="../usuarios" class="btn  grey-salsa btn-outline">Cancelar</a>
            </div>
          </div>
        </div>
        <!--TERMINA SECCION DE BOTONES-->

      </form>
      <!-- TERMINA FORM-->
    </div>
    <!--TERMINA CUERPO DE PORTLET-->

  </div>
  <!-- TERMINA PORTLET-->
</div>
<!--TERMINA COLUMNA DE 8-->
