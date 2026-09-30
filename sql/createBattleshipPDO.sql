-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 30 sep. 2026 à 09:46
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
-- Structure de la table `boat`
--

CREATE TABLE `boat` (
  `boatName` varchar(50) DEFAULT NULL,
  `boatSize` tinyint(4) NOT NULL DEFAULT 0,
  `boatLife` tinyint(4) NOT NULL DEFAULT 0,
  `isSunk` tinyint(1) NOT NULL DEFAULT 0,
  `coord` varchar(255) DEFAULT NULL,
  `boat_id` smallint(6) NOT NULL,
  `game_xid` tinyint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `boat`
--

INSERT INTO `boat` (`boatName`, `boatSize`, `boatLife`, `isSunk`, `coord`, `boat_id`, `game_xid`) VALUES
('Carrier', 5, 2, 0, 'A3,B3,C3,D3,E3', 220, 3),
('Battleship', 4, 4, 0, 'A9,B9,C9,D9', 221, 3),
('Destroyer', 3, 3, 0, 'B2,B3,B4', 222, 3),
('Submarine', 3, 3, 0, 'E7,E8,E9', 223, 3),
('Patrol Boat', 2, 2, 0, 'D7,D8', 224, 3),
('Carrier', 5, 5, 0, 'H4,H5,H6,H7,H8', 225, 6),
('Battleship', 4, 4, 0, 'D4,D5,D6,D7', 226, 6),
('Destroyer', 3, 3, 0, 'G2,H2,I2', 227, 6),
('Submarine', 3, 3, 0, 'C9,D9,E9', 228, 6),
('Patrol Boat', 2, 2, 0, 'F8,G8', 229, 6);

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
  `boatName` varchar(50) DEFAULT NULL,
  `boatLife` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cell`
--

INSERT INTO `cell` (`cell_id`, `game_xid`, `coord`, `isHitten`, `isSunk`, `hasBoat`, `boatName`, `boatLife`) VALUES
(24742, 3, 'A0', 1, 0, 0, NULL, 0),
(24743, 3, 'A1', 0, 0, 0, NULL, 0),
(24744, 3, 'A2', 1, 0, 0, NULL, 0),
(24745, 3, 'A3', 0, 0, 1, 'Carrier', 5),
(24746, 3, 'A4', 0, 0, 0, NULL, 0),
(24747, 3, 'A5', 0, 0, 0, NULL, 0),
(24748, 3, 'A6', 0, 0, 0, NULL, 0),
(24749, 3, 'A7', 0, 0, 0, NULL, 0),
(24750, 3, 'A8', 0, 0, 0, NULL, 0),
(24751, 3, 'A9', 0, 0, 1, 'Battleship', 4),
(24752, 3, 'B0', 0, 0, 0, NULL, 0),
(24753, 3, 'B1', 0, 0, 0, NULL, 0),
(24754, 3, 'B2', 0, 0, 1, 'Destroyer', 3),
(24755, 3, 'B3', 1, 0, 1, 'Destroyer', 3),
(24756, 3, 'B4', 0, 0, 1, 'Destroyer', 3),
(24757, 3, 'B5', 0, 0, 0, NULL, 0),
(24758, 3, 'B6', 0, 0, 0, NULL, 0),
(24759, 3, 'B7', 0, 0, 0, NULL, 0),
(24760, 3, 'B8', 0, 0, 0, NULL, 0),
(24761, 3, 'B9', 0, 0, 1, 'Battleship', 4),
(24762, 3, 'C0', 0, 0, 0, NULL, 0),
(24763, 3, 'C1', 0, 0, 0, NULL, 0),
(24764, 3, 'C2', 0, 0, 0, NULL, 0),
(24765, 3, 'C3', 0, 0, 1, 'Carrier', 5),
(24766, 3, 'C4', 0, 0, 0, NULL, 0),
(24767, 3, 'C5', 0, 0, 0, NULL, 0),
(24768, 3, 'C6', 0, 0, 0, NULL, 0),
(24769, 3, 'C7', 0, 0, 0, NULL, 0),
(24770, 3, 'C8', 0, 0, 0, NULL, 0),
(24771, 3, 'C9', 0, 0, 1, 'Battleship', 4),
(24772, 3, 'D0', 0, 0, 0, NULL, 0),
(24773, 3, 'D1', 0, 0, 0, NULL, 0),
(24774, 3, 'D2', 0, 0, 0, NULL, 0),
(24775, 3, 'D3', 1, 0, 1, 'Carrier', 5),
(24776, 3, 'D4', 0, 0, 0, NULL, 0),
(24777, 3, 'D5', 0, 0, 0, NULL, 0),
(24778, 3, 'D6', 0, 0, 0, NULL, 0),
(24779, 3, 'D7', 0, 0, 1, 'Patrol Boat', 2),
(24780, 3, 'D8', 0, 0, 1, 'Patrol Boat', 2),
(24781, 3, 'D9', 0, 0, 1, 'Battleship', 4),
(24782, 3, 'E0', 0, 0, 0, NULL, 0),
(24783, 3, 'E1', 0, 0, 0, NULL, 0),
(24784, 3, 'E2', 0, 0, 0, NULL, 0),
(24785, 3, 'E3', 1, 0, 1, 'Carrier', 5),
(24786, 3, 'E4', 0, 0, 0, NULL, 0),
(24787, 3, 'E5', 0, 0, 0, NULL, 0),
(24788, 3, 'E6', 0, 0, 0, NULL, 0),
(24789, 3, 'E7', 0, 0, 1, 'Submarine', 3),
(24790, 3, 'E8', 0, 0, 1, 'Submarine', 3),
(24791, 3, 'E9', 0, 0, 1, 'Submarine', 3),
(24792, 3, 'F0', 0, 0, 0, NULL, 0),
(24793, 3, 'F1', 0, 0, 0, NULL, 0),
(24794, 3, 'F2', 0, 0, 0, NULL, 0),
(24795, 3, 'F3', 0, 0, 0, NULL, 0),
(24796, 3, 'F4', 0, 0, 0, NULL, 0),
(24797, 3, 'F5', 0, 0, 0, NULL, 0),
(24798, 3, 'F6', 0, 0, 0, NULL, 0),
(24799, 3, 'F7', 0, 0, 0, NULL, 0),
(24800, 3, 'F8', 0, 0, 0, NULL, 0),
(24801, 3, 'F9', 0, 0, 0, NULL, 0),
(24802, 3, 'G0', 0, 0, 0, NULL, 0),
(24803, 3, 'G1', 0, 0, 0, NULL, 0),
(24804, 3, 'G2', 0, 0, 0, NULL, 0),
(24805, 3, 'G3', 0, 0, 0, NULL, 0),
(24806, 3, 'G4', 0, 0, 0, NULL, 0),
(24807, 3, 'G5', 0, 0, 0, NULL, 0),
(24808, 3, 'G6', 0, 0, 0, NULL, 0),
(24809, 3, 'G7', 0, 0, 0, NULL, 0),
(24810, 3, 'G8', 0, 0, 0, NULL, 0),
(24811, 3, 'G9', 0, 0, 0, NULL, 0),
(24812, 3, 'H0', 0, 0, 0, NULL, 0),
(24813, 3, 'H1', 0, 0, 0, NULL, 0),
(24814, 3, 'H2', 0, 0, 0, NULL, 0),
(24815, 3, 'H3', 1, 0, 0, NULL, 0),
(24816, 3, 'H4', 0, 0, 0, NULL, 0),
(24817, 3, 'H5', 0, 0, 0, NULL, 0),
(24818, 3, 'H6', 0, 0, 0, NULL, 0),
(24819, 3, 'H7', 0, 0, 0, NULL, 0),
(24820, 3, 'H8', 0, 0, 0, NULL, 0),
(24821, 3, 'H9', 0, 0, 0, NULL, 0),
(24822, 3, 'I0', 0, 0, 0, NULL, 0),
(24823, 3, 'I1', 0, 0, 0, NULL, 0),
(24824, 3, 'I2', 0, 0, 0, NULL, 0),
(24825, 3, 'I3', 0, 0, 0, NULL, 0),
(24826, 3, 'I4', 0, 0, 0, NULL, 0),
(24827, 3, 'I5', 0, 0, 0, NULL, 0),
(24828, 3, 'I6', 0, 0, 0, NULL, 0),
(24829, 3, 'I7', 0, 0, 0, NULL, 0),
(24830, 3, 'I8', 0, 0, 0, NULL, 0),
(24831, 3, 'I9', 0, 0, 0, NULL, 0),
(24832, 3, 'J0', 1, 0, 0, NULL, 0),
(24833, 3, 'J1', 0, 0, 0, NULL, 0),
(24834, 3, 'J2', 0, 0, 0, NULL, 0),
(24835, 3, 'J3', 0, 0, 0, NULL, 0),
(24836, 3, 'J4', 0, 0, 0, NULL, 0),
(24837, 3, 'J5', 0, 0, 0, NULL, 0),
(24838, 3, 'J6', 0, 0, 0, NULL, 0),
(24839, 3, 'J7', 0, 0, 0, NULL, 0),
(24840, 3, 'J8', 0, 0, 0, NULL, 0),
(24841, 3, 'J9', 0, 0, 0, NULL, 0),
(24842, 6, 'A0', 0, 0, 0, NULL, 0),
(24843, 6, 'A1', 0, 0, 0, NULL, 0),
(24844, 6, 'A2', 0, 0, 0, NULL, 0),
(24845, 6, 'A3', 0, 0, 0, NULL, 0),
(24846, 6, 'A4', 0, 0, 0, NULL, 0),
(24847, 6, 'A5', 0, 0, 0, NULL, 0),
(24848, 6, 'A6', 0, 0, 0, NULL, 0),
(24849, 6, 'A7', 0, 0, 0, NULL, 0),
(24850, 6, 'A8', 0, 0, 0, NULL, 0),
(24851, 6, 'A9', 0, 0, 0, NULL, 0),
(24852, 6, 'B0', 0, 0, 0, NULL, 0),
(24853, 6, 'B1', 0, 0, 0, NULL, 0),
(24854, 6, 'B2', 0, 0, 0, NULL, 0),
(24855, 6, 'B3', 0, 0, 0, NULL, 0),
(24856, 6, 'B4', 0, 0, 0, NULL, 0),
(24857, 6, 'B5', 0, 0, 0, NULL, 0),
(24858, 6, 'B6', 0, 0, 0, NULL, 0),
(24859, 6, 'B7', 0, 0, 0, NULL, 0),
(24860, 6, 'B8', 0, 0, 0, NULL, 0),
(24861, 6, 'B9', 0, 0, 0, NULL, 0),
(24862, 6, 'C0', 0, 0, 0, NULL, 0),
(24863, 6, 'C1', 0, 0, 0, NULL, 0),
(24864, 6, 'C2', 0, 0, 0, NULL, 0),
(24865, 6, 'C3', 0, 0, 0, NULL, 0),
(24866, 6, 'C4', 0, 0, 0, NULL, 0),
(24867, 6, 'C5', 0, 0, 0, NULL, 0),
(24868, 6, 'C6', 0, 0, 0, NULL, 0),
(24869, 6, 'C7', 0, 0, 0, NULL, 0),
(24870, 6, 'C8', 0, 0, 0, NULL, 0),
(24871, 6, 'C9', 0, 0, 1, 'Submarine', 3),
(24872, 6, 'D0', 0, 0, 0, NULL, 0),
(24873, 6, 'D1', 0, 0, 0, NULL, 0),
(24874, 6, 'D2', 0, 0, 0, NULL, 0),
(24875, 6, 'D3', 0, 0, 0, NULL, 0),
(24876, 6, 'D4', 0, 0, 1, 'Battleship', 4),
(24877, 6, 'D5', 0, 0, 1, 'Battleship', 4),
(24878, 6, 'D6', 0, 0, 1, 'Battleship', 4),
(24879, 6, 'D7', 0, 0, 1, 'Battleship', 4),
(24880, 6, 'D8', 0, 0, 0, NULL, 0),
(24881, 6, 'D9', 0, 0, 1, 'Submarine', 3),
(24882, 6, 'E0', 0, 0, 0, NULL, 0),
(24883, 6, 'E1', 0, 0, 0, NULL, 0),
(24884, 6, 'E2', 0, 0, 0, NULL, 0),
(24885, 6, 'E3', 0, 0, 0, NULL, 0),
(24886, 6, 'E4', 0, 0, 0, NULL, 0),
(24887, 6, 'E5', 0, 0, 0, NULL, 0),
(24888, 6, 'E6', 0, 0, 0, NULL, 0),
(24889, 6, 'E7', 0, 0, 0, NULL, 0),
(24890, 6, 'E8', 0, 0, 0, NULL, 0),
(24891, 6, 'E9', 0, 0, 1, 'Submarine', 3),
(24892, 6, 'F0', 0, 0, 0, NULL, 0),
(24893, 6, 'F1', 0, 0, 0, NULL, 0),
(24894, 6, 'F2', 0, 0, 0, NULL, 0),
(24895, 6, 'F3', 0, 0, 0, NULL, 0),
(24896, 6, 'F4', 0, 0, 0, NULL, 0),
(24897, 6, 'F5', 0, 0, 0, NULL, 0),
(24898, 6, 'F6', 0, 0, 0, NULL, 0),
(24899, 6, 'F7', 0, 0, 0, NULL, 0),
(24900, 6, 'F8', 0, 0, 1, 'Patrol Boat', 2),
(24901, 6, 'F9', 0, 0, 0, NULL, 0),
(24902, 6, 'G0', 0, 0, 0, NULL, 0),
(24903, 6, 'G1', 0, 0, 0, NULL, 0),
(24904, 6, 'G2', 0, 0, 1, 'Destroyer', 3),
(24905, 6, 'G3', 0, 0, 0, NULL, 0),
(24906, 6, 'G4', 0, 0, 0, NULL, 0),
(24907, 6, 'G5', 0, 0, 0, NULL, 0),
(24908, 6, 'G6', 0, 0, 0, NULL, 0),
(24909, 6, 'G7', 0, 0, 0, NULL, 0),
(24910, 6, 'G8', 0, 0, 1, 'Patrol Boat', 2),
(24911, 6, 'G9', 0, 0, 0, NULL, 0),
(24912, 6, 'H0', 0, 0, 0, NULL, 0),
(24913, 6, 'H1', 0, 0, 0, NULL, 0),
(24914, 6, 'H2', 0, 0, 1, 'Destroyer', 3),
(24915, 6, 'H3', 0, 0, 0, NULL, 0),
(24916, 6, 'H4', 0, 0, 1, 'Carrier', 5),
(24917, 6, 'H5', 0, 0, 1, 'Carrier', 5),
(24918, 6, 'H6', 0, 0, 1, 'Carrier', 5),
(24919, 6, 'H7', 0, 0, 1, 'Carrier', 5),
(24920, 6, 'H8', 0, 0, 1, 'Carrier', 5),
(24921, 6, 'H9', 0, 0, 0, NULL, 0),
(24922, 6, 'I0', 0, 0, 0, NULL, 0),
(24923, 6, 'I1', 0, 0, 0, NULL, 0),
(24924, 6, 'I2', 0, 0, 1, 'Destroyer', 3),
(24925, 6, 'I3', 0, 0, 0, NULL, 0),
(24926, 6, 'I4', 0, 0, 0, NULL, 0),
(24927, 6, 'I5', 0, 0, 0, NULL, 0),
(24928, 6, 'I6', 0, 0, 0, NULL, 0),
(24929, 6, 'I7', 0, 0, 0, NULL, 0),
(24930, 6, 'I8', 0, 0, 0, NULL, 0),
(24931, 6, 'I9', 0, 0, 0, NULL, 0),
(24932, 6, 'J0', 0, 0, 0, NULL, 0),
(24933, 6, 'J1', 0, 0, 0, NULL, 0),
(24934, 6, 'J2', 0, 0, 0, NULL, 0),
(24935, 6, 'J3', 0, 0, 0, NULL, 0),
(24936, 6, 'J4', 0, 0, 0, NULL, 0),
(24937, 6, 'J5', 0, 0, 0, NULL, 0),
(24938, 6, 'J6', 0, 0, 0, NULL, 0),
(24939, 6, 'J7', 0, 0, 0, NULL, 0),
(24940, 6, 'J8', 0, 0, 0, NULL, 0),
(24941, 6, 'J9', 0, 0, 0, NULL, 0);

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
(3, 3, 0, NULL, 0, '[\"E3 : Cible touché5\", \"D3 : Cible touché5\", \"B3 : Cible touché\", \"H3 : Raté\", \"J0 : Raté\", \"A2 : Raté\", \"J0 : Raté\", \"A0 : Raté\"]'),
(6, 6, 0, NULL, 0, '[]');

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
(3, 'bobby', 'bob@fromage.fr', '$2y$10$I/BWCpxkF5nO1cl.CfbngOBU2lrHzJInv5CKeQz7n1TF4PRj/io/u', 0, '2026-09-24 09:40:47', 'user'),
(6, 'Tulipe', 'tule@toit.com', '$2y$10$KQd1QNLo0yUgFV4wOEkkquqvqrVzZxLT590C2H5IOZdWX0aMYOJN6', 0, '2026-09-30 09:45:36', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `boat`
--
ALTER TABLE `boat`
  ADD PRIMARY KEY (`boat_id`),
  ADD KEY `gameBoat` (`game_xid`);

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
-- AUTO_INCREMENT pour la table `boat`
--
ALTER TABLE `boat`
  MODIFY `boat_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT pour la table `cell`
--
ALTER TABLE `cell`
  MODIFY `cell_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24942;

--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `game_id` tinyint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `boat`
--
ALTER TABLE `boat`
  ADD CONSTRAINT `gameBoat` FOREIGN KEY (`game_xid`) REFERENCES `game` (`game_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
