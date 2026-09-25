<nav>
  <ul>
    <li><a href="index.php">Accueil</a></li>

    <!-- Accessible uniquement connecté -->
    <?php if (isset($_SESSION['user'])) : ?>
      <li>
        Plateau de jeu
          <ul>
            <li><a href="index.php?page=gaming">Partie en cours</a></li>
            <li><a href="index.php?page=create-game">Lancer une nouvelle partie</a></li>
          </ul>
      </li>
      <li>
        <a href="index.php?page=history">Historique des scores</a>
      </li>
    <?php endif ?>
    
    <li>
      Zone membre
      <ul>
        <?php if (!isset($_SESSION['user'])) : ?>
          <li><a href="index.php?page=login">Se connecter</a></li>
          <li><a href="index.php?page=register">S'inscrire</a></li>
        <?php else : ?>
          <li>Connecté en tant que : <?= $_SESSION['user']['pseudo'] ?> (<?= $_SESSION['user']['role'] ?>)</li>
          <li><a href="index.php?page=logout">Se déconnecter</a></li>
        <?php endif ?>
      </ul>

    </li>


  </ul>
</nav>