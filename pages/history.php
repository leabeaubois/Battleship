<?php
/**
 * Récupérer des valeurs de la table ``user``
 * `` pseudo`` et ``max_score``
 * */

  $sql = "SELECT user_id AS id, pseudo, maxScore
          FROM user
          ORDER BY maxScore DESC
          ";

  $users = $pdo->query($sql)->fetchAll();
  $rang = 0;
?>


<main>
  <div id="left" class="history"></div>
  <div id="middle" class="history">
    <h1>Meilleurs scores</h1>
    <!-- Requête des tous les user (pseudo) et afficher tous leurs meilleurs scores -->
    <ul class="history-user">
      <?php foreach($users as $user):?>
        <li>
          <ul>RANG : <?= $rang ?>
            <li><?= $user['pseudo']?></li>
            <li>Score : <?= $user['maxScore']?></li>
          </ul>
          <?php $rang++; ?>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
</main>