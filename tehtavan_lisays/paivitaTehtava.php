<?php

	function paivitaVastaus($vastaus, $selitys, $vanha, $t_id) {
		$pituus = strlen( trim($vastaus) );

		if ($pituus > 0 && $vanha != '0')
			return (int)(pg_query("UPDATE htsysteemi.esimerkkivastaus SET esim_vast='$vastaus', selitys='$selitys' WHERE teht_id=$t_id AND esim_vast='$vanha'"));
		else if ($pituus > 0 && $vanha == '0')
			return (int)(pg_query("INSERT INTO htsysteemi.esimerkkivastaus VALUES ('$t_id', '$vastaus', '$selitys')"));
		else {
			pg_query("DELETE FROM htsysteemi.esimerkkivastaus WHERE teht_id=$t_id AND esim_vast='$vanha'");
			return 1;
		}
	}

	if (isset($_POST['tallenna'])) {
		include '../kirjautuminen/tarkistus.php';
		include "../db_connct.php";
		$yhteys = luo_yhteys();

		// Tehtävän tiedot
		$tyyppi = $_POST['tyyppi'];
		$kuvaus = pg_escape_string($_POST['kuvaus']);
		$teht_id = $_SESSION['tehtava_id'];

		$tehtava_ml = "UPDATE htsysteemi.tehtava SET tyyppi='$tyyppi', kuvaus='$kuvaus' WHERE teht_id=$teht_id";

		// Esimerkkivastaukset
		$vanha1 = $_SESSION['v_vastaus1'];
		$vastaus1 = $_POST['esimerkkivastaus'];
		$selitys1 = $_POST['selitys'];

		$vanha2 = $_SESSION['v_vastaus2'];
		$vastaus2 = $_POST['esimerkkivastaus2'];
		$selitys2 = $_POST['selitys2'];

		$vanha3 = $_SESSION['v_vastaus3'];
		$vastaus3 = $_POST['esimerkkivastaus3'];
		$selitys3 = $_POST['selitys3'];

		// =============== Tapahtuma alkaa...
		pg_query("BEGIN");

		$tehtava_paiv = (int)(pg_query($tehtava_ml));
		$vastaus1_paiv = paivitaVastaus($vastaus1, $selitys1, $vanha1, $teht_id);
		$vastaus2_paiv = paivitaVastaus($vastaus2, $selitys2, $vanha2, $teht_id);
		$vastaus3_paiv = paivitaVastaus($vastaus3, $selitys3, $vanha3, $teht_id);		

		if ($tehtava_paiv && $vastaus1_paiv && $vastaus2_paiv && $vastaus3_paiv)
			pg_query("COMMIT");
		else
			pg_query("ROLLBACK");

		header("Location: tehtavalista.php");
		
		pg_close($yhteys);
	}
?>
