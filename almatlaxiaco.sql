-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-07-2024 a las 12:53:11
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `almatlaxiaco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `puesto` varchar(255) NOT NULL,
  `horario_trabajo` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `salario` decimal(10,2) NOT NULL DEFAULT 0.00,
  `fecha_contratacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `nombre_completo`, `puesto`, `horario_trabajo`, `telefono`, `salario`, `fecha_contratacion`) VALUES
(1, 'Angel Gael Leon Leon', 'cocinero', '10:00 am - 4:00 pm', '9531379018', '1200.00', '2022-05-29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `venta` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`id`, `codigo`, `descripcion`, `categoria`, `venta`, `precio`) VALUES
(1, '220123', 'Quesadillas de pollo', 'Desayuno', '2.00', '30.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(10) NOT NULL,
  `correo_electronico` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contraseña` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `direccion`, `telefono`, `correo_electronico`, `usuario`, `contraseña`) VALUES
(1, 'Ana Michel', 'Leon Leon', 'av las flores', '9531379018', 'anamichel@gmail.com', 'Ana', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db'),
(2, 'Fernanda', 'Ruiz Heras', 'llano yosove ', '9531456287', 'fernanda@gmail.com', 'Fer', 'fb131bc57a477c8c9d068f1ee5622ac304195a77164ccc2d75d82dfe1a727ba8d674ed87f96143b2b416aacefb555e3045c356faa23e6d21de72b85822e39fdd'),
(4, 'Juan', 'perez', 'centro', '9531450214', 'juan@gmail.com', 'Juan12', '673d4b1d7deabe33d0037d3a39927ec3d56397a45f5eb9ac0512c75808c293f0d022e04adc5555cd3644d18cf79e9e9ebaea7e3a8e96744b0c49312a7f8af398');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `codigo_menu` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha_hora`, `codigo_menu`, `usuario_id`, `total`) VALUES
(1, '2024-07-21 09:35:46', 220123, 2, '70.00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
