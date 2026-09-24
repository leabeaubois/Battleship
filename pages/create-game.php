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

  foreach($FLOT as $boat){
    $boatName = $boat[0];
    $boatSize = $boat[1];
    $validePos = false; // Vérification de la position (hors plateau ou sur un bateau)
    $orientation = '';  // Vertical ou horizontal
    $coordinates = [];

    // while (!$validePos) {
      $validePos = true;

      # 1 - Position verticale ou horizontale
      if (random_int(1, 10) < 5) {
        $orientation = 'vertical';
      } else {
        $orientation = 'horizontal';
      }


      # 2 - Choisir une cellule de départ
      $o = random_int(0,99);
      $startPos = $CELLS[$o]['coord'];

      # 3 - Décomposer la lettre et le chiffre
      $startLetter = substr($startPos, 0, 1);
      $startNum = intval(substr($startPos, -1, 1));

      # 4 - Ecrire la liste des coordonnées du bateau
      # 4.1 - En position horizontale
      if ($orientation == 'horizontal') {
        for($s = 0; $s < $boatSize; $s++){
          $coordinates[$s] = $startLetter . $startNum;
          $startNum++;
        }
      }
      # 4.2 - En position verticale
      else{
        $startLetterKey = array_search($startLetter, $LETTERS);
        for($s = 0; $s < $boatSize; $s++){
          // Faire évoluer $startLetter en parcourant le tableau $LETTERS
          if(array_key_exists($startLetterKey, $LETTERS)){
            $coordinates[$s] = $LETTERS[$startLetterKey] . $startNum;
            $startLetterKey++;
          }else {
            break 2;
          }
        }
      }

      # 5 - Vérifier que toutes les coordonnées existent sur le plateau et qu'il n'y a pas déjà de bateau
      foreach($coordinates as $coord){
        echo $coord;
        if(array_key_exists($coord, $CELLS)){
          $validePos = true;
          echo $validePos;
        }else{$validePos = false; echo $validePos;}
      }
    
      
    // }   /* end of while loop */
  }     /* end of foreach $FLOT */

  // print_r($CELLS);
  // print_r($CELLS['coord']);


  # Etape 2.1 : D'abord on va les placer aléatoirement
  for($x = 0; $x < count($FLOT); $x++){
    $o = random_int(1,100);
    $CELLS[$o]['hasBoat'] = true;
    $CELLS[$o]['boatName'] =  $FLOT[$x][0];
  }










/* -------------------------------------------------------------------------- */
/*                          Requête SQL d'insertion                           */
/* -------------------------------------------------------------------------- */
// // ! - Attention, cell_id 
// try{
//   // On vérifie qu'il n'y pas d'autres cellules qui ont le game_xid
//   // Si c'est le cas, on les supprime
//   $verify = "
//             DELETE FROM  `cell` 
//             WHERE game_xid = ?;
//             ";
//   $clean = $pdo->prepare($verify);
//   $clean->execute([$game_id]);

//   // Puis on envoit la requête pour chaque cellule
//   foreach($CELLS as $cell){
//     // print_r($cell);
//     $sql = "INSERT INTO cell 
//                     (cell_id, game_xid, coord, isHitten, isSunk, hasBoat, boatName)
//             VALUES (?,?,?,?,?,?,?)
//               ";
//     $statement = $pdo->prepare($sql);
//     $statement->execute([
//         $cell['id'],
//         $cell['game_xid'],
//         strval($cell['coord']),
//         $cell['isHitten'],
//         $cell['isSunk'],
//         $cell['hasBoat'],
//         $cell['boatName'],
//     ]);
//   }

//   header('Location: index.php?page=gaming');

//   }catch (PDOException $e) {
//         $errors["global"] = "Erreur lors de la création du plateau.";
//   }
?>