<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Febrero 2017 : 9:45                                                             #
#                                                                                    #
###### proveedores.php ###############################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "proveedores".       #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 1-FEB-17: 9:47                                                                     #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "guardarProveedor()"                                    #
# IJLM - Creación del método "modificarProveedor()"                                  #
# IJLM - Creación del método "eliminarProveedor()"                                   #
# IJLM - Creación del método "consultarProveedores()"                                #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 24-FEB-17: 14:10                                                                   #
# IJLM - Creación del método "consultarProveedoresID()"                              #
######################################################################################

date_default_timezone_set('America/Tijuana');

class proveedores{
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

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR PROVEEDOR"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarProveedor(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo proveedor
      $query = "INSERT INTO proveedores (
      rfcProveedor,
      razonSocProveedor,
      calleProveedor,
      numeroExtProveedor,
      numeroIntProveedor,
      coloniaProveedor,
      codigoPostalProveedor,
      ciudadProveedor,
      estadoProveedor,
      paisProveedor,
      contactoProveedor,
      emailProveedor,
      telefonoProveedor,
      celularProveedor,
      paginaWebProveedor)

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
      '".$this->pagina."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Proveedor registrado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR PROOVEDOR"///////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR PROVEEDOR"/////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarProveedor(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un proveedor
      $query = "UPDATE proveedores SET

      rfcProveedor =           '".$this->rfc."',
      razonSocProveedor =      '".$this->razon."',
      calleProveedor =         '".$this->calle."',
      numeroExtProveedor =     '".$this->numeroExterior."',
      numeroIntProveedor =     '".$this->numeroInterior."',
      coloniaProveedor =       '".$this->colonia."',
      codigoPostalProveedor =  '".$this->codigoPostal."',
      ciudadProveedor =        '".$this->ciudad."',
      estadoProveedor =        '".$this->estado."',
      paisProveedor =          '".$this->pais."',
      contactoProveedor =      '".$this->contacto."',
      emailProveedor =         '".$this->email."',
      telefonoProveedor =      '".$this->telefono."',
      celularProveedor =       '".$this->celular."',
      paginaWebProveedor =     '".$this->pagina."'

      WHERE rfcProveedor =     '".$this->viejo."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Proveedor modificado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR PROVEEDOR"/////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "ELIMINAR PROVEEDOR"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function eliminarProveedor(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un proveedor
      $query = "DELETE FROM proveedores WHERE rfcProveedor = '".$this->rfc."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Proveedor eliminado exitosamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR PROVEEDOR"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR PROVEEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProveedores(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los clientes de la tabla.
      return $resultados = $conexion->query("SELECT * FROM proveedores");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR PROVEEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR PROVEEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProveedoresID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los clientes de la tabla.
      return $resultados = $conexion->query("SELECT * FROM proveedores WHERE rfcProveedor = '".$this->rfc."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR PROVEEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////
}

?>
