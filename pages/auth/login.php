<?php

$errors = [];

$values = [ 'pseudo' => '' ];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // La connexion se fait via le pseudo
  $values['pseudo'] = trim($_POST['pseudo']) ?? '';
  $password = trim($_POST["password"]);

  // Validation
  if ($values['pseudo'] === '') {
    $errors['pseudo'] =  "Le pseudo est obligatoire.";
  }

  if ($password === '') {
    $errors['password'] = "Le mot de passe est obligatoire.";
  }

  // Vérifier si les identifiants sont corrects
  if (!$errors) {

    $sql = "SELECT 
            user_id AS id, 
            pseudo, 
            mot_de_passe, 
            role 
            FROM user 
            WHERE pseudo = ?
            ";

    $statement = $pdo->prepare($sql);
    $statement->execute([$values['pseudo']]);

    $user = $statement->fetch();

    if (!$user || !password_verify($password, $user['mot_de_passe'])) {
      $errors['global'] = "Le pseudo et/ou mot de passe incorrect.";
    }
    else {
      $_SESSION['user'] = [
        'id' => $user['id'],
        'pseudo' => $values['pseudo'],
        'role' => $user['role']
      ];

      header("Location: index.php?page=gaming");
    }

  }

}

?>

<!-- Template -->

<h1>Se connecter</h1>

<form method="post">

    <?php if(isset($errors['global'])) : ?>
      <span class="error"><?= $errors['global'] ?></span>
    <?php endif ?>

  <div>
    <label for="pseudo">Pseudo :</label>
    <input type="text" name="pseudo" minlength="5" maxlength="50" id="pseudo" value="<?= $values['pseudo'] ?>">
    <?php if(isset($errors['pseudo'])) : ?>
      <span class="error"><?= $errors['pseudo'] ?></span>
    <?php endif ?>
  </div>


  <div>
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" id="password">
    <?php if(isset($errors['password'])) : ?>
      <span class="error"><?= $errors['password'] ?></span>
    <?php endif ?>
  </div>

  <button>Se connecter</button>

</form>

<p>Pas encore inscrit ? <a href="index.php?page=register">Inscris-toi !</a></p>
