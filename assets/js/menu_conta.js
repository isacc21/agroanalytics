/* DOCUMENTO PARA EL ACCESO A SECCIONES POR JQUERY */

/* INICIO DE PROCESO JQUERY */
$(document).ready(function(){

	/* CUENTAS POR COBRAR */
	$("#nuevo_cxcd").click(function(){
		$("#mainContent").load( "form_cuentasCobrar.php?moneda=1" );
	});
	$("#lista_cxcd").click(function(){
		$("#mainContent").load( "cat_cuentasCobrar.php?moneda=1" );
	});

	$("#nuevo_cxcp").click(function(){
		$("#mainContent").load( "form_cuentasCobrar.php?moneda=2" );
	});
	$("#lista_cxcp").click(function(){
		$("#mainContent").load( "cat_cuentasCobrar.php?moneda=2" );
	});


		/* CUENTAS POR PAGAR */
	$("#nuevo_cxpd").click(function(){
		$("#mainContent").load( "form_cuentasPagar.php?moneda=1" );
	});
	$("#lista_cxpd").click(function(){
		$("#mainContent").load( "cat_cuentasPagar.php?moneda=1" );
	});

	$("#nuevo_cxpp").click(function(){
		$("#mainContent").load( "form_cuentasPagar.php?moneda=2" );
	});
	$("#lista_cxpp").click(function(){
		$("#mainContent").load( "cat_cuentasPagar.php?moneda=2" );
	});

}); /* TERMINA PROCESO JQUERY */