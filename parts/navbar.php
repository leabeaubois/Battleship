<nav>
  <ul>
    <li><a href="index.php">Accueil</a></li>
    <li>
      Plateau de jeu (seulement si connecté)
      <ul>
        <li><a href="index.php?page=gaming">Partie en cours</a></li>
        <!-- < ?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?> -->
        <li><a href="index.php?page=new-game">Lancer une nouvelle partie</a></li>
        <!-- < ?php endif ?> -->
      </ul>
    </li>
    <li>
      <a href="index.php?page=history">Historique des scores</a>
    </li>
    
    <li>
      Zone membre
      <ul>
        <!-- < ?php if (!isset($_SESSION['user'])) : ?> -->
          <li><a href="index.php?page=login">Se connecter</a></li>
          <li><a href="index.php?page=register">S'inscrire</a></li>
        <!-- < ?php else : ?> -->
          <!-- <li>Connecté en tant que : < ?= $_SESSION['user']['email'] ?> (< ?= $_SESSION['user']['role'] ?>)</li> -->
          <li>Connecté en tant que : </li>
          <li><a href="index.php?page=logout">Se déconnecter</a></li>
        <!-- < ?php endif ?> -->
      </ul>

    </li>


  </ul>
</nav>