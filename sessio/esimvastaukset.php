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

		<!-- - - - Tagin <article> sisÃƒÂ¤ÃƒÂ¤n sivun varsinainen HTML-sisÃƒÂ¤ltÃƒÂ¶. - - - -->
		<article>
			<?php	 
			include '../listojen_selausta/ulospalikka.php';
			$yhteys = luo_yhteys();

			$teht_id = $_SESSION["teht_id"];
			pg_query("set search_path to htsysteemi");
			$ratk_yritykset_tulos = pg_query("select esim_vast, selitys from esimerkkivastaus where teht_id=$teht_id");
			while($ratk_yritys_rivi = pg_fetch_row($ratk_yritykset_tulos)) {
             echo("<table><tr><td>$ratk_yritys_rivi[0]</td><td>$ratk_yritys_rivi[1]</td></tr>");
            }
             
            echo("</table><p><a href='tehtava.php'>Jatka</a></p>");
             
            pg_close();
             
            ?>

		</article>
		<footer role="contentinfo">
			<p>&copy; K&auml;hk&ouml;nen, Saaristo, Sepp&auml;, TiKO 2014</p>
		</footer>
	</div>
</body>
</html>
