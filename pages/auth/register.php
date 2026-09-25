<?php
  /**
   * Initialise le tableau des messages d'erreurs
   */
  $errors = [];

  /**
   * Initialise les valeurs à insérer
   */
  $values = [ 
      'email' => '', 
      'pseudo' => '' 
  ];

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['pseudo'] = trim($_POST['pseudo']) ?? '';
    $values['email'] = trim($_POST['email']) ?? '';
    $password = trim($_POST["password"]);
    $confirmation = trim($_POST["confirmation"]);

    /* ------------------------------- Validation ------------------------------- */
    // Rajouter la valiation pour le pseudo (max 50 caractères, ne doit pas déjà exister, ne peut être vide)
    if ($values['pseudo'] === ''){
      $errors['pseudo'] =  "Le pseudo est obligatoire.";
    } else if (strlen($values['pseudo']) > 50) {
      $errors['pseudo'] = "Le pseudo ne peut pas excéder 50 caractères.";
    }

    if ($values['email'] === '') {
      $errors['email'] =  "L'email est obligatoire.";
    }
    else if (!filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Le format de l'email est incorrect.";
    }
    else if (strlen($values['email']) > 180) {
      $errors['email'] = "L'email ne peut pas excéder 180 caractères.";
    }

    if ($password === '') {
      $errors['password'] = "Le mot de passe est obligatoire.";
    }
    else if (strlen($password) < 8) {
      $errors['password'] = "Le mot de passe doit faire minimum 8 caractères.";
    }

    if ($password !== $confirmation) {
      $errors['confirmation'] = "Les deux mots de passe ne correspondent pas.";
    }


    /* -------------------- Enregistrement des données en DB -------------------- */
    if (!$errors) {

      try {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO 
                user (pseudo, email, mot_de_passe)
                VALUES (?, ?, ?)";

        $statement = $pdo->prepare($sql);
        $statement->execute([$values['pseudo'], $values['email'], $password_hash]);

        $_SESSION['user'] = [
          'id' => $pdo->lastInsertId(),
          'pseudo' => $values['pseudo'],
          'email' => $values['email'],
          'role' => 'user'
        ] ;     

        $lastCreatedId = $pdo->lastInsertId();

        $sql = "INSERT INTO
                game (game_id, user_xid)
                VALUES (?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$lastCreatedId, $lastCreatedId]);        

        header("Location: index.php?page=gaming");
        exit();

      } catch (PDOException $e) {
        $errors['email'] = "L'email est déjà pris.";
      }

    }

  }

?>

<!-- Template -->

<h1>S'inscrire</h1>

<form method="post">

  <div>
    <label for="pseudo">Pseudo : *</label>
    <input type="text" name="pseudo" id="pseudo" minlength="5" maxlength="50" value="<?= $values['pseudo'] ?>">
    <?php if(isset($errors['pseudo'])) : ?>
      <span class="error"><?= $errors['pseudo'] ?></span>
    <?php endif ?>
  </div>

  <div>
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?= $values['email'] ?>">
    <?php if(isset($errors['email'])) : ?>
      <span class="error"><?= $errors['email'] ?></span>
    <?php endif ?>
  </div>


  <div>
    <label for="password">Mot de passe: *</label>
    <input type="password" name="password" id="password">
    <?php if(isset($errors['password'])) : ?>
      <span class="error"><?= $errors['password'] ?></span>
    <?php endif ?>
  </div>


  <div>
    <label for="confirmation">Confirmation:</label>
    <input type="password" name="confirmation" id="confirmation">
    <?php if(isset($errors['confirmation'])) : ?>
      <span class="error"><?= $errors['confirmation'] ?></span>
    <?php endif ?>
  </div>

  <button>S'inscrire</button>

</form>

<p>Déjà inscrit ? <a href="index.php?page=login">Connecte toi !</a></p>
