<?php

session_start();

$kayt_tunnus = $_POST['kayt_tunnus'];
$salasana = $_POST['salasana'];

// Ulkoinen yhteystiedosto (jens):
include '../db_connct.php';
				
$yhteys = luo_yhteys();

if (!$yhteys)
 die("Tietokantayhteyden luominen epäonnistui.");

pg_query("set search_path to htsysteemi");

$kayt_id_tulos = pg_query("select kayt_id from kayttaja where kayt_tunnus = '$kayt_tunnus' and salasana = '$salasana'");

if(pg_num_rows($kayt_id_tulos) < 1) {
 //echo "Käyttäjänimi tai salasana väärin<br>
   //<a href='kirjaudu.html'>Yritä uudelleen</a>";
}


else {
 $kayt_id_rivi = pg_fetch_row($kayt_id_tulos);
 $kayt_id = $kayt_id_rivi[0];
 $opiskelija_tulos = pg_query("select * from opiskelija where kayt_id = '$kayt_id'");
 
 if(pg_num_rows($opiskelija_tulos) > 0) {
  $_SESSION["kirjautunut"] = $kayt_id;
  $_SESSION["rooli"] = "opiskelija";
 }
 
 else {
  $opettaja_tulos = pg_query("select * from opettaja where kayt_id = '$kayt_id'");
  
  if(pg_num_rows($opettaja_tulos) > 0) {
   $_SESSION["kirjautunut"] = $kayt_id;
   $_SESSION["rooli"] = "opettaja";
  }
  
  else {
   $yllapitaja_tulos = pg_query("select * from yllapitaja where kayt_id = '$kayt_id'");
   
   if(pg_num_rows($yllapitaja_tulos) > 0) {
    $_SESSION["kirjautunut"] = $kayt_id;
    $_SESSION["rooli"] = "yllapitaja";
   }
  }
 }
 // Yritys siirtää eri sivulle (jens):
 header('Location: ../listojen_selausta/listan_tiedot.php');
}


?>
