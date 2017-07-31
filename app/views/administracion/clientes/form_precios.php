<?php
###### ESTRUCTURA PARA IMPRIMIR ERRORES EN CODIGO ####################################
error_reporting(E_ALL);
Ini_set('display_errors',1);

###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';

##### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ###############################
require '../../../models/administracion/clientes.php';

$clientes = new clientes($datosConexionBD);

$precios = $clientes->consultarProductos();

$nombreSubmit = 'Guardar';

$listaProductos = "";
$listaPrecios = "";   
$listaID = "";  
$ppecial="";


###### SE DETERMINA SI SE ENCUENTRA UN RFC ###########################################
if (isset($_REQUEST['rfc'])){
  $clientes = new clientes($datosConexionBD);

  $nombreSubmit = 'Actualizar';
}

$clientes->rfc =$_REQUEST['rfc'];
$lista_clientes = $clientes->consultarClientes();
foreach($lista_clientes as $row){
  $nombre_cliente = $row['razonSocCliente'];
}
?>

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

<div class="col-md-12">

 <div class="portlet  box grey-steel">

  <!--INICIA TITULO DE PORTLET-->
  <div class="portlet-title">

    <!--INICIAN ESTILOS DE TITULO DE PORTLET-->
    <div class="caption"><div class="font-grey-mint"> <b>Precios de <?=$nombre_cliente;?></b> </div></div>
    <!-- TERMINAN ESTILOS DE TITULO DE PORTLET-->
    <div class="actions btn-set">
      <button type="button" name="back" id="back_form_client" class="btn default green-seagreen">
        <i class="fa fa-arrow-left"></i> Regresar
      </button>
    </div>
  </div>
  <!-- TERMINA TITULO DE PORTLET -->

  <!--INICIA CUERPO DE PORTLET-->
  <div class="portlet-body form">


    <!--INICIA FORM-->
    <form class="form-horizontal save-user" id="preciosNuevos" >

      <!--INICIAN ESTILOS DE FORM-->
      <div class="form-body">
        <?php 
        $x=0;

        $clientes->rfc = $_REQUEST['rfc'];
        $count_precios = $clientes->cuenta();
          //echo $count_precios;
        foreach($precios as $row){
          $producto = $row['nombreProducto'];
          $idProducto = $row['codigoProducto'];
          $presentacion = $row['presentacionProducto'];

          switch($presentacion){
            case 1:
            case 2:
            case 3:
            case 4:
            $phi = "[USD/GAL]";
            $phm = "[USD/LT]";
            break;
            case 5:
            case 6:
            $phi = "[USD/LB]";
            $phm = "[USD/KG]";
            break;
          }

          ?>
          
          <!-- INICIA INPUT PRODUCTO-->
          <div class="form-group">
            <?php
            $precio =0;
            if($count_precios!=0){


              $clientes->codigo = $idProducto;
              $clientes->rfc = $_REQUEST['rfc'];
              $lista_precios = $clientes->consultarEspeciales();
              $final = "0.00";
              $finalM = "0.00";
              foreach($lista_precios as $row){
                $final = "0.00";
                $finalM = "0.00";
                $precioEspecial = $row['iPrecioEspecial'];
                $precioEspecialM = $row['mPrecioEspecial'];
                if($precioEspecial != 0 || $precioEspecial != null ||$precioEspecialM != 0){
                  $final = $precioEspecial;
                  $finalM = $precioEspecialM;
                }
                else{
                  $final = "0.00";
                  $finalM = "0.00";
                }
              }
            }
            else{
              $final = "0.00";
              $finalM = "0.00";
            }

            ?>

            <label class="col-md-3 control-label"><?echo $producto;?></label>
            <div class="col-md-3">
              <input type="number" class="form-control" id="precio<?=$x;?>" name="precio<?=$x;?>" step="0.01" min="0" value="<?=$final;?>" required placeholder="<?=$phi;?>">
            </div>
            <div class="col-md-3">
              <input type="number"  class="form-control " id="precioM<?=$x;?>" name="precioM<?=$x;?>" step="0.01" min="0" value="<?=$finalM;?>" required placeholder="<?=$phm;?>">
            </div>
            <input type="hidden" id="idProducto" name="idProducto" value="<?=$idProducto;?>">
          </div>


          <?php
          $listaProductos = $listaProductos .$producto. ":";
          $listaPrecios = $listaPrecios .$precio. ":";
          $listaID = $listaID .$idProducto. ":";

          $x++;
        }




        ?>
        <input type="hidden" id="productos" name="productos" value="<?= $listaProductos;?>">
        <input type="hidden" id="precios" name="precios" value="<?= $listaPrecios;?>">
        <input type="hidden" id="id" name="id" value="<?= $listaID;?>">
        <input type="hidden" id="vueltas" name="vueltas" value="<?= $x;?>">
        <input type="hidden" id="rfc" name="rfc" value="<?=$_REQUEST['rfc'];?>">
        <br>
        <div class="text-center">

          <!--BOTON PARA GUARDAR O ACTUALIZAR LOS DATOS-->
          <input type="submit" id="accionBoton" class="btn green-seagreen" value="<?=$nombreSubmit;?>"> 

          <!-- BOTON PARA REGRESAR AL INICIO DE SECCION-->
          <a href="../clientes" class="btn grey-salsa btn-outline">Cancelar</a>
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

  $("#back_form_client").click(function(){
    window.location = ""
  });


  /* COMPARACION DE VALOR DE BOTON DE FORMULARIO PARA CAMBIO DE URL*/
  if ($("#accionBoton").val() == 'Guardar'){
    var urlCont = "../../../controllers/administracion/clientes/nvosPrecios.php";
  } /* LLAVE DE IF */


  else if($("#accionBoton").val() == 'Actualizar'){
    var urlCont = "../../../controllers/administracion/clientes/actualizarPrecios.php";
  } /* LLAVE DE ELSE */


  /* AJAX QUE ENVIA INFORMACION AL URL DE ACUERDO A LA SITUACION */
  $("#preciosNuevos").submit(function(e){
    var precios = "";
    var preciosM= "";
    var separacion = ":";
    var vueltas = $("#vueltas").val();

    for (var i = 0; i < vueltas; i++) {
      var precio = $("#precio"+i).val();
      var precioM = $("#precioM"+i).val();
      precios = precios + precio + separacion;
      preciosM = preciosM + precioM + separacion;
    }

    
    $.ajax({

      type: "POST",
      url: urlCont,
      data: "productos="+$("#productos").val()+
      "&precios="+precios+
      "&preciosM="+preciosM+
      "&id="+$("#id").val()+
      "&rfc="+$("#rfc").val()
    }).done(function(result){

      if(result=="RFC existente"){
        swal (result, "", "warning");
      }else{
        swal (result, "", "success");
      }
      $("#mainContent").load( "cat_clientes.php" );
    });
    return false;
  });
</script>