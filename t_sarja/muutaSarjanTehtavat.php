<?php
	include '../kirjautuminen/tarkistus.php';
	include '../db_connct.php';

	if(isset($_POST['button'])) {
		$yhteys = luo_yhteys();
		$nro = 0;
		$paivitys = 1;
		$poisto = 1;
		$nimi = $_SESSION['tlnimi'];
		$jokinMeniVikaan = 0;

		// Poistetaan vanhat.
		pg_query("BEGIN");

		$tehtavat_pois = "DELETE FROM htsysteemi.sisaltyy_listaan WHERE tl_nimi = '$nimi'";
		$poisto = (int)(pg_query($tehtavat_pois));

    if ($poisto)
			pg_query("COMMIT");
		else {
			pg_query("ROLLBACK");
			$jokinMeniVikaan = 1;
		}

		foreach($_POST['tehtava'] as $tehtava) {
			$nro++;
			$tehtava_sarjaan_ll = "INSERT INTO htsysteemi.sisaltyy_listaan VALUES ('$tehtava', '$nimi', '$nro')";
			$paivitys = (int)(pg_query($tehtava_sarjaan_ll));

    	if ($paivitys && $poisto)
				pg_query("COMMIT");
			else {
				pg_query("ROLLBACK");
				$jokinMeniVikaan = 1;
			}
    }

		pg_close($yhteys);

		if (!$jokinMeniVikaan)
			header("Location: ../listojen_selausta/tehtava_listat.php");
		else {
			echo '<p>Tehtävien muuttamisessa tapahtui virhe.</p>';
			echo '<a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>';
		}
	}
?>
