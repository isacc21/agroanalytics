<?php
date_default_timezone_set('America/Tijuana');

class principal{
	var $mes;
	var $year;
	var $producto;
	var $folio;
	var $proveedor;
	var $acreedor;

	function __construct($datosConexionBD){
		$this->datosConexionBD=$datosConexionBD;
	}

	public function ventas_mensuales(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(a.totalPedido) AS total FROM pedidos AS a INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura WHERE d.statusCuentaC <> 4 AND d.statusCuentaC <> 3 AND d.mmCuentaC = '".$this->mes."' AND d.mmCuentaC = '".date(Y)."'");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_acumuladas(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(a.totalPedido) AS total FROM pedidos AS a INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura WHERE d.statusCuentaC <> 4 AND d.statusCuentaC <> 3 AND d.yyyyCuentaC = '".$this->year."'");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function bancos_dolares(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				(SELECT 
				SUM( estadocuenta.montoBanco ) AS ingresos
				FROM estadocuenta
				INNER JOIN bancos ON estadocuenta.idBanco = bancos.idBanco
				WHERE bancos.monedaBanco =1
				AND estadocuenta.tipoBanco =1) - 
				(SELECT SUM( estadocuenta.montoBanco ) AS ingresos
				FROM estadocuenta
				INNER JOIN bancos ON estadocuenta.idBanco = bancos.idBanco
				WHERE bancos.monedaBanco =1
				AND estadocuenta.tipoBanco =2 )
				AS Total");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function bancos_pesos(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				(SELECT 
				SUM( estadocuenta.montoBanco ) AS ingresos
				FROM estadocuenta
				INNER JOIN bancos ON estadocuenta.idBanco = bancos.idBanco
				WHERE bancos.monedaBanco =2
				AND estadocuenta.tipoBanco =1) - 
				(SELECT SUM( estadocuenta.montoBanco ) AS ingresos
				FROM estadocuenta
				INNER JOIN bancos ON estadocuenta.idBanco = bancos.idBanco
				WHERE bancos.monedaBanco =2
				AND estadocuenta.tipoBanco =2 )
				AS Total");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function cxc_activas(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT SUM( importeCuentaC ) AS total
				FROM cuentascobrar
				WHERE statusCuentaC =1 OR statusCuentaC = 3");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	//SELECT SUM(a.totalPedido) AS total FROM pedidos AS a INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura WHERE d.statusCuentaC=1 

	public function cxp_usd(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(importeCuentaP) as Total FROM cuentaspagar WHERE statusCuentaP = 1 AND monedaCuentaP = 1");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function cxp_mxn(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(importeCuentaP) as Total FROM cuentaspagar WHERE statusCuentaP = 1 AND monedaCuentaP = 2");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function importaciones(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(costoImportacion) as Total FROM importaciones WHERE statusImportacion = 2 AND mmImportacion = '".$this->mes."'");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function inventario(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(a.existenciaInventario * b.compraProducto) AS Total FROM inventario AS a INNER JOIN productos AS b ON a.codigoProducto = b.codigoProducto");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_clientes(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(a.totalPedido) AS total, SUBSTRING(e.razonSocCliente,1,10) AS cliente FROM pedidos AS a INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura INNER JOIN clientes as e ON a.rfcCliente = e.rfcCliente WHERE d.statusCuentaC <> 4 AND d.statusCuentaC <> 3 AND d.mmCuentaC = '".$this->mes."' AND e.tipoCliente = 2 GROUP BY e.rfcCliente");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_distribuidor(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(a.totalPedido) AS total, SUBSTRING(e.razonSocCliente,1,10) AS cliente FROM pedidos AS a INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura INNER JOIN clientes AS e ON a.rfcCliente = e.rfcCliente WHERE d.statusCuentaC <> 4 AND d.statusCuentaC <> 3 AND d.mmCuentaC = '".$this->mes."' AND e.tipoCliente = 1 GROUP BY e.rfcCliente");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_grower(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM(a.totalPedido) AS total, SUBSTRING(e.razonSocCliente,1,10) AS cliente FROM pedidos AS a INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura INNER JOIN clientes AS e ON a.rfcCliente = e.rfcCliente WHERE d.statusCuentaC <> 4 AND d.statusCuentaC <> 3 AND d.mmCuentaC = '".$this->mes."' AND e.tipoCliente = 3 GROUP BY e.rfcCliente");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_producto(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT DISTINCT SUM( a.montoDetallePedido ) AS total, SUBSTRING( a.codigoProducto, 1, 4 ) AS codigo
				FROM detallepedidos AS a
				INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido
				INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga
				INNER JOIN cuentascobrar AS e ON c.folioRemision = e.remisionFactura
				WHERE e.statusCuentaC <>3
				AND e.statusCuentaC <>4
				AND e.mmCuentaC =  '".$this->mes."'
				GROUP BY SUBSTRING( a.codigoProducto, 1, 4 )");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function nombres_producto(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT DISTINCT nombreProducto from productos where codigoProducto like '".$this->producto."%'");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_anuales(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM( a.totalPedido ) AS total, d.mmCuentaC as mes
				FROM pedidos AS a
				INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido
				INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga
				INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura
				WHERE d.yyyyCuentaC = '".date(Y)."'
				AND d.mmCuentaC = '".$this->mes."'
				GROUP BY a.mmPedido
				ORDER BY a.mmPedido ASC");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function ventas_anuales_pasado(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("SELECT SUM( a.totalPedido ) AS total, d.mmCuentaC as mes
				FROM pedidos AS a
				INNER JOIN ordenescarga AS b ON a.folioPedido = b.folioPedido
				INNER JOIN remisiones AS c ON b.folioOrdenCarga = c.folioOrdenCarga
				INNER JOIN cuentascobrar AS d ON c.folioRemision = d.remisionFactura
				WHERE d.yyyyCuentaC = '".(date(Y)-1)."'
				GROUP BY a.mmPedido
				ORDER BY a.mmPedido ASC");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function caducidad_inventario(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				a.barCodeInventario,
				a.codigoProducto,
				a.existenciaInventario,
				a.ddCaducidad,
				a.mmCaducidad,
				a.yyyyCaducidad,
				b.nombreProducto,
				b.presentacionProducto
				FROM 
				inventario AS a 
				INNER JOIN 
				productos AS b
				ON a.codigoProducto = b.codigoProducto
				WHERE a.existenciaInventario > 0
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function cxc_revision(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				a.folioCuentaC, 
				a.ddCuentaC, 
				a.mmCuentaC, 
				a.yyyyCuentaC, 
				b.razonSocCliente 
				FROM 
				cuentascobrar AS a 
				INNER JOIN 
				clientes AS b 
				ON a.rfcCliente = b.rfcCliente 
				WHERE a.statusCuentaC = 1
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function cxp_lista(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				a.folioCuentaP, 
				a.ddCuentaP, 
				a.mmCuentaP, 
				a.yyyyCuentaP
				FROM 
				cuentaspagar AS a 

				WHERE a.statusCuentaP = 1
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function cxc_vencidas(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				a.folioCuentaC, 
				a.folioFactura,
				b.razonSocCliente 
				FROM 
				cuentascobrar AS a 
				INNER JOIN 
				clientes AS b 
				ON a.rfcCliente = b.rfcCliente 
				WHERE a.statusCuentaC = 3
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function cxp_vencidas(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				a.folioCuentaP, 
				a.folioFactura,
				a.rfcProveedor,
				a.rfcAcreedor
				FROM 
				cuentaspagar as a
				WHERE a.statusCuentaP = 3
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function permisos(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT 
				nombreProducto,
				ddCofProducto,
				mmCofProducto,
				yyyyCofProducto,
				ddCicProducto,
				mmCicProducto,
				yyyyCicProducto,
				ddSemProducto,
				mmSemProducto,
				yyyySemProducto
				FROM productos
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}

	public function vencerCXC(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				UPDATE cuentascobrar SET
				statusCuentaC = 3
				WHERE folioCuentaC = '".$this->folio."'
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
	

	public function vencerCXP(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				UPDATE cuentaspagar SET
				statusCuentaP = 3
				WHERE folioCuentaP = '".$this->folio."'
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarProveedoresxID(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT * FROM proveedores WHERE rfcProveedor = '".$this->proveedor."'
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}


	public function consultarAcreedoresxID(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT * FROM acreedores WHERE rfcAcreedor = '".$this->acreedor."'
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}



	public function cuentasVencidasXP(){
		try {
			//CONEXION A LA BASE DE DATOS
			$conexion = new PDO('mysql:host='.$this->datosConexionBD[0].';
				dbname='.$this->datosConexionBD[3], $this->datosConexionBD[1], $this->datosConexionBD[2]);
			$conexion -> exec("set names utf8");
			return $resultados = $conexion->query("
				SELECT * FROM cuentaspagar
				WHERE statusCuentaP = 3
				");
		}
		catch(PDOException $e){
			return "Error: " . $e->getMessage();
		}
	}
}
?>
