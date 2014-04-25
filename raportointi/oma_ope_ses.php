<?php

	// Open listojen tietoja:
	
	$id = $_SESSION['kirjautunut'];
	
	$kysely = "WITH opest AS
(
SELECT st.ses_id, nro, kesto, yrityksia, oikein
FROM sessiotiedot AS st INNER JOIN
  (SELECT ses_id
  FROM (select tl_nimi from t_lista where kayt_id = $id) AS tl 
  INNER JOIN sessio ON sessio.tl_nimi = tl.tl_nimi)
  AS opeses
  ON opeses.ses_id = st.ses_id
)
SELECT opest.ses_id, pvm, etunimi || ' ' || sukunimi as suorittaja, sessio.tl_nimi, sum(kesto) as aika, count(opest.nro) as tehtavia, sum(oikeat) as kpl_oikein
FROM (opest INNER JOIN
  (select ses_id, nro, case when oikein = 't' then 1 else 0 end oikeat from opest) AS oik
	ON opest.ses_id = oik.ses_id AND opest.nro = oik.nro)
	INNER JOIN (kayttaja INNER JOIN sessio ON kayttaja.kayt_id = sessio.kayt_id)
	ON opest.ses_id = sessio.ses_id
GROUP BY opest.ses_id, pvm, suorittaja, sessio.tl_nimi
ORDER BY opest.ses_id;";
			
			$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	date_default_timezone_set('Europe/Helsinki');
	
	// Taulukko:
	echo "<table><tr>";
	echo "<th>session pvm</th><th>suorittaja</th><th>lista</th><th>aika</th><th>tehtäviä oikein</th></tr>";
	while ($rivi = pg_fetch_row($tulos))
	{
		$aika = date_format(date_create($rivi[4]), 'H:i:s');
		echo "<tr><td>$rivi[1]</td><td>$rivi[2]</td><td>$rivi[3]</td><td>$aika</td><td>$rivi[6]/$rivi[5]</td></tr>";
	}
	echo "</table>";
			
?>