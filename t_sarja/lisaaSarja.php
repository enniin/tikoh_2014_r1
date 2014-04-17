<?php
	include '../kirjautuminen/tarkistus.php';
	include '../db_connct.php';

	if(isset($_POST['tallenna'])) {
		$yhteys = luo_yhteys();

		// Tehtävän tiedot.
		$nimi = pg_escape_string($_POST['nimi']);
		$kuvaus = pg_escape_string($_POST['kuvaus']);
		$pvm = date("Y-m-d");
		$kayt_id = $_SESSION['kirjautunut'];

		// Lisätään...
		pg_query("BEGIN");

		$sarja_ll = "INSERT INTO htsysteemi.t_lista VALUES ('$nimi', '$kuvaus', '$pvm', '$kayt_id')";
		$paivitys = (int)(pg_query($sarja_ll));

		if ($paivitys) {
			pg_query("COMMIT");
			$_SESSION['sarjan_nimi'] = $nimi;
		}
		else
			pg_query("ROLLBACK");

		pg_close($yhteys);

		if ($paivitys)
			header("Location: ts_tehtavalista.php");
	}
?>
