<?php 
include '../kirjautuminen/tarkistus.php';
include '../db_connct.php';
?>

<!DOCTYPE HTML>
<html lang="fi">

<head>
<meta charset = "UTF-8" />
<title>TikoHT - SQL-harjoituksia kaikille!</title>

<link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
<link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
</head>

<body>
<div id="main">

<header>
<h1>SQL-harjoituksia</h1>
</header>

<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
<article>
<?php	 
include '../listojen_selausta/ulospalikka.php';

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

//Varsinainen tehtävän tarkistus tässä.
$esim_vast_tulos = pg_query("select esim_vast from esimerkkivastaus where teht_id = $teht_id");
$esim_vast_rivi = pg_fetch_row($esim_vast_tulos);
$esim_vast = $esim_vast_rivi[0];
pg_query("set search_path to esimerkkikanta");
$oikea_tulos = pg_query($esim_vast);

while ($rivi = pg_fetch_row($oikea_tulos)) {
 for($i = 0; $i < count($rivi); i++) {
  echo($rivi[$i]);
 }
}



pg_query("set search_path to htsysteemi");
pg_query("insert into ratk_yritys(ses_id, teht_id, alk_aika, lop_aika, vastaus, oikein) values($ses_id, $teht_id, '$alk_aika', current_time, '$vastaus', true)");

pg_close();

?>
</article>
</div>
</body>
</html>
