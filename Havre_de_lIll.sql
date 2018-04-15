-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 14, 2018 at 05:37 PM
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

--
-- Dumping data for table `Accueil`
--

INSERT INTO `Accueil` (`id`, `titre`, `texte`, `urlImage`) VALUES
(1, 'Histoire', 'Construit en 1852, le Havre de l’Ill fut à l’origine un hôtel particulier de la famille Lauth mais celle-ci revendi la bâtisse en 1871 sous l’occupation allemande. Elle changea de main plusieures fois pendant le siècle qui suivit au grès des fortunes et infortunes des propriétaires avant d’être finalement rachetée par M. Jean-Marc Olivier en 1952 tout pile un siècle après sa construction. De nombreuses rénovations sont alors entreprises afin de transformer la bâtisse en habitation confortable en adéquation avec les standards de l’époque. Depuis, le Havre de l’Ill suit l’évolution des équipements domestiques. Depuis 2015 la maison n’est plus habitée que sporadiquement du fait des activités des membres de la famille. C’est alors que M. Franck Olivier décide d’ouvrir ses portes aux visiteurs de passage à Strasbourg.\r\n\r\n', '/assets/images/histoire.png'),
(2, 'Ambiance', 'Une parenthèse de luxe, une atmosphère relaxante et un confort haut de gamme dans le centre-ville de Strasbourg. C\'est dans sa maison d\'hôte à colombages que Mr Jean-Marc Olivier vous accueille en hôtes de luxe. Le Havre de l’Ill est un lieu de détente et de relaxation. Après avoir posé vos valises et dégusté une tisane de plantes locales ou un rafraîchissement maison, vous pourrez partir à la découverte de la magnifique ville de Strasbourg. Nous sommes à 5 minutes à pieds de notre belle cathédrale et du centre ville (un parking se trouve à 50m de la résidence).\r\nNotre havre vous accueille dans l’une de ces 4 chambres d’hôte de charme allant de 30 à 40 m2, spacieuses et lumineuses, proposant tout le confort nécessaire, ainsi qu’un accueil et des services de qualité.', '/assets/images/ambiance.png');

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

--
-- Dumping data for table `Admin`
--

INSERT INTO `Admin` (`id`, `name`, `password`, `mail`) VALUES
(1, 'Olivier', '123456', 'olivier.f@wild.fr');

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
  `accessibilite` varchar(3) NOT NULL,
  `salleDeBain` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Chambres`
--

INSERT INTO `Chambres` (`id`, `titre`, `texte`, `prix`, `style`, `literie`, `accessibilite`, `salleDeBain`) VALUES
(1, 'Chambre Gretel', 'Chambre confortable de 20 m² (avec un coin bureau), de style typiquement Alsacien, salle de bains avec baignoire, marbres rares et superbes compositions décoratives. Elle offre une vue sur la cour intérieure de la maison ou sur la cathédrale .notre chambres Classique est pourvues d\'un lit Queen Size.', '150', 'Classique', 'Lit double', 'Non', 'Baignoire'),
(2, 'Chambre Simone Veil', 'Authentique et pur avec ses meubles en acajou. Dans cette véritable chambre entièrement équipée, des galets gris au sol. Son canapé-lit vous invite à vous relaxer la journée et se transforme en lit de 90 x 200 pour une personnes . Sa petite salle de bain est équipée avec une douche. Derrière la maison, une terrasse avec deux fauteuils et un canapé à côté de notre terrain de boule vous invitent à la relaxation.\r\n', '250', 'Moderne', 'Lit simple + canapé transformé en lit', 'Non', 'Douche'),
(3, 'Chambre Hänsel', 'Entre amis ou en famille, la chambre Hänsel vous accueille dans un univers raffiné où se mêlent meubles patinés, terre cuite au sol avec des empreintes d’animaux et autres objet de décoration très recherchés, le tout dans des couleurs chaleureuses et douces. Sa salle de bain vous charmera par le style rétro de sa douche. Derrière la « séparation » - une authentique fenêtre industrielle en fer forgé - une vasque posée sur une table venant de l’ancienne Indochine. Au sol des galets plats coupés. Cette belle chambre avec ses deux lits séparés se trouve au rez-de-chaussée avec les toilettes en face de la chambre. Elle a vue sur le jardin et la terrasse du Cabanon Jeanne d’Arc. C’est pourquoi les deux sont souvent louées ensemble, entre amis ou pour une famille avec des enfants.', '190', 'Classique', 'Lits Simples', 'Non', 'Douche'),
(4, 'Chambre Robert Schuman', 'Cette très belle chambre moderne vous accueille au rez-de-chaussée avec sa grande fenêtre ouverte sur le jardin, Son intérieur avec un petit coin repos dans la tour recèle de matières nobles et chaleureuses, dans sa salle de bain au design moderne.', '280', 'Moderne', 'Lit double', 'Oui', 'Baignoire');

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

--
-- Dumping data for table `DiapoChambres`
--

INSERT INTO `DiapoChambres` (`id`, `urlImage`, `chambres_id`) VALUES
(1, '/assets/images/chambreGretel.png', 1),
(2, '/assets/images/chambreGretelsdb.png', 1),
(3, '/assets/images/chambreSimoneVeil.png', 2),
(4, '/assets/images/chambreSimoneVeilsdb.png', 2),
(5, '/assets/images/chambreHansel.png', 3),
(6, '/assets/images/chambreHanselsdb.png', 3),
(7, '/assets/images/chambreRobertSchuman.png', 4),
(8, '/assets/images/chambreRobertSchumansdb.png', 4);

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

--
-- Dumping data for table `Localisation`
--

INSERT INTO `Localisation` (`id`, `numPortable`, `numFixe`, `texte`) VALUES
(1, '06.78.49.00.00 / (+33)6.78.49.00.00', '03.08.99.04.04 / (+33)3.08.99.04.04', 'Vous souhaitez passer un séjour agréable et reposant au coeur de l\'Alsace dans un cadre luxuriant et authentique ? Venez découvrir notre maison d\'hôte le Havre de l’Ill , qui se trouve en plein cœur des marchés de Noël, au pied de la cathédrale Notre-Dame de Strasbourg et de la place Gutenberg.\r\n');

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

--
-- Dumping data for table `Parlementaires`
--

INSERT INTO `Parlementaires` (`id`, `texte`, `urlImage`, `titre`) VALUES
(1, 'Built in 1852, The Havre de l’Ill was the Lauth family mansion but was sell in 1871. The mansion has been bought and sold many times in it’s first century according the rise and fall of it’s owners. All of it changed in 1952, exactly one century after it’s construction when M. Jean-Marc Oliver bought it. Many renovations were then undertaken to transform the building into a comfortable dwelling keeping up with the standards of the time. Since then, the Havre de l’Ill follows the evolution of domestic equipment. Since 2015 the house is only sporadically inhabited because of the activities of family members. It was then that Mr Franck Olivier decided to open his doors to visitors to Strasbourg.\r\n', '/assets/images/histoire.png', 'History'),
(2, 'A luxury break, a relaxing atmosphere and upscale comfort in the city center of Strasbourg. It is in his hal-timbered guesthouse that Mr Jean-Marc Olivier welcomes you as a luxury guest. Le Havre de l\'Ill is a place of relaxation where after having put down your suitcases and tasted a herbal tea of local plants or a home refreshment, you will be able to go to the discovery of the splendid city of Strasbourg. We are a 5 minutes walk from our beautiful, cathedral and the city center (parking is 50m from the residence). Le Havre de l\'Ill welcomes you in one of these 4 charming guest rooms ranging from 30 to 40 m2, spacious and bright, offering all the necessary comfort, as well as a welcome and quality services.', '/assets/images/ambiance.png', 'Quality of service');

-- --------------------------------------------------------

--
-- Table structure for table `Reservation`
--

CREATE TABLE `Reservation` (
  `id` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `mailClient` varchar(256) NOT NULL,
  `nomClient` varchar(256) NOT NULL,
  `prenomClient` varchar(256) NOT NULL,
  `telClient` longtext NOT NULL,
  `chambre_id` int(11) NOT NULL
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
  ADD KEY `chambres_id` (`chambres_id`),
  ADD KEY `chambres_id_2` (`chambres_id`);

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `Admin`
--
ALTER TABLE `Admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Chambres`
--
ALTER TABLE `Chambres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `DiapoAccueil`
--
ALTER TABLE `DiapoAccueil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `DiapoChambres`
--
ALTER TABLE `DiapoChambres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Localisation`
--
ALTER TABLE `Localisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Parlementaires`
--
ALTER TABLE `Parlementaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- Constraints for table `DiapoChambres`
--
ALTER TABLE `DiapoChambres`
  ADD CONSTRAINT `DiapoChambres_ibfk_1` FOREIGN KEY (`chambres_id`) REFERENCES `Chambres` (`id`);

--
-- Constraints for table `Reservation`
--
ALTER TABLE `Reservation`
  ADD CONSTRAINT `Reservation_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Chambres` (`id`);

--
-- Constraints for table `ReservationEnAttente`
--
ALTER TABLE `ReservationEnAttente`
  ADD CONSTRAINT `ReservationEnAttente_ibfk_1` FOREIGN KEY (`id`) REFERENCES `Chambres` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
