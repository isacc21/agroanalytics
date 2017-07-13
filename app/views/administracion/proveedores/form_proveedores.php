<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 24 Febrero 2017 : 14:05                                                            #
#                                                                                    #
###### proveedores/form_proveedores.php ##############################################
#                                                                                    #
# Archivo sin estructura de la lista de proveedores para ser recibido por            #  
# JQuery en index de "PROVEEDORES"                                                   #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 24-FEB-17: 14:06                                                                   #
# IJLM - Se copia FORMULARIO de acreedores                                           #
# IJLM - Se realizan los cambios pertinentes a la sección proveedores                #
#                                                                                    #
# 24-FEB-17: 14:16                                                                   #
# IJLM - Se terminó de revisar el correcto funcionamiento de cada elemento           #
#                                                                                    #
# 24-FEB-17: 16:08                                                                   #
# IJLM - Se corrigió modificación de RFC, falta actualizar en otras secciones        #
#                                                                                    #
# 25-FEB-17: 07:56                                                                   #
# IJLM - Se cambiaron los input de teléfono y celular por tipo text                  #
#                                                                                    #
# 28-FEB-17: 12:16                                                                   #
# IJLM - Se agregaron campos y variables para CONTACTO                               #
#                                                                                    #
# 15-MAr-17: 02:00                                                                   #
# IJLM - Se cambiaron mensajes de AJAX                                               #
# IJLM - Se cambiaron inputs de EXTERNO, INTERNO Y CP por tipo Text                  #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

##### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ###############################
require '../../../models/administracion/proveedores.php';


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


###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$rfc=(isset($_REQUEST['rfc']))?$_REQUEST['rfc']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN RFC ###########################################
if (isset($_REQUEST['rfc'])){

###### CREACION DEL OBJETO PROVEEODRES PARA UTILIZAR SUS METODOS #####################
  $proveedores = new proveedores($datosConexionBD);
  $proveedores->rfc = $_REQUEST['rfc'];
  $result = $proveedores->consultarProveedoresID();


###### FOREACH PARA CONSULTA DE PROVEEDORES EN CASO DE MODIFICAR #####################
  foreach($result as $row){
    $rfc = $row['rfcProveedor'];
    $nombre = $row['razonSocProveedor'];
    $calle = $row['calleProveedor'];
    $exterior = $row['numeroExtProveedor'];
    $interior = $row['numeroIntProveedor'];
    $colonia = $row['coloniaProveedor'];
    $cPostal = $row['codigoPostalProveedor'];
    $ciudad = $row['ciudadProveedor'];
    $estado = $row['estadoProveedor'];
    $pais = $row['paisProveedor'];
    $contacto = $row['contactoProveedor'];
    $email = $row['emailProveedor'];
    $telefono = $row['telefonoProveedor'];
    $celular = $row['celularProveedor'];
    $pagina = $row['paginaWebProveedor'];

  } ## LLAVE DE FOREACH RESULT #######################################################

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

    $("#back_form_prov").click(function(){
      window.location = "";
    });

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/administracion/proveedores/nuevoProveedor.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/proveedores/actualizarProveedor.php";
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
    $("#guardarProveedor").submit(function(e){
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
        '&pagina='+$("#pagina").val()
      }).done(function(result){
       if(result=="Proveedor registrado exitósamente"||result=="Proveedor modificado exitósamente"){
        swal (result, "", "success");
        $("#mainContent").load( "cat_proveedores.php" );
      }else{
        swal (result, "", "warning");
        
      }
      
    });
      return false;
    });
  });
</script>

<style>
  input[type=number]::-webkit-outer-spin-button,
  input[type=number]::-webkit-inner-spin-button,
  input[type=date]::-webkit-outer-spin-button,
  input[type=date]::-webkit-inner-spin-button{
    -webkit-appearance: none;
    margin: 0;
  }
  input[type=number] {
    -moz-appearance:textfield;
  }
</style>


<!--COLUMNA DE 2 UTILIZADA PARA CENTRAR FORMULARIO-->
<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-12" id="mainContent">

  <!--INICIA PORTLET-->
  <div class="portlet box grey-mint">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption">Registro </div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
      <div class="actions btn-set">
        <button type="button" name="back" id="back_form_prov" class="btn default blue-stripe">
          <i class="fa fa-arrow-left"></i> Regresar
        </button>
      </div>
    </div>
    <!-- TERMINA TITULO DE PORTLET -->

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarProveedor" >

        <!--INICIAN ESTILOS DE FORM-->
        <div class="form-body">

          <!-- INICIA INPUT NOMBRE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Razón Social</label>
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
            <label class="col-md-3 control-label">Número Exterior</label>
            <div class="col-md-6">
              <input type="number" class="form-control " id="exterior" name="exterior" value="<?=$exterior;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT EXTERIOR-->

          <!-- INICIA INPUT INTERIOR-->
          <div class="form-group">
            <label class="col-md-3 control-label">Número Interior</label>
            <div class="col-md-6">
              <input type="number" class="form-control " id="interior" name="interior" value="<?=$interior;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT INTERIOR-->

          <!--INICIA INPUT DE COLONIA -->
          <div class="form-group">
            <label class="col-md-3 control-label">Colonia</label>
            <div class="col-md-6">
              <input type="text" step="any" class="form-control " id="colonia" name="colonia" value="<?=$colonia;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT DE COLONIA-->

          <!-- INICIA INPUT DE CODIGO POSTAL-->
          <div class="form-group">
            <label class="col-md-3 control-label">Código Postal</label>
            <div class="col-md-6">
              <input type="number" class="form-control " id="cPostal" name="cPostal" value="<?=$cPostal;?>" required>
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
              <input type="text" class="form-control " id="estado" name="estado" value="<?=$estado;?>">
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
              <input type="text" step="any" class="form-control " id="telefono" name="telefono" value="<?=$telefono;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT PARA TELEFONO-->

          <!-- INICIA INPUT PARA CELULAR-->
          <div class="form-group">
            <label class="col-md-3 control-label">Celular</label>
            <div class="col-md-6">
              <input type="text " step="any" class="form-control" id="celular" name="celular" value="<?=$celular;?>">
            </div>
          </div>
          <!-- TERMINA INPUT PARA CELULAR-->

          <!-- INICIA INPUT PARA PAGINA WEB-->
          <div class="form-group">
            <label class="col-md-3 control-label">Página Web</label>
            <div class="col-md-6">
              <input type="text" step="any" class="form-control " id="pagina" name="pagina" value="<?=$pagina;?>">
            </div>
          </div>
          <!-- TERMINA INPUT PARA PAGINA WEB-->

          <!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
          <div class="form-actions">
            <div class="row">
              <div class="text-center">

                <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
                <input type="submit" id="accionBoton" class="btn green" value="<?=$nombreSubmit;?>"> 
                
                <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
                <a href="../proveedores" class="btn grey-salsa btn-outline">Cancelar</a>
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

  <!-- COLUMNA DE 2 PARA CENTRAR FORMULARIO-->