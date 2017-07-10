<?php


date_default_timezone_set('America/Tijuana');

class declaraciones{

	var $folio;
	var $importacion;
	var $transportista;
	var $dd;
	var $mm;
	var $yyyy;
	var $placasmx;
	var $placasus;
	var $noeco_tracto;
	var $placas_plat;
	var $noeco_plat;
	var $peso;
	var $id;

	var $codigo;

	

	// DECLARACIÓN DEL MÉTODO CONSTRUCTOR
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}



	public function crearDeclaracion(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO aduanasdeclaraciones (
			folioDeclaracion,
			folioImportacion,
			rfcTransportista,
			ddDeclaracion,
			mmDeclaracion,
			yyyyDeclaracion,
			placasMXDeclaracion,
			placasUSDeclaracion,
			noEcoTractoDeclaracion,
			placasPlatDeclaracion,
			noEcoPlatDeclaracion,
			pesoTotalDeclaracion,
			statusDeclaracion,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->importacion."',
			'".$this->transportista."',
			'".$this->dd."',
			'".$this->mm."',
			'".$this->yyyy."',
			'".$this->placasmx."',
			'".$this->placasus."',
			'".$this->noeco_tracto."',
			'".$this->placas_plat."',
			'".$this->noeco_plat."',
			'".$this->peso."',
			1,
			'".$this->id."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Declaración registrada";
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
			return $resultados = $conexion->query("SELECT * FROM importaciones WHERE statusImportacion = 1");
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



	public function consultarProductosImp(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detallefacturaimportacion WHERE folioImportacion = '".$this->folio."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarDeclaraciones(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM aduanasdeclaraciones");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarTransportistas(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM transportistas");
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
			return $resultados = $conexion->query("SELECT folioDeclaracion FROM aduanasdeclaraciones WHERE folioDeclaracion LIKE '".$this->codigo."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function quemarImportacion(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "UPDATE importaciones SET statusImportacion = 4 WHERE folioImportacion = '".$this->importacion."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "listo";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultaodcs(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescompra WHERE folioImportacion = '".$this->importacion."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function consultarProductosCant(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("
				SELECT 
				a.codigoProducto, 
				a.cantidadOrdenCompra, 
				b.densidadProducto 
				FROM detalleordenescompra AS a INNER JOIN productos AS b 
				ON a.codigoProducto = b.codigoProducto 
				WHERE a.folioOrdenCompra = '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
}

?>
