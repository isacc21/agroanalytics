 <link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
 <?php
###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
 error_reporting(E_ALL);
 Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
 date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
 include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
 require '../../../models/contabilidad/bancos.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
 $codigo = '';
 $nombre = '';
 $moneda = '';
 $cuenta = '';
 $clabe = '';
 $num_sucursal = '';
 $nom_sucursal = '';
 $num_plaza = '';
 $nom_plaza = '';
 $codigosa = '';

 $pesos ='';
 $dolares = '';


###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
 $codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
 $nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
 if (isset($_REQUEST['codigo'])){

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
  $bancos = new bancos($datosConexionBD);
  $bancos->id = $_REQUEST['codigo'];
  $result = $bancos->consultarBancosID();


###### FOREACH PARA CONSULTA DE ACREEDORES EN CASO DE MODIFICAR ######################
  foreach($result as $row){
    $codigo = $row['idBanco'];
    $nombre = $row['nombreBanco'];
    $moneda = $row['monedaBanco'];
    $cuenta = $row['cuentaBanco'];
    $clabe = $row['clabeBanco'];
    $num_sucursal = $row['numSucursalBanco'];
    $nom_sucursal = $row['nomSucursalBanco'];
    $num_plaza = $row['numPlazaBanco'];
    $nom_plaza = $row['nomPlazaBanco'];
    

    if($moneda == 1){
      $dolares = 'checked';
    }
    else{
      if($moneda == 2){
        $pesos = 'checked';
      }
    }

    if($row['codigoSABanco'] == 'NULL'){
      $codigosa = "";
    }
    else{
      $codigosa = $row['codigoSABanco'];
    }

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


    $("#back_form_bancos").click(function(){
      window.location = ""
    });

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/administracion/bancos/nuevoBanco.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/bancos/actualizarBanco.php";
    } /* LLAVE DE ELSE */


    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarBanco").submit(function(e){

     if($("#pesos").is(':checked')){
      var moneda = "2";}
      else{
        if($("#dolares").is(':checked')){
          var moneda = "1";
        }
      } 

      $.ajax({
        type: "POST",
        url: urlCont,
        data: "nombre="+$("#nombre").val()+
        "&moneda="+moneda+
        "&cuenta="+$("#cuenta").val()+
        "&clabe="+$("#clabe").val()+
        "&numsucursal="+$("#numsucursal").val()+
        "&nomsucursal="+$("#nomsucursal").val()+
        "&numplaza="+$("#numplaza").val()+
        "&nomplaza="+$("#nomplaza").val()+
        "&codigosa="+$("#codigosa").val()+
        "&id="+$("#id").val()
      }).done(function(result){
        if(result=="Banco registrado exitósamente"||result=="Banco modificado exitósamente"){
          swal({
            title: result,
            type: "success",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
          $("#mainContent").load( "cat_bancos.php" );
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
  <div class="portlet  box grey-steel">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

     <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
     <div class="caption"><div class="font-grey-mint"> <b>Registro</b> </div></div>
     <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
     <div class="actions btn-set">
      <button type="button" name="back" id="back_form_bancos" class="btn default green-seagreen">
        <i class="fa fa-arrow-left"></i> Regresar
      </button>
    </div>

  </div>
  <!-- TERMINA TITULO DE PORTLET -->

  <!--INICIA CUERPO DE PORTLET-->
  <div class="portlet-body form">


    <!--INICIA FORM-->
    <form class="form-horizontal save-user" id="guardarBanco" >

      <!--INICIAN ESTILOS DE FORM-->
      <div class="form-body">

        <!-- INICIA INPUT NOMBRE-->
        <div class="form-group">
          <label class="col-md-3 control-label">Nombre de Banco</label>
          <div class="col-md-6">
            <input type="text" class="form-control  " id="nombre" name="nombre" value="<?=$nombre;?>" required>
            <input type="hidden" id="id" name="id" value="<?=$codigo;?>">
          </div>
        </div>
        <!-- TERMINA INPUT NOMBRE-->

        <!--INICIA RADIOS PARA MONEDA-->
        <div class="form-group">
          <label class="control-label col-md-3" >Moneda</label>
          <div class="input-group">
            <div class="icheck-inline col-md-12">
              <label>
                <input type="radio" name="tipo" id="dolares" class="icheck" data-radio="iradio_square-grey" <?echo $dolares;?> required> Dólares 
              </label>
              <label>
                <input type="radio" name="tipo" id="pesos" class="icheck" data-radio="iradio_square-grey" <?echo $pesos;?>> Pesos 
              </label>
            </div>
          </div>
        </div>
        <!--TERMINA RADIOS PARA MONEDA-->

        <!-- INICIA INPUT CALLE-->
        <div class="form-group">
          <label class="col-md-3 control-label">Cuenta</label>
          <div class="col-md-6">
            <input type="text" class="form-control  " id="cuenta" name="cuenta" value="<?=$cuenta;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT CALLE-->

        <!-- INICIA INPUT EXTERIOR-->
        <div class="form-group">
          <label class="col-md-3 control-label">CLABE</label>
          <div class="col-md-6">
            <input type="text" class="form-control  " id="clabe" name="clabe" value="<?=$clabe;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT EXTERIOR-->

        <!-- INICIA INPUT INTERIOR-->
        <div class="form-group">
          <label class="col-md-3 control-label">Sucursal</label>
          <div class="col-md-2">
            <input type="text" step="1" min="0" class="form-control  " id="numsucursal" name="numsucursal" value="<?=$num_sucursal;?>" required placeholder='Número'>
          </div>
          <div class="col-md-4">
            <input type="text" step="1" min="0" class="form-control  " id="nomsucursal" name="nomsucursal" value="<?=$nom_sucursal;?>" required placeholder='Nombre'>
          </div>
        </div>
        <!-- TERMINA INPUT INTERIOR-->

        <!-- INICIA INPUT INTERIOR-->
        <div class="form-group">
          <label class="col-md-3 control-label">Plaza</label>
          <div class="col-md-2">
            <input type="text" step="1" min="0" class="form-control  " id="numplaza" name="numplaza" value="<?=$num_plaza;?>" required placeholder='Número'>
          </div>
          <div class="col-md-4">
            <input type="text" step="1" min="0" class="form-control  " id="nomplaza" name="nomplaza" value="<?=$nom_plaza;?>" required placeholder='Nombre'>
          </div>
        </div>
        <!-- TERMINA INPUT INTERIOR-->

        <!-- INICIA INPUT DE CODIGO POSTAL-->
        <div class="form-group">
          <label class="col-md-3 control-label">Código Switfh / ABA</label>
          <div class="col-md-6">
            <input type="text"  class="form-control" id="codigosa" name="codigosa" value="<?=$codigosa;?>">
          </div>
        </div>
        <!-- TERMINA INPUT DE CODIGO POSTAL-->

        
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