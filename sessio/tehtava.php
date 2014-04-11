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

			pg_query("set search_path to htsysteemi");

			$ses_id = $_SESSION["ses_id"];
			$tl_nimi = $_SESSION["tl_nimi"];
			$teht_nro = $_SESSION["teht_nro"];

			if($_SESSION["yritys_nro"] > 0) {
			 echo("<p>VÃƒÂ¤ÃƒÂ¤rin! YritÃƒÂ¤ uudelleen!</p>");
			}

			$listan_viimeinen_t_tulos = pg_query("select max(nro) from sisaltyy_listaan where tl_nimi = '$tl_nimi'");
			$listan_viimeinen_t_rivi = pg_fetch_row($listan_viimeinen_t_tulos);
			$listan_viimeinen_t = $listan_viimeinen_t_rivi[0];

			if($teht_nro > $listan_viimeinen_t) {
			 echo("<p>TÃƒÂ¤ssÃƒÂ¤ voidaan sitten nÃƒÂ¤yttÃƒÂ¤ÃƒÂ¤ session yhteenveto.<br><a class='napp' href='../listojen_selausta/tehtava_listat.php'>Takaisin listaukseen </a></p>");
			}

			else {
			 $teht_id_tulos = pg_query("select teht_id from sisaltyy_listaan where tl_nimi = '$tl_nimi' and nro = '$teht_nro'");
			 $teht_id_rivi = pg_fetch_row($teht_id_tulos);
			 $teht_id = $teht_id_rivi[0];
			 $_SESSION["teht_id"] = $teht_id;

			 $alk_aika_tulos = pg_query("select current_time");
			 $alk_aika_rivi = pg_fetch_row($alk_aika_tulos);
			 $alk_aika = $alk_aika_rivi[0];

			 $teht_kuvaus_tulos = pg_query("select kuvaus from tehtava where teht_id = '$teht_id'");
			 $teht_kuvaus_rivi = pg_fetch_row($teht_kuvaus_tulos);
			 echo("<h1>TehtÃƒÂ¤vÃƒÂ¤ $teht_nro</h1><p>$teht_kuvaus_rivi[0]<p><form action='tehtavan_tarkistus.php' method='post'>
<label for='vastaus'>Vastaus:</label><textarea rows='5' cols='30' name='vastaus' id='vastaus'></textarea><br>
<input type='submit' value='OK'>
<input type='hidden' name='alk_aika' value='$alk_aika'>
</form>");
			}
			pg_close();
			?>

		</article>
	</div>
</body>
</html>
