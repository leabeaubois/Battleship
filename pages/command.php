<?php 

  // ** Est-ce qu'on a besoin de refaire la requête ? 
  /** Initialisation du tableaux de valuers qu'on va remplir via le POST */
  // 1 - Attention à la validation des coordonnées côté serveur
  // 2 - Ensuite on va cherche dans le colonne coord celle qui correspond à la valeur posté
  // 3 - Logique :
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
  ];

  /** 
   * Initialisation du tableaux des erreurs
   */

  // Commande est vide
  // commande trop longue
  // commande ne correspond pas au schéma (lettre entre A et J + chiffre entre 0 et 9)
  $errors = [];


  /** 
   * Initialisation du tableaux des messages
   * -> Résultat du tir
   */

  // Déjà visé / Touché / Vide / Coulé 
  $messages = [
    'alreadyHitten' => '',
    'isHitten' => '',
    'hasBoat' => '',
    'isSunk' => '',
  ];

  /**
   *  Gestion du formulaire
   */
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
  
  
    /**
     * Requête de la cellule ciblée
     * 
     * 
    */
    if (!$errors) {
      echo "Zone localisée, lancement en : ";
      echo $values['coord-command'];
      try {
        /** Va chercher la cellule et compare */
        $coord = $values['coord-command'];
        $sql = "SELECT
                board_xid,
                coord, isHitten, isSunk, hasBoat
                FROM cell
                WHERE board_xid = ? AND coord = ?
                ";
        $request = $pdo->prepare($sql);
        $request->execute([$user_id, $coord]);
        $targetedCell = $request->fetch();
  
        echo "</br>…Etat de la cellule visée : ";
        print_r($targetedCell);
        $result = "";
  
      
        if($targetedCell['hasBoat'] && $targetedCell['isHitten']){
          $values['isHitten'] = true; // reste true ou juste ne pas modifier ?
          $message['alreadyHitten'] = 'Bateau déjà touché';
          $result = "déjà touché";
          echo $message['alreadyHitten'];
        }
        else if($targetedCell['hasBoat']){
          $values['isHitten'] = true;
          $message['alreadyHitten'] = 'Touché !';
          echo $message['alreadyHitten'];
          echo $values['isHitten'];
          $result = "touché";
        }else{
          $values['hasBoat'] = false;
          $values['isHitten'] = true;
          $message['hasBoat'] = 'Il n\'y a rien ici.';
          echo $message['hasBoat'];
          $result = "dans l'eau";
        }

        /** Convertir en boolen */
        $isHitten = filter_var($values['isHitten'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        $isSunk   = filter_var($values['isSunk'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
  
        /**
         * Requête de modification de la cellule visée
         */
        $sql = "
        UPDATE cell
        SET
            isHitten = ?, 
            isSunk = ?
        WHERE board_xid = ? AND coord = ?
        ";
  
        $missile = $pdo->prepare($sql);
        $missile->execute([
          $isHitten,
          $isSunk,
            $user_id,
            $coord
        ]);


        // ** Rajouter les actions dans l'historique
        $strikeShot = '[' . $coord . ',' . $result . ']';

        /**
         * Requête d'adaptation de l'historique
         * Documentation json_array_append
         * https://mariadb.com/docs/server/reference/sql-functions/special-functions/json-functions/json_array_append
         * La table strike est inutile -> à supprimer.
         */
        $sql = "
        UPDATE board
        SET 
            strike_history = JSON_ARRAY_APPEND
                          (strike_history,
                          '$',
                          ? )
        WHERE board_id = ?
        ";

        $missile = $pdo->prepare($sql);
        $missile->execute([
          $strikeShot,
          $user_id,
        ]);
  
        // ne pas changer de page ?
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
  </form>
  <div id="logs">
    <?php if (isset($messages)) : ?>
      <?php foreach($messages as $message):?>
        <span><?=$message?></span>
      <?php endforeach ?>
    <?php endif ?>
  </div>
</div>