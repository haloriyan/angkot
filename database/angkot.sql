-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2018 at 02:03 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angkot`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `idadmin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `registered` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `angkot`
--

CREATE TABLE `angkot` (
  `idangkot` int(11) NOT NULL,
  `nama` varchar(2) NOT NULL,
  `added` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angkot`
--

INSERT INTO `angkot` (`idangkot`, `nama`, `added`) VALUES
(668, 'C', 1540434736),
(2384, 'D', 1540431633),
(9160, 'G', 1540429432);

-- --------------------------------------------------------

--
-- Table structure for table `waypoint`
--

CREATE TABLE `waypoint` (
  `idway` int(11) NOT NULL,
  `idangkot` int(11) NOT NULL,
  `coords` varchar(55) NOT NULL,
  `placeName` varchar(155) NOT NULL,
  `added` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `waypoint`
--

INSERT INTO `waypoint` (`idway`, `idangkot`, `coords`, `placeName`, `added`) VALUES
(98, 9160, '-7.2940595155141486|112.73476413325193', 'Ciliwung no 11A, stay in hook , Ciliwung and Cisedane street, Darmo, Wonokromo, Kota SBY, Jawa Timur 60241, Indonesia', 1540430265),
(230, 668, '-7.295485543138566|112.73303913757923', 'Persimpangan Mes Madya Brawijaya, Sawunggaling, Wonokromo, Kota SBY, Jawa Timur, Indonesia', 1540434973),
(12982, 9160, '-7.272242855402437|112.74369052485349', 'Jl. Jend. Basuki Rachmat No.194, Embong Kaliasin, Genteng, Kota SBY, Jawa Timur 60271, Indonesia', 1540431317),
(14038, 9160, '-7.2792299|112.74217670000007', 'Jalan Sriwijaya, Keputran, Surabaya City, East Java, Indonesia', 1540431083),
(18286, 9160, '-7.276084899999999|112.74320699999998', 'Jalan Keputran, Keputran, Surabaya City, East Java, Indonesia', 1540431113),
(20511, 668, '-7.294900272650458|112.73226091492745', 'Jl. Adityawarman No.41, RT.005/RW.11, Sawunggaling, Wonokromo, Kota SBY, Jawa Timur 60242, Indonesia', 1540435009),
(28698, 9160, '-7.270731613308479|112.74399093226316', 'Jl. Embong Cerme No.23, Embong Kaliasin, Genteng, Kota SBY, Jawa Timur 60271, Indonesia', 1540431329),
(31806, 2384, '-7.241421026210903|112.7455016864908', 'Jl. Bunguran No.31 D, Bongkaran, Pabean Cantian, Kota SBY, Jawa Timur 60165, Indonesia', 1540433647),
(40674, 668, '-7.295697456468589|112.73071315944912', 'Jl. Hayam Wuruk Blok H No.39, RT.005/RW.11, Sawunggaling, Wonokromo, Kota SBY, Jawa Timur 60242, Indonesia', 1540435027),
(47693, 9160, '-7.2751151|112.73149620000004', 'Jalan Pandegiling, Wonorejo, Surabaya City, East Java, Indonesia', 1540431102),
(48425, 2384, '-7.2502329|112.73583059999999', 'Jalan Bubutan, Bubutan, Surabaya City, East Java, Indonesia', 1540433320),
(48500, 9160, '-7.2834635|112.73538589999998', 'Jalan Dokter Soetomo, DR. Soetomo, Surabaya City, East Java, Indonesia', 1540431060),
(54887, 2384, '-7.2592587786788405|112.72708228663328', 'Jl. Arjuno No.20, RT.004/RW.07, Sawahan, Kec. Sawahan, Kota SBY, Jawa Timur 60251, Indonesia', 1540432934),
(56198, 9160, '-7.298592990580126|112.73609450892332', 'joyoboyo trem no. 9, Sawunggaling, Wonokromo, Kota SBY, Jawa Timur 60242, Indonesia', 1540429938),
(58525, 2384, '-7.236569800000001|112.74341789999994', 'Jalan Dukuh, Nyamplungan, Surabaya City, East Java, Indonesia', 1540433669),
(64133, 2384, '-7.282220099999998|112.73212000000001', 'Jalan Diponegoro, DR. Soetomo, Surabaya City, East Java, Indonesia', 1540432901),
(71777, 9160, '-7.2933997101506325|112.73042130158069', 'Adityawarman I No.2, RT.004/RW.04, Sawunggaling, Wonokromo, Kota SBY, Jawa Timur 60242, Indonesia', 1540430303),
(72918, 9160, '-7.289062100000001|112.73153150000007', 'Jalan Indragiri, Darmo, Surabaya City, East Java, Indonesia', 1540431028),
(75582, 2384, '-7.298908499999998|112.7365254', 'Terminal Joyoboyo, Sawunggaling, Surabaya City, East Java, Indonesia', 1540432879),
(80932, 9160, '-7.2897020328562725|112.73061240427228', 'Jl. Sibolga No.21, Darmo, Wonokromo, Kota SBY, Jawa Timur 60241, Indonesia', 1540430440),
(83102, 2384, '-7.243334700000001|112.73715089999996', 'Jalan Kebon Rojo, South Krembangan, Surabaya City, East Java, Indonesia', 1540433374),
(89704, 2384, '-7.270454906458714|112.72849849299314', 'Jl. Pasar Kembang No.43, RT.003/RW.02, Wonorejo, Tegalsari, Kota SBY, Jawa Timur 60263, Indonesia', 1540432917),
(92907, 2384, '-7.242604999999998|112.74266409999996', 'Jalan Stasiun Kota, Bongkaran, Surabaya City, East Java, Indonesia', 1540433394),
(94730, 9160, '-7.293612550696733|112.73772529200437', 'Jl. Raya Diponegoro No.25, RT.01/RW.01, Surodakan, Kec. Trenggalek, Kabupaten Trenggalek, Jawa Timur, Indonesia', 1540430238),
(98457, 2384, '-7.2495365|112.73125329999993', 'Jalan Semarang, Gundih, Surabaya City, East Java, Indonesia', 1540433215),
(99824, 9160, '-7.291264872653308|112.72932696030261', 'Jl. Patmosusastro No.106, Darmo, Wonokromo, Kota SBY, Jawa Timur 60256, Indonesia', 1540430332);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`idadmin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `angkot`
--
ALTER TABLE `angkot`
  ADD PRIMARY KEY (`idangkot`);

--
-- Indexes for table `waypoint`
--
ALTER TABLE `waypoint`
  ADD PRIMARY KEY (`idway`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
