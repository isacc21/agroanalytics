<?php
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){

###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
  include '../../../../config.php';

###### REQUIRE DE LA LIBRERIA DE METODOS DE ACREEDORES ###############################
  require '../../../models/contabilidad/bancos.php';
  require '../../../models/administracion/usuarios.php';

###### CREACION DEL OBJETO ACREEDORES PARA UTILIZAR METODOS ##########################
  $bancos = new bancos($datosConexionBD);
  $usuarios = new usuarios($datosConexionBD);

###### CONSULTA DE ACREEDORES PARA DATA TABLE ########################################
  $lista_bancos = $bancos->consultarBancos();


###### CONSULTA DE ACREEDORES PARA VENTANAS MODALES ##################################
  $consultaModal = $bancos->consultarBancos();

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
  $usuarios->id=$_SESSION['idUsuario'];
  $result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
  foreach ($result as $row){
    $banco = $row['bancosPermiso'];
  }## LLAVE DE FOREACH ###############################################################

  $html_nuevo='<button id="gotoBancos" class="btn green-seagreen"><i class="fa fa-plus"></i>&nbsp;Nuevo</button>';
  ?>

  <!-- INICIA LINK PARA ASSETS DE SWEET ALERTS -->
  <link href="../../../../assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
  <!-- TERMINA LINK PARA ASSETS DE SWEET ALERTS -->


  <!--INICIA ESTILOS PARA RADIO BUTTONS Y LABELS IMPROVISADOS -->
  <style>
    input[type=radio] { display: none }
    label {cursor: pointer}   
  </style>
  <!--TERMINA ESTILOS PARA RADIO BUTTONS Y LABELS IMPROVISADOS -->
  <div class="row">
    <div class="col-md-12">
      <!-- BEGIN EXAMPLE TABLE PORTLET-->
      <div class="portlet box grey-steel">
        <div class="portlet-title">

         <div class="caption"><div class="font-grey-mint"> <b>Catálogo</b> </div>

       </div>
       <div class="actions btn-set">
        <?php 
        if($banco[1]=='2'){
          echo $html_nuevo;
        } ?>
        <button type="button" name="back" id="back_cat_acre" class="btn green-seagreen">
          <i class="fa fa-arrow-left"></i>&nbsp;Regresar
        </button>


      </div>

    </div>
    <div class="portlet-body">
      <!-- INICIA ENCABEZADO DE CUERPO DE PORTLET-->

      <!-- TERMINA ENCABEZADO DE CUERPO DE PORTLET-->
      <table class="table table-striped table-bordered table-hover order-column" id="sample_1">
        <thead>
          <tr>
            <th> Nombre </th>
            <th> Moneda </th>
            <th> Cuenta </th>
            <th> CLABE </th>
            <th> Sucursal</th>
            <th> Plaza </th>
            <th> Acciones </th>
          </tr>
        </thead>
        <tbody>

          <!--INICIO DE FOREACH PARA TABLA DE ACREEDORES-->
          <?php
          foreach($lista_bancos as $row){
           $codigo = $row['idBanco'];
           $nombre = $row['nombreBanco'];
           $moneda = $row['monedaBanco'];
           $cuenta = $row['cuentaBanco'];
           $clabe = $row['clabeBanco'];
           $num_sucursal = $row['numSucursalBanco'];
           $nom_sucursal = $row['nomSucursalBanco'];
           $num_plaza = $row['numPlazaBanco'];
           $nom_plaza = $row['nomPlazaBanco'];
           $codigosa = $row['codigoSABanco'];
           ?>
           <!--TERMINO DE FOREACH PARA TABLA DE ACREEDORES-->

           <!-- INICIA FILA CON VARIABLES DE FOREACH-->
           <tr class="odd gradeX">
            <td> <?php echo $nombre;?> </td>
            <td> <?php if($moneda==1){echo "Dólares";}else{if($moneda==2){echo "Pesos";}}; ?> </td>
            <td> <?php echo $cuenta; ?></td>
            <td> <?php echo $clabe; ?></td>
            <td> <?php echo $num_sucursal ."-". $nom_sucursal; ?></td>
            <td> <?php echo $num_plaza ."-". $nom_plaza; ?></td>
            <td>
              <?php

              $html_inicio_actions='<div class="text-center"><div class="btn-group">
              <button class="btn btn-xs green-seagreen dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> 
                &nbsp;&nbsp;<i class="glyphicon glyphicon-list"></i>
                &nbsp; Elegir&nbsp;&nbsp;
              </button><ul class="dropdown-menu pull-right" role="menu">';

              $html_final_actions='</ul></div></div>';

              $html_moreInfo='<li>
              <a data-toggle="modal" href="#modal'.$codigo.'">
                <i class="icon-magnifier"></i> Ver info.<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></a>
              </li>';

              $html_editar='<li><a><input type="radio" id="editar'.$codigo.'" class="editar" name="editar" value="'.$codigo.'">
              <label for="editar'.$codigo.'">  <i class="fa fa-edit"></i>&nbsp;Modificar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

              $html_eliminar='<li><a><input type="radio" id="borrar'.$codigo.'" class="borrar" name="borrar" value="'.$codigo.'">
              <label for="borrar'.$codigo.'" " data-toggle="modal" href="#basic">  <i class="fa fa-trash-o"></i>&nbsp;Eliminar<i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i><i class="font-white fa fa-square-o"></i></label></a></li>';

              if($banco[0]=='1'||$banco[1]=='2'||$banco[2]=='3'||$banco[3]=='4'){
                echo $html_inicio_actions;
              }
              if($banco[0]=='1'){
               echo $html_moreInfo; 
             }
             if($banco[2]=='3'){
              echo $html_editar;
            }
            if($banco[3]=='4'){
              echo $html_eliminar;
            }
            if($banco[0]=='1'||$banco[1]=='2'||$banco[2]=='3'||$banco[3]=='4'){
              echo $html_final_actions;
            }
            ?>
          </td>
        </tr>
        <!-- TERMINA FILAS CON VARIABLES DE FOREACH-->

        <!-- INICIA LLAVE DE FOREACH PARA TABLA DE ACREEDORES-->
        <?php 
      }
      ?>
      <!-- TERMINA LLAVE DE FOREACH PARA TABLA DE ACREEDORES-->
    </tbody>
  </table>
</div>
</div>
</div>
</div>
<?php

###### FOREACH PARA CONSULTA DE DETALLES DE ACREEDORES PARA VENTANA MODAL #########
foreach($consultaModal as $row){
 $codigo = $row['idBanco'];
 $nombre = $row['nombreBanco'];
 $moneda = $row['monedaBanco'];
 $cuenta = $row['cuentaBanco'];
 $clabe = $row['clabeBanco'];
 $num_sucursal = $row['numSucursalBanco'];
 $nom_sucursal = $row['nomSucursalBanco'];
 $num_plaza = $row['numPlazaBanco'];
 $nom_plaza = $row['nomPlazaBanco'];
 $codigosa = $row['codigoSABanco'];

 ?>
 <!-- INICIO DE VENTANA MODAL -->
 <div class="modal fade" id="modal<?=$codigo;?>" tabindex="-1" role="basic" aria-hidden="true">

  <!-- INICIO DE VENTANA MODAL -->
  <div class="modal-dialog">

    <!-- INCIO DE DEFINICIO DE CONTENIDO DE VENTANA MODAL -->
    <div class="modal-content">

      <!-- INICIO DE CABECERA DE VENTANA MODAL -->
      <div class="modal-header">

        <!-- BONTON DE CIERRE DE VENTANA MODAL-->
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>

        <!-- ENCABEZADO DE VENTANA MODAL-->
        <h4 class="modal-title">Información completa</h4>
      </div>
      <!-- TERMINA CABECERA DE VENTANA MODAL -->

      <!-- INICIA CUERPO DE VENTANA MODAL-->
      <div class="modal-body">

        <!-- INICIA TABLA SIMPLE PARA MOSTRAR DETALLES DE ACREEDORES-->
        <table class="table table-hover">
          <tr>
            <td><strong>Nombre:</strong></td>
            <td><strong><?php echo $nombre; ?></strong></td>
          </tr>
          <tr>
            <td>Moneda:</td>
            <td><?php if($moneda==1){echo "Dólares";}else{if($moneda==2){echo "Pesos";}}; ?></td>
          </tr>
          <tr>
            <td>Cuenta:</td>
            <td><?php echo $cuenta; ?></td>
          </tr>
          <tr>
            <td>CLABE:</td>
            <td><?php echo $clabe; ?></td>
          </tr>
          <tr>
            <td>Surcursal:</td>
            <td> <?php echo $num_sucursal ."-". $nom_sucursal; ?></td>
          </tr>
          <tr>
            <td>Plaza: </td>
            <td> <?php echo $num_plaza ."-". $nom_plaza; ?></td>
          </tr>
          <?php 
          if($codigosa != "NULL"){
            echo '<tr>
            <td>Código Swift / ABA:</td>
            <td>'.$codigosa.'</td>
          </tr>';
        }?>

      </table>
    </div>
    <!-- TERMINA TABLA SIMPLE PARA DETALLES DE ACREEDORES-->

    <!-- INICIA PIE DE VENTANA MODAL-->
    <div class="modal-footer">

      <!-- BOTON DE CIERRE PARA VENTANA MODAL-->
      <button type="button" class="btn green-seagreen btn-outline" data-dismiss="modal">Cerrar</button>
    </div>
    <!-- TERMINA PIE DE VENTANA MODAL-->
  </div>
  <!-- TERMINO DE DEFINICION DE CONTENIDO DE VENTANA MODAL -->
</div>
<!-- TERMINO DE VENTANA MODAL  -->
</div>
<!-- TERMINO DE VENTANA MODAL -->
<?
} ###### LLAVE DE FOREACH PARA CADA DETALLE DE ACREEDORES #############################################
?>


<!-- SCRIPTS NECEARIOS PARA FUNCIONAMIENTO DE CATALOGO-->
<script>
  $(document).ready(function(){

   $("#back_cat_acre").click(function(){
    window.location = ""
  });

   /* SCRIPT PARA CAMBIAR CONTENIDO POR FORMULARIO EN BLANCO */
   $("#gotoBancos").click(function(){
    $("#mainContent").load( "form_bancos.php" );
  });


   /* SCRIPT PARA ENVIAR FOLIO DE PRODUCTO AL FORMULARIO Y EDITAR INFORMACION */
   $('.editar').click(function() {
    $("#mainContent").load( "form_bancos.php?codigo="+$(this).val() );

  });

   /* SCRIPT PARA ENVIO DE FOLIO Y ELIMINACION DEL ACREEDOR EN CUESTION*/ 
   $(".borrar").click(function(){

    var folio = $(this).val();

    swal({
      title: "¿Eliminar banco"+folio+"?",
      text: "Se eliminará permanentemente",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Eliminar",
      cancelButtonText: "Cancelar",
      closeOnConfirm: false,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        $.ajax({
          type: "POST",
          url: "../../../controllers/administracion/bancos/eliminarBanco.php",
          data:"folio="+ folio
        }).done(function(result){
          swal({
            title: "Eliminado"+result,
            text: "El banco ha sido eliminado",
            type: "success",
            showCloseButton: true,
            confirmButtonText:'Cerrar'
          });
          $("#mainContent").load( "cat_bancos.php" );
        });

      } else {
       swal({
        title: "Cancelado",
        text: "Se ha conservado el banco",
        type: "error",
        showCloseButton: true,
        confirmButtonText:'Cerrar'
      });
     }
   });
  });
 });
</script>
<script src="../../../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="../../../../assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="../../../../assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="../../../../assets/pages/scripts/table-datatables-scroller.min.js" type="text/javascript"></script>


<!-- TERMINAN SCRIPTS PARA EL FUNCIONAMIENTO DE DATA TABLES-->
<?php
}else{
  header("LOCATION: ../../../../index.php");
}
?>