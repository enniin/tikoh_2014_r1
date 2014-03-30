<?php
include '../db_connct.php';
include '../kirjautuminen/tarkistus.php';

// Tarkistetaan käyttöoikeus.
if (!tarkasta_rooli())
{
	echo 'Kirjautuminen vaaditaan!';
	echo '<a href="../kirjautuminen/kirjaudu.html"> Kirjaudu >></a>';
	exit;
}

echo '<div id="signout">';
echo 'Käyttöoikeus: ', $_SESSION["rooli"];
echo '<br /><a href="../kirjautuminen/ulos.php">Kirjaudu ulos</a>';
echo '</div>';

// Tarkistaa, onko ylimääräisiin vastauskenttiin lisätty tietoa.
function tarkistaVastaus($pituus, $lisayslause) {
	if ($pituus > 0)
		return (int)(pg_query($lisayslause));
	else
		return 1;
}

// Lisätään tehtävä.
$yhteys = luo_yhteys();

if (isset($_POST['tallenna'])) {
	// Tehtävä
	$tyyppi = $_POST['tyyppi'];
	$kuvaus = pg_escape_string($_POST['kuvaus']);
	$pvm = date("Y-m-d");
	$kayt_id = $_SESSION["kirjautunut"];
	$tehtavan_lisays = "INSERT INTO tehtava VALUES (DEFAULT, '$tyyppi', '$kuvaus', '$pvm', '$kayt_id')";

	// Tehtävän ID esimerkkivastauksia varten.
	$teht_lkm_lasku = "SELECT COUNT(teht_id) FROM tehtava";
	$teht_id_hakutulos = pg_query($teht_lkm_lasku);
	$teht_id = pg_fetch_result($teht_id_hakutulos, 0, 0) + 1;

	// Esimerkkivastaukset.
	$eka_vastaus = $_POST['esimerkkivastaus'];
	$eka_selitys = $_POST['selitys'];
	$eka_vastaus_lisays = "INSERT INTO esimerkkivastaus VALUES ('$teht_id', '$eka_vastaus', '$eka_selitys')";

	$toka_vastaus = $_POST['esimerkkivastaus2'];
	$toka_selitys = $_POST['selitys2'];
	$toka_vastaus_lisays = "INSERT INTO esimerkkivastaus VALUES ('$teht_id', '$toka_vastaus', '$toka_selitys')";
	$toka_vastaus_pituus = strlen( trim($toka_vastaus) );

	$kolmas_vastaus = $_POST['esimerkkivastaus3'];
	$kolmas_selitys = $_POST['selitys3'];
	$kolmas_vastaus_lisays = "INSERT INTO esimerkkivastaus VALUES ('$teht_id', '$kolmas_vastaus', '$kolmas_selitys')";
	$kolmas_vastaus_pituus = strlen( trim($kolmas_vastaus) );

	// Lisätään tehtävä...
	pg_query("BEGIN");

	$tehtava_paivitys = (int)(pg_query($tehtavan_lisays));
	$eka_vastaus_paivitys = (int)(pg_query($eka_vastaus_lisays));
	$toka_vastaus_paivitys = tarkistaVastaus($toka_vastaus_pituus, $toka_vastaus_lisays);
	$kolmas_vastaus_paivitys = tarkistaVastaus($kolmas_vastaus_pituus, $kolmas_vastaus_lisays);

	if ($tehtava_paivitys && $eka_vastaus_paivitys && $toka_vastaus_paivitys && $kolmas_vastaus_paivitys) {
		echo "Lisäys onnistui.";
		pg_query("COMMIT");
	}
	else {
		echo "Lisäys ei onnistunut.";
		pg_query("ROLLBACK");
	}
}

$pg_close($yhteys);
?>
