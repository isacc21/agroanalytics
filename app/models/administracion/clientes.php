<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Febrero 2017 : 10:00                                                            #
#                                                                                    #
###### clientes.php ##################################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "clientes".          #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 1-FEB-17: 10:02                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "guardarCliente()"                                      #
# IJLM - Creación del método "modificarCliente()"                                    #
# IJLM - Creación del método "eliminarCliente()"                                     #
# IJLM - Creación del método "consultarClientes()"                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 01-MAR-17: 08:23                                                                   #
# IJLM - Creación del método "consultarClientesID()"                                 #
######################################################################################

date_default_timezone_set('America/Tijuana');

class clientes{
  var $rfc;
  var $viejo;
  var $razon;
  var $calle;
  var $numeroInterior;
  var $numeroExterior;
  var $colonia;
  var $ciudad;
  var $estado;
  var $codigoPostal;
  var $pais;
  var $contacto;
  var $email;
  var $telefono;
  var $celular;
  var $pagina;
  var $tipo;

  var $codigo;
  var $precio;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR CLIENTE"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarCliente(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo cliente
      $query = "INSERT INTO clientes (
      rfcCliente,
      razonSocCliente,
      calleCliente,
      numeroExtCliente,
      numeroIntCliente,
      coloniaCliente,
      codigoPostalCliente,
      ciudadCliente,
      estadoCliente,
      paisCliente,
      contactoCliente,
      emailCliente,
      telefonoCliente,
      celularCliente,
      paginaWebCliente,
      tipoCliente)

      VALUES (
      '".$this->rfc."',
      '".$this->razon."',
      '".$this->calle."',
      '".$this->numeroExterior."',
      '".$this->numeroInterior."',
      '".$this->colonia."',
      '".$this->codigoPostal."',
      '".$this->ciudad."',
      '".$this->estado."',
      '".$this->pais."',
      '".$this->contacto."',
      '".$this->email."',
      '".$this->telefono."',
      '".$this->celular."',
      '".$this->pagina."',
      '".$this->tipo."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cliente registrado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR CLIENTE"///////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR CLIENTE"/////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarCliente(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un cliente
      $query = "UPDATE clientes SET

      rfcCliente =           '".$this->rfc."',
      razonSocCliente =      '".$this->razon."',
      calleCliente =         '".$this->calle."',
      numeroExtCliente =     '".$this->numeroExterior."',
      numeroIntCliente =     '".$this->numeroInterior."',
      coloniaCliente =       '".$this->colonia."',
      codigoPostalCliente =  '".$this->codigoPostal."',
      ciudadCliente =        '".$this->ciudad."',
      estadoCliente =        '".$this->estado."',
      paisCliente =          '".$this->pais."',
      contactoCliente =      '".$this->contacto."',
      emailCliente =         '".$this->email."',
      telefonoCliente =      '".$this->telefono."',
      celularCliente =       '".$this->celular."',
      paginaWebCliente =     '".$this->pagina."',
      tipoCliente =     '".$this->tipo."'

      WHERE rfcCliente =     '".$this->viejo."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cliente modificado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR CLIENTE"/////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "ELIMINAR CLIENTE"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function eliminarCliente(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un cliente
      $query = "DELETE FROM clientes WHERE rfcCliente = '".$this->rfc."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cliente eliminado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR CLIENTE"//////////////////////////////////////////////////////////////////////////////////////////////////////////

//FUNCION "ELIMINAR CLIENTE"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function cuenta(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un cliente
      $query = "SELECT * FROM preciosEspeciales WHERE rfcCliente = '".$this->rfc."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      $cuenta = $statement->rowCount();
      return $cuenta;
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR CLIENTE"//////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarClientes(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los clientes de la tabla.
      return $resultados = $conexion->query("SELECT * FROM clientes");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////




  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarClienteID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los clientes de la tabla.
      return $resultados = $conexion->query("SELECT * FROM clientes WHERE rfcCliente = '".$this->rfc."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProductos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los clientes de la tabla.
      return $resultados = $conexion->query("SELECT * FROM productos");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarEspeciales(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los clientes de la tabla.
      return $resultados = $conexion->query("SELECT * FROM preciosespeciales WHERE codigoProducto = '".$this->codigo."' AND rfcCliente = '".$this->rfc."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR CLIENTES"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR PRODUCTOS"////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProductosID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los productos de la tabla.
      return $resultados = $conexion->query("SELECT * FROM productos WHERE codigoProducto = '".$this->codigo."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR PRODUCTOS"///////////////////////////////////////////////////////////////////////////////////////////////////

   //FUNCION "GUARDAR CLIENTE"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarPrecio(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo cliente
      $query = "INSERT INTO preciosespeciales (
      idEspecial,
      codigoProducto,
      precioEspecial,
      rfcCliente)

      VALUES (
      NULL,
      '".$this->codigo."',
      '".$this->precio."',
      '".$this->rfc."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "listo";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR CLIENTE"///////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "ELIMINAR CLIENTE"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function limpiarPE(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un cliente
      $query = "DELETE FROM preciosespeciales WHERE rfcCliente = '".$this->rfc."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Limpio";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR CLIENTE"//////////////////////////////////////////////////////////////////////////////////////////////////////////

}
?>
