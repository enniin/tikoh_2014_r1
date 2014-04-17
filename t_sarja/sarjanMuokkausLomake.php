<?php
	include '../tehtavan_lisays/opettajaTarkistus.php';
?>

<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Muokkaa tehtäväsarjaa</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>Muokkaa tehtäväsarjaa</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<?php
			include '../db_connct.php';
			$yhteys = luo_yhteys();
			$nimi = $_SESSION['tlnimi'];
			$vanha_kuvaus_haku = "SELECT tl_kuvaus FROM htsysteemi.t_lista WHERE tl_nimi = '$nimi'";

			$kuvaus = pg_fetch_result( pg_query($vanha_kuvaus_haku), 0, 0);

		?>

		<article>
			<?php
				// Siqnout-palikka:
				include "../listojen_selausta/ulospalikka.php";
			?>

			<form action="sarjanPaivitys.php" method="post">

			<fieldset id = "Nimi">
				<legend>Nimi*</legend>
				<textarea name="nimi" maxlength="20" disabled><?php echo "$nimi"; ?></textarea>
			</fieldset>

			<fieldset>
				<legend>Kuvaus</legend>
				<textarea name="kuvaus" maxlength="1000" ><?php echo "$kuvaus";?></textarea>
			</fieldset>

			<?php pg_close($yhteys); ?>

		<input type="hidden" name="tallenna" value="Jatka" />
		<input type="submit" name="lahetaLomake" value="Päivitä kuvaus ja jatka tehtäväosioon" />
		</form>

		<p><a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>

</body>
</html>
