-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2025 a las 10:10:41
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cadena_restaurantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`codigo`, `nombre`, `descripcion`) VALUES
(1, 'Bebidas', 'Refrescos, zumos y bebidas alcohólicas'),
(2, 'Postres', 'Dulces y tartas'),
(3, 'Platos principales', 'Comidas completas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallespedido`
--

CREATE TABLE `detallespedido` (
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detallespedido`
--

INSERT INTO `detallespedido` (`id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 2, 1.50),
(1, 2, 1, 4.00),
(2, 3, 1, 6.50),
(3, 1, 2, 1.50),
(3, 4, 1, 12.00),
(6, 1, 1, 1.50),
(6, 3, 2, 8.50),
(7, 1, 1, 1.50),
(8, 1, 2, 1.50),
(8, 3, 1, 8.50),
(8, 4, 1, 12.00),
(9, 1, 2, 1.50),
(10, 1, 90, 1.50),
(11, 1, 1, 1.50),
(11, 3, 2, 8.50),
(14, 1, 4, 1.50),
(15, 2, 3, 4.00),
(16, 3, 23, 8.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_restaurante` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `estado` varchar(50) DEFAULT 'no enviado',
  `precio_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_restaurante`, `fecha`, `estado`, `precio_total`) VALUES
(1, 1, '2025-10-22 13:45:00', 'no enviado', 13.00),
(2, 2, '2025-10-22 14:10:00', 'no enviado', 8.50),
(3, 3, '2025-10-22 15:30:00', 'no enviado', 16.00),
(4, 1, '2025-10-27 00:00:00', 'no enviado', 0.00),
(5, 1, '2025-10-27 13:10:52', 'no enviado', 18.50),
(6, 1, '2025-10-27 13:11:19', 'no enviado', 18.50),
(7, 1, '2025-10-27 13:20:37', 'no enviado', 1.50),
(8, 1, '2025-10-28 10:18:16', 'no enviado', 23.50),
(9, 1, '2025-10-28 10:26:46', 'no enviado', 3.00),
(10, 1, '2025-10-28 10:27:46', 'no enviado', 135.00),
(11, 1, '2025-10-28 10:35:54', 'no enviado', 18.50),
(14, 1, '2025-10-28 11:10:39', 'no enviado', 6.00),
(15, 1, '2025-10-28 11:35:45', 'no enviado', 12.00),
(16, 1, '2025-10-30 10:07:39', 'no enviado', 195.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `codigo` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`codigo`, `nombre`, `descripcion`, `precio`, `stock`, `id_categoria`) VALUES
(1, 'Coca-Cola', 'Refresco de cola 33cl', 1.50, 0, 1),
(2, 'Tarta de queso', 'Postre casero con mermelada', 4.00, 47, 2),
(3, 'Pizza Margarita', 'Pizza con tomate, mozzarella y albahaca', 8.50, 4, 3),
(4, 'Sushi variado', 'Bandeja con 12 piezas', 12.00, 19, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `restaurantes`
--

CREATE TABLE `restaurantes` (
  `codigo` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `direccion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `restaurantes`
--

INSERT INTO `restaurantes` (`codigo`, `email`, `clave`, `direccion`) VALUES
(1, 'bartapas@gmail.com', '$2y$10$eOdu155dchc8GVWo59QvUuEY.vgrQesgPpo4dIIuxaZrDsT45RWVq', 'Calle Mayor 12, Madrid'),
(2, 'pizzeriaroma@gmail.com', '$2y$10$nITh6hdRADmJA.LFyOb5guPZAXnMAvp7S2BGWNuO.WXbjm.s7BQDe', 'Avenida Italia 45, Barcelona'),
(3, 'sushitokyo@gmail.com', '$2y$10$rn5BTva2jKac4asgw3qCXem0v0lZ1YB/virqorzgnJu8e/8p2NZzK', 'Calle Japón 8, Valencia'),
(4, 'nuevo@restaurante.com', '$2y$10$abc123EjemploDeHashSeguro4567890xyzABCDEFghijklmnopqrstu', 'Plaza Central 9, Sevilla');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `detallespedido`
--
ALTER TABLE `detallespedido`
  ADD PRIMARY KEY (`id_pedido`,`id_producto`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_restaurante` (`id_restaurante`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `restaurantes`
--
ALTER TABLE `restaurantes`
  ADD PRIMARY KEY (`codigo`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallespedido`
--
ALTER TABLE `detallespedido`
  ADD CONSTRAINT `detallespedido_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id`),
  ADD CONSTRAINT `detallespedido_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`codigo`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_restaurante`) REFERENCES `restaurantes` (`codigo`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`codigo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
