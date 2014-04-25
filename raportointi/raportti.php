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
			<h1>Yleisiä järjestelmäraportteja</h1>
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
				
				// Session tietoja (pakollinen):
				echo '<h1>R1 - Session tietoja</h1>';
				echo '<p>Tee raportti, joka näyttää yksittäisen session tiedot: Käyttäjä ja onnistuneiden tehtävien lukumäärä.</p>';
				include 'rap_R1.php';
				
				// Tehtävälistan tietoja (pakollinen):
				echo '<h1>R2 & R3 - Tehtävälistan tietoja</h1>';
				echo '<p>Tee raportti, joka näyttää tiettyyn tehtävälistaan liittyvien sessioiden yhteenvetotiedot: session nopein, hitain ja keskimääräinen suoritusaika.</p>';
				echo '<p>Raportin R3 saat esiin tehtävälistan nimeä klikkaamalla.</p>';
				include 'rap_R2.php';
				
				// Tehtävien vaikeus (valinnainen):
				echo '<h1>R4 - Tehtävien vaikeus</h1>';
				echo '<p>Tee raportti, joka listaa kaikki tehtävät ’vaikeusjärjestyksessä’, eli ensin tulee tehtävä, johon on käytetty keskimäärin eniten aikaa. Liitä tehtäviin tieto siitä, kuinka monta yritystä niihin on keskimäärin tarvittu (vain onnistuneet) sekä prosenttiosuus siitä, kuinka usein tehtävä jäi kokonaan ratkaisematta.</p>';
				include 'rap_R4.php';
				
				// Kyselytyyppien vaikeus (valinnainen):
				echo '<h1>R5 - Kyselytyyppien vaikeus</h1>';
				echo '<p>Tee raportti, joka ryhmittelee kyselyt tyypeittäin (Select, Insert jne.) ja liitä kyselytyyppeihin yritysten keskimääräinen lukumäärä sekä keskimäärin käytetty aika.</p>';
				include 'rap_R5.php';
				
				// Op vertailu (valinnainen):
				echo '<h1>R6 - Opiskelijoiden vertailu</h1>';
				echo '<p>Vertaile opiskelijoiden onnistumista tehtävissä pääaineittain. Perustele, kuinka mittaat onnistumista.</p>';
				echo '<p>Mihin vertailu perustuu: <ul>
	<li>Sessioiden määrä kertoo aktiivisuudesta</li>
	<li>Onnistumisprosentti yleisestä osaamisesta</li>
	<li>Yrityskertojen keskiarvo pätevyydestä vähän tarkemmin</li>
	<li>Keskimääräinen aika tehtävää kohden sujuvuudesta ja sisäistämisestä</li>
	</ul></p>';
				include 'rap_R6.php';
				
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