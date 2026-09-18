<main>
  <?php if (!isset($_SESSION['user'])) : ?>
      <h2>Bienvenue camarade</h2>
      <p>Il est temps de couler des navires de guerre ! <a href="index.php?page=register">Inscris-toi</a> pour jouer et remplir ta mission ou <a href="index.php?page=login">connecte toi</a> vite si tu as déjà un compte ! </p>
    <?php else : ?>
      <h2>Camarade <?= $_SESSION['user']['pseudo'] ?></h2>
      <p>Le radar n'arrête pas de sonner ! <a href="index.php?page=gaming">Rejoins vite la partie</a> !</p>
  <?php endif ?>
</main>