-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 15, 2023 at 04:30 PM
-- Server version: 8.0.33
-- PHP Version: 8.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `partitech`
--

-- --------------------------------------------------------

--
-- Table structure for table `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int NOT NULL,
  `nombre_actividad` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `desc_actividad` text COLLATE utf8mb4_spanish_ci,
  `id_grupo` int DEFAULT NULL,
  `numero_est` int DEFAULT NULL,
  `prof_autor` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuentas`
--

CREATE TABLE `cuentas` (
  `id_user` int NOT NULL,
  `username` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `password` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `email` text CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Dumping data for table `cuentas`
--

INSERT INTO `cuentas` (`id_user`, `username`, `password`, `email`) VALUES
(1, 'ismacinco', '1234abcd..', 'hola@configuroweb.com'),
(2, 'elprofe', '1234abcd..', 'zarate@itsescarcega.edu.mx');

-- --------------------------------------------------------

--
-- Table structure for table `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id_estudiante` int NOT NULL,
  `nombres` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidomat` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellidopat` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupo` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `prof_autor` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `estudiantes`
--

INSERT INTO `estudiantes` (`id_estudiante`, `nombres`, `apellidomat`, `apellidopat`, `grupo`, `prof_autor`) VALUES
(1, 'FELIPE ALBERTO', 'AVILA', 'CRUZ', 'ISMA-7', 1),
(2, 'JAIR DEL ANGEL', 'LOPEZ', 'LOPEZ', 'ISMA-7', 1),
(3, 'JOSUE ABIEL', 'CRUZ', 'RAMIREZ', 'ISMA-5', 1),
(4, 'DIEGO EMILIO', 'GORDILLO', 'NAVARRO', 'ISMA-5', 2),
(5, 'LUIS ANTONIO', 'INURRETA', 'MARTINEZ', 'ISMA-7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `grupos`
--

CREATE TABLE `grupos` (
  `id_grupo` int NOT NULL,
  `carrera` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre_grupo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descgrupo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `prof_autor` int NOT NULL,
  `numero_est` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `grupos`
--

INSERT INTO `grupos` (`id_grupo`, `carrera`, `nombre_grupo`, `descgrupo`, `prof_autor`, `numero_est`) VALUES
(1, 'INGENIERIA EN SISTEMAS COMPUTACIONALES', 'ISMA-5', 'MATUTINO', 2, 20),
(2, 'INGENIERIA EN SISTEMAS COMPUTACIONALES', 'ISMA-7', 'MATUTINO', 2, 20),
(3, 'LICENCIATURA EN ADMINISTRACION', 'LAMA-5', 'MATUTINO', 2, 23),
(4, 'CONTADOR PUBLICO', 'CPMA-1', 'MATUTINO', 2, 23),
(5, 'CONTADOR PUBLICO', 'CPVB-1', '0', 2, 12),
(6, 'INGENIERIA EN SISTEMAS COMPUTACIONALES', 'ISVB-3', 'VESPERTINO', 2, 9),
(7, 'LICENCIATURA EN ADMINISTRACION', 'LAMA-3', 'MATUTINO', 1, 24);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `prof_autor` (`prof_autor`);

--
-- Indexes for table `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id_estudiante`),
  ADD KEY `autores` (`prof_autor`);

--
-- Indexes for table `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `id_usuario` (`prof_autor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id_estudiante` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id_grupo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupos` (`id_grupo`),
  ADD CONSTRAINT `actividades_ibfk_2` FOREIGN KEY (`prof_autor`) REFERENCES `cuentas` (`id_user`);

--
-- Constraints for table `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `autores` FOREIGN KEY (`prof_autor`) REFERENCES `cuentas` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grupos`
--
ALTER TABLE `grupos`
  ADD CONSTRAINT `id_user` FOREIGN KEY (`prof_autor`) REFERENCES `cuentas` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
