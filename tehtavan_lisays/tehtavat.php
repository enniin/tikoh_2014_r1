<?php
	function luoLista($lajittelu) {
			$hakulause = "SELECT teht_id, tyyppi, kuvaus, luontipvm, kayt_id FROM htsysteemi.tehtava ORDER BY $lajittelu";
			$tulos = pg_query($hakulause);
			$kayt_id = $_SESSION['kirjautunut'];
	
			if (!((int)$tulos)) {
				echo "Tehtäviä ei löytynyt.";
				exit;
			}
			
			echo "<table>";
				echo "<tr>";
					echo"<th>teht_id</th>";
					echo"<th>tyyppi</th>";
					echo"<th>kuvaus</th>";
					echo"<th>luonti_pvm</th>";
				echo "</tr>";

			while ($rivi = pg_fetch_row($tulos)) {
				echo "<tr>";
				echo "<td>$rivi[0]</td>";
				echo "<td>$rivi[1]</td>";
				echo "<td>".substr($rivi[2], 0, 20)."</td>";
				echo "<td>$rivi[3]</td>";

				$teht_id = $rivi[0];
				
				// Vain tehtävän luojan/yllapitajan sallitaan tehdä muutoksia.
				if ($kayt_id == $rivi[4] || tarkasta_rooli() == 'yllapitaja')
					echo "<td><a href='paivitaTehtavaLomake.php?tId=$teht_id'>Muokkaa</a></td>";
				
				echo "</tr>";
			}

			echo "</table>";
	}

	if (array_key_exists("luokitus",$_POST))
		luoLista($_POST['luokitus']);
	else
		luoLista('teht_id');
?>
