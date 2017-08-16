/* DOCUMENTO PARA EL ACCESO A SECCIONES POR JQUERY */

/* INICIO DE PROCESO JQUERY */
$(document).ready(function(){

	/****************** COTIZACIONES **************************/

	/* RUTA A SECCION DOLARES*/
	$("#list_coti").click(function(){
		$("#mainContent").load( "cat_cotizaciones.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#add_coti").click(function(){
		$("#mainContent").load( "form_cotizaciones.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#rep_coti").click(function(){
		$("#mainContent").load( "cat_cotizaciones_all.php" );
	}); /* CIERRE SECCION DOLARES */


	/****************** PEDIDOS **************************/

	/* RUTA A SECCION DOLARES*/
	$("#list_pedido").click(function(){
		$("#mainContent").load( "cat_pedidos.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#avaible_coti").click(function(){
		$("#mainContent").load( "cat_cotizaciones.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#add_pedido").click(function(){
		$("#mainContent").load( "form_pedidos.php" );
	}); /* CIERRE SECCION DOLARES */

	


}); /* TERMINA PROCESO JQUERY */