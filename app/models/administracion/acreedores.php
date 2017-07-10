<?php
######################################################################################
# ISACC JAVIER LOZANO MONTAÑEZ (IJLM)                                                #
# 01 Febrero 2017 : 10:15                                                            #
#                                                                                    #
###### acreedores.php ################################################################
#                                                                                    #
# Archivo para realizar consultas o acciones directamente en la base de datos.       #
# Archivo donde se ejecutan los métodos que necesita la sección "acreedores".        #
#                                                                                    #
###### HISTORIAL DE MODIFICACIONES ###################################################
#                                                                                    #
# 1-FEB-17: 10:17                                                                    #
# IJLM - Creacion de Variables                                                       #
# IJLM - Creación del método constructor                                             #
# IJLM - Creación del método "guardarAcreedor()"                                     #
# IJLM - Creación del método "modificarAcreedor()"                                   #
# IJLM - Creación del método "eliminarAcreedor()"                                    #
# IJLM - Creación del método "consultarAcreedores()"                                 #
# IJLM - Creación del método "date_default_timezone_set('America/Tijuana')           #
#                                                                                    #
# 23-FEB-17: 16:01                                                                   #
# IJLM - Documentación parcial del archivo para mejor entendimiento                  #
#                                                                                    #
# 24-FEB-17: 10:18                                                                   #
# IJLM - Creación del método "consultarAcredoresID()"                                #
######################################################################################



###### DETERMINACION DE ZONA HORARIA #################################################
date_default_timezone_set('America/Tijuana');


###### DEFINICION DE CLASE ###########################################################
class acreedores{


###### DEFINICION DE VARIABLES #######################################################
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

###### METODO CONSTRUCTOR PARA RECIBIR VARIABLES DE CONEXION A BASE DE DATOS #########
	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	} ## LLAVE DE METODO CONSTRUCTOR ###################################################


###### FUNCION GUARDAR ACREEDOR ######################################################
	public function guardarAcreedor(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

###### SENTENCIA SQL PARA GUARDAR UN ACREEDOR ########################################
			$query = "INSERT INTO acreedores (
			rfcAcreedor,
			razonSocAcreedor,
			calleAcreedor,
			numeroExtAcreedor,
			numeroIntAcreedor,
			coloniaAcreedor,
			codigoPostalAcreedor,
			ciudadAcreedor,
			estadoAcreedor,
			paisAcreedor,
			contactoAcreedor,
			emailAcreedor,
			telefonoAcreedor,
			celularAcreedor,
			paginaWebAcreedor)

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


###### EJECUCION DE LA FUNCION EN LA BASE DE DATOS ###################################
			$statement = $conexion->prepare($query);

			$statement->execute();

###### RETORNO DE MENSAJE DE EXITO ###################################################
			return "Acreedor registrado exitósamente";


		} ## LLAVE DE TRY DE LA FUNCION  GUARDAR ACREEDOR ################################

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
			
		} ## LLAVE DE CATCH DE LA FUNCION  GUARDAR ACREEDOR ##############################


	} ## LLAVE DE LA FUNCION GUARDAR ACREEDOR ##########################################



###### FUNCION MODIFICAR ACREEDOR#####################################################
	public function modificarAcreedor(){
		try {

###### CONEXION A LA BASE DE DATOS ###################################################
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], 
				$this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

###### SENTENCIA SQL PARA MODIFICAR UN ACREEDOR ######################################
			$query = "UPDATE acreedores SET

			rfcAcreedor =           '".$this->rfc."',
			razonSocAcreedor =      '".$this->razon."',
			calleAcreedor =         '".$this->calle."',
			numeroExtAcreedor =     '".$this->numeroExterior."',
			numeroIntAcreedor =     '".$this->numeroInterior."',
			coloniaAcreedor =       '".$this->colonia."',
			codigoPostalAcreedor =  '".$this->codigoPostal."',
			ciudadAcreedor =        '".$this->ciudad."',
			estadoAcreedor =        '".$this->estado."',
			paisAcreedor =          '".$this->pais."',
			contactoAcreedor =      '".$this->contacto."',
			emailAcreedor =         '".$this->email."',
			telefonoAcreedor =      '".$this->telefono."',
			celularAcreedor =       '".$this->celular."',
			paginaWebAcreedor =     '".$this->pagina."'

			WHERE rfcAcreedor =     '".$this->viejo."'";



###### EJECUCION DE LA SENTENCIA SQL #################################################
			$statement = $conexion->prepare($query);

			$statement->execute();
##### RETORNO DE MENSAJE DE EXITO ####################################################
			return "Acreedor modificado exitósamente";
		} ## LLAVE DE TRY DE LA FUNCION MODIFICAR ACREEDOR ###############################

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		} ## LLAVE DE CATCH DE LA FUNCION MODIFICAR ACREEDOR #############################
	}
	//FUNCION "MODIFICAR ACREEDOR"/////////////////////////////////////////////////////////////////////////////////////////////////////////



	//FUNCION "ELIMINAR ACREEDOR"//////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function eliminarAcreedor(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para eliminar un acreedor
			$query = "DELETE FROM acreedores WHERE rfcAcreedor = '".$this->rfc."'";

			$statement = $conexion->prepare($query);

			$statement->execute();

			return "Acreedor eliminado exitosamente";
		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "ELIMINAR ACREEDOR"//////////////////////////////////////////////////////////////////////////////////////////////////////////



	//FUNCION "CONSULTAR ACREEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function consultarAcreedores(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM acreedores");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "CONSULTAR ACREEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////


	//FUNCION "CONSULTAR ACREEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function consultarAcreedoresID(){
		try {

			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);

			$conexion -> exec("set names utf8");

			//Sentencia SQL para consultar los acreedores de la tabla.
			return $resultados = $conexion->query("SELECT * FROM acreedores WHERE rfcAcreedor = '".$this->rfc."' ");

		}

		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	//FUNCION "CONSULTAR ACREEDORES"////////////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
