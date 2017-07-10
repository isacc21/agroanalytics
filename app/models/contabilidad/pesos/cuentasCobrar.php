<?php
##################################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                            #
# 02 Febrero 2017 : 14:13                                                                        #
#                                                                                                #
###### pesos/cuentasCobrar.php ###################################################################
#                                                                                                #
# Archivo para realizar consultas o acciones directamente en la base de datos.                   #
# Archivo donde se ejecutan los métodos que necesita la sección "cuentas por cobrar - pesos".    #
#                                                                                                #
###### HISTORIAL DE MODIFICACIONES ###############################################################
#                                                                                                #
# 2-FEB-17: 14:14                                                                                #
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
  var $cliente;
  var $factura;
  var $monto;
  var $comentario;

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
      $query = "INSERT INTO mxnCuentasC (
      folioCuentaC,
      ddCuentaC,
      mmCuentaC,
      yyyyCuentaC,
      rfcProveedor,
      rfcAcreedor,
      folioFactura,
      importeCuentaC,
      comentarioCuentaC,
      statusCuentaC)

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
  public function modificarCuentaC(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un registro
      $query = "UPDATE mxnCuentasC SET

          rfcProveedor =          '".$this->proveedor."',
          rfcAcreedor =           '".$this->acreedor."',
          folioFactura =          '".$this->factura."',
          importeCuentaC =        '".$this->importe."',
          comentarioCuentaC =     '".$this->comentario."'

          WHERE folioCuentaC =    '".$this->folio."'";

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
      $query = "UPDATE mxnCuentasC SET

          statusCuentaC = 2

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
      $query = "UPDATE mxnCuentasC SET

          statusCuentaC = 3

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
      return $resultados = $conexion->query("SELECT * FROM mxnCuentasC");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR REGISTROS"////////////////////////////////////////////////////////////////////////////////////////////////////////

}

?>
