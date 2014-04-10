<?php

	// R5 - kyselytyyppien vaikeus:
	
	
	$kysely = "SELECT t.tyyppi, avg(kesto) as ka_aika, round(avg(yrit_oik)::numeric,2) as ka_yrit, 100 - sum(oikeat)*100/count(*) as ei_pros
FROM (tehtava as t INNER JOIN sessiotiedot as st ON t.teht_id = st.teht_id)
	INNER JOIN (select teht_id,
	case when oikein = 't' then 1 else 0 end oikeat,
	case when oikein = 't' then yrityksia else NULL end yrit_oik
	from sessiotiedot) AS oik
	ON oik.teht_id = t.teht_id
GROUP BY t.tyyppi
ORDER BY ka_aika DESC;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>tyyppi</th><th>ka aika</th><th>ka yrit.</th><th>ei-ratk%</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$ka = date_format(date_create($rivi[1]), 'H:i:s');
		echo "<tr><td>$rivi[0]</td><td>$ka</td><td>$rivi[2]</td><td>$rivi[3]</td></tr>";
	}
	echo "</table>";
			
?>