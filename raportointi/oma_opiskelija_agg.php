<?php

	// Opiskelijan omien sessioiden tietoja:
	
	$id = $_SESSION['kirjautunut'];
	
	$kysely = "WITH sesteht AS
(
SELECT st.ses_id, st.teht_id, tyyppi, kesto, yrityksia, oikein
FROM ((select ses_id from sessio where kayt_id = $id) AS ses
  INNER JOIN sessiotiedot AS st ON ses.ses_id = st.ses_id)
  INNER JOIN tehtava AS t ON t.teht_id = st.teht_id
)
SELECT tyyppi, sum(oikeat)*100/count(*) as oik_pros, round(avg(yrit_oik)::numeric,2) as ka_yrit, avg(oik.kesto) as ka_aika
FROM sesteht INNER JOIN
   (select ses_id, kesto,
	case when oikein = 't' then 1 else 0 end oikeat,
	case when oikein = 't' then yrityksia else NULL end yrit_oik
	from sesteht) AS oik
	ON oik.ses_id = sesteht.ses_id
GROUP BY tyyppi;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Ei vielä suorituksia!\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>tehtävätyyppi</th><th>ratk%</th><th>ka yrit.</th><th>ka aika/teht</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$ka = date_format(date_create($rivi[3]), 'H:i:s');
		echo "<tr><td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td><td>$ka</td></tr>";
	}
	echo "</table>";
			
?>