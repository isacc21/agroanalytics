<link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Abril 2017 : 16:55                                                              #
#                                                                                    #
###### cuentasCobrar/form_cxcD.php ###################################################
#                                                                                    #
# Archivo sin estructura de la lista de acreedores para ser recibido por             #  
# JQuery en index de "Cuentas por Cobrar USD"                                        #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 02-ABR-17: 16:56                                                                   #
# IJLM - Se copia FORMULARIO de Bancos USD                                           #
# IJLM - Se realizan los cambios pertinentes a la sección Cuentas por cobrar USD.    #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
require '../../../models/aduanas/declaraciones.php';
$declaraciones = new declaraciones($datosConexionBD);

###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
$codigo ="";
$dd =date('d');
$mm = date('m');
$yyyy=date('Y');


###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';

?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
  $(document).ready(function(){

    $(".readonly").keydown(function(e){
      e.preventDefault();
    });

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/aduanas/declaraciones/nuevaDeclaracion.php";
    }


    $('#tanque').on('ifChecked', function(event){
      $("#placas").css("display", "block");
      $("#noeco").css("display", "block");
      $("#txtplaca").text("Placas tanque");
      $("#txtnoeco").text("No. económico tanque");
    });

    $('#plataforma').on('ifChecked', function(event){
      $("#placas").css("display", "block");
      $("#noeco").css("display", "block");
      $("#txtplaca").text("Placas plataforma");
      $("#txtnoeco").text("No. económico plataforma");
      $("#placasplat").prop("required", true);
      $("#noecoplat").prop("required", true);
    });

    $('#rabon').on('ifChecked', function(event){
      $("#placas").css("display", "none");
      $("#noeco").css("display", "none");
      $("#placasplat").removeAttr("required");
      $("#noecoplat").removeAttr("required");
    });



    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarCXC").submit(function(e){

      /* CONDICIONES PARA EL TIPO DE PRODUCTO*/
      if($("#tanque").is(':checked')){
        var tipo = "1";
      }
      else{
        if($("#plataforma").is(':checked')){
          var tipo = "2";
        }
        else
        {
          if($("#rabon").is(':checked')){
            var tipo = "3";
          }
        }
      } 

      $.ajax({
        type: "POST",
        url: urlCont,
        data: "fecha="+$("#fecha").val()+
        '&importacion='+$("#importacion").val()+
        '&transportista='+$("#transportista").val()+
        '&tipo='+tipo+
        '&placasmx='+$("#placasmx").val()+
        '&placasus='+$("#placasus").val()+
        '&noecotracto='+$("#noecotracto").val()+
        '&placasplat='+$("#placasplat").val()+
        '&noecoplat='+$("#noecoplat").val()+
        '&peso='+$("#peso").val()+
        '&pass='+$("#pass").val()
      }).done(function(result){
        if(result=="Declaración registrada"){
          swal (result, "", "success");
          $("#mainContent").load( "cat_declaraciones.php" );
        }else{
          swal (result, "", "warning");
          $("#mainContent").load( "cat_importaciones.php" );
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

<div class="col-md-12">

  <!--INICIA PORTLET-->
  <div class="portlet box grey-mint">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption">Nueva declaración de aduanas </div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

    </div>
    <!-- TERMINA TITULO DE PORTLET -->

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarCXC" >

        <!--INICIAN ESTILOS DE FORM-->
        <div class="form-body">

          <!-- INICIA INPUT FOLIO-->

          <input type="hidden" id="importacion" name="importacion" value="<?=$codigo;?>">
          <!-- TERMINA INPUT FOLIO-->

          <!-- INICIA INPUT FECHA-->
          <div class="form-group">
            <label class="control-label col-md-3">Fecha</label>
            <div class="col-md-7">
              <div class="input-group  date date-picker" data-date="<?=$dd."/".$mm."/".$yyyy;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
                <input type="text" class="form-control readonly"  id="fecha" required value="<?=$dd."/".$mm."/".$yyyy;?>">
                <span class="input-group-btn">
                  <button class="btn default" type="button">
                    <i class="fa fa-calendar"></i>
                  </button>
                </span>
              </div>
            </div>
          </div>
          <!-- TERMINA INPUT FECHA-->

          <!-- INICIA INPUT PARA CLIENTES-->
          <div class="form-group">
            <label class="col-md-3 control-label">Transportistas</label>
            <div class="col-md-7">
              <select id="transportista" class="form-control" required >
                <option selected disabled value="">Seleccione un transportista</option>
                <?php 
                $trans=$declaraciones->consultarTransportistas();
                foreach($trans as $row){
                  $rfc = $row['rfcTransportista'];
                  $nombre = $row['razonSocTransportista'];
                  ?>
                  <option value="<?=$rfc;?>" ><? echo $nombre;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- TERMINA INPUT PARA CLIENTES-->
            <!--INICIA RADIOS PARA TIPO DE PRODUCTO-->
            <div class="form-group">
              <label class="control-label col-md-3" >Tipo de transporte
              </label>
              <div class="input-group">
                <div class="icheck-inline col-md-12">
                  <label>
                    <input type="radio" name="tipo" id="tanque" class="icheck" data-radio="iradio_square-grey" required> Tanque 
                  </label>
                  <label>
                    <input type="radio" name="tipo" id="plataforma" class="icheck" data-radio="iradio_square-grey" > Plataforma 
                  </label>
                  <label>
                    <input type="radio" name="tipo" id="rabon" class="icheck" data-radio="iradio_square-grey"> Rabón 
                  </label>
                </div>
              </div>
            </div>
            <!--TERMINA RADIOS PARA TIPO DE PRODUCTO-->


            <!--INICIA INPUT DE PLACAS MEXICANAS -->
            <div class="form-group">
              <label class="col-md-3 control-label">Placas MX Tractocamión</label>
              <div class="col-md-7">
                <input type="text" class="form-control" id="placasmx" name="placasmx" required> 
              </div>
            </div>
            <!-- TERMINA INPUT DE PLACAS MEXICANAS-->


            <!-- INICIA INPUT PLACAS AMERICANAS-->
            <div class="form-group">
              <label class="col-md-3 control-label">Placas US Tractocamión</label>
              <div class="col-md-7">
                <input type="text" step="any" min="0" class="form-control" id="placasus" name="placasus" required>
              </div>
            </div>
            <!-- TERMINA INPUT PLACAS AMERICANAS-->   

            <!-- INICIA INPUT DE NUMERO ECONOMICO TRACTO-->
            <div class="form-group" >
              <label class="col-md-3 control-label">No. Económico Tractocamión</label>
              <div class="col-md-7">
                <input type="text" class="form-control" id="noecotracto" name="noecotracto" required>
              </div>
            </div>
            <!-- TERMINA INPUT DE NUMERO ECONOMICO TRACTO-->


            <!-- INICIA INPUT DE PLACAS PLATAFORMA-->
            <div class="form-group" style="display:none" id="placas">
              <label class="col-md-3 control-label"><div id="txtplaca">plataforma</div></label>
              <div class="col-md-7">
                <input type="text" class="form-control" id="placasplat" name="placasplat" required>
              </div>
            </div>
            <!-- TERMINA INPUT DE PLACAS PLATAFORMA-->


            <!-- INICIA INPUT DE NUMERO ECONOMICO PLATAFORMA-->
            <div class="form-group" style="display:none;" id="noeco">
              <label class="col-md-3 control-label"><div id="txtnoeco">plataforma</div></label>
              <div class="col-md-7">
                <input type="text" class="form-control" id="noecoplat" name="noecoplat" required>
              </div>
            </div>
            <!-- TERMINA INPUT DE NUMERO ECONOMICO PLATAFORMA-->


            <!-- INICIA INPUT PARA PAIS-->
            <div class="form-group">
              <label class="col-md-3 control-label">Password</label>
              <div class="col-md-7">
                <input type="password" class="form-control" id="pass" name="pass" required>
              </div>
            </div>
            <!-- TERMINA INPUT PARA PAIS-->

            <!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
            <div class="form-actions">
              <div class="row">
                <div class="col-md-offset-4 col-md-12">

                  <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
                  <input type="submit" id="accionBoton" class="btn btn-circle green" value="<?=$nombreSubmit;?>"> 

                  <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
                  <a href="../declaraciones" class="btn btn-circle grey-salsa btn-outline">Cancelar</a>
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

    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>


    <script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="../../../../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript">