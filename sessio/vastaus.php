<?php
include '../kirjautuminen/tarkistus.php';
include '../db_connct.php';
tarkasta_rooli();
?>

<!DOCTYPE HTML>
<html lang="fi">

<head>
<meta charset="UTF-8" />
<title>TikoHT - SQL-harjoituksia kaikille!</title>

<link rel="stylesheet" type="text/css" href="../css/basestyle.css"
	media="screen">
<link rel="stylesheet" type="text/css" href="../css/printstyle.css"
	media="print">
<link rel="stylesheet" type="text/css" href="../css/formstyle.css">
</head>

<body>
	<div id="main">

		<header>
			<h1>SQL-harjoituksia</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		<article>
			<?php	 
			include '../listojen_selausta/ulospalikka.php';

			if($_SESSION["oikein"] == "true") {
			 $kayttajan_vastaus = $_SESSION["kayttajan_vastaus"];
			 echo("<p>Oikea vastaus!</p><p>Kyselyn tulos:$kayttajan_vastaus</p>");
			}

			else {
			 //Virheilmoitukset kannasta.
			 if(array_key_exists("virheilm", $_SESSION)) {
			  $virheilm = $_SESSION["virheilm"];
			  echo("<p>Tietokanta palautti virheilmoituksen:<br>$virheilm</p>");
			 }

			 //Käyttäjän vastaus ja oikea vastaus.
			 else {
			  $kayttajan_vastaus = $_SESSION["kayttajan_vastaus"];
			  $oikea_vastaus = $_SESSION["oikea_vastaus"];
			  echo("<p>Kyselyss&auml; looginen virhe!<br>Oman kyselysi tulos:<br>$kayttajan_vastaus<br>Oikean vastauksen antama tulos:<br>$oikea_vastaus</p>");
			 }
			 //Annetaan mahdollisuus nähdä esimerkkivastaukset.
			 if(array_key_exists("nayta_ratk", $_SESSION) && $_SESSION["nayta_ratk"] == true) {
             $_SESSION["nayta_ratk"] = false;
             echo("<p><a href='esimvastaukset.php'>Katso oikea vastaus</a></p>");
            }
			}



			echo("<p><a href='tehtava.php'>Jatka</a></p>");
			//print_r($_SESSION);

			?>

		</article>
	</div>
</body>
</html>
