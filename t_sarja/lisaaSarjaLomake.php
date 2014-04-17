<?php
	include '../tehtavan_lisays/opettajaTarkistus.php';
?>

<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Luo uusi tehtäväsarja</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>Luo uusi tehtäväsarja</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php
				// Siqnout-palikka:
				include "../listojen_selausta/ulospalikka.php";
			?>

			<form action="lisaaSarja.php" method="post">

			<fieldset id = "Nimi">
				<legend>Nimi*</legend>
				<textarea name="nimi" maxlength="20" required></textarea>
			</fieldset>

			<fieldset>
				<legend>Kuvaus</legend>
				<textarea name="kuvaus" maxlength="1000" ></textarea>
			</fieldset>

		<input type="hidden" name="tallenna" value="Jatka" />
		<input type="submit" name="lahetaLomake" value="Lisää tyhjä lomake ja jatka tehtävien lisäykseen" />
		</form>

		<p><a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>

</body>
</html>
