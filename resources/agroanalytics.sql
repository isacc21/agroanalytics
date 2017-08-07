-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-02-2017 a las 00:41:06
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agroanalytics`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acreedores`
--

CREATE TABLE `acreedores` (
  `rfcAcreedor` varchar(30) NOT NULL,
  `razonSocAcreedor` varchar(75) NOT NULL,
  `calleAcreedor` varchar(30) NOT NULL,
  `numeroExtAcreedor` int(11) NOT NULL,
  `numeroIntAcreedor` int(11) NOT NULL,
  `coloniaAcreedor` varchar(30) NOT NULL,
  `codigoPostalAcreedor` int(11) NOT NULL,
  `ciudadAcreedor` varchar(30) NOT NULL,
  `estadoAcreedor` varchar(30) NOT NULL,
  `paisAcreedor` varchar(30) NOT NULL,
  `emailAcreedor` varchar(30) NOT NULL,
  `telefonoAcreedor` int(11) NOT NULL,
  `celularAcreedor` int(11) NOT NULL,
  `paginaWebAcreedor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `acreedores`
--

INSERT INTO `acreedores` (`rfcAcreedor`, `razonSocAcreedor`, `calleAcreedor`, `numeroExtAcreedor`, `numeroIntAcreedor`, `coloniaAcreedor`, `codigoPostalAcreedor`, `ciudadAcreedor`, `estadoAcreedor`, `paisAcreedor`, `emailAcreedor`, `telefonoAcreedor`, `celularAcreedor`, `paginaWebAcreedor`) VALUES
('LOMI941021HBCZNS28', 'Isacc Javier Lozano Montañez', 'Bacanora ', 3442, 1, 'Mayos', 21137, 'Mexicali', 'Baja California', 'México', 'isacc.loz.mon21@gmail.com', 2147483647, 2147483647, 'bajasoft.mx/isaccloz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aduanasdeclaraciones`
--

CREATE TABLE `aduanasdeclaraciones` (
  `folioDeclaracion` varchar(30) NOT NULL,
  `folioImportacion` varchar(30) NOT NULL,
  `rfcTransportista` varchar(15) NOT NULL,
  `placasMXDeclaracion` varchar(30) NOT NULL,
  `placasUSDeclaracion` varchar(30) NOT NULL,
  `noEcoTractoDeclaracion` varchar(30) NOT NULL,
  `placasPlatDeclaracion` varchar(30) NOT NULL,
  `noEcoPlatDeclaracion` varchar(30) NOT NULL,
  `pesoTotalDeclaracion` float(10,2) NOT NULL,
  `statusDeclaracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `rfcCliente` varchar(30) NOT NULL,
  `razonSocCliente` varchar(75) NOT NULL,
  `calleCliente` varchar(30) NOT NULL,
  `numeroExtCliente` int(11) NOT NULL,
  `numeroIntCliente` int(11) NOT NULL,
  `coloniaCliente` varchar(30) NOT NULL,
  `codigoPostalCliente` int(11) NOT NULL,
  `ciudadCliente` varchar(30) NOT NULL,
  `estadoCliente` varchar(30) NOT NULL,
  `paisCliente` varchar(30) NOT NULL,
  `emailCliente` varchar(30) NOT NULL,
  `telefonoCliente` int(11) NOT NULL,
  `celularCliente` int(11) NOT NULL,
  `paginaWebCliente` varchar(50) NOT NULL,
  `tipoCliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `folioCotizacion` varchar(30) NOT NULL,
  `rfcCliente` varchar(30) NOT NULL,
  `totalCotizacion` float(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecotizacion`
--

CREATE TABLE `detallecotizacion` (
  `idDetalleCotizacion` int(11) NOT NULL,
  `folioCotizacion` varchar(30) NOT NULL,
  `folioProducto` varchar(30) NOT NULL,
  `cantidadDetalleCotizacion` int(11) NOT NULL,
  `montoDetalleCotizacion` float(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalledeclaraciones`
--

CREATE TABLE `detalledeclaraciones` (
  `idDetalleDA` int(11) NOT NULL,
  `folioDeclaracion` varchar(30) NOT NULL,
  `idDetalleOC` int(11) NOT NULL,
  `pesoDetalleDA` float(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleimportacion`
--

CREATE TABLE `detalleimportacion` (
  `idDetalleImportacion` int(11) NOT NULL,
  `folioImportacion` varchar(30) NOT NULL,
  `idDetalleOc` int(11) NOT NULL,
  `ddCaducidadImportacion` int(11) NOT NULL,
  `mmCaducidadImportacion` int(11) NOT NULL,
  `yyyyCaducidadImportacion` int(11) NOT NULL,
  `ddManufacturaImporta` int(11) NOT NULL,
  `mmManufacturaImportacion` int(11) NOT NULL,
  `yyyyManufacturaImportacion` int(11) NOT NULL,
  `loteProducImportacion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleordenescompra`
--

CREATE TABLE `detalleordenescompra` (
  `idDetalleOc` int(11) NOT NULL,
  `folioOrdenCompra` varchar(30) NOT NULL,
  `folioProducto` varchar(30) NOT NULL,
  `cantidadOrdenCompra` int(11) NOT NULL,
  `montoOrdenCompra` float(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedidos`
--

CREATE TABLE `detallepedidos` (
  `idDetallePedido` int(11) NOT NULL,
  `folioPedido` varchar(30) NOT NULL,
  `folioProducto` varchar(30) NOT NULL,
  `cantidadDetallePedido` int(11) NOT NULL,
  `montoDetallePedido` float(11,2) NOT NULL,
  `statusDetallePedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `importaciones`
--

CREATE TABLE `importaciones` (
  `folioImportacion` varchar(30) NOT NULL,
  `folioOrdenCompra` varchar(30) NOT NULL,
  `facturaImportacion` varchar(30) NOT NULL,
  `statusImportacion` int(11) NOT NULL,
  `ddImportacion` int(11) NOT NULL,
  `mmImportacion` int(11) NOT NULL,
  `yyyyImportacion` int(11) NOT NULL,
  `costoImportacion` float(11,2) NOT NULL,
  `folioPedimentoImportacion` varchar(30) NOT NULL,
  `tipoEntradaImportacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idInventario` int(11) NOT NULL,
  `barCodeInventario` varchar(30) NOT NULL,
  `folioProducto` varchar(30) NOT NULL,
  `existenciaInventario` float(11,2) NOT NULL,
  `precioInventario` float(11,2) NOT NULL,
  `pesoInventario` float(11,2) NOT NULL,
  `loteInventario` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mxnbancos`
--

CREATE TABLE `mxnbancos` (
  `folioMXNBanco` varchar(30) NOT NULL,
  `ddMXNBanco` int(11) NOT NULL,
  `mmMXNBanco` int(11) NOT NULL,
  `yyyyMXNBanco` int(11) NOT NULL,
  `referenciaMXNBanco` varchar(30) NOT NULL,
  `tipoMXNBanco` int(11) NOT NULL,
  `montoMXNBanco` float(11,2) NOT NULL,
  `balanceMXNBanco` float(11,2) NOT NULL,
  `detalleMXNBanco` varchar(30) NOT NULL,
  `comentarioMXNBanco` varchar(30) NOT NULL,
  `statusMXNBanco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mxncuentac`
--

CREATE TABLE `mxncuentac` (
  `folioCuentaC` varchar(30) NOT NULL,
  `ddCuentaC` int(11) NOT NULL,
  `mmCuentaC` int(11) NOT NULL,
  `yyyyCuentaC` int(11) NOT NULL,
  `rfcCliente` varchar(15) NOT NULL,
  `folioFactura` varchar(30) NOT NULL,
  `importeCuentaC` float(11,2) NOT NULL,
  `comentarioCuentaC` varchar(30) NOT NULL,
  `statusCuentaC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mxncuentasp`
--

CREATE TABLE `mxncuentasp` (
  `folioCuentP` varchar(30) NOT NULL,
  `ddCuentaP` int(11) NOT NULL,
  `mmCuentaP` int(11) NOT NULL,
  `yyyyCuentaP` int(11) NOT NULL,
  `rfcProveedor` varchar(15) NOT NULL,
  `rfcAcreedor` varchar(15) NOT NULL,
  `folioFactura` varchar(30) NOT NULL,
  `importeCuentaP` float(11,2) NOT NULL,
  `comentarioCuentaP` varchar(30) NOT NULL,
  `statusCuentaP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenescarga`
--

CREATE TABLE `ordenescarga` (
  `folioOrdenCarga` varchar(30) NOT NULL,
  `folioPedido` varchar(30) NOT NULL,
  `ddOrdenCarga` int(11) NOT NULL,
  `mmOrdenCarga` int(11) NOT NULL,
  `yyyyOrdenCarga` int(11) NOT NULL,
  `statusOrdenCarga` int(11) NOT NULL,
  `folioFactura` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenescompra`
--

CREATE TABLE `ordenescompra` (
  `folioOrdenCompra` varchar(30) NOT NULL,
  `rfcProveedor` varchar(15) NOT NULL,
  `statusOrdenCompra` int(11) NOT NULL,
  `adicionalOrdenCompra` varchar(250) NOT NULL,
  `ddOrdenCompra` int(11) NOT NULL,
  `mmOrdenCompra` int(11) NOT NULL,
  `yyyyOrdenCompra` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `folioPedido` varchar(30) NOT NULL,
  `rfcCliente` varchar(30) NOT NULL,
  `statusPedido` int(11) NOT NULL,
  `totalPedido` float(11,2) NOT NULL,
  `ddPedido` int(11) NOT NULL,
  `mmPedido` int(11) NOT NULL,
  `yyyyPedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `folioProducto` varchar(30) NOT NULL,
  `nombreProducto` varchar(50) NOT NULL,
  `presentacionProducto` varchar(50) NOT NULL,
  `tiempoCadProducto` int(11) NOT NULL,
  `precioCompraProducto` float(11,2) NOT NULL,
  `precioVentaProducto` float(11,2) NOT NULL,
  `noRegistroProducto` varchar(50) NOT NULL,
  `fraccArancelariaProducto` varchar(50) NOT NULL,
  `ddRenovacionProducto` int(11) NOT NULL,
  `mmRenovacionProducto` int(11) NOT NULL,
  `yyyyRenovacionProducto` int(11) NOT NULL,
  `unidadProducto` varchar(5) NOT NULL,
  `tipoProducto` int(11) NOT NULL,
  `densidadProducto` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`folioProducto`, `nombreProducto`, `presentacionProducto`, `tiempoCadProducto`, `precioCompraProducto`, `precioVentaProducto`, `noRegistroProducto`, `fraccArancelariaProducto`, `ddRenovacionProducto`, `mmRenovacionProducto`, `yyyyRenovacionProducto`, `unidadProducto`, `tipoProducto`, `densidadProducto`) VALUES
('Ful-250', 'Fulvex', '250 Gal.', 8, 25.50, 35.50, 'COFEPRIS', 'ARANCEL', 4, 4, 2020, 'Galon', 2, 258.5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `rfcProveedor` varchar(30) NOT NULL,
  `razonSocProveedor` varchar(75) NOT NULL,
  `calleProveedor` varchar(30) NOT NULL,
  `numeroExtProveedor` int(11) NOT NULL,
  `numeroIntProveedor` int(11) NOT NULL,
  `coloniaProveedor` varchar(30) NOT NULL,
  `codigoPostalProveedor` int(11) NOT NULL,
  `ciudadProveedor` varchar(30) NOT NULL,
  `estadoProveedor` varchar(30) NOT NULL,
  `paisProveedor` varchar(30) NOT NULL,
  `emailProveedor` varchar(30) NOT NULL,
  `telefonoProveedor` int(11) NOT NULL,
  `celularProveedor` int(11) NOT NULL,
  `paginaWebProveedor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`rfcProveedor`, `razonSocProveedor`, `calleProveedor`, `numeroExtProveedor`, `numeroIntProveedor`, `coloniaProveedor`, `codigoPostalProveedor`, `ciudadProveedor`, `estadoProveedor`, `paisProveedor`, `emailProveedor`, `telefonoProveedor`, `celularProveedor`, `paginaWebProveedor`) VALUES
('LOMI941021HBCZNS28', 'Isacc Javier Lozano Montañez', 'Bacanora ', 3442, 1, 'Mayos', 21137, 'Mexicali', 'Baja California', 'México', 'isacc.loz.mon21@gmail.com', 2147483647, 2147483647, 'bajasoft.mx/isaccloz');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remisiones`
--

CREATE TABLE `remisiones` (
  `folioRemision` varchar(30) NOT NULL,
  `folioOrdenCarga` varchar(30) NOT NULL,
  `pedimentoRemision` varchar(30) NOT NULL,
  `aduanaRemision` varchar(30) NOT NULL,
  `calleRemision` varchar(30) NOT NULL,
  `numeroIntRemision` int(11) NOT NULL,
  `numeroExtRemision` int(11) NOT NULL,
  `coloniaRemision` varchar(30) NOT NULL,
  `codigoPostalRemision` int(11) NOT NULL,
  `ciudadRemision` varchar(30) NOT NULL,
  `estadoRemision` varchar(30) NOT NULL,
  `paisRemision` varchar(30) NOT NULL,
  `adicionalRemision` varchar(250) NOT NULL,
  `ddRemision` int(11) NOT NULL,
  `mmRemision` int(11) NOT NULL,
  `yyyyRemision` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transportistas`
--

CREATE TABLE `transportistas` (
  `rfcTransportista` varchar(30) NOT NULL,
  `razonSocTransportista` varchar(75) NOT NULL,
  `calleTransportista` varchar(30) NOT NULL,
  `numeroExtTransportista` int(11) NOT NULL,
  `numeroIntTransportista` int(11) NOT NULL,
  `coloniaTransportista` varchar(30) NOT NULL,
  `codigoPostalTransportista` int(11) NOT NULL,
  `ciudadTransportista` varchar(30) NOT NULL,
  `estadoTransportista` varchar(30) NOT NULL,
  `paisTransportista` varchar(30) NOT NULL,
  `emailTransportista` varchar(30) NOT NULL,
  `telefonoTransportista` int(11) NOT NULL,
  `celularTransportista` int(11) NOT NULL,
  `paginaWebTransportista` varchar(50) NOT NULL,
  `idFiscalTransportista` varchar(75) NOT NULL,
  `sccacTransportista` varchar(50) NOT NULL,
  `caatTransportista` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usdbancos`
--

CREATE TABLE `usdbancos` (
  `folioUSDBanco` varchar(30) NOT NULL,
  `ddUSDBanco` int(11) NOT NULL,
  `mmUSDBanco` int(11) NOT NULL,
  `yyyyUSDBanco` int(11) NOT NULL,
  `referenciaUSDBanco` varchar(30) NOT NULL,
  `tipoUSDBanco` int(11) NOT NULL,
  `montoUSDBanco` float(11,2) NOT NULL,
  `balanceUSDBanco` float(11,2) NOT NULL,
  `detalleUSDBanco` varchar(30) NOT NULL,
  `comentarioUSDBanco` varchar(30) NOT NULL,
  `statusUSDBanco` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usdcuentasc`
--

CREATE TABLE `usdcuentasc` (
  `folioCuentaC` varchar(30) NOT NULL,
  `ddCuentaC` int(11) NOT NULL,
  `mmCuentaC` int(11) NOT NULL,
  `yyyyCuentaC` int(11) NOT NULL,
  `rfcCliente` varchar(30) NOT NULL,
  `folioFactura` varchar(30) NOT NULL,
  `importeCuentaC` float(11,2) NOT NULL,
  `comentarioCuentaC` varchar(30) NOT NULL,
  `statusCuentaC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usdcuentasp`
--

CREATE TABLE `usdcuentasp` (
  `folioCuentaP` varchar(30) NOT NULL,
  `ddCuentaP` int(11) NOT NULL,
  `mmCuentaP` int(11) NOT NULL,
  `yyyyCuentaP` int(11) NOT NULL,
  `rfcProveedor` varchar(30) NOT NULL,
  `rfcAcreedor` varchar(30) NOT NULL,
  `folioFactura` varchar(30) NOT NULL,
  `importeCuentaP` float(11,2) NOT NULL,
  `comentarioCuentaP` varchar(30) NOT NULL,
  `statusCuentaP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(30) NOT NULL,
  `apellidoPatUsuario` varchar(30) NOT NULL,
  `apellidoMatUsuario` varchar(30) NOT NULL,
  `nickUsuario` varchar(50) NOT NULL,
  `passwordUsuario` varchar(50) NOT NULL,
  `tipoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombreUsuario`, `apellidoPatUsuario`, `apellidoMatUsuario`, `nickUsuario`, `passwordUsuario`, `tipoUsuario`) VALUES
(1, 'Oscar', 'Ramirez', 'Chavez', 'orch', 'orch', 1),
(2, 'Isacc Javier', 'Lozano', 'Montañez', 'isacc', '836f3d03f5fe79afe1afdea3999c5d02', 2),
(3, 'Pablo', 'Ramírez', 'Chávez', 'pablo', '7e4b64eb65e34fdfad79e623c44abd94', 2),
(4, 'Pedro', 'Ramírez', 'Chávez', 'pedro', 'c6cc8094c2dc07b700ffcc36d64e2138', 2),
(5, 'Sue Ellen', 'Tuells', 'Magaña', 'suellen', '2e9edf50f2aab9d29f53de966a261cd3', 2),
(6, 'Prueba', 'Esto es', 'una prueba', 'prueba', 'c893bad68927b457dbed39460e6afd62', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acreedores`
--
ALTER TABLE `acreedores`
  ADD PRIMARY KEY (`rfcAcreedor`);

--
-- Indices de la tabla `aduanasdeclaraciones`
--
ALTER TABLE `aduanasdeclaraciones`
  ADD PRIMARY KEY (`folioDeclaracion`),
  ADD KEY `folioImportacion` (`folioImportacion`),
  ADD KEY `rfcTransportista` (`rfcTransportista`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`rfcCliente`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`folioCotizacion`),
  ADD KEY `rfcCliente` (`rfcCliente`);

--
-- Indices de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  ADD PRIMARY KEY (`idDetalleCotizacion`),
  ADD KEY `folioCotizacion` (`folioCotizacion`),
  ADD KEY `folioProducto` (`folioProducto`);

--
-- Indices de la tabla `detalledeclaraciones`
--
ALTER TABLE `detalledeclaraciones`
  ADD PRIMARY KEY (`idDetalleDA`),
  ADD KEY `folioDeclaracion` (`folioDeclaracion`),
  ADD KEY `idDetalleOC` (`idDetalleOC`);

--
-- Indices de la tabla `detalleimportacion`
--
ALTER TABLE `detalleimportacion`
  ADD PRIMARY KEY (`idDetalleImportacion`),
  ADD KEY `folioImportacion` (`folioImportacion`),
  ADD KEY `idDetalleOc` (`idDetalleOc`);

--
-- Indices de la tabla `detalleordenescompra`
--
ALTER TABLE `detalleordenescompra`
  ADD PRIMARY KEY (`idDetalleOc`),
  ADD KEY `folioOrdenCompra` (`folioOrdenCompra`),
  ADD KEY `folioProducto` (`folioProducto`);

--
-- Indices de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  ADD PRIMARY KEY (`idDetallePedido`),
  ADD KEY `folioPedido` (`folioPedido`),
  ADD KEY `folioProducto` (`folioProducto`);

--
-- Indices de la tabla `importaciones`
--
ALTER TABLE `importaciones`
  ADD PRIMARY KEY (`folioImportacion`),
  ADD KEY `folioOrdenCompra` (`folioOrdenCompra`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idInventario`),
  ADD KEY `folioProducto` (`folioProducto`);

--
-- Indices de la tabla `mxnbancos`
--
ALTER TABLE `mxnbancos`
  ADD PRIMARY KEY (`folioMXNBanco`);

--
-- Indices de la tabla `mxncuentac`
--
ALTER TABLE `mxncuentac`
  ADD PRIMARY KEY (`folioCuentaC`),
  ADD KEY `rfcCliente` (`rfcCliente`);

--
-- Indices de la tabla `mxncuentasp`
--
ALTER TABLE `mxncuentasp`
  ADD PRIMARY KEY (`folioCuentP`),
  ADD KEY `rfcProveedor` (`rfcProveedor`),
  ADD KEY `rfcAcreedor` (`rfcAcreedor`);

--
-- Indices de la tabla `ordenescarga`
--
ALTER TABLE `ordenescarga`
  ADD PRIMARY KEY (`folioOrdenCarga`);

--
-- Indices de la tabla `ordenescompra`
--
ALTER TABLE `ordenescompra`
  ADD PRIMARY KEY (`folioOrdenCompra`),
  ADD KEY `rfcProveedor` (`rfcProveedor`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`folioPedido`),
  ADD KEY `rfcCliente` (`rfcCliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`folioProducto`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`rfcProveedor`);

--
-- Indices de la tabla `remisiones`
--
ALTER TABLE `remisiones`
  ADD PRIMARY KEY (`folioRemision`),
  ADD KEY `folioOrdenCarga` (`folioOrdenCarga`);

--
-- Indices de la tabla `transportistas`
--
ALTER TABLE `transportistas`
  ADD PRIMARY KEY (`rfcTransportista`);

--
-- Indices de la tabla `usdbancos`
--
ALTER TABLE `usdbancos`
  ADD PRIMARY KEY (`folioUSDBanco`);

--
-- Indices de la tabla `usdcuentasc`
--
ALTER TABLE `usdcuentasc`
  ADD PRIMARY KEY (`folioCuentaC`),
  ADD KEY `rfcCliente` (`rfcCliente`);

--
-- Indices de la tabla `usdcuentasp`
--
ALTER TABLE `usdcuentasp`
  ADD PRIMARY KEY (`folioCuentaP`),
  ADD KEY `rfcProveedor` (`rfcProveedor`),
  ADD KEY `rfcAcreedor` (`rfcAcreedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detallecotizacion`
--
ALTER TABLE `detallecotizacion`
  MODIFY `idDetalleCotizacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalledeclaraciones`
--
ALTER TABLE `detalledeclaraciones`
  MODIFY `idDetalleDA` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalleimportacion`
--
ALTER TABLE `detalleimportacion`
  MODIFY `idDetalleImportacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detalleordenescompra`
--
ALTER TABLE `detalleordenescompra`
  MODIFY `idDetalleOc` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `detallepedidos`
--
ALTER TABLE `detallepedidos`
  MODIFY `idDetallePedido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idInventario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
