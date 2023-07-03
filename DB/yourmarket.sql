-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 03 juil. 2023 à 10:55
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `yourmarket`
--

-- --------------------------------------------------------

--
-- Structure de la table `bids`
--

DROP TABLE IF EXISTS `bids`;
CREATE TABLE IF NOT EXISTS `bids` (
  `id` int NOT NULL AUTO_INCREMENT,
  `itemId` int NOT NULL,
  `price` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contains`
--

DROP TABLE IF EXISTS `contains`;
CREATE TABLE IF NOT EXISTS `contains` (
  `cartId` int NOT NULL,
  `itemId` int NOT NULL,
  PRIMARY KEY (`cartId`,`itemId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `have`
--

DROP TABLE IF EXISTS `have`;
CREATE TABLE IF NOT EXISTS `have` (
  `idLink` int NOT NULL,
  `idItem` int NOT NULL,
  PRIMARY KEY (`idLink`,`idItem`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historicoffers`
--

DROP TABLE IF EXISTS `historicoffers`;
CREATE TABLE IF NOT EXISTS `historicoffers` (
  `id` int NOT NULL,
  `proposedByUserId` int NOT NULL,
  `towardUserId` int NOT NULL,
  `price` int NOT NULL,
  `status` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hold`
--

DROP TABLE IF EXISTS `hold`;
CREATE TABLE IF NOT EXISTS `hold` (
  `orderId` int NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`orderId`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `descriptions` varchar(999) NOT NULL,
  `price` int NOT NULL,
  `categories` int NOT NULL,
  `available` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `make`
--

DROP TABLE IF EXISTS `make`;
CREATE TABLE IF NOT EXISTS `make` (
  `username` varchar(100) NOT NULL,
  `offerId` int NOT NULL,
  PRIMARY KEY (`username`,`offerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE IF NOT EXISTS `offers` (
  `offerId` int NOT NULL AUTO_INCREMENT,
  `itemId` int NOT NULL,
  `offerAmount` int NOT NULL,
  `offerTime` date NOT NULL,
  PRIMARY KEY (`offerId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` int NOT NULL AUTO_INCREMENT,
  `itemId` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`orderId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `picturesvideos`
--

DROP TABLE IF EXISTS `picturesvideos`;
CREATE TABLE IF NOT EXISTS `picturesvideos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `link` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

DROP TABLE IF EXISTS `place`;
CREATE TABLE IF NOT EXISTS `place` (
  `bidId` int NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`bidId`,`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `possess`
--

DROP TABLE IF EXISTS `possess`;
CREATE TABLE IF NOT EXISTS `possess` (
  `username` varchar(100) NOT NULL,
  `cartId` int NOT NULL,
  PRIMARY KEY (`username`,`cartId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `put`
--

DROP TABLE IF EXISTS `put`;
CREATE TABLE IF NOT EXISTS `put` (
  `username` varchar(100) NOT NULL,
  `idLink` int NOT NULL,
  PRIMARY KEY (`username`,`idLink`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sell`
--

DROP TABLE IF EXISTS `sell`;
CREATE TABLE IF NOT EXISTS `sell` (
  `username` varchar(100) NOT NULL,
  `idItem` int NOT NULL,
  PRIMARY KEY (`username`,`idItem`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `cartId` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`cartId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(100) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `familyName` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `passwd` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `roles` int NOT NULL,
  `activated` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `firstName`, `familyName`, `email`, `phone`, `passwd`, `roles`, `activated`) VALUES
('cena', 'john', 'ici', 'jc@gmail.com', '10', 'pp', 0, 0),
('joha', 'julien', 'oha', 'joha@gmail.com', '06', '123', 0, 0),
('hihi', 'haha', 'hoho', 'hehe@gmail.com', '06', 'huhu', 0, 0),
('c', 'a', 'b', 'd@gmail.com', '04', 'e', 0, 0),
('j', 'jack', 'chong', 'j@gmail.com', '00', '01', 0, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
