<?php
	include '../tehtavan_lisays/opettajaTarkistus.php';
?>

<!DOCTYPE html>
<head>
	<meta charset="UTF-8" />
	<title>Tehtävälista</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">	

</head>
<body>
	<div id="main">

		<header>
			<h1>Tehtävälista</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
		<?php
			// Siqnout-palikka:
			include "../listojen_selausta/ulospalikka.php";
		?>


		<form action = "muutaSarjanTehtavat.php" method = "post">
		<?php
			include "../db_connct.php";
			$yhteys = luo_yhteys();
			
			// Tehtävälista
			include "ts_valitut_tehtavat.php";

			pg_close($yhteys);
		?>
			
			<input type = "submit" name ="button" value="Lisää / poista tehtävät" />
		</form>

		<p><a href = "../listojen_selausta/tehtava_listat.php" class = "napp">Palaa etusivulle</a></p>
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>

</body>
</html>
