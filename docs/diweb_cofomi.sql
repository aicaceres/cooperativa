-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 12-06-2021 a las 14:39:58
-- Versión del servidor: 10.3.29-MariaDB-log
-- Versión de PHP: 7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `diweb_cofomi`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abierta` tinyint(1) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `created_by`, `nombre`, `abierta`, `created`) VALUES
(1, 1, 'UNICA', 1, '2016-05-20 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_apertura`
--

CREATE TABLE `caja_apertura` (
  `id` int(11) NOT NULL,
  `caja_id` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `fecha_apertura` datetime NOT NULL,
  `monto_apertura` decimal(10,2) NOT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_cierre` decimal(10,2) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `caja_apertura`
--

INSERT INTO `caja_apertura` (`id`, `caja_id`, `updated_by`, `created_by`, `fecha_apertura`, `monto_apertura`, `fecha_cierre`, `monto_cierre`, `created`) VALUES
(1, 1, 1, 1, '2016-06-01 17:32:23', '500.00', '2016-06-22 18:48:49', '670.00', '2016-06-01 17:32:23'),
(2, 1, 1, 1, '2016-06-28 08:31:24', '400.00', '2016-06-28 10:04:03', '400.00', '2016-06-28 08:31:24'),
(3, 1, 1, 1, '2016-06-28 10:08:09', '400.00', '2016-06-28 10:23:39', '400.00', '2016-06-28 10:08:09'),
(4, 1, 1, 1, '2016-06-28 15:11:42', '400.00', '2016-07-18 01:17:37', '634.11', '2016-06-28 15:11:42'),
(5, 1, 1, 1, '2019-01-10 15:06:51', '2500.00', '2021-02-11 09:24:02', '5000.00', '2019-01-10 15:06:51'),
(6, 1, 1, 1, '2021-05-12 08:20:51', '0.00', NULL, NULL, '2021-05-12 08:20:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_movimiento`
--

CREATE TABLE `caja_movimiento` (
  `id` int(11) NOT NULL,
  `caja_apertura_id` int(11) DEFAULT NULL,
  `socio_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `responsable_pago` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `total` decimal(10,2) NOT NULL,
  `pago` decimal(10,2) DEFAULT NULL,
  `descripcion_pago` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `caja_movimiento`
--

INSERT INTO `caja_movimiento` (`id`, `caja_apertura_id`, `socio_id`, `created_by`, `fecha`, `responsable_pago`, `total`, `pago`, `descripcion_pago`, `created`, `tipo`, `descripcion`) VALUES
(3, 1, NULL, 1, '2016-06-14 15:46:04', NULL, '10.00', NULL, NULL, '2016-06-14 15:46:04', 'E', 'asdfasd'),
(4, 1, NULL, 1, '2016-06-21 19:06:52', NULL, '20.00', NULL, NULL, '2016-06-21 19:06:52', 'E', 'fasdfas'),
(13, 1, 2, 1, '2016-06-22 18:47:13', 'ARRECHEA, HILDA', '202.22', '200.00', NULL, '2016-06-22 18:47:13', 'I', NULL),
(14, 1, NULL, 1, '2016-06-28 08:31:55', NULL, '200.00', NULL, NULL, '2016-06-28 08:31:55', 'E', 'sdfasdf'),
(15, 1, NULL, 1, '2016-06-28 08:39:32', NULL, '300.00', NULL, NULL, '2016-06-28 08:39:32', 'E', 'sdfasdf'),
(16, 3, NULL, 1, '2016-06-28 10:23:00', NULL, '200.00', NULL, NULL, '2016-06-28 10:23:01', 'E', 'sdfasdf'),
(17, 3, NULL, 1, '2016-06-28 10:23:27', 'YO', '200.00', '200.00', NULL, '2016-06-28 10:23:27', 'I', 'fsdfasd'),
(18, 4, 1, 1, '2016-07-17 21:57:03', 'ALEGRE, CINTIA', '202.60', '102.60', NULL, '2016-07-17 21:57:03', 'I', NULL),
(19, 4, 1, 1, '2016-07-17 22:02:44', 'ALEGRE, CINTIA', '129.29', '129.29', NULL, '2016-07-17 22:02:44', 'I', NULL),
(20, 4, 2, 1, '2016-07-17 22:29:27', 'ARRECHEA, HILDA', '2.22', '2.22', NULL, '2016-07-17 22:29:27', 'I', NULL),
(21, 5, 3, 1, '2019-01-10 15:08:18', 'DA LUZ, MAURO', '500.00', '500.00', 'prueba', '2019-01-10 15:08:18', 'I', 'cuota socio'),
(22, 5, 1, 1, '2021-02-11 09:23:31', 'ALEGRE, CINTIA', '550.00', '550.00', 'fsdfsfs', '2021-02-11 09:23:31', 'I', 'cobro'),
(23, 5, NULL, 1, '2021-02-11 09:23:49', NULL, '1000.00', NULL, NULL, '2021-02-11 09:23:49', 'E', 'bcvbc'),
(24, 6, 3, 1, '2021-05-12 08:21:45', 'DA LUZ, MAURO', '2.00', '2.00', 'ksjkljsfklsdjfkljsdlkfjds', '2021-05-12 08:21:45', 'I', 'cobro cuota nro 3'),
(25, 6, 4, 1, '2021-05-12 08:25:43', 'gimenez, pedro', '3.00', '3.00', NULL, '2021-05-12 08:25:43', 'I', 'dto gimenez'),
(26, 6, 3, 1, '2021-05-18 09:54:33', 'DA LUZ, MAURO', '1.00', '1.00', 'ASDASDA', '2021-05-18 09:54:33', 'I', 'dto arreglo auto'),
(27, 6, 2, 1, '2021-05-18 11:23:39', 'ARRECHEA, HILDA', '922.27', '922.27', NULL, '2021-05-18 11:23:39', 'I', 'pago chapa');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_movimiento_detalle`
--

CREATE TABLE `caja_movimiento_detalle` (
  `id` int(11) NOT NULL,
  `concepto_caja_id` int(11) DEFAULT NULL,
  `caja_movimiento_id` int(11) DEFAULT NULL,
  `deuda_id` int(11) DEFAULT NULL,
  `orden` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `importe` decimal(10,2) NOT NULL,
  `saldo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `caja_movimiento_detalle`
--

INSERT INTO `caja_movimiento_detalle` (`id`, `concepto_caja_id`, `caja_movimiento_id`, `deuda_id`, `orden`, `descripcion`, `importe`, `saldo`) VALUES
(1, 5, NULL, NULL, 1, NULL, '10.00', '0.00'),
(2, 5, 3, NULL, 1, 'sdsafd', '10.00', '0.00'),
(3, 5, 4, NULL, 1, 'dsds', '20.00', '0.00'),
(12, 1, 13, 2, 1, 'Pago de Cuota - JUN/2016', '102.22', '0.00'),
(13, 1, 13, 3, 2, 'Pago de Cuota - JUL/2016', '100.00', '0.00'),
(14, 5, 14, NULL, 1, 'fadsf', '200.00', '0.00'),
(15, 5, 15, NULL, 1, 'asfasdfs', '300.00', '0.00'),
(16, 5, 16, NULL, 1, 'fasd', '200.00', '0.00'),
(17, 4, 17, NULL, 1, 'fdsda', '200.00', '0.00'),
(18, 3, 18, 8, 1, 'Pago de Matrícula -', '101.30', '0.00'),
(19, 1, 18, 9, 2, 'Pago de Cuota - JUL/2016', '101.30', '0.00'),
(20, 3, 19, 1, 1, 'Pago de Matrícula - Año 2016', '108.33', '0.00'),
(21, 3, 19, 7, 2, 'Pago de Matrícula - det matricula', '20.96', '0.00'),
(22, 1, 20, 3, 1, 'Pago de Cuota - JUL/2016', '2.22', '0.00'),
(23, 1, 21, 25, 1, 'Pago de Cuota - ENE/2019', '500.00', '0.00'),
(24, 1, 22, 37, 1, 'dsfsdfs', '550.00', '0.00'),
(25, 5, 23, NULL, 1, NULL, '1000.00', '0.00'),
(26, 1, 24, 26, 1, 'Pago de Cuota - FEB/2019', '1.00', '0.00'),
(27, 1, 24, 27, 2, 'Pago de Cuota - MAR/2019', '1.00', '0.00'),
(28, 1, 25, 38, 1, 'Pago de Cuota - MAY/2021', '2.00', '0.00'),
(29, 3, 25, 42, 2, 'Pago de Matrícula -', '1.00', '0.00'),
(30, 1, 26, 28, 1, 'Pago de Cuota - ABR/2019', '1.00', '0.00'),
(31, 1, 27, 4, 1, 'Pago de Cuota - AGO/2016', '422.27', '0.00'),
(32, 6, 27, 54, 2, 'ffgrg', '500.00', '0.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto_caja`
--

CREATE TABLE `concepto_caja` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requiere_socio` tinyint(1) DEFAULT NULL,
  `de_sistema` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `concepto_caja`
--

INSERT INTO `concepto_caja` (`id`, `nombre`, `tipo`, `requiere_socio`, `de_sistema`, `monto`) VALUES
(1, 'Cuota', 'I', 1, '1', '100.00'),
(3, 'Matrícula', 'I', 1, '0', NULL),
(4, 'Certificado', 'I', 1, '0', NULL),
(5, 'Gasto 1', 'E', 0, NULL, NULL),
(6, 'Saldo Inicial', 'I', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `dia_vto_cuota` int(11) NOT NULL,
  `tipo_recargo_cuota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `monto_recargo_cuota` decimal(10,3) NOT NULL,
  `updated` datetime NOT NULL,
  `texto_mail_morosos` longtext COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `updated_by`, `dia_vto_cuota`, `tipo_recargo_cuota`, `monto_recargo_cuota`, `updated`, `texto_mail_morosos`) VALUES
(1, 1, 10, 'P', '0.185', '2016-06-03 10:58:26', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `tipo_contacto_id` int(11) DEFAULT NULL,
  `socio_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `dato` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `horario` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `deuda`
--

CREATE TABLE `deuda` (
  `id` int(11) NOT NULL,
  `concepto_caja_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `fecha_vto` datetime NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `mora` decimal(10,2) NOT NULL,
  `cancelada` tinyint(1) NOT NULL,
  `fecha_cancelacion` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `socio_id` int(11) DEFAULT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `deuda`
--

INSERT INTO `deuda` (`id`, `concepto_caja_id`, `created_by`, `fecha_vto`, `monto`, `mora`, `cancelada`, `fecha_cancelacion`, `created`, `socio_id`, `descripcion`) VALUES
(1, 3, 1, '2016-06-02 00:00:00', '100.00', '8.33', 1, '2016-07-17 22:02:44', '2016-06-03 09:46:44', 1, 'Año 2016'),
(2, 1, 1, '2016-06-10 00:00:00', '100.00', '2.22', 1, '2016-06-22 18:47:13', '2016-06-21 16:34:46', 2, 'JUN/2016'),
(3, 1, 1, '2016-07-10 00:00:00', '100.00', '-97.78', 1, '2016-07-17 22:29:27', '2016-06-21 16:34:46', 2, 'JUL/2016'),
(4, 1, 1, '2016-08-10 00:00:00', '100.00', '322.27', 1, '2021-05-18 11:23:39', '2016-06-21 16:34:46', 2, 'AGO/2016'),
(5, 1, 1, '2016-09-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-06-21 16:34:46', 2, 'SEP/2016'),
(6, 1, 1, '2016-10-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-06-21 16:34:46', 2, 'OCT/2016'),
(7, 3, 1, '2016-06-21 19:18:04', '20.00', '0.96', 1, '2016-06-21 19:18:04', '2016-06-21 19:18:04', 1, 'det matricula'),
(8, 3, 1, '2016-07-10 00:00:00', '100.00', '1.30', 1, '2016-07-17 21:57:03', '2016-07-17 21:53:36', 1, NULL),
(9, 1, 1, '2016-07-10 00:00:00', '100.00', '1.30', 0, NULL, '2016-07-17 21:55:09', 1, 'JUL/2016'),
(10, 1, 1, '2016-08-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 21:55:09', 1, 'AGO/2016'),
(11, 1, 1, '2016-09-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 21:55:09', 1, 'SEP/2016'),
(12, 1, 1, '2016-10-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 21:55:09', 1, 'OCT/2016'),
(13, 1, 1, '2016-11-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 21:55:09', 1, 'NOV/2016'),
(14, 1, 1, '2016-07-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'JUL/2016'),
(15, 1, 1, '2016-08-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'AGO/2016'),
(16, 1, 1, '2016-09-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'SEP/2016'),
(17, 1, 1, '2016-10-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'OCT/2016'),
(18, 1, 1, '2016-11-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'NOV/2016'),
(19, 1, 1, '2016-12-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'DIC/2016'),
(20, 1, 1, '2017-01-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'ENE/2017'),
(21, 1, 1, '2017-02-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'FEB/2017'),
(22, 1, 1, '2017-03-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'MAR/2017'),
(23, 1, 1, '2017-04-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-17 23:51:49', 1, 'ABR/2017'),
(24, 1, 1, '2016-12-10 00:00:00', '100.00', '0.00', 0, NULL, '2016-07-18 00:05:08', 1, 'Anual 2017'),
(25, 1, 1, '2019-01-10 00:00:00', '500.00', '0.00', 1, '2019-01-10 15:08:18', '2019-01-10 15:04:47', 3, 'ENE/2019'),
(26, 1, 1, '2019-02-10 00:00:00', '500.00', '-499.00', 1, '2021-05-12 08:21:45', '2019-01-10 15:04:47', 3, 'FEB/2019'),
(27, 1, 1, '2019-03-10 00:00:00', '500.00', '-499.00', 1, '2021-05-12 08:21:45', '2019-01-10 15:04:47', 3, 'MAR/2019'),
(28, 1, 1, '2019-04-10 00:00:00', '500.00', '-499.00', 1, '2021-05-18 09:54:33', '2019-01-10 15:04:47', 3, 'ABR/2019'),
(29, 1, 1, '2019-05-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'MAY/2019'),
(30, 1, 1, '2019-06-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'JUN/2019'),
(31, 1, 1, '2019-07-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'JUL/2019'),
(32, 1, 1, '2019-08-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'AGO/2019'),
(33, 1, 1, '2019-09-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'SEP/2019'),
(34, 1, 1, '2019-10-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'OCT/2019'),
(35, 1, 1, '2019-11-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'NOV/2019'),
(36, 1, 1, '2019-12-10 00:00:00', '500.00', '0.00', 0, NULL, '2019-01-10 15:04:47', 3, 'DIC/2019'),
(37, 1, 1, '2021-02-11 09:23:31', '550.00', '0.00', 1, '2021-02-11 09:23:31', '2021-02-11 09:23:31', 1, 'dsfsdfs'),
(38, 1, 1, '2021-05-15 00:00:00', '2500.00', '-2498.00', 1, '2021-05-12 08:25:43', '2021-05-12 08:24:17', 4, 'MAY/2021'),
(39, 1, 1, '2021-06-15 00:00:00', '2500.00', '0.00', 0, NULL, '2021-05-12 08:24:17', 4, 'JUN/2021'),
(40, 1, 1, '2021-07-15 00:00:00', '2500.00', '0.00', 0, NULL, '2021-05-12 08:24:17', 4, 'JUL/2021'),
(41, 1, 1, '2021-08-15 00:00:00', '2500.00', '0.00', 0, NULL, '2021-05-12 08:24:17', 4, 'AGO/2021'),
(42, 3, 1, '2021-05-15 00:00:00', '1000.00', '-999.00', 1, '2021-05-12 08:25:43', '2021-05-12 08:24:56', 4, NULL),
(43, 3, 1, '2021-05-10 00:00:00', '520.00', '0.00', 0, NULL, '2021-05-18 09:55:37', 3, 'ASDAS'),
(44, 1, 1, '2021-05-10 00:00:00', '1500.00', '0.00', 0, NULL, '2021-05-18 09:55:50', 3, 'MAY/2021'),
(45, 1, 1, '2021-06-10 00:00:00', '1500.00', '0.00', 0, NULL, '2021-05-18 09:55:50', 3, 'JUN/2021'),
(46, 1, 1, '2021-07-10 00:00:00', '1500.00', '0.00', 0, NULL, '2021-05-18 09:55:50', 3, 'JUL/2021'),
(47, 1, 1, '2021-08-10 00:00:00', '1500.00', '0.00', 0, NULL, '2021-05-18 09:55:50', 3, 'AGO/2021'),
(48, 1, 1, '2021-09-10 00:00:00', '1500.00', '0.00', 0, NULL, '2021-05-18 09:55:50', 3, 'SEP/2021'),
(49, 3, 1, '2021-05-10 00:00:00', '2500.00', '0.00', 0, NULL, '2021-05-18 11:17:39', 3, 'cubiertas'),
(50, 1, 1, '2021-05-28 00:00:00', '50000.00', '0.00', 0, NULL, '2021-05-18 11:18:29', 3, 'MAY/2021'),
(51, 1, 1, '2021-06-28 00:00:00', '50000.00', '0.00', 0, NULL, '2021-05-18 11:18:29', 3, 'JUN/2021'),
(52, 1, 1, '2021-07-28 00:00:00', '50000.00', '0.00', 0, NULL, '2021-05-18 11:18:29', 3, 'JUL/2021'),
(53, 1, 1, '2021-08-28 00:00:00', '50000.00', '0.00', 0, NULL, '2021-05-18 11:18:29', 3, 'AGO/2021'),
(54, 6, 1, '2021-05-18 11:23:39', '500.00', '0.00', 1, '2021-05-18 11:23:39', '2021-05-18 11:23:39', 2, 'ffgrg'),
(55, 3, 1, '2021-05-10 00:00:00', '150.00', '0.00', 0, NULL, '2021-05-19 08:10:06', 3, '1111111111111111111111111111111111111111111111111111111111');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `domicilio`
--

CREATE TABLE `domicilio` (
  `id` int(11) NOT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `socio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `domicilio`
--

INSERT INTO `domicilio` (`id`, `localidad_id`, `created_by`, `direccion`, `telefono`, `created`, `socio_id`) VALUES
(1, 18, 1, 'Grubert  y Mecking S/N', NULL, '2016-06-24 17:42:20', 1),
(3, 3, 1, 'Belgrano N° 300', NULL, '2016-06-30 01:03:32', 2),
(4, 1, 1, 'lavalle 1500', '376555222', '2019-01-10 15:03:56', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidad`
--

CREATE TABLE `localidad` (
  `id` int(11) NOT NULL,
  `provincia_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `codpostal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `by_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `localidad`
--

INSERT INTO `localidad` (`id`, `provincia_id`, `name`, `codpostal`, `by_default`) VALUES
(1, 1, 'Posadas', '3300', 1),
(2, 1, '25 de Mayo', '3363', 0),
(3, 1, 'Apóstoles', '3350', 0),
(4, 1, 'Aristobulo del Valle\r', '3364', 0),
(5, 1, 'Bernardo de Irigoyen\r', '3366', 0),
(6, 1, 'Bonpland', '3308', 0),
(7, 1, 'Campo Grande\r', '3362', 0),
(8, 1, 'Campo Viera\r', '3362', 0),
(9, 1, 'Candelaria\r', '3308', 0),
(10, 1, 'Capiovy\r', '3332', 0),
(11, 1, 'Cerro Azul\r', '3313', 0),
(12, 1, 'Colonia Wanda\r', '3376', 0),
(13, 1, 'Dos de Mayo\r', '3364', 0),
(14, 1, 'Eldorado\r', '3380', 0),
(15, 1, 'Garupá', '3304', 0),
(16, 1, 'Guaraní', '3361', 0),
(17, 1, 'Jardín América\r', '3328', 0),
(18, 1, 'Leandro N. Alem\r', '3315', 0),
(19, 1, 'Montecarlo\r', '3384', 0),
(20, 1, 'Oberá', '3360', 0),
(21, 1, 'Panambí\r', '3361', 0),
(23, 1, 'Puerto Rico\r', '3334', 0),
(24, 1, 'San Ignacio\r', '3322', 0),
(25, 1, 'San Javier\r', '3357', 0),
(26, 1, 'San Vicente\r', '3364', 0),
(27, 1, 'Santa Rita\r', '3363', 0),
(28, 1, 'Wanda', '3376', 0),
(29, 1, 'Puerto Iguazú', '3370', 0),
(30, 1, 'Andresito', '3385', 0),
(31, 1, 'Garuhape', '3334', 0),
(32, 1, 'San Pedro', '3352', 0),
(34, 1, 'Santa Ana', '3316', 0),
(35, 1, 'Gdor. Roca', '3324', 0),
(36, 1, 'El Soberbio', '3364', 0),
(37, 1, 'Puerto Esperanza', '3378', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` int(11) NOT NULL,
  `deuda_id` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `importe` decimal(10,2) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `caja_movimiento_id` int(11) DEFAULT NULL,
  `caja_movimiento_detalle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `deuda_id`, `created_by`, `fecha`, `importe`, `descripcion`, `created`, `caja_movimiento_id`, `caja_movimiento_detalle_id`) VALUES
(6, 2, 1, '2016-06-22', '102.22', NULL, '2016-06-22 18:47:13', 13, 12),
(7, 3, 1, '2016-06-22', '97.78', NULL, '2016-06-22 18:47:13', 13, 13),
(8, 8, 1, '2016-07-17', '101.30', NULL, '2016-07-17 21:57:03', 18, 18),
(9, 9, 1, '2016-07-17', '1.30', NULL, '2016-07-17 21:57:03', 18, 19),
(10, 1, 1, '2016-07-17', '108.33', NULL, '2016-07-17 22:02:44', 19, 20),
(11, 7, 1, '2016-07-17', '20.96', NULL, '2016-07-17 22:02:44', 19, 21),
(12, 3, 1, '2016-07-17', '2.22', NULL, '2016-07-17 22:29:27', 20, 22),
(13, 25, 1, '2019-01-10', '500.00', NULL, '2019-01-10 15:08:18', 21, 23),
(14, 37, 1, '2021-02-11', '550.00', NULL, '2021-02-11 09:23:31', 22, 24),
(15, 26, 1, '2021-05-12', '1.00', NULL, '2021-05-12 08:21:45', 24, 26),
(16, 27, 1, '2021-05-12', '1.00', NULL, '2021-05-12 08:21:45', 24, 27),
(17, 38, 1, '2021-05-12', '2.00', NULL, '2021-05-12 08:25:43', 25, 28),
(18, 42, 1, '2021-05-12', '1.00', NULL, '2021-05-12 08:25:43', 25, 29),
(19, 28, 1, '2021-05-18', '1.00', NULL, '2021-05-18 09:54:33', 26, 30),
(20, 4, 1, '2021-05-18', '422.27', NULL, '2021-05-18 11:23:39', 27, 31),
(21, 54, 1, '2021-05-18', '500.00', NULL, '2021-05-18 11:23:39', 27, 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `by_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `name`, `by_default`) VALUES
(1, 'Argentina', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametros`
--

CREATE TABLE `parametros` (
  `id` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `dia_vto_cuota` int(11) NOT NULL,
  `tipo_recargo_cuota` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `monto_recargo_cuota` decimal(10,2) NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `parametros`
--

INSERT INTO `parametros` (`id`, `updated_by`, `dia_vto_cuota`, `tipo_recargo_cuota`, `monto_recargo_cuota`, `updated`) VALUES
(1, 1, 10, 'P', '1.20', '2016-05-20 09:05:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pemisos_x_perfil`
--

CREATE TABLE `pemisos_x_perfil` (
  `perfil_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pemisos_x_perfil`
--

INSERT INTO `pemisos_x_perfil` (`perfil_id`, `permiso_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `parametro` tinyint(1) NOT NULL,
  `seguridad` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `socio` tinyint(1) NOT NULL,
  `caja` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`id`, `nombre`, `admin`, `parametro`, `seguridad`, `created`, `socio`, `caja`) VALUES
(1, 'Administrador', 1, 1, 1, '2016-05-23 16:10:26', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `texto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`id`, `created_by`, `modulo`, `item`, `tag`, `texto`, `created`) VALUES
(1, 1, 'socio', 'abm', 'new', 'Dar de Alta', '2016-05-21 18:46:17'),
(2, 1, 'socio', 'abm', 'edit', 'Modificar información', '2016-05-21 18:46:39'),
(3, 1, 'socio', 'abm', 'delete', 'Eliminar', '2016-05-21 18:47:05'),
(4, 1, 'seguridad', 'usuario', 'new', 'Dar de Alta', '2016-05-21 18:48:02'),
(5, 1, 'seguridad', 'usuario', 'edit', 'Modificar información', '2016-05-21 18:48:44'),
(6, 1, 'seguridad', 'usuario', 'delete', 'Eliminar', '2016-05-20 00:00:00'),
(7, 1, 'seguridad', 'perfil', 'new', 'Dar de Alta', '2016-05-20 00:00:00'),
(8, 1, 'seguridad', 'perfil', 'edit', 'Modificar Información', '2016-05-22 00:00:00'),
(9, 1, 'seguridad', 'perfil', 'delete', 'Eliminar', '2016-05-20 00:00:00'),
(10, 1, 'socio', 'ctacte', 'show', 'Ver Estado de Deuda', '2016-05-27 15:34:52'),
(11, 1, 'socio', 'ctacte', 'new', 'Cargar Conceptos', '2016-05-29 23:08:34'),
(12, 1, 'socio', 'ctacte', 'delete', 'Eliminar Conceptos', '2016-05-29 23:08:58'),
(13, 1, 'socio', 'abm', 'mailing', 'Envío de Correos', '2016-07-17 12:01:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincia`
--

CREATE TABLE `provincia` (
  `id` int(11) NOT NULL,
  `pais_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `by_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `provincia`
--

INSERT INTO `provincia` (`id`, `pais_id`, `name`, `by_default`) VALUES
(1, 1, 'Misiones', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `codigo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nro_documento` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `matricula` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_matriculacion` date DEFAULT NULL,
  `fecha_habilitacion` date DEFAULT NULL,
  `fecha_baja` date DEFAULT NULL,
  `actividad_principal` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `actividad_secundaria` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `situacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `celular` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) DEFAULT NULL,
  `deletedAt` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `localidad_id` int(11) DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `saldo_inicial` decimal(10,2) DEFAULT NULL,
  `universidad_id` int(11) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id`, `created_by`, `updated_by`, `codigo`, `nro_documento`, `nombre`, `apellido`, `matricula`, `fecha_matriculacion`, `fecha_habilitacion`, `fecha_baja`, `actividad_principal`, `actividad_secundaria`, `situacion`, `celular`, `activo`, `deletedAt`, `created`, `updated`, `email`, `localidad_id`, `direccion`, `telefono`, `saldo_inicial`, `universidad_id`, `fecha_nacimiento`, `titulo`) VALUES
(1, 1, 1, 'A1', '22616136', 'CINTIA', 'ALEGRE', '0029', NULL, NULL, NULL, NULL, 'jfalegre@nodoalem.com.ar', NULL, '03754 -  15459043', 1, NULL, '2016-05-13 19:40:46', '2016-07-17 15:53:54', 'alejandraicaceres@gmail.com', 18, 'B Virgen del Rosario Mz “B” Casa 17', '03754 – 421997', NULL, 1, '1972-05-05', 'Fonoaudiólogo/a'),
(2, 1, 1, 'A2', '6719485', 'HILDA', 'ARRECHEA', '0021', NULL, NULL, NULL, NULL, 'hildaarrechea@gmail.com', NULL, '15409900', 1, NULL, '2016-05-21 19:35:52', '2016-07-17 22:42:16', 'alejandraicaceres@gmail.com', 3, 'Av. 9 de Julio 1155', '03758 421096/424235', NULL, 2, '1951-08-01', 'Fonoaudiólogo/a'),
(3, 1, 1, '003', '28675703', 'MAURO', 'DA LUZ', '1212121', '2019-01-01', '2019-01-01', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2019-01-10 15:03:56', '2019-01-10 15:06:03', 'maurodl2003@hotmail.com', 1, NULL, NULL, NULL, 1, '2001-01-01', 'Ingeniero'),
(4, 1, 1, NULL, '4555555', 'pedro', 'gimenez', '54', '2021-05-12', '2021-05-12', NULL, NULL, NULL, NULL, NULL, 1, NULL, '2021-05-12 08:23:08', '2021-05-12 08:23:08', NULL, 1, NULL, NULL, NULL, 1, '2021-05-12', 'Fonoaudiólogo/a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_contacto`
--

CREATE TABLE `tipo_contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `abreviatura` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requerido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_operacion`
--

CREATE TABLE `tipo_operacion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `monto` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_operacion`
--

INSERT INTO `tipo_operacion` (`id`, `nombre`, `monto`) VALUES
(1, 'Pago de Cuota', '80.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `universidad`
--

CREATE TABLE `universidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `universidad`
--

INSERT INTO `universidad` (`id`, `nombre`) VALUES
(1, 'UNC'),
(2, 'UBA'),
(3, 'USAL'),
(4, 'Instituto DECROLY');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `perfil_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `roles` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `perfil_id`, `username`, `nombre`, `dni`, `email`, `password`, `activo`, `fecha_alta`, `roles`) VALUES
(1, 1, 'ADMIN', 'Administrador', '00000000', 'administrador@cofomi.com.ar', 'V42o7RRazJdSCevU6229+3k+hPB3Abq2dsziOxNeFqHpso0u14hB8BSThxFSyYBZQdQ1RBV0Fi+H++stpdv4Cw==', 0, '0000-00-00 00:00:00', 'ROLE_ADMIN');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E465F405DE12AB56` (`created_by`);

--
-- Indices de la tabla `caja_apertura`
--
ALTER TABLE `caja_apertura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_94D675A22D82B651` (`caja_id`),
  ADD KEY `IDX_94D675A216FE72E1` (`updated_by`),
  ADD KEY `IDX_94D675A2DE12AB56` (`created_by`);

--
-- Indices de la tabla `caja_movimiento`
--
ALTER TABLE `caja_movimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D22A8FD38145B6F8` (`caja_apertura_id`),
  ADD KEY `IDX_D22A8FD3DA04E6A9` (`socio_id`),
  ADD KEY `IDX_D22A8FD3DE12AB56` (`created_by`);

--
-- Indices de la tabla `caja_movimiento_detalle`
--
ALTER TABLE `caja_movimiento_detalle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_57BF7CC010B8325E` (`concepto_caja_id`),
  ADD KEY `IDX_57BF7CC08E2E03D9` (`caja_movimiento_id`),
  ADD KEY `IDX_57BF7CC0C5CAD3D1` (`deuda_id`);

--
-- Indices de la tabla `concepto_caja`
--
ALTER TABLE `concepto_caja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_682CCAF116FE72E1` (`updated_by`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2741493C5E747251` (`tipo_contacto_id`),
  ADD KEY `IDX_2741493CDA04E6A9` (`socio_id`),
  ADD KEY `IDX_2741493CDE12AB56` (`created_by`);

--
-- Indices de la tabla `deuda`
--
ALTER TABLE `deuda`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CF76747710B8325E` (`concepto_caja_id`),
  ADD KEY `IDX_CF767477DE12AB56` (`created_by`),
  ADD KEY `IDX_CF767477DA04E6A9` (`socio_id`);

--
-- Indices de la tabla `domicilio`
--
ALTER TABLE `domicilio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9B942ED167707C89` (`localidad_id`),
  ADD KEY `IDX_9B942ED1DE12AB56` (`created_by`),
  ADD KEY `IDX_9B942ED1DA04E6A9` (`socio_id`);

--
-- Indices de la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4F68E0104E7121AF` (`provincia_id`);

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F4DF5F3EC5CAD3D1` (`deuda_id`),
  ADD KEY `IDX_F4DF5F3EDE12AB56` (`created_by`),
  ADD KEY `IDX_F4DF5F3E8E2E03D9` (`caja_movimiento_id`),
  ADD KEY `IDX_F4DF5F3E2FBACBC0` (`caja_movimiento_detalle_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E096911716FE72E1` (`updated_by`);

--
-- Indices de la tabla `pemisos_x_perfil`
--
ALTER TABLE `pemisos_x_perfil`
  ADD PRIMARY KEY (`perfil_id`,`permiso_id`),
  ADD KEY `IDX_5DC769B957291544` (`perfil_id`),
  ADD KEY `IDX_5DC769B96CEFAD37` (`permiso_id`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD7AAB9EDE12AB56` (`created_by`);

--
-- Indices de la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D39AF213C604D5C6` (`pais_id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_38B65309DE12AB56` (`created_by`),
  ADD KEY `IDX_38B6530916FE72E1` (`updated_by`),
  ADD KEY `IDX_38B6530967707C89` (`localidad_id`),
  ADD KEY `IDX_38B65309271768CD` (`universidad_id`);

--
-- Indices de la tabla `tipo_contacto`
--
ALTER TABLE `tipo_contacto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_operacion`
--
ALTER TABLE `tipo_operacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `universidad`
--
ALTER TABLE `universidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2265B05D57291544` (`perfil_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `caja_apertura`
--
ALTER TABLE `caja_apertura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `caja_movimiento`
--
ALTER TABLE `caja_movimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `caja_movimiento_detalle`
--
ALTER TABLE `caja_movimiento_detalle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `concepto_caja`
--
ALTER TABLE `concepto_caja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `deuda`
--
ALTER TABLE `deuda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `domicilio`
--
ALTER TABLE `domicilio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `localidad`
--
ALTER TABLE `localidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `parametros`
--
ALTER TABLE `parametros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `provincia`
--
ALTER TABLE `provincia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_contacto`
--
ALTER TABLE `tipo_contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_operacion`
--
ALTER TABLE `tipo_operacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `universidad`
--
ALTER TABLE `universidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `FK_E465F405DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `caja_apertura`
--
ALTER TABLE `caja_apertura`
  ADD CONSTRAINT `FK_94D675A216FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_94D675A22D82B651` FOREIGN KEY (`caja_id`) REFERENCES `caja` (`id`),
  ADD CONSTRAINT `FK_94D675A2DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `caja_movimiento`
--
ALTER TABLE `caja_movimiento`
  ADD CONSTRAINT `FK_D22A8FD38145B6F8` FOREIGN KEY (`caja_apertura_id`) REFERENCES `caja_apertura` (`id`),
  ADD CONSTRAINT `FK_D22A8FD3DA04E6A9` FOREIGN KEY (`socio_id`) REFERENCES `socio` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_D22A8FD3DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `caja_movimiento_detalle`
--
ALTER TABLE `caja_movimiento_detalle`
  ADD CONSTRAINT `FK_57BF7CC010B8325E` FOREIGN KEY (`concepto_caja_id`) REFERENCES `concepto_caja` (`id`),
  ADD CONSTRAINT `FK_57BF7CC08E2E03D9` FOREIGN KEY (`caja_movimiento_id`) REFERENCES `caja_movimiento` (`id`),
  ADD CONSTRAINT `FK_57BF7CC0C5CAD3D1` FOREIGN KEY (`deuda_id`) REFERENCES `deuda` (`id`);

--
-- Filtros para la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD CONSTRAINT `FK_682CCAF116FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `FK_2741493C5E747251` FOREIGN KEY (`tipo_contacto_id`) REFERENCES `tipo_contacto` (`id`),
  ADD CONSTRAINT `FK_2741493CDA04E6A9` FOREIGN KEY (`socio_id`) REFERENCES `socio` (`id`),
  ADD CONSTRAINT `FK_2741493CDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `deuda`
--
ALTER TABLE `deuda`
  ADD CONSTRAINT `FK_CF76747710B8325E` FOREIGN KEY (`concepto_caja_id`) REFERENCES `concepto_caja` (`id`),
  ADD CONSTRAINT `FK_CF767477DA04E6A9` FOREIGN KEY (`socio_id`) REFERENCES `socio` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_CF767477DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `domicilio`
--
ALTER TABLE `domicilio`
  ADD CONSTRAINT `FK_9B942ED167707C89` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`),
  ADD CONSTRAINT `FK_9B942ED1DA04E6A9` FOREIGN KEY (`socio_id`) REFERENCES `socio` (`id`),
  ADD CONSTRAINT `FK_9B942ED1DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `localidad`
--
ALTER TABLE `localidad`
  ADD CONSTRAINT `FK_4F68E0104E7121AF` FOREIGN KEY (`provincia_id`) REFERENCES `provincia` (`id`);

--
-- Filtros para la tabla `pago`
--
ALTER TABLE `pago`
  ADD CONSTRAINT `FK_F4DF5F3E2FBACBC0` FOREIGN KEY (`caja_movimiento_detalle_id`) REFERENCES `caja_movimiento_detalle` (`id`),
  ADD CONSTRAINT `FK_F4DF5F3E8E2E03D9` FOREIGN KEY (`caja_movimiento_id`) REFERENCES `caja_movimiento` (`id`),
  ADD CONSTRAINT `FK_F4DF5F3EC5CAD3D1` FOREIGN KEY (`deuda_id`) REFERENCES `deuda` (`id`),
  ADD CONSTRAINT `FK_F4DF5F3EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `parametros`
--
ALTER TABLE `parametros`
  ADD CONSTRAINT `FK_E096911716FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `pemisos_x_perfil`
--
ALTER TABLE `pemisos_x_perfil`
  ADD CONSTRAINT `FK_5DC769B957291544` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`),
  ADD CONSTRAINT `FK_5DC769B96CEFAD37` FOREIGN KEY (`permiso_id`) REFERENCES `permiso` (`id`);

--
-- Filtros para la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD CONSTRAINT `FK_FD7AAB9EDE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `provincia`
--
ALTER TABLE `provincia`
  ADD CONSTRAINT `FK_D39AF213C604D5C6` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`);

--
-- Filtros para la tabla `socio`
--
ALTER TABLE `socio`
  ADD CONSTRAINT `FK_38B6530916FE72E1` FOREIGN KEY (`updated_by`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_38B65309271768CD` FOREIGN KEY (`universidad_id`) REFERENCES `universidad` (`id`),
  ADD CONSTRAINT `FK_38B6530967707C89` FOREIGN KEY (`localidad_id`) REFERENCES `localidad` (`id`),
  ADD CONSTRAINT `FK_38B65309DE12AB56` FOREIGN KEY (`created_by`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_2265B05D57291544` FOREIGN KEY (`perfil_id`) REFERENCES `perfil` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
