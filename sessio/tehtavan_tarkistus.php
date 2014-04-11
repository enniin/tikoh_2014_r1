<?php 
include '../kirjautuminen/tarkistus.php';
include '../db_connct.php';
tarkasta_rooli();


$yhteys = luo_yhteys();
pg_query("set search_path to htsysteemi");

$ses_id = $_SESSION["ses_id"];
$tl_nimi = $_SESSION["tl_nimi"];
$teht_nro = $_SESSION["teht_nro"];

$teht_id_tulos = pg_query("select teht_id from sisaltyy_listaan where tl_nimi = '$tl_nimi' and nro = '$teht_nro'");
$teht_id_rivi = pg_fetch_row($teht_id_tulos);
$teht_id = $teht_id_rivi[0];

$alk_aika = $_POST["alk_aika"];
$vastaus = $_POST["vastaus"];

//Varsinainen tehtÃƒÂ¤vÃƒÂ¤n tarkistus tÃƒÂ¤ssÃƒÂ¤.
$esim_vast_tulos = @pg_query("select esim_vast from esimerkkivastaus where teht_id = $teht_id");
$esim_vast_rivi = pg_fetch_row($esim_vast_tulos);
$esim_vast = $esim_vast_rivi[0];
pg_query("set search_path to esimerkkikanta");
$oikea_tulos = pg_query($esim_vast);

$kayttajan_vast_tulos = pg_query($vastaus);
$oikein = "false";

if($kayttajan_vast_tulos) {
 while ($oikea_rivi = pg_fetch_row($oikea_tulos)) {
  if($oikea_rivi == pg_fetch_row($kayttajan_vast_tulos)) {
   $oikein = "true";
  }
 }
}

//Toimenpiteet tuloksen selvittyÃ¤.
if($oikein == "false") {
 if($_SESSION["yritys_nro"] >= 2) {
  $_SESSION["teht_nro"]++;
  $_SESSION["yritys_nro"] = 0;
 }
 else
  $_SESSION["yritys_nro"]++;
}

if($oikein == "true") {
 $_SESSION["teht_nro"]++;
 $_SESSION["yritys_nro"] = 0;
}

$vastaus = pg_escape_string($vastaus);

pg_query("set search_path to htsysteemi");
pg_query("insert into ratk_yritys(ses_id, teht_id, alk_aika, lop_aika, vastaus, oikein) values($ses_id, $teht_id, '$alk_aika', current_time, '$vastaus', $oikein)");

pg_close();

header('Location: ../sessio/tehtava.php');

?>
