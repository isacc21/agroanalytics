/* DOCUMENTO PARA EL ACCESO A SECCIONES POR JQUERY */

/* INICIO DE PROCESO JQUERY */
$(document).ready(function(){


	/****************** USUARIOS *****************************/

	/* RUTA A LISTA DE USUARIOS */
	$("#list_user").click(function(){
		$("#mainContent").load( "cat_usuarios.php" );
	}); /* CIERRE DE LISTA DE USUARIOS */

	$("#list_admin").click(function(){
		$("#mainContent").load( "catAD_usuarios.php" );
	}); /* CIERRE DE LISTA DE USUARIOS */


	/* RUTA A REGISTRO DE USUARIOS */
	$("#add_user").click(function(){
		$("#mainContent").load( "form_usuarios.php" );
	}); /* CIERRE DE REGISTRO DE USUARIOS */


	/****************** PRODUCTOS ****************************/

	/* RUTA A LISTA DE PRODUCTOS */
	$("#list_product").click(function(){
		$("#mainContent").load( "cat_productos.php" );
	});/* CIERRE DE LISTA DE PRODUCTOS */


	/* RUTA A REGISTRO DE PRODUCTOS */
	$("#add_product").click(function(){
		$("#mainContent").load( "form_productos.php" );
	}); /* CIERRE DE REGISTRO DE PRODUCTOS */


	/****************** ACREEDORES ***************************/

	/* RUTA A LISTA DE ACREEDORES */
	$("#list_acreedor").click(function(){
		$("#mainContent").load( "cat_acreedores.php" );
	}); /* CIERRE DE LISTA DE ACREEDORES */

	/* RUTA A REGISTRO DE ACREEDORES */
	$("#add_acreedor").click(function(){
		$("#mainContent").load( "form_acreedores.php" );
	}); /* CIERRE DE REGISTRO DE ACREEDORES */ 

	/* RUTA A REGISTRO DE ACREEDORES */
	$("#rep_acreedor").click(function(){
		$("#mainContent").load( "prueba.php" );
	}); /* CIERRE DE REGISTRO DE ACREEDORES */ 


	/****************** PROVEEDORES **************************/

	/* RUTA A LISTA DE PROVEEDORES*/
	$("#list_prov").click(function(){
		$("#mainContent").load( "cat_proveedores.php" );
	}); /* CIERRE DE LISTA DE PROVEEDORES */

	/* RUTA A REGISTRO DE PROVEEDORES */
	$("#add_prov").click(function(){
		$("#mainContent").load( "form_proveedores.php" );
	}); /* CIERRE DE REGISTRO DE PROVEEDORES */

	/****************** TRANSPORTISTAS **************************/

	/* RUTA A LISTA DE TRANSPORTISTAS*/
	$("#list_trans").click(function(){
		$("#mainContent").load( "cat_transportistas.php" );
	}); /* CIERRE DE LISTA DE TRANSPORTISTAS */

	/* RUTA A REGISTRO DE TRANSPORTISTAS */
	$("#add_trans").click(function(){
		$("#mainContent").load( "form_transportistas.php" );
	}); /* CIERRE DE REGISTRO DE TRANSPORTISTAS */


	/****************** CLIENTES **************************/

	/* RUTA A LISTA DE CLIENTES*/
	$("#list_client").click(function(){
		$("#mainContent").load( "cat_clientes.php" );
	}); /* CIERRE DE LISTA DE CLIENTES */

	/* RUTA A REGISTRO DE CLIENTES */
	$("#add_client").click(function(){
		$("#mainContent").load( "form_clientes.php" );
	}); /* CIERRE DE REGISTRO DE CLIENTES */


	/****************** CLIENTES **************************/

	/* RUTA A LISTA DE CLIENTES*/
	$("#add_bancos").click(function(){
		$("#mainContent").load( "form_bancos.php" );
	}); /* CIERRE DE LISTA DE CLIENTES */

	/* RUTA A REGISTRO DE CLIENTES */
	$("#list_bancos").click(function(){
		$("#mainContent").load( "cat_bancos.php" );
	}); /* CIERRE DE REGISTRO DE CLIENTES */

	/* RUTA A REGISTRO DE CLIENTES */
	$("#rep_bancos").click(function(){
		$("#mainContent").load( "repo_bancos.php" );
	}); /* CIERRE DE REGISTRO DE CLIENTES */





	$("#logout").click(function() {
		$.ajax({
			url: "app/controllers/administracion/usuarios/logoutUsuario.php",
		}).done(function(result) {
			window.location = "../index.php";
		});
		return false;
	});


}); /* TERMINA PROCESO JQUERY */