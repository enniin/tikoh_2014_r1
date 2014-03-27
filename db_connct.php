<?php

function luo_yhteys() {
// funktio luo tietokantayhteyden
$y_tiedot = "host=dbstud.sis.uta.fi port=5432 dbname=tiko2014db1 user=js96416 password=gioRGi0n0";

if (!$yhteys = pg_connect($y_tiedot))
   exit("Tietokantayhteyden luominen epäonnistui.");
return $yhteys;
}
?>