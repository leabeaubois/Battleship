<?php
/* -------------------------------------------------------------------------- */
/*                  Initialisation du tableaux des cellules                   */
/* -------------------------------------------------------------------------- */

$game_id = filter_var($_SESSION['user']['id'], FILTER_VALIDATE_INT);
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
  'boatLife' => 0,
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
      $CELLS[$letter.$n] = $cell;
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


    while (!$validePos) {
      $validePos = true;

      # 1 - Position verticale ou horizontale
      if (random_int(1, 10) < 5) {
        $orientation = 'vertical';
      } else {
        $orientation = 'horizontal';
      }


      # 2 - Choisir une cellule de départ
      $startPos = array_rand($CELLS, 1);

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
      # 5.1 - Vérifier que toutes les coordonnées existent sur le plateau
      foreach($coordinates as $coord){
        if(array_key_exists($coord, $CELLS)){
          #5 .2 - Vérifier qu'il n'y a pas déjà de bateau
          if(!$CELLS[$coord]['hasBoat']){
            $validePos = true;
          }
        }else{
          $validePos = false;
        }
      }
    }   /* end of while loop */
    if($validePos){
      #6 - Parcourir les coordonnées et placer le bateau
      for($u = 0; $u < count($coordinates); $u++){
        #. 6.1 - Appliquer ['hasBoat'] : true 
        $CELLS[$coordinates[$u]]['hasBoat'] = true;
        # 6.2 - Appliquer ['boatName'] : $boatName
        $CELLS[$coordinates[$u]]['boatName'] = $boatName;
        # 6.3 - Appliquer ['boatLife'] : $boatSize
        $CELLS[$coordinates[$u]]['boatLife'] = $boatSize;
      }
    }
  }     /* end of foreach $FLOT */

/* -------------------------------------------------------------------------- */
/*                          Requête SQL d'insertion                           */
/* -------------------------------------------------------------------------- */
// ! - Attention, cell_id va s'incrémenter à l'infini

// On vérifie qu'il n'y pas d'autres cellules qui ont le game_xid
// Si c'est le cas, on les supprime
$verify = "
          DELETE FROM  `cell` 
          WHERE game_xid = ?;
          ";
$clean = $pdo->prepare($verify);
$clean->execute([$game_id]);

/* -------------------------------------------------------------------------- */
/*                          Préparation de la requête                         */
/* -------------------------------------------------------------------------- */
$sql = "INSERT INTO cell 
                  (cell_id, 
                  game_xid, 
                  coord, 
                  isHitten, 
                  isSunk, 
                  hasBoat, 
                  boatName, 
                  boatLife)
          VALUES (?,?,?,?,?,?,?,?)
            ";
$statement = $pdo->prepare($sql);

/* -------------------------------------------------------------------------- */
/*                 Execution de la requête pour chaque cellule                */
/* -------------------------------------------------------------------------- */
$pdo->beginTransaction();
try{
  foreach($CELLS as $cell){
    $game_xid = intval($cell['game_xid']);
    $coord =    strval($cell['coord']);
    $isHitten = filter_var($cell['isHitten'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;  
    $isSunk   = filter_var($cell['isSunk'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
    $hasBoat  = filter_var($cell['hasBoat'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

    $statement->execute([
        $cell['id'],
        $game_xid,
        $coord,
        $isHitten,
        $isSunk,
        $hasBoat,
        $cell['boatName'] !== '' ? $cell['boatName'] :  null,
        $cell['boatLife'] !== '' ? $cell['boatLife'] :  0,
    ]);
  }
  
  $pdo->commit();
  header('Location: index.php?page=gaming');
  }catch (PDOException $e) {
    $pdo->rollBack();
    throw $e;
    $errors["global"] = "Erreur lors de la création du plateau.";
  }
?>