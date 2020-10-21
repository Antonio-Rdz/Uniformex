-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-10-2020 a las 02:16:15
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bdventas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_customer_contacts`
--

CREATE TABLE `ufmx_customer_contacts` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `address` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(45) CHARACTER SET utf8 DEFAULT NULL,
  `linkedin` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `facebook` varchar(45) CHARACTER SET utf32 DEFAULT NULL,
  `type_contact` varchar(45) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_cxs_customers`
--

CREATE TABLE `ufmx_cxs_customers` (
  `id` int(11) NOT NULL,
  `alias` varchar(45) DEFAULT NULL,
  `name` varchar(60) DEFAULT NULL,
  `rfc` varchar(45) DEFAULT NULL,
  `r_social` varchar(60) DEFAULT NULL,
  `dom_fiscal` varchar(60) DEFAULT NULL,
  `CFDI` varchar(45) DEFAULT NULL,
  `c_electronico` varchar(45) DEFAULT NULL,
  `phone` varchar(12) DEFAULT NULL,
  `register_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_cxs_customers`
--

INSERT INTO `ufmx_cxs_customers` (`id`, `alias`, `name`, `rfc`, `r_social`, `dom_fiscal`, `CFDI`, `c_electronico`, `phone`, `register_time`, `last_updated`) VALUES
(3, 'dummy@company.com', 'Company Name', '', NULL, NULL, NULL, NULL, '4491203910', '2019-03-11 13:54:24', '2020-02-24 19:44:53'),
(4, 'cliente@empresa.com', 'Cliente Importante', '', NULL, NULL, NULL, NULL, '4491234567', '2020-06-22 18:12:36', '2020-09-25 01:00:48'),
(5, 'Telas@telas.com', 'Telas S.A. de C.V.', '', NULL, NULL, NULL, NULL, NULL, '2020-09-13 20:34:33', '2020-09-13 20:34:44'),
(6, 'prod@prod.com', 'Productos', 'dajsh1233aahdkja', NULL, NULL, NULL, NULL, NULL, '2020-09-23 20:38:00', '2020-09-25 00:55:18'),
(7, 'rfc@rfc.prueba', 'prueba de rfc', 'P4RR4567TE85', NULL, NULL, NULL, NULL, NULL, '2020-09-23 21:27:48', '2020-09-23 21:28:01'),
(8, 'prueba@prueba', 'prueba', '5465a4d654a6d8w', NULL, NULL, NULL, NULL, NULL, '2020-09-25 00:48:02', '2020-09-25 00:48:02'),
(9, 'Vallen-SLP', 'Vallen', '', NULL, NULL, NULL, NULL, NULL, '2020-09-25 01:36:29', '2020-09-25 01:36:29'),
(13, 'jashdkjah', 'jkhsadkjhd', '', NULL, NULL, NULL, NULL, NULL, '2020-10-01 00:52:51', '2020-10-01 00:52:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_cxs_customer_addresses`
--

CREATE TABLE `ufmx_cxs_customer_addresses` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `alias` varchar(45) DEFAULT NULL,
  `street` varchar(45) DEFAULT NULL,
  `int_num` varchar(45) DEFAULT NULL,
  `ext_num` varchar(45) DEFAULT NULL,
  `section` varchar(45) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country` varchar(45) DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL,
  `type_customer` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_cxs_customer_addresses`
--

INSERT INTO `ufmx_cxs_customer_addresses` (`id`, `customer_id`, `alias`, `street`, `int_num`, `ext_num`, `section`, `city_id`, `state_id`, `country`, `zip_code`, `type_customer`) VALUES
(2, 3, 'Principal', 'Avenida siempre viva', '342', '', 'Fraccionamiento bonito', 2800, 4, 'México', '20393', NULL),
(3, 5, 'Telas', 'telares', 's/n', '', 'Telas', 2776, 1, 'México', '201654', NULL),
(4, 6, 'Matriz', 'alfil', '324', '', 'Lomas del ajedrez', 2776, 1, 'México', '20154', NULL),
(5, 6, 'Local A', 'san diego', '120', '', 'Puertecito de la virgen', 2776, 1, 'México', '20784', NULL),
(6, 8, 'Matriz', 'sdakjha', '4654', '', 'kjsadkha', 2776, 1, 'México', '20256', NULL),
(7, 8, 'Local A', 'jahdskjh', '654', '', 'kajsdkja', 2776, 1, 'México', '20125', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_bundles`
--

CREATE TABLE `ufmx_inv_bundles` (
  `id` int(11) NOT NULL,
  `assignment_progress_id` int(11) NOT NULL,
  `pieces` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_bundles_warehouses`
--

CREATE TABLE `ufmx_inv_bundles_warehouses` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_clothes`
--

CREATE TABLE `ufmx_inv_clothes` (
  `id` int(11) NOT NULL,
  `part_number` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `average_cost` float(10,2) NOT NULL,
  `profit_margin` float(10,2) DEFAULT NULL,
  `record_card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_clothes`
--

INSERT INTO `ufmx_inv_clothes` (`id`, `part_number`, `name`, `average_cost`, `profit_margin`, `record_card_id`) VALUES
(1, 'PASM-0239', 'Pantalon de trabajo', 109.00, 5.00, 18),
(2, '', 'Camiseta Polo', 0.00, 5.00, 19);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_clothes_warehouses`
--

CREATE TABLE `ufmx_inv_clothes_warehouses` (
  `id` int(11) NOT NULL,
  `cloth_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_clothes_warehouses`
--

INSERT INTO `ufmx_inv_clothes_warehouses` (`id`, `cloth_id`, `warehouse_id`, `size_id`, `stock`) VALUES
(1, 1, 3, 8, 0),
(3, 1, 3, 9, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_cloth_entries`
--

CREATE TABLE `ufmx_inv_cloth_entries` (
  `id` int(11) NOT NULL,
  `cloth_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `cost` float(10,2) NOT NULL,
  `purchase_order_detail_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_cloth_entries`
--

INSERT INTO `ufmx_inv_cloth_entries` (`id`, `cloth_id`, `warehouse_id`, `user_id`, `supplier_id`, `size_id`, `timestamp`, `quantity`, `cost`, `purchase_order_detail_id`) VALUES
(1, 1, 3, 1, 1, 8, '2020-02-25 19:42:04', 10, 109.00, 7),
(2, 1, 3, 1, 1, 9, '2020-02-25 19:42:04', 10, 109.00, 8),
(3, 1, 3, 1, 1, 8, '2020-02-25 19:48:03', 10, 109.00, 7),
(4, 1, 3, 1, 1, 9, '2020-02-25 19:48:03', 10, 109.00, 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_material_warehouses`
--

CREATE TABLE `ufmx_inv_material_warehouses` (
  `id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `stock` float(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_material_warehouses`
--

INSERT INTO `ufmx_inv_material_warehouses` (`id`, `warehouse_id`, `material_id`, `stock`) VALUES
(1, 3, 2, 0.00),
(2, 3, 1, 90.00),
(4, 3, 5, 500.00),
(5, 3, 3, 500.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_parts`
--

CREATE TABLE `ufmx_inv_parts` (
  `id` int(11) NOT NULL,
  `part_number` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` float(10,2) DEFAULT NULL,
  `average_cost` float(10,2) DEFAULT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_parts`
--

INSERT INTO `ufmx_inv_parts` (`id`, `part_number`, `name`, `description`, `cost`, `average_cost`, `unit_id`) VALUES
(2, 'PRT-002', 'Botón plástico blanco', NULL, NULL, NULL, 1),
(3, 'AV-00123', 'Cierre metálico', NULL, NULL, NULL, 1),
(4, 'BTN304KSL', 'Boton metálico', NULL, NULL, NULL, 1),
(5, 'O2IJR030K', 'Cierre de plástico', NULL, NULL, NULL, 2),
(6, 'SID29EJ0OWKPOS', 'Mezclilla gris', NULL, NULL, NULL, 2),
(7, '', 'cierre prenza', NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_part_entries`
--

CREATE TABLE `ufmx_inv_part_entries` (
  `id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `cost` float(10,2) NOT NULL,
  `purchase_order_detail_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_part_entries`
--

INSERT INTO `ufmx_inv_part_entries` (`id`, `part_id`, `warehouse_id`, `user_id`, `supplier_id`, `timestamp`, `quantity`, `cost`, `purchase_order_detail_id`) VALUES
(1, 2, 3, 12, 1, '2020-02-24 21:46:34', 200, 1.12, 2),
(2, 4, 3, 1, 1, '2020-02-25 19:42:03', 100, 1.20, 6),
(3, 4, 3, 1, 1, '2020-02-25 19:48:03', 100, 1.20, 6),
(4, 7, 3, 4, 773355335, '2020-10-16 23:46:08', 20, 5.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_part_warehouses`
--

CREATE TABLE `ufmx_inv_part_warehouses` (
  `id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_part_warehouses`
--

INSERT INTO `ufmx_inv_part_warehouses` (`id`, `part_id`, `warehouse_id`, `stock`) VALUES
(1, 2, 3, 500),
(2, 4, 3, 500),
(4, 5, 3, 500),
(5, 7, 3, 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_pieces`
--

CREATE TABLE `ufmx_inv_pieces` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_pieces`
--

INSERT INTO `ufmx_inv_pieces` (`id`, `name`) VALUES
(3, 'Bolsa'),
(1, 'Cuello'),
(6, 'Espalda'),
(4, 'Frente'),
(2, 'Manga'),
(5, 'Trasero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_products`
--

CREATE TABLE `ufmx_inv_products` (
  `id` int(11) NOT NULL,
  `model` varchar(60) NOT NULL,
  `description` varchar(75) NOT NULL,
  `front_image` varchar(120) NOT NULL,
  `back_image` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_products`
--

INSERT INTO `ufmx_inv_products` (`id`, `model`, `description`, `front_image`, `back_image`) VALUES
(1, 'P001', 'Camiseta Polo', 'pye7tz44c1e00093.jpg', 'pye7tz2122e90d8d.jpg'),
(2, 'PANT01', 'Pantalon de trabajo', 'pzsf6j9bdc7a9cca.jpg', 'pzsf6j6a6c54ddb2.jpg'),
(3, 'Polo', 'Camisa tipo polo', 'qggk3peebf5a1fa2.jpg', 'qggk3p44204717d7.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_product_pieces`
--

CREATE TABLE `ufmx_inv_product_pieces` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `piece_id` int(11) NOT NULL,
  `quantity` varchar(45) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_product_pieces`
--

INSERT INTO `ufmx_inv_product_pieces` (`id`, `product_id`, `piece_id`, `quantity`) VALUES
(1, 1, 2, '2'),
(2, 1, 1, '1'),
(3, 2, 3, '2'),
(4, 2, 4, '1'),
(5, 2, 5, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_raw_material`
--

CREATE TABLE `ufmx_inv_raw_material` (
  `id` int(11) NOT NULL,
  `part_number` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` float(10,2) NOT NULL,
  `average_cost` float(10,2) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `color` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_raw_material`
--

INSERT INTO `ufmx_inv_raw_material` (`id`, `part_number`, `name`, `description`, `cost`, `average_cost`, `unit_id`, `color`) VALUES
(1, 'PARTMAT-001', 'Boton camisa', '4 orificios', 1.05, 1.05, 1, 'Café'),
(2, 'PARTMAT-002', 'Algodon', '100% puro', 16.54, 15.94, 2, 'Blanco'),
(3, 'PARTMAT-003', 'Algodon', 'Baja calidad', 12.45, 0.00, 2, 'Gris'),
(4, 'PARTMAT-004', 'Velcro', '', 14.54, 14.54, 2, 'Negro (absoluto)'),
(5, 'PARTMAT-005', 'Mezclilla', 'Clásica', 48.55, 48.55, 2, 'Azul cobalto'),
(7, '', 'boton dola', 'boton de camisa', 2.00, 0.00, 1, 'Dorado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_raw_material_entries`
--

CREATE TABLE `ufmx_inv_raw_material_entries` (
  `id` int(11) NOT NULL,
  `raw_material_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `quantity` float(10,2) NOT NULL,
  `cost` float(10,2) NOT NULL,
  `purchase_order_detail_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_raw_material_entries`
--

INSERT INTO `ufmx_inv_raw_material_entries` (`id`, `raw_material_id`, `warehouse_id`, `user_id`, `supplier_id`, `timestamp`, `quantity`, `cost`, `purchase_order_detail_id`) VALUES
(1, 2, 3, 11, 1, '2020-02-24 19:20:20', 50.00, 15.34, NULL),
(2, 1, 3, 11, 1, '2020-02-24 19:28:40', 300.00, 1.05, NULL),
(3, 2, 3, 12, 1, '2020-02-24 21:43:13', 100.00, 15.34, 1),
(4, 2, 3, 1, 1, '2020-02-25 19:42:03', 200.00, 16.54, 5),
(5, 2, 3, 1, 1, '2020-02-25 19:48:03', 200.00, 16.54, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_record_cards`
--

CREATE TABLE `ufmx_inv_record_cards` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `model` varchar(45) NOT NULL,
  `description` varchar(75) NOT NULL,
  `width` float(10,2) DEFAULT NULL,
  `height` float(10,2) DEFAULT NULL,
  `weight` float(10,2) DEFAULT NULL,
  `thread` varchar(45) DEFAULT NULL,
  `laundry` varchar(45) DEFAULT NULL,
  `union` varchar(45) DEFAULT NULL,
  `over_sewing` varchar(45) DEFAULT NULL,
  `additional_notes` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_record_cards`
--

INSERT INTO `ufmx_inv_record_cards` (`id`, `product_id`, `model`, `description`, `width`, `height`, `weight`, `thread`, `laundry`, `union`, `over_sewing`, `additional_notes`) VALUES
(5, 1, 'C137', 'Camiseta Polo', NULL, NULL, NULL, '', '', '', '', NULL),
(18, 2, 'PANTACAS', 'Pantalon de trabajo', NULL, NULL, NULL, '', '', '', '', NULL),
(19, 1, 'CIM', 'Camiseta Polo', NULL, NULL, NULL, '', '', '', '', NULL),
(20, 2, 'CIM2', 'Pantalon de trabajo', NULL, NULL, NULL, '', '', '', '', NULL),
(21, 2, 'M1', 'Pantalon de trabajo', NULL, NULL, NULL, '2', 'un', 'M', 'G', NULL),
(22, 1, 'adfasd', 'Camiseta Polo', NULL, NULL, NULL, 'sada', 'sadas', 'sdasda', 'dasdq', NULL),
(23, 1, '1', 'Camiseta Polo', NULL, NULL, NULL, 'blanco', 'lazaro', '3', '3', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_record_card_components`
--

CREATE TABLE `ufmx_inv_record_card_components` (
  `id` int(11) NOT NULL,
  `record_card_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` float(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_record_card_components`
--

INSERT INTO `ufmx_inv_record_card_components` (`id`, `record_card_id`, `material_id`, `quantity`) VALUES
(1, 5, 2, 2.00),
(2, 18, 2, 3.00),
(3, 19, 3, 2.00),
(4, 20, 5, 2.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_record_card_designs`
--

CREATE TABLE `ufmx_inv_record_card_designs` (
  `id` int(11) NOT NULL,
  `record_card_id` int(11) DEFAULT NULL,
  `image` varchar(80) DEFAULT NULL,
  `type` varchar(65) NOT NULL,
  `location` varchar(140) NOT NULL,
  `color_sequence` varchar(65) DEFAULT NULL,
  `color_code` varchar(45) DEFAULT NULL,
  `stitches` varchar(45) DEFAULT NULL,
  `dimensions` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_record_card_parts`
--

CREATE TABLE `ufmx_inv_record_card_parts` (
  `id` int(11) NOT NULL,
  `record_card_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_record_card_parts`
--

INSERT INTO `ufmx_inv_record_card_parts` (`id`, `record_card_id`, `part_id`, `quantity`) VALUES
(1, 5, 2, 4),
(2, 18, 4, 1),
(3, 19, 2, 3),
(4, 20, 4, 1),
(5, 20, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_record_card_pieces`
--

CREATE TABLE `ufmx_inv_record_card_pieces` (
  `id` int(11) NOT NULL,
  `record_card_id` int(11) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_semi_clothes`
--

CREATE TABLE `ufmx_inv_semi_clothes` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `size` varchar(4) DEFAULT NULL,
  `line_history_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_sizes`
--

CREATE TABLE `ufmx_inv_sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_sizes`
--

INSERT INTO `ufmx_inv_sizes` (`id`, `name`) VALUES
(1, '28'),
(2, '30'),
(3, '31'),
(4, '32'),
(5, '33'),
(6, '34'),
(7, '36'),
(8, '38'),
(9, '40'),
(10, '42'),
(11, '44'),
(12, '46'),
(13, '48'),
(14, '50'),
(15, 'Unitalla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_suppliers`
--

CREATE TABLE `ufmx_inv_suppliers` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `contact_name` varchar(90) DEFAULT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_suppliers`
--

INSERT INTO `ufmx_inv_suppliers` (`id`, `name`, `contact_name`, `phone`, `email`) VALUES
(1, 'PROVEEDOR DE MATERIALES SA', 'Contacto', '4491234568', 'contacto@proveedor.com'),
(773355334, 'Telas S.A. deC.V.', 'Pepe', '4495328565', 'Telas@telas.com'),
(773355335, 'Unif', 'Unif', '4493654516', 'unif@unif.com'),
(773355336, 'Telas', 'Telares', '4498756465', 'Telares@telas.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_transfers`
--

CREATE TABLE `ufmx_inv_transfers` (
  `id` int(11) NOT NULL,
  `assignment_inventory_id` int(11) NOT NULL,
  `quantity` float(10,2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 0,
  `cloth_warehouse_id` int(11) DEFAULT NULL,
  `part_warehouse_id` int(11) DEFAULT NULL,
  `material_warehouse_id` int(11) DEFAULT NULL,
  `quantity_before` float(10,2) NOT NULL,
  `quantity_after` float(10,2) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_timestamp` timestamp NULL DEFAULT NULL,
  `canceled_timestamp` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_inv_transfers`
--

INSERT INTO `ufmx_inv_transfers` (`id`, `assignment_inventory_id`, `quantity`, `status`, `cloth_warehouse_id`, `part_warehouse_id`, `material_warehouse_id`, `quantity_before`, `quantity_after`, `timestamp`, `completed_timestamp`, `canceled_timestamp`) VALUES
(12, 20, 20.00, 0, NULL, 2, NULL, 200.00, 180.00, '2020-03-04 17:48:36', NULL, NULL),
(13, 21, 60.00, 0, NULL, NULL, 1, 450.00, 390.00, '2020-03-04 17:48:36', NULL, NULL),
(14, 22, 30.00, 0, NULL, 2, NULL, 180.00, 150.00, '2020-03-04 17:48:36', NULL, NULL),
(15, 23, 90.00, 0, NULL, NULL, 1, 390.00, 300.00, '2020-03-04 17:48:36', NULL, NULL),
(16, 24, 20.00, 0, NULL, 2, NULL, 150.00, 130.00, '2020-03-04 17:48:36', NULL, NULL),
(17, 25, 60.00, 0, NULL, NULL, 1, 300.00, 240.00, '2020-03-04 17:48:36', NULL, NULL),
(18, 26, 20.00, 0, 1, NULL, NULL, 20.00, 0.00, '2020-03-04 17:48:36', NULL, NULL),
(19, 27, 40.00, 0, NULL, 2, NULL, 130.00, 90.00, '2020-03-04 17:48:36', NULL, NULL),
(20, 28, 120.00, 0, NULL, NULL, 1, 240.00, 120.00, '2020-03-04 17:48:36', NULL, NULL),
(21, 29, 10.00, 0, 3, NULL, NULL, 10.00, 0.00, '2020-03-04 17:48:36', NULL, NULL),
(22, 49, 10.00, 0, NULL, NULL, 2, 100.00, 90.00, '2020-03-04 20:32:45', NULL, NULL),
(23, 50, 20.00, 0, NULL, 2, NULL, 90.00, 70.00, '2020-04-22 17:42:40', NULL, NULL),
(24, 51, 60.00, 0, NULL, NULL, 1, 120.00, 60.00, '2020-04-22 17:42:40', NULL, NULL),
(25, 52, 30.00, 0, NULL, 2, NULL, 70.00, 40.00, '2020-04-22 17:42:40', NULL, NULL),
(26, 53, 60.00, 0, NULL, NULL, 1, 60.00, 0.00, '2020-04-22 17:42:40', NULL, NULL),
(27, 54, 20.00, 0, NULL, 2, NULL, 40.00, 20.00, '2020-04-22 17:42:40', NULL, NULL),
(28, 55, 0.00, 0, NULL, NULL, 1, 0.00, 0.00, '2020-04-22 17:42:40', NULL, NULL),
(29, 56, 20.00, 0, NULL, 2, NULL, 20.00, 0.00, '2020-04-22 17:42:40', NULL, NULL),
(30, 57, 0.00, 0, NULL, NULL, 1, 0.00, 0.00, '2020-04-22 17:42:40', NULL, NULL),
(31, 58, 0.00, 0, NULL, 2, NULL, 0.00, 0.00, '2020-04-22 17:42:40', NULL, NULL),
(32, 59, 0.00, 0, NULL, NULL, 1, 0.00, 0.00, '2020-05-14 18:23:49', NULL, NULL),
(33, 60, 0.00, 0, NULL, 2, NULL, 0.00, 0.00, '2020-04-22 17:42:40', NULL, NULL),
(34, 61, 0.00, 0, NULL, NULL, 1, 0.00, 0.00, '2020-04-22 17:42:40', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_units`
--

CREATE TABLE `ufmx_inv_units` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `short_name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_units`
--

INSERT INTO `ufmx_inv_units` (`id`, `name`, `short_name`) VALUES
(1, 'Pieza', 'pz'),
(2, 'Metro', 'm'),
(3, 'Pulgada', 'plg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_inv_warehouses`
--

CREATE TABLE `ufmx_inv_warehouses` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `street` varchar(60) DEFAULT NULL,
  `number` varchar(5) DEFAULT NULL,
  `section` varchar(60) DEFAULT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zip_code` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_inv_warehouses`
--

INSERT INTO `ufmx_inv_warehouses` (`id`, `name`, `street`, `number`, `section`, `state_id`, `city_id`, `zip_code`) VALUES
(3, 'Matriz', 'Calle', '100', 'Fraccionamiento o colonia', 1, 2776, 20100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_misc_cities`
--

CREATE TABLE `ufmx_misc_cities` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `state_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_misc_cities`
--

INSERT INTO `ufmx_misc_cities` (`id`, `name`, `state_id`) VALUES
(2776, 'Aguascalientes', 1),
(2777, 'Asientos', 1),
(2778, 'Calvillo', 1),
(2779, 'Cosío', 1),
(2780, 'Jesús María', 1),
(2781, 'Pabellón de Arteaga', 1),
(2782, 'Rincón de Romos', 1),
(2783, 'San José de Gracia', 1),
(2784, 'Tepezalá', 1),
(2785, 'El Llano', 1),
(2786, 'San Francisco de los Romo', 1),
(2787, 'Ensenada', 2),
(2788, 'Mexicali', 2),
(2789, 'Tecate', 2),
(2790, 'Tijuana', 2),
(2791, 'Playas de Rosarito', 2),
(2792, 'Comondú', 3),
(2793, 'Mulegé', 3),
(2794, 'La Paz', 3),
(2795, 'Los Cabos', 3),
(2796, 'Loreto', 3),
(2797, 'Calkiní', 4),
(2798, 'Campeche', 4),
(2799, 'Carmen', 4),
(2800, 'Champotón', 4),
(2801, 'Hecelchakán', 4),
(2802, 'Hopelchén', 4),
(2803, 'Palizada', 4),
(2804, 'Tenabo', 4),
(2805, 'Escárcega', 4),
(2806, 'Calakmul', 4),
(2807, 'Candelaria', 4),
(2808, 'Abasolo', 5),
(2809, 'Acuña', 5),
(2810, 'Allende', 5),
(2811, 'Arteaga', 5),
(2812, 'Candela', 5),
(2813, 'Castaños', 5),
(2814, 'Cuatro Ciénegas', 5),
(2815, 'Escobedo', 5),
(2816, 'Francisco I. Madero', 5),
(2817, 'Frontera', 5),
(2818, 'General Cepeda', 5),
(2819, 'Guerrero', 5),
(2820, 'Hidalgo', 5),
(2821, 'Jiménez', 5),
(2822, 'Juárez', 5),
(2823, 'Lamadrid', 5),
(2824, 'Matamoros', 5),
(2825, 'Monclova', 5),
(2826, 'Morelos', 5),
(2827, 'Múzquiz', 5),
(2828, 'Nadadores', 5),
(2829, 'Nava', 5),
(2830, 'Ocampo', 5),
(2831, 'Parras', 5),
(2832, 'Piedras Negras', 5),
(2833, 'Progreso', 5),
(2834, 'Ramos Arizpe', 5),
(2835, 'Sabinas', 5),
(2836, 'Sacramento', 5),
(2837, 'Saltillo', 5),
(2838, 'San Buenaventura', 5),
(2839, 'San Juan de Sabinas', 5),
(2840, 'San Pedro', 5),
(2841, 'Sierra Mojada', 5),
(2842, 'Torreón', 5),
(2843, 'Viesca', 5),
(2844, 'Villa Unión', 5),
(2845, 'Zaragoza', 5),
(2846, 'Armería', 6),
(2847, 'Colima', 6),
(2848, 'Comala', 6),
(2849, 'Coquimatlán', 6),
(2850, 'Cuauhtémoc', 6),
(2851, 'Ixtlahuacán', 6),
(2852, 'Manzanillo', 6),
(2853, 'Minatitlán', 6),
(2854, 'Tecomán', 6),
(2855, 'Villa de Álvarez', 6),
(2856, 'Acacoyagua', 7),
(2857, 'Acala', 7),
(2858, 'Acapetahua', 7),
(2859, 'Altamirano', 7),
(2860, 'Amatán', 7),
(2861, 'Amatenango de la Frontera', 7),
(2862, 'Amatenango del Valle', 7),
(2863, 'Angel Albino Corzo', 7),
(2864, 'Arriaga', 7),
(2865, 'Bejucal de Ocampo', 7),
(2866, 'Bella Vista', 7),
(2867, 'Berriozábal', 7),
(2868, 'Bochil', 7),
(2869, 'El Bosque', 7),
(2870, 'Cacahoatán', 7),
(2871, 'Catazajá', 7),
(2872, 'Cintalapa', 7),
(2873, 'Coapilla', 7),
(2874, 'Comitán de Domínguez', 7),
(2875, 'La Concordia', 7),
(2876, 'Copainalá', 7),
(2877, 'Chalchihuitán', 7),
(2878, 'Chamula', 7),
(2879, 'Chanal', 7),
(2880, 'Chapultenango', 7),
(2881, 'Chenalhó', 7),
(2882, 'Chiapa de Corzo', 7),
(2883, 'Chiapilla', 7),
(2884, 'Chicoasén', 7),
(2885, 'Chicomuselo', 7),
(2886, 'Chilón', 7),
(2887, 'Escuintla', 7),
(2888, 'Francisco León', 7),
(2889, 'Frontera Comalapa', 7),
(2890, 'Frontera Hidalgo', 7),
(2891, 'La Grandeza', 7),
(2892, 'Huehuetán', 7),
(2893, 'Huixtán', 7),
(2894, 'Huitiupán', 7),
(2895, 'Huixtla', 7),
(2896, 'La Independencia', 7),
(2897, 'Ixhuatán', 7),
(2898, 'Ixtacomitán', 7),
(2899, 'Ixtapa', 7),
(2900, 'Ixtapangajoya', 7),
(2901, 'Jiquipilas', 7),
(2902, 'Jitotol', 7),
(2903, 'Juárez', 7),
(2904, 'Larráinzar', 7),
(2905, 'La Libertad', 7),
(2906, 'Mapastepec', 7),
(2907, 'Las Margaritas', 7),
(2908, 'Mazapa de Madero', 7),
(2909, 'Mazatán', 7),
(2910, 'Metapa', 7),
(2911, 'Mitontic', 7),
(2912, 'Motozintla', 7),
(2913, 'Nicolás Ruíz', 7),
(2914, 'Ocosingo', 7),
(2915, 'Ocotepec', 7),
(2916, 'Ocozocoautla de Espinosa', 7),
(2917, 'Ostuacán', 7),
(2918, 'Osumacinta', 7),
(2919, 'Oxchuc', 7),
(2920, 'Palenque', 7),
(2921, 'Pantelhó', 7),
(2922, 'Pantepec', 7),
(2923, 'Pichucalco', 7),
(2924, 'Pijijiapan', 7),
(2925, 'El Porvenir', 7),
(2926, 'Villa Comaltitlán', 7),
(2927, 'Pueblo Nuevo Solistahuacán', 7),
(2928, 'Rayón', 7),
(2929, 'Reforma', 7),
(2930, 'Las Rosas', 7),
(2931, 'Sabanilla', 7),
(2932, 'Salto de Agua', 7),
(2933, 'San Cristóbal de las Casas', 7),
(2934, 'San Fernando', 7),
(2935, 'Siltepec', 7),
(2936, 'Simojovel', 7),
(2937, 'Sitalá', 7),
(2938, 'Socoltenango', 7),
(2939, 'Solosuchiapa', 7),
(2940, 'Soyaló', 7),
(2941, 'Suchiapa', 7),
(2942, 'Suchiate', 7),
(2943, 'Sunuapa', 7),
(2944, 'Tapachula', 7),
(2945, 'Tapalapa', 7),
(2946, 'Tapilula', 7),
(2947, 'Tecpatán', 7),
(2948, 'Tenejapa', 7),
(2949, 'Teopisca', 7),
(2950, 'Tila', 7),
(2951, 'Tonalá', 7),
(2952, 'Totolapa', 7),
(2953, 'La Trinitaria', 7),
(2954, 'Tumbalá', 7),
(2955, 'Tuxtla Gutiérrez', 7),
(2956, 'Tuxtla Chico', 7),
(2957, 'Tuzantán', 7),
(2958, 'Tzimol', 7),
(2959, 'Unión Juárez', 7),
(2960, 'Venustiano Carranza', 7),
(2961, 'Villa Corzo', 7),
(2962, 'Villaflores', 7),
(2963, 'Yajalón', 7),
(2964, 'San Lucas', 7),
(2965, 'Zinacantán', 7),
(2966, 'San Juan Cancuc', 7),
(2967, 'Aldama', 7),
(2968, 'Benemérito de las Américas', 7),
(2969, 'Maravilla Tenejapa', 7),
(2970, 'Marqués de Comillas', 7),
(2971, 'Montecristo de Guerrero', 7),
(2972, 'San Andrés Duraznal', 7),
(2973, 'Santiago el Pinar', 7),
(2974, 'Ahumada', 8),
(2975, 'Aldama', 8),
(2976, 'Allende', 8),
(2977, 'Aquiles Serdán', 8),
(2978, 'Ascensión', 8),
(2979, 'Bachíniva', 8),
(2980, 'Balleza', 8),
(2981, 'Batopilas', 8),
(2982, 'Bocoyna', 8),
(2983, 'Buenaventura', 8),
(2984, 'Camargo', 8),
(2985, 'Carichí', 8),
(2986, 'Casas Grandes', 8),
(2987, 'Coronado', 8),
(2988, 'Coyame del Sotol', 8),
(2989, 'La Cruz', 8),
(2990, 'Cuauhtémoc', 8),
(2991, 'Cusihuiriachi', 8),
(2992, 'Chihuahua', 8),
(2993, 'Chínipas', 8),
(2994, 'Delicias', 8),
(2995, 'Dr. Belisario Domínguez', 8),
(2996, 'Galeana', 8),
(2997, 'Santa Isabel', 8),
(2998, 'Gómez Farías', 8),
(2999, 'Gran Morelos', 8),
(3000, 'Guachochi', 8),
(3001, 'Guadalupe', 8),
(3002, 'Guadalupe y Calvo', 8),
(3003, 'Guazapares', 8),
(3004, 'Guerrero', 8),
(3005, 'Hidalgo del Parral', 8),
(3006, 'Huejotitán', 8),
(3007, 'Ignacio Zaragoza', 8),
(3008, 'Janos', 8),
(3009, 'Jiménez', 8),
(3010, 'Juárez', 8),
(3011, 'Julimes', 8),
(3012, 'López', 8),
(3013, 'Madera', 8),
(3014, 'Maguarichi', 8),
(3015, 'Manuel Benavides', 8),
(3016, 'Matachí', 8),
(3017, 'Matamoros', 8),
(3018, 'Meoqui', 8),
(3019, 'Morelos', 8),
(3020, 'Moris', 8),
(3021, 'Namiquipa', 8),
(3022, 'Nonoava', 8),
(3023, 'Nuevo Casas Grandes', 8),
(3024, 'Ocampo', 8),
(3025, 'Ojinaga', 8),
(3026, 'Praxedis G. Guerrero', 8),
(3027, 'Riva Palacio', 8),
(3028, 'Rosales', 8),
(3029, 'Rosario', 8),
(3030, 'San Francisco de Borja', 8),
(3031, 'San Francisco de Conchos', 8),
(3032, 'San Francisco del Oro', 8),
(3033, 'Santa Bárbara', 8),
(3034, 'Satevó', 8),
(3035, 'Saucillo', 8),
(3036, 'Temósachic', 8),
(3037, 'El Tule', 8),
(3038, 'Urique', 8),
(3039, 'Uruachi', 8),
(3040, 'Valle de Zaragoza', 8),
(3041, 'Azcapotzalco', 9),
(3042, 'Coyoacán', 9),
(3043, 'Cuajimalpa de Morelos', 9),
(3044, 'Gustavo A. Madero', 9),
(3045, 'Iztacalco', 9),
(3046, 'Iztapalapa', 9),
(3047, 'La Magdalena Contreras', 9),
(3048, 'Milpa Alta', 9),
(3049, 'Álvaro Obregón', 9),
(3050, 'Tláhuac', 9),
(3051, 'Tlalpan', 9),
(3052, 'Xochimilco', 9),
(3053, 'Benito Juárez', 9),
(3054, 'Cuauhtémoc', 9),
(3055, 'Miguel Hidalgo', 9),
(3056, 'Venustiano Carranza', 9),
(3057, 'Canatlán', 10),
(3058, 'Canelas', 10),
(3059, 'Coneto de Comonfort', 10),
(3060, 'Cuencamé', 10),
(3061, 'Durango', 10),
(3062, 'General Simón Bolívar', 10),
(3063, 'Gómez Palacio', 10),
(3064, 'Guadalupe Victoria', 10),
(3065, 'Guanaceví', 10),
(3066, 'Hidalgo', 10),
(3067, 'Indé', 10),
(3068, 'Lerdo', 10),
(3069, 'Mapimí', 10),
(3070, 'Mezquital', 10),
(3071, 'Nazas', 10),
(3072, 'Nombre de Dios', 10),
(3073, 'Ocampo', 10),
(3074, 'El Oro', 10),
(3075, 'Otáez', 10),
(3076, 'Pánuco de Coronado', 10),
(3077, 'Peñón Blanco', 10),
(3078, 'Poanas', 10),
(3079, 'Pueblo Nuevo', 10),
(3080, 'Rodeo', 10),
(3081, 'San Bernardo', 10),
(3082, 'San Dimas', 10),
(3083, 'San Juan de Guadalupe', 10),
(3084, 'San Juan del Río', 10),
(3085, 'San Luis del Cordero', 10),
(3086, 'San Pedro del Gallo', 10),
(3087, 'Santa Clara', 10),
(3088, 'Santiago Papasquiaro', 10),
(3089, 'Súchil', 10),
(3090, 'Tamazula', 10),
(3091, 'Tepehuanes', 10),
(3092, 'Tlahualilo', 10),
(3093, 'Topia', 10),
(3094, 'Vicente Guerrero', 10),
(3095, 'Nuevo Ideal', 10),
(3096, 'Abasolo', 11),
(3097, 'Acámbaro', 11),
(3098, 'San Miguel de Allende', 11),
(3099, 'Apaseo el Alto', 11),
(3100, 'Apaseo el Grande', 11),
(3101, 'Atarjea', 11),
(3102, 'Celaya', 11),
(3103, 'Manuel Doblado', 11),
(3104, 'Comonfort', 11),
(3105, 'Coroneo', 11),
(3106, 'Cortazar', 11),
(3107, 'Cuerámaro', 11),
(3108, 'Doctor Mora', 11),
(3109, 'Dolores Hidalgo', 11),
(3110, 'Guanajuato', 11),
(3111, 'Huanímaro', 11),
(3112, 'Irapuato', 11),
(3113, 'Jaral del Progreso', 11),
(3114, 'Jerécuaro', 11),
(3115, 'León', 11),
(3116, 'Moroleón', 11),
(3117, 'Ocampo', 11),
(3118, 'Pénjamo', 11),
(3119, 'Pueblo Nuevo', 11),
(3120, 'Purísima del Rincón', 11),
(3121, 'Romita', 11),
(3122, 'Salamanca', 11),
(3123, 'Salvatierra', 11),
(3124, 'San Diego de la Unión', 11),
(3125, 'San Felipe', 11),
(3126, 'San Francisco del Rincón', 11),
(3127, 'San José Iturbide', 11),
(3128, 'San Luis de la Paz', 11),
(3129, 'Santa Catarina', 11),
(3130, 'Santa Cruz de Juventino Rosas', 11),
(3131, 'Santiago Maravatío', 11),
(3132, 'Silao de la Victoria', 11),
(3133, 'Tarandacuao', 11),
(3134, 'Tarimoro', 11),
(3135, 'Tierra Blanca', 11),
(3136, 'Uriangato', 11),
(3137, 'Valle de Santiago', 11),
(3138, 'Victoria', 11),
(3139, 'Villagrán', 11),
(3140, 'Xichú', 11),
(3141, 'Yuriria', 11),
(3142, 'Acapulco de Juárez', 12),
(3143, 'Ahuacuotzingo', 12),
(3144, 'Ajuchitlán del Progreso', 12),
(3145, 'Alcozauca de Guerrero', 12),
(3146, 'Alpoyeca', 12),
(3147, 'Apaxtla', 12),
(3148, 'Arcelia', 12),
(3149, 'Atenango del Río', 12),
(3150, 'Atlamajalcingo del Monte', 12),
(3151, 'Atlixtac', 12),
(3152, 'Atoyac de Álvarez', 12),
(3153, 'Ayutla de los Libres', 12),
(3154, 'Azoyú', 12),
(3155, 'Benito Juárez', 12),
(3156, 'Buenavista de Cuéllar', 12),
(3157, 'Coahuayutla de José María Izazaga', 12),
(3158, 'Cocula', 12),
(3159, 'Copala', 12),
(3160, 'Copalillo', 12),
(3161, 'Copanatoyac', 12),
(3162, 'Coyuca de Benítez', 12),
(3163, 'Coyuca de Catalán', 12),
(3164, 'Cuajinicuilapa', 12),
(3165, 'Cualác', 12),
(3166, 'Cuautepec', 12),
(3167, 'Cuetzala del Progreso', 12),
(3168, 'Cutzamala de Pinzón', 12),
(3169, 'Chilapa de Álvarez', 12),
(3170, 'Chilpancingo de los Bravo', 12),
(3171, 'Florencio Villarreal', 12),
(3172, 'General Canuto A. Neri', 12),
(3173, 'General Heliodoro Castillo', 12),
(3174, 'Huamuxtitlán', 12),
(3175, 'Huitzuco de los Figueroa', 12),
(3176, 'Iguala de la Independencia', 12),
(3177, 'Igualapa', 12),
(3178, 'Ixcateopan de Cuauhtémoc', 12),
(3179, 'Zihuatanejo de Azueta', 12),
(3180, 'Juan R. Escudero', 12),
(3181, 'Leonardo Bravo', 12),
(3182, 'Malinaltepec', 12),
(3183, 'Mártir de Cuilapan', 12),
(3184, 'Metlatónoc', 12),
(3185, 'Mochitlán', 12),
(3186, 'Olinalá', 12),
(3187, 'Ometepec', 12),
(3188, 'Pedro Ascencio Alquisiras', 12),
(3189, 'Petatlán', 12),
(3190, 'Pilcaya', 12),
(3191, 'Pungarabato', 12),
(3192, 'Quechultenango', 12),
(3193, 'San Luis Acatlán', 12),
(3194, 'San Marcos', 12),
(3195, 'San Miguel Totolapan', 12),
(3196, 'Taxco de Alarcón', 12),
(3197, 'Tecoanapa', 12),
(3198, 'Técpan de Galeana', 12),
(3199, 'Teloloapan', 12),
(3200, 'Tepecoacuilco de Trujano', 12),
(3201, 'Tetipac', 12),
(3202, 'Tixtla de Guerrero', 12),
(3203, 'Tlacoachistlahuaca', 12),
(3204, 'Tlacoapa', 12),
(3205, 'Tlalchapa', 12),
(3206, 'Tlalixtaquilla de Maldonado', 12),
(3207, 'Tlapa de Comonfort', 12),
(3208, 'Tlapehuala', 12),
(3209, 'La Unión de Isidoro Montes de Oca', 12),
(3210, 'Xalpatláhuac', 12),
(3211, 'Xochihuehuetlán', 12),
(3212, 'Xochistlahuaca', 12),
(3213, 'Zapotitlán Tablas', 12),
(3214, 'Zirándaro', 12),
(3215, 'Zitlala', 12),
(3216, 'Eduardo Neri', 12),
(3217, 'Acatepec', 12),
(3218, 'Marquelia', 12),
(3219, 'Cochoapa el Grande', 12),
(3220, 'José Joaquín de Herrera', 12),
(3221, 'Juchitán', 12),
(3222, 'Iliatenco', 12),
(3223, 'Acatlán', 13),
(3224, 'Acaxochitlán', 13),
(3225, 'Actopan', 13),
(3226, 'Agua Blanca de Iturbide', 13),
(3227, 'Ajacuba', 13),
(3228, 'Alfajayucan', 13),
(3229, 'Almoloya', 13),
(3230, 'Apan', 13),
(3231, 'El Arenal', 13),
(3232, 'Atitalaquia', 13),
(3233, 'Atlapexco', 13),
(3234, 'Atotonilco el Grande', 13),
(3235, 'Atotonilco de Tula', 13),
(3236, 'Calnali', 13),
(3237, 'Cardonal', 13),
(3238, 'Cuautepec de Hinojosa', 13),
(3239, 'Chapantongo', 13),
(3240, 'Chapulhuacán', 13),
(3241, 'Chilcuautla', 13),
(3242, 'Eloxochitlán', 13),
(3243, 'Emiliano Zapata', 13),
(3244, 'Epazoyucan', 13),
(3245, 'Francisco I. Madero', 13),
(3246, 'Huasca de Ocampo', 13),
(3247, 'Huautla', 13),
(3248, 'Huazalingo', 13),
(3249, 'Huehuetla', 13),
(3250, 'Huejutla de Reyes', 13),
(3251, 'Huichapan', 13),
(3252, 'Ixmiquilpan', 13),
(3253, 'Jacala de Ledezma', 13),
(3254, 'Jaltocán', 13),
(3255, 'Juárez Hidalgo', 13),
(3256, 'Lolotla', 13),
(3257, 'Metepec', 13),
(3258, 'San Agustín Metzquititlán', 13),
(3259, 'Metztitlán', 13),
(3260, 'Mineral del Chico', 13),
(3261, 'Mineral del Monte', 13),
(3262, 'La Misión', 13),
(3263, 'Mixquiahuala de Juárez', 13),
(3264, 'Molango de Escamilla', 13),
(3265, 'Nicolás Flores', 13),
(3266, 'Nopala de Villagrán', 13),
(3267, 'Omitlán de Juárez', 13),
(3268, 'San Felipe Orizatlán', 13),
(3269, 'Pacula', 13),
(3270, 'Pachuca de Soto', 13),
(3271, 'Pisaflores', 13),
(3272, 'Progreso de Obregón', 13),
(3273, 'Mineral de la Reforma', 13),
(3274, 'San Agustín Tlaxiaca', 13),
(3275, 'San Bartolo Tutotepec', 13),
(3276, 'San Salvador', 13),
(3277, 'Santiago de Anaya', 13),
(3278, 'Santiago Tulantepec de Lugo Guerrero', 13),
(3279, 'Singuilucan', 13),
(3280, 'Tasquillo', 13),
(3281, 'Tecozautla', 13),
(3282, 'Tenango de Doria', 13),
(3283, 'Tepeapulco', 13),
(3284, 'Tepehuacán de Guerrero', 13),
(3285, 'Tepeji del Río de Ocampo', 13),
(3286, 'Tepetitlán', 13),
(3287, 'Tetepango', 13),
(3288, 'Villa de Tezontepec', 13),
(3289, 'Tezontepec de Aldama', 13),
(3290, 'Tianguistengo', 13),
(3291, 'Tizayuca', 13),
(3292, 'Tlahuelilpan', 13),
(3293, 'Tlahuiltepa', 13),
(3294, 'Tlanalapa', 13),
(3295, 'Tlanchinol', 13),
(3296, 'Tlaxcoapan', 13),
(3297, 'Tolcayuca', 13),
(3298, 'Tula de Allende', 13),
(3299, 'Tulancingo de Bravo', 13),
(3300, 'Xochiatipan', 13),
(3301, 'Xochicoatlán', 13),
(3302, 'Yahualica', 13),
(3303, 'Zacualtipán de Ángeles', 13),
(3304, 'Zapotlán de Juárez', 13),
(3305, 'Zempoala', 13),
(3306, 'Zimapán', 13),
(3307, 'Acatic', 14),
(3308, 'Acatlán de Juárez', 14),
(3309, 'Ahualulco de Mercado', 14),
(3310, 'Amacueca', 14),
(3311, 'Amatitán', 14),
(3312, 'Ameca', 14),
(3313, 'San Juanito de Escobedo', 14),
(3314, 'Arandas', 14),
(3315, 'El Arenal', 14),
(3316, 'Atemajac de Brizuela', 14),
(3317, 'Atengo', 14),
(3318, 'Atenguillo', 14),
(3319, 'Atotonilco el Alto', 14),
(3320, 'Atoyac', 14),
(3321, 'Autlán de Navarro', 14),
(3322, 'Ayotlán', 14),
(3323, 'Ayutla', 14),
(3324, 'La Barca', 14),
(3325, 'Bolaños', 14),
(3326, 'Cabo Corrientes', 14),
(3327, 'Casimiro Castillo', 14),
(3328, 'Cihuatlán', 14),
(3329, 'Zapotlán el Grande', 14),
(3330, 'Cocula', 14),
(3331, 'Colotlán', 14),
(3332, 'Concepción de Buenos Aires', 14),
(3333, 'Cuautitlán de García Barragán', 14),
(3334, 'Cuautla', 14),
(3335, 'Cuquío', 14),
(3336, 'Chapala', 14),
(3337, 'Chimaltitán', 14),
(3338, 'Chiquilistlán', 14),
(3339, 'Degollado', 14),
(3340, 'Ejutla', 14),
(3341, 'Encarnación de Díaz', 14),
(3342, 'Etzatlán', 14),
(3343, 'El Grullo', 14),
(3344, 'Guachinango', 14),
(3345, 'Guadalajara', 14),
(3346, 'Hostotipaquillo', 14),
(3347, 'Huejúcar', 14),
(3348, 'Huejuquilla el Alto', 14),
(3349, 'La Huerta', 14),
(3350, 'Ixtlahuacán de los Membrillos', 14),
(3351, 'Ixtlahuacán del Río', 14),
(3352, 'Jalostotitlán', 14),
(3353, 'Jamay', 14),
(3354, 'Jesús María', 14),
(3355, 'Jilotlán de los Dolores', 14),
(3356, 'Jocotepec', 14),
(3357, 'Juanacatlán', 14),
(3358, 'Juchitlán', 14),
(3359, 'Lagos de Moreno', 14),
(3360, 'El Limón', 14),
(3361, 'Magdalena', 14),
(3362, 'Santa María del Oro', 14),
(3363, 'La Manzanilla de la Paz', 14),
(3364, 'Mascota', 14),
(3365, 'Mazamitla', 14),
(3366, 'Mexticacán', 14),
(3367, 'Mezquitic', 14),
(3368, 'Mixtlán', 14),
(3369, 'Ocotlán', 14),
(3370, 'Ojuelos de Jalisco', 14),
(3371, 'Pihuamo', 14),
(3372, 'Poncitlán', 14),
(3373, 'Puerto Vallarta', 14),
(3374, 'Villa Purificación', 14),
(3375, 'Quitupan', 14),
(3376, 'El Salto', 14),
(3377, 'San Cristóbal de la Barranca', 14),
(3378, 'San Diego de Alejandría', 14),
(3379, 'San Juan de los Lagos', 14),
(3380, 'San Julián', 14),
(3381, 'San Marcos', 14),
(3382, 'San Martín de Bolaños', 14),
(3383, 'San Martín Hidalgo', 14),
(3384, 'San Miguel el Alto', 14),
(3385, 'Gómez Farías', 14),
(3386, 'San Sebastián del Oeste', 14),
(3387, 'Santa María de los Ángeles', 14),
(3388, 'Sayula', 14),
(3389, 'Tala', 14),
(3390, 'Talpa de Allende', 14),
(3391, 'Tamazula de Gordiano', 14),
(3392, 'Tapalpa', 14),
(3393, 'Tecalitlán', 14),
(3394, 'Tecolotlán', 14),
(3395, 'Techaluta de Montenegro', 14),
(3396, 'Tenamaxtlán', 14),
(3397, 'Teocaltiche', 14),
(3398, 'Teocuitatlán de Corona', 14),
(3399, 'Tepatitlán de Morelos', 14),
(3400, 'Tequila', 14),
(3401, 'Teuchitlán', 14),
(3402, 'Tizapán el Alto', 14),
(3403, 'Tlajomulco de Zúñiga', 14),
(3404, 'San Pedro Tlaquepaque', 14),
(3405, 'Tolimán', 14),
(3406, 'Tomatlán', 14),
(3407, 'Tonalá', 14),
(3408, 'Tonaya', 14),
(3409, 'Tonila', 14),
(3410, 'Totatiche', 14),
(3411, 'Tototlán', 14),
(3412, 'Tuxcacuesco', 14),
(3413, 'Tuxcueca', 14),
(3414, 'Tuxpan', 14),
(3415, 'Unión de San Antonio', 14),
(3416, 'Unión de Tula', 14),
(3417, 'Valle de Guadalupe', 14),
(3418, 'Valle de Juárez', 14),
(3419, 'San Gabriel', 14),
(3420, 'Villa Corona', 14),
(3421, 'Villa Guerrero', 14),
(3422, 'Villa Hidalgo', 14),
(3423, 'Cañadas de Obregón', 14),
(3424, 'Yahualica de González Gallo', 14),
(3425, 'Zacoalco de Torres', 14),
(3426, 'Zapopan', 14),
(3427, 'Zapotiltic', 14),
(3428, 'Zapotitlán de Vadillo', 14),
(3429, 'Zapotlán del Rey', 14),
(3430, 'Zapotlanejo', 14),
(3431, 'San Ignacio Cerro Gordo', 14),
(3432, 'Acambay de Ruíz Castañeda', 15),
(3433, 'Acolman', 15),
(3434, 'Aculco', 15),
(3435, 'Almoloya de Alquisiras', 15),
(3436, 'Almoloya de Juárez', 15),
(3437, 'Almoloya del Río', 15),
(3438, 'Amanalco', 15),
(3439, 'Amatepec', 15),
(3440, 'Amecameca', 15),
(3441, 'Apaxco', 15),
(3442, 'Atenco', 15),
(3443, 'Atizapán', 15),
(3444, 'Atizapán de Zaragoza', 15),
(3445, 'Atlacomulco', 15),
(3446, 'Atlautla', 15),
(3447, 'Axapusco', 15),
(3448, 'Ayapango', 15),
(3449, 'Calimaya', 15),
(3450, 'Capulhuac', 15),
(3451, 'Coacalco de Berriozábal', 15),
(3452, 'Coatepec Harinas', 15),
(3453, 'Cocotitlán', 15),
(3454, 'Coyotepec', 15),
(3455, 'Cuautitlán', 15),
(3456, 'Chalco', 15),
(3457, 'Chapa de Mota', 15),
(3458, 'Chapultepec', 15),
(3459, 'Chiautla', 15),
(3460, 'Chicoloapan', 15),
(3461, 'Chiconcuac', 15),
(3462, 'Chimalhuacán', 15),
(3463, 'Donato Guerra', 15),
(3464, 'Ecatepec de Morelos', 15),
(3465, 'Ecatzingo', 15),
(3466, 'Huehuetoca', 15),
(3467, 'Hueypoxtla', 15),
(3468, 'Huixquilucan', 15),
(3469, 'Isidro Fabela', 15),
(3470, 'Ixtapaluca', 15),
(3471, 'Ixtapan de la Sal', 15),
(3472, 'Ixtapan del Oro', 15),
(3473, 'Ixtlahuaca', 15),
(3474, 'Xalatlaco', 15),
(3475, 'Jaltenco', 15),
(3476, 'Jilotepec', 15),
(3477, 'Jilotzingo', 15),
(3478, 'Jiquipilco', 15),
(3479, 'Jocotitlán', 15),
(3480, 'Joquicingo', 15),
(3481, 'Juchitepec', 15),
(3482, 'Lerma', 15),
(3483, 'Malinalco', 15),
(3484, 'Melchor Ocampo', 15),
(3485, 'Metepec', 15),
(3486, 'Mexicaltzingo', 15),
(3487, 'Morelos', 15),
(3488, 'Naucalpan de Juárez', 15),
(3489, 'Nezahualcóyotl', 15),
(3490, 'Nextlalpan', 15),
(3491, 'Nicolás Romero', 15),
(3492, 'Nopaltepec', 15),
(3493, 'Ocoyoacac', 15),
(3494, 'Ocuilan', 15),
(3495, 'El Oro', 15),
(3496, 'Otumba', 15),
(3497, 'Otzoloapan', 15),
(3498, 'Otzolotepec', 15),
(3499, 'Ozumba', 15),
(3500, 'Papalotla', 15),
(3501, 'La Paz', 15),
(3502, 'Polotitlán', 15),
(3503, 'Rayón', 15),
(3504, 'San Antonio la Isla', 15),
(3505, 'San Felipe del Progreso', 15),
(3506, 'San Martín de las Pirámides', 15),
(3507, 'San Mateo Atenco', 15),
(3508, 'San Simón de Guerrero', 15),
(3509, 'Santo Tomás', 15),
(3510, 'Soyaniquilpan de Juárez', 15),
(3511, 'Sultepec', 15),
(3512, 'Tecámac', 15),
(3513, 'Tejupilco', 15),
(3514, 'Temamatla', 15),
(3515, 'Temascalapa', 15),
(3516, 'Temascalcingo', 15),
(3517, 'Temascaltepec', 15),
(3518, 'Temoaya', 15),
(3519, 'Tenancingo', 15),
(3520, 'Tenango del Aire', 15),
(3521, 'Tenango del Valle', 15),
(3522, 'Teoloyucan', 15),
(3523, 'Teotihuacán', 15),
(3524, 'Tepetlaoxtoc', 15),
(3525, 'Tepetlixpa', 15),
(3526, 'Tepotzotlán', 15),
(3527, 'Tequixquiac', 15),
(3528, 'Texcaltitlán', 15),
(3529, 'Texcalyacac', 15),
(3530, 'Texcoco', 15),
(3531, 'Tezoyuca', 15),
(3532, 'Tianguistenco', 15),
(3533, 'Timilpan', 15),
(3534, 'Tlalmanalco', 15),
(3535, 'Tlalnepantla de Baz', 15),
(3536, 'Tlatlaya', 15),
(3537, 'Toluca', 15),
(3538, 'Tonatico', 15),
(3539, 'Tultepec', 15),
(3540, 'Tultitlán', 15),
(3541, 'Valle de Bravo', 15),
(3542, 'Villa de Allende', 15),
(3543, 'Villa del Carbón', 15),
(3544, 'Villa Guerrero', 15),
(3545, 'Villa Victoria', 15),
(3546, 'Xonacatlán', 15),
(3547, 'Zacazonapan', 15),
(3548, 'Zacualpan', 15),
(3549, 'Zinacantepec', 15),
(3550, 'Zumpahuacán', 15),
(3551, 'Zumpango', 15),
(3552, 'Cuautitlán Izcalli', 15),
(3553, 'Valle de Chalco Solidaridad', 15),
(3554, 'Luvianos', 15),
(3555, 'San José del Rincón', 15),
(3556, 'Tonanitla', 15),
(3557, 'Acuitzio', 16),
(3558, 'Aguililla', 16),
(3559, 'Álvaro Obregón', 16),
(3560, 'Angamacutiro', 16),
(3561, 'Angangueo', 16),
(3562, 'Apatzingán', 16),
(3563, 'Aporo', 16),
(3564, 'Aquila', 16),
(3565, 'Ario', 16),
(3566, 'Arteaga', 16),
(3567, 'Briseñas', 16),
(3568, 'Buenavista', 16),
(3569, 'Carácuaro', 16),
(3570, 'Coahuayana', 16),
(3571, 'Coalcomán de Vázquez Pallares', 16),
(3572, 'Coeneo', 16),
(3573, 'Contepec', 16),
(3574, 'Copándaro', 16),
(3575, 'Cotija', 16),
(3576, 'Cuitzeo', 16),
(3577, 'Charapan', 16),
(3578, 'Charo', 16),
(3579, 'Chavinda', 16),
(3580, 'Cherán', 16),
(3581, 'Chilchota', 16),
(3582, 'Chinicuila', 16),
(3583, 'Chucándiro', 16),
(3584, 'Churintzio', 16),
(3585, 'Churumuco', 16),
(3586, 'Ecuandureo', 16),
(3587, 'Epitacio Huerta', 16),
(3588, 'Erongarícuaro', 16),
(3589, 'Gabriel Zamora', 16),
(3590, 'Hidalgo', 16),
(3591, 'La Huacana', 16),
(3592, 'Huandacareo', 16),
(3593, 'Huaniqueo', 16),
(3594, 'Huetamo', 16),
(3595, 'Huiramba', 16),
(3596, 'Indaparapeo', 16),
(3597, 'Irimbo', 16),
(3598, 'Ixtlán', 16),
(3599, 'Jacona', 16),
(3600, 'Jiménez', 16),
(3601, 'Jiquilpan', 16),
(3602, 'Juárez', 16),
(3603, 'Jungapeo', 16),
(3604, 'Lagunillas', 16),
(3605, 'Madero', 16),
(3606, 'Maravatío', 16),
(3607, 'Marcos Castellanos', 16),
(3608, 'Lázaro Cárdenas', 16),
(3609, 'Morelia', 16),
(3610, 'Morelos', 16),
(3611, 'Múgica', 16),
(3612, 'Nahuatzen', 16),
(3613, 'Nocupétaro', 16),
(3614, 'Nuevo Parangaricutiro', 16),
(3615, 'Nuevo Urecho', 16),
(3616, 'Numarán', 16),
(3617, 'Ocampo', 16),
(3618, 'Pajacuarán', 16),
(3619, 'Panindícuaro', 16),
(3620, 'Parácuaro', 16),
(3621, 'Paracho', 16),
(3622, 'Pátzcuaro', 16),
(3623, 'Penjamillo', 16),
(3624, 'Peribán', 16),
(3625, 'La Piedad', 16),
(3626, 'Purépero', 16),
(3627, 'Puruándiro', 16),
(3628, 'Queréndaro', 16),
(3629, 'Quiroga', 16),
(3630, 'Cojumatlán de Régules', 16),
(3631, 'Los Reyes', 16),
(3632, 'Sahuayo', 16),
(3633, 'San Lucas', 16),
(3634, 'Santa Ana Maya', 16),
(3635, 'Salvador Escalante', 16),
(3636, 'Senguio', 16),
(3637, 'Susupuato', 16),
(3638, 'Tacámbaro', 16),
(3639, 'Tancítaro', 16),
(3640, 'Tangamandapio', 16),
(3641, 'Tangancícuaro', 16),
(3642, 'Tanhuato', 16),
(3643, 'Taretan', 16),
(3644, 'Tarímbaro', 16),
(3645, 'Tepalcatepec', 16),
(3646, 'Tingambato', 16),
(3647, 'Tingüindín', 16),
(3648, 'Tiquicheo de Nicolás Romero', 16),
(3649, 'Tlalpujahua', 16),
(3650, 'Tlazazalca', 16),
(3651, 'Tocumbo', 16),
(3652, 'Tumbiscatío', 16),
(3653, 'Turicato', 16),
(3654, 'Tuxpan', 16),
(3655, 'Tuzantla', 16),
(3656, 'Tzintzuntzan', 16),
(3657, 'Tzitzio', 16),
(3658, 'Uruapan', 16),
(3659, 'Venustiano Carranza', 16),
(3660, 'Villamar', 16),
(3661, 'Vista Hermosa', 16),
(3662, 'Yurécuaro', 16),
(3663, 'Zacapu', 16),
(3664, 'Zamora', 16),
(3665, 'Zináparo', 16),
(3666, 'Zinapécuaro', 16),
(3667, 'Ziracuaretiro', 16),
(3668, 'Zitácuaro', 16),
(3669, 'José Sixto Verduzco', 16),
(3670, 'Amacuzac', 17),
(3671, 'Atlatlahucan', 17),
(3672, 'Axochiapan', 17),
(3673, 'Ayala', 17),
(3674, 'Coatlán del Río', 17),
(3675, 'Cuautla', 17),
(3676, 'Cuernavaca', 17),
(3677, 'Emiliano Zapata', 17),
(3678, 'Huitzilac', 17),
(3679, 'Jantetelco', 17),
(3680, 'Jiutepec', 17),
(3681, 'Jojutla', 17),
(3682, 'Jonacatepec', 17),
(3683, 'Mazatepec', 17),
(3684, 'Miacatlán', 17),
(3685, 'Ocuituco', 17),
(3686, 'Puente de Ixtla', 17),
(3687, 'Temixco', 17),
(3688, 'Tepalcingo', 17),
(3689, 'Tepoztlán', 17),
(3690, 'Tetecala', 17),
(3691, 'Tetela del Volcán', 17),
(3692, 'Tlalnepantla', 17),
(3693, 'Tlaltizapán de Zapata', 17),
(3694, 'Tlaquiltenango', 17),
(3695, 'Tlayacapan', 17),
(3696, 'Totolapan', 17),
(3697, 'Xochitepec', 17),
(3698, 'Yautepec', 17),
(3699, 'Yecapixtla', 17),
(3700, 'Zacatepec', 17),
(3701, 'Zacualpan de Amilpas', 17),
(3702, 'Temoac', 17),
(3703, 'Acaponeta', 18),
(3704, 'Ahuacatlán', 18),
(3705, 'Amatlán de Cañas', 18),
(3706, 'Compostela', 18),
(3707, 'Huajicori', 18),
(3708, 'Ixtlán del Río', 18),
(3709, 'Jala', 18),
(3710, 'Xalisco', 18),
(3711, 'Del Nayar', 18),
(3712, 'Rosamorada', 18),
(3713, 'Ruíz', 18),
(3714, 'San Blas', 18),
(3715, 'San Pedro Lagunillas', 18),
(3716, 'Santa María del Oro', 18),
(3717, 'Santiago Ixcuintla', 18),
(3718, 'Tecuala', 18),
(3719, 'Tepic', 18),
(3720, 'Tuxpan', 18),
(3721, 'La Yesca', 18),
(3722, 'Bahía de Banderas', 18),
(3723, 'Abasolo', 19),
(3724, 'Agualeguas', 19),
(3725, 'Los Aldamas', 19),
(3726, 'Allende', 19),
(3727, 'Anáhuac', 19),
(3728, 'Apodaca', 19),
(3729, 'Aramberri', 19),
(3730, 'Bustamante', 19),
(3731, 'Cadereyta Jiménez', 19),
(3732, 'El Carmen', 19),
(3733, 'Cerralvo', 19),
(3734, 'Ciénega de Flores', 19),
(3735, 'China', 19),
(3736, 'Doctor Arroyo', 19),
(3737, 'Doctor Coss', 19),
(3738, 'Doctor González', 19),
(3739, 'Galeana', 19),
(3740, 'García', 19),
(3741, 'San Pedro Garza García', 19),
(3742, 'General Bravo', 19),
(3743, 'General Escobedo', 19),
(3744, 'General Terán', 19),
(3745, 'General Treviño', 19),
(3746, 'General Zaragoza', 19),
(3747, 'General Zuazua', 19),
(3748, 'Guadalupe', 19),
(3749, 'Los Herreras', 19),
(3750, 'Higueras', 19),
(3751, 'Hualahuises', 19),
(3752, 'Iturbide', 19),
(3753, 'Juárez', 19),
(3754, 'Lampazos de Naranjo', 19),
(3755, 'Linares', 19),
(3756, 'Marín', 19),
(3757, 'Melchor Ocampo', 19),
(3758, 'Mier y Noriega', 19),
(3759, 'Mina', 19),
(3760, 'Montemorelos', 19),
(3761, 'Monterrey', 19),
(3762, 'Parás', 19),
(3763, 'Pesquería', 19),
(3764, 'Los Ramones', 19),
(3765, 'Rayones', 19),
(3766, 'Sabinas Hidalgo', 19),
(3767, 'Salinas Victoria', 19),
(3768, 'San Nicolás de los Garza', 19),
(3769, 'Hidalgo', 19),
(3770, 'Santa Catarina', 19),
(3771, 'Santiago', 19),
(3772, 'Vallecillo', 19),
(3773, 'Villaldama', 19),
(3774, 'Abejones', 20),
(3775, 'Acatlán de Pérez Figueroa', 20),
(3776, 'Asunción Cacalotepec', 20),
(3777, 'Asunción Cuyotepeji', 20),
(3778, 'Asunción Ixtaltepec', 20),
(3779, 'Asunción Nochixtlán', 20),
(3780, 'Asunción Ocotlán', 20),
(3781, 'Asunción Tlacolulita', 20),
(3782, 'Ayotzintepec', 20),
(3783, 'El Barrio de la Soledad', 20),
(3784, 'Calihualá', 20),
(3785, 'Candelaria Loxicha', 20),
(3786, 'Ciénega de Zimatlán', 20),
(3787, 'Ciudad Ixtepec', 20),
(3788, 'Coatecas Altas', 20),
(3789, 'Coicoyán de las Flores', 20),
(3790, 'La Compañía', 20),
(3791, 'Concepción Buenavista', 20),
(3792, 'Concepción Pápalo', 20),
(3793, 'Constancia del Rosario', 20),
(3794, 'Cosolapa', 20),
(3795, 'Cosoltepec', 20),
(3796, 'Cuilápam de Guerrero', 20),
(3797, 'Cuyamecalco Villa de Zaragoza', 20),
(3798, 'Chahuites', 20),
(3799, 'Chalcatongo de Hidalgo', 20),
(3800, 'Chiquihuitlán de Benito Juárez', 20),
(3801, 'Heroica Ciudad de Ejutla de Crespo', 20),
(3802, 'Eloxochitlán de Flores Magón', 20),
(3803, 'El Espinal', 20),
(3804, 'Tamazulápam del Espíritu Santo', 20),
(3805, 'Fresnillo de Trujano', 20),
(3806, 'Guadalupe Etla', 20),
(3807, 'Guadalupe de Ramírez', 20),
(3808, 'Guelatao de Juárez', 20),
(3809, 'Guevea de Humboldt', 20),
(3810, 'Mesones Hidalgo', 20),
(3811, 'Villa Hidalgo', 20),
(3812, 'Heroica Ciudad de Huajuapan de León', 20),
(3813, 'Huautepec', 20),
(3814, 'Huautla de Jiménez', 20),
(3815, 'Ixtlán de Juárez', 20),
(3816, 'Heroica Ciudad de Juchitán de Zaragoza', 20),
(3817, 'Loma Bonita', 20),
(3818, 'Magdalena Apasco', 20),
(3819, 'Magdalena Jaltepec', 20),
(3820, 'Santa Magdalena Jicotlán', 20),
(3821, 'Magdalena Mixtepec', 20),
(3822, 'Magdalena Ocotlán', 20),
(3823, 'Magdalena Peñasco', 20),
(3824, 'Magdalena Teitipac', 20),
(3825, 'Magdalena Tequisistlán', 20),
(3826, 'Magdalena Tlacotepec', 20),
(3827, 'Magdalena Zahuatlán', 20),
(3828, 'Mariscala de Juárez', 20),
(3829, 'Mártires de Tacubaya', 20),
(3830, 'Matías Romero Avendaño', 20),
(3831, 'Mazatlán Villa de Flores', 20),
(3832, 'Miahuatlán de Porfirio Díaz', 20),
(3833, 'Mixistlán de la Reforma', 20),
(3834, 'Monjas', 20),
(3835, 'Natividad', 20),
(3836, 'Nazareno Etla', 20),
(3837, 'Nejapa de Madero', 20),
(3838, 'Ixpantepec Nieves', 20),
(3839, 'Santiago Niltepec', 20),
(3840, 'Oaxaca de Juárez', 20),
(3841, 'Ocotlán de Morelos', 20),
(3842, 'La Pe', 20),
(3843, 'Pinotepa de Don Luis', 20),
(3844, 'Pluma Hidalgo', 20),
(3845, 'San José del Progreso', 20),
(3846, 'Putla Villa de Guerrero', 20),
(3847, 'Santa Catarina Quioquitani', 20),
(3848, 'Reforma de Pineda', 20),
(3849, 'La Reforma', 20),
(3850, 'Reyes Etla', 20),
(3851, 'Rojas de Cuauhtémoc', 20),
(3852, 'Salina Cruz', 20),
(3853, 'San Agustín Amatengo', 20),
(3854, 'San Agustín Atenango', 20),
(3855, 'San Agustín Chayuco', 20),
(3856, 'San Agustín de las Juntas', 20),
(3857, 'San Agustín Etla', 20),
(3858, 'San Agustín Loxicha', 20),
(3859, 'San Agustín Tlacotepec', 20),
(3860, 'San Agustín Yatareni', 20),
(3861, 'San Andrés Cabecera Nueva', 20),
(3862, 'San Andrés Dinicuiti', 20),
(3863, 'San Andrés Huaxpaltepec', 20),
(3864, 'San Andrés Huayápam', 20),
(3865, 'San Andrés Ixtlahuaca', 20),
(3866, 'San Andrés Lagunas', 20),
(3867, 'San Andrés Nuxiño', 20),
(3868, 'San Andrés Paxtlán', 20),
(3869, 'San Andrés Sinaxtla', 20),
(3870, 'San Andrés Solaga', 20),
(3871, 'San Andrés Teotilálpam', 20),
(3872, 'San Andrés Tepetlapa', 20),
(3873, 'San Andrés Yaá', 20),
(3874, 'San Andrés Zabache', 20),
(3875, 'San Andrés Zautla', 20),
(3876, 'San Antonino Castillo Velasco', 20),
(3877, 'San Antonino el Alto', 20),
(3878, 'San Antonino Monte Verde', 20),
(3879, 'San Antonio Acutla', 20),
(3880, 'San Antonio de la Cal', 20),
(3881, 'San Antonio Huitepec', 20),
(3882, 'San Antonio Nanahuatípam', 20),
(3883, 'San Antonio Sinicahua', 20),
(3884, 'San Antonio Tepetlapa', 20),
(3885, 'San Baltazar Chichicápam', 20),
(3886, 'San Baltazar Loxicha', 20),
(3887, 'San Baltazar Yatzachi el Bajo', 20),
(3888, 'San Bartolo Coyotepec', 20),
(3889, 'San Bartolomé Ayautla', 20),
(3890, 'San Bartolomé Loxicha', 20),
(3891, 'San Bartolomé Quialana', 20),
(3892, 'San Bartolomé Yucuañe', 20),
(3893, 'San Bartolomé Zoogocho', 20),
(3894, 'San Bartolo Soyaltepec', 20),
(3895, 'San Bartolo Yautepec', 20),
(3896, 'San Bernardo Mixtepec', 20),
(3897, 'San Blas Atempa', 20),
(3898, 'San Carlos Yautepec', 20),
(3899, 'San Cristóbal Amatlán', 20),
(3900, 'San Cristóbal Amoltepec', 20),
(3901, 'San Cristóbal Lachirioag', 20),
(3902, 'San Cristóbal Suchixtlahuaca', 20),
(3903, 'San Dionisio del Mar', 20),
(3904, 'San Dionisio Ocotepec', 20),
(3905, 'San Dionisio Ocotlán', 20),
(3906, 'San Esteban Atatlahuca', 20),
(3907, 'San Felipe Jalapa de Díaz', 20),
(3908, 'San Felipe Tejalápam', 20),
(3909, 'San Felipe Usila', 20),
(3910, 'San Francisco Cahuacuá', 20),
(3911, 'San Francisco Cajonos', 20),
(3912, 'San Francisco Chapulapa', 20),
(3913, 'San Francisco Chindúa', 20),
(3914, 'San Francisco del Mar', 20),
(3915, 'San Francisco Huehuetlán', 20),
(3916, 'San Francisco Ixhuatán', 20),
(3917, 'San Francisco Jaltepetongo', 20),
(3918, 'San Francisco Lachigoló', 20),
(3919, 'San Francisco Logueche', 20),
(3920, 'San Francisco Nuxaño', 20),
(3921, 'San Francisco Ozolotepec', 20),
(3922, 'San Francisco Sola', 20),
(3923, 'San Francisco Telixtlahuaca', 20),
(3924, 'San Francisco Teopan', 20),
(3925, 'San Francisco Tlapancingo', 20),
(3926, 'San Gabriel Mixtepec', 20),
(3927, 'San Ildefonso Amatlán', 20),
(3928, 'San Ildefonso Sola', 20),
(3929, 'San Ildefonso Villa Alta', 20),
(3930, 'San Jacinto Amilpas', 20),
(3931, 'San Jacinto Tlacotepec', 20),
(3932, 'San Jerónimo Coatlán', 20),
(3933, 'San Jerónimo Silacayoapilla', 20),
(3934, 'San Jerónimo Sosola', 20),
(3935, 'San Jerónimo Taviche', 20),
(3936, 'San Jerónimo Tecóatl', 20),
(3937, 'San Jorge Nuchita', 20),
(3938, 'San José Ayuquila', 20),
(3939, 'San José Chiltepec', 20),
(3940, 'San José del Peñasco', 20),
(3941, 'San José Estancia Grande', 20),
(3942, 'San José Independencia', 20),
(3943, 'San José Lachiguiri', 20),
(3944, 'San José Tenango', 20),
(3945, 'San Juan Achiutla', 20),
(3946, 'San Juan Atepec', 20),
(3947, 'Ánimas Trujano', 20),
(3948, 'San Juan Bautista Atatlahuca', 20),
(3949, 'San Juan Bautista Coixtlahuaca', 20),
(3950, 'San Juan Bautista Cuicatlán', 20),
(3951, 'San Juan Bautista Guelache', 20),
(3952, 'San Juan Bautista Jayacatlán', 20),
(3953, 'San Juan Bautista Lo de Soto', 20),
(3954, 'San Juan Bautista Suchitepec', 20),
(3955, 'San Juan Bautista Tlacoatzintepec', 20),
(3956, 'San Juan Bautista Tlachichilco', 20),
(3957, 'San Juan Bautista Tuxtepec', 20),
(3958, 'San Juan Cacahuatepec', 20),
(3959, 'San Juan Cieneguilla', 20),
(3960, 'San Juan Coatzóspam', 20),
(3961, 'San Juan Colorado', 20),
(3962, 'San Juan Comaltepec', 20),
(3963, 'San Juan Cotzocón', 20),
(3964, 'San Juan Chicomezúchil', 20),
(3965, 'San Juan Chilateca', 20),
(3966, 'San Juan del Estado', 20),
(3967, 'San Juan del Río', 20),
(3968, 'San Juan Diuxi', 20),
(3969, 'San Juan Evangelista Analco', 20),
(3970, 'San Juan Guelavía', 20),
(3971, 'San Juan Guichicovi', 20),
(3972, 'San Juan Ihualtepec', 20),
(3973, 'San Juan Juquila Mixes', 20),
(3974, 'San Juan Juquila Vijanos', 20),
(3975, 'San Juan Lachao', 20),
(3976, 'San Juan Lachigalla', 20),
(3977, 'San Juan Lajarcia', 20),
(3978, 'San Juan Lalana', 20),
(3979, 'San Juan de los Cués', 20),
(3980, 'San Juan Mazatlán', 20),
(3981, 'San Juan Mixtepec', 20),
(3982, 'San Juan Mixtepec', 20),
(3983, 'San Juan Ñumí', 20),
(3984, 'San Juan Ozolotepec', 20),
(3985, 'San Juan Petlapa', 20),
(3986, 'San Juan Quiahije', 20),
(3987, 'San Juan Quiotepec', 20),
(3988, 'San Juan Sayultepec', 20),
(3989, 'San Juan Tabaá', 20),
(3990, 'San Juan Tamazola', 20),
(3991, 'San Juan Teita', 20),
(3992, 'San Juan Teitipac', 20),
(3993, 'San Juan Tepeuxila', 20),
(3994, 'San Juan Teposcolula', 20),
(3995, 'San Juan Yaeé', 20),
(3996, 'San Juan Yatzona', 20),
(3997, 'San Juan Yucuita', 20),
(3998, 'San Lorenzo', 20),
(3999, 'San Lorenzo Albarradas', 20),
(4000, 'San Lorenzo Cacaotepec', 20),
(4001, 'San Lorenzo Cuaunecuiltitla', 20),
(4002, 'San Lorenzo Texmelúcan', 20),
(4003, 'San Lorenzo Victoria', 20),
(4004, 'San Lucas Camotlán', 20),
(4005, 'San Lucas Ojitlán', 20),
(4006, 'San Lucas Quiaviní', 20),
(4007, 'San Lucas Zoquiápam', 20),
(4008, 'San Luis Amatlán', 20),
(4009, 'San Marcial Ozolotepec', 20),
(4010, 'San Marcos Arteaga', 20),
(4011, 'San Martín de los Cansecos', 20),
(4012, 'San Martín Huamelúlpam', 20),
(4013, 'San Martín Itunyoso', 20),
(4014, 'San Martín Lachilá', 20),
(4015, 'San Martín Peras', 20),
(4016, 'San Martín Tilcajete', 20),
(4017, 'San Martín Toxpalan', 20),
(4018, 'San Martín Zacatepec', 20),
(4019, 'San Mateo Cajonos', 20),
(4020, 'Capulálpam de Méndez', 20),
(4021, 'San Mateo del Mar', 20),
(4022, 'San Mateo Yoloxochitlán', 20),
(4023, 'San Mateo Etlatongo', 20),
(4024, 'San Mateo Nejápam', 20),
(4025, 'San Mateo Peñasco', 20),
(4026, 'San Mateo Piñas', 20),
(4027, 'San Mateo Río Hondo', 20),
(4028, 'San Mateo Sindihui', 20),
(4029, 'San Mateo Tlapiltepec', 20),
(4030, 'San Melchor Betaza', 20),
(4031, 'San Miguel Achiutla', 20),
(4032, 'San Miguel Ahuehuetitlán', 20),
(4033, 'San Miguel Aloápam', 20),
(4034, 'San Miguel Amatitlán', 20),
(4035, 'San Miguel Amatlán', 20),
(4036, 'San Miguel Coatlán', 20),
(4037, 'San Miguel Chicahua', 20),
(4038, 'San Miguel Chimalapa', 20),
(4039, 'San Miguel del Puerto', 20),
(4040, 'San Miguel del Río', 20),
(4041, 'San Miguel Ejutla', 20),
(4042, 'San Miguel el Grande', 20),
(4043, 'San Miguel Huautla', 20),
(4044, 'San Miguel Mixtepec', 20),
(4045, 'San Miguel Panixtlahuaca', 20),
(4046, 'San Miguel Peras', 20),
(4047, 'San Miguel Piedras', 20),
(4048, 'San Miguel Quetzaltepec', 20),
(4049, 'San Miguel Santa Flor', 20),
(4050, 'Villa Sola de Vega', 20),
(4051, 'San Miguel Soyaltepec', 20),
(4052, 'San Miguel Suchixtepec', 20),
(4053, 'Villa Talea de Castro', 20),
(4054, 'San Miguel Tecomatlán', 20),
(4055, 'San Miguel Tenango', 20),
(4056, 'San Miguel Tequixtepec', 20),
(4057, 'San Miguel Tilquiápam', 20),
(4058, 'San Miguel Tlacamama', 20),
(4059, 'San Miguel Tlacotepec', 20),
(4060, 'San Miguel Tulancingo', 20),
(4061, 'San Miguel Yotao', 20),
(4062, 'San Nicolás', 20),
(4063, 'San Nicolás Hidalgo', 20),
(4064, 'San Pablo Coatlán', 20),
(4065, 'San Pablo Cuatro Venados', 20),
(4066, 'San Pablo Etla', 20),
(4067, 'San Pablo Huitzo', 20),
(4068, 'San Pablo Huixtepec', 20),
(4069, 'San Pablo Macuiltianguis', 20),
(4070, 'San Pablo Tijaltepec', 20),
(4071, 'San Pablo Villa de Mitla', 20),
(4072, 'San Pablo Yaganiza', 20),
(4073, 'San Pedro Amuzgos', 20),
(4074, 'San Pedro Apóstol', 20),
(4075, 'San Pedro Atoyac', 20),
(4076, 'San Pedro Cajonos', 20),
(4077, 'San Pedro Coxcaltepec Cántaros', 20),
(4078, 'San Pedro Comitancillo', 20),
(4079, 'San Pedro el Alto', 20),
(4080, 'San Pedro Huamelula', 20),
(4081, 'San Pedro Huilotepec', 20),
(4082, 'San Pedro Ixcatlán', 20),
(4083, 'San Pedro Ixtlahuaca', 20),
(4084, 'San Pedro Jaltepetongo', 20),
(4085, 'San Pedro Jicayán', 20),
(4086, 'San Pedro Jocotipac', 20),
(4087, 'San Pedro Juchatengo', 20),
(4088, 'San Pedro Mártir', 20),
(4089, 'San Pedro Mártir Quiechapa', 20),
(4090, 'San Pedro Mártir Yucuxaco', 20),
(4091, 'San Pedro Mixtepec', 20),
(4092, 'San Pedro Mixtepec', 20),
(4093, 'San Pedro Molinos', 20),
(4094, 'San Pedro Nopala', 20),
(4095, 'San Pedro Ocopetatillo', 20),
(4096, 'San Pedro Ocotepec', 20),
(4097, 'San Pedro Pochutla', 20),
(4098, 'San Pedro Quiatoni', 20),
(4099, 'San Pedro Sochiápam', 20),
(4100, 'San Pedro Tapanatepec', 20),
(4101, 'San Pedro Taviche', 20),
(4102, 'San Pedro Teozacoalco', 20),
(4103, 'San Pedro Teutila', 20),
(4104, 'San Pedro Tidaá', 20),
(4105, 'San Pedro Topiltepec', 20),
(4106, 'San Pedro Totolápam', 20),
(4107, 'Villa de Tututepec de Melchor Ocampo', 20),
(4108, 'San Pedro Yaneri', 20),
(4109, 'San Pedro Yólox', 20),
(4110, 'San Pedro y San Pablo Ayutla', 20),
(4111, 'Villa de Etla', 20),
(4112, 'San Pedro y San Pablo Teposcolula', 20),
(4113, 'San Pedro y San Pablo Tequixtepec', 20),
(4114, 'San Pedro Yucunama', 20),
(4115, 'San Raymundo Jalpan', 20),
(4116, 'San Sebastián Abasolo', 20),
(4117, 'San Sebastián Coatlán', 20),
(4118, 'San Sebastián Ixcapa', 20),
(4119, 'San Sebastián Nicananduta', 20),
(4120, 'San Sebastián Río Hondo', 20),
(4121, 'San Sebastián Tecomaxtlahuaca', 20),
(4122, 'San Sebastián Teitipac', 20),
(4123, 'San Sebastián Tutla', 20),
(4124, 'San Simón Almolongas', 20),
(4125, 'San Simón Zahuatlán', 20),
(4126, 'Santa Ana', 20),
(4127, 'Santa Ana Ateixtlahuaca', 20),
(4128, 'Santa Ana Cuauhtémoc', 20),
(4129, 'Santa Ana del Valle', 20),
(4130, 'Santa Ana Tavela', 20),
(4131, 'Santa Ana Tlapacoyan', 20),
(4132, 'Santa Ana Yareni', 20),
(4133, 'Santa Ana Zegache', 20),
(4134, 'Santa Catalina Quierí', 20),
(4135, 'Santa Catarina Cuixtla', 20),
(4136, 'Santa Catarina Ixtepeji', 20),
(4137, 'Santa Catarina Juquila', 20),
(4138, 'Santa Catarina Lachatao', 20),
(4139, 'Santa Catarina Loxicha', 20),
(4140, 'Santa Catarina Mechoacán', 20),
(4141, 'Santa Catarina Minas', 20),
(4142, 'Santa Catarina Quiané', 20),
(4143, 'Santa Catarina Tayata', 20),
(4144, 'Santa Catarina Ticuá', 20),
(4145, 'Santa Catarina Yosonotú', 20),
(4146, 'Santa Catarina Zapoquila', 20),
(4147, 'Santa Cruz Acatepec', 20),
(4148, 'Santa Cruz Amilpas', 20),
(4149, 'Santa Cruz de Bravo', 20),
(4150, 'Santa Cruz Itundujia', 20),
(4151, 'Santa Cruz Mixtepec', 20),
(4152, 'Santa Cruz Nundaco', 20),
(4153, 'Santa Cruz Papalutla', 20),
(4154, 'Santa Cruz Tacache de Mina', 20),
(4155, 'Santa Cruz Tacahua', 20),
(4156, 'Santa Cruz Tayata', 20),
(4157, 'Santa Cruz Xitla', 20),
(4158, 'Santa Cruz Xoxocotlán', 20),
(4159, 'Santa Cruz Zenzontepec', 20),
(4160, 'Santa Gertrudis', 20),
(4161, 'Santa Inés del Monte', 20),
(4162, 'Santa Inés Yatzeche', 20),
(4163, 'Santa Lucía del Camino', 20),
(4164, 'Santa Lucía Miahuatlán', 20),
(4165, 'Santa Lucía Monteverde', 20),
(4166, 'Santa Lucía Ocotlán', 20),
(4167, 'Santa María Alotepec', 20),
(4168, 'Santa María Apazco', 20),
(4169, 'Santa María la Asunción', 20),
(4170, 'Heroica Ciudad de Tlaxiaco', 20),
(4171, 'Ayoquezco de Aldama', 20),
(4172, 'Santa María Atzompa', 20),
(4173, 'Santa María Camotlán', 20),
(4174, 'Santa María Colotepec', 20),
(4175, 'Santa María Cortijo', 20),
(4176, 'Santa María Coyotepec', 20),
(4177, 'Santa María Chachoápam', 20),
(4178, 'Villa de Chilapa de Díaz', 20),
(4179, 'Santa María Chilchotla', 20),
(4180, 'Santa María Chimalapa', 20),
(4181, 'Santa María del Rosario', 20),
(4182, 'Santa María del Tule', 20),
(4183, 'Santa María Ecatepec', 20),
(4184, 'Santa María Guelacé', 20),
(4185, 'Santa María Guienagati', 20),
(4186, 'Santa María Huatulco', 20),
(4187, 'Santa María Huazolotitlán', 20),
(4188, 'Santa María Ipalapa', 20),
(4189, 'Santa María Ixcatlán', 20),
(4190, 'Santa María Jacatepec', 20),
(4191, 'Santa María Jalapa del Marqués', 20),
(4192, 'Santa María Jaltianguis', 20),
(4193, 'Santa María Lachixío', 20),
(4194, 'Santa María Mixtequilla', 20),
(4195, 'Santa María Nativitas', 20),
(4196, 'Santa María Nduayaco', 20),
(4197, 'Santa María Ozolotepec', 20),
(4198, 'Santa María Pápalo', 20),
(4199, 'Santa María Peñoles', 20),
(4200, 'Santa María Petapa', 20),
(4201, 'Santa María Quiegolani', 20),
(4202, 'Santa María Sola', 20),
(4203, 'Santa María Tataltepec', 20),
(4204, 'Santa María Tecomavaca', 20),
(4205, 'Santa María Temaxcalapa', 20),
(4206, 'Santa María Temaxcaltepec', 20),
(4207, 'Santa María Teopoxco', 20),
(4208, 'Santa María Tepantlali', 20),
(4209, 'Santa María Texcatitlán', 20),
(4210, 'Santa María Tlahuitoltepec', 20),
(4211, 'Santa María Tlalixtac', 20),
(4212, 'Santa María Tonameca', 20),
(4213, 'Santa María Totolapilla', 20),
(4214, 'Santa María Xadani', 20),
(4215, 'Santa María Yalina', 20),
(4216, 'Santa María Yavesía', 20),
(4217, 'Santa María Yolotepec', 20),
(4218, 'Santa María Yosoyúa', 20),
(4219, 'Santa María Yucuhiti', 20),
(4220, 'Santa María Zacatepec', 20),
(4221, 'Santa María Zaniza', 20),
(4222, 'Santa María Zoquitlán', 20),
(4223, 'Santiago Amoltepec', 20),
(4224, 'Santiago Apoala', 20),
(4225, 'Santiago Apóstol', 20),
(4226, 'Santiago Astata', 20),
(4227, 'Santiago Atitlán', 20),
(4228, 'Santiago Ayuquililla', 20),
(4229, 'Santiago Cacaloxtepec', 20),
(4230, 'Santiago Camotlán', 20),
(4231, 'Santiago Comaltepec', 20),
(4232, 'Santiago Chazumba', 20),
(4233, 'Santiago Choápam', 20),
(4234, 'Santiago del Río', 20),
(4235, 'Santiago Huajolotitlán', 20),
(4236, 'Santiago Huauclilla', 20),
(4237, 'Santiago Ihuitlán Plumas', 20),
(4238, 'Santiago Ixcuintepec', 20),
(4239, 'Santiago Ixtayutla', 20),
(4240, 'Santiago Jamiltepec', 20),
(4241, 'Santiago Jocotepec', 20),
(4242, 'Santiago Juxtlahuaca', 20),
(4243, 'Santiago Lachiguiri', 20),
(4244, 'Santiago Lalopa', 20),
(4245, 'Santiago Laollaga', 20),
(4246, 'Santiago Laxopa', 20),
(4247, 'Santiago Llano Grande', 20),
(4248, 'Santiago Matatlán', 20),
(4249, 'Santiago Miltepec', 20),
(4250, 'Santiago Minas', 20),
(4251, 'Santiago Nacaltepec', 20),
(4252, 'Santiago Nejapilla', 20),
(4253, 'Santiago Nundiche', 20),
(4254, 'Santiago Nuyoó', 20),
(4255, 'Santiago Pinotepa Nacional', 20),
(4256, 'Santiago Suchilquitongo', 20),
(4257, 'Santiago Tamazola', 20),
(4258, 'Santiago Tapextla', 20),
(4259, 'Villa Tejúpam de la Unión', 20),
(4260, 'Santiago Tenango', 20),
(4261, 'Santiago Tepetlapa', 20),
(4262, 'Santiago Tetepec', 20),
(4263, 'Santiago Texcalcingo', 20),
(4264, 'Santiago Textitlán', 20),
(4265, 'Santiago Tilantongo', 20),
(4266, 'Santiago Tillo', 20),
(4267, 'Santiago Tlazoyaltepec', 20),
(4268, 'Santiago Xanica', 20),
(4269, 'Santiago Xiacuí', 20),
(4270, 'Santiago Yaitepec', 20),
(4271, 'Santiago Yaveo', 20),
(4272, 'Santiago Yolomécatl', 20),
(4273, 'Santiago Yosondúa', 20),
(4274, 'Santiago Yucuyachi', 20),
(4275, 'Santiago Zacatepec', 20),
(4276, 'Santiago Zoochila', 20),
(4277, 'Nuevo Zoquiápam', 20),
(4278, 'Santo Domingo Ingenio', 20),
(4279, 'Santo Domingo Albarradas', 20),
(4280, 'Santo Domingo Armenta', 20),
(4281, 'Santo Domingo Chihuitán', 20),
(4282, 'Santo Domingo de Morelos', 20),
(4283, 'Santo Domingo Ixcatlán', 20),
(4284, 'Santo Domingo Nuxaá', 20),
(4285, 'Santo Domingo Ozolotepec', 20),
(4286, 'Santo Domingo Petapa', 20),
(4287, 'Santo Domingo Roayaga', 20),
(4288, 'Santo Domingo Tehuantepec', 20),
(4289, 'Santo Domingo Teojomulco', 20),
(4290, 'Santo Domingo Tepuxtepec', 20),
(4291, 'Santo Domingo Tlatayápam', 20),
(4292, 'Santo Domingo Tomaltepec', 20),
(4293, 'Santo Domingo Tonalá', 20),
(4294, 'Santo Domingo Tonaltepec', 20),
(4295, 'Santo Domingo Xagacía', 20),
(4296, 'Santo Domingo Yanhuitlán', 20),
(4297, 'Santo Domingo Yodohino', 20),
(4298, 'Santo Domingo Zanatepec', 20),
(4299, 'Santos Reyes Nopala', 20),
(4300, 'Santos Reyes Pápalo', 20),
(4301, 'Santos Reyes Tepejillo', 20),
(4302, 'Santos Reyes Yucuná', 20),
(4303, 'Santo Tomás Jalieza', 20),
(4304, 'Santo Tomás Mazaltepec', 20),
(4305, 'Santo Tomás Ocotepec', 20),
(4306, 'Santo Tomás Tamazulapan', 20),
(4307, 'San Vicente Coatlán', 20),
(4308, 'San Vicente Lachixío', 20),
(4309, 'San Vicente Nuñú', 20),
(4310, 'Silacayoápam', 20),
(4311, 'Sitio de Xitlapehua', 20),
(4312, 'Soledad Etla', 20),
(4313, 'Villa de Tamazulápam del Progreso', 20),
(4314, 'Tanetze de Zaragoza', 20),
(4315, 'Taniche', 20),
(4316, 'Tataltepec de Valdés', 20),
(4317, 'Teococuilco de Marcos Pérez', 20),
(4318, 'Teotitlán de Flores Magón', 20),
(4319, 'Teotitlán del Valle', 20),
(4320, 'Teotongo', 20),
(4321, 'Tepelmeme Villa de Morelos', 20),
(4322, 'Heroica Villa Tezoatlán de Segura y Luna', 20),
(4323, 'San Jerónimo Tlacochahuaya', 20),
(4324, 'Tlacolula de Matamoros', 20),
(4325, 'Tlacotepec Plumas', 20),
(4326, 'Tlalixtac de Cabrera', 20),
(4327, 'Totontepec Villa de Morelos', 20),
(4328, 'Trinidad Zaachila', 20),
(4329, 'La Trinidad Vista Hermosa', 20),
(4330, 'Unión Hidalgo', 20),
(4331, 'Valerio Trujano', 20),
(4332, 'San Juan Bautista Valle Nacional', 20),
(4333, 'Villa Díaz Ordaz', 20),
(4334, 'Yaxe', 20),
(4335, 'Magdalena Yodocono de Porfirio Díaz', 20),
(4336, 'Yogana', 20),
(4337, 'Yutanduchi de Guerrero', 20),
(4338, 'Villa de Zaachila', 20),
(4339, 'San Mateo Yucutindoo', 20),
(4340, 'Zapotitlán Lagunas', 20),
(4341, 'Zapotitlán Palmas', 20),
(4342, 'Santa Inés de Zaragoza', 20),
(4343, 'Zimatlán de Álvarez', 20),
(4344, 'Acajete', 21),
(4345, 'Acateno', 21),
(4346, 'Acatlán', 21),
(4347, 'Acatzingo', 21),
(4348, 'Acteopan', 21),
(4349, 'Ahuacatlán', 21),
(4350, 'Ahuatlán', 21),
(4351, 'Ahuazotepec', 21),
(4352, 'Ahuehuetitla', 21),
(4353, 'Ajalpan', 21),
(4354, 'Albino Zertuche', 21),
(4355, 'Aljojuca', 21),
(4356, 'Altepexi', 21),
(4357, 'Amixtlán', 21),
(4358, 'Amozoc', 21),
(4359, 'Aquixtla', 21),
(4360, 'Atempan', 21),
(4361, 'Atexcal', 21),
(4362, 'Atlixco', 21),
(4363, 'Atoyatempan', 21),
(4364, 'Atzala', 21),
(4365, 'Atzitzihuacán', 21),
(4366, 'Atzitzintla', 21),
(4367, 'Axutla', 21),
(4368, 'Ayotoxco de Guerrero', 21),
(4369, 'Calpan', 21),
(4370, 'Caltepec', 21),
(4371, 'Camocuautla', 21),
(4372, 'Caxhuacan', 21),
(4373, 'Coatepec', 21),
(4374, 'Coatzingo', 21),
(4375, 'Cohetzala', 21),
(4376, 'Cohuecan', 21),
(4377, 'Coronango', 21),
(4378, 'Coxcatlán', 21),
(4379, 'Coyomeapan', 21),
(4380, 'Coyotepec', 21),
(4381, 'Cuapiaxtla de Madero', 21),
(4382, 'Cuautempan', 21),
(4383, 'Cuautinchán', 21),
(4384, 'Cuautlancingo', 21),
(4385, 'Cuayuca de Andrade', 21),
(4386, 'Cuetzalan del Progreso', 21),
(4387, 'Cuyoaco', 21),
(4388, 'Chalchicomula de Sesma', 21),
(4389, 'Chapulco', 21),
(4390, 'Chiautla', 21),
(4391, 'Chiautzingo', 21),
(4392, 'Chiconcuautla', 21),
(4393, 'Chichiquila', 21),
(4394, 'Chietla', 21),
(4395, 'Chigmecatitlán', 21),
(4396, 'Chignahuapan', 21),
(4397, 'Chignautla', 21),
(4398, 'Chila', 21),
(4399, 'Chila de la Sal', 21),
(4400, 'Honey', 21),
(4401, 'Chilchotla', 21),
(4402, 'Chinantla', 21),
(4403, 'Domingo Arenas', 21),
(4404, 'Eloxochitlán', 21),
(4405, 'Epatlán', 21),
(4406, 'Esperanza', 21),
(4407, 'Francisco Z. Mena', 21),
(4408, 'General Felipe Ángeles', 21),
(4409, 'Guadalupe', 21),
(4410, 'Guadalupe Victoria', 21),
(4411, 'Hermenegildo Galeana', 21),
(4412, 'Huaquechula', 21),
(4413, 'Huatlatlauca', 21),
(4414, 'Huauchinango', 21),
(4415, 'Huehuetla', 21),
(4416, 'Huehuetlán el Chico', 21),
(4417, 'Huejotzingo', 21),
(4418, 'Hueyapan', 21),
(4419, 'Hueytamalco', 21),
(4420, 'Hueytlalpan', 21),
(4421, 'Huitzilan de Serdán', 21),
(4422, 'Huitziltepec', 21),
(4423, 'Atlequizayan', 21),
(4424, 'Ixcamilpa de Guerrero', 21),
(4425, 'Ixcaquixtla', 21),
(4426, 'Ixtacamaxtitlán', 21),
(4427, 'Ixtepec', 21),
(4428, 'Izúcar de Matamoros', 21),
(4429, 'Jalpan', 21),
(4430, 'Jolalpan', 21),
(4431, 'Jonotla', 21),
(4432, 'Jopala', 21),
(4433, 'Juan C. Bonilla', 21),
(4434, 'Juan Galindo', 21),
(4435, 'Juan N. Méndez', 21),
(4436, 'Lafragua', 21),
(4437, 'Libres', 21),
(4438, 'La Magdalena Tlatlauquitepec', 21),
(4439, 'Mazapiltepec de Juárez', 21),
(4440, 'Mixtla', 21),
(4441, 'Molcaxac', 21),
(4442, 'Cañada Morelos', 21),
(4443, 'Naupan', 21),
(4444, 'Nauzontla', 21),
(4445, 'Nealtican', 21),
(4446, 'Nicolás Bravo', 21),
(4447, 'Nopalucan', 21),
(4448, 'Ocotepec', 21),
(4449, 'Ocoyucan', 21),
(4450, 'Olintla', 21),
(4451, 'Oriental', 21),
(4452, 'Pahuatlán', 21),
(4453, 'Palmar de Bravo', 21),
(4454, 'Pantepec', 21),
(4455, 'Petlalcingo', 21),
(4456, 'Piaxtla', 21),
(4457, 'Puebla', 21),
(4458, 'Quecholac', 21),
(4459, 'Quimixtlán', 21),
(4460, 'Rafael Lara Grajales', 21),
(4461, 'Los Reyes de Juárez', 21),
(4462, 'San Andrés Cholula', 21),
(4463, 'San Antonio Cañada', 21),
(4464, 'San Diego la Mesa Tochimiltzingo', 21),
(4465, 'San Felipe Teotlalcingo', 21),
(4466, 'San Felipe Tepatlán', 21),
(4467, 'San Gabriel Chilac', 21),
(4468, 'San Gregorio Atzompa', 21),
(4469, 'San Jerónimo Tecuanipan', 21),
(4470, 'San Jerónimo Xayacatlán', 21),
(4471, 'San José Chiapa', 21),
(4472, 'San José Miahuatlán', 21),
(4473, 'San Juan Atenco', 21),
(4474, 'San Juan Atzompa', 21),
(4475, 'San Martín Texmelucan', 21),
(4476, 'San Martín Totoltepec', 21),
(4477, 'San Matías Tlalancaleca', 21),
(4478, 'San Miguel Ixitlán', 21),
(4479, 'San Miguel Xoxtla', 21),
(4480, 'San Nicolás Buenos Aires', 21),
(4481, 'San Nicolás de los Ranchos', 21),
(4482, 'San Pablo Anicano', 21),
(4483, 'San Pedro Cholula', 21),
(4484, 'San Pedro Yeloixtlahuaca', 21),
(4485, 'San Salvador el Seco', 21),
(4486, 'San Salvador el Verde', 21),
(4487, 'San Salvador Huixcolotla', 21),
(4488, 'San Sebastián Tlacotepec', 21),
(4489, 'Santa Catarina Tlaltempan', 21),
(4490, 'Santa Inés Ahuatempan', 21),
(4491, 'Santa Isabel Cholula', 21),
(4492, 'Santiago Miahuatlán', 21),
(4493, 'Huehuetlán el Grande', 21),
(4494, 'Santo Tomás Hueyotlipan', 21),
(4495, 'Soltepec', 21),
(4496, 'Tecali de Herrera', 21),
(4497, 'Tecamachalco', 21),
(4498, 'Tecomatlán', 21),
(4499, 'Tehuacán', 21),
(4500, 'Tehuitzingo', 21),
(4501, 'Tenampulco', 21),
(4502, 'Teopantlán', 21),
(4503, 'Teotlalco', 21),
(4504, 'Tepanco de López', 21),
(4505, 'Tepango de Rodríguez', 21),
(4506, 'Tepatlaxco de Hidalgo', 21),
(4507, 'Tepeaca', 21),
(4508, 'Tepemaxalco', 21),
(4509, 'Tepeojuma', 21),
(4510, 'Tepetzintla', 21),
(4511, 'Tepexco', 21),
(4512, 'Tepexi de Rodríguez', 21),
(4513, 'Tepeyahualco', 21),
(4514, 'Tepeyahualco de Cuauhtémoc', 21),
(4515, 'Tetela de Ocampo', 21),
(4516, 'Teteles de Avila Castillo', 21),
(4517, 'Teziutlán', 21),
(4518, 'Tianguismanalco', 21),
(4519, 'Tilapa', 21),
(4520, 'Tlacotepec de Benito Juárez', 21),
(4521, 'Tlacuilotepec', 21),
(4522, 'Tlachichuca', 21),
(4523, 'Tlahuapan', 21),
(4524, 'Tlaltenango', 21),
(4525, 'Tlanepantla', 21),
(4526, 'Tlaola', 21),
(4527, 'Tlapacoya', 21),
(4528, 'Tlapanalá', 21),
(4529, 'Tlatlauquitepec', 21),
(4530, 'Tlaxco', 21),
(4531, 'Tochimilco', 21),
(4532, 'Tochtepec', 21),
(4533, 'Totoltepec de Guerrero', 21),
(4534, 'Tulcingo', 21),
(4535, 'Tuzamapan de Galeana', 21),
(4536, 'Tzicatlacoyan', 21),
(4537, 'Venustiano Carranza', 21),
(4538, 'Vicente Guerrero', 21),
(4539, 'Xayacatlán de Bravo', 21),
(4540, 'Xicotepec', 21),
(4541, 'Xicotlán', 21),
(4542, 'Xiutetelco', 21),
(4543, 'Xochiapulco', 21),
(4544, 'Xochiltepec', 21);
INSERT INTO `ufmx_misc_cities` (`id`, `name`, `state_id`) VALUES
(4545, 'Xochitlán de Vicente Suárez', 21),
(4546, 'Xochitlán Todos Santos', 21),
(4547, 'Yaonáhuac', 21),
(4548, 'Yehualtepec', 21),
(4549, 'Zacapala', 21),
(4550, 'Zacapoaxtla', 21),
(4551, 'Zacatlán', 21),
(4552, 'Zapotitlán', 21),
(4553, 'Zapotitlán de Méndez', 21),
(4554, 'Zaragoza', 21),
(4555, 'Zautla', 21),
(4556, 'Zihuateutla', 21),
(4557, 'Zinacatepec', 21),
(4558, 'Zongozotla', 21),
(4559, 'Zoquiapan', 21),
(4560, 'Zoquitlán', 21),
(4561, 'Amealco de Bonfil', 22),
(4562, 'Pinal de Amoles', 22),
(4563, 'Arroyo Seco', 22),
(4564, 'Cadereyta de Montes', 22),
(4565, 'Colón', 22),
(4566, 'Corregidora', 22),
(4567, 'Ezequiel Montes', 22),
(4568, 'Huimilpan', 22),
(4569, 'Jalpan de Serra', 22),
(4570, 'Landa de Matamoros', 22),
(4571, 'El Marqués', 22),
(4572, 'Pedro Escobedo', 22),
(4573, 'Peñamiller', 22),
(4574, 'Querétaro', 22),
(4575, 'San Joaquín', 22),
(4576, 'San Juan del Río', 22),
(4577, 'Tequisquiapan', 22),
(4578, 'Tolimán', 22),
(4579, 'Cozumel', 23),
(4580, 'Felipe Carrillo Puerto', 23),
(4581, 'Isla Mujeres', 23),
(4582, 'Othón P. Blanco', 23),
(4583, 'Benito Juárez', 23),
(4584, 'José María Morelos', 23),
(4585, 'Lázaro Cárdenas', 23),
(4586, 'Solidaridad', 23),
(4587, 'Tulum', 23),
(4588, 'Bacalar', 23),
(4589, 'Ahualulco', 24),
(4590, 'Alaquines', 24),
(4591, 'Aquismón', 24),
(4592, 'Armadillo de los Infante', 24),
(4593, 'Cárdenas', 24),
(4594, 'Catorce', 24),
(4595, 'Cedral', 24),
(4596, 'Cerritos', 24),
(4597, 'Cerro de San Pedro', 24),
(4598, 'Ciudad del Maíz', 24),
(4599, 'Ciudad Fernández', 24),
(4600, 'Tancanhuitz', 24),
(4601, 'Ciudad Valles', 24),
(4602, 'Coxcatlán', 24),
(4603, 'Charcas', 24),
(4604, 'Ebano', 24),
(4605, 'Guadalcázar', 24),
(4606, 'Huehuetlán', 24),
(4607, 'Lagunillas', 24),
(4608, 'Matehuala', 24),
(4609, 'Mexquitic de Carmona', 24),
(4610, 'Moctezuma', 24),
(4611, 'Rayón', 24),
(4612, 'Rioverde', 24),
(4613, 'Salinas', 24),
(4614, 'San Antonio', 24),
(4615, 'San Ciro de Acosta', 24),
(4616, 'San Luis Potosí', 24),
(4617, 'San Martín Chalchicuautla', 24),
(4618, 'San Nicolás Tolentino', 24),
(4619, 'Santa Catarina', 24),
(4620, 'Santa María del Río', 24),
(4621, 'Santo Domingo', 24),
(4622, 'San Vicente Tancuayalab', 24),
(4623, 'Soledad de Graciano Sánchez', 24),
(4624, 'Tamasopo', 24),
(4625, 'Tamazunchale', 24),
(4626, 'Tampacán', 24),
(4627, 'Tampamolón Corona', 24),
(4628, 'Tamuín', 24),
(4629, 'Tanlajás', 24),
(4630, 'Tanquián de Escobedo', 24),
(4631, 'Tierra Nueva', 24),
(4632, 'Vanegas', 24),
(4633, 'Venado', 24),
(4634, 'Villa de Arriaga', 24),
(4635, 'Villa de Guadalupe', 24),
(4636, 'Villa de la Paz', 24),
(4637, 'Villa de Ramos', 24),
(4638, 'Villa de Reyes', 24),
(4639, 'Villa Hidalgo', 24),
(4640, 'Villa Juárez', 24),
(4641, 'Axtla de Terrazas', 24),
(4642, 'Xilitla', 24),
(4643, 'Zaragoza', 24),
(4644, 'Villa de Arista', 24),
(4645, 'Matlapa', 24),
(4646, 'El Naranjo', 24),
(4647, 'Ahome', 25),
(4648, 'Angostura', 25),
(4649, 'Badiraguato', 25),
(4650, 'Concordia', 25),
(4651, 'Cosalá', 25),
(4652, 'Culiacán', 25),
(4653, 'Choix', 25),
(4654, 'Elota', 25),
(4655, 'Escuinapa', 25),
(4656, 'El Fuerte', 25),
(4657, 'Guasave', 25),
(4658, 'Mazatlán', 25),
(4659, 'Mocorito', 25),
(4660, 'Rosario', 25),
(4661, 'Salvador Alvarado', 25),
(4662, 'San Ignacio', 25),
(4663, 'Sinaloa', 25),
(4664, 'Navolato', 25),
(4665, 'Aconchi', 26),
(4666, 'Agua Prieta', 26),
(4667, 'Alamos', 26),
(4668, 'Altar', 26),
(4669, 'Arivechi', 26),
(4670, 'Arizpe', 26),
(4671, 'Atil', 26),
(4672, 'Bacadéhuachi', 26),
(4673, 'Bacanora', 26),
(4674, 'Bacerac', 26),
(4675, 'Bacoachi', 26),
(4676, 'Bácum', 26),
(4677, 'Banámichi', 26),
(4678, 'Baviácora', 26),
(4679, 'Bavispe', 26),
(4680, 'Benjamín Hill', 26),
(4681, 'Caborca', 26),
(4682, 'Cajeme', 26),
(4683, 'Cananea', 26),
(4684, 'Carbó', 26),
(4685, 'La Colorada', 26),
(4686, 'Cucurpe', 26),
(4687, 'Cumpas', 26),
(4688, 'Divisaderos', 26),
(4689, 'Empalme', 26),
(4690, 'Etchojoa', 26),
(4691, 'Fronteras', 26),
(4692, 'Granados', 26),
(4693, 'Guaymas', 26),
(4694, 'Hermosillo', 26),
(4695, 'Huachinera', 26),
(4696, 'Huásabas', 26),
(4697, 'Huatabampo', 26),
(4698, 'Huépac', 26),
(4699, 'Imuris', 26),
(4700, 'Magdalena', 26),
(4701, 'Mazatán', 26),
(4702, 'Moctezuma', 26),
(4703, 'Naco', 26),
(4704, 'Nácori Chico', 26),
(4705, 'Nacozari de García', 26),
(4706, 'Navojoa', 26),
(4707, 'Nogales', 26),
(4708, 'Onavas', 26),
(4709, 'Opodepe', 26),
(4710, 'Oquitoa', 26),
(4711, 'Pitiquito', 26),
(4712, 'Puerto Peñasco', 26),
(4713, 'Quiriego', 26),
(4714, 'Rayón', 26),
(4715, 'Rosario', 26),
(4716, 'Sahuaripa', 26),
(4717, 'San Felipe de Jesús', 26),
(4718, 'San Javier', 26),
(4719, 'San Luis Río Colorado', 26),
(4720, 'San Miguel de Horcasitas', 26),
(4721, 'San Pedro de la Cueva', 26),
(4722, 'Santa Ana', 26),
(4723, 'Santa Cruz', 26),
(4724, 'Sáric', 26),
(4725, 'Soyopa', 26),
(4726, 'Suaqui Grande', 26),
(4727, 'Tepache', 26),
(4728, 'Trincheras', 26),
(4729, 'Tubutama', 26),
(4730, 'Ures', 26),
(4731, 'Villa Hidalgo', 26),
(4732, 'Villa Pesqueira', 26),
(4733, 'Yécora', 26),
(4734, 'General Plutarco Elías Calles', 26),
(4735, 'Benito Juárez', 26),
(4736, 'San Ignacio Río Muerto', 26),
(4737, 'Balancán', 27),
(4738, 'Cárdenas', 27),
(4739, 'Centla', 27),
(4740, 'Centro', 27),
(4741, 'Comalcalco', 27),
(4742, 'Cunduacán', 27),
(4743, 'Emiliano Zapata', 27),
(4744, 'Huimanguillo', 27),
(4745, 'Jalapa', 27),
(4746, 'Jalpa de Méndez', 27),
(4747, 'Jonuta', 27),
(4748, 'Macuspana', 27),
(4749, 'Nacajuca', 27),
(4750, 'Paraíso', 27),
(4751, 'Tacotalpa', 27),
(4752, 'Teapa', 27),
(4753, 'Tenosique', 27),
(4754, 'Abasolo', 28),
(4755, 'Aldama', 28),
(4756, 'Altamira', 28),
(4757, 'Antiguo Morelos', 28),
(4758, 'Burgos', 28),
(4759, 'Bustamante', 28),
(4760, 'Camargo', 28),
(4761, 'Casas', 28),
(4762, 'Ciudad Madero', 28),
(4763, 'Cruillas', 28),
(4764, 'Gómez Farías', 28),
(4765, 'González', 28),
(4766, 'Güémez', 28),
(4767, 'Guerrero', 28),
(4768, 'Gustavo Díaz Ordaz', 28),
(4769, 'Hidalgo', 28),
(4770, 'Jaumave', 28),
(4771, 'Jiménez', 28),
(4772, 'Llera', 28),
(4773, 'Mainero', 28),
(4774, 'El Mante', 28),
(4775, 'Matamoros', 28),
(4776, 'Méndez', 28),
(4777, 'Mier', 28),
(4778, 'Miguel Alemán', 28),
(4779, 'Miquihuana', 28),
(4780, 'Nuevo Laredo', 28),
(4781, 'Nuevo Morelos', 28),
(4782, 'Ocampo', 28),
(4783, 'Padilla', 28),
(4784, 'Palmillas', 28),
(4785, 'Reynosa', 28),
(4786, 'Río Bravo', 28),
(4787, 'San Carlos', 28),
(4788, 'San Fernando', 28),
(4789, 'San Nicolás', 28),
(4790, 'Soto la Marina', 28),
(4791, 'Tampico', 28),
(4792, 'Tula', 28),
(4793, 'Valle Hermoso', 28),
(4794, 'Victoria', 28),
(4795, 'Villagrán', 28),
(4796, 'Xicoténcatl', 28),
(4797, 'Amaxac de Guerrero', 29),
(4798, 'Apetatitlán de Antonio Carvajal', 29),
(4799, 'Atlangatepec', 29),
(4800, 'Atltzayanca', 29),
(4801, 'Apizaco', 29),
(4802, 'Calpulalpan', 29),
(4803, 'El Carmen Tequexquitla', 29),
(4804, 'Cuapiaxtla', 29),
(4805, 'Cuaxomulco', 29),
(4806, 'Chiautempan', 29),
(4807, 'Muñoz de Domingo Arenas', 29),
(4808, 'Españita', 29),
(4809, 'Huamantla', 29),
(4810, 'Hueyotlipan', 29),
(4811, 'Ixtacuixtla de Mariano Matamoros', 29),
(4812, 'Ixtenco', 29),
(4813, 'Mazatecochco de José María Morelos', 29),
(4814, 'Contla de Juan Cuamatzi', 29),
(4815, 'Tepetitla de Lardizábal', 29),
(4816, 'Sanctórum de Lázaro Cárdenas', 29),
(4817, 'Nanacamilpa de Mariano Arista', 29),
(4818, 'Acuamanala de Miguel Hidalgo', 29),
(4819, 'Natívitas', 29),
(4820, 'Panotla', 29),
(4821, 'San Pablo del Monte', 29),
(4822, 'Santa Cruz Tlaxcala', 29),
(4823, 'Tenancingo', 29),
(4824, 'Teolocholco', 29),
(4825, 'Tepeyanco', 29),
(4826, 'Terrenate', 29),
(4827, 'Tetla de la Solidaridad', 29),
(4828, 'Tetlatlahuca', 29),
(4829, 'Tlaxcala', 29),
(4830, 'Tlaxco', 29),
(4831, 'Tocatlán', 29),
(4832, 'Totolac', 29),
(4833, 'Ziltlaltépec de Trinidad Sánchez Santos', 29),
(4834, 'Tzompantepec', 29),
(4835, 'Xaloztoc', 29),
(4836, 'Xaltocan', 29),
(4837, 'Papalotla de Xicohténcatl', 29),
(4838, 'Xicohtzinco', 29),
(4839, 'Yauhquemehcan', 29),
(4840, 'Zacatelco', 29),
(4841, 'Benito Juárez', 29),
(4842, 'Emiliano Zapata', 29),
(4843, 'Lázaro Cárdenas', 29),
(4844, 'La Magdalena Tlaltelulco', 29),
(4845, 'San Damián Texóloc', 29),
(4846, 'San Francisco Tetlanohcan', 29),
(4847, 'San Jerónimo Zacualpan', 29),
(4848, 'San José Teacalco', 29),
(4849, 'San Juan Huactzinco', 29),
(4850, 'San Lorenzo Axocomanitla', 29),
(4851, 'San Lucas Tecopilco', 29),
(4852, 'Santa Ana Nopalucan', 29),
(4853, 'Santa Apolonia Teacalco', 29),
(4854, 'Santa Catarina Ayometla', 29),
(4855, 'Santa Cruz Quilehtla', 29),
(4856, 'Santa Isabel Xiloxoxtla', 29),
(4857, 'Acajete', 30),
(4858, 'Acatlán', 30),
(4859, 'Acayucan', 30),
(4860, 'Actopan', 30),
(4861, 'Acula', 30),
(4862, 'Acultzingo', 30),
(4863, 'Camarón de Tejeda', 30),
(4864, 'Alpatláhuac', 30),
(4865, 'Alto Lucero de Gutiérrez Barrios', 30),
(4866, 'Altotonga', 30),
(4867, 'Alvarado', 30),
(4868, 'Amatitlán', 30),
(4869, 'Naranjos Amatlán', 30),
(4870, 'Amatlán de los Reyes', 30),
(4871, 'Angel R. Cabada', 30),
(4872, 'La Antigua', 30),
(4873, 'Apazapan', 30),
(4874, 'Aquila', 30),
(4875, 'Astacinga', 30),
(4876, 'Atlahuilco', 30),
(4877, 'Atoyac', 30),
(4878, 'Atzacan', 30),
(4879, 'Atzalan', 30),
(4880, 'Tlaltetela', 30),
(4881, 'Ayahualulco', 30),
(4882, 'Banderilla', 30),
(4883, 'Benito Juárez', 30),
(4884, 'Boca del Río', 30),
(4885, 'Calcahualco', 30),
(4886, 'Camerino Z. Mendoza', 30),
(4887, 'Carrillo Puerto', 30),
(4888, 'Catemaco', 30),
(4889, 'Cazones de Herrera', 30),
(4890, 'Cerro Azul', 30),
(4891, 'Citlaltépetl', 30),
(4892, 'Coacoatzintla', 30),
(4893, 'Coahuitlán', 30),
(4894, 'Coatepec', 30),
(4895, 'Coatzacoalcos', 30),
(4896, 'Coatzintla', 30),
(4897, 'Coetzala', 30),
(4898, 'Colipa', 30),
(4899, 'Comapa', 30),
(4900, 'Córdoba', 30),
(4901, 'Cosamaloapan de Carpio', 30),
(4902, 'Cosautlán de Carvajal', 30),
(4903, 'Coscomatepec', 30),
(4904, 'Cosoleacaque', 30),
(4905, 'Cotaxtla', 30),
(4906, 'Coxquihui', 30),
(4907, 'Coyutla', 30),
(4908, 'Cuichapa', 30),
(4909, 'Cuitláhuac', 30),
(4910, 'Chacaltianguis', 30),
(4911, 'Chalma', 30),
(4912, 'Chiconamel', 30),
(4913, 'Chiconquiaco', 30),
(4914, 'Chicontepec', 30),
(4915, 'Chinameca', 30),
(4916, 'Chinampa de Gorostiza', 30),
(4917, 'Las Choapas', 30),
(4918, 'Chocamán', 30),
(4919, 'Chontla', 30),
(4920, 'Chumatlán', 30),
(4921, 'Emiliano Zapata', 30),
(4922, 'Espinal', 30),
(4923, 'Filomeno Mata', 30),
(4924, 'Fortín', 30),
(4925, 'Gutiérrez Zamora', 30),
(4926, 'Hidalgotitlán', 30),
(4927, 'Huatusco', 30),
(4928, 'Huayacocotla', 30),
(4929, 'Hueyapan de Ocampo', 30),
(4930, 'Huiloapan de Cuauhtémoc', 30),
(4931, 'Ignacio de la Llave', 30),
(4932, 'Ilamatlán', 30),
(4933, 'Isla', 30),
(4934, 'Ixcatepec', 30),
(4935, 'Ixhuacán de los Reyes', 30),
(4936, 'Ixhuatlán del Café', 30),
(4937, 'Ixhuatlancillo', 30),
(4938, 'Ixhuatlán del Sureste', 30),
(4939, 'Ixhuatlán de Madero', 30),
(4940, 'Ixmatlahuacan', 30),
(4941, 'Ixtaczoquitlán', 30),
(4942, 'Jalacingo', 30),
(4943, 'Xalapa', 30),
(4944, 'Jalcomulco', 30),
(4945, 'Jáltipan', 30),
(4946, 'Jamapa', 30),
(4947, 'Jesús Carranza', 30),
(4948, 'Xico', 30),
(4949, 'Jilotepec', 30),
(4950, 'Juan Rodríguez Clara', 30),
(4951, 'Juchique de Ferrer', 30),
(4952, 'Landero y Coss', 30),
(4953, 'Lerdo de Tejada', 30),
(4954, 'Magdalena', 30),
(4955, 'Maltrata', 30),
(4956, 'Manlio Fabio Altamirano', 30),
(4957, 'Mariano Escobedo', 30),
(4958, 'Martínez de la Torre', 30),
(4959, 'Mecatlán', 30),
(4960, 'Mecayapan', 30),
(4961, 'Medellín de Bravo', 30),
(4962, 'Miahuatlán', 30),
(4963, 'Las Minas', 30),
(4964, 'Minatitlán', 30),
(4965, 'Misantla', 30),
(4966, 'Mixtla de Altamirano', 30),
(4967, 'Moloacán', 30),
(4968, 'Naolinco', 30),
(4969, 'Naranjal', 30),
(4970, 'Nautla', 30),
(4971, 'Nogales', 30),
(4972, 'Oluta', 30),
(4973, 'Omealca', 30),
(4974, 'Orizaba', 30),
(4975, 'Otatitlán', 30),
(4976, 'Oteapan', 30),
(4977, 'Ozuluama de Mascareñas', 30),
(4978, 'Pajapan', 30),
(4979, 'Pánuco', 30),
(4980, 'Papantla', 30),
(4981, 'Paso del Macho', 30),
(4982, 'Paso de Ovejas', 30),
(4983, 'La Perla', 30),
(4984, 'Perote', 30),
(4985, 'Platón Sánchez', 30),
(4986, 'Playa Vicente', 30),
(4987, 'Poza Rica de Hidalgo', 30),
(4988, 'Las Vigas de Ramírez', 30),
(4989, 'Pueblo Viejo', 30),
(4990, 'Puente Nacional', 30),
(4991, 'Rafael Delgado', 30),
(4992, 'Rafael Lucio', 30),
(4993, 'Los Reyes', 30),
(4994, 'Río Blanco', 30),
(4995, 'Saltabarranca', 30),
(4996, 'San Andrés Tenejapan', 30),
(4997, 'San Andrés Tuxtla', 30),
(4998, 'San Juan Evangelista', 30),
(4999, 'Santiago Tuxtla', 30),
(5000, 'Sayula de Alemán', 30),
(5001, 'Soconusco', 30),
(5002, 'Sochiapa', 30),
(5003, 'Soledad Atzompa', 30),
(5004, 'Soledad de Doblado', 30),
(5005, 'Soteapan', 30),
(5006, 'Tamalín', 30),
(5007, 'Tamiahua', 30),
(5008, 'Tampico Alto', 30),
(5009, 'Tancoco', 30),
(5010, 'Tantima', 30),
(5011, 'Tantoyuca', 30),
(5012, 'Tatatila', 30),
(5013, 'Castillo de Teayo', 30),
(5014, 'Tecolutla', 30),
(5015, 'Tehuipango', 30),
(5016, 'Álamo Temapache', 30),
(5017, 'Tempoal', 30),
(5018, 'Tenampa', 30),
(5019, 'Tenochtitlán', 30),
(5020, 'Teocelo', 30),
(5021, 'Tepatlaxco', 30),
(5022, 'Tepetlán', 30),
(5023, 'Tepetzintla', 30),
(5024, 'Tequila', 30),
(5025, 'José Azueta', 30),
(5026, 'Texcatepec', 30),
(5027, 'Texhuacán', 30),
(5028, 'Texistepec', 30),
(5029, 'Tezonapa', 30),
(5030, 'Tierra Blanca', 30),
(5031, 'Tihuatlán', 30),
(5032, 'Tlacojalpan', 30),
(5033, 'Tlacolulan', 30),
(5034, 'Tlacotalpan', 30),
(5035, 'Tlacotepec de Mejía', 30),
(5036, 'Tlachichilco', 30),
(5037, 'Tlalixcoyan', 30),
(5038, 'Tlalnelhuayocan', 30),
(5039, 'Tlapacoyan', 30),
(5040, 'Tlaquilpa', 30),
(5041, 'Tlilapan', 30),
(5042, 'Tomatlán', 30),
(5043, 'Tonayán', 30),
(5044, 'Totutla', 30),
(5045, 'Tuxpan', 30),
(5046, 'Tuxtilla', 30),
(5047, 'Ursulo Galván', 30),
(5048, 'Vega de Alatorre', 30),
(5049, 'Veracruz', 30),
(5050, 'Villa Aldama', 30),
(5051, 'Xoxocotla', 30),
(5052, 'Yanga', 30),
(5053, 'Yecuatla', 30),
(5054, 'Zacualpan', 30),
(5055, 'Zaragoza', 30),
(5056, 'Zentla', 30),
(5057, 'Zongolica', 30),
(5058, 'Zontecomatlán de López y Fuentes', 30),
(5059, 'Zozocolco de Hidalgo', 30),
(5060, 'Agua Dulce', 30),
(5061, 'El Higo', 30),
(5062, 'Nanchital de Lázaro Cárdenas del Río', 30),
(5063, 'Tres Valles', 30),
(5064, 'Carlos A. Carrillo', 30),
(5065, 'Tatahuicapan de Juárez', 30),
(5066, 'Uxpanapa', 30),
(5067, 'San Rafael', 30),
(5068, 'Santiago Sochiapan', 30),
(5069, 'Abalá', 31),
(5070, 'Acanceh', 31),
(5071, 'Akil', 31),
(5072, 'Baca', 31),
(5073, 'Bokobá', 31),
(5074, 'Buctzotz', 31),
(5075, 'Cacalchén', 31),
(5076, 'Calotmul', 31),
(5077, 'Cansahcab', 31),
(5078, 'Cantamayec', 31),
(5079, 'Celestún', 31),
(5080, 'Cenotillo', 31),
(5081, 'Conkal', 31),
(5082, 'Cuncunul', 31),
(5083, 'Cuzamá', 31),
(5084, 'Chacsinkín', 31),
(5085, 'Chankom', 31),
(5086, 'Chapab', 31),
(5087, 'Chemax', 31),
(5088, 'Chicxulub Pueblo', 31),
(5089, 'Chichimilá', 31),
(5090, 'Chikindzonot', 31),
(5091, 'Chocholá', 31),
(5092, 'Chumayel', 31),
(5093, 'Dzán', 31),
(5094, 'Dzemul', 31),
(5095, 'Dzidzantún', 31),
(5096, 'Dzilam de Bravo', 31),
(5097, 'Dzilam González', 31),
(5098, 'Dzitás', 31),
(5099, 'Dzoncauich', 31),
(5100, 'Espita', 31),
(5101, 'Halachó', 31),
(5102, 'Hocabá', 31),
(5103, 'Hoctún', 31),
(5104, 'Homún', 31),
(5105, 'Huhí', 31),
(5106, 'Hunucmá', 31),
(5107, 'Ixil', 31),
(5108, 'Izamal', 31),
(5109, 'Kanasín', 31),
(5110, 'Kantunil', 31),
(5111, 'Kaua', 31),
(5112, 'Kinchil', 31),
(5113, 'Kopomá', 31),
(5114, 'Mama', 31),
(5115, 'Maní', 31),
(5116, 'Maxcanú', 31),
(5117, 'Mayapán', 31),
(5118, 'Mérida', 31),
(5119, 'Mocochá', 31),
(5120, 'Motul', 31),
(5121, 'Muna', 31),
(5122, 'Muxupip', 31),
(5123, 'Opichén', 31),
(5124, 'Oxkutzcab', 31),
(5125, 'Panabá', 31),
(5126, 'Peto', 31),
(5127, 'Progreso', 31),
(5128, 'Quintana Roo', 31),
(5129, 'Río Lagartos', 31),
(5130, 'Sacalum', 31),
(5131, 'Samahil', 31),
(5132, 'Sanahcat', 31),
(5133, 'San Felipe', 31),
(5134, 'Santa Elena', 31),
(5135, 'Seyé', 31),
(5136, 'Sinanché', 31),
(5137, 'Sotuta', 31),
(5138, 'Sucilá', 31),
(5139, 'Sudzal', 31),
(5140, 'Suma', 31),
(5141, 'Tahdziú', 31),
(5142, 'Tahmek', 31),
(5143, 'Teabo', 31),
(5144, 'Tecoh', 31),
(5145, 'Tekal de Venegas', 31),
(5146, 'Tekantó', 31),
(5147, 'Tekax', 31),
(5148, 'Tekit', 31),
(5149, 'Tekom', 31),
(5150, 'Telchac Pueblo', 31),
(5151, 'Telchac Puerto', 31),
(5152, 'Temax', 31),
(5153, 'Temozón', 31),
(5154, 'Tepakán', 31),
(5155, 'Tetiz', 31),
(5156, 'Teya', 31),
(5157, 'Ticul', 31),
(5158, 'Timucuy', 31),
(5159, 'Tinum', 31),
(5160, 'Tixcacalcupul', 31),
(5161, 'Tixkokob', 31),
(5162, 'Tixmehuac', 31),
(5163, 'Tixpéhual', 31),
(5164, 'Tizimín', 31),
(5165, 'Tunkás', 31),
(5166, 'Tzucacab', 31),
(5167, 'Uayma', 31),
(5168, 'Ucú', 31),
(5169, 'Umán', 31),
(5170, 'Valladolid', 31),
(5171, 'Xocchel', 31),
(5172, 'Yaxcabá', 31),
(5173, 'Yaxkukul', 31),
(5174, 'Yobaín', 31),
(5175, 'Apozol', 32),
(5176, 'Apulco', 32),
(5177, 'Atolinga', 32),
(5178, 'Benito Juárez', 32),
(5179, 'Calera', 32),
(5180, 'Cañitas de Felipe Pescador', 32),
(5181, 'Concepción del Oro', 32),
(5182, 'Cuauhtémoc', 32),
(5183, 'Chalchihuites', 32),
(5184, 'Fresnillo', 32),
(5185, 'Trinidad García de la Cadena', 32),
(5186, 'Genaro Codina', 32),
(5187, 'General Enrique Estrada', 32),
(5188, 'General Francisco R. Murguía', 32),
(5189, 'El Plateado de Joaquín Amaro', 32),
(5190, 'General Pánfilo Natera', 32),
(5191, 'Guadalupe', 32),
(5192, 'Huanusco', 32),
(5193, 'Jalpa', 32),
(5194, 'Jerez', 32),
(5195, 'Jiménez del Teul', 32),
(5196, 'Juan Aldama', 32),
(5197, 'Juchipila', 32),
(5198, 'Loreto', 32),
(5199, 'Luis Moya', 32),
(5200, 'Mazapil', 32),
(5201, 'Melchor Ocampo', 32),
(5202, 'Mezquital del Oro', 32),
(5203, 'Miguel Auza', 32),
(5204, 'Momax', 32),
(5205, 'Monte Escobedo', 32),
(5206, 'Morelos', 32),
(5207, 'Moyahua de Estrada', 32),
(5208, 'Nochistlán de Mejía', 32),
(5209, 'Noria de Ángeles', 32),
(5210, 'Ojocaliente', 32),
(5211, 'Pánuco', 32),
(5212, 'Pinos', 32),
(5213, 'Río Grande', 32),
(5214, 'Sain Alto', 32),
(5215, 'El Salvador', 32),
(5216, 'Sombrerete', 32),
(5217, 'Susticacán', 32),
(5218, 'Tabasco', 32),
(5219, 'Tepechitlán', 32),
(5220, 'Tepetongo', 32),
(5221, 'Teúl de González Ortega', 32),
(5222, 'Tlaltenango de Sánchez Román', 32),
(5223, 'Valparaíso', 32),
(5224, 'Vetagrande', 32),
(5225, 'Villa de Cos', 32),
(5226, 'Villa García', 32),
(5227, 'Villa González Ortega', 32),
(5228, 'Villa Hidalgo', 32),
(5229, 'Villanueva', 32),
(5230, 'Zacatecas', 32),
(5231, 'Trancoso', 32),
(5232, 'Santa María de la Paz', 32);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_misc_quotations`
--

CREATE TABLE `ufmx_misc_quotations` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_misc_quotations`
--

INSERT INTO `ufmx_misc_quotations` (`id`, `customer_id`, `user_id`) VALUES
(6, 3, 4),
(7, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_misc_quotation_details`
--

CREATE TABLE `ufmx_misc_quotation_details` (
  `id` int(11) NOT NULL,
  `quotation_id` int(11) NOT NULL,
  `description` varchar(75) NOT NULL,
  `color` varchar(25) DEFAULT NULL,
  `size` varchar(4) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `customization` tinyint(1) NOT NULL DEFAULT 0,
  `additional_notes` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_misc_quotation_details`
--

INSERT INTO `ufmx_misc_quotation_details` (`id`, `quotation_id`, `description`, `color`, `size`, `price`, `quantity`, `customization`, `additional_notes`) VALUES
(1, 6, 'asdasdwqdsad', 'Azul aciano', '34', 200, 40, 0, 'asdfasdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_misc_states`
--

CREATE TABLE `ufmx_misc_states` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `short_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_misc_states`
--

INSERT INTO `ufmx_misc_states` (`id`, `name`, `short_name`) VALUES
(1, 'Aguascalientes', 'AGU'),
(2, 'Baja California', 'BCN'),
(3, 'Baja California Sur', 'BCS'),
(4, 'Campeche', 'CAM'),
(5, 'Chiapas', 'CHP'),
(6, 'Chihuahua', 'CHH'),
(7, 'Ciudad de México', 'CMX'),
(8, 'Coahuila', 'COA'),
(9, 'Colima', 'COL'),
(10, 'Durango', 'DUR'),
(11, 'Guanajuato', 'GUA'),
(12, 'Guerrero', 'GRO'),
(13, 'Hidalgo', 'HID'),
(14, 'Jalisco', 'JAL'),
(15, 'Estado de México', 'MEX'),
(16, 'Michoacán', 'MIC'),
(17, 'Morelos', 'MOR'),
(18, 'Nayarit', 'NAY'),
(19, 'Nuevo León', 'NLE'),
(20, 'Oaxaca', 'OAX'),
(21, 'Puebla', 'PUE'),
(22, 'Querétaro', 'QUE'),
(23, 'Quintana', 'ROO'),
(24, 'San Luis Potosí', 'SLP'),
(25, 'Sinaloa', 'SIN'),
(26, 'Sonora', 'SON'),
(27, 'Tabasco', 'TAB'),
(28, 'Tamaulipas', 'TAM'),
(29, 'Tlaxcala', 'TLA'),
(30, 'Veracruz', 'VER'),
(31, 'Yucatán', 'YUC'),
(32, 'Zacatecas', 'ZAC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_cloth_types`
--

CREATE TABLE `ufmx_ord_cloth_types` (
  `id` int(11) NOT NULL,
  `name` varchar(65) NOT NULL,
  `color` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_ord_cloth_types`
--

INSERT INTO `ufmx_ord_cloth_types` (`id`, `name`, `color`) VALUES
(1, 'Algodón', 'Blanco'),
(2, 'Algodón', 'Gris'),
(5, 'Mezclilla', 'Azul'),
(4, 'Mezclilla', 'Rosa'),
(3, 'Poliester', 'Rojo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_cloth_types_record_cards`
--

CREATE TABLE `ufmx_ord_cloth_types_record_cards` (
  `id` int(11) NOT NULL,
  `cloth_type_id` int(11) NOT NULL,
  `record_card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_ord_cloth_types_record_cards`
--

INSERT INTO `ufmx_ord_cloth_types_record_cards` (`id`, `cloth_type_id`, `record_card_id`) VALUES
(5, 1, 5),
(17, 1, 18),
(18, 2, 19),
(19, 5, 20),
(20, 5, 21),
(21, 5, 22),
(22, 1, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_delivery_offices`
--

CREATE TABLE `ufmx_ord_delivery_offices` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_ord_delivery_offices`
--

INSERT INTO `ufmx_ord_delivery_offices` (`id`, `name`) VALUES
(1, 'Estafeta'),
(2, 'FedEx');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_orders`
--

CREATE TABLE `ufmx_ord_orders` (
  `id` int(11) NOT NULL,
  `order_number` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `due_date` date NOT NULL,
  `payment_due_date` date DEFAULT NULL,
  `calendar_color` varchar(10) NOT NULL DEFAULT '#000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_ord_orders`
--

INSERT INTO `ufmx_ord_orders` (`id`, `order_number`, `status`, `customer_id`, `warehouse_id`, `user_id`, `creation_timestamp`, `due_date`, `payment_due_date`, `calendar_color`) VALUES
(1, '001-20', 2, 3, 3, 6, '2020-02-24 19:53:45', '2020-03-31', '2020-02-28', '#c02a1e'),
(2, '002-20', 3, 3, 3, 1, '2020-02-25 16:45:19', '2020-03-31', '2020-03-04', '#d7ff00'),
(3, '003-20', 2, 4, 3, 1, '2020-06-22 18:13:50', '2020-07-22', '2020-08-31', '#f87a73'),
(4, '004-20', 2, 3, 3, 4, '2020-09-07 21:50:34', '2020-09-21', '2020-09-18', '#a6aa04'),
(5, '005-20', 1, 3, 3, 4, '2020-10-16 22:28:39', '2020-10-30', '2020-10-31', '#130930'),
(6, '006-20', 1, 6, 3, 4, '2020-10-16 23:19:55', '2020-10-30', '2020-10-31', '#ec4646'),
(7, '007-20', 1, 8, 3, 4, '2020-10-17 00:37:18', '2020-10-30', '2020-10-31', '#37f7f6');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_order_details`
--

CREATE TABLE `ufmx_ord_order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `record_card_id` int(11) NOT NULL,
  `cloth_id` int(11) DEFAULT NULL,
  `description` varchar(75) NOT NULL,
  `size_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `quantity` int(11) NOT NULL,
  `manufacture_quantity` int(11) DEFAULT NULL,
  `purchase_quantity` int(11) DEFAULT NULL,
  `additional_notes` varchar(140) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_ord_order_details`
--

INSERT INTO `ufmx_ord_order_details` (`id`, `order_id`, `product_id`, `record_card_id`, `cloth_id`, `description`, `size_id`, `price`, `quantity`, `manufacture_quantity`, `purchase_quantity`, `additional_notes`) VALUES
(13, 1, 1, 5, NULL, 'Camiseta Polo', 6, 139, 50, 50, 0, ''),
(14, 1, 1, 5, NULL, 'Camiseta Polo', 7, 139, 50, 50, 0, ''),
(15, 1, 1, 5, NULL, 'Camiseta Polo', 8, 139, 50, 50, 0, ''),
(35, 2, 2, 18, NULL, 'Pantalon de trabajo', 6, 214, 20, 20, 0, ''),
(36, 2, 2, 18, 1, 'Pantalon de trabajo', 7, 214, 30, 30, 0, ''),
(37, 2, 2, 18, 1, 'Pantalon de trabajo', 8, 214, 40, 30, 10, ''),
(38, 2, 2, 18, 1, 'Pantalon de trabajo', 9, 214, 50, 40, 10, ''),
(39, 3, 1, 19, NULL, 'Camiseta Polo', 2, 150, 10, 10, 0, ''),
(40, 3, 1, 19, NULL, 'Camiseta Polo', 4, 150, 20, 10, 10, ''),
(41, 3, 1, 19, NULL, 'Camiseta Polo', 6, 150, 30, 20, 10, ''),
(42, 3, 1, 19, NULL, 'Camiseta Polo', 14, 150, 40, 35, 5, ''),
(43, 3, 2, 20, NULL, 'Pantalon de trabajo', 2, 200, 10, 10, 0, ''),
(44, 3, 2, 20, NULL, 'Pantalon de trabajo', 3, 200, 15, 10, 5, ''),
(45, 3, 2, 20, NULL, 'Pantalon de trabajo', 4, 200, 20, 10, 10, ''),
(46, 3, 2, 20, NULL, 'Pantalon de trabajo', 5, 200, 25, 25, 0, ''),
(47, 3, 2, 20, NULL, 'Pantalon de trabajo', 6, 200, 30, 15, 15, ''),
(48, 4, 2, 21, NULL, 'Pantalon de trabajo', 2, 150, 3, 3, 0, ''),
(49, 5, 1, 22, NULL, 'Camiseta Polo', 1, 200, 3, NULL, NULL, ''),
(50, 5, 1, 22, NULL, 'Camiseta Polo', 6, 200, 2, NULL, NULL, ''),
(51, 5, 1, 23, NULL, 'Camiseta Polo', 2, 200, 2, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_order_history`
--

CREATE TABLE `ufmx_ord_order_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `changed_from` int(11) NOT NULL,
  `changed_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_ord_order_history`
--

INSERT INTO `ufmx_ord_order_history` (`id`, `order_id`, `user_id`, `timestamp`, `changed_from`, `changed_to`) VALUES
(1, 1, 1, '2020-02-24 21:26:33', 1, 2),
(2, 2, 1, '2020-02-25 18:42:23', 1, 2),
(3, 2, 1, '2020-02-25 19:48:03', 2, 3),
(4, 3, 1, '2020-06-22 18:19:37', 1, 2),
(5, 4, 4, '2020-09-07 21:55:42', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_payments`
--

CREATE TABLE `ufmx_ord_payments` (
  `id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `paid_date` timestamp NULL DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_purchase_orders`
--

CREATE TABLE `ufmx_ord_purchase_orders` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `requested_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `creation` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_ord_purchase_orders`
--

INSERT INTO `ufmx_ord_purchase_orders` (`id`, `order_id`, `status`, `requested_date`, `arrival_date`, `creation`, `user_id`, `supplier_id`) VALUES
(1, 1, 3, '2020-02-29', '2020-02-24', '2020-02-24 21:30:52', 5, 1),
(2, 1, 1, '2020-02-29', NULL, '2020-02-24 21:30:52', 5, 1),
(3, 2, 4, '2020-03-02', '2020-02-25', '2020-02-25 18:52:50', 1, 1),
(4, 3, 1, '2020-06-27', NULL, '2020-06-22 18:30:37', 1, 1),
(5, 3, 3, '2020-06-27', '2020-06-22', '2020-06-22 18:30:37', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_purchase_order_details`
--

CREATE TABLE `ufmx_ord_purchase_order_details` (
  `id` int(11) NOT NULL,
  `purchase_order_id` int(11) NOT NULL,
  `description` varchar(60) NOT NULL,
  `estimated_cost` float(10,2) DEFAULT NULL,
  `real_cost` float(10,2) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1: Material 2: Part 3: Cloth',
  `size_id` int(11) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `quantity` float(10,2) NOT NULL,
  `cloth_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_ord_purchase_order_details`
--

INSERT INTO `ufmx_ord_purchase_order_details` (`id`, `purchase_order_id`, `description`, `estimated_cost`, `real_cost`, `type`, `size_id`, `unit_id`, `quantity`, `cloth_id`) VALUES
(1, 1, 'Algodon 100% puro', 15.34, 15.34, 1, NULL, 2, 250.00, NULL),
(2, 1, 'Botón plástico blanco ', NULL, 1.12, 2, NULL, 1, 600.00, NULL),
(3, 2, 'Algodon 100% puro', 15.34, NULL, 1, NULL, 2, 250.00, NULL),
(4, 2, 'Botón plástico blanco ', NULL, NULL, 2, NULL, 1, 600.00, NULL),
(5, 3, 'Algodon 100% puro', 15.34, 16.54, 1, NULL, 2, 310.00, NULL),
(6, 3, 'Boton metálico ', 1.50, 1.20, 2, NULL, 1, 120.00, NULL),
(7, 3, 'Pantalon de trabajo talla 38', 99.00, 109.00, 3, 8, 1, 10.00, NULL),
(8, 3, 'Pantalon de trabajo talla 40', 99.00, 109.00, 3, 9, 1, 10.00, NULL),
(9, 4, 'Algodon Baja calidad', 12.45, NULL, 1, NULL, 2, 150.00, NULL),
(10, 4, 'Mezclilla Clásica', 48.55, NULL, 1, NULL, 2, 140.00, NULL),
(11, 4, 'Botón plástico blanco ', NULL, NULL, 2, NULL, 1, 100.00, NULL),
(12, 4, 'Boton metálico ', NULL, NULL, 2, NULL, 1, 70.00, NULL),
(13, 4, 'Cierre de plástico ', NULL, NULL, 2, NULL, 2, 70.00, NULL),
(14, 4, 'Camiseta Polo talla 32', NULL, NULL, 3, 4, 1, 10.00, NULL),
(15, 4, 'Camiseta Polo talla 34', NULL, NULL, 3, 6, 1, 10.00, NULL),
(16, 4, 'Camiseta Polo talla 50', NULL, NULL, 3, 14, 1, 5.00, NULL),
(17, 4, 'Pantalon de trabajo talla 31', NULL, NULL, 3, 3, 1, 5.00, NULL),
(18, 4, 'Pantalon de trabajo talla 32', NULL, NULL, 3, 4, 1, 10.00, NULL),
(19, 4, 'Pantalon de trabajo talla 34', NULL, NULL, 3, 6, 1, 15.00, NULL),
(20, 5, 'Algodon Baja calidad', 12.45, NULL, 1, NULL, 2, 150.00, NULL),
(21, 5, 'Mezclilla Clásica', 48.55, NULL, 1, NULL, 2, 140.00, NULL),
(22, 5, 'Botón plástico blanco ', 15.34, NULL, 2, NULL, 1, 255.00, NULL),
(23, 5, 'Boton metálico ', NULL, NULL, 2, NULL, 1, 70.00, NULL),
(24, 5, 'Cierre de plástico ', NULL, NULL, 2, NULL, 2, 70.00, NULL),
(25, 5, 'Camiseta Polo talla 32', NULL, NULL, 3, 4, 1, 10.00, NULL),
(26, 5, 'Camiseta Polo talla 34', NULL, NULL, 3, 6, 1, 10.00, NULL),
(27, 5, 'Camiseta Polo talla 50', NULL, NULL, 3, 14, 1, 5.00, NULL),
(28, 5, 'Pantalon de trabajo talla 31', NULL, NULL, 3, 3, 1, 5.00, NULL),
(29, 5, 'Pantalon de trabajo talla 32', NULL, NULL, 3, 4, 1, 10.00, NULL),
(30, 5, 'Pantalon de trabajo talla 34', NULL, NULL, 3, 6, 1, 15.00, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_ord_shipments`
--

CREATE TABLE `ufmx_ord_shipments` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_office_id` int(11) NOT NULL,
  `cost` float NOT NULL,
  `delivered_date` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignments`
--

CREATE TABLE `ufmx_prod_assignments` (
  `id` int(11) NOT NULL,
  `order_detail_id` int(11) NOT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `assigned_by` int(11) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `quantity` float(10,2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `assigned_timestamp` timestamp NULL DEFAULT NULL,
  `estimated_finish_date` date DEFAULT NULL,
  `real_finish_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_prod_assignments`
--

INSERT INTO `ufmx_prod_assignments` (`id`, `order_detail_id`, `assigned_to`, `assigned_by`, `type`, `quantity`, `status`, `created_timestamp`, `assigned_timestamp`, `estimated_finish_date`, `real_finish_date`) VALUES
(1, 13, 4, 1, 1, 50.00, 1, '2020-02-24 21:53:29', NULL, NULL, NULL),
(2, 14, 4, 1, 1, 50.00, 1, '2020-02-24 21:53:29', NULL, NULL, NULL),
(3, 15, 4, 1, 1, 50.00, 1, '2020-02-24 21:53:29', NULL, NULL, NULL),
(13, 35, 4, 1, 1, 20.00, 1, '2020-02-26 21:10:18', NULL, NULL, NULL),
(14, 36, 4, 1, 1, 30.00, 1, '2020-02-26 21:10:18', NULL, NULL, NULL),
(15, 37, 4, 1, 1, 20.00, 1, '2020-02-26 21:10:18', NULL, NULL, NULL),
(16, 37, 3, 1, 4, 20.00, 1, '2020-02-26 21:10:18', NULL, NULL, NULL),
(17, 38, 4, 1, 1, 40.00, 1, '2020-02-26 21:10:18', NULL, NULL, NULL),
(18, 38, 3, 1, 4, 10.00, 1, '2020-02-26 21:10:18', NULL, NULL, NULL),
(19, 35, 4, 1, 1, 20.00, 1, '2020-04-22 17:42:40', NULL, NULL, NULL),
(20, 36, 4, 1, 1, 30.00, 1, '2020-04-22 17:42:40', NULL, NULL, NULL),
(21, 37, 4, 1, 1, 20.00, 1, '2020-04-22 17:42:40', NULL, NULL, NULL),
(22, 37, 13, 1, 1, 20.00, 1, '2020-04-22 17:42:40', NULL, NULL, NULL),
(23, 38, 4, 1, 1, 25.00, 1, '2020-04-22 17:42:40', NULL, NULL, NULL),
(24, 38, 13, 1, 1, 25.00, 1, '2020-04-22 17:42:40', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignment_inventory`
--

CREATE TABLE `ufmx_prod_assignment_inventory` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `quantity` float(10,2) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `raw_material_id` int(11) DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL,
  `cloth_id` int(11) DEFAULT NULL,
  `bundle_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_prod_assignment_inventory`
--

INSERT INTO `ufmx_prod_assignment_inventory` (`id`, `assignment_id`, `quantity`, `type`, `raw_material_id`, `part_id`, `cloth_id`, `bundle_id`) VALUES
(1, 1, 200.00, 2, NULL, 2, NULL, NULL),
(2, 1, 100.00, 1, 2, NULL, NULL, NULL),
(3, 2, 200.00, 2, NULL, 2, NULL, NULL),
(4, 2, 100.00, 1, 2, NULL, NULL, NULL),
(5, 3, 200.00, 2, NULL, 2, NULL, NULL),
(6, 3, 100.00, 1, 2, NULL, NULL, NULL),
(20, 13, 20.00, 2, NULL, 4, NULL, NULL),
(21, 13, 60.00, 1, 2, NULL, NULL, NULL),
(22, 14, 30.00, 2, NULL, 4, NULL, NULL),
(23, 14, 90.00, 1, 2, NULL, NULL, NULL),
(24, 15, 20.00, 2, NULL, 4, NULL, NULL),
(25, 15, 60.00, 1, 2, NULL, NULL, NULL),
(26, 16, 20.00, 3, NULL, NULL, 1, NULL),
(27, 17, 40.00, 2, NULL, 4, NULL, NULL),
(28, 17, 120.00, 1, 2, NULL, NULL, NULL),
(29, 18, 10.00, 3, NULL, NULL, 1, NULL),
(49, 1, 10.00, 1, NULL, NULL, NULL, NULL),
(50, 19, 20.00, 2, NULL, 4, NULL, NULL),
(51, 19, 60.00, 1, 2, NULL, NULL, NULL),
(52, 20, 30.00, 2, NULL, 4, NULL, NULL),
(53, 20, 60.00, 1, 2, NULL, NULL, NULL),
(54, 21, 20.00, 2, NULL, 4, NULL, NULL),
(55, 21, 0.00, 1, 2, NULL, NULL, NULL),
(56, 22, 20.00, 2, NULL, 4, NULL, NULL),
(57, 22, 0.00, 1, 2, NULL, NULL, NULL),
(58, 23, 0.00, 2, NULL, 4, NULL, NULL),
(59, 23, 0.00, 1, 2, NULL, NULL, NULL),
(60, 24, 0.00, 2, NULL, 4, NULL, NULL),
(61, 24, 0.00, 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignment_meta`
--

CREATE TABLE `ufmx_prod_assignment_meta` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `meta_key_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignment_meta_keys`
--

CREATE TABLE `ufmx_prod_assignment_meta_keys` (
  `id` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_prod_assignment_meta_keys`
--

INSERT INTO `ufmx_prod_assignment_meta_keys` (`id`, `key`, `name`, `description`) VALUES
(1, 'draw_lenght', 'Medida del trazo', 'En cm'),
(2, 'repeat', 'No. de repeticiones', 'Sólo números'),
(3, 'cloth_width', 'Ancho de tela', 'En cm'),
(4, 'bundles', 'Bultos', 'Número de bultos generados'),
(5, 'pieces_per_bundle', 'Piezas por bulto', 'Número de piezas que contiene cada bulto'),
(6, 'packages', 'Paquetes', 'Numero de paquetes de prendas'),
(7, 'pieces_per_package', 'Piezas por paquete', 'Número de piezas (prendas) que contiene un paquete');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignment_processes`
--

CREATE TABLE `ufmx_prod_assignment_processes` (
  `id` int(10) NOT NULL,
  `type_id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_prod_assignment_processes`
--

INSERT INTO `ufmx_prod_assignment_processes` (`id`, `type_id`, `name`, `description`) VALUES
(1, 4, 'Bordado', 'Se bordan cosas supongo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignment_progress`
--

CREATE TABLE `ufmx_prod_assignment_progress` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_timestamp` timestamp NULL DEFAULT NULL,
  `quantity` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_prod_assignment_type_meta`
--

CREATE TABLE `ufmx_prod_assignment_type_meta` (
  `id` int(11) NOT NULL,
  `meta_key_id` int(11) NOT NULL,
  `assignment_type` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ufmx_prod_assignment_type_meta`
--

INSERT INTO `ufmx_prod_assignment_type_meta` (`id`, `meta_key_id`, `assignment_type`) VALUES
(1, 1, 2),
(2, 2, 2),
(3, 3, 2),
(4, 6, 5),
(5, 7, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_usr_privileges`
--

CREATE TABLE `ufmx_usr_privileges` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(128) NOT NULL,
  `controller` varchar(45) NOT NULL,
  `action` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_usr_privileges`
--

INSERT INTO `ufmx_usr_privileges` (`id`, `name`, `description`, `controller`, `action`) VALUES
(1, 'list_users', 'Ver usuarios', 'user', 'index'),
(3, 'delete_user', 'Eliminar usuarios', 'user', 'delete'),
(4, 'edit_user', 'Modificar usuarios', 'user', 'update'),
(5, 'create_user', 'Crear usuarios', 'user', 'create'),
(6, 'privilege_create', 'Crear permisos', 'privileges', 'create'),
(7, 'delete_privilege', 'Eliminar permisos', 'privileges', 'delete'),
(8, 'list_customers', 'Ver clientes', 'customers', 'index'),
(9, 'list_privileges', 'Ver permisos', 'privileges', 'index'),
(10, 'edit_privilege', 'Editar permisos', 'privileges', 'update'),
(11, 'list_cloth_entries', 'Ver entradas de prendas', 'cloth-entries', 'index'),
(12, 'create_clothes_entries', 'Crear entradas de prendas', 'cloth-entries', 'create'),
(13, 'revert_cloth_entries', 'Revertir entradas de prendas', 'cloth-entries', 'delete'),
(14, 'list_clothes', 'Listar prendas', 'clothes', 'index'),
(15, 'create_clothes', 'Crear prendas', 'clothes', 'create'),
(16, 'edit_clothes', 'Editar prendas', 'clothes', 'update'),
(17, 'view_clothes', 'Ver prendas', 'clothes', 'view'),
(18, 'delete_clothes', 'Eliminar prendas', 'clothes', 'delete'),
(19, 'create_order', 'Crear ordenes', 'orders', 'create'),
(20, 'delete_record_cards', 'Eliminar fichas', 'record-cards', 'delete'),
(21, 'list_roles', 'Ver roles', 'roles', 'index'),
(22, 'view_products', 'Ver productos', 'products', 'index'),
(23, 'view_raw_materials', 'Ver materiales', 'material', 'index'),
(24, 'view_parts', 'Ver avíos', 'parts', 'index'),
(25, 'view_suppliers', 'Ver proveedores', 'suppliers', 'index'),
(26, 'view_payments', 'Ver pagos', 'payments', 'index'),
(27, 'view_shipments', 'Ver envíos', 'shipments', 'index'),
(29, 'view_assignments', 'Ver asignaciones', 'assignments', 'index'),
(30, 'edit_order', 'Editar ordenes', 'orders', 'update'),
(31, 'list_purchase_orders', 'Ver ordenes de compra', 'purchase-orders', 'index'),
(32, 'list_orders', 'Ver ordenes', 'orders', 'index'),
(33, 'pending_assignments', 'Ver asignaciones pendientes', 'assignments', 'assigned'),
(34, 'create_assignments', 'Crear asignaciones', 'assignments', 'create'),
(35, 'view_order_progress', 'Seguimiento de orden', 'orders', 'view'),
(36, 'create_purchase_orders', 'Crear ordenes de compra', 'purchase-orders', 'create'),
(37, 'create_entry_for_purchase_order', 'Crear entrada para orden de compra', 'purchase-orders', 'create-entry'),
(38, 'view_purchase_orders', 'Ver progreso de orden de compra', 'purchase-orders', 'view'),
(39, 'list_order_details', 'Ver detalles de orden', 'order-details', 'index'),
(40, 'create_order_details', 'Crear detalle de orden', 'order-details', 'create'),
(41, 'confirm_order', 'Confirmar orden', 'orders', 'confirm'),
(42, 'supply_order', 'Surtir orden', 'orders', 'supply'),
(43, 'assignment_history', 'Ver historial de progreso de asignaciones', 'assignment-progress', 'index'),
(44, 'cancel_purchase_orders', 'Cancelar ordenes de compra', 'purchase-orders', 'cancel'),
(45, 'confirm_purchase_orders', 'Confirmar ordenes de compra', 'purchase-orders', 'confirm'),
(46, 'purchase_orders_reception', 'Recepción de orden de compra', 'purchase-orders', 'reception'),
(47, 'create_entry_purchase_order', 'Crear entrada de orden de compra', 'purchase-orders', 'createentry'),
(48, 'create_transfers', 'Crear transferencias', 'transfers', 'create'),
(49, 'complete_transfer', 'Completar transferencia', 'transfers', 'complete');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_usr_roles`
--

CREATE TABLE `ufmx_usr_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `common_name` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_usr_roles`
--

INSERT INTO `ufmx_usr_roles` (`id`, `name`, `common_name`) VALUES
(1, 'superadmin', 'Súper Admin'),
(2, 'admin', 'Admin'),
(3, 'operator', 'Maquilador'),
(4, 'finance_manager', 'Admin de Finanzas'),
(5, 'shipping_manager', 'Admin de Envíos'),
(6, 'cutter', 'Cortador'),
(7, 'buyer', 'Compras'),
(8, 'seller', 'Vendedor'),
(9, 'storage', 'Almacen'),
(10, 'prod_admin', 'Admin de produccion'),
(11, 'storage_admin', 'Admin de almacén'),
(12, 'purchases_admin', 'Admin. Compras'),
(13, 'supad', 'supad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_usr_role_privileges`
--

CREATE TABLE `ufmx_usr_role_privileges` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_usr_role_privileges`
--

INSERT INTO `ufmx_usr_role_privileges` (`id`, `role_id`, `privilege_id`) VALUES
(1, 1, 1),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(9, 1, 8),
(10, 1, 9),
(11, 1, 10),
(12, 1, 3),
(13, 1, 14),
(14, 1, 19),
(15, 1, 20),
(16, 1, 18),
(17, 1, 15),
(18, 1, 21),
(19, 1, 11),
(20, 1, 12),
(21, 1, 13),
(22, 1, 16),
(23, 1, 17),
(24, 1, 22),
(25, 1, 23),
(26, 1, 24),
(27, 1, 25),
(28, 1, 26),
(29, 1, 27),
(31, 1, 29),
(32, 1, 30),
(33, 8, 32),
(34, 8, 30),
(35, 8, 19),
(36, 8, 8),
(37, 1, 31),
(38, 1, 32),
(39, 1, 33),
(40, 1, 34),
(41, 1, 35),
(42, 7, 31),
(43, 7, 36),
(44, 9, 37),
(45, 9, 12),
(46, 9, 31),
(47, 9, 38),
(48, 7, 38),
(49, 8, 39),
(50, 8, 40),
(52, 7, 42),
(54, 7, 32),
(55, 7, 39),
(56, 1, 36),
(57, 1, 37),
(58, 1, 38),
(59, 1, 39),
(60, 1, 40),
(61, 1, 41),
(62, 1, 42),
(63, 10, 32),
(64, 10, 39),
(65, 10, 34),
(66, 6, 33),
(67, 9, 33),
(68, 9, 35),
(69, 11, 37),
(70, 11, 12),
(71, 11, 31),
(72, 11, 38),
(73, 11, 33),
(74, 11, 35),
(75, 11, 14),
(76, 11, 15),
(77, 11, 11),
(78, 11, 16),
(79, 11, 18),
(80, 11, 24),
(81, 11, 22),
(82, 11, 23),
(83, 11, 20),
(84, 7, 41),
(85, 12, 31),
(86, 12, 38),
(87, 12, 36),
(88, 12, 45),
(89, 12, 44),
(90, 12, 25),
(91, 12, 46),
(92, 12, 47),
(93, 12, 37),
(94, 12, 39),
(95, 1, 43),
(96, 1, 45),
(97, 1, 46),
(98, 1, 47),
(99, 1, 44),
(100, 1, 48),
(101, 1, 49),
(102, 13, 1),
(103, 13, 8),
(105, 13, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_usr_users`
--

CREATE TABLE `ufmx_usr_users` (
  `id` int(11) NOT NULL,
  `user` varchar(16) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `birthday` date DEFAULT NULL,
  `authKey` varchar(128) NOT NULL,
  `access_token` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_usr_users`
--

INSERT INTO `ufmx_usr_users` (`id`, `user`, `password`, `email`, `first_name`, `last_name`, `birthday`, `authKey`, `access_token`) VALUES
(1, 'poncho', 'poncho', 'alfonso@ceosnm.com', 'Alfonso', 'Pedroza', '1995-11-19', 'urj394rj3e0ifje', 'difsodfno2jenfj'),
(2, 'finance_admin', '$2y$10$4b7SxDQztlsKbjHYX2mCEeIAb7iHFU4ipCq75JqaWnUYJBd0JD2x2', 'finance@uniformex.com', 'Carlos', 'Esparza', '1993-07-06', '868330f373f7b9e966dd983d67320611cd377f30864c85436afebcbad39565b26b414970551820dea980f6affc29132d1e35aa2c6165d3874dd2e23f3cde517e', 'd1a948e457d8243ad889fd2735a46c1260505e9dd192ad7d5ae7be3112eba4f5c8729543ad7ce1b795c229853e7f453b297fe8950f028dff047f00e462970359'),
(3, 'maquilator01', '$2y$10$NUiofSONR/4goO5kwAnAcOCKSoJpCax7Ucz7UZgYMBv./7mkUh486', 'm@quila.tor', 'Pedro', 'Páramo', NULL, '6a0faf1949042b8f0676055ce890a9e9ce56385a7c467632f83884cfd339478d4cf69ead149ae25b94de196f9de056f833ecad626e7302a909d3f019009aa94e', '9387230f5a23bc27c4006333dbeacc79113974b2471e6aaf3ee06063fa90a8bb14883fd33c3cf0a056388f571b6ab986480e6f5e8e455501342823202da2a3e1'),
(4, 'corte', '$2y$10$qI6Mwj33yejrNgDgH4gQ9.HDWNeweT6YnAonTTQZQRxHg2gGRwAOi', 'cortador01@mail.com', 'Agustin', 'Fuentes', '1963-01-17', '1d5c91af27632d5e07baf22724646ea0a945d62573f21fa50d1369dc9291092216fe45412605bc1ff872ac88b225c8769030c5be5386448c897e471e3d592a88', '32ab01fce2e4bc8f769556d19d0d3b3933d21184b2c7995919a594beee12ed89086e012a18a0a1449c2c1005ef44e037c3ee46d278e43aa417e83870e00afc5b'),
(5, 'compras', '$2y$10$nWC6bRd/J2iMAuY.gxFoSeBrMy24PVPCh1H/EdpkFnZRkW8udffCu', 'compras@uniformex.com', 'Compras', 'Hernandez', '2020-01-22', '47e415cdc8a0dbc5f57e4c149cee871a02474107eea598f3d78e7dded3c417a80197eb4d785c5bc47aad7d47fb15abe521a9a01a4438c08a97212c36d71770c3', '4402e73249e7c62aba5d76d588bde153081f8864f0128f1090cceac862f5199742aa93b868ed0f8f149ba07611dd27cc41223add91a2450b71334856e5ada605'),
(6, 'ventas', '$2y$10$r45hqMZtiznxGFq4lnXaauI2IqV7xhAnk.Y4XmMKyY7M5JjIt5hM.', 'ventas@uniformex.com', 'Ventas', 'Martinez', NULL, '1e90a49c310bfcf7d834afff69398c52c79e18fc7fc7a91e5e8e36607674ebdc01afa6bd3013c2a27389a4f8494d3caadefec9ad7accc21cbbc4513add718ccc', '40704c0a135cd3c3f000c89f755690d35093fe122e64ee9a8f190e1b56604587cb57e70f73fb15a4344ba315da636cc20ca28a33bd5d9f756349210d68c74d80'),
(7, 'prodadmin', '$2y$10$DMxxzk8HWO01IaQtJgeq2O2D7ArrCu8KyArhayvM10qXLX92mpIz.', 'produccion@uniformex.com', 'Admin de', 'Produccion', NULL, '7ac45bf6b6f2dcce2f994e8e15cce0ce2107bc4f4b72c7b961eae49f60fe5c1baed68b32140244ab1e3ffec664e0be73bb5ba0ba8a6b0af88476c29045a9aaf0', '3ee2a876d1bf64387699a038f4cc4e36583c35c277871b012777a4e875f95c38f27e769b57ad8a31813da21eeb8c071e3c72d3b802385566f27149d0f6ef5e04'),
(8, 'almacen', '$2y$10$hF10Oiw40WboxL3V1scMr.boLojIOegqBqUtUZAS928yGkXjQOvPm', 'almacen@uniformex.com', 'Almacenista', 'Almacen', '1969-01-30', '0206d458142e651b11881f3dd13ee9cec3a9cb3128efe0216b508cb4ed8ad8bceb548d315f0d41ac5e48c4797ed3379d92b76bb8dfa48bfe11ef934e3f4dc544', 'ad95214caa58125f6e14e0270c59f616420d06cb10209330703d1dc98905b1c4225a783a59e5ce5fbfb152611dd4f9687413a0854179720189b6100fd2d3acad'),
(10, 'system', 'system', 'sys@ufmx.com', 'SYSTEM', '32', NULL, 'does_not_have', 'does_not_have'),
(11, 'admin_almacen', '$2y$10$bXxtD8pgPRxdASYTNRiINOrE1b3DyKDQkmiPHBUgq7fx/G7Pw8CMm', 'admin_almacen@uniformex.com.mx', 'Almacen', 'Admin', NULL, 'c3359614be371b3b06cbe7f1afec6f5254038dd0aa64036145728f6f790f5a66a3a90a54da929a3728987f12275a31129be613ac68cba3c9f435c78d2f661e98', '7f577dc522994b05b3e2f110781250b14fe952e21f2658e389fb9a7863b52ae8682831dc56ca6e5bc02a5fda9d5cc9b1b7af16b30d71ffdfcb59ccee65e52f56'),
(12, 'admin_compras', '$2y$10$QTI5xsZv.7QmYDQiUKWuh.usXOjKTGatprzF1NRvZotcHNu.4ia0O', 'admin_compras@uniformex.com.mx', 'Compras', 'Admin', NULL, '140671b6d6db3205f7000e2a792a0e73b12a3e39648709baf7679527a292572a74cbb5c3d0fbf81b650b3d5e655c334651750e21d86603e548e2d34a8d12ee42', '3b5807656257c5da641f753149c139b60676eb1172d9c6742f246fb2f6a60d69454c2e053c46083e3f68e8e3f544cecf9f0bb157455919a167bfb3d82760afcc'),
(13, 'corte2', '$2y$10$YSf6mSpvehwS3SUeHKUWLeQiO5ObD5TkiX2bsuQPNPqAtJY47AxSi', 'cortadordos@mailer.com', 'Albert', 'Camus', '1955-11-07', 'bdf8bbd6e7bda61403636e9050dcd5d608935d7e48540937a8a1934f0dbe2f094e910a212f595c23331f2d8f9ae8af7320705fa0ccf41213f5c3ea84cf5eeb41', '3ef0b7d8815087bbc0dda64536c8d4bea0ae000559c2e26c194d73bcb51f1f677779c2616db2a49dbe7411ee2e778273d7d106c6f4c305e0ecbd448d7ea0a9b0'),
(15, 'Juan', '$2y$10$LmZJHypaXjs/Q0mUESpaUuM7Fho1wYkZwcioZM3YlSHW3tmoHnNR2', 'juan@unif.com', 'Juan', 'Juan', NULL, '4a81db9c481d4125d849b278d0b945aff576f8fdc33226bbeb014cfe670c82663059b8506d4ea18b5a42cd58e9a71b345eb0c47dab0c23165f5a7b96ee44e0ed', '7fa2de1b737f85d5129fae05537a0e6dcfe1ac93e738b5b06db0af2088189483d4145c3e1da69b9c2559b798eb4717e3d57cee514b9bf4de5e8237395eac4c82');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_usr_users_privileges`
--

CREATE TABLE `ufmx_usr_users_privileges` (
  `id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_usr_users_privileges`
--

INSERT INTO `ufmx_usr_users_privileges` (`id`, `privilege_id`, `user_id`) VALUES
(1, 1, 1),
(2, 1, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ufmx_usr_users_roles`
--

CREATE TABLE `ufmx_usr_users_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ufmx_usr_users_roles`
--

INSERT INTO `ufmx_usr_users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(4, 2, 4),
(5, 3, 3),
(6, 4, 6),
(7, 6, 8),
(8, 5, 7),
(9, 8, 9),
(10, 7, 10),
(11, 11, 11),
(12, 12, 12),
(13, 13, 6),
(20, 4, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ufmx_customer_contacts`
--
ALTER TABLE `ufmx_customer_contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indices de la tabla `ufmx_cxs_customers`
--
ALTER TABLE `ufmx_cxs_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`alias`),
  ADD KEY `register_time` (`register_time`),
  ADD KEY `last_updated` (`last_updated`);
ALTER TABLE `ufmx_cxs_customers` ADD FULLTEXT KEY `name` (`name`);

--
-- Indices de la tabla `ufmx_cxs_customer_addresses`
--
ALTER TABLE `ufmx_cxs_customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_cxs_customer_addresses_ufmx_misc_states1_idx` (`state_id`),
  ADD KEY `fk_ufmx_cxs_customer_addresses_ufmx_misc_cities1_idx` (`city_id`),
  ADD KEY `fk_ufmx_cxs_customer_addresses_ufmx_cxs_customers1_idx` (`customer_id`),
  ADD KEY `alias` (`alias`),
  ADD KEY `street` (`street`),
  ADD KEY `number` (`int_num`),
  ADD KEY `section` (`section`),
  ADD KEY `country` (`country`),
  ADD KEY `zip` (`zip_code`);

--
-- Indices de la tabla `ufmx_inv_bundles`
--
ALTER TABLE `ufmx_inv_bundles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_bundles_ufmx_prod_assignment_progress1_idx` (`assignment_progress_id`);

--
-- Indices de la tabla `ufmx_inv_bundles_warehouses`
--
ALTER TABLE `ufmx_inv_bundles_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_bundles_warehouses_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `fk_ufmx_inv_bundles_warehouses_ufmx_inv_bundles1_idx` (`bundle_id`);

--
-- Indices de la tabla `ufmx_inv_clothes`
--
ALTER TABLE `ufmx_inv_clothes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `part_number_UNIQUE` (`part_number`),
  ADD KEY `name` (`name`),
  ADD KEY `cost` (`profit_margin`),
  ADD KEY `fk_ufmx_inv_clothes_ufmx_inv_record_cards1_idx` (`record_card_id`);

--
-- Indices de la tabla `ufmx_inv_clothes_warehouses`
--
ALTER TABLE `ufmx_inv_clothes_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_register` (`cloth_id`,`warehouse_id`,`size_id`),
  ADD KEY `fk_ufmx_inv_clothes_warehouses_ufmx_inv_clothes1_idx` (`cloth_id`),
  ADD KEY `fk_ufmx_inv_clothes_warehouses_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `fk_ufmx_inv_clothes_warehouses_ufmx_inv_sizes1_idx` (`size_id`);

--
-- Indices de la tabla `ufmx_inv_cloth_entries`
--
ALTER TABLE `ufmx_inv_cloth_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_cloth_entries_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `fk_ufmx_inv_cloth_entries_ufmx_inv_clothes1_idx` (`cloth_id`),
  ADD KEY `fk_ufmx_inv_cloth_entries_ufmx_usr_users1_idx` (`user_id`),
  ADD KEY `fk_ufmx_inv_cloth_entries_ufmx_inv_suppliers1_idx` (`supplier_id`),
  ADD KEY `fk_ufmx_inv_cloth_entries_ufmx_inv_sizes1_idx` (`size_id`),
  ADD KEY `fk_ufmx_inv_cloth_entries_ufmx_ord_purchase_order_details1_idx` (`purchase_order_detail_id`);

--
-- Indices de la tabla `ufmx_inv_material_warehouses`
--
ALTER TABLE `ufmx_inv_material_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_register` (`warehouse_id`,`material_id`),
  ADD KEY `fk_ufmx_inv_material_almacenes_ufmx_inv_material1_idx` (`material_id`),
  ADD KEY `fk_ufmx_inv_material_almacenes_ufmx_inv_almacenes1_idx` (`warehouse_id`),
  ADD KEY `stock` (`stock`);

--
-- Indices de la tabla `ufmx_inv_parts`
--
ALTER TABLE `ufmx_inv_parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `part_number_UNIQUE` (`part_number`),
  ADD KEY `fk_ufmx_inv_parts_ufmx_inv_units1_idx` (`unit_id`),
  ADD KEY `index3` (`name`),
  ADD KEY `index4` (`description`);

--
-- Indices de la tabla `ufmx_inv_part_entries`
--
ALTER TABLE `ufmx_inv_part_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_part_entries_ufmx_inv_parts1_idx` (`part_id`),
  ADD KEY `fk_ufmx_inv_part_entries_ufmx_usr_users1_idx` (`user_id`),
  ADD KEY `fk_ufmx_inv_part_entries_ufmx_inv_suppliers1_idx` (`supplier_id`),
  ADD KEY `fk_ufmx_inv_part_entries_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `fk_ufmx_inv_part_entries_ufmx_ord_purchase_order_details1_idx` (`purchase_order_detail_id`);

--
-- Indices de la tabla `ufmx_inv_part_warehouses`
--
ALTER TABLE `ufmx_inv_part_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_register` (`part_id`,`warehouse_id`),
  ADD KEY `fk_ufmx_inv_part_warehouses_ufmx_inv_parts1_idx` (`part_id`),
  ADD KEY `fk_ufmx_inv_part_warehouses_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `stock` (`stock`);

--
-- Indices de la tabla `ufmx_inv_pieces`
--
ALTER TABLE `ufmx_inv_pieces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indices de la tabla `ufmx_inv_products`
--
ALTER TABLE `ufmx_inv_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`model`),
  ADD KEY `index3` (`description`);

--
-- Indices de la tabla `ufmx_inv_product_pieces`
--
ALTER TABLE `ufmx_inv_product_pieces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_product_pieces_ufmx_inv_pieces1_idx` (`piece_id`),
  ADD KEY `fk_ufmx_inv_product_pieces_ufmx_inv_products1_idx` (`product_id`);

--
-- Indices de la tabla `ufmx_inv_raw_material`
--
ALTER TABLE `ufmx_inv_raw_material`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `part_number_UNIQUE` (`part_number`),
  ADD KEY `fk_ufmx_inv_material_ufmx_inv_unidades_idx` (`unit_id`),
  ADD KEY `name` (`name`),
  ADD KEY `color` (`color`),
  ADD KEY `cost` (`name`);
ALTER TABLE `ufmx_inv_raw_material` ADD FULLTEXT KEY `description` (`description`);

--
-- Indices de la tabla `ufmx_inv_raw_material_entries`
--
ALTER TABLE `ufmx_inv_raw_material_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_stock_entries_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `fk_ufmx_inv_raw_material_entries_ufmx_inv_raw_material1_idx` (`raw_material_id`),
  ADD KEY `fk_ufmx_inv_raw_material_entries_ufmx_usr_users1_idx` (`user_id`),
  ADD KEY `fk_ufmx_inv_raw_material_entries_ufmx_inv_suppliers1_idx` (`supplier_id`),
  ADD KEY `fk_ufmx_inv_raw_material_entries_ufmx_ord_purchase_order_de_idx` (`purchase_order_detail_id`);

--
-- Indices de la tabla `ufmx_inv_record_cards`
--
ALTER TABLE `ufmx_inv_record_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model_UNIQUE` (`model`),
  ADD KEY `fk_ufmx_inv_record_cards_ufmx_inv_products1_idx` (`product_id`),
  ADD KEY `index3` (`model`);

--
-- Indices de la tabla `ufmx_inv_record_card_components`
--
ALTER TABLE `ufmx_inv_record_card_components`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_record_card_components_ufmx_inv_record_cards1_idx` (`record_card_id`),
  ADD KEY `fk_ufmx_inv_record_card_components_ufmx_inv_raw_material1_idx` (`material_id`);

--
-- Indices de la tabla `ufmx_inv_record_card_designs`
--
ALTER TABLE `ufmx_inv_record_card_designs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_record_card_designs_ufmx_inv_record_cards1_idx` (`record_card_id`);

--
-- Indices de la tabla `ufmx_inv_record_card_parts`
--
ALTER TABLE `ufmx_inv_record_card_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_record_card_parts_ufmx_inv_record_cards1_idx` (`record_card_id`),
  ADD KEY `fk_ufmx_inv_record_card_parts_ufmx_inv_parts1_idx` (`part_id`);

--
-- Indices de la tabla `ufmx_inv_record_card_pieces`
--
ALTER TABLE `ufmx_inv_record_card_pieces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_record_card_pieces_ufmx_inv_record_cards1_idx` (`record_card_id`),
  ADD KEY `index3` (`description`);

--
-- Indices de la tabla `ufmx_inv_semi_clothes`
--
ALTER TABLE `ufmx_inv_semi_clothes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `size` (`size`),
  ADD KEY `fk_ufmx_inv_semi_clothes_ufmx_prod_line_history1_idx` (`line_history_id`);
ALTER TABLE `ufmx_inv_semi_clothes` ADD FULLTEXT KEY `description` (`description`);

--
-- Indices de la tabla `ufmx_inv_sizes`
--
ALTER TABLE `ufmx_inv_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`name`);

--
-- Indices de la tabla `ufmx_inv_suppliers`
--
ALTER TABLE `ufmx_inv_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`name`),
  ADD KEY `index3` (`contact_name`),
  ADD KEY `index4` (`phone`),
  ADD KEY `index5` (`email`);

--
-- Indices de la tabla `ufmx_inv_transfers`
--
ALTER TABLE `ufmx_inv_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_inv_transfers_ufmx_prod_assignment_inventory1_idx` (`assignment_inventory_id`),
  ADD KEY `fk_ufmx_inv_transfers_ufmx_inv_clothes_warehouses1_idx` (`cloth_warehouse_id`),
  ADD KEY `fk_ufmx_inv_transfers_ufmx_inv_part_warehouses1_idx` (`part_warehouse_id`),
  ADD KEY `fk_ufmx_inv_transfers_ufmx_inv_material_warehouses1_idx` (`material_warehouse_id`);

--
-- Indices de la tabla `ufmx_inv_units`
--
ALTER TABLE `ufmx_inv_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `short_name` (`name`);

--
-- Indices de la tabla `ufmx_inv_warehouses`
--
ALTER TABLE `ufmx_inv_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `street` (`street`),
  ADD KEY `number` (`number`),
  ADD KEY `section` (`section`),
  ADD KEY `zip` (`zip_code`),
  ADD KEY `fk_ufmx_inv_warehouses_ufmx_misc_states1_idx` (`state_id`),
  ADD KEY `fk_ufmx_inv_warehouses_ufmx_misc_cities1_idx` (`city_id`);

--
-- Indices de la tabla `ufmx_misc_cities`
--
ALTER TABLE `ufmx_misc_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `fk_ufmx_misc_cities_ufmx_misc_states1_idx` (`state_id`);

--
-- Indices de la tabla `ufmx_misc_quotations`
--
ALTER TABLE `ufmx_misc_quotations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_misc_quotations_ufmx_cxs_customer_addresses1_idx` (`customer_id`),
  ADD KEY `fk_ufmx_misc_quotations_ufmx_usr_users1_idx` (`user_id`);

--
-- Indices de la tabla `ufmx_misc_quotation_details`
--
ALTER TABLE `ufmx_misc_quotation_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_misc_quotation_details_ufmx_misc_quotations1_idx` (`quotation_id`),
  ADD KEY `color` (`color`),
  ADD KEY `size` (`size`),
  ADD KEY `price` (`price`),
  ADD KEY `quantity` (`quantity`),
  ADD KEY `custom` (`customization`);
ALTER TABLE `ufmx_misc_quotation_details` ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `ufmx_misc_quotation_details` ADD FULLTEXT KEY `notes` (`additional_notes`);

--
-- Indices de la tabla `ufmx_misc_states`
--
ALTER TABLE `ufmx_misc_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `short_name` (`short_name`);

--
-- Indices de la tabla `ufmx_ord_cloth_types`
--
ALTER TABLE `ufmx_ord_cloth_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index4` (`name`,`color`),
  ADD KEY `index2` (`name`),
  ADD KEY `index3` (`color`);

--
-- Indices de la tabla `ufmx_ord_cloth_types_record_cards`
--
ALTER TABLE `ufmx_ord_cloth_types_record_cards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ord_cloth_types_record_cards_ufmx_ord_cloth_types1_idx` (`cloth_type_id`),
  ADD KEY `fk_ufmx_ord_cloth_types_record_cards_ufmx_inv_record_cards1_idx` (`record_card_id`);

--
-- Indices de la tabla `ufmx_ord_delivery_offices`
--
ALTER TABLE `ufmx_ord_delivery_offices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`);

--
-- Indices de la tabla `ufmx_ord_orders`
--
ALTER TABLE `ufmx_ord_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ped_pedidos_ufmx_cli_customers1_idx` (`customer_id`),
  ADD KEY `payment_due` (`payment_due_date`),
  ADD KEY `order_number` (`order_number`),
  ADD KEY `fk_ufmx_ord_orders_ufmx_inv_warehouses1_idx` (`warehouse_id`),
  ADD KEY `fk_ufmx_ord_orders_ufmx_usr_users1_idx` (`user_id`);

--
-- Indices de la tabla `ufmx_ord_order_details`
--
ALTER TABLE `ufmx_ord_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ord_order_details_ufmx_ord_orders1_idx` (`order_id`),
  ADD KEY `price` (`price`),
  ADD KEY `fk_ufmx_ord_order_details_ufmx_inv_products1_idx` (`product_id`),
  ADD KEY `fk_ufmx_ord_order_details_ufmx_inv_record_cards1_idx` (`record_card_id`),
  ADD KEY `fk_ufmx_ord_order_details_ufmx_inv_sizes1_idx` (`size_id`),
  ADD KEY `fk_ufmx_ord_order_details_ufmx_inv_clothes1_idx` (`cloth_id`);
ALTER TABLE `ufmx_ord_order_details` ADD FULLTEXT KEY `description` (`description`);
ALTER TABLE `ufmx_ord_order_details` ADD FULLTEXT KEY `notes` (`additional_notes`);

--
-- Indices de la tabla `ufmx_ord_order_history`
--
ALTER TABLE `ufmx_ord_order_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ord_order_history_ufmx_ord_orders1_idx` (`order_id`),
  ADD KEY `timestamp` (`timestamp`),
  ADD KEY `changed_from` (`changed_from`),
  ADD KEY `changed_to` (`changed_to`),
  ADD KEY `from_to` (`changed_from`,`changed_to`),
  ADD KEY `fk_ufmx_ord_order_history_ufmx_usr_users1_idx` (`user_id`);

--
-- Indices de la tabla `ufmx_ord_payments`
--
ALTER TABLE `ufmx_ord_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ped_pagos_ufmx_ped_pedidos1_idx` (`order_id`),
  ADD KEY `paid_date` (`paid_date`),
  ADD KEY `amount` (`amount`);

--
-- Indices de la tabla `ufmx_ord_purchase_orders`
--
ALTER TABLE `ufmx_ord_purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ord_purchase_orders_ufmx_ord_orders1_idx` (`order_id`),
  ADD KEY `fk_ufmx_ord_purchase_orders_ufmx_usr_users1_idx` (`user_id`),
  ADD KEY `fk_ufmx_ord_purchase_orders_ufmx_inv_suppliers1_idx` (`supplier_id`);

--
-- Indices de la tabla `ufmx_ord_purchase_order_details`
--
ALTER TABLE `ufmx_ord_purchase_order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ord_purchase_order_details_ufmx_ord_purchase_orders_idx` (`purchase_order_id`),
  ADD KEY `fk_ufmx_ord_purchase_order_details_ufmx_inv_units1_idx` (`unit_id`),
  ADD KEY `fk_ufmx_ord_purchase_order_details_ufmx_inv_sizes1_idx` (`size_id`),
  ADD KEY `fk_ufmx_ord_purchase_order_details_ufmx_inv_clothes1_idx` (`cloth_id`);

--
-- Indices de la tabla `ufmx_ord_shipments`
--
ALTER TABLE `ufmx_ord_shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_ord_shipments_ufmx_ord_orders1_idx` (`order_id`),
  ADD KEY `fk_ufmx_ord_shipments_ufmx_ord_delivery_offices1_idx` (`delivery_office_id`),
  ADD KEY `cost` (`cost`),
  ADD KEY `delivered_date` (`delivered_date`);

--
-- Indices de la tabla `ufmx_prod_assignments`
--
ALTER TABLE `ufmx_prod_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_prod_line_assignments_ufmx_ord_order_details1_idx` (`order_detail_id`),
  ADD KEY `fk_ufmx_prod_assignments_ufmx_usr_users1_idx` (`assigned_to`),
  ADD KEY `fk_ufmx_prod_assignments_ufmx_usr_users2_idx` (`assigned_by`);

--
-- Indices de la tabla `ufmx_prod_assignment_inventory`
--
ALTER TABLE `ufmx_prod_assignment_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_prod_assignment_inventory_ufmx_prod_assignments1_idx` (`assignment_id`),
  ADD KEY `fk_ufmx_prod_assignment_inventory_ufmx_inv_raw_material1_idx` (`raw_material_id`),
  ADD KEY `fk_ufmx_prod_assignment_inventory_ufmx_inv_clothes1_idx` (`cloth_id`),
  ADD KEY `fk_ufmx_prod_assignment_inventory_ufmx_inv_parts1_idx` (`part_id`),
  ADD KEY `fk_ufmx_prod_assignment_inventory_ufmx_inv_bundles1_idx` (`bundle_id`);

--
-- Indices de la tabla `ufmx_prod_assignment_meta`
--
ALTER TABLE `ufmx_prod_assignment_meta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_prod_assigment_meta_ufmx_prod_assignments1_idx` (`assignment_id`),
  ADD KEY `fk_ufmx_prod_assignment_meta_ufmx_prod_assignment_meta_keys_idx` (`meta_key_id`);

--
-- Indices de la tabla `ufmx_prod_assignment_meta_keys`
--
ALTER TABLE `ufmx_prod_assignment_meta_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_UNIQUE` (`key`);

--
-- Indices de la tabla `ufmx_prod_assignment_processes`
--
ALTER TABLE `ufmx_prod_assignment_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ufmx_prod_assignment_progress`
--
ALTER TABLE `ufmx_prod_assignment_progress`
  ADD PRIMARY KEY (`id`),
  ADD KEY `timestamp` (`end_timestamp`),
  ADD KEY `quantity` (`quantity`),
  ADD KEY `fk_ufmx_prod_line_history_ufmx_prod_line_assignments1_idx` (`assignment_id`),
  ADD KEY `fk_ufmx_prod_assignment_progress_ufmx_usr_users1_idx` (`user_id`);

--
-- Indices de la tabla `ufmx_prod_assignment_type_meta`
--
ALTER TABLE `ufmx_prod_assignment_type_meta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_meta_key_id_assignment_type` (`meta_key_id`,`assignment_type`),
  ADD KEY `fk_assignment_type_meta_ufmx_prod_assignment_meta_keys1_idx` (`meta_key_id`);

--
-- Indices de la tabla `ufmx_usr_privileges`
--
ALTER TABLE `ufmx_usr_privileges`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `controller_action` (`controller`,`action`),
  ADD KEY `name` (`name`),
  ADD KEY `controller` (`controller`),
  ADD KEY `action` (`action`);

--
-- Indices de la tabla `ufmx_usr_roles`
--
ALTER TABLE `ufmx_usr_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ufmx_usr_role_privileges`
--
ALTER TABLE `ufmx_usr_role_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_usr_role_privileges_ufmx_usr_roles1_idx` (`role_id`),
  ADD KEY `fk_ufmx_usr_role_privileges_ufmx_usr_privileges1_idx` (`privilege_id`);

--
-- Indices de la tabla `ufmx_usr_users`
--
ALTER TABLE `ufmx_usr_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `email` (`email`),
  ADD KEY `first_name` (`first_name`),
  ADD KEY `last_name` (`last_name`),
  ADD KEY `birthday` (`birthday`);

--
-- Indices de la tabla `ufmx_usr_users_privileges`
--
ALTER TABLE `ufmx_usr_users_privileges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_usr_users_privileges_ufmx_usr_privileges1_idx` (`privilege_id`),
  ADD KEY `fk_ufmx_usr_users_privileges_ufmx_usr_users1_idx` (`user_id`);

--
-- Indices de la tabla `ufmx_usr_users_roles`
--
ALTER TABLE `ufmx_usr_users_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ufmx_usr_users_roles_ufmx_usr_users1_idx` (`user_id`),
  ADD KEY `fk_ufmx_usr_users_roles_ufmx_usr_roles1_idx` (`role_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ufmx_customer_contacts`
--
ALTER TABLE `ufmx_customer_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_cxs_customers`
--
ALTER TABLE `ufmx_cxs_customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ufmx_cxs_customer_addresses`
--
ALTER TABLE `ufmx_cxs_customer_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_bundles`
--
ALTER TABLE `ufmx_inv_bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_bundles_warehouses`
--
ALTER TABLE `ufmx_inv_bundles_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_clothes`
--
ALTER TABLE `ufmx_inv_clothes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_clothes_warehouses`
--
ALTER TABLE `ufmx_inv_clothes_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_cloth_entries`
--
ALTER TABLE `ufmx_inv_cloth_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_material_warehouses`
--
ALTER TABLE `ufmx_inv_material_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_parts`
--
ALTER TABLE `ufmx_inv_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_part_entries`
--
ALTER TABLE `ufmx_inv_part_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_part_warehouses`
--
ALTER TABLE `ufmx_inv_part_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_pieces`
--
ALTER TABLE `ufmx_inv_pieces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_products`
--
ALTER TABLE `ufmx_inv_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_product_pieces`
--
ALTER TABLE `ufmx_inv_product_pieces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_raw_material`
--
ALTER TABLE `ufmx_inv_raw_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_raw_material_entries`
--
ALTER TABLE `ufmx_inv_raw_material_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_record_cards`
--
ALTER TABLE `ufmx_inv_record_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_record_card_components`
--
ALTER TABLE `ufmx_inv_record_card_components`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_record_card_designs`
--
ALTER TABLE `ufmx_inv_record_card_designs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_record_card_parts`
--
ALTER TABLE `ufmx_inv_record_card_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_semi_clothes`
--
ALTER TABLE `ufmx_inv_semi_clothes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_sizes`
--
ALTER TABLE `ufmx_inv_sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_suppliers`
--
ALTER TABLE `ufmx_inv_suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=773355337;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_transfers`
--
ALTER TABLE `ufmx_inv_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_units`
--
ALTER TABLE `ufmx_inv_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ufmx_inv_warehouses`
--
ALTER TABLE `ufmx_inv_warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ufmx_misc_cities`
--
ALTER TABLE `ufmx_misc_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5233;

--
-- AUTO_INCREMENT de la tabla `ufmx_misc_quotations`
--
ALTER TABLE `ufmx_misc_quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ufmx_misc_quotation_details`
--
ALTER TABLE `ufmx_misc_quotation_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ufmx_misc_states`
--
ALTER TABLE `ufmx_misc_states`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_cloth_types`
--
ALTER TABLE `ufmx_ord_cloth_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_cloth_types_record_cards`
--
ALTER TABLE `ufmx_ord_cloth_types_record_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_delivery_offices`
--
ALTER TABLE `ufmx_ord_delivery_offices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_orders`
--
ALTER TABLE `ufmx_ord_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_order_details`
--
ALTER TABLE `ufmx_ord_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_order_history`
--
ALTER TABLE `ufmx_ord_order_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_payments`
--
ALTER TABLE `ufmx_ord_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_purchase_orders`
--
ALTER TABLE `ufmx_ord_purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_purchase_order_details`
--
ALTER TABLE `ufmx_ord_purchase_order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `ufmx_ord_shipments`
--
ALTER TABLE `ufmx_ord_shipments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignments`
--
ALTER TABLE `ufmx_prod_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignment_inventory`
--
ALTER TABLE `ufmx_prod_assignment_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignment_meta`
--
ALTER TABLE `ufmx_prod_assignment_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignment_meta_keys`
--
ALTER TABLE `ufmx_prod_assignment_meta_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignment_processes`
--
ALTER TABLE `ufmx_prod_assignment_processes`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignment_progress`
--
ALTER TABLE `ufmx_prod_assignment_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ufmx_prod_assignment_type_meta`
--
ALTER TABLE `ufmx_prod_assignment_type_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ufmx_usr_privileges`
--
ALTER TABLE `ufmx_usr_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `ufmx_usr_roles`
--
ALTER TABLE `ufmx_usr_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `ufmx_usr_role_privileges`
--
ALTER TABLE `ufmx_usr_role_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `ufmx_usr_users`
--
ALTER TABLE `ufmx_usr_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `ufmx_usr_users_privileges`
--
ALTER TABLE `ufmx_usr_users_privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ufmx_usr_users_roles`
--
ALTER TABLE `ufmx_usr_users_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ufmx_cxs_customer_addresses`
--
ALTER TABLE `ufmx_cxs_customer_addresses`
  ADD CONSTRAINT `fk_ufmx_cxs_customer_addresses_ufmx_cxs_customers1` FOREIGN KEY (`customer_id`) REFERENCES `ufmx_cxs_customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_cxs_customer_addresses_ufmx_misc_cities1` FOREIGN KEY (`city_id`) REFERENCES `ufmx_misc_cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_cxs_customer_addresses_ufmx_misc_states1` FOREIGN KEY (`state_id`) REFERENCES `ufmx_misc_states` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `ufmx_inv_bundles`
--
ALTER TABLE `ufmx_inv_bundles`
  ADD CONSTRAINT `fk_ufmx_inv_bundles_ufmx_prod_assignment_progress1` FOREIGN KEY (`assignment_progress_id`) REFERENCES `ufmx_prod_assignment_progress` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_bundles_warehouses`
--
ALTER TABLE `ufmx_inv_bundles_warehouses`
  ADD CONSTRAINT `fk_ufmx_inv_bundles_warehouses_ufmx_inv_bundles1` FOREIGN KEY (`bundle_id`) REFERENCES `ufmx_inv_bundles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_bundles_warehouses_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_clothes`
--
ALTER TABLE `ufmx_inv_clothes`
  ADD CONSTRAINT `fk_ufmx_inv_clothes_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_clothes_warehouses`
--
ALTER TABLE `ufmx_inv_clothes_warehouses`
  ADD CONSTRAINT `fk_ufmx_inv_clothes_warehouses_ufmx_inv_clothes1` FOREIGN KEY (`cloth_id`) REFERENCES `ufmx_inv_clothes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_clothes_warehouses_ufmx_inv_sizes1` FOREIGN KEY (`size_id`) REFERENCES `ufmx_inv_sizes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_clothes_warehouses_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_cloth_entries`
--
ALTER TABLE `ufmx_inv_cloth_entries`
  ADD CONSTRAINT `fk_ufmx_inv_cloth_entries_ufmx_inv_clothes1` FOREIGN KEY (`cloth_id`) REFERENCES `ufmx_inv_clothes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_cloth_entries_ufmx_inv_sizes1` FOREIGN KEY (`size_id`) REFERENCES `ufmx_inv_sizes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_cloth_entries_ufmx_inv_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `ufmx_inv_suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_cloth_entries_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_cloth_entries_ufmx_ord_purchase_order_details1` FOREIGN KEY (`purchase_order_detail_id`) REFERENCES `ufmx_ord_purchase_order_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_cloth_entries_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_material_warehouses`
--
ALTER TABLE `ufmx_inv_material_warehouses`
  ADD CONSTRAINT `fk_ufmx_inv_material_almacenes_ufmx_inv_almacenes1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ufmx_inv_material_almacenes_ufmx_inv_material1` FOREIGN KEY (`material_id`) REFERENCES `ufmx_inv_raw_material` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ufmx_inv_parts`
--
ALTER TABLE `ufmx_inv_parts`
  ADD CONSTRAINT `fk_ufmx_inv_parts_ufmx_inv_units1` FOREIGN KEY (`unit_id`) REFERENCES `ufmx_inv_units` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_part_entries`
--
ALTER TABLE `ufmx_inv_part_entries`
  ADD CONSTRAINT `fk_ufmx_inv_part_entries_ufmx_inv_parts1` FOREIGN KEY (`part_id`) REFERENCES `ufmx_inv_parts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_part_entries_ufmx_inv_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `ufmx_inv_suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_part_entries_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_part_entries_ufmx_ord_purchase_order_details1` FOREIGN KEY (`purchase_order_detail_id`) REFERENCES `ufmx_ord_purchase_order_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_part_entries_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_part_warehouses`
--
ALTER TABLE `ufmx_inv_part_warehouses`
  ADD CONSTRAINT `fk_ufmx_inv_part_warehouses_ufmx_inv_parts1` FOREIGN KEY (`part_id`) REFERENCES `ufmx_inv_parts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_part_warehouses_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_product_pieces`
--
ALTER TABLE `ufmx_inv_product_pieces`
  ADD CONSTRAINT `fk_ufmx_inv_product_pieces_ufmx_inv_pieces1` FOREIGN KEY (`piece_id`) REFERENCES `ufmx_inv_pieces` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_product_pieces_ufmx_inv_products1` FOREIGN KEY (`product_id`) REFERENCES `ufmx_inv_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_raw_material`
--
ALTER TABLE `ufmx_inv_raw_material`
  ADD CONSTRAINT `fk_ufmx_inv_material_ufmx_inv_unidades` FOREIGN KEY (`unit_id`) REFERENCES `ufmx_inv_units` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ufmx_inv_raw_material_entries`
--
ALTER TABLE `ufmx_inv_raw_material_entries`
  ADD CONSTRAINT `fk_ufmx_inv_raw_material_entries_ufmx_inv_raw_material1` FOREIGN KEY (`raw_material_id`) REFERENCES `ufmx_inv_raw_material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_raw_material_entries_ufmx_inv_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `ufmx_inv_suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_raw_material_entries_ufmx_ord_purchase_order_deta1` FOREIGN KEY (`purchase_order_detail_id`) REFERENCES `ufmx_ord_purchase_order_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_raw_material_entries_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_stock_entries_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_record_cards`
--
ALTER TABLE `ufmx_inv_record_cards`
  ADD CONSTRAINT `fk_ufmx_inv_record_cards_ufmx_inv_products1` FOREIGN KEY (`product_id`) REFERENCES `ufmx_inv_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_record_card_components`
--
ALTER TABLE `ufmx_inv_record_card_components`
  ADD CONSTRAINT `fk_ufmx_inv_record_card_components_ufmx_inv_raw_material1` FOREIGN KEY (`material_id`) REFERENCES `ufmx_inv_raw_material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_record_card_components_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_record_card_designs`
--
ALTER TABLE `ufmx_inv_record_card_designs`
  ADD CONSTRAINT `fk_ufmx_inv_record_card_designs_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_record_card_parts`
--
ALTER TABLE `ufmx_inv_record_card_parts`
  ADD CONSTRAINT `fk_ufmx_inv_record_card_parts_ufmx_inv_parts1` FOREIGN KEY (`part_id`) REFERENCES `ufmx_inv_parts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_record_card_parts_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_record_card_pieces`
--
ALTER TABLE `ufmx_inv_record_card_pieces`
  ADD CONSTRAINT `fk_ufmx_inv_record_card_pieces_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_semi_clothes`
--
ALTER TABLE `ufmx_inv_semi_clothes`
  ADD CONSTRAINT `fk_ufmx_inv_semi_clothes_ufmx_prod_line_history1` FOREIGN KEY (`line_history_id`) REFERENCES `ufmx_prod_assignment_progress` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_transfers`
--
ALTER TABLE `ufmx_inv_transfers`
  ADD CONSTRAINT `fk_ufmx_inv_transfers_ufmx_inv_clothes_warehouses1` FOREIGN KEY (`cloth_warehouse_id`) REFERENCES `ufmx_inv_clothes_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_transfers_ufmx_inv_material_warehouses1` FOREIGN KEY (`material_warehouse_id`) REFERENCES `ufmx_inv_material_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_transfers_ufmx_inv_part_warehouses1` FOREIGN KEY (`part_warehouse_id`) REFERENCES `ufmx_inv_part_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_transfers_ufmx_prod_assignment_inventory1` FOREIGN KEY (`assignment_inventory_id`) REFERENCES `ufmx_prod_assignment_inventory` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_inv_warehouses`
--
ALTER TABLE `ufmx_inv_warehouses`
  ADD CONSTRAINT `fk_ufmx_inv_warehouses_ufmx_misc_cities1` FOREIGN KEY (`city_id`) REFERENCES `ufmx_misc_cities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_inv_warehouses_ufmx_misc_states1` FOREIGN KEY (`state_id`) REFERENCES `ufmx_misc_states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_misc_cities`
--
ALTER TABLE `ufmx_misc_cities`
  ADD CONSTRAINT `fk_ufmx_misc_cities_ufmx_misc_states1` FOREIGN KEY (`state_id`) REFERENCES `ufmx_misc_states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_misc_quotations`
--
ALTER TABLE `ufmx_misc_quotations`
  ADD CONSTRAINT `fk_ufmx_misc_quotations_ufmx_cxs_customer_addresses1` FOREIGN KEY (`customer_id`) REFERENCES `ufmx_cxs_customer_addresses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_misc_quotations_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_misc_quotation_details`
--
ALTER TABLE `ufmx_misc_quotation_details`
  ADD CONSTRAINT `fk_ufmx_misc_quotation_details_ufmx_misc_quotations1` FOREIGN KEY (`quotation_id`) REFERENCES `ufmx_misc_quotations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `ufmx_ord_cloth_types_record_cards`
--
ALTER TABLE `ufmx_ord_cloth_types_record_cards`
  ADD CONSTRAINT `fk_ufmx_ord_cloth_types_record_cards_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_cloth_types_record_cards_ufmx_ord_cloth_types1` FOREIGN KEY (`cloth_type_id`) REFERENCES `ufmx_ord_cloth_types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_ord_orders`
--
ALTER TABLE `ufmx_ord_orders`
  ADD CONSTRAINT `fk_ufmx_ord_orders_ufmx_inv_warehouses1` FOREIGN KEY (`warehouse_id`) REFERENCES `ufmx_inv_warehouses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_orders_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ped_pedidos_ufmx_cli_customers1` FOREIGN KEY (`customer_id`) REFERENCES `ufmx_cxs_customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_ord_order_details`
--
ALTER TABLE `ufmx_ord_order_details`
  ADD CONSTRAINT `fk_ufmx_ord_order_details_ufmx_inv_clothes1` FOREIGN KEY (`cloth_id`) REFERENCES `ufmx_inv_clothes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_order_details_ufmx_inv_products1` FOREIGN KEY (`product_id`) REFERENCES `ufmx_inv_products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_order_details_ufmx_inv_record_cards1` FOREIGN KEY (`record_card_id`) REFERENCES `ufmx_inv_record_cards` (`id`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_order_details_ufmx_inv_sizes1` FOREIGN KEY (`size_id`) REFERENCES `ufmx_inv_sizes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_order_details_ufmx_ord_orders1` FOREIGN KEY (`order_id`) REFERENCES `ufmx_ord_orders` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `ufmx_ord_order_history`
--
ALTER TABLE `ufmx_ord_order_history`
  ADD CONSTRAINT `fk_ufmx_ord_order_history_ufmx_ord_orders1` FOREIGN KEY (`order_id`) REFERENCES `ufmx_ord_orders` (`id`),
  ADD CONSTRAINT `fk_ufmx_ord_order_history_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_ord_payments`
--
ALTER TABLE `ufmx_ord_payments`
  ADD CONSTRAINT `fk_ufmx_ped_pagos_ufmx_ped_pedidos1` FOREIGN KEY (`order_id`) REFERENCES `ufmx_ord_orders` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ufmx_ord_purchase_orders`
--
ALTER TABLE `ufmx_ord_purchase_orders`
  ADD CONSTRAINT `fk_ufmx_ord_purchase_orders_ufmx_inv_suppliers1` FOREIGN KEY (`supplier_id`) REFERENCES `ufmx_inv_suppliers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_purchase_orders_ufmx_ord_orders1` FOREIGN KEY (`order_id`) REFERENCES `ufmx_ord_orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_purchase_orders_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_ord_purchase_order_details`
--
ALTER TABLE `ufmx_ord_purchase_order_details`
  ADD CONSTRAINT `fk_ufmx_ord_purchase_order_details_ufmx_inv_clothes1` FOREIGN KEY (`cloth_id`) REFERENCES `ufmx_inv_clothes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_purchase_order_details_ufmx_inv_sizes1` FOREIGN KEY (`size_id`) REFERENCES `ufmx_inv_sizes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_purchase_order_details_ufmx_inv_units1` FOREIGN KEY (`unit_id`) REFERENCES `ufmx_inv_units` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_purchase_order_details_ufmx_ord_purchase_orders1` FOREIGN KEY (`purchase_order_id`) REFERENCES `ufmx_ord_purchase_orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_ord_shipments`
--
ALTER TABLE `ufmx_ord_shipments`
  ADD CONSTRAINT `fk_ufmx_ord_shipments_ufmx_ord_delivery_offices1` FOREIGN KEY (`delivery_office_id`) REFERENCES `ufmx_ord_delivery_offices` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_ord_shipments_ufmx_ord_orders1` FOREIGN KEY (`order_id`) REFERENCES `ufmx_ord_orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_prod_assignments`
--
ALTER TABLE `ufmx_prod_assignments`
  ADD CONSTRAINT `fk_ufmx_prod_assignments_ufmx_ord_order_details1` FOREIGN KEY (`order_detail_id`) REFERENCES `ufmx_ord_order_details` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignments_ufmx_usr_users1` FOREIGN KEY (`assigned_to`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignments_ufmx_usr_users2` FOREIGN KEY (`assigned_by`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_prod_assignment_inventory`
--
ALTER TABLE `ufmx_prod_assignment_inventory`
  ADD CONSTRAINT `fk_ufmx_prod_assignment_inventory_ufmx_inv_bundles1` FOREIGN KEY (`bundle_id`) REFERENCES `ufmx_inv_bundles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignment_inventory_ufmx_inv_clothes1` FOREIGN KEY (`cloth_id`) REFERENCES `ufmx_inv_clothes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignment_inventory_ufmx_inv_parts1` FOREIGN KEY (`part_id`) REFERENCES `ufmx_inv_parts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignment_inventory_ufmx_inv_raw_material1` FOREIGN KEY (`raw_material_id`) REFERENCES `ufmx_inv_raw_material` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignment_inventory_ufmx_prod_assignments1` FOREIGN KEY (`assignment_id`) REFERENCES `ufmx_prod_assignments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_prod_assignment_meta`
--
ALTER TABLE `ufmx_prod_assignment_meta`
  ADD CONSTRAINT `fk_ufmx_prod_assigment_meta_ufmx_prod_assignments1` FOREIGN KEY (`assignment_id`) REFERENCES `ufmx_prod_assignments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_assignment_meta_ufmx_prod_assignment_meta_keys1` FOREIGN KEY (`meta_key_id`) REFERENCES `ufmx_prod_assignment_meta_keys` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_prod_assignment_progress`
--
ALTER TABLE `ufmx_prod_assignment_progress`
  ADD CONSTRAINT `fk_ufmx_prod_assignment_progress_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_prod_line_history_ufmx_prod_line_assignments1` FOREIGN KEY (`assignment_id`) REFERENCES `ufmx_prod_assignments` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_prod_assignment_type_meta`
--
ALTER TABLE `ufmx_prod_assignment_type_meta`
  ADD CONSTRAINT `fk_assignment_type_meta_ufmx_prod_assignment_meta_keys1` FOREIGN KEY (`meta_key_id`) REFERENCES `ufmx_prod_assignment_meta_keys` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_usr_role_privileges`
--
ALTER TABLE `ufmx_usr_role_privileges`
  ADD CONSTRAINT `fk_ufmx_usr_role_privileges_ufmx_usr_privileges1` FOREIGN KEY (`privilege_id`) REFERENCES `ufmx_usr_privileges` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_usr_role_privileges_ufmx_usr_roles1` FOREIGN KEY (`role_id`) REFERENCES `ufmx_usr_roles` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_usr_users_privileges`
--
ALTER TABLE `ufmx_usr_users_privileges`
  ADD CONSTRAINT `fk_ufmx_usr_users_privileges_ufmx_usr_privileges1` FOREIGN KEY (`privilege_id`) REFERENCES `ufmx_usr_privileges` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_usr_users_privileges_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ufmx_usr_users_roles`
--
ALTER TABLE `ufmx_usr_users_roles`
  ADD CONSTRAINT `fk_ufmx_usr_users_roles_ufmx_usr_roles1` FOREIGN KEY (`role_id`) REFERENCES `ufmx_usr_roles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ufmx_usr_users_roles_ufmx_usr_users1` FOREIGN KEY (`user_id`) REFERENCES `ufmx_usr_users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
