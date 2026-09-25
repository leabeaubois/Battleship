<?php
 /* -------------------------------------------------------------------------- */
 /*                       Delete and build new game board                      */
 /* -------------------------------------------------------------------------- */
// -> delete / drop cells filtrer avec l'id du board
// -> delete /drop strikeHistory

// -> relancer un plateau 
// -> disposition aléatoire des bateaux
// -> create the cells 


if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  http_response_code(405);
  echo "<h1>Action non autorisée.</h1>";
}

// ! à modifier
// Vérifier l'id_user par la session
$user = $_SESSION['user']['id'];

if ($user) {
  # Supprime toutes les cellules (la table entière à l'id correspondant au user)
  $sql = "DELETE FROM cell WHERE board_xid = ?";
  $restart = $pdo->prepare($sql);
  $restart->execute([$user]);

  # Supprime seulement la colonne de l'historique (à l'id correspondant au user)
  $sql = "UPDATE
                board  
          SET   strike_history = '[]'
          WHERE board_id = ?
          ";
  $restart = $pdo->prepare($sql);
  $restart->execute([$user]);
}




# Re-remplir les cellules
$errors = [];
  if (!$errors) {

    try {
      $sql = "
      INSERT INTO livre (titre, annee, prix, isbn, auteur_id)
      VALUES (?, ?, ?, ?, ?)
      ";
    }catch (PDOException $e) {
      $errors["global"] = "Une erreur est survenue.";
    }
  }


# Relancer la construction d'un board
header("Location: index.php?page=gaming");
