<?php
##################################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                            #
# 02 Febrero 2017 : 13:29                                                                        #
#                                                                                                #
###### dolares/cuentasPagar ######################################################################
#                                                                                                #
# Archivo para realizar consultas o acciones directamente en la base de datos.                   #
# Archivo donde se ejecutan los métodos que necesita la sección "cuentas por cobrar - dolares".  #
#                                                                                                #
###### HISTORIAL DE MODIFICACIONES ###############################################################
#                                                                                                #
# 2-FEB-17: 13:30                                                                                #
# IJLM - Creacion de Variables                                                                   #
# IJLM - Creación del método constructor                                                         #
# IJLM - Creación del método "crearCuentaP()"                                                    #
# IJLM - Creación del método "modificarCuentaP()"                                                #
# IJLM - Creación del método "cancelarCuentaP()"                                                 #
# IJLM - Creación del método "saldarCuentaP()"                                                   #
# IJLM - Creación del método "consultarCuentasP()"                                               #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')                       #
##################################################################################################

date_default_timezone_set('America/Tijuana');

class usdCuentasP{
  var $folio;
  var $dd;
  var $mm;
  var $yyyy;
  var $acreedor;
  var $proveedor;
  var $factura;
  var $monto;
  var $comentario;
  var $id;
  var $viejo;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR CUENTA"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function crearCuentaP(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo registro en bancos - dolares
      $query = "INSERT INTO usdcuentasp (
      folioCuentaP,
      ddCuentaP,
      mmCuentaP,
      yyyyCuentaP,
      rfcProveedor,
      rfcAcreedor,
      folioFactura,
      importeCuentaP,
      comentarioCuentaP,
      statusCuentaP,
      idUsuario)

      VALUES (
      '".$this->folio."',
      '".$this->dd."',
      '".$this->mm."',
      '".$this->yyyy."',
      '".$this->proveedor."',
      '".$this->acreedor."',
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
  public function modificarCuentaP(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdcuentasp SET

      ddCuentaP =             '".$this->dd."',
      mmCuentaP =             '".$this->mm."',
      yyyyCuentaP =           '".$this->yyyy."',
      rfcProveedor =          '".$this->proveedor."',
      rfcAcreedor =           '".$this->acreedor."',
      folioFactura =          '".$this->factura."',
      importeCuentaP =        '".$this->monto."',
      comentarioCuentaP =     '".$this->comentario."'

      WHERE folioCuentaP =    '".$this->viejo."'";

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
  public function cancelarCuentaP(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdcuentasp SET

      statusCuentaP = 2,
      idUsuario = '".$this->id."'

      WHERE folioCuentaP =   '".$this->folio."'";

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
  public function saldarCuentaP(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE usdcuentasp SET

      statusCuentaP = 3,
      idUsuario = '".$this->id."'

      WHERE folioCuentaP =   '".$this->folio."'";

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
  public function consultarCuentasP(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasp ORDER BY yyyyCuentaP DESC, mmCuentaP DESC, ddCuentaP DESC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarCuentasPxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usdcuentasp WHERE folioCuentaP = '".$this->folio."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProveedoresxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM proveedores WHERE rfcProveedor = '".$this->proveedor."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProveedores(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM proveedores");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarAcreedoresxID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM acreedores WHERE rfcAcreedor = '".$this->acreedor."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarAcreedores(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM acreedores");

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
      return $resultados = $conexion->query("SELECT * FROM usdcuentasp WHERE statusCuentaP = 1 ORDER BY yyyyCuentaP DESC, mmCuentaP DESC, ddCuentaP DESC");

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
      return $resultados = $conexion->query("SELECT * FROM usdcuentasp WHERE statusCuentaP = 2 ORDER BY yyyyCuentaP DESC, mmCuentaP DESC, ddCuentaP DESC");

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
      return $resultados = $conexion->query("SELECT * FROM usdcuentasp WHERE statusCuentaP = 3 ORDER BY yyyyCuentaP DESC, mmCuentaP DESC, ddCuentaP DESC");

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
      return $resultados = $conexion->query("SELECT folioCuentaP FROM usdcuentasp WHERE folioCuentaP LIKE '".$this->codigo."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }

}

?>
