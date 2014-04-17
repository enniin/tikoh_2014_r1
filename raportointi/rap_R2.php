<?php

	// R2 - tehtävälistan tietoja:
	
	
	$kysely = "WITH tl_sessiot AS
(
SELECT st.ses_id, tl_nimi, sum(kesto) as ses_kesto
FROM sessio INNER JOIN sessiotiedot as st ON sessio.ses_id = st.ses_id 
GROUP BY st.ses_id, tl_nimi
)
SELECT tl_nimi, min(ses_kesto) as nopein_aika, max(ses_kesto) as pisin_aika, avg(ses_kesto) ka_aika, count(*) as ses_lkm
FROM tl_sessiot
GROUP BY tl_nimi;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>tehtävälista</th><th>nopein aika</th><th>hitain aika</th><th>keskimääräinen</th><th>sessioita</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$tl = $rivi[0];
		$min = date_format(date_create($rivi[1]), 'H:i:s');
		$max = date_format(date_create($rivi[2]), 'H:i:s');
		$ka = date_format(date_create($rivi[3]), 'H:i:s');
		echo "<tr><td><a href='raportti_R3.php?tlista=$tl'>$tl</a></td><td>$min</td><td>$max</td><td>$ka</td><td>$rivi[4]</td></tr>";
	}
	echo "</table>";
			
?>