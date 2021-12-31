
 drop database if exists cipeca00; --poistaa mikäli löytyy jo saman niminen

 create database c1peca00; -- lisää tietokannan nimeltä 

 use c1peca00;


-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 31, 2021 at 12:33 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `c1peca00`
--

--
-- Table structure for table `tieto`
--

CREATE TABLE `tieto` (
  `id` varchar(50) DEFAULT NULL,
  `puhnro` varchar(50) DEFAULT NULL,
  `osoite` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tieto`
--

INSERT INTO `tieto` (`id`, `puhnro`, `osoite`) VALUES
('cami', '0505347574', 'rauduntie9');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`first_name`, `last_name`, `username`, `password`) VALUES
('camilla', 'peltonen', 'cami', '$2y$10$L0wOLE175TZ3M18w3gWaQOWWcmiawxX8r.VHyEcQ0l18.fAbsrqq6'),
('Risto', 'Rappaaja', 'ripa123', '$2y$10$pLkmmPqpkK23qfinExaAduYYMpk8.uUp4AE.SN4ZiLNiPzBuC3Z6W');

--cami salasana allimac
-- Risto salasana 1234

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tieto`
--
ALTER TABLE `tieto`
  ADD KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tieto`
--
ALTER TABLE `tieto`
  ADD CONSTRAINT `tieto_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
