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
  <!-- Requête des tous les user (pseudo) et afficher tous leurs meilleurs scores -->
  <ul>
    <?php foreach($users as $user):?>
      <li>
        <ul>RANG : <?= $rang ?>
          <li><?= $user['pseudo']?></li>
          <li><?= $user['maxScore']?></li>
        </ul>
        <?php $rang++; ?>
      </li>
    <?php endforeach ?>
  </ul>
</main>