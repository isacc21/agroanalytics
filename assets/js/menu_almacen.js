$(document).ready(function(){

	/****************** ORDENES DE COMPRA **************************/

	/* RUTA A SECCION DOLARES*/
	$("#list_ocompra").click(function(){
		$("#mainContent").load( "cat_ocompras.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#add_ocompra").click(function(){
		$("#mainContent").load( "form_ocompras.php" );
	}); /* CIERRE SECCION DOLARES */


	/****************** INVENTARIO **************************/

	/* RUTA A SECCION DOLARES*/
	$("#inventory").click(function(){
		$("#mainContent").load( "cat_inventario.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#list_pedimento").click(function(){
		$("#mainContent").load( "cat_pedimentos.php" );
	}); /* CIERRE SECCION DOLARES */


	/****************** ORDENES DE CARGA **************************/

	/* RUTA A SECCION DOLARES*/
	$("#add_ocarga").click(function(){
		$("#mainContent").load( "cat_pedidos.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#list_ocarga").click(function(){
		$("#mainContent").load( "cat_ocargas.php" );
	}); /* CIERRE SECCION DOLARES */


	/****************** REMISIONES **************************/

	/* RUTA A SECCION DOLARES*/
	$("#add_remisiones").click(function(){
		$("#mainContent").load( "cat_ocargas.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#list_remisiones").click(function(){
		$("#mainContent").load( "cat_remisiones.php" );
	}); /* CIERRE SECCION DOLARES */

}); /* TERMINA PROCESO JQUERY */