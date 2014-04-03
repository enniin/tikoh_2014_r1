<?php

	// Haetaan tietoja tehtävistä:
	$kysely = "SELECT nro, tyyppi, kuvaus FROM htsysteemi.sisaltyy_listaan AS sl, htsysteemi.tehtava AS th WHERE sl.tl_nimi = '$listanimi' AND sl.teht_id = th.teht_id;";
	$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
				
	// Taulukko:
	echo "<table><tr>";
	echo "<th>nro</th><th>tyyppi</th><th>tehtävä</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		echo "<tr><td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td></tr>";
	}
	echo "</table>";
			
?>