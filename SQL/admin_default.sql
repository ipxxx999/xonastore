-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-07-2022 a las 22:46:27
-- Versión del servidor: 5.7.17-log
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `mixonaplay`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botstatus`
--

CREATE TABLE `botstatus` (
  `id` int(11) NOT NULL,
  `status_run` tinyint(4) NOT NULL,
  `last_run` datetime NOT NULL,
  `last_check` datetime NOT NULL,
  `pid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `botstatus`
--

INSERT INTO `botstatus` (`id`, `status_run`, `last_run`, `last_check`, `pid`) VALUES
(1, 0, '2021-02-14 18:43:01', '2021-02-14 18:43:01', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `views` int(11) NOT NULL,
  `ubicacion` text NOT NULL,
  `error` text NOT NULL,
  `calidades` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `links`
--

INSERT INTO `links` (`id`, `title`, `user_id`, `data`, `status`, `views`, `ubicacion`, `error`, `calidades`) VALUES
(5, 'el 12', 1, '{\"link\":\"21-_1080p.mp4\",\"poster_link\":\"\",\"subtitles\":[]}', 0, 0, '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `options`
--

CREATE TABLE `options` (
  `option_key` varchar(100) NOT NULL,
  `option_value` text,
  `version` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `options`
--

INSERT INTO `options` (`option_key`, `option_value`, `version`) VALUES
('general', '{\"player\":\"jwplayer\",\"allowed_referer\":[\"localhost\",\"10.0.8.4\",\"127.0.0.1\",\"192.168.1.1\"],\"allowed_referer_null\":true,\"calidades\":[\"480p\"],\"api_key_google_drive\":\"\"}', '2.3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servers`
--

CREATE TABLE `servers` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ip_ftp` varchar(100) NOT NULL,
  `usuario_ftp` varchar(100) NOT NULL,
  `password_ftp` varchar(100) NOT NULL,
  `puerto_ftp` varchar(100) NOT NULL,
  `tipo_servidor` varchar(50) NOT NULL,
  `ruta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(78) NOT NULL,
  `rol` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `rol`) VALUES
(1, 'admin@admin.com', '$2y$10$oCUM8hO5NfAcGvXcVsNRI.SIDxiL3MdyDBbpoSLt5bLp/syajrXza', 1),
(2, 'Guest@guest.com', '$2y$10$.e2qcoyeJRPplBwaR7oCweM63sY5tkpBNdn2CJ6d1bESCZFdEwQSa', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitas`
--

CREATE TABLE `visitas` (
  `id` int(11) NOT NULL,
  `video` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `botstatus`
--
ALTER TABLE `botstatus`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_key`);

--
-- Indices de la tabla `servers`
--
ALTER TABLE `servers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indices de la tabla `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `botstatus`
--
ALTER TABLE `botstatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `servers`
--
ALTER TABLE `servers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;