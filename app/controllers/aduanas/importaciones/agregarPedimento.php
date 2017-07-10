<?php 

session_start();
###### INCLUDE PARA CONEXION A BASE DE DATOS #########################################
include '../../../../config.php';


###### REQUIRE DE LA LIBRERIA DE METODOS DE PROVEEDORES ##############################
require '../../../models/aduanas/importaciones.php';

$importaciones = new importaciones($datosConexionBD);

$print = "";
$tarimas = 0;
$envases = 0;
$exitosos = 0;

if(md5($_POST['pass'])==$_SESSION['password']){
	if($_POST['entrada']==1){
		$importaciones->folio = $_POST['importacion'];
		$odcompras = $importaciones->consultarOrdenesxImportacion();

		foreach($odcompras as $row){
			$orden = $row['folioOrdenCompra'];
			$factura = $row['folioFactura'];
			
			$importaciones->odc = $orden;
			$detalles = $importaciones->consultarProductosODC();

			foreach ($detalles as $row){
				$producto = $row['codigoProducto'];
				$cantidad = $row['cantidadOrdenCompra'];
				$monto = $row['montoOrdenCompra'];

				$importaciones->factura = $factura;
				$importaciones->producto = $producto;
				$lista_lotes = $importaciones->consultarLoteF();
				foreach($lista_lotes as $row){
					$lote = $row['loteProduccion'];
					$ddM = $row['ddManufactura'];
					$mmM = $row['mmManufactura'];
					$yyyyM = $row['yyyyManufactura'];
					$ddC = $row['ddCaducidad'];
					$mmC = $row['mmCaducidad'];
					$yyyyC = $row['yyyyCaducidad'];
				}

				$importaciones->producto = $producto;
				$list_pres = $importaciones->consultarPresentacion();
				foreach($list_pres as $row){
					$presentacion = $row['presentacionProducto'];
					$precioVenta = $row['ventaProducto'];
				}
				if($presentacion!=4){
					switch($presentacion){
						case 1: 
						$envases = 180;
						$tarimas = ceil($cantidad/$envases);
						$print = $print." ".$tarimas." ";
						break;
						case 2: 
						$envases = 220;
						$tarimas = ceil($cantidad/$envases);
						$print = $print." ".$tarimas." ";
						break;
						case 3: 
						$envases = 275;
						$tarimas = ceil($cantidad/$envases);
						$print = $print." ".$tarimas." ";
						break;
						case 5: 
						$envases = 2000;
						$tarimas = ceil($cantidad/$envases);
						$print = $print." ".$tarimas." ";
						break;
						case 6: 
						$envases = 2000;
						$tarimas = ceil($cantidad/$envases);
						$print = $print." ".$tarimas." ";
						break;
					}

					for ($i=0; $i < $tarimas; $i++) { 

						/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

						$dia = date('d');
						$mes = date('m');
						$anio = date('y');

						$contador = 0;

						$fechaCodigo = "K".$dia.$mes.$anio;
						$importaciones->codigo = $fechaCodigo."%";
						$encontrados = $importaciones->consultarCodigosInv();
						foreach($encontrados as $row){
							if($row['barCodeInventario']!=""){
								$contador++;
							}
						}

						if($contador==0){
							$folio = $fechaCodigo."-01";
						}
						else{
							if($contador <9){
								$folio = $fechaCodigo."-0".($contador+1);
							}
							else{
								$folio = $fechaCodigo."-".($contador+1);	
							}
						}
						/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/
						if($cantidad<$envases){
							$cantidad_inventario = $cantidad;
						}
						else{
							if(($i+1)==$tarimas){
								$cantidad_inventario = $cantidad - ($envases*($i));	
							}
							else{
								$cantidad_inventario = $envases;
							}
						}


						$precio_inventario = $precioVenta * $cantidad_inventario;
						$importaciones->producto = $producto;
						$densidades = $importaciones->catalogoProductos();
						foreach($densidades as $row){
							$densidad = $row['densidadProducto'];

						}

						$peso_total = $densidad * $cantidad_inventario;


						$importaciones->codigo = $_POST['importacion'];
						$importaciones->folio = $folio;
						$importaciones->producto = $producto;
						$importaciones->cantidad = $cantidad_inventario;
						$importaciones->costo = $precio_inventario;
						$importaciones->lote = $lote;
						$importaciones->peso = $peso_total;
						$importaciones->diaM = $ddM;
						$importaciones->mesM = $mmM;
						$importaciones->anoM = $yyyyM;
						$importaciones->diaC = $ddC;
						$importaciones->mesC = $mmC;
						$importaciones->anoC = $yyyyC;

						$registros = $importaciones->registrarInventario();
						if($registros=="Listo"){
							$exitosos ++;
						}

						

					}
				}
			}
		}

	}
	else{
		if($_POST['entrada'] == 2){
			$importaciones->folio = $_POST['importacion'];
			$odcompras = $importaciones->consultarOrdenesxImportacion();

			foreach($odcompras as $row){
				$orden = $row['folioOrdenCompra'];
				$factura = $row['folioFactura'];

				$importaciones->odc = $orden;
				$detalles = $importaciones->consultarProductosODC();

				foreach ($detalles as $row){
					$producto = $row['codigoProducto'];
					$cantidad = $row['cantidadOrdenCompra'];
					$monto = $row['montoOrdenCompra'];

					$importaciones->factura = $factura;
					$importaciones->producto = $producto;
					$lista_lotes = $importaciones->consultarLoteF();
					foreach($lista_lotes as $row){
						$lote = $row['loteProduccion'];
						$ddM = $row['ddManufactura'];
						$mmM = $row['mmManufactura'];
						$yyyyM = $row['yyyyManufactura'];
						$ddC = $row['ddCaducidad'];
						$mmC = $row['mmCaducidad'];
						$yyyyC = $row['yyyyCaducidad'];
					}

					$importaciones->producto = $producto;
					$list_pres = $importaciones->consultarPresentacion();
					foreach($list_pres as $row){
						$presentacion = $row['presentacionProducto'];
						$precioVenta = $row['ventaProducto'];
					}
					



					/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/

					$dia = date('d');
					$mes = date('m');
					$anio = date('y');

					$contador = 0;

					$fechaCodigo = "EE".$dia.$mes.$anio;
					$importaciones->codigo = $fechaCodigo."%";
					$encontrados = $importaciones->consultarCodigosInv();
					foreach($encontrados as $row){
						if($row['barCodeInventario']!=""){
							$contador++;
						}
					}

					if($contador==0){
						$folio = $fechaCodigo."-1";
					}
					else{
						$folio = $fechaCodigo."-".($contador+1);
					}
					/*SCRIPT PARA GENERAR FOLIOS CON FECHA Y NUMERO CONTINUO*/



					$precio_inventario = $precioVenta * $cantidad;

					$importaciones->codigo = $_POST['importacion'];
					$importaciones->folio = $folio;
					$importaciones->producto = $producto;
					$importaciones->cantidad = $cantidad;
					$importaciones->costo = $precio_inventario;
					$importaciones->lote = $lote;
					$importaciones->diaM = $ddM;
					$importaciones->mesM = $mmM;
					$importaciones->anoM = $yyyyM;
					$importaciones->diaC = $ddC;
					$importaciones->mesC = $mmC;
					$importaciones->anoC = $yyyyC;

					$registros = $importaciones->registrarInventario();
					if($registros=="Listo"){
						$exitosos ++;
					}
				}
			}
		}
	}
	
	$importaciones->pedimento = $_POST['pedimento'];
	$importaciones->folio = $_POST['importacion'];
	$importaciones->entrada = $_POST['entrada'];
	$importaciones->id = $_SESSION['idUsuario'];
	echo $importaciones->registrarPedimento();
	//echo $_POST['pedimento']."||".
}
else{
	echo "Password no corresponde al usuario activo";
}
?>