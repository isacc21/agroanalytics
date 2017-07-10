<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Febrero 2017 : 12:06                                                            #
#                                                                                    #
###### dolares/bancos.php ############################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "bancos - dolares".  #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 2-FEB-17: 12:08                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "registroBancoUSD()"                                    #
# IJLM - Creación del método "modificarRegistroBancoUSD()"                           #
# IJLM - Creación del método "cancelarRegistroBancoUSD()"                            #
# IJLM - Creación del método "consultarRegistrosBancoUSD()"                          #
# IJLM - Creación del método "consultarIngresosBancoUSD()"                           #
# IJLM - Creación del método "consultarEgresosBancoUSD()"                            #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
######################################################################################

date_default_timezone_set('America/Tijuana');

class usdBancos{
  var $folio;
  var $viejo;
  var $referencia;
  var $tipo;
  var $monto;
  var $detalle;
  var $comentario;
  var $id;
  var $dd;
  var $mm;
  var $yyyy;

  var $codigo;
  var $numeral;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR REGISTRO"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function registroBancoUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - dolares
      $query = "INSERT INTO usdbancos (
      folioUSDBanco,
      ddUSDBanco,
      mmUSDBanco,
      yyyyUSDBanco,
      referenciaUSDBanco,
      tipoUSDBanco,
      montoUSDBanco,
      detalleUSDBanco,
      comentarioUSDBanco,
      statusUSDBanco,
      idUsuario)

      VALUES (
      '".$this->folio."',
      '".$this->dd."',
      '".$this->mm."',
      '".$this->yyyy."',
      '".$this->referencia."',
      '".$this->tipo."',
      '".$this->monto."',
      '".$this->detalle."',
      '".$this->comentario."',
      1,
      '".$this->id."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Registro exitoso";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR REGISTRO"///////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarRegistroBancoUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdbancos SET

      ddUSDBanco =            '".$this->dd."',
      mmUSDBanco =            '".$this->mm."',
      yyyyUSDBanco =          '".$this->yyyy."',
      referenciaUSDBanco =    '".$this->referencia."',
      tipoUSDBanco =          '".$this->tipo."',
      montoUSDBanco =         '".$this->monto."',
      detalleUSDBanco =       '".$this->detalle."',
      comentarioUSDBanco =    '".$this->comentario."',
      idUsuario =             '".$this->id."'

      WHERE folioUSDBanco =   '".$this->viejo."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Modificación Exitosa";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CANCELAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function cancelarRegistroBancoUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdbancos SET

      statusUSDBanco = 2,
      idUsuario = '".$this->id."'

      WHERE folioUSDBanco =   '".$this->folio."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cancelación Exitosa";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CANCELAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarRegistrosBancoUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdbancos ORDER BY yyyyUSDBanco DESC, mmUSDBanco DESC, ddUSDBanco DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR INGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarIngresosBancoUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT SUM(montoUSDBanco) as ingresos FROM usdbancos WHERE tipoUSDBanco = 1 AND statusUSDBanco = 1");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR INGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR EGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarEgresosBancoUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT SUM(montoUSDBanco) as egresos FROM usdbancos WHERE tipoUSDBanco = 2 AND statusUSDBanco = 1");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR EGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarRegistrosBancoUSDxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdbancos WHERE folioUSDBanco = '".$this->folio."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarCanceladosUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdbancos WHERE statusUSDBanco = 2 ORDER BY yyyyUSDBanco DESC, mmUSDBanco DESC, ddUSDBanco DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarRegistradosUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdbancos WHERE statusUSDBanco = 1 ORDER BY yyyyUSDBanco DESC, mmUSDBanco DESC, ddUSDBanco DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarIngresosUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdbancos WHERE tipoUSDBanco = 1 ORDER BY yyyyUSDBanco DESC, mmUSDBanco DESC, ddUSDBanco DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarEgresosUSD(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdbancos WHERE tipoUSDBanco = 2 ORDER BY yyyyUSDBanco DESC, mmUSDBanco DESC, ddUSDBanco DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////



  public function consultarCodigos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT folioUSDBanco FROM usdbancos WHERE folioUSDBanco LIKE '".$this->codigo."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }

}
?>
