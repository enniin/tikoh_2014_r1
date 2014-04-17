<?php
	include 'opettajaTarkistus.php';
?>

<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Luo uusi tehtävä</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  <link rel="stylesheet" type="text/css" href="../css/formstyle.css">
  
</head>

<body>
	<div id="main">

		<header>
			<h1>Luo uusi tehtävä</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
			<?php
				// Siqnout-palikka:
				include "../listojen_selausta/ulospalikka.php";
			?>
		
			<form action="lisaaTehtava.php" method="post">

			<fieldset id = "tyyppi">
				<legend>Tyyppi*</legend>
				<div>
					<p><label for="t1"><input type="radio" name="tyyppi" id="t1" value="select" required>SELECT</label></p>
					<p><label for="t2"><input type="radio" name="tyyppi" id="t2" value="insert">INSERT</label></p>
				</div>
			
				<div>
					<p><label for="t3"><input type="radio" name="tyyppi" id="t3" value="delete">DELETE</label></p>
					<p><label for="t4"><input type="radio" name="tyyppi" id="t4" value="update">UPDATE</label></p>
				</div>
			</fieldset>

			<fieldset>
				<legend>Kuvaus*</legend>
				<textarea name="kuvaus" maxlength="1000" required></textarea>
			</fieldset>

			<fieldset>
				<legend>Esimerkkivastaus (väh. 1)</legend>

				<div  id = "vastausAlue">

				<div>
					<label for="esimerkkivastaus">1. Vastaus*</label>
					<textarea name="esimerkkivastaus" id="esimerkkivastaus" maxlength="1000" required></textarea>

					<label for="selitys">1. Selitys</label>
					<textarea name="selitys" id="selitys" maxlength="1000"></textarea>
				</div>
				
				<div>
					<label for="esimerkkivastaus2">2. Vastaus</label>
					<textarea name="esimerkkivastaus2" id="esimerkkivastaus2" maxlength="1000"></textarea>

					<label for="selitys">2. Selitys</label>
					<textarea name="selitys2" id="selitys2" maxlength="1000"></textarea>
				</div>
				
				<div>
					<label for="esimerkkivastaus3">3. Vastaus</label>
					<textarea name="esimerkkivastaus3" id="esimerkkivastaus3" maxlength="1000"></textarea>

					<label for="selitys3">3. Selitys</label>
					<textarea name="selitys3" id="selitys3" maxlength="1000"></textarea>
				</div>

				</div>
			
			<p>Tyhjäksi jätettyä ylimääräistä vastauskenttää ei talleteta.</p>
		
		</fieldset>
		</form>
		<p><a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>

		<input type="hidden" name="tallenna" value="Jatka" />
		<input type="submit" name="lahetaLomake" value="Tallenna" />
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>

</body>
</html>
