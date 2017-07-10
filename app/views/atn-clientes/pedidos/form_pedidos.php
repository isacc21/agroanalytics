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
require '../../../models/atn-cliente/pedidos.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
$codigo = "";
$cliente = "";
$dd = date('d');
$mm =date('m');
$yyyy = date('Y');
$total = "";

$pedidos = new pedidos($datosConexionBD);

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
if (isset($_REQUEST['codigo'])){

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
  $pedidos = new pedidos($datosConexionBD);

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
  $(document).ready(function(){

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/atn-clientes/pedidos/nuevoPedido.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/acreedores/actualizarAcreedor.php";
    } /* LLAVE DE ELSE */

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
  <div class="portlet box blue-hoki">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption">
        <!-- ICONO Y TEXTO DE TITULO-->
        <i class="fa fa-save"></i> Registro de Pedido 
      </div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->

    </div>
    <!-- TERMINA TITULO DE PORTLET -->

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarCotizacion" >



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


          <!-- INICIA INPUT PARA CLIENTE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Cliente</label>
            <div class="col-md-7">
              <select id="cliente" class="form-control input-circle" required >
                <option selected disabled value="">Seleccione un cliente</option>
                <?php 
                $clientes=$pedidos->consultarClientesAll();
                foreach($clientes as $row){
                  $rfc = $row['rfcCliente'];
                  $nombre = $row['razonSocCliente'];

                  ?>
                  <option value="<?=$rfc;?>"><? echo $nombre;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- TERMINA INPUT PARA CLIENTE-->

            <div class="form-group">
              <label class="col-md-3 control-label">
                <div id="app_producto" class="btn btn-circle blue-chambray btn-outline" >
                  <i class="glyphicon glyphicon-plus"></i>&nbsp;Producto
                  
                </div>
              </label>


            </div>
            <!-- TERMINA INPUT PARA CLIENTE-->
            <div id="nuevoProducto">

              <div class="form-group">

              </div>
            </div>
            <div id="calculos"></div>
            <div class="form-group">
              <label class="col-md-6 control-label">Total</label>
              <div class="col-md-3">
                <input type="text" class="form-control input-circle" id="total" name="total" value="" required placeholder="Calcular total">
              </div>
              <div class="col-md-2">
               <i class="col-md-4 icon-calculator btn btn-icon-only btn-lg white" id="calc_total"></i>          
             </div>
           </div>
           <!-- INICIA INPUT FOLIO DE REGISTRO-->
           <div class="form-group">
            <label class="col-md-3 control-label">Password</label>
            <div class="col-md-7">
              <input type="password" class="form-control input-circle" id="pass" name="pass" required>
            </div>
          </div>
          <!-- TERMINA INPUT FOLIO DE REGISTRO-->


          <!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
          <div class="form-actions">
            <div class="row">
              <div class="col-md-offset-4 col-md-12">

                <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
                <input type="submit" id="accionBoton" class="btn btn-circle green" value="<?=$nombreSubmit;?>"> 

                <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
                <a href="../pedidos" class="btn btn-circle grey-salsa btn-outline">Cancelar</a>
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
  

  <script type="text/javascript">

    $(".readonly").keydown(function(e){
      e.preventDefault();
    });

    x=0;
    $("#app_producto").click(function(){
      $( "#nuevoProducto" ).append('<div class="form-group" id="remover'+x+'"><label class="col-md-3 control-label">Productos</label><div class="col-md-3"><select id="producto'+x+'" class="form-control input-circle" required ><option selected disabled value="">Seleccione</option><?php $productos=$pedidos->consultarProductos();foreach($productos as $row){$codigoP = $row['codigoProducto'];$nombreP = $row['nombreProducto'];?><option value="<?=$codigoP;?>"><? echo $nombreP;?></option><?php } ?></select></div><div class="col-md-3"> <input type="text" class="form-control input-circle" id="cantidad'+x+'" name="cantidad" value="" placeholder="Cantidad" required "></div><div class="col-md-2"> <div class="btn btn-circle blue-chambray btn-outline" onclick="removerProducto('+x+')"><i class="glyphicon glyphicon-trash"></i></div></div></div>');
      x++;
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

    $("#calc_total").click(function(e){

      $("#codigos").remove();
      $("#cantidades").remove();
      e.preventDefault();
      var registros = 0;
      registros = x;

      var codigos = "";
      var cantidades = "";
      var separacion = "*hola*";
      var bander = 0;
      for (var fp = 0; fp < registros; fp++) {
          //alert(productoEliminado[fp]);
          if(productoEliminado[fp]!="no"){
            bander= 0;
          }
          else{
            if(productoEliminado[fp]=="no"){
              bander = 1;
            }
          }
          if(bander==0){
            codigos = codigos + $("#producto"+fp).val() + separacion;
            cantidades = cantidades + $("#cantidad"+fp).val() + separacion;
          }
        }

        $("#nuevoProducto").append( '<input type="hidden" value="'+codigos+'" id="codigos" name="codigos">');
        $("#nuevoProducto").append( '<input type="hidden" value="'+cantidades+'" id="cantidades" name="cantidades">');

        $.ajax({
          type: "POST",
          url: "../../../controllers/atn-cliente/pedidos/calculo.php",
          data: "codigos="+$("#codigos").val()+
          "&cantidades="+$("#cantidades").val()+
          "&codigo="+$("#codigo").val()+
          "&fecha="+$("#fecha").val()+
          "&cliente="+$("#cliente").val()
        }).done(function(result){
         $("#total").val(result);
       });
      });

    $("#guardarCotizacion").submit(function(e){
      $("#codigos").remove();
      $("#cantidades").remove();
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
          codigos = codigos + $("#producto"+fp).val() + separacion;
          cantidades = cantidades + $("#cantidad"+fp).val() + separacion;
        }
      }

      $("#nuevoProducto").append( '<input type="hidden" value="'+codigos+'" id="codigos" name="codigos">');
      $("#nuevoProducto").append( '<input type="hidden" value="'+cantidades+'" id="cantidades" name="cantidades">');

      $.ajax({
        type: "POST",
        url: "../../../controllers/atn-cliente/pedidos/nuevoPedido.php",
        data: "codigos="+$("#codigos").val()+
        "&cantidades="+$("#cantidades").val()+
        "&codigo="+$("#codigo").val()+
        "&fecha="+$("#fecha").val()+
        "&cliente="+$("#cliente").val()+
        "&pass="+$("#pass").val()
      }).done(function(result){
        if(result=="Registro exitoso"){
          swal (result, "", "success");
          $("#mainContent").load( "cat_pedidos.php" );
        }else{
          swal (result, "", "warning");
        } 
      });

    });

  </script>

  <script src="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <script src="../../../../assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
  <script src="../../../../assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript">
