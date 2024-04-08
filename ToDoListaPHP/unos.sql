-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Tnaziv: Sep 28, 2022 at 01:46 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `todolista`
--
CREATE DATABASE IF NOT EXISTS `todolista` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `todolista`;

-- --------------------------------------------------------

--
-- Table structure for table `dogadjaj`
--То До листа (ИД догађаја, Назив, Датум, Број учесника)


CREATE TABLE IF NOT EXISTS `dogadjaj` (
  `id` int(11) NOT NULL,
  `naziv` varchar(100) NOT NULL,
  `datum` DATE NOT NULL,
  `brojUcesnika` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dogadjaj`
--

INSERT INTO `dogadjaj` (`id`, `naziv`, `datum`, `brojUcesnika`) VALUES
(1, 'Velika Seoba', '22.04.2024', 2),
(2, 'Skok sa gimnazije', '23.04.2024', 1),
(3, 'Let pod kola', '25.04.2024.', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dogadjaj`
--
ALTER TABLE `dogadjaj`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dogadjaj`
--
ALTER TABLE `dogadjaj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;