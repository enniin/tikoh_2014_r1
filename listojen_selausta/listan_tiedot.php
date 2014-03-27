


<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Tehtävälistan tiedot</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>Tehtävälistan tiedot</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php
				$y_tiedot = "host=dbstud.sis.uta.fi port=5432 dbname=tiko2014db1 user=js96416 password=gioRGi0n0";

				if (!$yhteys = pg_connect($y_tiedot))
					 die("Tietokantayhteyden luominen epäonnistui.");
				
				$encoding = pg_client_encoding($yhteys);
				echo "Client encoding is: ", $encoding, "\n";
				
				$kysely = "SELECT tl_nimi, tl_kuvaus, tl_luontipvm, (select count(teht_id) from htsysteemi.sisaltyy_listaan where tl_nimi = 'Perushakuja 1') AS teht_lkm, etunimi, sukunimi FROM htsysteemi.t_lista AS tl INNER JOIN htsysteemi.kayttaja AS ka ON tl.kayt_id = ka.kayt_id WHERE tl_nimi = 'Perushakuja 1';";
				$tulos = pg_query($kysely);
				
				if (!$tulos)
				{
					echo "Virhe kyselyssä.\n";
					exit;
				}
		
				$rivi = pg_fetch_row($tulos);
				date_default_timezone_set('Europe/Helsinki');
				$pvm = date_create($rivi[2]);
				
				echo "<h1>$rivi[0]</h1>";
				echo "<p>$rivi[1] Tehtävien lukumäärä: $rivi[3].<br /><span class='de-em'>Tekijä: $rivi[4] $rivi[5]<br />Luotu: ";
				echo date_format($pvm, 'd.m.Y');
				echo "</span></p>";
				
				$kysely = "SELECT nro, tyyppi, kuvaus FROM htsysteemi.sisaltyy_listaan AS sl, htsysteemi.tehtava AS th WHERE sl.tl_nimi = 'Perushakuja 1' AND sl.teht_id = th.teht_id;";
				$tulos = pg_query($kysely);
				
				if (!$tulos)
				{
					echo "Virhe kyselyssä.\n";
					exit;
				}
				
				echo "<table><tr>";
				echo "<th>nro</th><th>tyyppi</th><th>tehtävä</th></tr>";
				while ($rivi = pg_fetch_row($tulos))
				{
					echo "<td>$rivi[0]</td><td>$rivi[1]</td><td>$rivi[2]</td></tr>";
				}
				echo "</table>";
				
				pg_close($yhteys);
?>
			<button type="button"> Suorita tehtävälista </button>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Copyleft elikkäs right</p>
		</footer>

	</div>


</body>