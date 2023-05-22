-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-08-2021 a las 17:47:17
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_citas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apl_configuracion`
--

CREATE TABLE `apl_configuracion` (
  `configuracion_id` int(11) NOT NULL,
  `configuracion_nombre` varchar(200) NOT NULL,
  `configuracion_clase` varchar(50) NOT NULL,
  `configuracion_valor` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `apl_configuracion`
--

INSERT INTO `apl_configuracion` (`configuracion_id`, `configuracion_nombre`, `configuracion_clase`, `configuracion_valor`) VALUES
(1, 'nombre_cliente', 'validacion_cliente', 'true'),
(2, 'apellido_p_cliente', 'validacion_cliente', 'true'),
(3, 'apellido_m_cliente', 'validacion_cliente', 'true'),
(4, 'telefono_cliente', 'validacion_cliente', 'true'),
(5, 'correo_cliente', 'validacion_cliente', 'true'),
(6, 'sexo_cliente', 'validacion_cliente', 'false'),
(7, 'edad_cliente', 'validacion_cliente', 'false'),
(8, 'direccion_cliente', 'validacion_cliente', 'false'),
(9, 'nombre_empresa', 'info_empresa', 'Clínica por tu salud'),
(10, 'enviar_correo', 'envio_correos', 'false'),
(11, 'cuenta_correo', 'envio_correos', ''),
(12, 'clave_correo', 'envio_correos', ''),
(13, 'horario_domingo_final', 'horarios', ''),
(14, 'horario_domingo_inicio', 'horarios', ''),
(15, 'horario_sabado_final', 'horarios', '14'),
(16, 'horario_sabado_inicio', 'horarios', '7'),
(17, 'horario_viernes_final', 'horarios', '19'),
(18, 'horario_viernes_inicio', 'horarios', '7'),
(19, 'horario_jueves_final', 'horarios', '19'),
(20, 'horario_jueves_inicio', 'horarios', '7'),
(21, 'horario_miercoles_final', 'horarios', '19'),
(22, 'horario_miercoles_inicio', 'horarios', '7'),
(23, 'horario_martes_final', 'horarios', '19'),
(24, 'horario_martes_inicio', 'horarios', '7'),
(25, 'horario_lunes_final', 'horarios', '19'),
(26, 'horario_lunes_inicio', 'horarios', '7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_categorias`
--

CREATE TABLE `cat_categorias` (
  `categorias_id` int(11) NOT NULL,
  `categorias_nombre` varchar(200) NOT NULL,
  `categorias_descripcion` varchar(1500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_clientes`
--

CREATE TABLE `cat_clientes` (
  `clientes_id` int(11) NOT NULL,
  `clientes_nombre` varchar(200) NOT NULL,
  `clientes_apellido_p` varchar(200) NOT NULL,
  `clientes_apellido_m` varchar(200) NOT NULL,
  `clientes_telefono` varchar(15) NOT NULL,
  `clientes_correo` varchar(200) NOT NULL,
  `clientes_direccion` varchar(800) NOT NULL,
  `clientes_sexo` varchar(8) NOT NULL,
  `clientes_edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_servicios`
--

CREATE TABLE `cat_servicios` (
  `servicios_id` int(11) NOT NULL,
  `servicios_categoria_id` int(11) NOT NULL,
  `servicios_descripcion` varchar(1500) NOT NULL,
  `servicios_nombre` varchar(200) NOT NULL,
  `servicios_duracion` varchar(50) NOT NULL,
  `servicios_precio` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cat_usuarios`
--

CREATE TABLE `cat_usuarios` (
  `usuarios_id` int(11) NOT NULL,
  `usuarios_nombre` varchar(200) NOT NULL,
  `usuarios_apellido_p` varchar(200) NOT NULL,
  `usuarios_apellido_m` varchar(200) NOT NULL,
  `usuarios_telefono` varchar(15) NOT NULL,
  `usuarios_correo` varchar(200) NOT NULL,
  `usuarios_direccion` varchar(800) NOT NULL,
  `usuarios_usuario` varchar(200) NOT NULL,
  `usuarios_clave` varchar(200) NOT NULL,
  `usuarios_rol` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cat_usuarios`
--

INSERT INTO `cat_usuarios` (`usuarios_id`, `usuarios_nombre`, `usuarios_apellido_p`, `usuarios_apellido_m`, `usuarios_telefono`, `usuarios_correo`, `usuarios_direccion`, `usuarios_usuario`, `usuarios_clave`, `usuarios_rol`) VALUES
(1, 'Admin', 'admin', 'angel', '9988776655', '9@hotmail.com', 'Mexico.', 'admin', 'admin', 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ope_citas`
--

CREATE TABLE `ope_citas` (
  `citas_id` int(11) NOT NULL,
  `citas_servicios_id` int(11) NOT NULL,
  `citas_proveedor_id` int(11) NOT NULL,
  `citas_clientes_id` int(11) NOT NULL,
  `citas_estatus` varchar(15) NOT NULL,
  `citas_fecha` date NOT NULL,
  `citas_hora` varchar(5) NOT NULL,
  `citas_notas` varchar(1500) NOT NULL,
  `citas_fecha_creo` date NOT NULL,
  `citas_sala` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ope_descansos`
--

CREATE TABLE `ope_descansos` (
  `descansos_id` int(11) NOT NULL,
  `descansos_dia` varchar(10) NOT NULL,
  `descansos_inicio` varchar(5) NOT NULL,
  `descansos_final` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ope_rel_usuario_servicio`
--

CREATE TABLE `ope_rel_usuario_servicio` (
  `relacion_id` int(11) NOT NULL,
  `usuarios_id` int(11) NOT NULL,
  `servicios_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apl_configuracion`
--
ALTER TABLE `apl_configuracion`
  ADD PRIMARY KEY (`configuracion_id`);

--
-- Indices de la tabla `cat_categorias`
--
ALTER TABLE `cat_categorias`
  ADD PRIMARY KEY (`categorias_id`);

--
-- Indices de la tabla `cat_clientes`
--
ALTER TABLE `cat_clientes`
  ADD PRIMARY KEY (`clientes_id`);

--
-- Indices de la tabla `cat_servicios`
--
ALTER TABLE `cat_servicios`
  ADD PRIMARY KEY (`servicios_id`),
  ADD KEY `fk_servicios_categorias` (`servicios_categoria_id`);

--
-- Indices de la tabla `cat_usuarios`
--
ALTER TABLE `cat_usuarios`
  ADD PRIMARY KEY (`usuarios_id`);

--
-- Indices de la tabla `ope_citas`
--
ALTER TABLE `ope_citas`
  ADD PRIMARY KEY (`citas_id`),
  ADD KEY `citas_clientes_id` (`citas_clientes_id`),
  ADD KEY `fk_citas_servicios` (`citas_servicios_id`),
  ADD KEY `fk_citas_proveedor` (`citas_proveedor_id`);

--
-- Indices de la tabla `ope_descansos`
--
ALTER TABLE `ope_descansos`
  ADD PRIMARY KEY (`descansos_id`);

--
-- Indices de la tabla `ope_rel_usuario_servicio`
--
ALTER TABLE `ope_rel_usuario_servicio`
  ADD PRIMARY KEY (`relacion_id`),
  ADD KEY `fk_relacion_usuarios` (`usuarios_id`) USING BTREE,
  ADD KEY `fk_relacion_servicios` (`servicios_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apl_configuracion`
--
ALTER TABLE `apl_configuracion`
  MODIFY `configuracion_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `cat_categorias`
--
ALTER TABLE `cat_categorias`
  MODIFY `categorias_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_clientes`
--
ALTER TABLE `cat_clientes`
  MODIFY `clientes_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_servicios`
--
ALTER TABLE `cat_servicios`
  MODIFY `servicios_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cat_usuarios`
--
ALTER TABLE `cat_usuarios`
  MODIFY `usuarios_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ope_citas`
--
ALTER TABLE `ope_citas`
  MODIFY `citas_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ope_descansos`
--
ALTER TABLE `ope_descansos`
  MODIFY `descansos_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ope_rel_usuario_servicio`
--
ALTER TABLE `ope_rel_usuario_servicio`
  MODIFY `relacion_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cat_servicios`
--
ALTER TABLE `cat_servicios`
  ADD CONSTRAINT `fk_servicios_categorias` FOREIGN KEY (`servicios_categoria_id`) REFERENCES `cat_categorias` (`categorias_id`);

--
-- Filtros para la tabla `ope_citas`
--
ALTER TABLE `ope_citas`
  ADD CONSTRAINT `fk_citas_clientes` FOREIGN KEY (`citas_clientes_id`) REFERENCES `cat_clientes` (`clientes_id`),
  ADD CONSTRAINT `fk_citas_proveedor` FOREIGN KEY (`citas_proveedor_id`) REFERENCES `cat_usuarios` (`usuarios_id`),
  ADD CONSTRAINT `fk_citas_servicios` FOREIGN KEY (`citas_servicios_id`) REFERENCES `cat_servicios` (`servicios_id`);

--
-- Filtros para la tabla `ope_rel_usuario_servicio`
--
ALTER TABLE `ope_rel_usuario_servicio`
  ADD CONSTRAINT `fk_relacion_servicios` FOREIGN KEY (`servicios_id`) REFERENCES `cat_servicios` (`servicios_id`),
  ADD CONSTRAINT `fk_usuarios_servicios` FOREIGN KEY (`usuarios_id`) REFERENCES `cat_usuarios` (`usuarios_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
