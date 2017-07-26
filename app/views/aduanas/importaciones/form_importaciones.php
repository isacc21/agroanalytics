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

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
 require '../../../models/aduanas/importaciones.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
 $codigo = "";
 $cliente = "";
 $dd = date('d');
 $mm =date('m');
 $yyyy = date('Y');
 $total = "";

 $importaciones = new importaciones($datosConexionBD);

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
 $codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
 $nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
 if (isset($_REQUEST['codigo'])){

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
  $importaciones = new importaciones($datosConexionBD);

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->

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
      <div class="caption">Registro de importacion </div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

    </div>
    <!-- TERMINA TITULO DE PORTLET -->

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarImportacion" >
        <!--INICIAN ESTILOS DE FORM-->
        <div class="form-body">
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

          <!-- TERMINA INPUT PARA CLIENTE-->
          <div id="nuevaFactura">

            <div class="form-group" id="remover0">
              <label class="col-md-3 control-label">Facturas</label>
              <div class="col-md-4">
                <select id="factura0" class="form-control" required >
                  <option selected disabled value="default">Seleccione factura</option>
                  <?php 
                  $facturas=$importaciones->consultarFacturasOC();
                  foreach($facturas as $row){
                    $folio = $row['folioFactura'];
                    ?>
                    <option value="<?=$folio;?>"><? echo $folio;?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-3">
                  <input type="text" class="form-control" id="unitario0" value="" disabled placeholder="Precio de factura">
                </div>
                <div class="col-md-1">
                 <div class="btn blue-chambray btn-outline" onclick="removerProducto(0)">
                   <i class="glyphicon glyphicon-trash"></i>
                 </div>
               </div>
             </div>

           </div>
           <div class="form-group">
            <label class="col-md-10 control-label">
              <div id="app_factura" class="btn blue-chambray btn-outline" >
                <i class="glyphicon glyphicon-plus"></i>&nbsp;Agregar factura
              </div>
            </label>
          </div>
          <div id="calculos"></div>
          <div class="form-group">
            <label class="col-md-6 control-label">Total</label>
            <div class="col-md-4">
              <input type="text" class="form-control" id="total" name="total" value="" required placeholder="Calcular total">

            </div>
          </div>
          <!-- INICIA INPUT FOLIO DE REGISTRO-->
          <div class="form-group">
            <label class="col-md-3 control-label">Password</label>
            <div class="col-md-7">
              <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
          </div>
          <!-- TERMINA INPUT FOLIO DE REGISTRO-->


          <!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
          <div class="form-actions">
            <div class="row">
              <div class="text-center">

                <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
                <input type="submit" id="accionBoton" class="btn green" value="<?=$nombreSubmit;?>"> 

                <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
                <a href="../importaciones" class="btn grey-salsa btn-outline">Cancelar</a>
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

  <script type="text/javascript">
  //$(document).ready(function(){

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/aduanas/importaciones/nuevaOrden.php";
    } /* LLAVE DE IF */
    $(".readonly").keydown(function(e){
      e.preventDefault();
    });

    x=1;
    $("#app_factura").click(function(){

      $( "#nuevaFactura" ).append('<div class="form-group" id="remover'+x+'"><label class="col-md-3 control-label">Facturas</label><div class="col-md-4"><select id="factura'+x+'" class="form-control" required ><option selected disabled value="default">Seleccione facturas</option><?php $facturas=$importaciones->consultarFacturasOC();foreach($facturas as $row){$folio = $row['folioFactura'];?><option value="<?=$folio;?>"><? echo $folio;?></option><?php } ?></select></div><div class="col-md-3"><input type="text" class="form-control" id="unitario'+x+'" value="" disabled placeholder="Precio de factura"></div><div class="col-md-1"> <div class="btn blue-chambray btn-outline" onclick="removerProducto('+x+')"><i class="glyphicon glyphicon-trash"></i></div></div></div>');

      x++;
     //$("#nuevaFactura").append("<h1>DAMN!</h1>")

   });
    productoEliminado = [];
    function removerProducto(numeroElemento){
      $( "#remover"+numeroElemento ).css("display","none");
      productoEliminado[numeroElemento] = "no";

    }

    function revisar(){
      for (var i = 0; i < x; i++) {
        hola = productoEliminado[i];
        alert(hola);
      }
    }

    $("#nuevaFactura").change(function(e){

      var registros = 0;
      registros = x;
      // SCRIPT PARA REVISAR SI HAY REPETIDOS/////////////////////
      for (var i = 0; i < registros; i++) {
       var producto = "";
       var conf_del = "";
       var cuenta = "";
       producto = $("#factura"+i).val();
       conf_del = productoEliminado[i];
       if(conf_del == "no"){
        cuenta = "1";
      }
      for (var j = 0; j < registros; j++) {

        if(j!=i && i!=registros && producto == $("#factura"+j).val() && cuenta!== "1" && productoEliminado[j]!="no"){
          $("#factura"+j).val("default");
          swal("Factura ya ingresada", "", "warning");
        }
      }
    }

    $("#facturas").remove();
    e.preventDefault();
    var registros = 0;
    registros = x;

    var facturas = "";
    var separacion = "*hola*";
    var bander = 0;
    for (var fp = 0; fp < registros; fp++) {

      if(productoEliminado[fp]!="no"){
        bander= 0;
      }
      else{
        if(productoEliminado[fp]=="no"){
          bander = 1;
        }
      }
      if(bander==0){
        facturas = facturas + $("#factura"+fp).val() + separacion;
      }
    }

    $("#nuevaFactura").append( '<input type="hidden" value="'+facturas+'" id="facturas" name="facturas">');

    $.ajax({
      type: "POST",
      url: "../../../controllers/aduanas/importaciones/calculo.php",
      data: "facturas="+$("#facturas").val()
    }).done(function(result){
      $("#total").val('$ ' +result);
    });


    var atrabajar = 0;
    var factura_enviada ="";
    atrabajar = x-1;
    factura_enviada = $("#factura"+atrabajar).val();
    
    $.ajax({
      type: "POST",
      url: "../../../controllers/aduanas/importaciones/precioUnitario.php",
      data: "factura="+factura_enviada
    }).done(function(result){
      $("#unitario"+atrabajar).val('$ ' +result);
    });


  });



    $("#guardarImportacion").submit(function(e){
      $("#app_facturas").remove();
      e.preventDefault();
      var registros = 0;
      registros = x;

      var codigos = "";
      var cantidades = "";
      var separacion = "*hola*";
      var bander = 0;
      for (var fp = 0; fp < registros; fp++) {

        if(productoEliminado[fp]!="no"){
          bander= 0;
        }
        else{
          if(productoEliminado[fp]=="no"){
            bander = 1;
          }
        }
        if(bander==0){
          codigos = codigos + $("#factura"+fp).val() + separacion;

        }
      }

      $("#nuevaFactura").append( '<input type="hidden" value="'+codigos+'" id="facturas" name="facturas">');


      $.ajax({
        type: "POST",
        url: "../../../controllers/aduanas/importaciones/nuevaImportacion.php",
        data: "facturas="+$("#facturas").val()+
        "&codigo="+$("#codigo").val()+
        "&fecha="+$("#fecha").val()+
        "&total="+$("#total").val()+
        "&pass="+$("#pass").val()
      }).done(function(result){
        if(result!="Password no corresponde al usuario activo"||result!="Campos de factura vacios"){
          swal ("Registro exitoso", "", "success");
          $("#mainContent").load( "form_fechas.php?codigo="+result );
        }else{
          swal (result, "", "warning");
        } 
      });

    });
    //});
  </script>


  <script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
  <script src="../../../../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript">
