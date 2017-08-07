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
	var $remision;
	var $pedimento;

	var $dd;
	var $mm;
	var $yy;

	var $producto;
	var $cantidad;
	var $cliente;




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

	public function detalleRemision(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para crear una nueva orden de compra
			$query = "INSERT INTO detalleremisiones (
			idDetalleRemision,
			folioRemision,
			folioPedimento)

			VALUES (
			NULL,
			'".$this->remision."',
			'".$this->pedimento."'
			)";

			$statement = $conexion->prepare($query);

			$statement->execute();

			//return "listo";
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
			return $resultados = $conexion->query("SELECT * FROM ordenescarga WHERE folioOrdenCarga = '".$this->carga."'");

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
			return $resultados = $conexion->query("SELECT * FROM inventario WHERE barCodeInventario LIKE 'K%' AND codigoProducto = '".$this->producto."' AND existenciaInventario > 0 ORDER BY idInventario ASC");

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

	public function consultarEE(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM inventario WHERE barCodeInventario LIKE 'EE%' AND codigoProducto = '".$this->producto."' and existenciaInventario > 0 ORDER BY idInventario ASC");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function remisionarODCarga(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para modificar un registro
			$query = "UPDATE ordenescarga SET

			statusOrdenCarga = 2,
			remisionCarga    = '".$this->remision."',
			idUsuario        = '".$this->id."'

			WHERE folioOrdenCarga =   '".$this->folio."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			//return "listo";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarImportacionesxID(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM importaciones WHERE folioImportacion = '".$this->folio."'");

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

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM remisiones");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarRemisionesID(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM remisiones WHERE folioRemision ='".$this->folio."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarPedidosxID(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM pedidos WHERE folioPedido = '".$this->pedido."'");

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

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM clientes WHERE rfcCliente = '".$this->cliente."'");

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

	public function consultarDetalleRemision(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT DISTINCT folioPedimento FROM detalleremisiones WHERE folioRemision = '".$this->remision."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

}//LLAVE DE CLASE REMISIONES
?>