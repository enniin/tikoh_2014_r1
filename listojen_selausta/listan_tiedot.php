<?php
include '../kirjautuminen/tarkistus.php';
?>
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
			<h1>Tehtäväsarjan tiedot</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php
				// Siqnout-palikka:
				include 'ulospalikka.php';
				
				// Luodaan yhteys:
				include '../db_connct.php';
				$yhteys = luo_yhteys();
				
				$listanimi = $_GET["listanimi"];
				
				// Haetaan ja tulostetaan tehtävälistan tiedot:
				include 'tl_perustiedot.php';
				include 'tl_tehtiedot.php';
				
				// Linkkirivi:
				include 'tl_linkit.php';
			
			pg_close($yhteys);
			?>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>