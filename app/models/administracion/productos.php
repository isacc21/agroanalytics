<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Febrero 2017 : 9:15                                                             #
#                                                                                    #
###### productos.php #################################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "productos".         #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 1-FEB-17: 9:17                                                                     #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "guardarProducto()"                                     #
# IJLM - Creación del método "modificarProducto()"                                   #
# IJLM - Creación del método "eliminarProducto()"                                    #
# IJLM - Creación del método "consultarProductos()"                                  #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 27-FEB-17: 22:08                                                                   #
# IJLM - Modificacion de métodos GUARDAR Y MODIFICACION en base a la nueva tabla     #
#                                                                                    #
# 01-MAR-17: 08:23                                                                   #
# IJLM - Creación del método "consultarProductosID()"                                #
######################################################################################

date_default_timezone_set('America/Tijuana');

class productos{
  var $codigo;
  var $viejo;
  var $nombre;
  var $presentacion;
  var $tipo;
  var $caducidad;
  var $compra;
  var $distribuidor;
  var $distribuidorM;
  var $grower;
  var $growerM;
  var $cofepris;
  var $ddCof;
  var $mmCof;
  var $yyyyCof;
  var $cicoplafest;
  var $ddCic;
  var $mmCic;
  var $yyyyCic;
  var $semarnat;
  var $ddSem;
  var $mmSem;
  var $yyyySem;
  var $arancel;
  var $densidad;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR PRODUCTO"//////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarProducto(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo producto
      $query = "INSERT INTO productos (
      codigoProducto,
      nombreProducto,
      presentacionProducto,
      tipoProducto,
      caducidadProducto,
      compraProducto,
      iVentaDisProducto,
      mVentaDisProducto,
      iVentaGrwProducto,
      mVentaGrwProducto,
      cofeprisProducto,
      ddCofProducto,
      mmCofProducto,
      yyyyCofProducto,
      cicoplafestProducto,
      ddCicProducto,
      mmCicProducto,
      yyyyCicProducto,
      semarnatProducto,
      ddSemProducto,
      mmSemProducto,
      yyyySemProducto,
      arancelProducto,
      densidadProducto)

      VALUES (
      '".$this->codigo."',
      '".$this->nombre."',
      '".$this->presentacion."',
      '".$this->tipo."',
      '".$this->caducidad."',
      '".$this->compra."',
      '".$this->distribuidor."',
      '".$this->distribuidorM."',
      '".$this->grower."',
      '".$this->growerM."',
      '".$this->cofepris."',
      '".$this->ddCof."',
      '".$this->mmCof."',
      '".$this->yyyyCof."',
      '".$this->cicoplafest."',
      '".$this->ddCic."',
      '".$this->mmCic."',
      '".$this->yyyyCic."',
      '".$this->semarnat."',
      '".$this->ddSem."',
      '".$this->mmSem."',
      '".$this->yyyySem."',
      '".$this->arancel."',
      '".$this->densidad."')"; 

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Producto registrado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR PRODUCTO"//////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR PRODUCTO"////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarProducto(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un producto
      $query = "UPDATE productos SET

      codigoProducto          = '".$this->codigo."',
      nombreProducto          = '".$this->nombre."',
      presentacionProducto    = '".$this->presentacion."',
      tipoProducto            = '".$this->tipo."',
      caducidadProducto       = '".$this->caducidad."',
      compraProducto          = '".$this->compra."',
      iVentaDisProducto       = '".$this->distribuidor."',
      mVentaDisProducto       = '".$this->distribuidorM."',
      iVentaGrwProducto       = '".$this->grower."',
      mVentaGrwProducto       = '".$this->growerM."',
      cofeprisProducto        = '".$this->cofepris."',
      ddCofProducto           = '".$this->ddCof."',
      mmCofProducto           = '".$this->mmCof."',
      yyyyCofProducto         = '".$this->yyyyCof."',
      cicoplafestProducto     = '".$this->cicoplafest."',
      ddCicProducto           = '".$this->ddCic."',
      mmCicProducto           = '".$this->mmCic."',
      yyyyCicProducto         = '".$this->yyyyCic."',
      semarnatProducto        = '".$this->semarnat."',
      ddSemProducto           = '".$this->ddSem."',
      mmSemProducto           = '".$this->mmSem."',
      yyyySemProducto         = '".$this->yyyySem."',
      arancelProducto         = '".$this->arancel."',
      densidadProducto        = '".$this->densidad."'


      WHERE codigoProducto =     '".$this->viejo."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Producto modificado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR PRODUCTO"////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "ELIMINAR PRODUCTO"/////////////////////////////////////////////////////////////////////////////////////////////////////
  public function eliminarProducto(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un producto
      $query = "DELETE FROM productos WHERE codigoProducto = '".$this->codigo."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Producto eliminado exitosamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR PRODUCTO"/////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR PRODUCTOS"////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarProductos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para consultar los productos de la tabla.
      return $resultados = $conexion->query("SELECT * FROM productos");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR PRODUCTOS"///////////////////////////////////////////////////////////////////////////////////////////////////



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
}
?>
