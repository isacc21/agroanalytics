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
 require '../../../models/atn-cliente/cotizaciones.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
 $codigo = "";
 $cliente = "";
 $dd = date('d');
 $mm =date('m');
 $yyyy = date('Y');
 $total = "";

 $cotizaciones = new cotizaciones($datosConexionBD);

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
 $codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
 $nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO #########################################
 if (isset($_REQUEST['codigo'])){

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR SUS METODOS ######################
  $cotizaciones = new cotizaciones($datosConexionBD);

###### EN CASO DE QUE SE HAGA EL PROCESO DENTRO DEL IF, SE CAMBIA LA VARIABLE ########
  $nombreSubmit = 'Actualizar';
} ###### LLAVE DE IF PARA CONSULTAR SI EXISTE EL FOLIO ###############################
?>

<!-- SCRIPTS NECESARIOS PARA BOTONES DE ACCIONES-->
<script type="text/javascript">
  $(document).ready(function(){

   $("#back_form_cotiz").click(function(){
    window.location = "";
  });

   /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
   if ($("#accionBoton").val() == 'Guardar'){
    var urlCont = "../../../controllers/atn-clientes/cotizaciones/nuevaCoti.php";
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
  <div class="portlet  box grey-steel">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption"><div class="font-grey-mint"> <b>Registro</b> </div></div>
      <!-- TERMINA TITULO DE PORTLET -->
      <div class="actions btn-set">
        <button type="button" name="back" id="back_form_cotiz" class="btn green-seagreen">
          <i class="fa fa-arrow-left"></i>&nbsp;Regresar
        </button>
      </div>
    </div>
    

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarCotizacion" >
        <input type="hidden" id="prod_faltante" value="">



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
              <select id="cliente" class="form-control" required >
                <option selected disabled value="">Seleccione un cliente</option>
                <?php 
                $clientes=$cotizaciones->consultarClientesAll();
                foreach($clientes as $row){
                  $rfc = $row['rfcCliente'];
                  $nombre = $row['razonSocCliente'];
                  $comercial = $row['comercialCliente'];

                  ?>
                  <option value="<?=$rfc;?>"><? echo $comercial;?></option>
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
                    $productos=$cotizaciones->consultarProductos();
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
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <input type="text" class="form-control" id="cantidad0" name="cantidad" value="" placeholder="Cantidad" required "> 
                  </div>
                  <div class="col-md-2">
                    <select disabled id="unidad0" class="form-control" required >
                      <option selected disabled value="default">Seleccione</option>
                      <option id="litro0" value="Litros" style="display:none">Litros</option>
                      <option id="galon0" value="Galones" style="display:none">Galones</option>
                      <option id="metrica0" value="Ton_Metrica" style="display:none">Ton. Métrica</option>
                      <option id="corta0" value="Ton_Corta" style="display:none">Ton. Corta</option>
                    </select>
                  </div>
                  <div class="col-md-1"> 
                    <div class="btn blue-chambray btn-outline" onclick="removerProducto(0)">
                      <i class="glyphicon glyphicon-trash"></i>
                    </div>
                  </div>
                  <br/>
                  <br/>
                  <br />
                  <div id="mensaje0" style="display:none">
                    <div class="col-md-1"></div>
                    <div class="alert alert-danger col-md-10 text-center">
                      <strong><div id="text-message0"></div></strong>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-10 control-label">
                  <div id="app_producto" class="btn blue-chambray btn-outline" >
                    <i class="glyphicon glyphicon-plus"></i>&nbsp;Agregar producto
                  </div>
                </label>
              </div>
              <div class="form-group">
                <label class="col-md-6 control-label">Total</label>
                <div class="col-md-4">
                  <input type="text" class="form-control" id="total" name="total" value="" required placeholder="Calcular total" readonly>
                </div>
              </div>
              <!-- INICIA INPUT FOLIO DE REGISTRO-->
              <div class="form-group">
                <label class="col-md-3 control-label">Autorización</label>
                <div class="col-md-7">
                  <input type="password" class="form-control" id="pass" name="pass" required placeholder="Ingresa tu password">
                </div>
              </div>
              <!-- TERMINA INPUT FOLIO DE REGISTRO-->
              <div class="text-center">
                <hr>
                <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
                <input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>"> 

                <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
                <a href="../cotizaciones" class="btn grey-salsa btn-outline">Cancelar</a>
              </div>
              <!--TERMINA GRUPO DE BOTONES DE FORMULARIO-->
            </form>
            <!-- TERMINA FORM-->
          </div>
        </div>
        <!-- TERMINA CUERPO DE PORTLET-->
      </div>
      <!-- TERMINA PORTLET-->


      <script type="text/javascript">

        $(".readonly").keydown(function(e){
          e.preventDefault();
        });

        x=1;
        var falto = 0;

        $("#app_producto").click(function(){

          $( "#nuevoProducto" ).append('<div class="form-group" id="remover'+x+'"><label class="col-md-3 control-label">Productos</label><div class="col-md-3"><select id="producto'+x+'" class="form-control" required ><option selected disabled value="default">Seleccione</option><?php 
            $productos=$cotizaciones->consultarProductos();
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
              }?><option value="<?=$codigoP;?>"><? echo $nombreP.$preS;?></option><?php } ?></select></div><div class="col-md-2"> <input type="text" class="form-control" id="cantidad'+x+'" name="cantidad" value="" placeholder="Cantidad" required "> </div><div class="col-md-2"><select disabled id="unidad'+x+'" class="form-control" required ><option selected disabled value="default">Seleccione</option><option id="litro'+x+'" value="Litros" style="display:none">Litros</option><option id="galon'+x+'" value="Galones" style="display:none">Galones</option><option id="metrica'+x+'" value="Ton_Metrica" style="display:none">Ton. Métrica</option><option id="corta'+x+'" value="Ton_Corta" style="display:none">Ton. Corta</option></select></div><div class="col-md-1"> <div class="btn blue-chambray btn-outline" onclick="removerProducto('+x+')"><i class="glyphicon glyphicon-trash"></i></div></div><br/><br/><br/><div id="mensaje'+x+'" style="display:none"><div class="col-md-1"></div><div class="alert alert-danger col-md-10 text-center"><strong><div id="text-message'+x+'"></div></strong></div></div></div>');
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


          // SCRIPT PARA CAMBIAR UNIDAD DE LOS PRODUCTOS///////////
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

          //$("#litro"+atrabajar).css("display", "block");
          $("#galon"+atrabajar).css("display", "block");

          $("#metrica"+atrabajar).css("display", "none");
          $("#corta"+atrabajar).css("display", "none");

          //$("#unidad"+atrabajar).children().removeAttr("selected");


          $('#unidad'+atrabajar+' option[value="Galones"]').attr('selected', 'selected');

          break;

          case "Saco":
          case "Súper saco":

          $("#litro"+atrabajar).css("display", "none");
          $("#galon"+atrabajar).css("display", "none");

          //$("#metrica"+atrabajar).css("display", "block");
          $("#corta"+atrabajar).css("display", "block");

          //$("#unidad"+atrabajar).children().removeAttr("selected");
          
          $('#unidad'+atrabajar+' option[value="Ton_Corta"]').attr('selected', 'selected');

          break;
        }
        $.ajax({
          type: "POST",
          url: "../../../controllers/atn-cliente/cotizaciones/inventario.php",
          data: "producto="+$("#producto"+atrabajar).val()+
          "&cantidad="+$("#cantidad"+atrabajar).val()+
          "&unidad="+$("#unidad"+atrabajar).val()+
          "&cliente="+$("#cliente").val()
        }).done(function(result){
          if(result!="Inventario insuficiente"){
            if(result=="No hay producto"){
              $("#mensaje"+atrabajar).css("display", "block");
              $("#text-message"+atrabajar).text("No hay existencia de este producto");
              $("#prod_faltante").val("1");
            }
            else{
              if(result=="Introduce una cantidad"){
                $("#mensaje"+atrabajar).css("display", "none");
              }
              else{
                $("#mensaje"+atrabajar).css("display", "block");
                $("#text-message"+atrabajar).text("Faltan "+result+" para surtir el producto");
                $("#prod_faltante").val("1");

              }
            }
            
          }
          else{
           $("#mensaje"+atrabajar).css("display", "none");
         }
       });

        // SCRIPT PARA REVISAR SI HAY REPETIDOS/////////////////////
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
            swal("Producto ya ingresado", "", "warning");
          }
        }


      }






      $("#codigos").remove();
      $("#cantidades").remove();
      $("#unidades").remove();
      e.preventDefault();
      var registros = 0;
      registros = x;

      var codigos = "";
      var cantidades = "";
      var unidades = "";
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
            unidades = unidades + $("#unidad"+fp).val() + separacion;
          }
        }

        $("#nuevoProducto").append( '<input type="hidden" value="'+codigos+'" id="codigos" name="codigos">');
        $("#nuevoProducto").append( '<input type="hidden" value="'+cantidades+'" id="cantidades" name="cantidades">');
        $("#nuevoProducto").append( '<input type="hidden" value="'+unidades+'" id="unidades" name="unidades">');

        $.ajax({
          type: "POST",
          url: "../../../controllers/atn-cliente/cotizaciones/calculo.php",
          data: "codigos="+$("#codigos").val()+
          "&cantidades="+$("#cantidades").val()+
          "&unidades="+$("#unidades").val()+
          "&codigo="+$("#codigo").val()+
          "&fecha="+$("#fecha").val()+
          "&cliente="+$("#cliente").val()
        }).done(function(result){
          if(result != "Seleccione un cliente"){
            if(result == "Ingrese una cantidadRegistro exitoso"){
              swal("Ingrese una cantidad", "", "warning");
            }
            else{
             $("#total").val(result);
           }
         }
         else{
          swal(result, "", "warning");
        }
      });

      });







 $("#accionBoton").click(function(e){
  $("#codigos").remove();
  $("#cantidades").remove();
  $("#unidades").remove();
  e.preventDefault();
  var registros = 0;
  registros = x;

  var codigos = "";
  var cantidades = "";
  var unidades = "";
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
      unidades = unidades + $("#unidad"+fp).val() + separacion;
    }
  }

  $("#nuevoProducto").append( '<input type="hidden" value="'+codigos+'" id="codigos" name="codigos">');
  $("#nuevoProducto").append( '<input type="hidden" value="'+cantidades+'" id="cantidades" name="cantidades">');
  $("#nuevoProducto").append( '<input type="hidden" value="'+unidades+'" id="unidades" name="unidades">');

  $.ajax({
    type: "POST",
    url: "../../../controllers/atn-cliente/cotizaciones/nuevaCotizacion.php",
    data: "codigos="+$("#codigos").val()+
    "&cantidades="+$("#cantidades").val()+
    "&unidades="+$("#unidades").val()+
    "&codigo="+$("#codigo").val()+
    "&fecha="+$("#fecha").val()+
    "&cliente="+$("#cliente").val()+
    "&pass="+$("#pass").val()
  }).done(function(result){
    if(result=="Registro exitoso"){
      swal({
        title: result,
        type: "success",
        showCloseButton: true,
        confirmButtonText:'Cerrar'
      });
      $("#mainContent").load( "cat_cotizaciones.php" );
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
