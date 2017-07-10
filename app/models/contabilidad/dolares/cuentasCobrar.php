<?php
##################################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                            #
# 06 Febrero 2017 : 15:59                                                                        #
#                                                                                                #
###### dolares/cuentasCobrar.php #################################################################
#                                                                                                #
# Archivo para realizar consultas o acciones directamente en la base de datos.                   #
# Archivo donde se ejecutan los métodos que necesita la sección "cuentas por cobrar - dolares".  #
#                                                                                                #
###### HISTORIAL DE MODIFICACIONES ###############################################################
#                                                                                                #
# 6-FEB-17: 16:00                                                                                #
# IJLM - Creacion de Variables                                                                   #
# IJLM - Creación del método constructor                                                         #
# IJLM - Creación del método "crearCuentaC()"                                                    #
# IJLM - Creación del método "modificarCuentaC()"                                                #
# IJLM - Creación del método "cancelarCuentaC()"                                                 #
# IJLM - Creación del método "saldarCuentaC()"                                                   #
# IJLM - Creación del método "consultarCuentasC()"                                               #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')                       #
##################################################################################################

date_default_timezone_set('America/Tijuana');

class usdCuentasC{
  var $folio;
  var $viejo;
  var $dd;
  var $mm;
  var $yyyy;
  var $cliente;
  var $factura;
  var $monto;
  var $comentario;
  var $id;
  var $rfc;

  var $codigo;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR CUENTA"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function crearCuentaC(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - dolares
      $query = "INSERT INTO usdcuentasc (
      folioCuentaC,
      ddCuentaC,
      mmCuentaC,
      yyyyCuentaC,
      rfcCliente,
      folioFactura,
      importeCuentaC,
      comentarioCuentaC,
      statusCuentaC,
      idUsuario)

      VALUES (
      '".$this->folio."',
      '".$this->dd."',
      '".$this->mm."',
      '".$this->yyyy."',
      '".$this->cliente."',
      '".$this->factura."',
      '".$this->monto."',
      '".$this->comentario."',
      1,
      '".$this->id."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Registro Exitoso";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR REGISTRO"///////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarCuentaC(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdcuentasc SET

      ddCuentaC =             '".$this->dd."',
      mmCuentaC =             '".$this->mm."',
      yyyyCuentaC =           '".$this->yyyy."',
      rfcCliente =            '".$this->cliente."',
      folioFactura =          '".$this->factura."',
      importeCuentaC =        '".$this->monto."',
      comentarioCuentaC =     '".$this->comentario."',
      idUsuario =             '".$this->id."'

      WHERE folioCuentaC =    '".$this->viejo."'";

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
  public function cancelarCuentaC(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdcuentasc SET

      statusCuentaC = 2,
      idUsuario = '".$this->id."'

      WHERE folioCuentaC =   '".$this->folio."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cancelación Exitosa";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CANCELAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "SALDAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function saldarCuentaC(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdcuentasc SET

      statusCuentaC = 3,
      idUsuario = '".$this->id."'

      WHERE folioCuentaC =   '".$this->folio."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Cuenta Saldada con Éxito";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "SALDAR REGISTRO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarCuentasC(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasc ORDER BY yyyyCuentaC DESC, mmCuentaC DESC, ddCuentaC DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarCuentasCxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasc WHERE folioCuentaC = '".$this->folio."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////


   //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarClientesxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM clientes WHERE rfcCliente = '".$this->rfc."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarClientes(){
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
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarRegistradas(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasc WHERE statusCuentaC = 1 ORDER BY yyyyCuentaC DESC, mmCuentaC DESC, ddCuentaC DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarCanceladas(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasc WHERE statusCuentaC = 2 ORDER BY yyyyCuentaC DESC, mmCuentaC DESC, ddCuentaC DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarSaldadas(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasc WHERE statusCuentaC = 3 ORDER BY yyyyCuentaC DESC, mmCuentaC DESC, ddCuentaC DESC");

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
      return $resultados = $conexion->query("SELECT folioCuentaC FROM usdcuentasc WHERE folioCuentaC LIKE '".$this->codigo."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }

}

?>
