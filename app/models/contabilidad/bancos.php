<?php
date_default_timezone_set('America/Tijuana');

class bancos{
	var $id;
	var $nombre;
	var $moneda;
	var $cuenta;
	var $clabe;
	var $numsuc;
	var $nomsuc;
	var $numpla;
	var $nompla;
	var $codigosa;

	var $folio;
	var $dd;
	var $mm;
	var $yyyy;
	var $banco;
	var $metpago;
	var $tipo;
	var $monto;
	var $concepto;
	var $descripcion;
	var $usuario;

	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	public function consultarBancosID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM bancos WHERE idBanco = '".$this->id."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function guardarBanco(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "INSERT INTO bancos (
			idBanco,
			nombreBanco,
			monedaBanco,
			cuentaBanco,
			clabeBanco,
			numSucursalBanco,
			nomSucursalBanco,
			numPlazaBanco,
			nomPlazaBanco,
			codigoSABanco,
			statusBanco)

			VALUES (
			NULL,
			'".$this->nombre."',
			'".$this->moneda."',
			'".$this->cuenta."',
			'".$this->clabe."',
			'".$this->numsuc."',
			'".$this->nomsuc."',
			'".$this->numpla."',
			'".$this->nompla."',
			'".$this->codigosa."',
			1)";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Banco registrado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}


	public function modificarBanco(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE bancos SET
			nombreBanco ='".$this->nombre."',
			monedaBanco = '".$this->moneda."',
			cuentaBanco = '".$this->cuenta."',
			clabeBanco = '".$this->clabe."',
			numSucursalBanco = '".$this->numsuc."',
			nomSucursalBanco = '".$this->nomsuc."',
			numPlazaBanco = '".$this->numpla."',
			nomPlazaBanco = '".$this->nompla."',
			codigoSABanco = '".$this->codigosa."'

			WHERE idBanco = '".$this->id."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Banco modificado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function consultarBancos(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM bancos WHERE statusBanco = 1");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function estadoCuenta(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM estadocuenta WHERE idBanco = '".$this->id."' ORDER BY yyyyBanco, mmBanco, ddBanco ASC");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarIngresos(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT SUM(montoBanco) as ingresos FROM estadocuenta WHERE idBanco = '".$this->id."' AND tipoBanco = 1");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarEgresos(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT SUM(montoBanco) as egresos FROM estadocuenta WHERE idBanco = '".$this->id."' AND tipoBanco = 2");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarRegistros(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM estadocuenta WHERE folioBanco = '".$this->folio."'");

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
			return $resultados = $conexion->query("SELECT folioBanco FROM estadocuenta WHERE folioBanco LIKE '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function registroEstado(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "INSERT INTO estadocuenta (
			folioBanco,
			ddBanco,
			mmBanco,
			yyyyBanco,
			idBanco,
			pagoBanco,
			tipoBanco,
			montoBanco,
			conceptoBanco,
			descBanco,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->dd."',
			'".$this->mm."',
			'".$this->yyyy."',
			'".$this->banco."',
			'".$this->metpago."',
			'".$this->tipo."',
			'".$this->monto."',
			'".$this->concepto."',
			'".$this->descripcion."',
			'".$this->usuario."')";

			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Registrado exitósamente";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}

	public function eliminarBanco(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			$query = "UPDATE bancos 
			SET statusBanco = 2
			WHERE idBanco = '".$this->folio."'";
			
			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Banco eliminado";


		}catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################
	}


}
?>
