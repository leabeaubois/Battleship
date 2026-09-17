<?php
/**
 * Récupérer les valeurs la table ``cell`` pour construire le plateau
 * */

  $sql = "SELECT cell_id AS id, coord, isHitten, isSunk, hasBoat, boatName
          FROM cell
          ORDER BY id
          ";

  $cells = $pdo->query($sql)->fetchAll();
?>

<?php
    /** 
     * Créer une première fonction pour construire le tableau depuis $cells
     * createBoard() sera ranger dans une class ``Board`` plus tard
    */
    function createBoard($cells){  
      $LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

        /**
         *  Construire l'entête horizontale
         */
        $tableHeader = "";
        $tableRows = "";
        $u = 0;
        $tableRow = "";

        $table = "<table>";
        $table .= "<thead>";

        for ($x = -1; $x < 10; $x++) {
          $tableHeader .= "<th>" . $x . "</th>";
        }
        $table .= "<tr>$tableHeader</tr>";
        $table .= "</thead><tbody>";

        /**
         * Parcourir les cellules, toutes les 10 cellules, ouvrir/fermer la rangée
         */
        foreach($cells as $cell){
          if($u % 10 == 0){
            $tableRow = "<th>" . $LETTERS[intdiv($u, 10)] . "</th>";
          }
            $typeCell = $cell['hasBoat'];
            if($typeCell){
              $typeCell = "boat";
            }
            
            $stateCell = $cell['isHitten'];
            if($typeCell){
              $isHittenCell = "hitten";
            }

            $boatCell = $cell['boatName'];
          
          $tableRow .= "<td class='". $typeCell . " " . $stateCell . " " . $boatCell . "'></td>";
          $u++;

          if($u % 10 == 0){
            $tableRows .= "<tr>" . $tableRow . "</tr>";
          }
        } // end of foreach

        $table .= $tableRows;
        $table .= "</tbody></table>";
        return $table;
    }
?>

<main>
  <div id="left">
    <div id="game-id"></div>
    <div id="radar"></div>
  </div>  
  <div id="board">
    <?php 
      echo createBoard($cells);
    ?>
  </div>
  <div id="right">
    <div id="history"></div>
    <div id="boat-stats"></div>
  </div>
  <div id="command-pannel">
    <!-- Formulaire de lancement des missiles -->
    <form action="" method="POST">
      <p>Verrouillage du missile, coordonnées : <input type="text" name="letterCommand"><input type="number" name="numberCommand"></p>
      <input type="submit" name="submit" value="Submit">
    </form>
    <div id="logs"></div>
  </div>
</main>