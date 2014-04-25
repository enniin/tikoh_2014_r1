<?php
include '../kirjautuminen/tarkistus.php';
tarkasta_rooli();
?>
<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Yleiset raportit</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>Omat raportit</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php
				// Siqnout-palikka:
				include '../listojen_selausta/ulospalikka.php';
				
				// Luodaan yhteys:
				include '../db_connct.php';
				$yhteys = luo_yhteys();
				pg_query("SET search_path TO htsysteemi");
				
				
				$rooli = $_SESSION['rooli'];
				
				if ($rooli == 'opiskelija')
				{
					// Opiskelijan omia sessioita:
					echo '<h1>Omat suorituksesi</h1>';
					
					echo '<p>Suorittamiesi sessioiden tiedot:</p>';
					include 'oma_opiskelija_ses.php';
					
					echo '<br /><p>Yleiset tilastotietosi tehtävätyypeittäin jaoteltuna: ratkaisuprosentti tehtävittäin, keskimäärin yrityksiä onnistuneiden tehtävien osalta, sekä tehtävien keskimääräinen ratkaisuaika. Mikä tehtävätyyppi kaipaa eniten harjoitusta?</p>';
					include 'oma_opiskelija_agg.php';
				}
				
				if ($rooli == 'opettaja')
				{
					// Opiskelijan omia sessioita:
					echo '<h1>Omat tehtävälistasi</h1>';
					
					echo '<p>Laatimiisi listoihin liittyvät sessiot:</p>';
					include 'oma_ope_ses.php';
					
					echo '<br /><p>Käyttäjät, jotka ovat suorittaneet listojasi ja heidän onnistumistilastonsa: ratkaisuprosentti tehtävittäin, keskimäärin yrityksiä onnistuneiden tehtävien osalta, sekä tehtävien keskimääräinen ratkaisuaika.</p>';
					include 'oma_ope_agg.php';
				}
				
				
				echo '<p><br />';
				echo '<a class="napp" href="../listojen_selausta/tehtava_listat.php"> Takaisin listaukseen </a></p>';
			
			pg_close($yhteys);
			?>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>