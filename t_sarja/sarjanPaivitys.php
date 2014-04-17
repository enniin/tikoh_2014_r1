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

		$sarja_pl = "UPDATE htsysteemi.t_lista SET tl_kuvaus = '$kuvaus' WHERE tl_nimi = '$nimi'";
		$paivitys = (int)(pg_query($sarja_pl));

		if ($paivitys) {
			pg_query("COMMIT");
		}
		else
			pg_query("ROLLBACK");

		pg_close($yhteys);

		if ($paivitys)
			header("Location: ts_muutaTehtaviaLomake.php");		
	}
?>
