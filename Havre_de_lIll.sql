-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2018 at 05:31 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Havre_de_lIll`
--

-- --------------------------------------------------------

--
-- Table structure for table `Accueil`
--

CREATE TABLE `Accueil` (
  `id` int(11) NOT NULL,
  `titre` varchar(256) NOT NULL,
  `texte` longtext NOT NULL,
  `urlImage` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Admin`
--

CREATE TABLE `Admin` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `mail` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Chambres`
--

CREATE TABLE `Chambres` (
  `id` int(11) NOT NULL,
  `titre` longtext NOT NULL,
  `texte` longtext NOT NULL,
  `prix` varchar(45) NOT NULL,
  `style` varchar(45) NOT NULL,
  `literie` varchar(45) NOT NULL,
  `accessibilite` varchar(45) NOT NULL,
  `salleDeBain` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `DiapoAccueil`
--

CREATE TABLE `DiapoAccueil` (
  `id` int(11) NOT NULL,
  `urlImage` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `DiapoChambres`
--

CREATE TABLE `DiapoChambres` (
  `id` int(11) NOT NULL,
  `urlImage` longtext NOT NULL,
  `chambres_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Localisation`
--

CREATE TABLE `Localisation` (
  `id` int(11) NOT NULL,
  `numPortable` longtext NOT NULL,
  `numFixe` longtext NOT NULL,
  `texte` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Parlementaires`
--

CREATE TABLE `Parlementaires` (
  `id` int(11) NOT NULL,
  `texte` longtext NOT NULL,
  `urlImage` longtext NOT NULL,
  `titre` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `id` int(11) NOT NULL,
  `chambre_id` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `mailClient` varchar(256) NOT NULL,
  `nomClient` varchar(256) NOT NULL,
  `prenomClient` varchar(256) NOT NULL,
  `telClient` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ReservationEnAttente`
--

CREATE TABLE `ReservationEnAttente` (
  `id` int(11) NOT NULL,
  `chambre_id` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `mailClient` varchar(256) NOT NULL,
  `nomClient` varchar(256) NOT NULL,
  `prenomClient` varchar(256) NOT NULL,
  `telClient` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Accueil`
--
ALTER TABLE `Accueil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Admin`
--
ALTER TABLE `Admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Chambres`
--
ALTER TABLE `Chambres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DiapoAccueil`
--
ALTER TABLE `DiapoAccueil`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DiapoChambres`
--
ALTER TABLE `DiapoChambres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chambres_id` (`chambres_id`);

--
-- Indexes for table `Localisation`
--
ALTER TABLE `Localisation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Parlementaires`
--
ALTER TABLE `Parlementaires`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chambre_id` (`chambre_id`);

--
-- Indexes for table `ReservationEnAttente`
--
ALTER TABLE `ReservationEnAttente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chambre_id` (`chambre_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Accueil`
--
ALTER TABLE `Accueil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Chambres`
--
ALTER TABLE `Chambres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `DiapoAccueil`
--
ALTER TABLE `DiapoAccueil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `DiapoChambres`
--
ALTER TABLE `DiapoChambres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Localisation`
--
ALTER TABLE `Localisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Parlementaires`
--
ALTER TABLE `Parlementaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Reservation`
--
ALTER TABLE `Reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ReservationEnAttente`
--
ALTER TABLE `ReservationEnAttente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Chambres`
--
ALTER TABLE `Chambres`
  ADD CONSTRAINT `Chambres_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Reservation` (`chambre_id`);

--
-- Constraints for table `DiapoChambres`
--
ALTER TABLE `DiapoChambres`
  ADD CONSTRAINT `DiapoChambres_ibfk_1` FOREIGN KEY (`chambres_id`) REFERENCES `Chambres` (`id`);

--
-- Constraints for table `ReservationEnAttente`
--
ALTER TABLE `ReservationEnAttente`
  ADD CONSTRAINT `ReservationEnAttente_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Chambres` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
