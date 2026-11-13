-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2026 at 04:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tienda_moto`
--

-- --------------------------------------------------------

--
-- Table structure for table `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`) VALUES
(1, 'Yamaha'),
(2, 'Honda'),
(3, 'Kawasaki'),
(4, 'Suzuki'),
(5, 'Husqvarna'),
(6, 'KTM');

-- --------------------------------------------------------

--
-- Table structure for table `motos`
--

CREATE TABLE `motos` (
  `id` int(11) NOT NULL,
  `marca_id` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `cilindrada` varchar(20) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motos`
--

INSERT INTO `motos` (`id`, `marca_id`, `modelo`, `cilindrada`, `precio`, `descripcion`, `imagen`) VALUES
(1, 1, 'Yamaha YZ', '85 cc', 9000.00, 'Moto cross 2T, ideal para niños que comienzan a practicar el deporte.', 'Yamaha_Yz_85.webp'),
(2, 1, 'Yamaha YZF', '450 cc', 17000.00, 'Motocros 4T fuel injection, ideal para adultos con experiencia en el rubro.', 'Yamaha_yzf_450.webp'),
(3, 1, 'Yamaha R1', '1000 cc', 31000.00, 'GP de alta potencia y ágil manejo.', 'Yamaha_Yzf_R1.webp'),
(4, 2, 'Honda CR', '85 cc', 8500.00, 'Moto cross 2T, ideal para niños que comienzan a practicar el deporte.', 'Honda_Cr_85.webp'),
(5, 2, 'Honda CRFx', '450 cc', 19000.00, 'Moto enduro de alto rendimiento. Ideal para competicion off-road', 'Honda_Crfx_450.webp'),
(6, 2, 'Honda CBR', '1000 cc', 32000.00, 'GP tope de gama. Excelente rendimiento en ciudad y ruta.', 'Honda_Cbr_1000.webp'),
(7, 3, 'Kawasaki KX', '85 cc', 8300.00, 'Compacta, divertida y muy ágil. Iniciantes en el motocross', 'Kawasaki_Kx_85.webp'),
(8, 3, 'Kawasaki KXF', '450 cc', 15700.00, 'Deportiva para adultos con excelentes prestaciones para el motocross.', 'Kawasaki_Kxf_450.webp'),
(9, 3, 'Kawasaki ZX10', '1000 cc', 35000.00, 'GP de alto poder, la mas velóz del segmento.', 'Kawasaki_Zx10_1000.webp'),
(10, 4, 'Suzuki RM', '85 cc', 7900.00, 'Motocross para niños muy resistente y de mantenimiento simple.', 'Suzuki_Rm_85.webp'),
(11, 4, 'Suzuki RMZ', '450 cc', 14900.00, 'Estilo y manejo off-road. Robusta y confibable para los caminos mas exigentes', 'Suzuki_Rmz_450.webp'),
(12, 4, 'Suzuki GSX', '1300 cc', 39200.00, 'Moto deportiva de alta cilindrada, ideal trayectos de carretera porlongada', 'Suzuki_Gsx_1000.webp'),
(13, 5, 'Husqvarna Svartpilen 200', '200 cc', 4900.00, 'Diseño neoretro único y excelente ciclística.', 'Husqvarna_Svartpilen_200.webp'),
(14, 5, 'Husqvarna Norden', '901 cc', 28000.00, 'Trial todo terreno. Ideal para viajes estilo off-road.', 'Husqvarna_Norden_901.webp'),
(15, 5, 'Husqvarna FE 350', '350 cc', 22000.00, 'Enduro profesional ligera y potente.', 'Husqvarna_Fe_350.webp'),
(16, 6, 'KTM Duke 200', '200 cc', 4600.00, 'Potencia y aceleración destacada en su segmento.', 'KTM_Duke_200.webp'),
(17, 6, 'KTM EXC', '300 cc', 23200.00, 'Moto enduro 2T de alta competision. Ideal  para Hard Enduro.', 'KTM_Exc_300.webp'),
(18, 6, 'KTM Adventure', '1290 cc', 38000.00, 'Versátil para asfalto y caminos off-road. Tope de gama', 'KTM_Adventure_1290.webp');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `email`, `password`, `creado_en`) VALUES
(1, 'Juan Pérez', 'juan@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m', '2026-11-11 17:39:35'),
(2, 'María Gómez', 'maria@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m', '2026-11-11 17:39:35'),
(3, 'Carlos López', 'carlos@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m', '2026-11-11 17:39:35'),
(4, 'Ana Martínez', 'ana@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m', '2026-11-11 17:39:35'),
(5, 'Luis Rodríguez', 'luis@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m', '2026-11-11 17:39:35'),
(6, 'Laura Sánchez', 'laura@example.com', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHeFXd1xZp/2Hh.y/T9VjZgZ.WbNq3WJ4m', '2026-11-11 17:39:35'),
(7, 'Juan Manuel Alonso Wilczek', 'juan.alonsow@davinci.edu.ar', '$2y$10$m52ORwrnktMv5pprKTkty.f5zWlFOcdkvXk1GBGGvBwEiPOQwUAX2', '2026-11-11 17:50:36'),
(8, 'Jose Luis', 'Jose@hotmail.com', '$2y$10$ETMMaMFvOElBeeggWeaCp.ZhE94.oI/CZ7pXa3119ZlIBqRGcwkaS', '2026-11-11 22:13:32'),
(9, 'Juan Ignacio', 'Igna@gmail.com', '$2y$10$jWujW1d9wuARuUSVJ56D1eYTRrn/lmjFYUkzpLaQDrRM7kWAcMi32', '2026-11-11 22:14:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motos`
--
ALTER TABLE `motos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `motos`
--
ALTER TABLE `motos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `motos`
--
ALTER TABLE `motos`
  ADD CONSTRAINT `motos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
