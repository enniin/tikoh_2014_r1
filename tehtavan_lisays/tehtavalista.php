<?php
	include 'opettajaTarkistus.php';
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
			include "../db_connct.php";
			$yhteys = luo_yhteys();

			// Tehtävien järjestelypalkki
			include "jarjestyspalkki.php";
			
			// Tehtävälista
			include "tehtavat.php";

			echo '<a href = "lisaaTehtavaLomake.php">Lisää tehtävä?</a>';
			pg_close($yhteys);
		?>
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>

</body>
</html>
