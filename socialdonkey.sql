-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 03 nov. 2024 à 21:20
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `socialdonkey`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int NOT NULL,
  `comment_contain` text NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `friendship`
--

DROP TABLE IF EXISTS `friendship`;
CREATE TABLE IF NOT EXISTS `friendship` (
  `friend_id` int NOT NULL,
  `friend_date` date NOT NULL,
  PRIMARY KEY (`friend_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `love`
--

DROP TABLE IF EXISTS `love`;
CREATE TABLE IF NOT EXISTS `love` (
  `love_id` int NOT NULL,
  `love_date` date NOT NULL,
  `post_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`love_id`),
  KEY `post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `post_contain` text NOT NULL,
  `post_date` date NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`post_id`, `post_contain`, `post_date`, `user_id`) VALUES
(41, 'testons cela', '2024-11-03', 1),
(42, 'amina', '2024-11-03', 24);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_mail` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_avatar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `user_date` date NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_mail` (`user_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id_user`, `user_name`, `user_firstname`, `user_mail`, `user_password`, `user_birthday`, `user_avatar`, `user_date`) VALUES
(1, 'akrouche', 'mohamed', 'elakrouche@gmail.com', 'blabla93', '2024-10-01', '', '2024-10-29'),
(2, 'omari', 'abdel', 'abdomari@gmail.com', 'abdo93', '2017-10-11', '', '2024-10-29'),
(5, 'donkeyTeam2', 'marc', 'emailtest@gmail.com', 'blabla', '2024-10-17', NULL, '0000-00-00'),
(7, 'franck', 'benoit', 'franck@gmail.com', 'balbla', '2024-10-03', NULL, '0000-00-00'),
(10, 'donkeyTeam1', 'Lucas', 'kdlsjgkf@gmail.com', 'df', '2024-10-01', NULL, '0000-00-00'),
(11, 'benoit', 'darian', 'benoit@gmail.com', 'dsf', '2024-10-01', NULL, '0000-00-00'),
(12, 'test secure', 'secure test', 'alo@gmail.com', '$2y$10$EOqLr538DQFCudltTU1Wxu7uueM584/UszUZggb5R4P.DX/vKrxT.', '2024-10-11', NULL, '0000-00-00'),
(13, 'eric', 'judor', 'eric@gmail.com', '$2y$10$TGcy4aHpEks/Ikg5gzoIcOeVF33nJR5VMA8gQUDToNF0KgKmqWizC', '2024-10-01', NULL, '0000-00-00'),
(16, 'emmanuel', 'emma', 'emmanuel@gmail.com', '$2y$10$284xTq5bDhKEOG5Y9dR5Le3IbUYLPdWAHvjs81J26IDrafYATnGem', '2024-10-01', NULL, '0000-00-00'),
(17, 'test', 'test', 'set@gmail.com', '$2y$10$LcYauDxiUCVWlgj.iijZseN.bU8pl8FXeKSc3Cqwa.RTSfoOlZ1Jy', '2024-10-02', NULL, '0000-00-00'),
(18, 'Microsoft', 'Windows', 'micro@gmail.com', '$2y$10$lUlg9Cpeuhq9ZlLOBKJrr.GelxrN7JZBwaPYmPt2RfSYMb//SLSL6', '2024-11-01', NULL, '0000-00-00'),
(19, 'inscriptionBDD', 'sdfsdf', 'sdff@gmail.com', '$2y$10$Ub8tlR1Vq9n/.3F06LuhvOgqPSlWSMRxpKeCay96jr.gEMt3/vsga', '2024-11-06', NULL, '0000-00-00'),
(20, 'inscriptionBDDa', 'sdfsdfa', 'sdfaf@gmail.com', '$2y$10$NRenk4Vm0gcf1DQ6hYr2s.d5jN4eVHyXzlPYebxi.X8RAULgEkBnC', '2024-11-06', NULL, '0000-00-00'),
(21, 'sdfsdf', 'sdfsdf', 'sdfsdf@gmail.com', '$2y$10$9V0rgCiEw4J6q8TS45SUyeq/jKY1RP6wzsiqBGSH6Z.Jk3lj3OU.i', '2024-10-30', NULL, '0000-00-00'),
(22, 'benoit', 'dfdf', 'dfdsfsdf@gmail.com', '$2y$10$TzfqEW8V8fQTdqaSmZlE9OzJhhHdMFMPr75XJOkBf7VnBiYfDwvgy', '2024-10-29', NULL, '0000-00-00'),
(23, 'bdfgdfg', 'dfdffdgg', 'dfdsfsfggdf@gmail.com', '$2y$10$vy3O565kJQtMC5wUC8h4ZuQbrCWvtcC6JD3dfnybZIePC7fISJgsm', '2024-10-29', NULL, '0000-00-00'),
(24, 'El akrouche', 'Amina', 'elakroucheamina@gmail.com', '$2y$10$zScqMCez.uhqNIHy2TC5VO9YX7SrmZPeyAJIoY3P8rpr46yRFxGQ6', '2024-11-11', NULL, '0000-00-00');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `user_post` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
