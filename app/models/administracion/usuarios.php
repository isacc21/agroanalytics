<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Febrero 2017 : 10:30                                                            #
#                                                                                    #
###### usuarios.php ##################################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "usuarios".          #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 1-FEB-17: 10:32                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Utilización de método "session_start()"                                     #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "guardarUsuario()"                                      #
# IJLM - Creación del método "modificarUsuario()"                                    #
# IJLM - Creación del método "eliminarUsuario()"                                     #
# IJLM - Creación del método "consultarUsuarios()"                                   #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 20-FEB-17: 16:34                                                                   #
# IJLM - Creación del método "consultarUsuariosID()"                                 #
#                                                                                    #
# 21-FEB-17: 11:03                                                                   #
# IJLM - Creación del método "consultarUsuariosNick()"                               #
#                                                                                    #
# 04-MAR-17: 20:15                                                                   #
# IJLM - Creación del método "consultarUltimo()"                                     #
# IJLM - Creación del método "guardarPermisos()"                                     #
# IJLM - Creación del método "consultarPermisos()"                                   #
# IJLM - Creación del método "modificarPermisos()"                                   #
# IJLM - Creación del método "loginUsuario()"                                        #
######################################################################################

date_default_timezone_set('America/Tijuana');

// Método para realizar el inicio de sesión por parte de los usuarios
session_start();

class usuarios{
  var $id;
  var $nombre;
  var $apellidos;
  var $nick;
  var $password;

  var $proveedores;
  var $acreedores;
  var $transportistas;
  var $clientes;
  var $productos;
  var $aduanal;
  var $persona;
  var $pedidos;
  var $cotizaciones;
  var $importaciones;
  var $declaraciones;
  var $inventario;
  var $carga;
  var $compra;
  var $remisiones;
  var $bancos;
  var $cxc;
  var $cxp;

  // DECLARACIÓN DEL MÉTODO CONSTRUCTOR
  function __construct($datosConexionBD){
    $this->datosConexionBD=$datosConexionBD;
  }

  //FUNCION "GUARDAR USUARIO"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarUsuario(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo usuario
      $query = "INSERT INTO usuarios (idUsuario, nombreUsuario, apellidosUsuario, nickUsuario, passwordUsuario, tipoUsuario, statusUsuario, entradaUsuario)
      VALUES (NULL, '".$this->nombre."', '".$this->apellidos."',
      '".$this->nick."', '".$this->password."', 2, 0, 0)";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Usuario registrado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR USUARIO"///////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarUsuario(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un usuario
      $query = "UPDATE usuarios SET

      nombreUsuario =       '".$this->nombre."',
      apellidosUsuario =  '".$this->apellidos."',
      nickUsuario =         '".$this->nick."',
      passwordUsuario =     '".$this->password."'

      WHERE idUsuario =     '".$this->id."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Usuario modificado exitósamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "ELIMINAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function eliminarUsuario(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      $query = "DELETE FROM usuarios WHERE idUsuario = '".$this->id."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Usuario eliminado exitosamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "ELIMINAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarUsuarios(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usuarios");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarUsuariosNA(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usuarios WHERE tipoUsuario=2");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarUsuariosID(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usuarios WHERE idUsuario='".$this->id."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarUsuariosNick(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT * FROM usuarios WHERE nickUsuario='".$this->nick."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////



//FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarUltimo(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query("SELECT idUsuario FROM usuarios ORDER BY idUsuario DESC LIMIT 1");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR USUARIOS"////////////////////////////////////////////////////////////////////////////////////////////////////////

//FUNCION "GUARDAR USUARIO"///////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function guardarPermisos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para guardar nuevo usuario
      $query = "INSERT INTO permisos (
      idPermiso, 
      proveedoresPermiso,
      acreedoresPermiso,
      transportistasPermiso,
      clientesPermiso,
      productosPermiso,
      aduanalPermiso,
      usuariosPermiso,
      pedidosPermiso,
      cotizacionesPermiso,
      importacionesPermiso,
      declaracionesPermiso,
      inventarioPermiso,
      cargaPermiso,
      compraPermiso,
      remisionesPermiso,
      bancosPermiso,
      cxcPermiso,
      cxpPermiso,
      idUsuario)
      VALUES (NULL, 
      '".$this->proveedores."', 
      '".$this->acreedores."', 
      '".$this->transportistas."',
      '".$this->clientes."',
      '".$this->productos."',
      '".$this->aduanal."', 
      '".$this->persona."', 
      '".$this->pedidos."', 
      '".$this->cotizaciones."', 
      '".$this->importaciones."', 
      '".$this->declaraciones."', 
      '".$this->inventario."', 
      '".$this->carga."', 
      '".$this->compra."', 
      '".$this->remisiones."', 
      '".$this->bancos."', 
      '".$this->cxc."', 
      '".$this->cxp."',
      '".$this->id."')";


      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Permisos registrados exitosamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "GUARDAR USUARIO"///////////////////////////////////////////////////////////////////////////////////////////////////////////


  //FUNCION "CONSULTAR PERMISOS"////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function consultarPermisos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
      return $resultados = $conexion->query(
        "SELECT
        a.idUsuario,
        b.idPermiso,
        b.proveedoresPermiso,
        b.acreedoresPermiso,
        b.transportistasPermiso,
        b.clientesPermiso,
        b.productosPermiso,
        b.aduanalPermiso,
        b.usuariosPermiso,
        b.pedidosPermiso,
        b.cotizacionesPermiso,
        b.importacionesPermiso,
        b.declaracionesPermiso,
        b.inventarioPermiso,
        b.cargaPermiso,
        b.compraPermiso,
        b.remisionesPermiso,
        b.bancosPermiso,
        b.cxcPermiso,
        b.cxpPermiso
        
        FROM
        usuarios AS a 
        INNER JOIN 
        permisos AS b

        ON a.idUsuario = b.idUsuario
        WHERE a.idUsuario='".$this->id."'");

    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "CONSULTAR PERMISOS"////////////////////////////////////////////////////////////////////////////////////////////////////////


//FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function modificarPermisos(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");

      //Sentencia SQL para modificar un usuario
      $query = "UPDATE permisos SET

      proveedoresPermiso             ='".$this->proveedores."',
      acreedoresPermiso              ='".$this->acreedores."',
      transportistasPermiso          ='".$this->transportistas."',
      clientesPermiso                ='".$this->clientes."',
      productosPermiso               ='".$this->productos."',
      aduanalPermiso                 ='".$this->aduanal."',
      usuariosPermiso                ='".$this->persona."',
      pedidosPermiso                 ='".$this->pedidos."',
      cotizacionesPermiso            ='".$this->cotizaciones."',
      importacionesPermiso           ='".$this->importaciones."',
      declaracionesPermiso           ='".$this->declaraciones."',
      inventarioPermiso              ='".$this->inventario."',
      cargaPermiso                   ='".$this->carga."',
      compraPermiso                  ='".$this->compra."',
      remisionesPermiso              ='".$this->remisiones."',
      bancosPermiso                  ='".$this->bancos."',
      cxcPermiso                     ='".$this->cxc."',
      cxpPermiso                     ='".$this->cxp."'

      WHERE idPermiso =              '".$this->id."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Permisos modificados exitosamente";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////



//FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function activarSesion(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");
      $time = time();
      //Sentencia SQL para modificar un usuario
      $query = "UPDATE usuarios SET

      statusUsuario             = 1,
      entradaUsuario            ='".$time."'

      WHERE idUsuario =              '".$this->id."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Sesión activada";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////

  //FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function cancelarSesion(){
    try {

      //CONEXION A LA BASE DE DATOS
      $conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
        dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

      $conexion -> exec("set names utf8");
      
      //Sentencia SQL para modificar un usuario
      $query = "UPDATE usuarios SET

      statusUsuario             = 0,
      entradaUsuario            = 0

      WHERE idUsuario =              '".$this->id."'";

      $statement = $conexion->prepare($query);

      $statement->execute();

      return "Sesión cancelada";
    }

    catch(PDOException $e){
      return "Error: " . $e->getMessage();
    }
  }
  //FUNCION "MODIFICAR USUARIO"//////////////////////////////////////////////////////////////////////////////////////////////////////////


}
?>
