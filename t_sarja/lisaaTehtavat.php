<?php
	include '../kirjautuminen/tarkistus.php';
	include '../db_connct.php';

	if(isset($_POST['button'])) {
		$yhteys = luo_yhteys();
		$nro = 0;
		$paivitys = 1;

		foreach($_POST['tehtava'] as $tehtava) {
			$nro++;
			$nimi = $_SESSION['sarjan_nimi'];
			$tehtava_sarjaan_ll = "INSERT INTO htsysteemi.sisaltyy_listaan VALUES ('$tehtava', '$nimi', '$nro')";
			
			// Lisätään...
			pg_query("BEGIN");

			$paivitys = (int)(pg_query($tehtava_sarjaan_ll));

			if ($paivitys)
				pg_query("COMMIT");
			else
				pg_query("ROLLBACK");
    	}

		pg_close($yhteys);
	
		header("Location: ../listojen_selausta/tehtava_listat.php");
	}
?>
