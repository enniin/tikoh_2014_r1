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
				
				$tlista = $_GET["tlista"];
				echo "<h1>R3 - Tehtävälistan tietoja tehtäväkohtaisesti</h1>";
				echo "<p>Tee raportti, joka näyttää testisarjan yhteenvetotiedot tehtäväkohtaisesti: tehtäväkuvaukset, onnistumisprosentit, keskimääräinen aika.</p>";
				
				echo "<h1>$tlista</h1>";
				include "rap_R3.php";
				
				echo '<p><br />';
				echo '<a class="napp" href="raportti.php"> Takaisin </a></p>';
				
			
			pg_close($yhteys);
			?>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>