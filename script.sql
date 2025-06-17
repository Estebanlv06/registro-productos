SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `registro_productos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `registro_productos`;

CREATE TABLE `bodegas` (
    `id` int NOT NULL,
    `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `bodegas` (`id`, `nombre`) VALUES
(1, 'Bodega 1'),
(2, 'Bodega 2'),
(3, 'Bodega 3');

CREATE TABLE `monedas` (
    `id` int NOT NULL,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `monedas` (`id`, `nombre`) VALUES
(1, 'Peso chileno'),
(2, 'Dólar'),
(3, 'Euro');

CREATE TABLE `productos` (
    `id` int NOT NULL,
    `codigo` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
    `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
    `id_bodega` int DEFAULT NULL,
    `id_sucursal` int DEFAULT NULL,
    `id_moneda` int DEFAULT NULL,
    `precio` decimal(10,2) NOT NULL,
    `descripcion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    `materiales` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sucursales` (
    `id` int NOT NULL,
    `id_bodega` int DEFAULT NULL,
    `nombre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sucursales` (`id`, `id_bodega`, `nombre`) VALUES
(1, 1, 'Sucursal 1.1'),
(2, 1, 'Sucursal 1.2'),
(3, 2, 'Sucursal 2.1'),
(4, 2, 'Sucursal 2.2'),
(5, 3, 'Sucursal 3.1');

ALTER TABLE `bodegas`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `monedas`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `productos`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `codigo` (`codigo`),
    ADD KEY `id_bodega` (`id_bodega`),
    ADD KEY `id_sucursal` (`id_sucursal`),
    ADD KEY `id_moneda` (`id_moneda`);

ALTER TABLE `sucursales`
    ADD PRIMARY KEY (`id`),
    ADD KEY `id_bodega` (`id_bodega`);

ALTER TABLE `bodegas`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `monedas`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `productos`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `sucursales`
    MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `productos`
    ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_bodega`) REFERENCES `bodegas` (`id`),
    ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursales` (`id`),
    ADD CONSTRAINT `productos_ibfk_3` FOREIGN KEY (`id_moneda`) REFERENCES `monedas` (`id`);

ALTER TABLE `sucursales`
    ADD CONSTRAINT `sucursales_ibfk_1` FOREIGN KEY (`id_bodega`) REFERENCES `bodegas` (`id`);
COMMIT;