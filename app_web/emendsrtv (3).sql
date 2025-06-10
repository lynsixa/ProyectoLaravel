-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2025 a las 19:15:37
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
-- Base de datos: `emendsrtv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `Nombre` varchar(105) NOT NULL,
  `Descripcion` varchar(450) NOT NULL,
  `Foto1` varchar(350) NOT NULL,
  `Foto2` varchar(350) DEFAULT NULL,
  `Foto3` varchar(350) DEFAULT NULL,
  `Producto_idProducto` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigonis`
--

CREATE TABLE `codigonis` (
  `idCodigoNis` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL,
  `Disponibilidad` tinyint(4) NOT NULL,
  `Menu_idMenu` int(11) NOT NULL,
  `Mesa_idMesa` int(11) NOT NULL,
  `Eventos_idEventos` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `codigonis`
--

INSERT INTO `codigonis` (`idCodigoNis`, `Descripcion`, `Disponibilidad`, `Menu_idMenu`, `Mesa_idMesa`, `Eventos_idEventos`, `created_at`, `updated_at`) VALUES
(13, '32', 1, 1, 5, NULL, '2025-04-30 01:41:15', '2025-04-30 01:41:15'),
(15, '65', 0, 2, 7, 2, '2025-04-30 02:00:19', '2025-04-30 02:06:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `idEntrega` int(11) NOT NULL,
  `Entrega_idEntrega` int(11) UNSIGNED DEFAULT NULL,
  `Descripcion` varchar(450) DEFAULT NULL,
  `Informe` varchar(250) DEFAULT NULL,
  `Entregado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrega`
--

INSERT INTO `entrega` (`idEntrega`, `Entrega_idEntrega`, `Descripcion`, `Informe`, `Entregado`) VALUES
(1, 1, 'Entrega de 10 copas de vino tinto', 'no hay de eso', 1),
(2, 3, 'Entrega de 5 botellas de tequila', 'no hay producto', -1),
(3, 5, 'Entrega de 3 cajas de cerveza artesanal', 'si', 0),
(4, 7, 'Entrega de 20 vasos de cristal', 'Motivo: no hay vino', 0),
(5, 9, 'Entrega de 15 botellas de vino rosado', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEventos` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `Descripcion` varchar(50) NOT NULL,
  `Fecha_Evento` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idEventos`, `Titulo`, `Descripcion`, `Fecha_Evento`) VALUES
(2, 'asda', 'd', '2025-04-20 14:21:00'),
(4, '1', 'sadsad', '2025-04-18 16:20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL,
  `Descripcion` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idMenu`, `Descripcion`) VALUES
(1, 'Menú Común'),
(2, 'Menú de Evento');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mesa`
--

CREATE TABLE `mesa` (
  `idMesa` int(11) NOT NULL,
  `NumeroPiso` int(11) NOT NULL,
  `NumeroMesa` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mesa`
--

INSERT INTO `mesa` (`idMesa`, `NumeroPiso`, `NumeroMesa`, `created_at`, `updated_at`) VALUES
(3, 1, 1, '2025-04-29 20:22:34', '2025-04-29 20:22:34'),
(4, 1, 1, '2025-04-29 20:23:38', '2025-04-29 20:23:38'),
(5, 32, 32, '2025-04-30 01:39:49', '2025-04-30 01:39:49'),
(6, 43, 43, '2025-04-30 01:46:42', '2025-04-30 01:46:42'),
(7, 56, 56, '2025-04-30 02:00:19', '2025-04-30 02:00:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `idOrden` int(11) NOT NULL,
  `TokenCliente` varchar(450) DEFAULT NULL,
  `Descripcion` varchar(450) NOT NULL,
  `PrecioFinal` float NOT NULL,
  `Fecha` datetime NOT NULL,
  `Producto_idProducto` int(11) DEFAULT NULL,
  `Solicitud_idSolicitud` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL DEFAULT 1,
  `Usuario_idUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `Precio` decimal(10,3) NOT NULL,
  `Disponibilidad` tinyint(4) NOT NULL,
  `Cantidad` int(11) NOT NULL,
  `CodigoNis_idCodigoNis` int(11) DEFAULT NULL,
  `Categoria_idCategoria` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRoles` int(11) NOT NULL,
  `Descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRoles`, `Descripcion`) VALUES
(1, 'Administrador'),
(2, 'Gerente'),
(3, 'Mesero'),
(4, 'Usuario'),
(5, 'Bartender');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud`
--

CREATE TABLE `solicitud` (
  `idSolicitud` int(11) NOT NULL,
  `Descripcion` varchar(405) NOT NULL,
  `Informe` varchar(450) DEFAULT NULL,
  `Despachado` tinyint(4) NOT NULL,
  `Entrega_idEntrega` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitud`
--

INSERT INTO `solicitud` (`idSolicitud`, `Descripcion`, `Informe`, `Despachado`, `Entrega_idEntrega`, `created_at`, `updated_at`) VALUES
(1, 'Pedido de 10 copas de vino tinto', NULL, 1, NULL, '2025-05-07 15:52:32', '2025-05-07 16:39:03'),
(2, 'Pedido de 5 botellas de tequila', '\nMotivo: no hay', -1, NULL, '2025-05-07 15:52:32', '2025-05-07 16:00:51'),
(3, 'Pedido de 3 cajas de cerveza artesanal', NULL, 1, NULL, '2025-05-07 15:52:32', '2025-05-07 16:05:26'),
(4, 'Pedido de 20 vasos de cristal', '\nMotivo: no hay vino', -1, NULL, '2025-05-07 15:52:32', '2025-05-07 16:05:39'),
(5, 'Pedido de 15 botellas de vino rosado', NULL, 1, NULL, '2025-05-07 15:52:32', '2025-05-07 16:39:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_de_documento`
--

CREATE TABLE `tipo_de_documento` (
  `idTipodedocumento` int(11) NOT NULL,
  `Descripcion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_de_documento`
--

INSERT INTO `tipo_de_documento` (`idTipodedocumento`, `Descripcion`) VALUES
(1, 'Cédula de ciudadanía'),
(2, 'Pasaporte'),
(3, 'Cédula de extranjería'),
(4, 'Permiso especial de permanencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(11) NOT NULL,
  `Nombres` varchar(45) NOT NULL,
  `Apellidos` varchar(45) NOT NULL,
  `Documento` varchar(35) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contraseña` varbinary(200) NOT NULL,
  `FechaDeNacimiento` date NOT NULL,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(100) DEFAULT NULL,
  `password_request` int(11) DEFAULT 0,
  `Tipo_de_documento_idTipodedocumento` int(11) DEFAULT NULL,
  `Roles_idRoles` int(11) NOT NULL,
  `CodigoNis_idCodigoNis` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `Nombres`, `Apellidos`, `Documento`, `Correo`, `Contraseña`, `FechaDeNacimiento`, `token`, `token_password`, `password_request`, `Tipo_de_documento_idTipodedocumento`, `Roles_idRoles`, `CodigoNis_idCodigoNis`, `created_at`, `updated_at`) VALUES
(2, 'Lyahn', 'vargas', '1030531161', 'trollgamem@gmail.com', 0x24327924313224776179334e72506c756b69715259725a7759684a4f2e3330355651664d33454852526154797550622e6143547755413568372f4443, '2004-11-14', 'gNc7MqFbLkdYIx3OO3NU59OFSl925LHxDrZX3eUN', NULL, 0, 1, 3, NULL, '2025-04-28 23:27:38', '2025-05-07 16:24:31'),
(3, 'Juan', 'Pérez', '123456789', 'juan.perez@email.com', 0x70617373776f72645f656e6372697074616461, '1990-01-01', 'token123', 'token_pass123', 0, 1, 1, NULL, '2025-04-29 22:15:02', '2025-04-29 22:15:02'),
(5, '12343', '123324', '123234', '123@gmail.com', 0x2432792431322465694c6e6f634d71394957377656546d4c64466d702e4a2f317a7846353868636d45645639446e3839615569416e392e2f344b7247, '2001-02-28', 'nvxKavfSNXeZVlVCHfvghhlaUttBujGJSrpKsfOH', NULL, 0, 2, 2, NULL, '2025-04-30 03:43:43', '2025-04-30 03:49:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`),
  ADD KEY `Producto_idProducto` (`Producto_idProducto`);

--
-- Indices de la tabla `codigonis`
--
ALTER TABLE `codigonis`
  ADD PRIMARY KEY (`idCodigoNis`),
  ADD KEY `Menu_idMenu` (`Menu_idMenu`),
  ADD KEY `Mesa_idMesa` (`Mesa_idMesa`),
  ADD KEY `Eventos_idEventos` (`Eventos_idEventos`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`idEntrega`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEventos`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idMenu`);

--
-- Indices de la tabla `mesa`
--
ALTER TABLE `mesa`
  ADD PRIMARY KEY (`idMesa`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`idOrden`),
  ADD KEY `Producto_idProducto` (`Producto_idProducto`),
  ADD KEY `Solicitud_idSolicitud` (`Solicitud_idSolicitud`),
  ADD KEY `Usuario_idUsuario` (`Usuario_idUsuario`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `CodigoNis_idCodigoNis` (`CodigoNis_idCodigoNis`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRoles`);

--
-- Indices de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD PRIMARY KEY (`idSolicitud`),
  ADD KEY `Entrega_idEntrega` (`Entrega_idEntrega`);

--
-- Indices de la tabla `tipo_de_documento`
--
ALTER TABLE `tipo_de_documento`
  ADD PRIMARY KEY (`idTipodedocumento`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `Tipo_de_documento_idTipodedocumento` (`Tipo_de_documento_idTipodedocumento`),
  ADD KEY `Roles_idRoles` (`Roles_idRoles`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `codigonis`
--
ALTER TABLE `codigonis`
  MODIFY `idCodigoNis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `entrega`
--
ALTER TABLE `entrega`
  MODIFY `idEntrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEventos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mesa`
--
ALTER TABLE `mesa`
  MODIFY `idMesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `idOrden` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRoles` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `solicitud`
--
ALTER TABLE `solicitud`
  MODIFY `idSolicitud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_de_documento`
--
ALTER TABLE `tipo_de_documento`
  MODIFY `idTipodedocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD CONSTRAINT `categoria_ibfk_1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `codigonis`
--
ALTER TABLE `codigonis`
  ADD CONSTRAINT `codigonis_ibfk_1` FOREIGN KEY (`Menu_idMenu`) REFERENCES `menu` (`idMenu`),
  ADD CONSTRAINT `codigonis_ibfk_2` FOREIGN KEY (`Mesa_idMesa`) REFERENCES `mesa` (`idMesa`),
  ADD CONSTRAINT `codigonis_ibfk_3` FOREIGN KEY (`Eventos_idEventos`) REFERENCES `eventos` (`idEventos`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `orden_ibfk_1` FOREIGN KEY (`Producto_idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `orden_ibfk_2` FOREIGN KEY (`Solicitud_idSolicitud`) REFERENCES `solicitud` (`idSolicitud`),
  ADD CONSTRAINT `orden_ibfk_3` FOREIGN KEY (`Usuario_idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`CodigoNis_idCodigoNis`) REFERENCES `codigonis` (`idCodigoNis`);

--
-- Filtros para la tabla `solicitud`
--
ALTER TABLE `solicitud`
  ADD CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`Entrega_idEntrega`) REFERENCES `entrega` (`idEntrega`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`Tipo_de_documento_idTipodedocumento`) REFERENCES `tipo_de_documento` (`idTipodedocumento`),
  ADD CONSTRAINT `usuario_ibfk_2` FOREIGN KEY (`Roles_idRoles`) REFERENCES `roles` (`idRoles`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
