-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 13 nov. 2020 à 15:25
-- Version du serveur :  8.0.21
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `web`
--

-- --------------------------------------------------------

--
-- Structure de la table `w_annonces`
--

DROP TABLE IF EXISTS `w_annonces`;
CREATE TABLE IF NOT EXISTS `w_annonces` (
  `id` smallint NOT NULL AUTO_INCREMENT,
  `marque` varchar(25) NOT NULL,
  `modele` varchar(25) NOT NULL,
  `couleur` varchar(25) NOT NULL,
  `annee_mec` smallint NOT NULL,
  `kilometrage` varchar(25) NOT NULL,
  `prix` varchar(25) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `date_creation` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `w_annonces`
--

INSERT INTO `w_annonces` (`id`, `marque`, `modele`, `couleur`, `annee_mec`, `kilometrage`, `prix`, `auteur`, `date_creation`) VALUES
(1, 'Honda', 'Civic', 'Bleue', 2005, '108 000km', '2500$', '', '2020-11-11');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
