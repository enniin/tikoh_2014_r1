<?php
	include '../kirjautuminen/tarkistus.php';
	include '../db_connct.php';

	if(isset($_POST['tallenna'])) {
		$yhteys = luo_yhteys();

		// Tehtävän tiedot.
		$nimi = $_SESSION['tlnimi'];
		$kuvaus = pg_escape_string($_POST['kuvaus']);

		// Lisätään...
		pg_query("BEGIN");
		$kuvaus_pl = "UPDATE htsysteemi.t_lista SET tl_kuvaus = '$kuvaus' WHERE tl_nimi = '$nimi'";
		$kuvaus_paivitys = (int)(pg_query($kuvaus_pl));

		if ($kuvaus_paivitys) {
			pg_query("COMMIT");
		}
		else
			pg_query("ROLLBACK");

		pg_close($yhteys);

		if ($kuvaus_paivitys)
			header("Location: ts_muutaTehtaviaLomake.php");
		else {
			echo '<p>Päivitys ei onnistunut.</p>';
			echo '<a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>';
		}

	}
?>
