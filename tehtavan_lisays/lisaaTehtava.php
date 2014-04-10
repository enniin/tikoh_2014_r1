<?php
	include '../kirjautuminen/tarkistus.php';
	include '../db_connct.php';

	// Jos vastauskentässä on sisältöä, sen tiedot lisätään
	// kantaan.
	function luoVastaus($teht_id, $vastaus, $selitys) {
		$pituus = strlen( trim($vastaus) );

		if ($pituus > 0)
			return (int)(pg_query("INSERT INTO htsysteemi.esimerkkivastaus VALUES ('$teht_id', '$vastaus', '$selitys')"));
		else
			return 1;
	}

	if(isset($_POST['tallenna'])) {
		$yhteys = luo_yhteys();

		// Tehtävän tiedot.
		$tyyppi = $_POST['tyyppi'];
		$kuvaus = pg_escape_string($_POST['kuvaus']);
		$pvm = date("Y-m-d");
		$kayt_id = $_SESSION['kirjautunut'];

		// Vastaukset.
		$vastaus1 = $_POST['esimerkkivastaus'];
		$vastaus2 = $_POST['esimerkkivastaus2'];
		$vastaus3 = $_POST['esimerkkivastaus3'];

		// Vastauksien selitykset.
		$selitys1 = $_POST['selitys'];
		$selitys2 = $_POST['selitys2'];
		$selitys3 = $_POST['selitys3'];

		// Teht:n ID vastauksien talletusta varten.
		$teht_id = pg_fetch_result( pg_query("SELECT COUNT(teht_id) FROM htsysteemi.tehtava"), 0, 0) + 1;

		// Lisätään...
		pg_query("BEGIN");

		$tehtava_ll = "INSERT INTO htsysteemi.tehtava VALUES (DEFAULT, '$tyyppi', '$kuvaus', '$pvm', '$kayt_id')";
		
		$tehtava_paiv = (int)(pg_query($tehtava_ll));
		$vastaus1_paiv = luoVastaus($teht_id, $vastaus1, $selitys1);
		$vastaus2_paiv = luoVastaus($teht_id, $vastaus2, $selitys2);
		$vastaus3_paiv = luoVastaus($teht_id, $vastaus3, $selitys3);

		$onnistui = $tehtava_paiv && $vastaus1_paiv && $vastaus2_paiv && $vastaus3_paiv;

		if ($onnistui)
			pg_query("COMMIT");
		else
			pg_query("ROLLBACK");

		pg_close($yhteys);

		if ($onnistui)
			header("Location: tehtavalista.php");
	}
?>
