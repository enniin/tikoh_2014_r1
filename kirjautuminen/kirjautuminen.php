<?php
session_start();

$kayt_tunnus = $_POST['kayt_tunnus'];
$salasana = $_POST['salasana'];

$y_tiedot = "host=dbstud.sis.uta.fi port=5432 dbname=tiko2014db1 user=a581011 password=salasana";

if (!$yhteys = pg_connect($y_tiedot))
 die("Tietokantayhteyden luominen epäonnistui.");

pg_query("set search_path to htsysteemi");

$kayt_id_tulos = pg_query("select kayt_id from kayttaja where kayt_tunnus = '$kayt_tunnus' and salasana = '$salasana'");

if(pg_num_rows($kayt_id_tulos) < 1)
 echo "Käyttäjänimi tai salasana väärin";

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
}

header('Location: salainen.php');
?>
