<?php
  class Board
  {
    public array $cells = [];
    public array $LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

    public function __construct(){

    }
    
    public function createBoard()
    {
      /**
       *  Construire l'entête horizontale
       */
      $tableHeader = "";
      $tableRows = "";

      $table = "<table>";
      $table .= "<thead>";

      for ($x = -1; $x < 10; $x++) {
        $tableHeader .= "<th>" . $x . "</th>";
      }
      $table .= "<tr>$tableHeader</tr>";
      $table .= "</thead><tbody>";

      for ($u = 0; $u < 10; $u++) {
        $tableCell = "<th>" . $this->LETTERS[$u] . "</th>";
        for ($d = 0; $d < 10; $d++) {
          $coordi = $this->LETTERS[$u] . $d;
          $stateCell = $this->cells[$coordi]->state;
          $boatCell = $this->cells[$coordi]->boatName;
          $tableCell .= "<td class='" . $stateCell . " " . $boatCell . "'></td>";
        }
        $tableRows .= "<tr>" . $tableCell . "</tr>";
      }

      $table .= $tableRows;
      $table .= "</tbody></table>";
      return $table;
    }
  }
?>