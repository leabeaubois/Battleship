
<?php
  /**
   * Récupérer le $user_id via la session
   */
  if (isset($_SESSION['user'])){
    $user_id = $_SESSION['user']['id'];
  }
  /**
   * Récupérer les valeurs la table ``cell`` pour construire le plateau
   * */
  // ! Attention : filtrer pour afficher le game correspondant au user 
  //  La requête devient une insertion qu'il faut préparer */
  $request = "SELECT 
              game_xid,
              cell_id AS id, 
              coord, isHitten, isSunk, hasBoat, boatName, boatLife
          FROM cell
          WHERE game_xid = ?
          ORDER BY id
          ";
  $searchCells = $pdo->prepare($request);   
  $searchCells->execute([$user_id]);
  $cells = $searchCells->fetchAll();

  $request = "SELECT strike_history
            FROM game
            WHERE game_id = ?";
  $searchHistory = $pdo->prepare($request);
  $searchHistory->execute([$user_id]);
  $strikeHistory = $searchHistory->fetch();



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

            /** Ajout des classes */
            $typeCell = "sea";
            $isHittenCell = "";
            $boatCell = $cell['boatName'] ? $cell['boatName'] : "";
            
            if($cell['hasBoat']){
              $typeCell = "boat";
            }
            
            if($cell['isHitten']){
              $isHittenCell = "hitten";
            }
          
          $tableRow .= "<td class='". $typeCell . " " . $isHittenCell . " " . $boatCell . "'></td>";
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
    <div id="game-id">
    <?= $_SESSION['user']['pseudo'] ?>
      <p>Score : 00000</p>
      <?php
        date_default_timezone_set('Europe/Paris');?>
        <p> <?= "Fuseau horaire 'Europe/Paris'";?></p>
        <p><?= date('Y-m-d H:i:s'); ?></p>
    </div>
    <div id="radar"></div>
  </div>  

  <div id="middle">
    <div id="board">
      <?php 
        echo createBoard($cells);
      ?>
    </div>

  <?php require 'command.php';?>

  </div>

  <div id="right">
    <div id="strike-history">
      <!-- Stocker toutes les commandes envoyées dans un tableau et les afficher ici -->
      
      <?php  
        $strikes = explode(", ", $strikeHistory['strike_history']);?>
      <?php foreach($strikes as $strike): ?>
        <li><?= $strike ?></li>
      <?php endforeach?>
    </div>
    <div id="boat-stats">
      <!-- Requête pour afficher une liste des bateau et leur niveau de vie -->
      <?php
      $BOATS = [];
      $hits = 0;
      $boat = '';
      $life = 0;
      foreach ($cells as $cell) {
        # 1 - Si la cellule a un bateau et que le bateau n'est pas déjà dans le tableau $BOATS
        if($cell['hasBoat'] && !array_key_exists($cell['boatName'], $BOATS)){
          # 2 - Je l'ajoute au tableau avec sa vie
          $BOATS['name'] = $cell['boatName'];
          $BOATS['life'] = $cell['boatLife'];
        }
        // # 3 - Si la cellule est le bateau et qu'elle est touchée, on augmente les $hits
        // if($BOAT[$cell['boatName']] = $cell['boatName'] && $cell['isHitten']){
        //     $hits++;
        // }
      }
      print_r($BOATS);
      // echo $life - $hits;
    

      
      ?>
    </div>
  </div>
</main>