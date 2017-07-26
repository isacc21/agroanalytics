<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 07 Febrero 2017 : 10:57                                                            #
#                                                                                    #
###### ordenesCompra.php #############################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "ordenes de compra". #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 7-FEB-17: 10:58                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "generarOrdenCompra()"                                  #
# IJLM - Creación del método "agregarDetalleOrden()"                                 #
# IJLM - Creación del método "cancelarOrdenCompra()"                                 #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 8-FEB-17: 8:34                                                                     #
# IJLM - Creación del método "cancelarOrdenCompra()"                                 #
# IJLM - Creación del método "completarOrdenCompra()"                                #
# IJLM - Creación del método "consultarOrdenes()"                                    #
######################################################################################

date_default_timezone_set('America/Tijuana');

class ordenesCompra{
	var $folio;
	var $proveedor;
	var $adicional;
	var $total;
	var $usuario;
	var $producto;
	var $cantidad;
	var $monto;
	var $id;
	var $factura;

	var $codigo;

	// DECLARACIÓN DEL MÉTODO CONSTRUCTOR
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	//FUNCION "NUEVA ORDEN"////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function generarOrdenCompra(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO ordenescompra (
			folioOrdenCompra,
			rfcProveedor,
			statusOrdenCompra,
			adicionalOrdenCompra,
			ddOrdenCompra,
			mmOrdenCompra,
			yyyyOrdenCompra,
			totalOrdenCompra,
			folioFactura,
			statusFactura,
			folioImportacion,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->proveedor."',
			1,
			'".$this->adicional."',
			'".date(d)."',
			'".date(m)."',
			'".date(Y)."',
			'".$this->total."',
			NULL,
			0,
			NULL,
			'".$this->id."'
			)";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Orden de Compra registrada";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "NUEVA ORDEN"////////////////////////////////////////////////////////////////////////////////////////////////////////////////



	//FUNCION "NUEVOS DETALLES DE ORDEN"///////////////////////////////////////////////////////////////////////////////////////////////////
	public function agregarDetalleOrden(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO detalleordenescompra (
			idDetalleOC,
			folioOrdenCompra,
			codigoProducto,
			cantidadOrdenCompra,
			montoOrdenCompra)

			VALUES (
			NULL,
			'".$this->folio."',
			'".$this->producto."',
			'".$this->cantidad."',
			'".$this->monto."'
			)";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Detalle de Orden de Compra registrada";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "NUEVOS DETALLES DE ORDEN"///////////////////////////////////////////////////////////////////////////////////////////////////



	//FUNCION "CANCELAR ORDEN"/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function cancelarOrdenCompra(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE ordenescompra SET

					statusOrdenCompra =    3,
					idUsuario = '".$this->id."'

					WHERE folioOrdenCompra =   '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Orden de Compra Cancelada";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "CANCELAR ORDEN"/////////////////////////////////////////////////////////////////////////////////////////////////////////////



	//FUNCION "CANCELAR ORDEN"/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function completarOrdenCompra(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE ordenescompra SET

					statusOrdenCompra =    2,
					folioFactura = '".$this->factura."',
					statusFactura = 1,
					idUsuario = '".$this->id."'

					WHERE folioOrdenCompra =   '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Factura procesada";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "COMPLETAR ORDEN"/////////////////////////////////////////////////////////////////////////////////////////////////////////////



	//FUNCION "CONSULTAR ORDEN"/////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function consultarOrdenes(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "CANCELAR ORDEN"/////////////////////////////////////////////////////////////////////////////////////////////////////////////


	public function consultarOrdenesxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioOrdenCompra = '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarProveedores(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM proveedores WHERE rfcProveedor = '".$this->proveedor."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarProveedoresAll(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM proveedores");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarDetalle(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detalleordenescompra WHERE folioOrdenCompra = '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarProductosxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM productos WHERE codigoProducto = '".$this->producto."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarProductos(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
			dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM productos");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}




	public function consultarCodigos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT folioOrdenCompra FROM ordenescompra WHERE folioOrdenCompra LIKE '".$this->codigo."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
}

?>
