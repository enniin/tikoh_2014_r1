<?php

	// R6 - vertailu:
	
	
	$kysely = "SELECT paa_aine, count(s.ses_id) as sessioita, sum(oikeat)*100/count(*) as oik_pros, round(avg(yrit_oik)::numeric,2) as ka_yrit, avg(kesto) as ka_aika
FROM (opiskelija as op INNER JOIN sessio as s ON op.kayt_id = s.kayt_id)
	INNER JOIN (select ses_id, kesto,
	case when oikein = 't' then 1 else 0 end oikeat,
	case when oikein = 't' then yrityksia else NULL end yrit_oik
	from sessiotiedot) AS oik
	ON oik.ses_id = s.ses_id
GROUP BY paa_aine
ORDER BY oik_pros DESC;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>pääaine</th><th>sessioita yht.</th><th>ratk%</th><th>ka yrit.</th><th>ka aika/teht</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$ka = date_format(date_create($rivi[4]), 'H:i:s');
		echo "<tr><td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td><td>$rivi[3]</td><td>$ka</td></tr>";
	}
	echo "</table>";
			
?>