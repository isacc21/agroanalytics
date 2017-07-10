<?php 
date_default_timezone_set('America/Tijuana');

class pedidos{
  var $folio;
  var $cliente;
  var $dd;
  var $mm;
  var $yyyy;
  var $total;
  var $id;
  var $status;

  var $producto;
  var $cantidad;
  var $monto;
  var $pedido;

  var $codigo;


  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarPedidosxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM pedidos WHERE folioPedido = '".$this->folio."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarCotizacionesxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM cotizaciones WHERE folioCotizacion = '".$this->folio."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////


  public function registrarPedido(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - dolares
      $query = "INSERT INTO pedidos (
      folioPedido,
      rfcCliente,
      statusPedido,
      totalPedido,
      ddPedido,
      mmPedido,
      yyyyPedido,      
      idUsuario)

      VALUES (
      '".$this->folio."',
      '".$this->cliente."',
      1,
      '".$this->total."',
      '".$this->dd."',
      '".$this->mm."',
      '".$this->yyyy."',
      '".$this->id."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Pedido establecido";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }


  public function usarCotizacion(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - dolares
      $query = "UPDATE cotizaciones SET 
      statusCotizacion = 4, 
      idUsuario = '".$this->id."', 
      folioPedido = '".$this->pedido."' 
      WHERE folioCotizacion = '".$this->folio."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Listo";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarDetallesCoti(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM detallecotizacion WHERE folioCotizacion = '".$this->folio."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  public function registrarDetalle(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - dolares
      $query = "INSERT INTO detallepedidos (
      idDetallePedido,
      folioPedido,
      codigoProducto,
      cantidadDetallePedido,
      montoDetallePedido)

      VALUES (
      NULL,
      '".$this->folio."',
      '".$this->producto."',
      '".$this->cantidad."',
      '".$this->monto."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Registro detalle exitoso";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }


  public function consultarPedidos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM pedidos");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }


  public function consultarPedidosDisponibles(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM pedidos WHERE statusPedido = 1");

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


  public function consultarDetalle(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM detallepedidos WHERE folioPedido = '".$this->folio."'");

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

  //FUNCION "CANCELAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function cancelarPedido(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE pedidos SET

          statusPedido = 3,
          idUsuario = '".$this->id."'

          WHERE folioPedido =   '".$this->folio."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cancelación Exitosa";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CANCELAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////


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


  //////////////////////////////
  public function consultarPrecios(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT 
        a.codigoProducto, 
        a.ventaProducto, 
        b.precioEspecial, 
        b.rfcCliente 
        FROM productos AS a 
        INNER JOIN preciosespeciales AS b 
        ON a.codigoProducto = b.codigoProducto 
        WHERE a.codigoProducto = '".$this->producto."'");

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
      return $resultados = $conexion->query("SELECT folioPedido FROM pedidos WHERE folioPedido LIKE '".$this->codigo."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  


  public function consultarPedidosEnCotizaciones(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM cotizaciones WHERE folioPedido =  '".$this->pedido."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
}
?>