$(document).ready(function(){

	/****************** IMPORTACIONES **************************/

	/* RUTA A SECCION DOLARES*/
	$("#list_importacion").click(function(){
		$("#mainContent").load( "cat_importaciones.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#add_importacion").click(function(){
		$("#mainContent").load( "form_importaciones.php" );
	}); /* CIERRE SECCION DOLARES */






		/****************** DECLARACIONES **************************/

	/* RUTA A SECCION DOLARES*/
	$("#jalar_importacion").click(function(){
		$("#mainContent").load( "cat_importaciones.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION DOLARES*/
	$("#list_declaracion").click(function(){
		$("#mainContent").load( "cat_declaraciones.php" );
	}); /* CIERRE SECCION DOLARES */


}); /* TERMINA PROCESO JQUERY */