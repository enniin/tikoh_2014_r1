<?php

	// Opiskelijoiden tietoja opelle:
	
	$id = $_SESSION['kirjautunut'];
	
	$kysely = "WITH op AS
(
SELECT ka.kayt_id, etunimi || ' ' || sukunimi as nimi
FROM ((select tl_nimi from t_lista where kayt_id = 6) as tl
	INNER JOIN sessio ON sessio.tl_nimi = tl.tl_nimi)
	INNER JOIN kayttaja AS ka ON ka.kayt_id = sessio.kayt_id
)
SELECT op.nimi, count(distinct s.ses_id) as sessioita, sum(oikeat)*100/count(*) as oik_pros, round(avg(yrit_oik)::numeric,2) as ka_yrit, avg(kesto) as ka_aika
FROM (op INNER JOIN sessio as s ON op.kayt_id = s.kayt_id)
	INNER JOIN (select ses_id, kesto,
	case when oikein = 't' then 1 else 0 end oikeat,
	case when oikein = 't' then yrityksia else NULL end yrit_oik
	from sessiotiedot) AS oik
	ON oik.ses_id = s.ses_id
GROUP BY op.nimi
ORDER BY sessioita;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Ei vielä suorituksia!\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>nimi</th><th>sessioita</th><th>ratk%</th><th>ka yrit.</th><th>ka aika/teht</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$ka = date_format(date_create($rivi[4]), 'H:i:s');
		echo "<tr><td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td><td>$rivi[3]</td><td>$ka</td></tr>";
	}
	echo "</table>";
			
?>