
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
  //  Requête du jeu
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


  // Requête de l'historique
  $request = "SELECT strike_history
            FROM game
            WHERE game_id = ?";
  $searchHistory = $pdo->prepare($request);
  $searchHistory->execute([$user_id]);
  $strikeHistory = $searchHistory->fetch();


  // Requête des bateaux
  $request = "SELECT boatName, boatSize, boatLife, isSunk, coord
              FROM boat
              WHERE game_xid = ?
              ";
  $searchBoats = $pdo->prepare($request);
  $searchBoats->execute([$user_id]);
  $boats = $searchBoats->fetchAll();
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
            $boatNameCell = '';

            if($cell['hasBoat']){
              //$typeCell = "boat";
              if($cell['isHitten']){
                $typeCell = "boat";
                $isHittenCell = "hitten";
              }
              if($cell['isSunk']){
                $typeCell = "sunk";
                $boatNameCell = $boatCell;
              }
            }
            

            if($cell['isHitten']){
              $isHittenCell = "hitten";
            }
          
          $tableRow .= "<td class='". $typeCell . " " . $isHittenCell . " " . $boatNameCell . "'></td>";
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
    <div id="radar">
    <!-- Un exemple de radar en pur CSS qui pourrait être implanté https://codepen.io/thebabydino/pen/AqbWeE -->
    </div>
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
      <!-- Stocker toutes les commandes envoyées dans un format json et les afficher ici
      
      Traitement des données reçu en json :
      https://www.php.net/manual/fr/function.json-decode.php
      https://developer.mozilla.org/fr/docs/Learn_web_development/Core/Scripting/JSON

      -->
      <p>Journal de bord</p>
      <?php  
        $strikes = json_decode($strikeHistory['strike_history']);
        $lastTenStrikes = array_slice($strikes, -10);
        ?>
      <p>...</p>  
      <?php foreach($lastTenStrikes as $strike): ?>
        <li><?= $strike ?></li>
      <?php endforeach?>
    </div>
    <div id="boat-stats">
      <!-- Requête pour afficher une liste des bateau et leur niveau de vie -->
      <p>Cibles</p>
      <?php   foreach($boats as $boat):        ?>  
        <li><?=  $boat['boatName'] ?> 
            <?php 
              $life =  $boat['boatLife'];
              if($life > 0){
                for($l = 0; $l < $life; $l++){
                  echo "♥";
                }
              }else{
                echo "<span class='life-sunk'>☠</span>";
              }
            ?>   
        </li>
      
      <?php endforeach ?>
    </div>
  </div>
</main>