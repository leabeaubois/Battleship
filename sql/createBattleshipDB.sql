-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 16 sep. 2026 à 15:00
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `battleship`
--

-- --------------------------------------------------------

--
-- Structure de la table `board`
--

CREATE TABLE `board` (
  `board_id` tinyint(6) NOT NULL,
  `game_xid` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cell`
--

CREATE TABLE `cell` (
  `cell_id` tinyint(6) NOT NULL,
  `board_xid` tinyint(6) NOT NULL,
  `coord` varchar(2) DEFAULT NULL,
  `isHitten` tinyint(1) DEFAULT 0,
  `isSunk` tinyint(1) DEFAULT 0,
  `hasBoat` tinyint(1) DEFAULT 0,
  `boatName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `game_id` tinyint(6) NOT NULL,
  `user_xid` tinyint(6) DEFAULT NULL,
  `board_xid` tinyint(6) DEFAULT NULL,
  `score` smallint(6) DEFAULT 0,
  `ongoing` tinyint(1) DEFAULT NULL,
  `timing` smallint(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `strike`
--

CREATE TABLE `strike` (
  `strike_id` tinyint(6) NOT NULL,
  `board_xid` tinyint(6) DEFAULT NULL,
  `coord` varchar(2) DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` tinyint(3) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `maxScore` smallint(6) DEFAULT 0,
  `registerDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`board_id`),
  ADD KEY `game_xid` (`game_xid`);

--
-- Index pour la table `cell`
--
ALTER TABLE `cell`
  ADD PRIMARY KEY (`cell_id`),
  ADD KEY `board_xid` (`board_xid`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `user_xid` (`user_xid`);

--
-- Index pour la table `strike`
--
ALTER TABLE `strike`
  ADD PRIMARY KEY (`strike_id`),
  ADD KEY `game_xid` (`board_xid`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `PSEUDO` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `board`
--
ALTER TABLE `board`
  MODIFY `board_id` tinyint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cell`
--
ALTER TABLE `cell`
  MODIFY `cell_id` tinyint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` tinyint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `strike`
--
ALTER TABLE `strike`
  MODIFY `strike_id` tinyint(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` tinyint(3) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `board`
--
ALTER TABLE `board`
  ADD CONSTRAINT `boardGame` FOREIGN KEY (`game_xid`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `cell`
--
ALTER TABLE `cell`
  ADD CONSTRAINT `boardCell` FOREIGN KEY (`board_xid`) REFERENCES `board` (`board_id`);

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `userGame` FOREIGN KEY (`user_xid`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `strike`
--
ALTER TABLE `strike`
  ADD CONSTRAINT `strike_ibfk_1` FOREIGN KEY (`board_xid`) REFERENCES `board` (`board_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Insertion de données de test
--

-- Insertion de deux utilisateurs
INSERT INTO `user` (`user_id`, `pseudo`, `email`, `password`, `maxScore`, `registerDate`) 
VALUES (
    NULL, 
    'yakikou03', 
    'yaniskoulaouh@yahoo.com', 
    '$2y$10$n80eF0E5oE2Zea2C51YaUu1efa7Tx9fP3ocb0kkZLjbng5BrAHzii', 
    '0', 
    current_timestamp()
  ),    
  (
    NULL, 
    'tambouille', 
    'tambouille@aol.com', 
    '$2y$10$adF79RWqZzGMceXeqXhMkO7WfG0T/uo0BFYE4KhhHAGvhxaYla39e', 
    '0', 
    current_timestamp()
  ) 

-- Insertion d'une partie pour chacun d'eux
INSERT INTO `game` (`game_id`, `user_xid`, `board_xid`, `score`, `ongoing`, `timing`) 
VALUES 
  (NULL, '1', NULL, '0', NULL, '0'), 
  (NULL, '2', NULL, '0', NULL, '0');

-- Insertion de plateau pour les deux parties

INSERT INTO `board` (`board_id`, `game_xid`) 
VALUES 
  (NULL, '1'), 
  (NULL, '2');


-- Insertion de cellules sur le plateau 1 qui lié à l'utilisateur 1 (yakikou03)
-- Ici il serait intéressant de faire une boucle pour parcourir les lettres A,B,C,D,E,F,G,H,I,J 

INSERT INTO `cell` (`cell_id`, `board_xid`, `coord`, `isHitten`, `isSunk`, `hasBoat`, `boatName`) 
VALUES 
  (NULL, '1', 'A0', '0', '0', '0', NULL), 
  (NULL, '1', 'A1', '0', '0', '0', NULL), 
  (NULL, '1', 'A2', '0', '0', '0', NULL), 
  (NULL, '1', 'A3', '0', '0', '0', NULL), 
  (NULL, '1', 'A4', '0', '0', '0', NULL), 
  (NULL, '1', 'A5', '0', '0', '0', NULL);