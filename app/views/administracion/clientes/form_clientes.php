<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Marzo 2017 : 10:40                                                              #
#                                                                                    #
###### clientes/form_clientes.php ####################################################
#                                                                                    #
# Archivo sin estructura de la lista de clientes para ser recibido por               #  
# JQuery en index de "CLIENTES"                                                      #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 01-MAR-17: 10:41                                                                   #
# IJLM - Se copia FORMULARIO de proveedores                                          #
# IJLM - Se realizan los cambios pertinentes a la sección clientes                   #
#                                                                                    #
# 15-MAR-17: 01:43                                                                   #
# IJLM - Se corrigio error con boton Cancelar, redireccion a Clientes                #
# IJLM - Se corrigieron mensajes en AJAX de envio.                                   #
# IJLM - Se cambiaron a inputs INTERIOR, EXTERIOR Y CP a tipo Text                   #
######################################################################################


session_start();

###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

##### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ###############################
require '../../../models/administracion/clientes.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
$rfc ="";
$nombre ="";
$calle ="";
$exterior ="";
$interior ="";
$colonia ="";
$cPostal ="";
$ciudad ="";
$estado ="";
$pais ="";
$contacto ="";
$email ="";
$telefono ="";
$celular ="";
$pagina ="";
$tipo ="";
$distribuidor ="";
$gdc="";
$grower="";


###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$rfc=(isset($_REQUEST['rfc']))?$_REQUEST['rfc']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN RFC ###########################################
if (isset($_REQUEST['rfc'])){

###### CREACION DEL OBJETO PROVEEODRES PARA UTILIZAR SUS METODOS #####################
  $clientes = new clientes($datosConexionBD);
  $clientes->rfc = $_REQUEST['rfc'];
  $result = $clientes->consultarClienteID();


###### FOREACH PARA CONSULTA DE PROVEEDORES EN CASO DE MODIFICAR #####################
  foreach($result as $row){
    $rfc = $row['rfcCliente'];
    $nombre = $row['razonSocCliente'];
    $calle = $row['calleCliente'];
    $exterior = $row['numeroExtCliente'];
    $interior = $row['numeroIntCliente'];
    $colonia = $row['coloniaCliente'];
    $cPostal = $row['codigoPostalCliente'];
    $ciudad = $row['ciudadCliente'];
    $estado = $row['estadoCliente'];
    $pais = $row['paisCliente'];
    $contacto = $row['contactoCliente'];
    $email = $row['emailCliente'];
    $telefono = $row['telefonoCliente'];
    $celular = $row['celularCliente'];
    $pagina = $row['paginaWebCliente'];
    $tipo = $row['tipoCliente'];

  } ## LLAVE DE FOREACH RESULT #######################################################

  if($tipo==1){
    $distribuidor = "checked";
  }
  else{
    if($tipo==2){
      $gdc= "checked";
    }
    else{
      if($tipo==3){
        $grower="checked";
      }
    }
  }

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
  $(document).ready(function(){

    $('form').on('focus', 'input[type=number]', function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll')
    })

    $("#back_form_client").click(function(){
      window.location = ""
    });

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/administracion/clientes/nuevoCliente.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/clientes/actualizarCliente.php";
    } /* LLAVE DE ELSE */

    $("#pais").change(function(){
      if($("#pais").val()=="México"||$("#pais").val()=="Mexico"||$("#pais").val()=="mexico"||$("#pais").val()=="méxico"){
        document.getElementById('oculto').style.display = 'block';
        document.getElementById('mostrado').style.display = 'none';
        document.getElementById('estado').value = "";
      }
      else{
        document.getElementById('oculto').style.display = 'none';
        document.getElementById('mostrado').style.display = 'block';
      }
    });


    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarCliente").submit(function(e){

      if($("#distribuidor").is(':checked')){
        var tipo = "1";
      }
      else{
        if($("#gdc").is(':checked')){
          var tipo = "2";
        }
        else{
         if($("#grower").is(':checked')){
          var tipo = "3";
        } 
      }
    }

    $.ajax({
      type: "POST",
      url: urlCont,
      data: "rfc="+$("#rfc").val()+
      "&viejo="+$("#viejo").val()+
      "&nombre="+$("#nombre").val()+
      '&calle='+$("#calle").val()+
      '&exterior='+$("#exterior").val()+
      '&interior='+$("#interior").val()+
      '&colonia='+$("#colonia").val()+
      '&cPostal='+$("#cPostal").val()+
      '&ciudad='+$("#ciudad").val()+
      '&estado='+$("#estado").val()+
      '&estadoMexico='+$("#estadoMexico").val()+
      '&pais='+$("#pais").val()+
      '&contacto='+$("#contacto").val()+
      '&email='+$("#email").val()+
      '&telefono='+$("#telefono").val()+
      '&celular='+$("#celular").val()+
      '&tipo='+tipo+
      '&pagina='+$("#pagina").val()
      
    }).done(function(result){
     if(result=="Cliente registrado exitósamente"||result=="Cliente modificado exitósamente"){
      swal (result, "", "success");
      if(tipo=="2"){
        var rfc = $("#rfc").val();
        $("#mainContent").load( "form_precios.php?rfc="+rfc);  
      }
      else{
        $("#mainContent").load( "cat_clientes.php");
      }
      
    }else{
      swal (result, "", "warning");
      //$("#mainContent").load( "cat_clientes.php");
    }

  });
    return false;
  });
  });
</script>
<style>
  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button{
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance:textfield;
  }
</style>

<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-12">

  <!--INICIA PORTLET-->
  <div class="portlet box grey-mint">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption"> Registro </div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
      <div class="actions btn-set">
      <button type="button" name="back" id="back_form_client" class="btn default blue-stripe">
          <i class="fa fa-arrow-left"></i> Regresar
        </button>
      </div>

    </div>
    <!-- TERMINA TITULO DE PORTLET -->

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarCliente" >

        <!--INICIAN ESTILOS DE FORM-->
        <div class="form-body">

          <!-- INICIA INPUT NOMBRE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Razón social</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="nombre" name="nombre" value="<?=$nombre;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT NOMBRE-->

          <!-- INICIA INPUT RFC-->
          <div class="form-group">
            <label class="col-md-3 control-label">RFC</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="rfc" name="rfc" value="<?=$rfc;?>" required>
              <input type="hidden" id="viejo" class="viejo" value="<?=$rfc;?>" />
            </div>
          </div>
          <!-- TERMINA INPUT RFC-->

          <!-- INICIA INPUT CALLE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Calle</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="calle" name="calle" value="<?=$calle;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT CALLE-->

          <!-- INICIA INPUT EXTERIOR-->
          <div class="form-group">
            <label class="col-md-3 control-label">Número exterior</label>
            <div class="col-md-6">
              <input type="number" step="1" min="0" class="form-control " id="exterior" name="exterior" value="<?=$exterior;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT EXTERIOR-->

          <!-- INICIA INPUT INTERIOR-->
          <div class="form-group">
            <label class="col-md-3 control-label">Número interior</label>
            <div class="col-md-6">
              <input type="number" step="1" min="0" class="form-control " id="interior" name="interior" value="<?=$interior;?>" required>
              <span class="help-block"> Escribir 0 si no existe </span>
            </div>
          </div>
          <!-- TERMINA INPUT INTERIOR-->

          <!--INICIA INPUT DE COLONIA -->
          <div class="form-group">
            <label class="col-md-3 control-label">Colonia</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="colonia" name="colonia" value="<?=$colonia;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT DE COLONIA-->

          <!-- INICIA INPUT DE CODIGO POSTAL-->
          <div class="form-group">
            <label class="col-md-3 control-label">Código postal</label>
            <div class="col-md-6">
              <input type="number" step="1" min="0" class="form-control " id="cPostal" name="cPostal" value="<?=$cPostal;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT DE CODIGO POSTAL-->

          <!-- INICIA INPUT PARA PAIS-->
          <div class="form-group">
            <label class="col-md-3 control-label">País</label>
            <div class="col-md-6">
              <input type="text" step="any" class="form-control " id="pais" name="pais" value="<?=$pais;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT PARA PAIS-->

          <!-- INICIA INPUT PARA ESTAD-->
          <div class="form-group" id="mostrado" style="display:block;">
            <label class="col-md-3 control-label">Estado</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="estado" name="estado" value="<?=$estado;?>" >
            </div>
          </div>
          <!-- TERMINA INPUT PARA ESTAD-->

          <!-- INICIA INPUT PARA ESTAD-->
          <div class="form-group" id="oculto" style="display:none;">
            <label class="col-md-3 control-label">Estado</label>
            <div class="col-md-6">
              <select id="estadoMexico" class="form-control ">
                <option selected disabled value="">Seleccione Estado</option>
                <option value="Aguascalientes">Aguascalientes</option>
                <option value="Baja California">Baja California</option>
                <option value="Baja California Sur">Baja California Sur</option>
                <option value="Campeche">Campeche</option>
                <option value="Ciudad de México">Ciudad de México</option>
                <option value="Coahuila">Coahuila</option>
                <option value="Colima">Colima</option>
                <option value="Chiapas">Chiapas</option>
                <option value="Chihuahua">Chihuahua</option>
                <option value="Durango">Durango</option>
                <option value="Estado de México">Estado de México</option>
                <option value="Guanajuato">Guanajuato</option>
                <option value="Guerrero">Guerrero</option>
                <option value="Hidalgo">Hidalgo</option>
                <option value="Jalisco">Jalisco</option>
                <option value="Michoacán">Michoacán</option>
                <option value="Morelos">Morelos</option>
                <option value="Nayarit">Nayarit</option>
                <option value="Nuevo León">Nuevo León</option>
                <option value="Oaxaca">Oaxaca</option>
                <option value="Puebla">Puebla</option>
                <option value="Querétaro">Querétaro</option>
                <option value="Quintana Roo">Quintana Roo</option>
                <option value="San Luis Potosí">San Luis Potosí</option>
                <option value="Sinaloa">Sinaloa</option>
                <option value="Sonora">Sonora</option>
                <option value="Tabasco">Tabasco</option>
                <option value="Tamaulipas">Tamaulipas</option>
                <option value="Tlaxcala">Tlaxcala</option>
                <option value="Veracruz">Veracruz</option>
                <option value="Yucatán">Yucatán</option>
                <option value="Zacatecas">Zacatecas</option>
              </select>
            </div>
          </div>
          <!-- TERMINA INPUT PARA ESTAD-->

          <!-- INICIA INPUT DE CIUDAD-->
          <div class="form-group">
            <label class="col-md-3 control-label">Ciudad</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="ciudad" name="ciudad" value="<?=$ciudad;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT DE CIUDAD-->


          <!-- INICIA INPUT CONTACTO-->
          <div class="form-group">
            <label class="col-md-3 control-label">Contacto</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="contacto" name="contacto" value="<?=$contacto;?>">
            </div>
          </div>
          <!-- TERMINA INPUT CONTACTO-->

          <!-- INICIA INPUT PARA EMAIL-->
          <div class="form-group">
            <label class="col-md-3 control-label">E-mail</label>
            <div class="col-md-6">
              <input type="email" step="any" class="form-control " id="email" name="email" value="<?=$email;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT PARA EMAIL-->

          <!-- INICIA INPUT PARA TELEFONO-->
          <div class="form-group">
            <label class="col-md-3 control-label">Teléfono</label>
            <div class="col-md-6">
              <input type="number" step="1" min="0" class="form-control " id="telefono" name="telefono" value="<?=$telefono;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT PARA TELEFONO-->

          <!-- INICIA INPUT PARA CELULAR-->
          <div class="form-group">
            <label class="col-md-3 control-label">Celular</label>
            <div class="col-md-6">
              <input type="number" step="1" min="0" class="form-control " id="celular" name="celular" value="<?=$celular;?>">
            </div>
          </div>
          <!-- TERMINA INPUT PARA CELULAR-->

          <!-- INICIA INPUT PARA PAGINA WEB-->
          <div class="form-group">
            <label class="col-md-3 control-label">Página web</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="pagina" name="pagina" value="<?=$pagina;?>">
            </div>
          </div>
          <!-- TERMINA INPUT PARA PAGINA WEB-->

          <!-- INICIA RADIO TIPO-->
          <div class="form-group">
            <label class="control-label col-md-3" >Tipo de cliente
            </label>
            <div class="input-group">
              <div class="icheck-inline col-md-12" >
                <label>
                  <input type="radio" name="tipo" id="distribuidor" class="icheck" data-radio="iradio_square-grey" <?echo $distribuidor;?> required> Distribuidor 
                </label>
                <label>
                  <input type="radio" name="tipo" id="grower" class="icheck" data-radio="iradio_square-grey" <?echo $grower;?> required> Grower 
                </label>
                <label>
                  <input type="radio" name="tipo" id="gdc" class="icheck" data-radio="iradio_square-grey"<?echo $gdc;?>> Global Direct Customer 
                </label>
              </div>
            </div>
          </div>
          <!-- TERMINA RADIO TIPO-->

          <!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
          <div class="form-actions">
            <div class="row">
              <div class="text-center">

                <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
                <input type="submit" id="accionBoton" class="btn green" value="<?=$nombreSubmit;?>"> 
                
                <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
                <a href="../clientes" class="btn grey-salsa btn-outline">Cancelar</a>
              </div>
            </div>
          </div>
          <!--TERMINA GRUPO DE BOTONES DE FORMULARIO-->
        </form>
        <!-- TERMINA FORM-->
      </div>
    </div>
    <!-- TERMINA CUERPO DE PORTLET-->
  </div>
  <!-- TERMINA PORTLET-->


  <script src="../../../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>

  <script src="../../../../assets/global/plugins/jquery.input-ip-address-control-1.0.min.js" type="text/javascript"></script>

  <script src="../../../../assets/pages/scripts/form-input-mask.min.js" type="text/javascript"></script>


  
  <script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN THEME GLOBAL SCRIPTS -->
  <script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
  <!-- END THEME GLOBAL SCRIPTS -->
  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL SCRIPTS -->
  <!-- BEGIN THEME LAYOUT SCRIPTS -->

