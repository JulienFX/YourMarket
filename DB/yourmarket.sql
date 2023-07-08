-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : sam. 08 juil. 2023 à 11:04
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contains`
--

DROP TABLE IF EXISTS `contains`;
CREATE TABLE IF NOT EXISTS `contains` (
  `cartId` int NOT NULL,
  `itemId` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`cartId`,`itemId`),
  KEY `fk_itemsCart` (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `have`
--

DROP TABLE IF EXISTS `have`;
CREATE TABLE IF NOT EXISTS `have` (
  `idLink` int NOT NULL,
  `idItem` int NOT NULL,
  PRIMARY KEY (`idLink`,`idItem`),
  KEY `fk_idLinkForItem` (`idItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `have`
--

INSERT INTO `have` (`idLink`, `idItem`) VALUES
(29, 29),
(30, 30);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hold`
--

DROP TABLE IF EXISTS `hold`;
CREATE TABLE IF NOT EXISTS `hold` (
  `orderId` int NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`orderId`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nameItem` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descriptions` varchar(999) NOT NULL,
  `price` double NOT NULL,
  `categories` int NOT NULL,
  `sellType` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `available` tinyint(1) NOT NULL DEFAULT '1',
  `endDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `items`
--

INSERT INTO `items` (`id`, `nameItem`, `descriptions`, `price`, `categories`, `sellType`, `quantity`, `available`, `endDate`) VALUES
(29, 'oui', 'oui', 60, 2, 2, 6, 1, '2027-01-06 16:30:00'),
(30, 'non', 'n', 15, 2, 1, 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `make`
--

DROP TABLE IF EXISTS `make`;
CREATE TABLE IF NOT EXISTS `make` (
  `username` varchar(100) NOT NULL,
  `offerId` int NOT NULL,
  PRIMARY KEY (`username`,`offerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `picturesvideos`
--

DROP TABLE IF EXISTS `picturesvideos`;
CREATE TABLE IF NOT EXISTS `picturesvideos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `link` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `picturesvideos`
--

INSERT INTO `picturesvideos` (`id`, `link`) VALUES
(1, 'Photos/Items/FRNG.png'),
(2, 'Photos/Items/xbox.png'),
(3, 'Photos/Items/FRNG.png'),
(4, 'Photos/Items/FRNG.png'),
(5, 'Photos/Items/FRNG.png'),
(6, 'Photos/Items/FRNG.png'),
(7, 'Photos/Items/FRNG.png'),
(8, 'Photos/Items/FRNG.png'),
(9, 'Photos/Items/xbox.png'),
(10, 'Photos/Items/FRNG.png'),
(11, 'Photos/Items/xbox.png'),
(12, 'Photos/Items/xbox.png'),
(13, 'Photos/Items/xbox.png'),
(14, 'Photos/Items/xbox.png'),
(15, 'Photos/Items/xbox.png'),
(16, 'Photos/Items/xbox.png'),
(17, 'Photos/Items/motherboard.png'),
(18, 'Photos/Items/xbox.png'),
(19, 'Photos/Items/motherboard.png'),
(20, 'Photos/Items/xbox.png'),
(21, 'Photos/Items/motherboard.png'),
(22, 'Photos/Items/electrician.png'),
(23, 'Photos/Items/FRNG.png'),
(24, 'Photos/Items/electrician.png'),
(25, 'Photos/Items/xbox.png'),
(26, 'Photos/Items/motherboard.png'),
(27, 'Photos/Items/motherboard.png'),
(28, 'Photos/Items/electrician.png'),
(29, 'Photos/Items/motherboard.png'),
(30, 'Photos/Items/xbox.png');

-- --------------------------------------------------------

--
-- Structure de la table `place`
--

DROP TABLE IF EXISTS `place`;
CREATE TABLE IF NOT EXISTS `place` (
  `bidId` int NOT NULL,
  `username` varchar(100) NOT NULL,
  PRIMARY KEY (`bidId`,`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `possess`
--

DROP TABLE IF EXISTS `possess`;
CREATE TABLE IF NOT EXISTS `possess` (
  `username` varchar(100) NOT NULL,
  `cartId` int NOT NULL,
  PRIMARY KEY (`username`,`cartId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `put`
--

DROP TABLE IF EXISTS `put`;
CREATE TABLE IF NOT EXISTS `put` (
  `username` varchar(100) NOT NULL,
  `idLink` int NOT NULL,
  PRIMARY KEY (`username`,`idLink`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sell`
--

DROP TABLE IF EXISTS `sell`;
CREATE TABLE IF NOT EXISTS `sell` (
  `username` varchar(100) NOT NULL,
  `idItem` int NOT NULL,
  PRIMARY KEY (`username`,`idItem`),
  KEY `fk_sell_item` (`idItem`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `sell`
--

INSERT INTO `sell` (`username`, `idItem`) VALUES
('j', 29),
('j', 30);

-- --------------------------------------------------------

--
-- Structure de la table `shoppingcart`
--

DROP TABLE IF EXISTS `shoppingcart`;
CREATE TABLE IF NOT EXISTS `shoppingcart` (
  `cartId` int NOT NULL AUTO_INCREMENT,
  `quantity` int NOT NULL,
  PRIMARY KEY (`cartId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`username`, `firstName`, `familyName`, `email`, `phone`, `passwd`, `roles`, `activated`) VALUES
('j', 'john', 'cena', 'jc@gmail.com', '0690', 'j', 1, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `fk_cartitems` FOREIGN KEY (`cartId`) REFERENCES `shoppingcart` (`cartId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itemsCart` FOREIGN KEY (`itemId`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `have`
--
ALTER TABLE `have`
  ADD CONSTRAINT `fk_idItemsPics` FOREIGN KEY (`idItem`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idLinkForItem` FOREIGN KEY (`idItem`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sell`
--
ALTER TABLE `sell`
  ADD CONSTRAINT `fk_sell_item` FOREIGN KEY (`idItem`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_username_seller` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
