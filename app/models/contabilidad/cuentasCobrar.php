<?php
date_default_timezone_set('America/Tijuana');

class cuentasCobrar{
	var $folio;

	var $dd;
	var $mm;
	var $yyyy;
	var $cliente;
	var $factura;
	var $remision;
	var $monto;
	var $comentario;
	var $moneda;
	var $usuario;

	var $tipo;


	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	public function consultarCuentasCxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM cuentascobrar WHERE folioCuentaC = '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarClientes(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM clientes");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarClientesxID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM clientes WHERE rfcCliente = '".$this->cliente."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarRemisiones(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM remisiones WHERE statusRemision = 1");
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarRemisionesAll(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM remisiones");
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
			return $resultados = $conexion->query("SELECT folioCuentaC FROM cuentascobrar WHERE folioCuentaC LIKE '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function registrocxc(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "INSERT INTO cuentascobrar (
			folioCuentaC,
			ddCuentaC,
			mmCuentaC,
			yyyyCuentaC,
			rfcCliente,
			folioFactura,
			remisionFactura,
			importeCuentaC,
			comentarioCuentaC,
			statusCuentaC,
			monedaCuentaC,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->dd."',
			'".$this->mm."',
			'".$this->yyyy."',
			'".$this->cliente."',
			'".$this->factura."',
			'".$this->remision."',
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

	public function cuentasCobrarxMoneda(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM cuentascobrar WHERE monedaCuentaC = '".$this->moneda."' AND yyyyCuentaC = '".date(Y)."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function cuentasCobrarxMoneda_all(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM cuentascobrar WHERE monedaCuentaC = '".$this->moneda."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function facturarRemision(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE remisiones SET
			statusRemision = 2 
			WHERE folioRemision = '".$this->remision."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Registrado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function arreglarRemision(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE remisiones SET
			statusRemision = 1 
			WHERE folioRemision = '".$this->remision."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Registrado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function actualizarcxc(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE  cuentascobrar SET 
			
			ddCuentaC = '".$this->dd."',
			mmCuentaC = '".$this->mm."',
			yyyyCuentaC = '".$this->yyyy."',
			rfcCliente = '".$this->cliente."',
			folioFactura = '".$this->factura."',
			remisionFactura = '".$this->remision."',
			importeCuentaC = '".$this->monto."',
			comentarioCuentaC = '".$this->comentario."',
			idUsuario = '".$this->usuario."'

			WHERE folioCuentaC  = '".$this->folio."'";
			
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

			$query = "UPDATE cuentascobrar SET
			statusCuentaC = 2 
			WHERE folioCuentaC = '".$this->folio."'";

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

			$query = "UPDATE cuentascobrar SET
			statusCuentaC = 4 
			WHERE folioCuentaC = '".$this->folio."'";

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
