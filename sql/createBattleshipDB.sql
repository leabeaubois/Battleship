-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 24 sep. 2026 à 14:37
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

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
-- Structure de la table `cell`
--

CREATE TABLE `cell` (
  `cell_id` int(6) NOT NULL,
  `game_xid` tinyint(6) NOT NULL,
  `coord` varchar(2) DEFAULT NULL,
  `isHitten` tinyint(1) DEFAULT 0,
  `isSunk` tinyint(1) DEFAULT 0,
  `hasBoat` tinyint(1) DEFAULT 0,
  `boatName` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cell`
--

INSERT INTO `cell` (`cell_id`, `game_xid`, `coord`, `isHitten`, `isSunk`, `hasBoat`, `boatName`) VALUES
(8028, 3, 'A0', 0, 0, 0, ''),
(8029, 3, 'A1', 0, 0, 0, ''),
(8030, 3, 'A2', 0, 0, 0, ''),
(8031, 3, 'A3', 0, 0, 0, ''),
(8032, 3, 'A4', 0, 0, 0, ''),
(8033, 3, 'A5', 0, 0, 0, ''),
(8034, 3, 'A6', 0, 0, 1, 'Destroyer'),
(8035, 3, 'A7', 0, 0, 0, ''),
(8036, 3, 'A8', 0, 0, 0, ''),
(8037, 3, 'A9', 0, 0, 0, ''),
(8038, 3, 'B0', 0, 0, 0, ''),
(8039, 3, 'B1', 0, 0, 0, ''),
(8040, 3, 'B2', 0, 0, 0, ''),
(8041, 3, 'B3', 0, 0, 0, ''),
(8042, 3, 'B4', 0, 0, 0, ''),
(8043, 3, 'B5', 0, 0, 0, ''),
(8044, 3, 'B6', 0, 0, 0, ''),
(8045, 3, 'B7', 0, 0, 0, ''),
(8046, 3, 'B8', 0, 0, 0, ''),
(8047, 3, 'B9', 0, 0, 0, ''),
(8048, 3, 'C0', 0, 0, 0, ''),
(8049, 3, 'C1', 0, 0, 0, ''),
(8050, 3, 'C2', 0, 0, 0, ''),
(8051, 3, 'C3', 0, 0, 0, ''),
(8052, 3, 'C4', 0, 0, 0, ''),
(8053, 3, 'C5', 0, 0, 0, ''),
(8054, 3, 'C6', 0, 0, 0, ''),
(8055, 3, 'C7', 0, 0, 0, ''),
(8056, 3, 'C8', 0, 0, 0, ''),
(8057, 3, 'C9', 0, 0, 0, ''),
(8058, 3, 'D0', 0, 0, 0, ''),
(8059, 3, 'D1', 0, 0, 0, ''),
(8060, 3, 'D2', 0, 0, 0, ''),
(8061, 3, 'D3', 0, 0, 0, ''),
(8062, 3, 'D4', 0, 0, 0, ''),
(8063, 3, 'D5', 0, 0, 0, ''),
(8064, 3, 'D6', 0, 0, 0, ''),
(8065, 3, 'D7', 0, 0, 0, ''),
(8066, 3, 'D8', 0, 0, 0, ''),
(8067, 3, 'D9', 0, 0, 0, ''),
(8068, 3, 'E0', 0, 0, 0, ''),
(8069, 3, 'E1', 0, 0, 0, ''),
(8070, 3, 'E2', 0, 0, 0, ''),
(8071, 3, 'E3', 0, 0, 0, ''),
(8072, 3, 'E4', 0, 0, 0, ''),
(8073, 3, 'E5', 0, 0, 0, ''),
(8074, 3, 'E6', 0, 0, 0, ''),
(8075, 3, 'E7', 0, 0, 0, ''),
(8076, 3, 'E8', 0, 0, 0, ''),
(8077, 3, 'E9', 0, 0, 0, ''),
(8078, 3, 'F0', 0, 0, 0, ''),
(8079, 3, 'F1', 0, 0, 0, ''),
(8080, 3, 'F2', 0, 0, 0, ''),
(8081, 3, 'F3', 0, 0, 0, ''),
(8082, 3, 'F4', 0, 0, 0, ''),
(8083, 3, 'F5', 0, 0, 0, ''),
(8084, 3, 'F6', 0, 0, 0, ''),
(8085, 3, 'F7', 0, 0, 0, ''),
(8086, 3, 'F8', 0, 0, 0, ''),
(8087, 3, 'F9', 0, 0, 0, ''),
(8088, 3, 'G0', 0, 0, 0, ''),
(8089, 3, 'G1', 0, 0, 0, ''),
(8090, 3, 'G2', 0, 0, 0, ''),
(8091, 3, 'G3', 0, 0, 0, ''),
(8092, 3, 'G4', 0, 0, 1, 'Patrol Boat'),
(8093, 3, 'G5', 0, 0, 0, ''),
(8094, 3, 'G6', 0, 0, 1, 'Carrier'),
(8095, 3, 'G7', 0, 0, 0, ''),
(8096, 3, 'G8', 0, 0, 0, ''),
(8097, 3, 'G9', 0, 0, 0, ''),
(8098, 3, 'H0', 0, 0, 0, ''),
(8099, 3, 'H1', 0, 0, 0, ''),
(8100, 3, 'H2', 0, 0, 0, ''),
(8101, 3, 'H3', 0, 0, 0, ''),
(8102, 3, 'H4', 0, 0, 0, ''),
(8103, 3, 'H5', 0, 0, 0, ''),
(8104, 3, 'H6', 0, 0, 0, ''),
(8105, 3, 'H7', 0, 0, 0, ''),
(8106, 3, 'H8', 0, 0, 0, ''),
(8107, 3, 'H9', 0, 0, 0, ''),
(8108, 3, 'I0', 0, 0, 0, ''),
(8109, 3, 'I1', 0, 0, 0, ''),
(8110, 3, 'I2', 0, 0, 0, ''),
(8111, 3, 'I3', 0, 0, 0, ''),
(8112, 3, 'I4', 0, 0, 0, ''),
(8113, 3, 'I5', 0, 0, 0, ''),
(8114, 3, 'I6', 0, 0, 0, ''),
(8115, 3, 'I7', 0, 0, 0, ''),
(8116, 3, 'I8', 0, 0, 0, ''),
(8117, 3, 'I9', 0, 0, 0, ''),
(8118, 3, 'J0', 0, 0, 1, 'Submarine'),
(8119, 3, 'J1', 0, 0, 0, ''),
(8120, 3, 'J2', 0, 0, 0, ''),
(8121, 3, 'J3', 0, 0, 0, ''),
(8122, 3, 'J4', 0, 0, 0, ''),
(8123, 3, 'J5', 0, 0, 0, ''),
(8124, 3, 'J6', 0, 0, 1, 'Battleship'),
(8125, 3, 'J7', 0, 0, 0, ''),
(8126, 3, 'J8', 0, 0, 0, ''),
(8127, 3, 'J9', 0, 0, 0, '');

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `game_id` tinyint(6) NOT NULL,
  `user_xid` tinyint(6) DEFAULT NULL,
  `score` smallint(6) DEFAULT 0,
  `ongoing` tinyint(1) DEFAULT NULL,
  `timing` smallint(10) DEFAULT 0,
  `strike_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`strike_history`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`game_id`, `user_xid`, `score`, `ongoing`, `timing`, `strike_history`) VALUES
(1, 1, 0, NULL, 0, '[]'),
(2, 2, 0, NULL, 0, '[]'),
(3, 3, 0, NULL, 0, '[]');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` tinyint(3) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `maxScore` smallint(6) DEFAULT 0,
  `registerDate` datetime DEFAULT current_timestamp(),
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `pseudo`, `email`, `mot_de_passe`, `maxScore`, `registerDate`, `role`) VALUES
(1, 'yakikou03', 'yaniskoulaouh@yahoo.com', '$2y$10$n80eF0E5oE2Zea2C51YaUu1efa7Tx9fP3ocb0kkZLjbng5BrAHzii', 0, '2026-09-24 09:33:29', 'user'),
(2, 'tambouille', 'tambouille@aol.com', '$2y$10$adF79RWqZzGMceXeqXhMkO7WfG0T/uo0BFYE4KhhHAGvhxaYla39e', 0, '2026-09-24 09:33:29', 'user'),
(3, 'bobby', 'bob@fromage.fr', '$2y$10$I/BWCpxkF5nO1cl.CfbngOBU2lrHzJInv5CKeQz7n1TF4PRj/io/u', 0, '2026-09-24 09:40:47', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cell`
--
ALTER TABLE `cell`
  ADD PRIMARY KEY (`cell_id`),
  ADD KEY `board_xid` (`game_xid`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`game_id`),
  ADD KEY `user_xid` (`user_xid`);

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
-- AUTO_INCREMENT pour la table `cell`
--
ALTER TABLE `cell`
  MODIFY `cell_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8428;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cell`
--
ALTER TABLE `cell`
  ADD CONSTRAINT `gameCell` FOREIGN KEY (`game_xid`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `userGame` FOREIGN KEY (`user_xid`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
