<?php 
include '../kirjautuminen/tarkistus.php';
include '../db_connct.php';

$yhteys = luo_yhteys();
pg_query("set search_path to htsysteemi");

//Tehdään uusi ses_id manuaalisesti
$ses_id_tulos = pg_query("select max(ses_id) from sessio");
$ses_id_rivi = pg_fetch_row($ses_id_tulos);
$ses_id = $ses_id_rivi[0];
$ses_id++;

$kayt_id = $_SESSION["kirjautunut"];
$tl_nimi = $_SESSION["tl_nimi"];

pg_query("insert into sessio(ses_id, kayt_id, tl_nimi, pvm) values('$ses_id', '$kayt_id', '$tl_nimi', current_date)");


//Tallennetaan tehtävälista ja session id sessiomuuttujiin. Teht_nro on tällä hetkellä suoritettavan tehtävän numero, 
//joka alustetaan nollaksi jotta seuraavaksi voidaan luontevasti kasvattaa yhdellä.
$_SESSION["tlnimi"] = $tlnimi;
$_SESSION["ses_id"] = $ses_id;
$_SESSION["teht_nro"] = 0;

pg_close();

header('Location: ../sessio/tehtava.php');
?>
