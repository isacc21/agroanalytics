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

  $cotizaciones->folio = $_REQUEST['codigo'];
  $lista_cotizaciones = $cotizaciones->consultarDetalle();

  $cliente_cotizaciones = $cotizaciones->consultarCotizacionesxID();

  foreach($cliente_cotizaciones as $row){
    $cliente = $row['rfcCliente'];
  }

  $x=0;


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
<div class="col-md-11">

  <!--INICIA PORTLET-->
  <div class="portlet box grey-mint">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption">Registro de Cotizacion <?echo $_REQUEST['codigo'];?></div>
      <!-- TERMINA TITULO DE PORTLET -->
      <div class="actions btn-set">
        <button type="button" name="back" id="back_form_cotiz" class="btn default blue-stripe">
          <i class="fa fa-arrow-left"></i> Regresar
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
              <select id="cliente" class="form-control" required disabled>
                <option selected disabled value="">Seleccione un cliente</option>
                <?php 
                $clientes=$cotizaciones->consultarClientesAll();
                foreach($clientes as $row){
                  $rfc = $row['rfcCliente'];
                  $nombre = $row['razonSocCliente'];

                  if($cliente == $rfc){
                    $selected_cliente = " selected";
                  }
                  else{
                    $selected_cliente = " ";
                  }

                  ?>
                  <option value="<?=$rfc;?>" <?=$selected_cliente;?>><? echo $nombre;?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- TERMINA INPUT PARA CLIENTE-->

            
            <!-- TERMINA INPUT PARA CLIENTE-->
            <div id="nuevoProducto">

              <?php 
              

              foreach($lista_cotizaciones as $row){
                $producto_registrado = $row['codigoProducto'];
                $cantidad_registrada = $row['cantidadDetalleCotizacion'];
                $unidad_registrada = $row['unidadDetalleCotizacion'];


                echo '<div class="form-group" id="remover'.$x.'">
                <label class="col-md-3 control-label">Productos</label>
                <div class="col-md-3">
                  <select id="producto'.$x.'" class="form-control" required >
                    <option selected disabled value="default">Seleccione</option>';
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
                      }
                      if($producto_registrado == $codigoP){
                        $selected = " selected";
                      }
                      else{
                        $selected = " ";
                      }
                      echo '<option value="'.$codigoP.'" '.$selected.'>'.$nombreP.$preS.'</option>';
                    }
                    echo '</select>
                  </div>
                  <div class="col-md-2">
                    <input type="text" class="form-control" id="cantidad'.$x.'" name="cantidad" value="'.$cantidad_registrada.'" placeholder="Cantidad" required "> 
                  </div>
                  <div class="col-md-2">
                    <select id="unidad'.$x.'" class="form-control" required >
                      <option selected disabled value="default">Seleccione</option>';
                      if($unidad_registrada == "Galones" || $unidad_registrada == "Litros"){
                        $litro = "block";
                        $galon = "block";
                        $metrica = "none";
                        $corta = "none";

                        if($unidad_registrada == "Galones"){
                          $selected_galon = " selected";
                          $selected_litro = "";
                        }
                        if($unidad_registrada == "Litros"){
                          $selected_galon = "";
                          $selected_litro = "selected";
                        }
                      }

                      if($unidad_registrada == "Ton_Metrica" || $unidad_registrada == "Ton_Corta"){
                        $litro = "none";
                        $galon = "none";
                        $metrica = "block";
                        $corta = "block";

                        if($unidad_registrada == "Ton_Metrica"){
                          $selected_metrica = " selected";
                          $selected_corta = "";
                        }
                        if($unidad_registrada == "Ton_Corta"){
                          $selected_metrica = "";
                          $selected_corta = "selected";
                        }
                      }
                      echo '<option id="litro'.$x.'" value="Litros" style="display:'.$litro.'" '.$selected_litro.'>Litros</option>
                      <option id="galon'.$x.'" value="Galones" style="display:'.$galon.'" '.$selected_galon.'>Galones</option>
                      <option id="metrica'.$x.'" value="Ton_Metrica" style="display:'.$metrica.'" '.$selected_metrica.'>Ton. Métrica</option>
                      <option id="corta'.$x.'" value="Ton_Corta" style="display:'.$corta.'" '.$selected_corta.'>Ton. Corta</option>
                    </select>
                  </div>
                  <div class="col-md-1"> 
                    <div class="btn blue-chambray btn-outline" onclick="removerProducto('.$x.')">
                      <i class="glyphicon glyphicon-trash"></i>
                    </div>
                  </div>
                  <br/>
                  <br/>
                  <br />
                  <div id="mensaje'.$x.'" style="display:none">
                    <div class="col-md-1"></div>
                    <div class="alert alert-danger col-md-10 text-center">
                      <strong><div id="text-message'.$x.'"></div></strong>
                    </div>
                  </div>
                </div>';
                $x++;
              }
              ?>
              <input type="hidden" id="equis" value="<?=$x;?>">
              <input type="hidden" id="codigo" value="<?=$_REQUEST['codigo'];?>">

              
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
              <label class="col-md-3 control-label">Ingresa password</label>
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
                  <a href="../cotizaciones" class="btn grey-salsa btn-outline">Cancelar</a>
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


    <script type="text/javascript">

      $(".readonly").keydown(function(e){
        e.preventDefault();
      });

      x = $("#equis").val();
      var falto = 0;

      $("#app_producto").click(function(){
        //alert(x);

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
            }?><option value="<?=$codigoP;?>"><? echo $nombreP.$preS;?></option><?php } ?></select></div><div class="col-md-2"> <input type="text" class="form-control" id="cantidad'+x+'" name="cantidad" value="" placeholder="Cantidad" required "> </div><div class="col-md-2"><select id="unidad'+x+'" class="form-control" required ><option selected disabled value="default">Seleccione</option><option id="litro'+x+'" value="Litros" style="display:none">Litros</option><option id="galon'+x+'" value="Galones" style="display:none">Galones</option><option id="metrica'+x+'" value="Ton_Metrica" style="display:none">Ton. Métrica</option><option id="corta'+x+'" value="Ton_Corta" style="display:none">Ton. Corta</option></select></div><div class="col-md-1"> <div class="btn blue-chambray btn-outline" onclick="removerProducto('+x+')"><i class="glyphicon glyphicon-trash"></i></div></div><br/><br/><br/><div id="mensaje'+x+'" style="display:none"><div class="col-md-1"></div><div class="alert alert-danger col-md-10 text-center"><strong><div id="text-message'+x+'"></div></strong></div></div></div>');

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

          $("#litro"+atrabajar).css("display", "block");
          $("#galon"+atrabajar).css("display", "block");

          $("#metrica"+atrabajar).css("display", "none");
          $("#corta"+atrabajar).css("display", "none");

          //$("#unidad"+atrabajar).children().removeAttr("selected");


          $('#unidad'+atrabajar+' option[value="Litros"]').attr('selected', 'selected');

          break;

          case "Saco":
          case "Súper saco":

          $("#litro"+atrabajar).css("display", "none");
          $("#galon"+atrabajar).css("display", "none");

          $("#metrica"+atrabajar).css("display", "block");
          $("#corta"+atrabajar).css("display", "block");

          //$("#unidad"+atrabajar).children().removeAttr("selected");
          
          $('#unidad'+atrabajar+' option[value="Ton_Metrica"]').attr('selected', 'selected');

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
    url: "../../../controllers/atn-cliente/pedidos/nuevoPedido.php",
    data: "codigos="+$("#codigos").val()+
    "&cantidades="+$("#cantidades").val()+
    "&unidades="+$("#unidades").val()+
    "&codigo="+$("#codigo").val()+
    "&fecha="+$("#fecha").val()+
    "&cliente="+$("#cliente").val()+
    "&pass="+$("#pass").val()
  }).done(function(result){
    if(result=="Pedido establecido"){
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
