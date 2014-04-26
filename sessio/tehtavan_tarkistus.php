<?php 
include '../kirjautuminen/tarkistus.php';
include '../db_connct.php';
include 'manuaalinen_tarkistus.php';
tarkasta_rooli();

$yhteys = luo_yhteys();
pg_query("set search_path to htsysteemi");

$ses_id = $_SESSION["ses_id"];
$tl_nimi = $_SESSION["tlnimi"];
$teht_nro = $_SESSION["teht_nro"];

$teht_id_tulos = pg_query("select teht_id from sisaltyy_listaan where tl_nimi = '$tl_nimi' and nro = '$teht_nro'");
$teht_id_rivi = pg_fetch_row($teht_id_tulos);
$teht_id = $teht_id_rivi[0];

$alk_aika = $_POST["alk_aika"];
$vastaus = $_POST["vastaus"];

//Tässä muuttujassa totuusarvo merkkijonona, jotta voidaan käyttää sitä suoraan SQL-lauseissa.
$oikein = "false";

//Jos on jo aikaisemmin saatu syntaksivirhe, poistetaan vanha.
if(array_key_exists("syntaksivirhe", $_SESSION)) {
 unset($_SESSION["syntaksivirhe"]);
}

//Jos on jo aiemmin saatu virheilmoitus, poistetaan vanha.
if(array_key_exists("virheilm", $_SESSION)) {
 unset($_SESSION["virheilm"]);
}

//Tarkistetaan sulkeiden määrä ja puolipiste käyttäjän vastauksesta manuaalisesti.
if(!tarkista_sulkeet($vastaus))
 $_SESSION["syntaksivirhe"] = "Tarkista sulkeet!";
if(!tarkista_puolipiste($vastaus))
 $_SESSION["syntaksivirhe"] = "Puolipiste kyselyn per&auml;&auml;n!";

//Aletaan tarkistaa vastausta tarkemmin, jos syntaksivirheitä ei löytynyt.
if(!array_key_exists("syntaksivirhe", $_SESSION)) {
 //Lähetetään kantaan käyttäjän kysely.
 pg_query("set search_path to esimerkkikanta");
 $kayttajan_vast_tulos = pg_query($vastaus);

 //Käydään kyselyiden tulokset läpi, jos ei tullut virheilmoitusta.
 if($kayttajan_vast_tulos) {
  //Poikkeustapaus on insert-, delete- ja update-kyselyt, joilla ei ole tulosjoukkoa.
  pg_query("set search_path to htsysteemi");
  $teht_tyyppi_tulos = pg_query("select tyyppi from tehtava where teht_id = $teht_id");
  $teht_tyyppi_rivi = pg_fetch_row($teht_tyyppi_tulos);
  $teht_tyyppi = $teht_tyyppi_rivi[0];
  $_SESSION["teht_tyyppi"] = $teht_tyyppi;
  if($teht_tyyppi == "insert" || $teht_tyyppi == "delete" || $teht_tyyppi == "update") {
   $oikein = "true";
  }
  else {
   //Haetaan esimerkkivastaus ja tehdään sillä kysely.
   $esim_vast_tulos = pg_query("select esim_vast from esimerkkivastaus where teht_id = $teht_id");
   $esim_vast_rivi = pg_fetch_row($esim_vast_tulos);
   $esim_vast = $esim_vast_rivi[0];
   pg_query("set search_path to esimerkkikanta");
   $oikea_tulos = pg_query($esim_vast);
   //Alustetaan sessiomuuttujat kyselyjen vastausten tallentamista varten.
   $_SESSION["kayttajan_vastaus"] = "<table>";
   $_SESSION["oikea_vastaus"] = "<table>";
   while ($oikea_rivi = pg_fetch_row($oikea_tulos)) {
    $_SESSION["kayttajan_vastaus"] .= "<tr>";
    $_SESSION["oikea_vastaus"] .= "<tr>";
    //Jos rivit täsmäävät, tulos on oikein tähän mennessä.
    if($oikea_rivi == $kayttajan_rivi = pg_fetch_row($kayttajan_vast_tulos)) {
     $oikein = "true";
    }
    else {
     $oikein = "false";
    }
    //Tallennetaan samalla kyselyiden tulokset.
    foreach($kayttajan_rivi as $k_solu) {
     $_SESSION["kayttajan_vastaus"] .= "<td>$k_solu</td>";
    }
    $_SESSION["kayttajan_vastaus"] .= "</tr>";
    foreach($oikea_rivi as $o_solu) {
     $_SESSION["oikea_vastaus"] .= "<td>$o_solu</td>";
    }
    $_SESSION["oikea_vastaus"] .= "</tr>";
   }
   $_SESSION["oikea_vastaus"] .= "</table>";

   //Tallennetaan loputkin käyttäjän vastauksen tuloksesta.
   while($kayttajan_rivi = pg_fetch_row($kayttajan_vast_tulos)) {
    $_SESSION["kayttajan_vastaus"] .= "<tr>";
    foreach($kayttajan_rivi as $k_solu) {
     $_SESSION["kayttajan_vastaus"] .= "<td>$k_solu</td>";
    }
    $_SESSION["kayttajan_vastaus"] .= "</tr>";
   }
   $_SESSION["kayttajan_vastaus"] .= "</table>";

  }
 }
 //Jos kysely ei onnistunut, tallennetaan sessiomuuttujaan tietokannan virheilmoitus.
 else {
  $_SESSION["virheilm"] = pg_last_error();
 }
}

//Toimenpiteet tuloksen selvittyä.
if($oikein == "false") {
 //Jos meni väärin ja yrityksiä on jo kolme, siirrytään seuraavaan tehtävään ja näytetään ratkaisut.
 if($_SESSION["yritys_nro"] >= 2) {
  $_SESSION["teht_nro"]++;
  $_SESSION["yritys_nro"] = 0;
  $_SESSION["nayta_ratk"] = true;
 }
 //Muuten kasvatetaan yritysten lukumäärää.
 else
  $_SESSION["yritys_nro"]++;
}

//Jos meni oikein, siirrytään seuraavaan tehtävään.
if($oikein == "true") {
 $_SESSION["teht_nro"]++;
 $_SESSION["yritys_nro"] = 0;
}

$_SESSION["oikein"] = $oikein;

//Muotoillaan käyttäjän vastaus tietokantaan tallentamiseen sopivaksi.
$vastaus = pg_escape_string($vastaus);

//Tallennetaan ratkaisuyrityksen tiedot.
pg_query("set search_path to htsysteemi");
pg_query("insert into ratk_yritys(ses_id, teht_id, alk_aika, lop_aika, vastaus, oikein) values($ses_id, $teht_id, '$alk_aika', current_time, '$vastaus', $oikein)");

pg_close();

header('Location: ../sessio/vastaus.php');

?>
