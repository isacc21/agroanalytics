<?php
date_default_timezone_set('America/Tijuana');

class cuentasPagar{
	var $folio;

	var $dd;
	var $mm;
	var $yyyy;

	var $proveedor;
	var $acreedor;

	var $factura;
	var $monto;
	var $comentario;
	var $moneda;
	var $usuario;

	var $tipo;


	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	public function consultarCuentasPxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM cuentaspagar WHERE folioCuentaP = '".$this->folio."'");

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

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM proveedores");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarAcreedores(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM acreedores");

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
			return $resultados = $conexion->query("SELECT folioCuentaP FROM cuentaspagar WHERE folioCuentap LIKE '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function registrocxp(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "INSERT INTO cuentaspagar (
			folioCuentaP,
			ddCuentaP,
			mmCuentaP,
			yyyyCuentaP,
			rfcProveedor,
			rfcAcreedor,
			folioFactura,
			importeCuentaP,
			comentarioCuentaP,
			statusCuentaP,
			monedaCuentaP,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->dd."',
			'".$this->mm."',
			'".$this->yyyy."',
			'".$this->proveedor."',
			'".$this->acreedor."',
			'".$this->factura."',
			'".$this->monto."',
			'".$this->comentario."',
			1,
			'".$this->moneda."',
			'".$this->usuario."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Registrado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function cuentasPagarxMoneda(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM cuentaspagar WHERE monedaCuentaP = '".$this->moneda."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarProveedoresxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM proveedores WHERE rfcProveedor = '".$this->proveedor."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarAcreedoresxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM acreedores WHERE rfcAcreedor = '".$this->acreedor."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function actualizarcxp(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE  cuentaspagar SET 
			
			ddCuentaP = '".$this->dd."',
			mmCuentaP = '".$this->mm."',
			yyyyCuentaP = '".$this->yyyy."',
			rfcProveedor = '".$this->proveedor."',
			rfcAcreedor = '".$this->acreedor."',
			folioFactura = '".$this->factura."',
			importeCuentaP = '".$this->monto."',
			comentarioCuentaP = '".$this->comentario."',
			idUsuario = '".$this->usuario."'

			WHERE folioCuentaP = '".$this->folio."'";
			
			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Modificado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function saldarCuenta(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE cuentaspagar SET
			statusCuentaP = 2 
			WHERE folioCuentaP = '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Cuenta saldada";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function cancelarCuenta(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE cuentaspagar SET
			statusCuentaP = 4 
			WHERE folioCuentaP = '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Cuenta cancelada";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}
}
?>