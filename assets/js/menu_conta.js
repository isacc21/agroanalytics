/* DOCUMENTO PARA EL ACCESO A SECCIONES POR JQUERY */

/* INICIO DE PROCESO JQUERY */
$(document).ready(function(){

	/****************** BANCOS **************************/

	/* RUTA A SECCION DOLARES*/
	$("#sec_dolares").click(function(){
		$("#mainContent").load( "sec_dolares.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION PESOS*/
	$("#sec_pesos").click(function(){
		$("#mainContent").load( "sec_pesos.php" );
	}); /* CIERRE SECCION PESOS */


	/* RUTA A SECCION DOLARES*/
	$("#list_bank").click(function(){
		$("#mainContent").load( "cat_bancoD.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION PESOS*/
	$("#add_bank").click(function(){
		$("#mainContent").load( "form_bancoD.php" );
	}); /* CIERRE SECCION PESOS */

	/****************** CUENTAS POR COBRAR **************************/

	/* RUTA A SECCION DOLARES*/
	$("#cuentasC_dolares").click(function(){
		$("#mainContent").load( "cxc_dolares.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION PESOS*/
	$("#cxc_pesos").click(function(){
		$("#mainContent").load( "cxc_pesos.php" );
	}); /* CIERRE SECCION PESOS */

	$("#list_cxcD").click(function(){
		$("#mainContent").load( "cat_cxcD.php" );
	}); /* CIERRE SECCION DOLARES */

	$("#add_cxcD").click(function(){
		$("#mainContent").load( "form_cxcD.php" );
	}); /* CIERRE SECCION DOLARES */

	/****************** CUENTAS POR PAGAR **************************/

	/* RUTA A SECCION DOLARES*/
	$("#cuentasP_dolares").click(function(){
		$("#mainContent").load( "cxp_dolares.php" );
	}); /* CIERRE SECCION DOLARES */

	/* RUTA A SECCION PESOS*/
	$("#cxp_pesos").click(function(){
		$("#mainContent").load( "cxp_pesos.php" );
	}); /* CIERRE SECCION PESOS */

	$("#list_cxpD").click(function(){
		$("#mainContent").load( "cat_cxpD.php" );
	}); /* CIERRE SECCION DOLARES */

	$("#add_cxpD").click(function(){
		$("#mainContent").load( "form_cxpD.php" );
	}); /* CIERRE SECCION DOLARES */


}); /* TERMINA PROCESO JQUERY */