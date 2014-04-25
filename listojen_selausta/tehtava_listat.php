<?php
include '../kirjautuminen/tarkistus.php';
tarkasta_rooli();
$_SESSION["tlnimi"] = '';
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
			<?php
				include 'ulospalikka.php'; 
				
				if ($_SESSION["rooli"] == 'opiskelija')
					include 'opisk_ohje.php';
				else
					include 'opett_ohje.php';
			?>
			
			<h1>Valitse tehtäväsarja:</h1>
			<p>
			<?php
				// Taulukko
				include 'tl_listaus.php';
				
				// Linkkirivi:
				echo '<p><br />';
				
				// Linkit tsekkauksineen
				if ($_SESSION["rooli"] == 'opettaja' || $_SESSION["rooli"] == 'yllapitaja')
					include 'opett_linkit.php';
				
				if ($_SESSION["rooli"] == 'yllapitaja')
					echo '<a class="napp" href="../raportointi/raportti.php"> Yleiset raportit </a>';
				else
					echo '<a class="napp" href="../raportointi/oma_raportti.php"> Omat raportit </a>';
				echo '</p>';
			
			?>
			</p>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>