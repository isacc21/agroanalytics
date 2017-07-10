<?php
##################################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                            #
# 02 Febrero 2017 : 14:04                                                                        #
#                                                                                                #
###### pesos/cuentasPagar.php ####################################################################
#                                                                                                #
# Archivo para realizar consultas o acciones directamente en la base de datos.                   #
# Archivo donde se ejecutan los métodos que necesita la sección "cuentas por pagar - pesos".     #
#                                                                                                #
###### HISTORIAL DE MODIFICACIONES ###############################################################
#                                                                                                #
# 2-FEB-17: 14:06                                                                                #
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
  var $cliente;
  var $factura;
  var $monto;
  var $comentario;

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
      $query = "INSERT INTO usdCuentasP (
      folioCuentaP,
      ddCuentaP,
      mmCuentaP,
      yyyyCuentaP,
      rfcProveedor,
      rfcAcreedor,
      folioFactura,
      importeCuentaP,
      comentarioCuentaP,
      statusCuentaP)

      VALUES (
      '".$this->folio."',
      '".date(d)."',
      '".date(m)."',
      '".date(Y)."',
      '".$this->proveedor."',
      '".$this->acreedor."',
      '".$this->factura."',
      '".$this->monto."',
      '".$this->comentario."',
      1)";

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
      $query = "UPDATE mxnCuentasP SET

          rfcProveedor =          '".$this->proveedor."',
          rfcAcreedor =           '".$this->acreedor."',
          folioFactura =          '".$this->factura."',
          importeCuentaP =        '".$this->importe."',
          comentarioCuentaP =     '".$this->comentario."'

          WHERE folioCuentaP =    '".$this->folio."'";

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
      $query = "UPDATE mxnCuentasP SET

          statusCuentaP = 2

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
      $query = "UPDATE mxnCuentasP SET

          statusCuentaP = 3

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
      return $resultados = $conexion->query("SELECT * FROM mxnCuentasP");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

}

?>
