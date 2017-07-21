<?php 
date_default_timezone_set('America/Tijuana'); 

class remisiones{

	//VARIABLES
	var $codigo;
	var $folio;
	var $adicional;
	var $id;
	var $carga;
	var $pedido;

	var $dd;
	var $mm;
	var $yy;

	var $producto;
	var $cantidad;




	// DECLARACIÓN DEL MÉTODO CONSTRUCTOR
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}


	public function nuevaRemision(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO remisiones (
			folioRemision,
			folioOrdenCarga,
			adicionalRemision,
			ddRemision,
			mmRemision,
			yyyyRemision,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->carga."',
			'".$this->adicional."',
			'".$this->dd."',
			'".$this->mm."',
			'".$this->yyyy."',
			'".$this->id."'
			)";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "listo";
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
			return $resultados = $conexion->query("SELECT folioRemision FROM remisiones WHERE folioRemision LIKE '".$this->codigo."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarOrdenesCarga(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescarga WHERE folioOrdenCarga = '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarDetallePedido(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM detallepedidos WHERE folioPedido = '".$this->pedido."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarExistencia(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM inventario WHERE codigoProducto = '".$this->producto."' ORDER BY idInventario ASC");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


		public function restarInventario(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE inventario SET

			existenciaInventario = '".$this->cantidad."'

			WHERE barCodeInventario =   '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "listo";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

}//LLAVE DE CLASE REMISIONES
?>