<?php
	$kayt_id = $_SESSION['kirjautunut'];
	$tId = $_GET['tId'];
	
	// Haetaan listan tekijän id.
	$tekija_haku = "SELECT kayt_id FROM htsysteemi.tehtava WHERE teht_id = '$tId' AND kayt_id = '$kayt_id'";
	$loytyiko = pg_num_rows(pg_query($tekija_haku));

	if (!$loytyiko && $_SESSION['rooli'] != 'yllapitaja') {
		echo "<p>Ei oikeuksia!";
		echo '<a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>';
		exit();
	}
?>
