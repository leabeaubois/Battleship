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
    'coord' => '',
    'isHitten' => '',
    'hasBoat' => '',
    'isSunk' => '',
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
    'isEmpty' => '',
    'isSunk' => '',
  ];

  /**
   *  Gestion du formulaire
   */
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mapping de données : pas besoin car une seule donnée à récupérer via le POST
    $values['coord-command'] = trim($_POST['coord-command']) ?? '';
  }

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
  <div id="logs"></div>
</div>