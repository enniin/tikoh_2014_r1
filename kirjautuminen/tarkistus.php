<?php
session_start();

//Tarkistaa, onko käyttäjä kirjautunut sisään.
//Jos on, funktio palauttaa käyttäjän roolin,
//muuten palautetaan false.
function tarkasta_rooli(){

 if(array_key_exists("kirjautunut",$_SESSION))
  return $_SESSION["rooli"];

 else
  header('Location: ../kirjautuminen/kirjautumisvirhe.php');

}

?>
