<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Febrero 2017 : 9:30                                                             #
#                                                                                    #
###### transportistas.php ############################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "transportistas".    #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 1-FEB-17: 9:32                                                                     #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "guardarTransportista()"                                #
# IJLM - Creación del método "modificarTransportista()"                              #
# IJLM - Creación del método "eliminarTransportistas()"                              #
# IJLM - Creación del método "consultarTransportistas()"                             #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 01-MAR-17: 08:23                                                                   #
# IJLM - Creación del método "consultarTransportistasID()"                           #
######################################################################################

date_default_timezone_set('America/Tijuana');

class transportistas{
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
  var $idFiscal;
  var $sccac;
  var $caat;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR TRANSPORTISTA"//////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarTransportista(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo transportista
      $query = "INSERT INTO transportistas (
      rfcTransportista,
      razonSocTransportista,
      calleTransportista,
      numeroExtTransportista,
      numeroIntTransportista,
      coloniaTransportista,
      codigoPostalTransportista,
      ciudadTransportista,
      estadoTransportista,
      paisTransportista,
      contactoTransportista,
      emailTransportista,
      telefonoTransportista,
      celularTransportista,
      paginaWebTransportista,
      idFiscalTransportista,
      sccacTransportista,
      caatTransportista)

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
      '".$this->idFiscal."',
      '".$this->sccac."',
      '".$this->caat."')";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Transportista registrado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR TRASNPORTISTA"//////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR TRANSPORTISTA"////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarTransportista(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un transportista
      $query = "UPDATE transportistas SET

          rfcTransportista =           '".$this->rfc."',
          razonSocTransportista =      '".$this->razon."',
          calleTransportista   =       '".$this->calle."',
          numeroExtTransportista =     '".$this->numeroExterior."',
          numeroIntTransportista   =   '".$this->numeroInterior."',
          coloniaTransportista =       '".$this->colonia."',
          codigoPostalTransportista =  '".$this->codigoPostal."',
          ciudadTransportista =        '".$this->ciudad."',
          estadoTransportista =        '".$this->estado."',
          paisTransportista  =         '".$this->pais."',
          contactoTransportista =      '".$this->contacto."',
          emailTransportista   =       '".$this->email."',
          telefonoTransportista =      '".$this->telefono."',
          celularTransportista =       '".$this->celular."',
          paginaWebTransportista =     '".$this->pagina."',
          idFiscalTransportista =      '".$this->idFiscal."',
          sccacTransportista =         '".$this->sccac."',
          caatTransportista =          '".$this->caat."'

          WHERE rfcTransportista =     '".$this->viejo."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Transportista modificado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR TRANSPORTISTA"////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "ELIMINAR TRANSPORTISTA"/////////////////////////////////////////////////////////////////////////////////////////////////////
  public function eliminarTransportista(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un transportista
      $query = "DELETE FROM transportistas WHERE rfcTransportista = '".$this->rfc."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Transportista eliminado exitosamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR TRANSPORTISTA"/////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR TRANSPORTISTA"////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarTransportista(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los transportistas de la tabla.
      return $resultados = $conexion->query("SELECT * FROM transportistas");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR TRANSPORTISTAS"///////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR TRANSPORTISTA"////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarTransportistaID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
      dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los transportistas de la tabla.
      return $resultados = $conexion->query("SELECT * FROM transportistas WHERE rfcTransportista = '".$this->rfc."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR TRANSPORTISTAS"///////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
