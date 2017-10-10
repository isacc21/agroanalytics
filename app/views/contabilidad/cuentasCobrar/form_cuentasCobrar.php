 <link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

 <?php

 error_reporting(E_ALL);
 Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
 date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
 include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
 require '../../../models/contabilidad/cuentasCobrar.php';

 $cuentasCobrar = new cuentasCobrar($datosConexionBD);
 $folio ='';
 $cliente ='';
 $factura ='';
 $remision = '';
 $monto = '';
 $comentario ='';
 $moneda = '';
 $ddCXC=date('d');
 $mmCXC =date('m');
 $yyyyCXC=date('Y');

 $nombreSubmit = 'Guardar';

 if(isset($_REQUEST['moneda'])){
  $divisa = $_REQUEST['moneda'];
}

###### SE DETERMINA SI SE ENCUENTRA UN FOLIO ########################################
if (isset($_REQUEST['folio'])){
###### CREACION DEL OBJETO PRODUCTOS PARA UTILIZAR SUS METODOS ######################

  $cuentasCobrar->folio = $_REQUEST['folio'];
  $result = $cuentasCobrar->consultarCuentasCxID();


###### FOREACH PARA CONSULTA DE PRODUCTOS EN CASO DE MODIFICAR ######################
  foreach($result as $row){
   $folio = $row['folioCuentaC'];
   $ddCXC = $row['ddCuentaC'];
   $mmCXC = $row['mmCuentaC'];
   $yyyyCXC = $row['yyyyCuentaC'];
   $cliente = $row['rfcCliente'];
   $factura = $row['folioFactura'];
   $remision = $row['remisionFactura'];
   $monto = $row['importeCuentaC'];
   $comentario = $row['comentarioCuentaC'];
   $moneda = $row['monedaCuentaC'];
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

    $("#back_form_prod").click(function(){
      window.location = ""
    });

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/contabilidad/cuentasCobrar/nvoRegistro.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/contabilidad/cuentasCobrar/actualizaRegistro.php";
    } /* LLAVE DE ELSE */



    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarProduct").submit(function(e){
      $.ajax({
        type: "POST",
        url: urlCont,
        data: "fecha="+$("#fecha").val()+
        "&cliente="+$("#cliente").val()+
        "&factura="+$("#factura").val()+
        "&folio="+$("#folio").val()+
        "&remision="+$("#remision").val()+
        "&moneda="+$("#moneda").val()+
        "&monto="+$("#monto").val()+
        "&comentario="+$("#comentario").val()+
        "&vieja="+$("#vieja").val()+
        "&pass="+$("#pass").val()

      }).done(function(result){
        if(result=="Registrado exitósamente"||result=="Modificado exitósamente"){
          swal({
            title: result,
            type: "success",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
          var divisa = $("#moneda").val();
          $("#mainContent").load( "cat_cuentasCobrar.php?moneda="+divisa );
        }else{
          swal({
            title: result,
            type: "warning",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
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

<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-12">

 <!--INICIA PORTLET-->
 <div class="portlet  box grey-steel">

  <!--INICIA TITULO DE PORTLET-->
  <div class="portlet-title">

    <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
    <div class="caption"><div class="font-grey-mint"> <b>Registro</b> </div></div>
    <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
    <div class="actions btn-set">
      <button type="button" name="back" id="back_form_prod" class="btn default green-seagreen">
        <i class="fa fa-arrow-left"></i> Regresar
      </button>
    </div>
  </div>
  <!-- TERMINA TITULO DE PORTLET -->

  <!--INICIA CUERPO DE PORTLET-->
  <div class="portlet-body form">


    <!--INICIA FORM-->
    <form class="form-horizontal save-user" id="guardarProduct" >

      <!--INICIAN ESTILOS DE FORM-->
      <div class="form-body">


        <div class="form-group">
          <label class="control-label col-md-3">Fecha</label>
          <div class="col-md-6">
            <div class="input-group  date date-picker" data-date="<?=$ddCXC."/".$mmCXC."/".$yyyyCXC;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
              <input type="text" class="form-control readonly"  id="fecha" required value="<?=$ddCXC."/".$mmCXC."/".$yyyyCXC;?>">
              <span class="input-group-btn">
                <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
          </div>
        </div>

        <!-- INICIA INPUT PARA CLIENTE-->
        <div class="form-group">
          <label class="col-md-3 control-label">Cliente</label>
          <div class="col-md-6">
            <select id="cliente" class="form-control" required >
              <option selected disabled value="">Seleccione un cliente</option>
              <?php 
              $clientes=$cuentasCobrar->consultarClientes();
              foreach($clientes as $row){
                $selected = '';
                $rfc = $row['rfcCliente'];
                $nombre = $row['razonSocCliente'];
                $comercial = $row['comercialCliente'];
                if($rfc == $cliente){
                  $selected = 'selected';
                }
                ?>
                <option value="<?=$rfc;?>" <?=$selected;?>><? echo $comercial;?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <!-- TERMINA INPUT PARA CLIENTE-->

          <!-- INICIA INPUT FOLIO-->
          <div class="form-group">
            <label class="col-md-3 control-label">Folio de factura</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="factura" name="factura" value="<?=$factura;?>" required>
              <input type="hidden" id="folio" name="folio" value="<?=$folio;?>">
              <input type="hidden" id="moneda" name="moneda" value="<?=$divisa;?>">
              <input type="hidden" id="vieja" name="vieja" value="<?=$remision;?>">
            </div>
          </div>
          <!-- TERMINA INPUT FOLIO-->

          <!-- INICIA INPUT PARA CLIENTE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Remisiones</label>
            <div class="col-md-6">
              <select id="remision" class="form-control" >
                <option selected disabled value="">Seleccione una remisión</option>
                <?php 
                if($nombreSubmit == 'Guardar'){
                  $remisiones=$cuentasCobrar->consultarRemisiones();
                }
                else{
                  if($nombreSubmit == 'Actualizar'){
                    $remisiones=$cuentasCobrar->consultarRemisionesAll();
                  }
                }
                
                foreach($remisiones as $row){
                  $selected = '';
                  $folio_rem = $row['folioRemision'];

                  if($folio_rem == $remision){
                    $selected = 'selected';
                  }
                  ?>
                  <option value="<?=$folio_rem;?>" <?=$selected;?>><? echo $folio_rem;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- TERMINA INPUT PARA CLIENTE-->
            <!-- INICIA INPUT PRECIO DE COMPRA-->
            <div class="form-group">
              <label class="col-md-3 control-label">Monto</label>
              <div class="col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="glyphicon glyphicon-usd"></i>
                  </span>
                  <input type="number" step="any" min="0" class="form-control " id="monto" name="monto" value="<?=$monto;?>" required>
                </div>
              </div>
            </div>
            <!-- TERMINA INPUT PRECIO DE COMPRA-->


            <!-- INICIA INPUT DE REGISTRO COFEPRIS-->
            <div class="form-group">
              <label class="col-md-3 control-label">Comentario</label>
              <div class="col-md-6">
                <input type="text" class="form-control " id="comentario" name="comentario" value="<?=$comentario;?>" required>
              </div>
            </div>
            <!-- TERMINA INPUT DE REGISTRO COFEPRIS-->

            <!-- INICIA INPUT FOLIO-->
            <div class="form-group">
              <label class="col-md-3 control-label">Autorización</label>
              <div class="col-md-6">
                <input type="password" class="form-control" id="pass" name="pass" required placeholder="Ingresa tu contraseña">
                <input type="hidden" id="carga" name="carga" value="<?=$codigo;?>">
              </div>
            </div>
            <!-- TERMINA INPUT FOLIO-->


            <div class="text-center">
              <hr>
              <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
              <input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>">
              <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
              <a href="../cuentasCobrar" class="btn grey-salsa btn-outline">Cancelar</a>
            </div>

          </form>
          <!-- TERMINA FORM-->
        </div>
      </div>
      <!-- TERMINA CUERPO DE PORTLET-->
    </div>
    <!-- TERMINA PORTLET-->

    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="../../../../assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="../../../../assets/global/scripts/app.min.js" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="../../../../assets/pages/scripts/form-icheck.min.js" type="text/javascript"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME LAYOUT SCRIPTS -->

    <script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
    <script src="../../../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
    <script src="../../../../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript">