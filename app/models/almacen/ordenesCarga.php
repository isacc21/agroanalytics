<?php


date_default_timezone_set('America/Tijuana');

class ordenesCarga{

	var $producto;
	var $codigo;

	var $folio;
	var $pedido;
	var $dd;
	var $mm;
	var $yyyy;
	var $remision;
	var $id;

	var $cantidad;
	var $cliente;



	// DECLARACIÓN DEL MÉTODO CONSTRUCTOR
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	//FUNCION "NUEVA ORDEN"////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function generarOrdenCarga(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO ordenescarga (
			folioOrdenCarga,
			folioPedido,
			ddOrdenCarga,
			mmOrdenCarga,
			yyyyOrdenCarga,
			statusOrdenCarga,
			remisionCarga,
			idUsuario)

			VALUES (
			'".$this->folio."',
			'".$this->pedido."',
			'".date('d')."',
			'".date('m')."',
			'".date('Y')."',
			1,
			'".$this->remision."',
			'".$this->id."'
			)";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Orden de Carga registrada";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function quemarPedido(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE pedidos SET

			statusPedido =    2,
			idUsuario = '".$this->id."'

			WHERE folioPedido =   '".$this->pedido."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "listo";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function consultarClientesAll(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM clientes");

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


	public function consultarPrecios(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM preciosespeciales WHERE rfcCliente = '".$this->cliente."' AND codigoProducto = '".$this->producto."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarPedidosID(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM pedidos WHERE folioPedido LIKE '".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function consultarCargas(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescarga");

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
			return $resultados = $conexion->query("SELECT * FROM detallepedidos WHERE folioPedido = '".$this->pedido."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarRemision(){
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


	public function agregarRemision(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE ordenescarga SET

			statusOrdenCarga =    2,
			remisionCarga = '".$this->remision."',
			idUsuario = '".$this->id."'

			WHERE folioOrdenCarga =   '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "listo";
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


	public function consultarCodigos(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT folioOrdenCarga FROM ordenescarga WHERE folioOrdenCarga LIKE '".$this->codigo."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function inventarioEsp(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT SUM(existenciaInventario) FROM inventario WHERE codigoProducto = '".$this->producto."'");

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

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM clientes WHERE rfcCliente = '".$this->cliente."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarCargasSS(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM ordenescarga WHERE statusOrdenCarga = 1");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

}

?>
