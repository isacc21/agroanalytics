<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Marzo 2017 : 13:01                                                            #
#                                                                                    #
###### nuevosPermisos.php ############################################################
#                                                                                    #
# Archivo Controller para el envio de información de la vista al modelo              #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 02-MAR-17: 13:02                                                                   #
# IJLM - Se copia archivo de nuevo usuario                                           #
######################################################################################


###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE USUARIOS #################################
require '../../../models/administracion/usuarios.php';


###### SE CREA EL OBJETO "USUARIOS" PARA UTILIZAR LOS METODOS ########################
$usuarios = new usuarios($datosConexionBD);

###### SE PROCESA EL METODO consultarUsuariosNick PARA COMPARAR REPETICION DE NICK ###
$consulta = $usuarios->consultarUltimo();

###### FOREACH PARA COMPARAR PROCESAR LOS RESULTADOS DE consultarUltimo() ############
foreach ($consulta as $row) {
	$id = $row['idUsuario'];
		}## LLAVE DE FOREACH #############################################################


###### VARIABLES PARA ENVIAR AL METODO
		$usuarios->proveedores = $_POST['provConsulta'].$_POST['provCrear'].$_POST['provModificar'].$_POST['provEliminar'];
		$usuarios->acreedores = $_POST['acreConsulta'].$_POST['acreCrear'].$_POST['acreModificar'].$_POST['acreEliminar'];
		$usuarios->transportistas = $_POST['transConsulta'].$_POST['transCrear'].$_POST['transModificar'].$_POST['transEliminar'];
		$usuarios->clientes = $_POST['clientConsulta'].$_POST['clientCrear'].$_POST['clientModificar'].$_POST['clientEliminar'];
		$usuarios->productos = $_POST['productConsulta'].$_POST['productCrear'].$_POST['productModificar'].$_POST['productEliminar'];
		$usuarios->aduanal = $_POST['aduanalConsulta'].$_POST['aduanalCrear'].$_POST['aduanalModificar'].$_POST['aduanalEliminar'];
		$usuarios->persona = $_POST['personaConsulta'].$_POST['personaCrear'].$_POST['personaModificar'].$_POST['personaEliminar'];
		$usuarios->pedidos = $_POST['pedidoConsulta'].$_POST['pedidoCrear'].$_POST['pedidoModificar'].$_POST['pedidoEliminar'];
		$usuarios->cotizaciones = $_POST['cotizacionConsulta'].$_POST['cotizacionCrear'].$_POST['cotizacionModificar'].$_POST['cotizacionEliminar'];
		$usuarios->importaciones = $_POST['importacionConsulta'].$_POST['importacionCrear'].$_POST['importacionModificar'].$_POST['importacionEliminar'];
		$usuarios->declaraciones = $_POST['declaracionConsulta'].$_POST['declaracionCrear'].$_POST['declaracionModificar'].$_POST['declaracionEliminar'];
		$usuarios->inventario = $_POST['inventarioConsulta'].$_POST['inventarioCrear'].$_POST['inventarioModificar'].$_POST['inventarioEliminar'];
		$usuarios->carga = $_POST['cargaConsulta'].$_POST['cargaCrear'].$_POST['cargaModificar'].$_POST['cargaEliminar'];
		$usuarios->compra = $_POST['compraConsulta'].$_POST['compraCrear'].$_POST['compraModificar'].$_POST['compraEliminar'];
		$usuarios->remisiones = $_POST['remisionConsulta'].$_POST['remisionCrear'].$_POST['remisionModificar'].$_POST['remisionEliminar'];
		$usuarios->bancos = $_POST['bancosConsulta'].$_POST['bancosCrear'].$_POST['bancosModificar'].$_POST['bancosEliminar'];
		$usuarios->cxc = $_POST['cxcConsulta'].$_POST['cxcCrear'].$_POST['cxcModificar'].$_POST['cxcEliminar'];
		$usuarios->cxp = $_POST['cxpConsulta'].$_POST['cxpCrear'].$_POST['cxpModificar'].$_POST['cxpEliminar'];
		$usuarios->id = $id;


###### SE PROCESA EL METODO PARA REALIZAR EL PROCESO EN LA BASE DE DATOS #############
		echo $usuarios->guardarPermisos();

		?>