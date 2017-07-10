<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Abril 2017 : 01:52                                                              #
#                                                                                    #
###### cuentasCobrar/cxc_dolares.php #################################################
#                                                                                    #
# Menu para la sección cuentas por cobrar                                            #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 02-ABR-17: 01:53                                                                   #
# IJLM - Se copia archivo de index Bancos                                            #
######################################################################################


###### DEFINICION DE ZONA HORARIA ####################################################
date_default_timezone_set('America/Tijuana');

session_start();
if(isset($_SESSION['login'])){
    ###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
	include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
	require '../../../models/administracion/usuarios.php';


###### CREACION DEL METODO USUARIOS ##################################################
	$usuarios = new usuarios($datosConexionBD);

###### SE CONSULTAN PERMISOS PARA MOSTRAR INFORMACION ################################
	$usuarios->id=$_SESSION['idUsuario'];
	$result = $usuarios->consultarPermisos();

###### FOREACH PARA CONSULTA DE PERMISOS #############################################
	foreach ($result as $row){
		$cxp = $row['cxpPermiso'];
    }## LLAVE DE FOREACH ###############################################################




    $html_registro='<div class="col-md-4">
    <div class="mt-widget-3">
    	<div class="mt-head bg-green-jungle">
    		<div class="mt-head-icon">
    			<i class="fa fa-upload"></i>
    		</div>
    		<div class="mt-head-desc">Registrar nueva orden por pagar</div>
    		<div class="mt-head-button">
    			<button type="button" id="add_cxpD" class="btn btn-circle btn-outline white btn-sm">Registrar</button>
    		</div>
    	</div>
    </div></div>';

    $html_consulta='<div class="col-md-4">
    <div class="mt-widget-3">
    	<div class="mt-head bg-green-haze">
    		<div class="mt-head-icon">
    			<i class="fa fa-list-ol"></i>
    		</div>
    		<div class="mt-head-desc"> Lista de cuentas por pagar </div>
    		<div class="mt-head-button">
    			<button type="button" id="list_cxpD" class="btn btn-circle btn-outline white btn-sm">Consultar</button>
    		</div>
    	</div>
    </div></div>';

    $html_reporte='<div class="col-md-4">
    <div class="mt-widget-3">
    	<div class="mt-head bg-blue-soft">
    		<div class="mt-head-icon">
    			<i class="icon-notebook"></i>
    		</div>
    		<div class="mt-head-desc"> Reporte </div>
    		<div class="mt-head-button">
    			<button type="button" id="rep_bank" class="btn btn-circle btn-outline white btn-sm">Seleccionar</button>
    		</div>
    	</div>
    </div></div>';

    ?>




    <!--INICIA PORTLET MENU DE USUARIOS-->
    <div class="portlet light portlet-fit bordered">
    	<div class="portlet-title">
    		<div class="caption">
    			<i class="icon-settings font-green-sharp"></i>
    			<span class="caption-subject font-green-sharp bold uppercase">Seleccione una opción</span>
    		</div>
    	</div>
    	<div class="portlet-body">
    		<div class="row">

    			<!--INICIA LISTA DE USUARIOS-->
    			<?php 
    			if($cxp[1]=='2'){
    				echo $html_registro;
    			}
    			if($cxp[0]=='1'||$cxp[2]=='3'||$cxp[3]=='4'){
    				echo $html_consulta;
    				echo $html_reporte;
    			}
    			?>
    			<!--TERMINA LISTA DE USUARIOS-->

    		</div>
    	</div>
    </div>
    <!--TERMINA PORTLET DE USUARIOS-->
  </div>
  <!--TERMINA MAIN CONTAINT PARA USO DE AJAX-->
</div>
</div>
<!-- TERMINA CONTENIDO DE LA PAGINA -->
</div>
<!-- TERMINA CONTENEDOR -->
<script type="text/javascript" src="../../../../assets/js/menu_conta.js"></script>



</html>
<?php
}else{
	header("LOCATION: ../../../../  index.php");
}
?>