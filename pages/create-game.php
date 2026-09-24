<?php
/* -------------------------------------------------------------------------- */
/*                  Initialisation du tableaux des cellules                  */
/* -------------------------------------------------------------------------- */

$game_id = $_SESSION['user']['id'];
// Pas de validation $_POST car tout est crée côté serveur
// Pas besoin de remplir l'id: il sera auto-généré en BDD
//game-xid sera récupérer avec le user id depuis la session
// isSunk et isHitten seront initialisés à ´´false´´
$CELLS = [];
$cell = [
  'id' => null,
  'game_xid' => $game_id,
  'coord' => '',
  'isHitten' => false,
  'isSunk' => false,
  'hasBoat' => false,
  'boatName' => '',
];


/* -------------------------------------------------------------------------- */
/*                     Remplissage du tableau des cellules                    */
/* -------------------------------------------------------------------------- */

/** Dans le futur, il faudra transformer ce script en class */


# Etape 1 : Créer les coordonnées
  $LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
  $i = 0;
  foreach($LETTERS as $letter){
    for($n = 0; $n < 10; $n++){
      $cell['coord'] = $letter.$n;
      $CELLS[$i] = $cell;
      $i++;
    }
  }

  # Etape 2 : Placer les bateaux
  $FLOT = [
    ["Carrier", 5],
    ["Battleship", 4],
    ["Destroyer", 3],
    ["Submarine", 3],
    ["Patrol Boat", 2],
  ];

  $validePos = false; // Vérification de la position (hors plateau ou sur un bateau)
  $orientation = '';  // Vertical ou horizontal

  if (random_int(1, 10) < 5) {
    $orientation = 'vertical';
  } else {
    $orientation = 'horizontal';
  }


  # Etape 2.1 : D'abord on va les placer aléatoirement
  for($x = 0; $x < count($FLOT); $x++){
    $o = random_int(1,100);
    $CELLS[$o]['hasBoat'] = true;
    $CELLS[$o]['boatName'] =  $FLOT[$x][0];
  }

/* -------------------------------------------------------------------------- */
/*                          Requête SQL d'insertion                           */
/* -------------------------------------------------------------------------- */
// ! - Attention, cell_id 
try{
  // On vérifie qu'il n'y pas d'autres cellules qui ont le game_xid
  // Si c'est le cas, on les supprime
  $verify = "
            DELETE FROM  `cell` 
            WHERE game_xid = ?;
            ";
  $clean = $pdo->prepare($verify);
  $clean->execute([$game_id]);

  // Puis on envoit la requête pour chaque cellule
  foreach($CELLS as $cell){
    // print_r($cell);
    $sql = "INSERT INTO cell 
                    (cell_id, game_xid, coord, isHitten, isSunk, hasBoat, boatName)
            VALUES (?,?,?,?,?,?,?)
              ";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        $cell['id'],
        $cell['game_xid'],
        strval($cell['coord']),
        $cell['isHitten'],
        $cell['isSunk'],
        $cell['hasBoat'],
        $cell['boatName'],
    ]);
  }

  header('Location: index.php?page=gaming');

  } catch (PDOException $e) {
        $errors["global"] = "Erreur lors de la création du plateau.";
  }
?>