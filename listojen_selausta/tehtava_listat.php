<?php
include '../kirjautuminen/tarkistus.php';
include '../kirjautuminen/kaytto-oikeus.php';
?>
<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - SQL-harjoituksia kaikille!</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>SQL-harjoituksia</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php	include 'ulospalikka.php'; ?>
			
			<h1>Tervetuloa harjoittelemaan</h1>
			<p>Ohjeita ohjeita ohjeita löpinää löpinää!</p>
			
			<h1>Valitse tehtäväsarja:</h1>
			<p>
			<?php
				// Luodaan yhteys:
				include '../db_connct.php';
				$yhteys = luo_yhteys();
				
				// Haetaan listat:
				$kysely = "SELECT tl_nimi, tl_kuvaus, tl_luontipvm FROM htsysteemi.t_lista ORDER BY tl_luontipvm;";
				$tulos = pg_query($kysely);
				
				if (!$tulos)
				{
					echo "Virhe kyselyssä.\n";
					exit;
				}
				
				// Taulun tulostus:
				echo "<table><tr>";
				echo "<th>sarja</th><th>kuvaus</th><th>pvm</th></tr>";
				while ($rivi = pg_fetch_row($tulos))
				{
					$nimi = $rivi[0];
					//echo $nimi;
					echo '<tr><td><a href="listan_tiedot.php?listanimi=', $nimi, '">';
					echo $nimi, '</a></td>';
					echo "<td>$rivi[1]</td><td>$rivi[2]</td></tr>";
				}
				echo "</table>";
				
			
			pg_close($yhteys);
			?>
			</p>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>