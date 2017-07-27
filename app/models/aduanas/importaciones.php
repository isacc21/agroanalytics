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

class importaciones{
	var $factura;
	var $orden;
	var $producto;

	var $folio;
	var $dd;
	var $mm;
	var $yyyy;
	var $costo;
	var $id;

	var $detalle;

	var $diaM;
	var $mesM;
	var $anoM;
	var $diaC;
	var $mesC;
	var $anoC;
	var $lote;
	var $peso;

	var $codigo;
	var $odc;

	var $cantidad;

	var $pedimento;
	var $entrada;
	



	// DECLARACIÓN DEL MÉTODO CONSTRUCTOR
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}



	public function consultarFacturasOC(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioFactura IS NOT NULL AND statusFactura = 1 ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarImportacionesUPU(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM importaciones WHERE folioImportacion = '".$this->folio."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function agregarImportacion(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO importaciones (
			folioImportacion,
			statusImportacion,
			ddImportacion,
			mmImportacion,
			yyyyImportacion,
			costoImportacion,
			folioPedimentoImportacion,
			tipoEntradaImportacion,
			idUsuario)

			VALUES (
			'".$this->folio."',
			1,
			'".$this->dd."',
			'".$this->mm."',
			'".$this->yyyy."',
			'".$this->costo."',
			NULL,
			0,
			'".$this->id."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Importación registrada";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function agregarFacturasImportacion(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO detalleimportacion (
			idDetalleImportacion,
			folioImportacion,
			facturaImportacion)

			VALUES (
			NULL,
			'".$this->folio."',
			'".$this->factura."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Listo";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function quemarFacturas(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE ordenescompra SET

			statusFactura = 2,
			statusOrdenCompra = 4,
			folioImportacion = '".$this->folio."',
			idUsuario = '".$this->id."'

			WHERE folioFactura =   '".$this->factura."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Factura añadida con éxito";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarFacturas(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detalleimportacion WHERE folioImportacion = '".$this->folio."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarCompras(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioFactura = '".$this->factura."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarProductosOC(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detalleordenescompra WHERE folioOrdenCompra = '".$this->orden."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarNombreProducto(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM productos WHERE codigoProducto = '".$this->producto."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function registrarDetalleFI(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO detallefacturaimportacion (
			idDetalleFI,
			folioImportacion,
			folioFactura,
			codigoProducto,
			ddManufactura,
			mmManufactura,
			yyyyManufactura,
			ddCaducidad,
			mmCaducidad,
			yyyyCaducidad,
			loteProduccion)

			VALUES (
			NULL,
			'".$this->folio."',
			'".$this->factura."',
			'".$this->producto."',
			'".$this->diaM."',
			'".$this->mesM."',
			'".$this->anoM."',
			'".$this->diaC."',
			'".$this->mesC."',
			'".$this->anoC."',
			'".$this->lote."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Registro exitoso";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarImportaciones(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM importaciones");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarOrdenesxImportacion(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioImportacion = '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function consultarProductosODC(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detalleordenescompra WHERE folioOrdenCompra = '".$this->odc."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function catalogoProductos(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM productos WHERE codigoProducto ='".$this->producto."'");

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
			return $resultados = $conexion->query("SELECT folioImportacion FROM importaciones WHERE folioImportacion LIKE '".$this->codigo."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarCodigosInv(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT barCodeInventario FROM inventario WHERE barCodeInventario LIKE '".$this->codigo."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarImportacionesNV(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM importaciones WHERE statusImportacion = 1");
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarLoteF(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detallefacturaimportacion WHERE folioFactura = '".$this->factura."' AND codigoProducto = '".$this->producto."'");
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarPresentacion(){
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



	public function registrarInventario(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO inventario (
			idInventario,
			folioImportacion,
			barCodeInventario,
			codigoProducto,
			existenciaInventario,
			ddManufactura,
			mmManufactura,
			yyyyManufactura,
			ddCaducidad,
			mmCaducidad,
			yyyyCaducidad,
			loteInventario)

			VALUES (
			NULL,
			'".$this->codigo."',
			'".$this->folio."',
			'".$this->producto."',
			'".$this->cantidad."',
			'".$this->diaM."',
			'".$this->mesM."',
			'".$this->anoM."',
			'".$this->diaC."',
			'".$this->mesC."',
			'".$this->anoC."',
			'".$this->lote."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Listo";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function registrarPedimento(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE importaciones SET

			statusImportacion = 2,
			folioPedimentoImportacion = '".$this->pedimento."',
			tipoEntradaImportacion = '".$this->entrada."',
			idUsuario = '".$this->id."'

			WHERE folioImportacion =   '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Pedimento registrado \nInventario actualizado";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarMontosFac(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioFactura = '".$this->factura."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarPreciosFactura(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioFactura = '".$this->factura."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	
}

?>
