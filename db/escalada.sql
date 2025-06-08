-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-06-2025 a las 00:56:59
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `escalada`
--
CREATE DATABASE IF NOT EXISTS `escalada` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `escalada`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ascent_types`
--

DROP TABLE IF EXISTS `ascent_types`;
CREATE TABLE `ascent_types` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ascent_types`
--

INSERT INTO `ascent_types` (`id`, `name`) VALUES
(1, 'A vista'),
(3, 'Ensayada'),
(2, 'Flash'),
(4, 'Toprope');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `routes`
--

DROP TABLE IF EXISTS `routes`;
CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `meters` int(11) DEFAULT NULL,
  `draws` int(11) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `style_id` int(11) DEFAULT NULL,
  `pitches` int(11) DEFAULT NULL,
  `tries` int(11) DEFAULT NULL,
  `ascent_type_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'defaultRoute.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `routes`
--

INSERT INTO `routes` (`id`, `user_id`, `name`, `meters`, `draws`, `country`, `location`, `style_id`, `pitches`, `tries`, `ascent_type_id`, `date`, `comments`, `photo`) VALUES
(6, 4, 'Chukundur', 26, 8, 'España', 'Rodellar', 3, 2, 4, 3, '2024-11-20', 'Cut star figure ground family sell effort clear.', 'defaultRoute.png'),
(8, 2, 'Rate', 13, 6, 'Italia', 'Margalef', 2, 1, 2, 2, '2024-08-01', 'Step wife maintain source green glass.', 'defaultRoute.png'),
(9, 2, 'House', 21, 12, 'España', 'Chera', 1, 3, 2, 3, '2024-11-17', 'Simple feel find speak miss language business measure.', 'defaultRoute.png'),
(10, 2, 'Appear', 23, 6, 'Italia', 'Montanejos', 1, 3, 6, 3, '2024-04-17', 'Civil score beyond first happen management.', 'defaultRoute.png'),
(11, 2, 'Red', 27, 11, 'España', 'Siurana', 1, 3, 3, 3, '2023-06-27', 'Happen next fine through.', 'defaultRoute.png'),
(13, 1, 'Hijos del bobal', 18, 15, 'Francia', 'Chulilla', 1, 1, 6, 3, '2023-06-07', 'Central necessary despite shoulder late mind couple interesting.', 'defaultRoute.png'),
(15, 2, 'International', 10, 10, 'España', 'Chulilla', 3, 2, 6, 2, '2023-07-12', 'Base series wall us certainly sort send.', 'defaultRoute.png'),
(17, 4, 'Table', 24, 12, 'Francia', 'Chera', 3, 1, 6, 3, '2024-02-22', 'Expert nor discussion add.', 'defaultRoute.png'),
(18, 1, 'Polvos magicos', 40, 8, 'Italia', 'Chera', 3, 3, 3, 3, '2023-12-18', 'Financial establish participant four apply.', 'defaultRoute.png'),
(19, 1, 'Machine', 13, 5, 'España', 'Siurana', 3, 2, 6, 3, '2024-09-24', 'Summer go health claim not analysis off.', 'defaultRoute.png'),
(20, 2, 'Together', 20, 8, 'Suiza', 'Chera', 1, 3, 6, 3, '2024-02-22', 'Item reach coach report night visit candidate yeah.', 'defaultRoute.png'),
(21, 1, 'La feria', 20, 10, 'España', 'Chera', 1, 5, 1, 1, '2025-06-19', 'Nada', 'defaultRoute.png'),
(22, 1, 'Pumuki', 20, 9, 'Suiza', 'Cheste', 3, 2, 2, 1, '2025-06-19', 'err', 'defaultRoute.png'),
(23, 1, 'hola', 4, 5, 'madrid', 'Valencia', 3, 5, 5, 1, '2025-06-25', 'err', '1749304848pruebaRuta.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `styles`
--

DROP TABLE IF EXISTS `styles`;
CREATE TABLE `styles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `styles`
--

INSERT INTO `styles` (`id`, `name`) VALUES
(3, 'Bulder'),
(2, 'Clásica'),
(1, 'Deportiva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `profile_image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `role`, `profile_image`) VALUES
(1, 'admin', 'Pablogorn@gmail.com', '$2y$10$1IxHPFfuPD.UeQE1mc31QOFiTrylPRgKuThgnZtQrrImneju3K5CK', 'admin', 'admin.jpg'),
(2, 'juan', 'Pablogorn@gmail.com', '$2y$10$5oQhZD1sFZ2LMX9/MEAOpOgSFNsFdEObcZg1uN22Aiu9rTQ9ssBmy', 'admin', 'admin.jpg'),
(4, 'Pau', 'bleble@gmail.com', '$2y$10$lgVJRHTA7ycSyhgtUjA3KO5uXz3uyjDg8joQVbZ922XzHrT62qFWC', 'user', 'default.png'),
(9, 'Pepe', 'lelele@gmail.com', '$2y$10$Ulg4RQRDHkNjF76TZCSYtO.n7og.nF1664LhN/70mKEzYPZfmmlai', 'user', 'default.png'),
(10, 'pepito', 'prueba@gmail.com', '$2y$10$2hGi2rrl08LklVOCwQxB9uk13qZ2AqtLPlCmAg9n8Nh0IbXo2pMn.', 'user', 'default.png'),
(11, 'Jaime', 'prueba@gmail.com', '$2y$10$Aw0jL8IxuSAVKIT/307EkO4AA4.fqqJ/zuK.AD0x0wvW2QCC4S0w2', 'user', '1749293410pruebaUsuario.jpg'),
(12, 'miriam', 'prueba@gmail.com', '$2y$10$8rxEp3sj0WycStPA9rnw2ube6ZVQQXmt9hw7SAHOeGOjF8AfklBhK', 'user', 'default.png'),
(13, 'jorge', 'prueba@gmail.com', '$2y$10$sG2cLHS110tLM/nvW05M2.z0DX3STZFKcc.zWlFETUzWnLhejY5Ai', 'user', '1749303214pruebaUsuario.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ascent_types`
--
ALTER TABLE `ascent_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `style_id` (`style_id`),
  ADD KEY `ascent_type_id` (`ascent_type_id`);

--
-- Indices de la tabla `styles`
--
ALTER TABLE `styles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ascent_types`
--
ALTER TABLE `ascent_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `styles`
--
ALTER TABLE `styles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `routes`
--
ALTER TABLE `routes`
  ADD CONSTRAINT `routes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `routes_ibfk_2` FOREIGN KEY (`style_id`) REFERENCES `styles` (`id`),
  ADD CONSTRAINT `routes_ibfk_3` FOREIGN KEY (`ascent_type_id`) REFERENCES `ascent_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
