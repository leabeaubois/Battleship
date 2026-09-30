<?php
/*
  $FLOTTILA = [
    ["Carrier", 5],
    ["Battleship", 4],
    ["Destroyer", 3],
    ["Submarine", 3],
    ["Patrol Boat", 2],
  ];
*/
?>

<form action="" method="POST">
  <h2>Positioner la flotte : </h2>
  <p>Navire de transport : </p>

  <label for="carrier-start-letter"></label>
  <input type="text"
          pattern="[A-J]+[0-9]+" 
          minlength="2" maxlength="2" 
          id="carrier-start-letter" 
          name="carrier-start-letter" 
          value="" 
          placeholder="A0">
    <div class="radio-input">
      <input type="radio" name="carrier" id="carrier-orientation" value="vertical" checked />
      <label for="carrier-orientation">Vertical</label>
    </div>
    <div class="radio-input">
      <input type="radio" name="carrier" id="carrier-orientation" value="horizontal" checked />
      <label for="carrier-orientation">Horizontal</label>
    </div> 

  <p>Navire de guerre : </p>
  <label for="battleship-start-letter"></label>
  <input type="text"
          pattern="[A-J]+[0-9]+" 
          minlength="2" maxlength="2" 
          id="battleship-start-letter" 
          name="battleship-start-letter" 
          value="" 
          placeholder="A0">


    <div class="radio-input">
      <input type="radio" name="battleship" id="battleship-orientation" value="vertical" checked />
      <label for="battleship-orientation">Vertical</label>
    </div>
    <div class="radio-input">
      <input type="radio" name="battleship" id="battleship-orientation" value="horizontal" checked />
      <label for="battleship-orientation">Horizontal</label>
    </div>

  <p>Contre-torpilleur : </p>
  <label for="destroyer-start-letter"></label>
  <input type="text"
          pattern="[A-J]+[0-9]+" 
          minlength="2" maxlength="2" 
          id="destroyer-start-letter" 
          name="destroyer-start-letter" 
          value="" 
          placeholder="A0">

      <div class="radio-input">
        <input type="radio" name="destroyer" id="destroyer-orientation" value="vertical" checked />
        <label for="destroyer-orientation">Vertical</label>
      </div>
      <div class="radio-input">
        <input type="radio" name="destroyer" id="destroyer-orientation" value="horizontal" checked />
        <label for="destroyer-orientation">Horizontal</label>
      </div>   
</form>