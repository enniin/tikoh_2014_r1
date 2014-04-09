<?php
session_start();

//Tarkistaa, onko kÃ¤yttÃ¤jÃ¤ kirjautunut sisÃ¤Ã¤n.
//Jos on, funktio palauttaa kÃ¤yttÃ¤jÃ¤n roolin,
//muuten palautetaan false.
function tarkasta_rooli(){

 if(!array_key_exists("kirjautunut",$_SESSION))
  header('Location: ../kirjautuminen/kirjautumisvirhe.php');

 else
  return $_SESSION["rooli"];

}

?>
