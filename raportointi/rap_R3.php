<?php

	// R3 - tehtävälistan tietoja:
	
	
	$kysely = "SELECT st.nro, t.kuvaus, sum(oikeat)*100/count(*) as oikein_pros, avg(kesto) as ka_aika
FROM (sessio INNER JOIN (
	tehtava as t INNER JOIN sessiotiedot as st ON t.teht_id = st.teht_id)
	ON sessio.ses_id = st.ses_id)
	INNER JOIN (select nro, case when oikein = 't' then 1 else 0 end oikeat from sessiotiedot) AS oik ON oik.nro = st.nro
WHERE tl_nimi = '$tlista'
GROUP BY st.nro, t.kuvaus
ORDER BY st.nro;";
			
	$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>nro</th><th>kuvaus</th><th>ratk%</th><th>ka aika</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$ka = date_format(date_create($rivi[3]), 'H:i:s');
		echo "<tr><td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td><td>$ka</td></tr>";
	}
	echo "</table>";
			
?>