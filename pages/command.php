<?php 

 /* -------------------------------------------------------------------------- */
 /*     Initialisation du tableaux de valeers qu'on va remplir via le POST     */
 /* -------------------------------------------------------------------------- */
  # 1 - Attention à la validation des coordonnées côté serveur
  # 2 - Ensuite on va cherche dans le colonne coord celle qui correspond à la valeur posté
  # 3 - Logique :
    //      - vérifier que la coordonnées existe sinon erreur
    //      - si la case est isHitten = ``true`` -> déjà touché -> isHitten reste ``true``
    //.     - si la case isBoat true : et isHitten = ``false`` -> touché ->  isHitten devient ``true`` + boatLife perd 1.
    //          et si bateau life = 0 -> coulé -> isSunk devient ``true``
    //      - sinon la case est vide -> coup dans l'eau -> isHitten devient ``true``

$values = [
  'command-coord' => '',
  'isHitten' => false,
  'hasBoat' => false,
  'isSunk' => false,
  'boatName' => '',
  'boatLife' => 0,
  'boatCoordinates' => '',
];

/** 
 * Initialisation du tableaux des erreurs
 */

// Commande est vide
// commande trop longue
// commande ne correspond pas au schéma (lettre entre A et J + chiffre entre 0 et 9)
$errors = [];


/** 
 * Initialisation des messages à afficher
 */
$result = '';


/* -------------------------------------------------------------------------- */
/*                            Gestion du formulaire                           */
/* -------------------------------------------------------------------------- */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Mapping de données : pas besoin car une seule donnée à récupérer via le POST
  $values['coord-command'] = trim($_POST['coord-command']) ?? '';

  /**
   * Validation des coordonnées envoyées
   */
  $pattern = "/[A-J]+[0-9]+/i";
  if ($values['coord-command'] === '') {
    $errors["coord-command"] = "Coordonnées vides…";
  } else if (strlen($values['coord-command']) > 2 || strlen($values['coord-command']) < 2) {
    $errors["coord-command"] = "Format type 'A0' est attendu…";
  } elseif (!preg_match($pattern, $values['coord-command'])){
    $errors["coord-command"] = "Les coordonnées sont au format : 'J9' (une lettre entre A et J + un chiffre entre 0 et 9.)";
  }

  

/* -------------------------------------------------------------------------- */
/*                        Requête de la cellule ciblée                        */
/* -------------------------------------------------------------------------- */
  
    if (!$errors) {
      $pdo->beginTransaction();
      try {
        /** Va chercher la cellule et compare */
        $coord = $values['coord-command'];
        $sql = "SELECT
                game_xid,
                coord, isHitten, isSunk, hasBoat
                FROM cell
                WHERE game_xid = ? AND coord = ?
                ";
        $request = $pdo->prepare($sql);
        // $user_id est définit dans gaming.php
        $request->execute([$user_id, $coord]);
        $targetedCell = $request->fetch();



        /* -------------------------------------------------------------------------- */
        /*                               Logique du jeu                               */
        /* -------------------------------------------------------------------------- */
        # 1 - Récupère la commande envoyée
        $coord = $values['coord-command'];

        # 2 - Calcul le nombre de vies restantes étant le nombre de bateaux non coulés
        $gameLife = count($boats);
        for($u=0; $u < count($boats); $u++){
          if($boats[$u]['isSunk']){
            $gameLife--;
          }
        }

        # 3-  On parcourt les bateaux récupérés depuis la requête de la table ``boat´´ dans gaming.php
        foreach($boats as $boat){
          # 4 - Si il y a un bateau 
          if(str_contains($boat['coord'], $coord) ){
            

            # 5.1 - La cellule visée a déjà été touchée
            if($targetedCell['isHitten']){
              $result = "Cible déjà touché.";
            }
            # 5.2 - La cellule visée est touchée pour la première fois
            else{
              # 6.1 - On récupère le nom du bateau
              $values['boatName'] = $boat['boatName'];

              # 6.2 - On enlève un PV
              $life = $boat['boatLife'];
              $life--;

              # 6.3 - On change le statut
              $values['isHitten'] = true;

              # 7 - On vérifie si le bateau est coulé
              if($life == 0){
                # 8.1 - S'il est coulé on abaisse la vie du bateau à 0
                $values['boatLife'] = 0;
                # 8.2 - On change la valeur isSunk (pour cell et boat)
                $values['isSunk'] = true;
                # 8.3 - On récupère toutes les autres coordonnées du bateau pour changer la valeur isSunk
                $values['boatCoordinates'] = $boat['coord'];

                $result = "Cible coulé !";
                
                # 9 - Dernière étape, vérifier si tous les bateaux sont coulés :
                if($gameLife == 1){
                  $result = "Gagné !!!";
                }

              # Si le bateau n'est pas coulé, il est touché, et on break la boucle 
              }else{
                $values['boatLife'] = $life;
                $result = "Cible touché.";
              }
            }
            break;
          }
        # 10 - Aucun bateau n'a été trouvé   
        $values['isHitten'] = true;
        $result = "Raté.";
        }
        

        

        /* -------------------------------------------------------------------------- */
        /*                         Stockage du résultat en BDD                        */
        /* -------------------------------------------------------------------------- */

        /** Convertir et purifier les valeurs */
        $isHitten = filter_var($values['isHitten'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $isSunk   = filter_var($values['isSunk'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $life     = intval($values['boatLife']);
        $boatName = strval($values['boatName']);

        /**
         * Requête de modification de la cellule visée
         */
        $sqlC = "
          UPDATE cell
          SET
              isHitten = ?, 
              isSunk = ?
          WHERE game_xid = ? AND coord = ?
          ";
      
        if($values['isSunk']){
          # 1 - Coulé - exécuté sur toutes les cellules du bateau
          // Mettre à jour toutes les cellules du bateau

          # 1.1 - Convertir la string en array
          $boatCoordinates = explode(",", $values['boatCoordinates']);

          foreach($boatCoordinates as $coordi){
            # 1.2 - Reconvertir $coordi en string
            $coord = strval($coordi);

            # 1.3 - Exécution
            $missileCell = $pdo->prepare($sqlC);
            $missileCell->execute([
              $isHitten,
              $isSunk,
                $user_id,
                $coord
            ]);
          }
        }
        else{
          # 2- Pas coulé - exécuté une seule fois
          $missileCell = $pdo->prepare($sqlC);
          $missileCell->execute([
            $isHitten,
            $isSunk,
              $user_id,
              $coord
          ]);
        }

      

        /**
         * Requête de modification des bateaux
         */

        $sqlB = "
                UPDATE boat
                SET 
                  boatLife = ?,
                  isSunk = ?
                WHERE game_xid = ? AND boatName = ?
                ";
        $missileB = $pdo->prepare($sqlB);
        $missileB->execute([
          $life,
          $isSunk,
          $user_id,
          $boatName,
        ]);



        /* ----------------- Rajouter les actions dans l'historique ----------------- */
        $strikeShot =  $coord . ' : ' . $result ;

        /**
         * Requête d'adaptation de l'historique
         * 
         * Documentation json_array_append
         * https://mariadb.com/docs/server/reference/sql-functions/special-functions/json-functions/json_array_append
         */
        $sqlS = "
        UPDATE game
        SET 
            strike_history = JSON_ARRAY_APPEND
                          (strike_history, '$',
                          ? )
        WHERE game_id = ?
        ";

        $missileS = $pdo->prepare($sqlS);
        $missileS->execute([
          $strikeShot,
          $user_id,
        ]);
      
        $pdo->commit();
        header('Location: index.php?page=gaming');
      } catch (PDOException $e) {
        $errors["global"] = "Erreur au lancement du missile.";
      }
    }
  }
?>

<div id="command-pannel">
  <!-- Formulaire de lancement des missiles -->
  <form action="" method="POST">
    <label for=""></label>
    <p>Verrouillage du missile, coordonnées : 
      <label for="coord-command"></label>
      <input type="text" 
              pattern="[A-J]+[0-9]+" 
              minlength="2" maxlength="2" 
              id="coord-command" 
              name="coord-command" 
              value="" 
              placeholder="A0">
    </p>
    <input type="submit" name="submit" value="Submit">
    <?php if (isset($errors['coord-command'])) : ?>
      <span class="error"><?= $errors['coord-command'] ?></span>
    <?php endif ?>
    <?php if (isset($errors['global'])) : ?>
      <span class="error"><?= $errors['global'] ?></span>
    <?php endif ?>
  </form>
</div>