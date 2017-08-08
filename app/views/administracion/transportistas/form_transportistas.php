<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 28 Febrero 2017 : 22:44                                                            #
#                                                                                    #
###### transportistas/form_transportistas.php ########################################
#                                                                                    #
# Archivo sin estructura de la lista de transportistas para ser recibido por         #
# JQuery en index de "PROVEEDORES"                                                   #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 28-FEB-17: 22:45                                                                   #
# IJLM - Se copia FORMULARIO de proveedores                                          #
# IJLM - Se realizan los cambios pertinentes a la sección transportistas             #
#                                                                                    #
# 15-MAR-17: 02:11                                                                   #
# IJLM - Se cambian mensajes de AJAX                                                 #
# IJLM - Se cambian inputs INTERIOR, EXTERIOR Y CP por tipo Text                     #
# IJLM - Se modifico redireccion en boton cancelar.                                  #
######################################################################################



###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

##### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ###############################
require '../../../models/administracion/transportistas.php';


###### DEFINICION DE VARIABLES PARA EVITAR ERRORES ###################################
$rfc ="";
$nombre ="";
$calle ="";
$exterior ="";
$interior ="";
$colonia ="";
$cPostal ="";
$ciudad ="";
$estado ="";
$pais ="";
$contacto ="";
$email ="";
$telefono ="";
$celular ="";
$pagina ="";
$idFiscal = "";
$sccac = "";
$caat ="";
$ladafijo ="";
$ladamovil ="";
$telfijo="";
$telmovil="";

$abreF="";
$abreM="";

$cierraF="";
$cierraM="";


###### RECEPCION DE VARIABLE EN CASO DE MODIFICACION #################################
$rfc=(isset($_REQUEST['rfc']))?$_REQUEST['rfc']:"";


###### VARIABLE PARA BOTON DE FORM EN CASO FORM EN BLANCO ############################
$nombreSubmit = 'Guardar';


###### SE DETERMINA SI SE ENCUENTRA UN RFC ###########################################
if (isset($_REQUEST['rfc'])){

###### CREACION DEL OBJETO PROVEEODRES PARA UTILIZAR SUS METODOS #####################
  $transportistas = new transportistas($datosConexionBD);
  $transportistas->rfc = $_REQUEST['rfc'];
  $result = $transportistas->consultarTransportistaID();


###### FOREACH PARA CONSULTA DE PROVEEDORES EN CASO DE MODIFICAR #####################
  foreach($result as $row){
    $rfc = $row['rfcTransportista'];
    $nombre = $row['razonSocTransportista'];
    $calle = $row['calleTransportista'];
    $exterior = $row['numeroExtTransportista'];
    $interior = $row['numeroIntTransportista'];
    $colonia = $row['coloniaTransportista'];
    $cPostal = $row['codigoPostalTransportista'];
    $ciudad = $row['ciudadTransportista'];
    $estado = $row['estadoTransportista'];
    $pais = $row['paisTransportista'];
    $contacto = $row['contactoTransportista'];
    $email = $row['emailTransportista'];
    $telefono = $row['telefonoTransportista'];
    $celular = $row['celularTransportista'];
    $pagina = $row['paginaWebTransportista'];
    $idFiscal=$row['idFiscalTransportista'];
    $sccac=$row['sccacTransportista'];
    $caat=$row['caatTransportista'];

  } ## LLAVE DE FOREACH RESULT #######################################################

  for ($i=0; $i <(strlen($telefono)) ; $i++) { 
    if($telefono[$i]=="("){
      $abreF = $i;
    }
    if($telefono[$i]==")"){
      $cierraF = $i;
    }
  }

  for ($i=($abreF+1); $i < $cierraF ; $i++) { 
    $ladafijo .= $telefono[$i];
  }
  for ($i=($cierraF+1); $i < (strlen($telefono)); $i++) { 
    $telfijo .= $telefono[$i];
  }
  

  for ($i=0; $i <(strlen($celular)) ; $i++) { 
    if($celular[$i]=="("){
      $abreM = $i;
    }
    if($celular[$i]==")"){
      $cierraM = $i;
    }
  }

  for ($i=($abreM+1); $i < $cierraM ; $i++) { 
    $ladamovil .= $celular[$i];
  }
  for ($i=($cierraM+1); $i < (strlen($celular)); $i++) { 
    $telmovil .= $celular[$i];
  }

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


    $("#back_form_trans").click(function(){
      window.location = ""
    });

    /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
    if ($("#accionBoton").val() == 'Guardar'){
      var urlCont = "../../../controllers/administracion/transportistas/nuevoTransportista.php";
    } /* LLAVE DE IF */


    else if($("#accionBoton").val() == 'Actualizar'){
      var urlCont = "../../../controllers/administracion/transportistas/actualizarTransportista.php";
    } /* LLAVE DE ELSE */

    $("#pais").change(function(){
      if($("#pais").val()=="México"||$("#pais").val()=="Mexico"||$("#pais").val()=="mexico"||$("#pais").val()=="méxico"||$("#pais").val()=="MEXICO"||$("#pais").val()=="MÉXICO"){
        document.getElementById('oculto').style.display = 'block';
        document.getElementById('mostrado').style.display = 'none';
        document.getElementById('estado').value = "";
      }
      else{
        document.getElementById('oculto').style.display = 'none';
        document.getElementById('mostrado').style.display = 'block';
      }
    });


    /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
    $("#guardarTrans").submit(function(e){
      $.ajax({
        type: "POST",
        url: urlCont,
        data: "rfc="+$("#rfc").val()+
        "&viejo="+$("#viejo").val()+
        "&nombre="+$("#nombre").val()+
        '&calle='+$("#calle").val()+
        '&exterior='+$("#exterior").val()+
        '&interior='+$("#interior").val()+
        '&colonia='+$("#colonia").val()+
        '&cPostal='+$("#cPostal").val()+
        '&ciudad='+$("#ciudad").val()+
        '&estado='+$("#estado").val()+
        '&estadoMexico='+$("#estadoMexico").val()+
        '&pais='+$("#pais").val()+
        '&contacto='+$("#contacto").val()+
        '&email='+$("#email").val()+
        '&ladafijo='+$("#ladafijo").val()+
        '&telefono='+$("#telefono").val()+
        '&ladamovil='+$("#ladamovil").val()+
        '&celular='+$("#celular").val()+
        '&pagina='+$("#pagina").val()+
        '&idFiscal='+$("#idFiscal").val()+
        '&sccac='+$("#sccac").val()+
        '&caat='+$("#caat").val()
      }).done(function(result){
       if(result=="Transportista registrado exitósamente"||result=="Transportista modificado exitósamente"){
        swal({
          title: result,
          type: "success",
          showCloseButton: true,
          confirmButtonText:'Cerrar'
        });
        $("#mainContent").load( "cat_transportistas.php" );
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
        <button type="button" name="back" id="back_form_trans" class="btn default green-seagreen">
          <i class="fa fa-arrow-left"></i> Regresar
        </button>
      </div>
    </div>
    <!-- TERMINA TITULO DE PORTLET -->

    <!--INICIA CUERPO DE PORTLET-->
    <div class="portlet-body form">


      <!--INICIA FORM-->
      <form class="form-horizontal save-user" id="guardarTrans" >

        <!--INICIAN ESTILOS DE FORM-->
        <div class="form-body">

          <!-- INICIA INPUT NOMBRE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Razón Social</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="nombre" name="nombre" value="<?=$nombre;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT NOMBRE-->

          <!-- INICIA INPUT RFC-->
          <div class="form-group">
            <label class="col-md-3 control-label">RFC</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="rfc" name="rfc" value="<?=$rfc;?>" required>
              <input type="hidden" id="viejo" class="viejo" value="<?=$rfc;?>" />
            </div>
          </div>
          <!-- TERMINA INPUT RFC-->

          <!-- INICIA INPUT CALLE-->
          <div class="form-group">
            <label class="col-md-3 control-label">Calle</label>
            <div class="col-md-6">
              <input type="text" class="form-control " id="calle" name="calle" value="<?=$calle;?>" required>
            </div>
          </div>
          <!-- TERMINA INPUT CALLE-->

          <!-- INICIA INPUT EXTERIOR-->
          <div class="form-group">
            <label class="col-md-3 control-label">Número exterior</label>
            <div class="col-md-6">
             <input type="text" class="form-control  " id="exterior" name="exterior" value="<?=$exterior;?>" required>
           </div>
         </div>
         <!-- TERMINA INPUT EXTERIOR-->

         <!-- INICIA INPUT INTERIOR-->
         <div class="form-group">
          <label class="col-md-3 control-label">Número interior</label>
          <div class="col-md-6">
            <input type="number" step="1" min="0" class="form-control " id="interior" name="interior" value="<?=$interior;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT INTERIOR-->

        <!--INICIA INPUT DE COLONIA -->
        <div class="form-group">
          <label class="col-md-3 control-label">Colonia</label>
          <div class="col-md-6">
            <input type="text" step="any" class="form-control " id="colonia" name="colonia" value="<?=$colonia;?>">
          </div>
        </div>
        <!-- TERMINA INPUT DE COLONIA-->

        <!-- INICIA INPUT DE CODIGO POSTAL-->
        <div class="form-group">
          <label class="col-md-3 control-label">Código Postal</label>
          <div class="col-md-6">
            <input type="number" step="1" min="0" class="form-control " id="cPostal" name="cPostal" value="<?=$cPostal;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT DE CODIGO POSTAL-->

        <!-- INICIA INPUT PARA PAIS-->
        <div class="form-group">
          <label class="col-md-3 control-label">País</label>
          <div class="col-md-6">
            <input type="text" step="any" class="form-control " id="pais" name="pais" value="<?=$pais;?>">
          </div>
        </div>
        <!-- TERMINA INPUT PARA PAIS-->

        <!-- INICIA INPUT PARA ESTAD-->
        <div class="form-group" id="mostrado" style="display:block;">
          <label class="col-md-3 control-label">Estado</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="estado" name="estado" value="<?=$estado;?>">
          </div>
        </div>
        <!-- TERMINA INPUT PARA ESTAD-->

        <!-- INICIA INPUT PARA ESTAD-->
        <div class="form-group" id="oculto" style="display:none;">
          <label class="col-md-3 control-label">Estado</label>
          <div class="col-md-6">
            <select id="estadoMexico" class="form-control ">
              <option selected disabled value="">Seleccione Estado</option>
              <option value="Aguascalientes">Aguascalientes</option>
              <option value="Baja California">Baja California</option>
              <option value="Baja California Sur">Baja California Sur</option>
              <option value="Campeche">Campeche</option>
              <option value="Ciudad de México">Ciudad de México</option>
              <option value="Coahuila">Coahuila</option>
              <option value="Colima">Colima</option>
              <option value="Chiapas">Chiapas</option>
              <option value="Chihuahua">Chihuahua</option>
              <option value="Durango">Durango</option>
              <option value="Estado de México">Estado de México</option>
              <option value="Guanajuato">Guanajuato</option>
              <option value="Guerrero">Guerrero</option>
              <option value="Hidalgo">Hidalgo</option>
              <option value="Jalisco">Jalisco</option>
              <option value="Michoacán">Michoacán</option>
              <option value="Morelos">Morelos</option>
              <option value="Nayarit">Nayarit</option>
              <option value="Nuevo León">Nuevo León</option>
              <option value="Oaxaca">Oaxaca</option>
              <option value="Puebla">Puebla</option>
              <option value="Querétaro">Querétaro</option>
              <option value="Quintana Roo">Quintana Roo</option>
              <option value="San Luis Potosí">San Luis Potosí</option>
              <option value="Sinaloa">Sinaloa</option>
              <option value="Sonora">Sonora</option>
              <option value="Tabasco">Tabasco</option>
              <option value="Tamaulipas">Tamaulipas</option>
              <option value="Tlaxcala">Tlaxcala</option>
              <option value="Veracruz">Veracruz</option>
              <option value="Yucatán">Yucatán</option>
              <option value="Zacatecas">Zacatecas</option>
            </select>
          </div>
        </div>
        <!-- TERMINA INPUT PARA ESTAD-->

        <!-- INICIA INPUT DE CIUDAD-->
        <div class="form-group">
          <label class="col-md-3 control-label">Ciudad</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="ciudad" name="ciudad" value="<?=$ciudad;?>">
          </div>
        </div>
        <!-- TERMINA INPUT DE CIUDAD-->

        <!-- INICIA INPUT CONTACTO-->
        <div class="form-group">
          <label class="col-md-3 control-label">Contacto</label>
          <div class="col-md-6">
            <input type="text" class="form-control " id="contacto" name="contacto" value="<?=$contacto;?>">
          </div>
        </div>
        <!-- TERMINA INPUT CONTACTO-->

        <!-- INICIA INPUT PARA EMAIL-->
        <div class="form-group">
          <label class="col-md-3 control-label">E-mail</label>
          <div class="col-md-6">
            <input type="email" step="any" class="form-control " id="email" name="email" value="<?=$email;?>">
          </div>
        </div>
        <!-- TERMINA INPUT PARA EMAIL-->

        <!--INICIA INPUT DE PRECIO DE VENTA -->
        <div class="form-group">
          <label class="col-md-3 control-label">Telefono</label>
          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-phone-alt"></i>
              </span>
              <input type="number" class="form-control" id="ladafijo" name="ladafijo" value="<?=$ladafijo;?>" required placeholder="Lada">
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-phone-alt"></i>
              </span>
              <input type="number"  class="form-control " id="telefono" name="telefono" value="<?=$telfijo;?>" required placeholder="Teléfono">
            </div>
          </div>
        </div>
        <!-- TERMINA INPUT DE PRECIO DE VENTA-->

        <!--INICIA INPUT DE PRECIO DE VENTA -->
        <div class="form-group">
          <label class="col-md-3 control-label">Celular</label>
          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-phone"></i>
              </span>
              <input type="number" class="form-control" id="ladamovil" name="ladamovil" value="<?=$ladamovil;?>" placeholder="Lada">
            </div>
          </div>
          <div class="col-md-4">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="glyphicon glyphicon-phone"></i>
              </span>
              <input type="text " step="any" class="form-control" id="celular" name="celular" value="<?=$telmovil;?>" placeholder="Celular">
            </div>
          </div>
        </div>
        <!-- TERMINA INPUT DE PRECIO DE VENTA-->

        <!-- INICIA INPUT PARA PAGINA WEB-->
        <div class="form-group">
          <label class="col-md-3 control-label">Página Web</label>
          <div class="col-md-6">
            <input type="text" step="any" class="form-control " id="pagina" name="pagina" value="<?=$pagina;?>">
          </div>
        </div>
        <!-- TERMINA INPUT PARA PAGINA WEB-->

        <!-- INICIA INPUT PARA ID FISCAL-->
        <div class="form-group">
          <label class="col-md-3 control-label">ID Fiscal</label>
          <div class="col-md-6">
            <input type="text" step="any" class="form-control " id="idFiscal" name="idFiscal" value="<?=$idFiscal;?>">
          </div>
        </div>
        <!-- TERMINA INPUT PARA ID FISCAL-->

        <!-- INICIA INPUT PARA SCCAC-->
        <div class="form-group">
          <label class="col-md-3 control-label">SCCAC</label>
          <div class="col-md-6">
            <input type="text" step="any" class="form-control " id="sccac" name="sccac" value="<?=$sccac;?>" required>
          </div>
        </div>
        <!-- TERMINA INPUT PARA SCCAC-->

        <!-- INICIA INPUT PARA CAAT-->
        <div class="form-group">
          <label class="col-md-3 control-label">CAAT</label>
          <div class="col-md-6">
            <input type="text" step="any" class="form-control " id="caat" name="caat" value="<?=$caat;?>" required>
          </div>
        </div>

        <div class="text-center">
          <hr>
          <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
          <input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>"> 

          <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
          <a href="../transportistas" class="btn grey-salsa btn-outline">Cancelar</a>
        </div>
        
        <!--TERMINA GRUPO DE BOTONES DE FORMULARIO-->
      </form>
      <!-- TERMINA FORM-->
    </div>
  </div>
  <!-- TERMINA CUERPO DE PORTLET-->
</div>
  <!-- TERMINA PORTLET-->