<?php

	// R1 - yksittäisen session tietoja:
	
	
	$kysely = "WITH ses_agg AS
(
SELECT st.ses_id, sum(kesto) as aika, count(st.nro) as tehtavia, sum(oikeat) as kpl_oikein
FROM sessiotiedot as st INNER JOIN
	(select ses_id, nro, case when oikein = 't' then 1 else 0 end oikeat from sessiotiedot) AS oik
	ON st.ses_id = oik.ses_id AND st.nro = oik.nro
GROUP BY st.ses_id
ORDER BY st.ses_id
)
SELECT pvm, etunimi || ' ' || sukunimi as suorittaja, tl_nimi, aika, tehtavia, kpl_oikein 
FROM (kayttaja INNER JOIN sessio ON kayttaja.kayt_id = sessio.kayt_id)
	INNER JOIN ses_agg ON sessio.ses_id = ses_agg.ses_id
ORDER BY pvm, tl_nimi;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>session pvm</th><th>suorittaja</th><th>sarja</th><th>aika</th><th>tehtäviä oikein</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$aika = date_format(date_create($rivi[3]), 'H:i:s');
		echo "<tr><td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td><td>$aika</td><td>$rivi[5]/$rivi[4]</td></tr>";
	}
	echo "</table>";
			
?>