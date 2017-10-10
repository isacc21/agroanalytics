<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 07 Febrero 2017 : 10:57                                                            #
#                                                                                    #
###### ordenesCompra.php #############################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "ordenes de compra". #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 7-FEB-17: 10:58                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "generarOrdenCompra()"                                  #
# IJLM - Creación del método "agregarDetalleOrden()"                                 #
# IJLM - Creación del método "cancelarOrdenCompra()"                                 #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 8-FEB-17: 8:34                                                                     #
# IJLM - Creación del método "cancelarOrdenCompra()"                                 #
# IJLM - Creación del método "completarOrdenCompra()"                                #
# IJLM - Creación del método "consultarOrdenes()"                                    #
######################################################################################

date_default_timezone_set('America/Tijuana');

class inventario{
	var $producto;
	var $importacion;

	// DECLARACIÓN DEL MÉTODO CONSTRUCTOR
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	public function consultarExistencia(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM inventario AS a INNER JOIN importaciones AS b ON a.folioImportacion = b.folioImportacion WHERE a.existenciaInventario > 0");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function consultarProductosID(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM productos WHERE codigoProducto = '".$this->producto."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function consultarPedimentos(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM importaciones WHERE folioPedimentoImportacion IS NOT NULL");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarProductosPedimento(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("SELECT * FROM inventario WHERE folioImportacion = '".$this->importacion."'");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function reporteInventario(){
		try {

      //CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

      //Sentencia SQL para eliminar un usuario
			return $resultados = $conexion->query("
				SELECT 
				a.folioImportacion, 
				a.codigoProducto, 
				SUM(a.existenciaInventario) as existenciaInventario, 
				a.ddManufactura, 
				a.mmManufactura, 
				a.yyyyManufactura, 
				a.ddCaducidad, 
				a.mmCaducidad, 
				a.yyyyCaducidad, 
				a.loteInventario, 
				b.folioPedimentoImportacion, 
				c.nombreProducto, 
				c.presentacionProducto
				FROM inventario AS a
				INNER JOIN importaciones AS b 
				ON a.folioImportacion = b.folioImportacion
				INNER JOIN productos AS c 
				ON a.codigoProducto = c.codigoProducto
				WHERE a.existenciaInventario > 0
				GROUP BY 
				c.presentacionProducto,
				a.loteInventario,
				a.ddManufactura,
				a.mmManufactura,
				a.yyyyManufactura,
				a.ddCaducidad,
				a.mmCaducidad,
				a.yyyyCaducidad
				ORDER BY 
				c.presentacionProducto ASC , 
				c.nombreProducto ASC,
				a.loteInventario ASC 
				");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
}

?>
