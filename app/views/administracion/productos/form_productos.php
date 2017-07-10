 <link href="../../../../assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
 <link href="../../../../assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />

 <?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 21 Febrero 2017 : 14:05                                                            #
#                                                                                    #
###### productos/form_productos.php ##################################################
#                                                                                    #
# Archivo sin estructura de la lista de productos para ser recibido por              #  
# JQuery en index de "PRODUCTOS"                                                     #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 21-FEB-17: 13:02                                                                   #
# IJLM - Se copia CATALOGO de usuarios                                               #
# IJLM - Se realizan los cambios pertinentes a la sección productos.                 #
#                                                                                    #
# 23-FEB-17: 14:44                                                                   #
# IJLM - Se finalizó el cambio de parametros en AJAX y variables PHP                 #
# IJLM - Se finalizó el cambio del formulario para la sección de productos           #
#                                                                                    #
# 23-FEB-17: 17:03                                                                   #
# IJLM - Se documentó el código completo para su mejor entendimiento                 #
#                                                                                    #
# 27-FEB-17: 13:25                                                                   #
# IJLM - Se corrigío el problema para el cambio del FOLIO                            #
#                                                                                    #
# 27-FEB-17: 13:38                                                                   #
# IJLM - Se cambio el campo FOLIO por CODIGO                                         #
#                                                                                    #
# 27-FEB-17: 17:54                                                                   #
# IJLM - Se agregaron complementos para utilizar radio buttons                       #
# IJLM - Se agregaron Radio Buttons para seleccionar tipo de producto                #
# IJLM - Se cambio estructura JavaScript para uso de radio buttons                   #
#                                                                                    #
# 27-FEB-17: 22:47                                                                   #
# IJLM - Se modifico el código en la opcion GUARDAR para la nueva tabla              #
#                                                                                    #
# 27-FEB-17: 00:27                                                                   #
# IJLM - Se modificó el código en la opción MOFICIAR para la nueva tabla             #
#                                                                                    #
# 28-FEB-17: 02:06                                                                   #
# IJLM - Se corrigieron errores en los CHECKED de TIPO Y PRESENTACION                #
# IJLM - Se dejaron funcionando CHECKED consultados y para modificar                 #
#                                                                                    #
# 28-FEB-17: 12:58                                                                   #
# IJLM - Se determinaron nuevos mensajes de error al enviar formulario               #
#                                                                                    #
# 15-MAR-17: 01:55                                                                   #
# IJLM - Se cambiaron mensajes en AJAX                                               #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
 error_reporting(E_ALL);
 Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
 date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
 include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
 require '../../../models/administracion/productos.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
 $codigo ="";
 $nombre ="";
 $presentacion ="";
 $tipo ="";
 $caducidad ="0";
 $compra ="";
 $venta ="";
 $cofepris ="";
 $ddCof =date('d');
 $mmCof =date('m');
 $yyyyCof =date('Y');
 $cicoplafest ="";
 $ddCic =date('d');
 $mmCic =date('m');
 $yyyyCic =date('Y');
 $semarnat ="";
 $ddSem =date('d');
 $mmSem =date('m');
 $yyyySem =date('Y');
 $arancel ="";
 $densidad ="";
 $v_liquido ="none";
 $v_solido = "none";

 $cubeta ="";
 $tibor="";
 $tote="";
 $granel="";

 $saco="";
 $superSaco="";

 $organico ="";
 $convencional="";
 $ambos="";

 $liquido ="";
 $solido="";

###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
 $codigo=(isset($_REQUEST['codigo']))?$_REQUEST['codigo']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
 $nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN FOLIO ########################################
 if (isset($_REQUEST['codigo'])){



###### CREACION DEL OBJETO PRODUCTOS PARA UTILIZAR SUS METODOS ######################
  $productos = new productos($datosConexionBD);
  $productos->codigo = $_REQUEST['codigo'];
  $result = $productos->consultarProductosID();


###### FOREACH PARA CONSULTA DE PRODUCTOS EN CASO DE MODIFICAR ######################
  foreach($result as $row){
    $codigo = $row['codigoProducto'];
    $nombre = $row['nombreProducto'];
    $presentacion = $row['presentacionProducto'];
    $tipo = $row['tipoProducto'];
    $caducidad = $row['caducidadProducto'];
    $compra = $row['compraProducto'];
    $distribuidor = $row['ventaDisProducto'];
    $grower = $row['ventaGrwProducto'];
    $cofepris = $row['cofeprisProducto'];
    $ddCof = $row['ddCofProducto'];
    $mmCof = $row['mmCofProducto'];
    $yyyyCof = $row['yyyyCofProducto'];
    $cicoplafest = $row['cicoplafestProducto'];
    $ddCic = $row['ddCicProducto'];
    $mmCic = $row['mmCicProducto'];
    $yyyyCic = $row['yyyyCicProducto'];
    $semarnat = $row['semarnatProducto'];
    $ddSem = $row['ddSemProducto'];
    $mmSem = $row['mmSemProducto'];
    $yyyySem = $row['yyyySemProducto'];
    $arancel = $row['arancelProducto'];
    $densidad = $row['densidadProducto'];

  } ## LLAVE DE FOREACH RESULT #######################################################

###### CONDICIONALES PARA EL CHECKED DE PRESENTACION DEL PRODUCTO ####################
  
  switch($presentacion){
    case 1: 
    $cubeta = "checked";
    $v_liquido = "block";
    $liquido = "checked";
    break;

    case 2: 
    $tibor = "checked";
    $v_liquido = "block";
    $liquido = "checked";
    break;

    case 3:
    $tote = "checked";
    $v_liquido = "block";
    $liquido = "checked";
    break;

    case 4:
    $granel = "checked";
    $v_liquido = "block";
    $liquido = "checked";
    break;

    case 5:
    $saco = "checked";
    $v_solido = "block";
    $solido = "checked";
    break;

    case 6:
    $superSaco = "checked";
    $v_solido = "block";
    $solido = "checked";

  }
  

###### CONDICIONALES PARA EL CHECKED DEL TIPO DE PRODUCTO ############################
  if($tipo==1){
    $organico="checked";
  }
  else{
    if($tipo == 2){
      $convencional = "checked";
    }
    else{
      if($tipo == 3){
        $ambos = "checked";
      }
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


    $('#liquido').on('ifChecked', function(event){
      $("#rb_solidos").css("display", "none");
      $("#rb_liquidos").css("display", "block");
      $('#saco').iCheck('uncheck');
      $("#supersaco").iCheck('uncheck');
    });



    $('#solido').on('ifChecked', function(event){
      $("#rb_liquidos").css("display", "none");
      $("#rb_solidos").css("display", "block");
      $("#cubeta").iCheck('uncheck');
      $("#tote").iCheck('uncheck');
      $("#tibor").iCheck('uncheck');
      $("#granel").iCheck('uncheck');
    });
    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/administracion/productos/nuevoProducto.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/productos/actualizarProducto.php";
    } /* LLAVE DE ELSE */

    $('#decrementar').click(function(){
        //Solo si el valor del campo es diferente de 0
        if ($('#caducidad').val() != 0)
            //Decrementamos su valor
          $('#caducidad').val(parseInt($('#caducidad').val()) - 1);
        });

    $('#incrementar').click(function(){
        //Solo si el valor del campo es diferente de 0
        $('#caducidad').val(parseInt($('#caducidad').val()) + 1);
      });



    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarProduct").submit(function(e){


      /* CONDICIONES PARA EL TIPO DE PRODUCTO*/
      if($("#convencional").is(':checked')){
        var tipo = "2";
      }
      else{
        if($("#organico").is(':checked')){
          var tipo = "1";
        }
        else
        {
          if($("#both").is(':checked')){
            var tipo = "3";
          }
          else{
            var tipo = "<? echo $tipo;?>"
          }
        }
      } 

      /* CONDICIONES PARA LA PRESENTACION DE PRODUCTO*/
      if($("#cubeta").is(':checked')){
        var presentacion = "1";
      }
      else{
        if($("#tibor").is(':checked')){
          var presentacion = "2";
        }
        else
        {
          if($("#tote").is(':checked')){
            var presentacion = "3";
          }
          else{
            if($("#granel").is(':checked')){
              var presentacion = "4";
            }
            else{
              if($("#saco").is(':checked')){
                var presentacion = "5";
              }
              else{
                if($("#supersaco").is(':checked')){
                  var presentacion = "6";
                }
                else{
                  var presentacion = "<?echo $presentacion;?>"    
                }
              }
              
            }
          }
        }
      }

      
      $.ajax({
        type: "POST",
        url: urlCont,
        data: "codigo="+$("#codigo").val()+
        "&viejo="+$("#viejo").val()+
        "&nombre="+$("#nombre").val()+
        '&presentacion='+ presentacion+
        '&tipo='+ tipo+
        '&caducidad='+$("#caducidad").val()+
        '&compra='+$("#compra").val()+
        '&distribuidor='+$("#ventaDistri").val()+
        '&grower='+$("#ventaGrower").val()+
        '&cofepris='+$("#cofepris").val()+
        '&fechaCof='+$("#fechaCof").val()+
        '&cicoplafest='+$("#cicoplafest").val()+
        '&fechaCic='+$("#fechaCic").val()+
        '&semarnat='+$("#semarnat").val()+
        '&fechaSem='+$("#fechaSem").val()+
        '&arancel='+$("#arancel").val()+
        '&densidad='+$("#densidad").val()

      }).done(function(result){
       if(result=="Producto registrado exitósamente"||result=="Producto modificado exitósamente"){
        swal (result, "", "success");
        $("#mainContent").load( "cat_productos.php" );
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

<!-- INICIA COLUMNA DE 8 PARA USO DE FORMULARIO-->
<div class="col-md-12">

  <!--INICIA PORTLET-->
  <div class="portlet box grey-mint">

    <!--INICIA TITULO DE PORTLET-->
    <div class="portlet-title">

      <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
      <div class="caption">Registro </div>
      <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
      <div class="actions btn-set">
        <button type="button" name="back" id="back_form_prod" class="btn default blue-stripe">
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

          <!-- INICIA INPUT FOLIO-->
          <div class="form-group">
            <label class="col-md-3 control-label">Código</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="codigo" name="codigo" value="<?=$codigo;?>" required>
              <input type="hidden" id="viejo" name="viejo" value="<?=$codigo;?>">
            </div>
          </div>
          <!-- TERMINA INPUT FOLIO-->

          

          <!-- INICIA INPUT NOMBRE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Nombre</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="nombre" name="nombre" value="<?=$nombre;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT NOMBRE-->

          

          <!-- INICIA RADIO TIPO-->
          <div class="form-group">
            <label class="control-label col-md-3" >Categoría
            </label>
            <div class="input-group" id="categoria">
              <div class="icheck-inline col-md-12" >
                <label>
                  <input type="radio" name="cat" id="liquido" class="icheck" data-radio="iradio_square-grey" <?echo $liquido;?> value="liquido" required> Líquido 
                </label>
                <label>
                  <input type="radio" name="cat" id="solido" class="icheck" data-radio="iradio_square-grey"<?echo $solido;?> value="solido" > Sólido 
                </label>
              </div>
            </div>
          </div>
          <!-- TERMINA RADIO TIPO-->


          <!-- INICIA RADIO PRESENTACION-->
          <div class="form-group" id="rb_liquidos" style="display:<?=$v_liquido;?>;">
            <label class="control-label col-md-3" >Líquidos
            </label>
            <div class="input-group">
              <div class="icheck-inline col-md-12" >
                <label>
                  <input type="radio" name="presentacion" id="cubeta" class="icheck" data-radio="iradio_square-grey" <?echo $cubeta?> required> Cubeta 
                </label>
                <label>
                  <input type="radio" name="presentacion" id="tibor" class="icheck" data-radio="iradio_square-grey"<?echo $tibor?>> Tibor 
                </label>
                <label>
                  <input type="radio" name="presentacion" id="tote" class="icheck" data-radio="iradio_square-grey" <?echo $tote?>> Tote 
                </label>
                <label>
                  <input type="radio" name="presentacion" id="granel" class="icheck" data-radio="iradio_square-grey" <?echo $granel?>> Granel 
                </label>
              </div>
            </div>
          </div>
          <!-- TERMINA RADIO PRESENTACION-->


          <!-- INICIA RADIO PRESENTACION-->
          <div class="form-group" id="rb_solidos" style="display:<?=$v_solido;?>;">
            <label class="control-label col-md-3" >Sólidos
            </label>
            <div class="input-group">
              <div class="icheck-inline col-md-12" >
                <label>
                  <input type="radio" name="presentacion" id="saco" class="icheck" data-radio="iradio_square-grey" <?echo $saco?> required> Saco 
                </label>
                <label>
                  <input type="radio" name="presentacion" id="supersaco" class="icheck" data-radio="iradio_square-grey"<?echo $superSaco?>> Súper saco 
                </label>
              </div>
            </div>
          </div>
          <!-- TERMINA RADIO PRESENTACION-->

          <!--INICIA RADIOS PARA TIPO DE PRODUCTO-->
          <div class="form-group">
            <label class="control-label col-md-3" >Tipo de producto
            </label>
            <div class="input-group">
              <div class="icheck-inline col-md-12">
                <label>
                  <input type="radio" name="tipo" id="organico" class="icheck" data-radio="iradio_square-grey" <?echo $organico;?> required> Orgánico 
                </label>
                <label>
                  <input type="radio" name="tipo" id="convencional" class="icheck" data-radio="iradio_square-grey" <?echo $convencional;?>> Convencional 
                </label>
                <label>
                  <input type="radio" name="tipo" id="both" class="icheck" data-radio="iradio_square-grey" <?echo $ambos;?>> Ambos 
                </label>
              </div>
            </div>
          </div>
          <!--TERMINA RADIOS PARA TIPO DE PRODUCTO-->

          <!-- INICIA INPUT CADUCIDAD-->
          <div class="form-group">
            <label class="col-md-3 control-label">Ciclo de vida</label>
            <div class="col-md-3">
              <input type="number" class="form-control " id="caducidad" name="caducidad" value="<?=$caducidad;?>" required>
              <span class="help-block">No. de meses </span>
            </div>
            <div class="col-md-2">
             <i class="glyphicon glyphicon-plus btn btn-icon-only btn-lg white" id="incrementar"></i>
             <i class="glyphicon glyphicon-minus btn btn-icon-only btn-lg white" id="decrementar"></i>
             
           </div>
         </div>
         <!-- TERMINA INPUT CADUCIDAD-->

         <!-- INICIA INPUT PRECIO DE COMPRA-->
         <div class="form-group">
          <label class="col-md-3 control-label">Precio de compra</label>
          <div class="col-md-6">
            <input type="number" step="any" min="0" class="form-control " id="compra" name="compra" value="<?=$compra;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT PRECIO DE COMPRA-->

        <!--INICIA INPUT DE PRECIO DE VENTA -->
        <div class="form-group">
          <label class="col-md-3 control-label">Precio de venta | Distribuidor</label>
          <div class="col-md-6">
            <input type="number" step="any" min="0" class="form-control " id="ventaDistri" name="venta" value="<?=$distribuidor;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE PRECIO DE VENTA-->

        <!--INICIA INPUT DE PRECIO DE VENTA -->
        <div class="form-group">
          <label class="col-md-3 control-label">Precio de venta | Grower</label>
          <div class="col-md-6">
            <input type="number" step="any" min="0" class="form-control " id="ventaGrower" name="venta" value="<?=$grower;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE PRECIO DE VENTA-->

        <!-- INICIA INPUT DE REGISTRO COFEPRIS-->
        <div class="form-group">
          <label class="col-md-3 control-label">Número de Registro COFEPRIS</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="cofepris" name="cofepris" value="<?=$cofepris;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE REGISTRO COFEPRIS-->

        <!-- INICIA INPUT PARA FECHA COFEPRIS-->
        <div class="form-group">
          <label class="control-label col-md-3">Vencimiento COFEPRIS</label>
          <div class="col-md-6">
            <div class="input-group  date date-picker" data-date="<?=$ddCof."/".$mmCof."/".$yyyyCof;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
              <input type="text" class="form-control readonly"  id="fechaCof" required value="<?=$ddCof."/".$mmCof."/".$yyyyCof;?>">
              <span class="input-group-btn">
                <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <!-- TERMINA INPUT PARA FECHA COFEPRIS-->


        <!-- INICIA INPUT DE REGISTRO CICOPLAFEST-->
        <div class="form-group">
          <label class="col-md-3 control-label">Registro CICOPLAFEST</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="cicoplafest" name="cicoplafest" value="<?=$cicoplafest;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE REGISTRO CICOPLAFEST-->

        <!-- INICIA INPUT PARA FECHA CICOPLAFEST-->
        <div class="form-group">
          <label class="control-label col-md-3">Vencimiento CICOPLAFEST</label>
          <div class="col-md-6">
            <div class="input-group  date date-picker" data-date="<?=$ddCic."/".$mmCic."/".$yyyyCic;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
              <input type="text" class="form-control readonly"  id="fechaCic" required value="<?=$ddCic."/".$mmCic."/".$yyyyCic;?>">
              <span class="input-group-btn">
                <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <!-- TERMINA INPUT PARA FECHA CICOPLAFEST-->

        <!-- INICIA INPUT DE REGISTRO SEMARNAT-->
        <div class="form-group">
          <label class="col-md-3 control-label">Registro SEMARNAT</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="semarnat" name="semarnat" value="<?=$semarnat;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE REGISTRO SEMARNAT-->

        <!-- INICIA INPUT PARA FECHA SEMARNAT-->
        <div class="form-group">
          <label class="control-label col-md-3">Vencimiento SEMARNAT</label>
          <div class="col-md-6">
            <div class="input-group  date date-picker" data-date="<?=$ddSem."/".$mmSem."/".$yyyySem;?>" data-date-format="dd/mm/yyyy" data-date-viewmode="days">
              <input type="text" class="form-control readonly"  id="fechaSem" required value="<?=$ddSem."/".$mmSem."/".$yyyySem;?>">
              <span class="input-group-btn">
                <button class="btn default" type="button">
                  <i class="fa fa-calendar"></i>
                </button>
              </span>
            </div>
          </div>
        </div>
        <!-- TERMINA INPUT PARA FECHA SEMARNAT-->

        <!-- INICIA INPUT DE FRACCION ARANCELARIA-->
        <div class="form-group">
          <label class="col-md-3 control-label">Fraccion Arancelaria</label>
          <div class="col-md-6">
            <input type="text" step="1" min="0" class="form-control " id="arancel" name="arancel" value="<?=$arancel;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE FRACCION ARANCELARIA-->

        <!-- INICIA INPUT PARA DENSIDAD-->
        <div class="form-group">
          <label class="col-md-3 control-label">Densidad</label>
          <div class="col-md-6">
            <input type="number" step="any" min="0" class="form-control " id="densidad" name="densidad" value="<?=$densidad;?>">
          </div>

        </div>
        <!-- TERMINA INPUT PARA DENSIDAD-->

        <!--INICIA GRUPO DE BOTONES DE FORMULARIO-->
        <div class="form-actions">
          <div class="text-center">
            <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
            <input type="submit" id="accionBoton" class="btn green" value="<?=$nombreSubmit;?>">
            <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
            <a href="../productos" class="btn grey-salsa btn-outline">Cancelar</a>
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