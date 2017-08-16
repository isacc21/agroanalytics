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
 require '../../../models/contabilidad/bancos.php';

 $bancos = new bancos($datosConexionBD);

 $folio = "";
 $dd = "";
 $mm = "";
 $yyyy = "";
 $metpago = "";
 $tipo = "";
 $monto = "";
 $concepto = "";
 $descripcion = "";
 $ingreso ="";
 $egreso ="";
 $ddBanco=date('d');
 $mmBanco =date('m');
 $yyyyBanco=date('Y');

 $nombreSubmit = 'Guardar';

 if(isset($_REQUEST['banco'])){
  $idBanco = $_REQUEST['banco'];
}

//echo $_REQUEST['banco'];

###### SE DETERMINA SI SE ENCUENTRA UN FOLIO ########################################
if (isset($_REQUEST['folio'])){
###### CREACION DEL OBJETO PRODUCTOS PARA UTILIZAR SUS METODOS ######################

  $bancos->folio = $_REQUEST['folio'];
  $result = $bancos->consultarRegistros();


###### FOREACH PARA CONSULTA DE PRODUCTOS EN CASO DE MODIFICAR ######################
  foreach($result as $row){
    $folio = $row['folioBanco'];
    $yyyyBanco = $row['yyyyBanco'];
    $mmBanco = $row['mmBanco'];
    $ddBanco = $row['ddBanco'];
    $metpago = $row['pagoBanco'];
    $tipo = $row['tipoBanco'];
    $monto = $row['montoBanco'];
    $concepto = $row['conceptoBanco'];
    $descripcion = $row['descBanco'];
    $idBanco = $row['idBanco'];
  } ## LLAVE DE FOREACH RESULT #######################################################

###### CONDICIONALES PARA EL CHECKED DE PRESENTACION DEL PRODUCTO ####################

###### CONDICIONALES PARA EL CHECKED DEL TIPO DE PRODUCTO ############################
  if($tipo==1){
    $ingreso="checked";
  }
  else{
    if($tipo == 2){
      $egreso = "checked";
    }
  }



###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
  $(document).ready(function(){

    $(".readonly").keydown(function(e){
      e.preventDefault();
    });

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
      var urlCont = "../../../controllers/contabilidad/bancos/nvoRegistro.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/contabilidad/bancos/actualizaRegistro.php";
    } /* LLAVE DE ELSE */



    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarProduct").submit(function(e){


      /* CONDICIONES PARA EL TIPO DE PRODUCTO*/
      if($("#ingreso").is(':checked')){
        var tipo = "1";
      }
      else{
        if($("#egreso").is(':checked')){
          var tipo = "2";
        }
      }

      var banco = $("#banco").val();

      $.ajax({
        type: "POST",
        url: urlCont,
        data: "fecha="+$("#fecha").val()+
        "&banco="+$("#banco").val()+
        "&metpago="+$("#metpago").val()+
        '&tipo='+ tipo+
        '&monto='+$("#monto").val()+
        '&concepto='+$("#concepto").val()+
        '&descripcion='+$("#descripcion").val()+
        '&folio='+$("#folio").val()

      }).done(function(result){
        if(result=="Registrado exitósamente"||result=="Modificado exitósamente"){
          swal({
            title: result,
            type: "success",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
          $("#mainContent").load( "cat_bancos.php?banco="+banco );
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
            <div class="input-group  date date-picker" data-date="<?=$ddBanco."/".$mmBanco."/".$yyyyBanco;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
              <input type="text" class="form-control readonly"  id="fecha" required value="<?=$ddBanco."/".$mmBanco."/".$yyyyBanco;?>">
              <span class="input-group-btn">
                <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
          </div>
        </div>

        <!-- INICIA INPUT FOLIO-->
        <div class="form-group">
          <label class="col-md-3 control-label">Método de pago</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="metpago" name="metpago" value="<?=$metpago;?>" required>
            <input type="hidden" id="folio" name="folio" value="<?=$folio;?>">
            <input type="hidden" id="banco" name="banco" value="<?=$idBanco;?>">
          </div>
        </div>
        <!-- TERMINA INPUT FOLIO-->

        <!-- INICIA RADIO TIPO-->
        <div class="form-group">
          <label class="control-label col-md-3" >Tipo de registro
          </label>
          <div class="input-group" id="categoria">
            <div class="icheck-inline col-md-12" >
              <label>
                <input type="radio" name="cat" id="ingreso" class="icheck" data-radio="iradio_square-grey" <?echo $ingreso;?> value="liquido" required> Ingreso 
              </label>
              <label>
                <input type="radio" name="cat" id="egreso" class="icheck" data-radio="iradio_square-grey"<?echo $egreso;?> value="solido" > Egreso 
              </label>
            </div>
          </div>
        </div>
        <!-- TERMINA RADIO TIPO-->


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
          <label class="col-md-3 control-label">Concepto</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="concepto" name="concepto" value="<?=$concepto;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE REGISTRO COFEPRIS-->

        <!-- INICIA INPUT DE REGISTRO COFEPRIS-->
        <div class="form-group">
          <label class="col-md-3 control-label">Descripción</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="descripcion" name="descripcion" value="<?=$descripcion;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE REGISTRO COFEPRIS-->


        <div class="text-center">
          <hr>
          <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
          <input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>">
          <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
          <a href="../bancos" class="btn grey-salsa btn-outline">Cancelar</a>
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