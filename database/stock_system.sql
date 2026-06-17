-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generacion: 17-06-2026
-- Version del servidor: 10.4.32-MariaDB
-- Version de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `stock_system`
--
CREATE DATABASE IF NOT EXISTS `stock_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `stock_system`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alerta`
--

CREATE TABLE `alerta` (
  `id_alerta` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `tipo_alerta` varchar(100) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `fecha_generacion` datetime NOT NULL DEFAULT current_timestamp(),
  `leida` tinyint(1) NOT NULL DEFAULT 0,
  `estado` varchar(50) DEFAULT 'activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `componentes`
--

CREATE TABLE `componentes` (
  `id_componente` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `marca` varchar(150) DEFAULT NULL,
  `modelo` varchar(150) DEFAULT NULL,
  `cantidad_disponible` int(11) NOT NULL DEFAULT 0,
  `estado` varchar(80) DEFAULT 'activo',
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_guardado` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo_propietario` varchar(50) DEFAULT NULL,
  `id_propietario` int(10) UNSIGNED DEFAULT NULL,
  `modo_prestamo` varchar(80) DEFAULT 'requiere_aprobacion',
  `requiere_deposito` tinyint(1) DEFAULT 0,
  `visibilidad` varchar(50) DEFAULT 'publico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_prestamo`
--

CREATE TABLE `detalle_prestamo` (
  `id_detalle` int(10) UNSIGNED NOT NULL,
  `id_prestamo` int(10) UNSIGNED NOT NULL,
  `tipo_item` enum('componente','herramienta') NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `estado_item` varchar(100) DEFAULT 'entregado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `herramientas`
--

CREATE TABLE `herramientas` (
  `id_herramienta` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `marca` varchar(150) DEFAULT NULL,
  `modelo` varchar(150) DEFAULT NULL,
  `cantidad_disponible` int(11) NOT NULL DEFAULT 0,
  `estado` varchar(80) DEFAULT 'activo',
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_guardado` datetime NOT NULL DEFAULT current_timestamp(),
  `tipo_propietario` varchar(50) DEFAULT NULL,
  `id_propietario` int(10) UNSIGNED DEFAULT NULL,
  `modo_prestamo` varchar(80) DEFAULT 'requiere_aprobacion',
  `requiere_deposito` tinyint(1) DEFAULT 0,
  `visibilidad` varchar(50) DEFAULT 'publico'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id_historial` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `accion` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_hora` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `id_prestamo` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `fecha_prestamo` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_devolucion_estimada` datetime DEFAULT NULL,
  `fecha_devolucion_real` datetime DEFAULT NULL,
  `estado` varchar(80) DEFAULT 'activo',
  `observaciones` text DEFAULT NULL,
  `fecha_guardado` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `objetivo` text DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_estimada_fin` datetime DEFAULT NULL,
  `estado` varchar(80) DEFAULT 'activo',
  `id_profesor` int(10) UNSIGNED DEFAULT NULL,
  `fecha_guardado` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_grupo`
--

CREATE TABLE `proyecto_grupo` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_proyecto` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyecto_item`
--

CREATE TABLE `proyecto_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_proyecto` int(10) UNSIGNED NOT NULL,
  `tipo_item` enum('componente','herramienta') NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reputacion`
--

CREATE TABLE `reputacion` (
  `id_reputacion` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `puntos_totales` int(11) NOT NULL DEFAULT 0,
  `nivel` varchar(50) DEFAULT 'Bronce',
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id_reserva` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `tipo_item` enum('componente','herramienta') NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `fecha_reserva` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_necesidad` datetime DEFAULT NULL,
  `tipo_reserva` varchar(80) DEFAULT NULL,
  `estado` varchar(80) DEFAULT 'activa',
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_prestamo`
--

CREATE TABLE `solicitud_prestamo` (
  `id_solicitud` int(10) UNSIGNED NOT NULL,
  `id_usuario_solicitante` int(10) UNSIGNED NOT NULL,
  `tipo_item` enum('componente','herramienta') NOT NULL,
  `id_item` int(10) UNSIGNED NOT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `fecha_solicitud` datetime NOT NULL DEFAULT current_timestamp(),
  `estado` varchar(80) DEFAULT 'pendiente',
  `id_aprobador` int(10) UNSIGNED DEFAULT NULL,
  `fecha_respuesta` datetime DEFAULT NULL,
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `dni` varchar(50) DEFAULT NULL,
  `nombre` varchar(150) NOT NULL,
  `apellido` varchar(150) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL DEFAULT 'alumno',
  `estado` varchar(50) NOT NULL DEFAULT 'activo',
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `curso_division` varchar(100) DEFAULT NULL,
  `materia` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indices para tablas volcadas
--

--
-- Indices de la tabla `alerta`
--
ALTER TABLE `alerta`
  ADD PRIMARY KEY (`id_alerta`),
  ADD KEY `fk_alerta_usuario` (`id_usuario`);

--
-- Indices de la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD PRIMARY KEY (`id_componente`),
  ADD KEY `fk_componentes_propietario` (`id_propietario`);

--
-- Indices de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `fk_detalle_prestamo` (`id_prestamo`);

--
-- Indices de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD PRIMARY KEY (`id_herramienta`),
  ADD KEY `fk_herramientas_propietario` (`id_propietario`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id_historial`),
  ADD KEY `fk_historial_usuario` (`id_usuario`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`id_prestamo`),
  ADD KEY `fk_prestamo_usuario` (`id_usuario`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `fk_proyectos_profesor` (`id_profesor`);

--
-- Indices de la tabla `proyecto_grupo`
--
ALTER TABLE `proyecto_grupo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pg_proyecto` (`id_proyecto`),
  ADD KEY `fk_pg_usuario` (`id_usuario`);

--
-- Indices de la tabla `proyecto_item`
--
ALTER TABLE `proyecto_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pi_proyecto` (`id_proyecto`);

--
-- Indices de la tabla `reputacion`
--
ALTER TABLE `reputacion`
  ADD PRIMARY KEY (`id_reputacion`),
  ADD UNIQUE KEY `uniq_rep_usuario` (`id_usuario`),
  ADD KEY `fk_reputacion_usuario` (`id_usuario`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `fk_reserva_usuario` (`id_usuario`);

--
-- Indices de la tabla `solicitud_prestamo`
--
ALTER TABLE `solicitud_prestamo`
  ADD PRIMARY KEY (`id_solicitud`),
  ADD KEY `fk_solicitud_usuario` (`id_usuario_solicitante`),
  ADD KEY `fk_solicitud_aprobador` (`id_aprobador`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uniq_email` (`email`),
  ADD UNIQUE KEY `uniq_dni` (`dni`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alerta`
--
ALTER TABLE `alerta`
  MODIFY `id_alerta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `componentes`
--
ALTER TABLE `componentes`
  MODIFY `id_componente` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  MODIFY `id_detalle` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `herramientas`
--
ALTER TABLE `herramientas`
  MODIFY `id_herramienta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id_historial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `id_prestamo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto_grupo`
--
ALTER TABLE `proyecto_grupo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proyecto_item`
--
ALTER TABLE `proyecto_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reputacion`
--
ALTER TABLE `reputacion`
  MODIFY `id_reputacion` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id_reserva` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_prestamo`
--
ALTER TABLE `solicitud_prestamo`
  MODIFY `id_solicitud` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alerta`
--
ALTER TABLE `alerta`
  ADD CONSTRAINT `fk_alerta_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `componentes`
--
ALTER TABLE `componentes`
  ADD CONSTRAINT `fk_componentes_propietario` FOREIGN KEY (`id_propietario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_prestamo`
--
ALTER TABLE `detalle_prestamo`
  ADD CONSTRAINT `fk_detalle_prestamo` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamo` (`id_prestamo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `herramientas`
--
ALTER TABLE `herramientas`
  ADD CONSTRAINT `fk_herramientas_propietario` FOREIGN KEY (`id_propietario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `fk_historial_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `fk_prestamo_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `fk_proyectos_profesor` FOREIGN KEY (`id_profesor`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto_grupo`
--
ALTER TABLE `proyecto_grupo`
  ADD CONSTRAINT `fk_pg_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pg_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `proyecto_item`
--
ALTER TABLE `proyecto_item`
  ADD CONSTRAINT `fk_pi_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reputacion`
--
ALTER TABLE `reputacion`
  ADD CONSTRAINT `fk_reputacion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `fk_reserva_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitud_prestamo`
--
ALTER TABLE `solicitud_prestamo`
  ADD CONSTRAINT `fk_solicitud_aprobador` FOREIGN KEY (`id_aprobador`) REFERENCES `usuarios` (`id_usuario`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_solicitud_usuario` FOREIGN KEY (`id_usuario_solicitante`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;