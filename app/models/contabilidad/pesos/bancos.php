<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 02 Febrero 2017 : 13:13                                                            #
#                                                                                    #
###### pesos/bancos.php ##############################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "bancos - pesos".    #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 2-FEB-17: 13:14                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "registroBancoMXN()"                                    #
# IJLM - Creación del método "modificarRegistroBancoMXN()"                           #
# IJLM - Creación del método "cancelarRegistroBancoMXN()"                            #
# IJLM - Creación del método "consultarRegistrosBancoMXN()"                          #
# IJLM - Creación del método "consultarIngresosBancoMXN()"                           #
# IJLM - Creación del método "consultarEgresosBancoMXN()"                            #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
######################################################################################

date_default_timezone_set('America/Tijuana');

class usdBancos{
  var $folio;
  var $referencia;
  var $tipo;
  var $monto;
  var $detalle;
  var $comentario;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR REGISTRO"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function registroBancoMXN(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - PESOS
      $query = "INSERT INTO mxnBancos (
      folioMXNBanco,
      ddMXNBanco,
      mmMXNBanco,
      yyyyMXNBanco,
      referenciaMXNBanco,
      tipMXNDBanco,
      montoMXNBanco,
      detalleMXNBanco,
      comentarioUSDBanco,
      statusMXNBanco)

      VALUES (
      '".$this->folio."',
      '".date(d)."',
      '".date(m)."',
      '".date(Y)."',
      '".$this->referencia."',
      '".$this->tipo."',
      '".$this->monto."',
      '".$this->detalle."',
      '".$this->comentario."',
      1)";

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
  public function modificarRegistroBancoMXN(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE mxnBancos SET

          referenciaMXNBanco =    '".$this->referencia."',
          tipoMXNBanco =          '".$this->tipo."',
          montoMXNBanco =         '".$this->monto."',
          detalleMXNBanco =       '".$this->detalle."',
          comentarioMXNBanco =    '".$this->comentario."'

          WHERE folioMXNBanco =   '".$this->folio."'";

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
  public function cancelarRegistroBancoMXN(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE mxnBancos SET

          statusMXNBanco = 2

          WHERE folioMXNBanco =   '".$this->folio."'";

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
      return $resultados = $conexion->query("SELECT * FROM usBancos");

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
      return $resultados = $conexion->query("SELECT SUM(montoUSDBanco) as ingresos FROM usdBancos WHERE tipoUSDBanco = 1");

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
      return $resultados = $conexion->query("SELECT SUM(montoUSDBanco) as egresos FROM usdBancos WHERE tipoUSDBanco = 2");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR EGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarRegistrosBancoMXN(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM mxnBancos");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR INGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarIngresosBancoMXN(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT SUM(montoMXNBanco) as ingresos FROM mxnBancos WHERE tipoMXNBanco = 1");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR INGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR EGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarEgresosBancoMXN(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT SUM(montoMXNBanco) as egresos FROM mxnBancos WHERE tipoMXNBanco = 2");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR EGRESOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
}

?>
