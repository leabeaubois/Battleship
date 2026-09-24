
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