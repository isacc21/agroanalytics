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
 require '../../../models/almacen/ordenesCompra.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
 $codigo = "";
 $cliente = "";
 $dd = date('d');
 $mm =date('m');
 $yyyy = date('Y');
 $total = "";

 $ordenesCompra = new ordenesCompra($datosConexionBD);

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
 $codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
 $nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
 if (isset($_REQUEST['codigo'])){

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
  $ordenesCompra = new ordenesCompra($datosConexionBD);

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
  $(document).ready(function(){

   $("#back_form_oc").click(function(){
    window.location = "";
  });

   /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
   if ($("#accionBoton").val() == 'Guardar'){
    var urlCont = "../../../controllers/almacen/ordenesCompra/nuevaOrden.php";
  } /* LLAVE DE IF */

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
  <div class="portlet box grey-steel">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption"><div class="font-grey-mint"> <b>Registro</b> </div></div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
      <div class="actions btn-set">
        <button type="button" name="back" id="back_form_oc" class="btn default green-seagreen">
          <i class="fa fa-arrow-left"></i> Regresar
        </button>
      </div>

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
            <label class="col-md-3 control-label">Proveedor</label>
            <div class="col-md-7">
              <select id="proveedor" class="form-control" required >
                <option selected disabled value="">Seleccione un proveedor</option>
                <?php 
                $proveedores=$ordenesCompra->consultarProveedoresAll();
                foreach($proveedores as $row){
                  $rfc = $row['rfcProveedor'];
                  $nombre = $row['razonSocProveedor'];

                  ?>
                  <option value="<?=$rfc;?>"><? echo $nombre;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- TERMINA INPUT PARA CLIENTE-->

            
            <!-- TERMINA INPUT PARA CLIENTE-->
            <div id="nuevoProducto">

              <div class="form-group" id="remover0">
                <label class="col-md-3 control-label">Productos</label>
                <div class="col-md-3">
                  <select id="producto0" class="form-control" required >
                    <option selected disabled value="default">Seleccione</option>
                    <?php 
                    $productos=$ordenesCompra->consultarProductos();
                    foreach($productos as $row){
                      $codigoP = $row['codigoProducto'];
                      $nombreP = $row['nombreProducto'];
                      $presP = $row['presentacionProducto'];
                      switch($presP){
                        case 1:
                        $preS = " | Cubeta";
                        break;
                        case 2:
                        $preS = " | Tibor";
                        break;
                        case 3:
                        $preS = " | Tote";
                        break;
                        case 4:
                        $preS = " | Granel";
                        break;
                        case 5:
                        $preS = " | Saco";
                        break;
                        case 6:
                        $preS = " | Súper saco";
                        break;
                      }?>
                      <option value="<?=$codigoP;?>"><? echo $nombreP.$preS;?></option>
                      <?php 
                    } 
                    ?>
                  </select>
                </div>
                <div class="col-md-2"> 
                  <input type="text" class="form-control" id="cantidad0" name="cantidad" value="" placeholder="Cantidad" required ">
                </div>
                <div class="col-md-2"> 
                  <input type="text" class="form-control" value="" id="unidad0" disabled placeholder="Unidad">
                </div>
                <div class="col-md-2"> 
                  <div class="btn blue-chambray btn-outline" onclick="removerProducto(0)">
                    <i class="glyphicon glyphicon-trash"></i>
                  </div>
                </div>
              </div>
            </div>
            <div id="calculos"></div>
            <div class="form-group">
              <div class="col-md-7"></div>
              <label class="col-md-3 control-label">
                <div id="app_producto" class="btn blue-chambray btn-outline" >
                  <i class="glyphicon glyphicon-plus"></i>&nbsp;Agregar producto
                </div>
              </label>


            </div>
            <div class="form-group">
              <label class="col-md-6 control-label">Total</label>
              <div class="col-md-4">
                <input type="text" class="form-control" id="total" name="total" value="" required placeholder="Calcular total">
              </div>
            </div>
            <!-- INICIA INPUT FOLIO DE REGISTRO-->
            <div class="form-group">
              <label class="col-md-3 control-label">Autorización</label>
              <div class="col-md-7">
                <input type="password" class="form-control" id="pass" name="pass" required placeholder="Ingresa tu contraseña">
              </div>
            </div>
            <!-- TERMINA INPUT FOLIO DE REGISTRO-->



            <div class="text-center">
              <hr>
              <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
              <input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>"> 

              <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
              <a href="../ordenesCompra" class="btn grey-salsa btn-outline">Cancelar</a>
            </div>
            <!--TERMINA GRUPO DE BOTONES DE FORMULARIO-->
          </form>
          <!-- TERMINA FORM-->
        </div>
      </div>
      <!-- TERMINA CUERPO DE PORTLET-->
    </div>


    <script type="text/javascript">

      $(".readonly").keydown(function(e){
        e.preventDefault();
      });

      x=1;
      $("#app_producto").click(function(){
        $( "#nuevoProducto" ).append('<div class="form-group" id="remover'+x+'"><label class="col-md-3 control-label">Productos</label><div class="col-md-3"><select id="producto'+x+'" class="form-control" required ><option selected disabled value="default">Seleccione</option><?php $productos=$ordenesCompra->consultarProductos();
          foreach($productos as $row){
            $codigoP = $row['codigoProducto'];
            $nombreP = $row['nombreProducto'];
            $presP = $row['presentacionProducto'];
            switch($presP){
              case 1:
              $preS = " | Cubeta";
              break;
              case 2:
              $preS = " | Tibor";
              break;
              case 3:
              $preS = " | Tote";
              break;
              case 4:
              $preS = " | Granel";
              break;
              case 5:
              $preS = " | Saco";
              break;
              case 6:
              $preS = " | Súper saco";
              break;
            }?><option value="<?=$codigoP;?>"><? echo $nombreP.$preS;?></option><?php } ?></select></div><div class="col-md-2"> <input type="text" class="form-control" id="cantidad'+x+'" name="cantidad" value="" placeholder="Cantidad" required "></div><div class="col-md-2"><input type="text" class="form-control" value="" id="unidad'+x+'" disabled placeholder="Unidad"></div><div class="col-md-2"> <div class="btn blue-chambray btn-outline" onclick="removerProducto('+x+')"><i class="glyphicon glyphicon-trash"></i></div></div></div>');
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

      $("#nuevoProducto").change(function(e){

        var registros = 0;
        var atrabajar;
        var selected;

        var vf ="";
        var lim = 0;

        registros = x;



        atrabajar = x-1;

        texto = document.getElementById("producto"+atrabajar);
        selected = texto.options[texto.selectedIndex].text;
        for (var i = 0; i < selected.length; i++){
         if(selected[i] == "|"){
          lim = i+1;
        }
      }
      for (var i = 0; i < selected.length; i++) {
        if (lim<i){
          vf+=selected[i];
        }
      }

      switch(vf){
        case "Cubeta":
        case "Tibor":
        case "Tote":
        case "Granel":
        $("#unidad"+atrabajar).val("GAL.");
        break;

        case "Saco":
        case "Súper saco":
        $("#unidad"+atrabajar).val("Ton. Corta");
        break;
      }

      for (var i = 0; i < registros; i++) {
       var producto = "";
       var conf_del = "";
       var cuenta = "";
       producto = $("#producto"+i).val();
       conf_del = productoEliminado[i];
       if(conf_del == "no"){
        cuenta = "1";
      }
      for (var j = 0; j < registros; j++) {

        if(j!=i && i!=registros && producto == $("#producto"+j).val() && cuenta!== "1" && productoEliminado[j]!="no"){
          $("#producto"+j).val("default");
          swal({
            title: 'Producto ya ingresado',
            type: "warning",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
        }
      }


    }

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
          url: "../../../controllers/almacen/ordenesCompra/calculo.php",
          data: "codigos="+$("#codigos").val()+
          "&cantidades="+$("#cantidades").val()+
          "&codigo="+$("#codigo").val()+
          "&fecha="+$("#fecha").val()+
          "&proveedor="+$("#proveedor").val()
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
          url: "../../../controllers/almacen/ordenesCompra/nuevaOrden.php",
          data: "codigos="+$("#codigos").val()+
          "&cantidades="+$("#cantidades").val()+
          "&codigo="+$("#codigo").val()+
          "&fecha="+$("#fecha").val()+
          "&proveedor="+$("#proveedor").val()+
          "&pass="+$("#pass").val()
        }).done(function(result){
          if(result=="Orden de Compra registrada"){
            swal({
              title: result,
              type: "success",
              showCloseButton: true,
              confirmButtonText:'Cerrar'
            });
            $("#mainContent").load( "cat_ocompras.php" );
          }else{
            swal({
              title: result,
              type: "warning",
              showCloseButton: true,
              confirmButtonText:'Cerrar'
            });
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
