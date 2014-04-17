<?php
	include 'opettajaTarkistus.php';
?>

<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Muokkaa tehtävää</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>Muokkaa tehtävää</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php
				include '../db_connct.php';
				$yhteys = luo_yhteys();

				// Siqnout-palikka:
				include "../listojen_selausta/ulospalikka.php";

				$teht_id = $_GET['tId'];
				$_SESSION['tehtava_id'] = $teht_id;
			?>

			<form action="paivitaTehtava.php" method="post">

			<?php
				// Haetaan tehtävän vanhat tiedot kannasta.
				$vanha_teht = pg_query("SELECT tyyppi, kuvaus FROM htsysteemi.tehtava WHERE teht_id=$teht_id");
				$vanha_vast = pg_query("SELECT * FROM htsysteemi.esimerkkivastaus WHERE teht_id=$teht_id");
			?>

			<fieldset id = "tyyppi">
				<legend>Tyyppi*</legend>
				<div>
					<?php include 'vanha_tyyppi.php'; ?>
				</div>
			</fieldset>

			<fieldset>
				<legend>Kuvaus*</legend>
				<?php include 'vanha_kuvaus.php'; ?>
			</fieldset>

			<fieldset>
				<legend>Esimerkkivastaus (väh. 1)</legend>

				<div id = "vastausAlue">
					<?php
						include 'vanhat_vastaukset.php'; 
						pg_close($yhteys);
					?>
				</div>
			
			<p>Tyhjäksi jätettyä ylimääräistä vastauskenttää ei talleteta.</p>
		
		</fieldset>

		<input type="hidden" name="tallenna" value="Jatka" />
		<input type="submit" name="tehtavanLisays" value="Tallenna" />
		</form>
		
		<p><a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>

</body>
</html>
