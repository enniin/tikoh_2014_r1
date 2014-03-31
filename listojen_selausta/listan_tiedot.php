<?php include '../kirjautuminen/tarkistus.php';?>
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
				// Tarkastetaan ensin käyttöoikeus ja luodaan siqnout-palikka:
				include '../kirjautuminen/kaytto-oikeus.php';
				
				// Kaikki oli ok, luodaan yhteys ja haetaan tiedot:
				include '../db_connct.php';
				$yhteys = luo_yhteys();
				
				$listanimi = "Perushakuja 1";
				
				// Haetaan tehtävälistan perustietoja:
				$kysely = "SELECT tl_nimi, tl_kuvaus, tl_luontipvm, (select count(teht_id) from htsysteemi.sisaltyy_listaan where tl_nimi = '$listanimi') AS teht_lkm, etunimi, sukunimi FROM htsysteemi.t_lista AS tl INNER JOIN htsysteemi.kayttaja AS ka ON tl.kayt_id = ka.kayt_id WHERE tl_nimi = '$listanimi';";
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
				echo "<p>$rivi[1] Tehtävien lukumäärä: $rivi[3].<br />Tekijä: $rivi[4] $rivi[5]<br />Luotu: ";
				echo date_format($pvm, 'd.m.Y');
				echo "</p>";
				
				// Haetaan tietoja tehtävistä:
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
				
				echo '<button type="button"> Suorita tehtävälista </button>';
				
				$kayttaja = $_SESSION["kirjautunut"];
				
				// Jos kyseessä on listan luonut opettaja, sallitaan muokkaus:
				// (myös ylläpitäjän oikeus toteutetaan tähän)
				$tulos = pg_query("SELECT kayt_id FROM htsysteemi.t_lista WHERE tl_nimi = '$listanimi';");
				
				if (!$tulos)
				{
					echo "Virhe kyselyssä.\n";
					exit;
				}
		
				$rivi = pg_fetch_row($tulos);
				
				if($kayttaja == $rivi[0])
				{
					echo '<button type="button"> Muokkaa listaa </button>';
				}
			
			pg_close($yhteys);
			?>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>