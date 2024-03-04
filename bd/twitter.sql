-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-03-2024 a las 15:04:45
-- Versión del servidor: 10.5.24-MariaDB
-- Versión de PHP: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `twitter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `ID` int(11) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`ID`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Operador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_consulta`
--

CREATE TABLE `tabla_consulta` (
  `id` int(11) NOT NULL,
  `operador` varchar(255) DEFAULT NULL,
  `turno` varchar(255) DEFAULT NULL,
  `clientes` varchar(255) DEFAULT NULL,
  `paises` varchar(255) NOT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `publica` varchar(255) DEFAULT NULL,
  `links` varchar(255) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `enfoque` varchar(255) DEFAULT NULL,
  `likes` varchar(255) DEFAULT NULL,
  `comentarios` varchar(255) DEFAULT NULL,
  `rt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla_consulta`
--

INSERT INTO `tabla_consulta` (`id`, `operador`, `turno`, `clientes`, `paises`, `estado`, `publica`, `links`, `fecha_publicacion`, `enfoque`, `likes`, `comentarios`, `rt`) VALUES
(9, 'prueba', 'Matutino', 'LopezDoriga', 'a', 'QUINTANAROO', 'XD', 'https://www.google.com/', '2022-08-01', 'a', '12', '123', '1'),
(10, 'prueba', 'Matutino', 'a', 'Mexico', '', 'a', 'a', '2023-08-05', 'a', '2', '1', '2'),
(11, 'Ejecutivo1', 'Matutino', 'R', 'Mexico', 'Nayarit', '1', '1', '0001-01-01', '1', '1', '1', '1'),
(12, 'prueba', 'Matutino', 'Darwin Cab', 'Mexico', 'Quintana Roo', 'a', 'a', '2023-08-23', '123', '1231', '12312', '214312');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tabla_estatus`
--

CREATE TABLE `tabla_estatus` (
  `id` int(11) NOT NULL,
  `operador` varchar(255) DEFAULT NULL,
  `turno` varchar(255) DEFAULT NULL,
  `consulta_id` int(11) DEFAULT NULL,
  `pais` varchar(255) DEFAULT NULL,
  `entidad` varchar(255) DEFAULT NULL,
  `partido` varchar(255) DEFAULT NULL,
  `coalicion` varchar(255) DEFAULT NULL,
  `cliente` varchar(255) DEFAULT NULL,
  `identidad_perfil` varchar(255) DEFAULT NULL,
  `reaccion` varchar(255) DEFAULT NULL,
  `nombre_usuario` varchar(255) DEFAULT NULL,
  `usuario` varchar(255) DEFAULT NULL,
  `contrasena` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `compania` varchar(255) DEFAULT NULL,
  `id_chip` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` varchar(255) DEFAULT NULL,
  `cuenta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tabla_estatus`
--

INSERT INTO `tabla_estatus` (`id`, `operador`, `turno`, `consulta_id`, `pais`, `entidad`, `partido`, `coalicion`, `cliente`, `identidad_perfil`, `reaccion`, `nombre_usuario`, `usuario`, `contrasena`, `correo`, `telefono`, `compania`, `id_chip`, `fecha_nacimiento`, `sexo`, `cuenta`) VALUES
(33, 'Charles', 'Matutino', NULL, NULL, 'a', 'PAN', 'a', 'a', 'Profesor', 'adulacion', 'a', 'ae', 'a', 'a', 'a', 'a', '', '2023-07-20', 'f', 'Activa'),
(34, 'Charles', 'Matutino', NULL, NULL, 'a', 'PARTIDO VERDE', 'a', 'a', 'Artista', 'adulacion', 'a', 'a', 'a', 'a', 'a', 'a', '', '2023-01-11', 'a', 'Activa'),
(35, 'Charles', 'Matutino', NULL, NULL, 'a', 'MORENA', 'a', 'Darwin', 'Artista', 'adulacion', 'a', 'e', 'a', 'a', 'a', 'a', '', '2023-07-06', 'f', 'Apelacion'),
(36, 'prueba', 'Matutino', NULL, NULL, 'CANCUN', 'Morena', '4T', 'LopezDoriga', 'Profesor', 'positiva', 'Darwin', 'Charles', '12345', 'darwin@gmail.com', '1234567891', '', '', '2023-08-17', 'Masculino', 'Activa'),
(37, 'Ejecutivo1', 'Matutino', NULL, NULL, 'CANCUN', 'PAN', '4T', 'LopezDoriga', 'Estudiante', 'positiva', 'as', 'asax', '12345', 'csa.com', '5423', 'Idsa', 'TELCEL', '1111-11-11', 'Masculino', 'Nueva'),
(38, 'Ejecutivo1', 'Matutino', NULL, NULL, 'CANCUN', 'Partido Verde', '123456', 'Y', 'Profesional', 'positiva', 'a', 'a', 'a1235', '12', '1234567891', 'ESCA', 'AS', '5622-04-12', 'Masculino', 'Nueva'),
(39, 'prueba', 'Matutino', NULL, 'Mexico', 'Baja California', 'PAN', 'a', 'aa', 'Estudiante', 'adulacion', 'a', 'a', 'a', 'a', '1', 'A', 'A', '2023-08-18', 'f', 'Nueva'),
(40, 'prueba', 'Matutino', NULL, 'Mexico', 'Morelos', 'PRI', 'e', 'e', 'Profesor', 'positiva', 'e', 'e', 'e', 'e', '2', 'E', 'E', '2023-08-25', 'F', 'Nueva'),
(41, 'prueba', 'Matutino', NULL, 'Mexico', 'Quintana Roo', 'PAN', 'Ecologia', 'Darwin Cab', 'Profesional', 'positiva', 'DarwinCab', 'DarwinCab', '12345', 'darwincab@hotmail.com', '9982731243', 'TELCEL', '231', '2000-02-03', 'Masculina', 'Nueva');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `usuario` varchar(250) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES
(1, 'prueba', 'prueba', '12345', 1),
(10, 'Darwin', 'Charles', '12345', 1),
(12, 'Ejecutivo 1', 'Ejecutivo1', '12345', 1),
(13, 'Operador 1', 'Operador1', '12345', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `tabla_consulta`
--
ALTER TABLE `tabla_consulta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tabla_estatus`
--
ALTER TABLE `tabla_estatus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consulta_id` (`consulta_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_cargo` (`id_cargo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tabla_consulta`
--
ALTER TABLE `tabla_consulta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tabla_estatus`
--
ALTER TABLE `tabla_estatus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tabla_estatus`
--
ALTER TABLE `tabla_estatus`
  ADD CONSTRAINT `tabla_estatus_ibfk_1` FOREIGN KEY (`consulta_id`) REFERENCES `tabla_consulta` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
