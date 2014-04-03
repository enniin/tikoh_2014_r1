<?php

	// Luodaan yhteys:
				include '../db_connct.php';
				$yhteys = luo_yhteys();
				
				// Haetaan listat:
				$kysely = "SELECT tl_nimi, tl_kuvaus, tl_luontipvm FROM htsysteemi.t_lista ORDER BY tl_luontipvm;";
				$tulos = pg_query($kysely);
				
				if (!$tulos)
				{
					echo "Virhe kyselyssä.\n";
					exit;
				}
				
				// Taulun tulostus:
				echo "<table><tr>";
				echo "<th>sarja</th><th>kuvaus</th><th>pvm</th></tr>";
				while ($rivi = pg_fetch_row($tulos))
				{
					$nimi = $rivi[0];
					//echo $nimi;
					echo '<tr><td><a href="listan_tiedot.php?listanimi=', $nimi, '">';
					echo $nimi, '</a></td>';
					echo "<td>$rivi[1]</td><td>$rivi[2]</td></tr>";
				}
				echo "</table>";
				
				pg_close($yhteys);

?>