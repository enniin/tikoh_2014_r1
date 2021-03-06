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
			$yhteys = luo_yhteys();

			pg_query("set search_path to htsysteemi");

			$ses_id = $_SESSION["ses_id"];
			$tl_nimi = $_SESSION["tlnimi"];
			$teht_nro = $_SESSION["teht_nro"];
			
			//Kannan rakenne muotoilluksi merkkijonoksi.
			$taulut_tulos = pg_query("select table_name from information_schema.tables where table_schema = 'esimerkkikanta'");
			pg_query("set search_path to esimerkkikanta");

			$metadata = '';
			while($taulut_rivi = pg_fetch_row($taulut_tulos)) {
			 $taulun_nimi = $taulut_rivi[0];
			 $metadata .= "$taulun_nimi(";
			 $taulu_tiedot = pg_meta_data($yhteys, 'esimerkkikanta.'.$taulun_nimi);
			 foreach ($taulu_tiedot as $sarake=>$tiedot) {
			  $metadata .= "$sarake, ";
			 }
			 $metadata = substr_replace($metadata, ')', (strlen($metadata)-2));
			 $metadata .= "<br>";
			}

			//Selvitetään ollaanko jo tehty listan viimeinen tehtävä.
			pg_query("set search_path to htsysteemi");
			$listan_viimeinen_t_tulos = pg_query("select max(nro) from sisaltyy_listaan where tl_nimi = '$tl_nimi'");
			$listan_viimeinen_t_rivi = pg_fetch_row($listan_viimeinen_t_tulos);
			$listan_viimeinen_t = $listan_viimeinen_t_rivi[0];
			if($teht_nro > $listan_viimeinen_t) {
			 //Näytetään session yhteenveto.
			 $yhteenveto_tulos = pg_query("select alku, loppu, kesto, ratkaistu from suoritukset where s_id = $ses_id");
             $yhteenveto_rivi = pg_fetch_row($yhteenveto_tulos);
			 date_default_timezone_set('Europe/Helsinki');
			 
			 echo "<p><table><tr><th>aloitusaika</th><th>lopetusaika</th><th>kesto</th><th>teht&auml;vi&auml; oikein</th></tr>";
			 $alku = date_format(date_create($yhteenveto_rivi[0]), 'H:i:s');
			 $loppu = date_format(date_create($yhteenveto_rivi[1]), 'H:i:s');
			 $kesto = date_format(date_create($yhteenveto_rivi[2]), 'H:i:s');
			 echo "<tr><td>$alku</td><td>$loppu</td><td>$kesto</td><td>$yhteenveto_rivi[3]</td></tr></table></p>";
			 echo("<a class='napp' href='../listojen_selausta/tehtava_listat.php'>Takaisin listaukseen </a></p>");
			}

			//Jos tehtäviä on vielä jäljellä, haetaan tehtävän tiedot ja tulostetaan lomake.
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
			 echo("<h1>Teht&auml;v&auml; $teht_nro</h1><pre><code>$metadata</code></pre><p>$teht_kuvaus_rivi[0]<p><div id='vastausAlue'>
<div><form action='tehtavan_tarkistus.php' method='post'>
<label for='vastaus'>Vastaus:</label><br><textarea rows='5' cols='30' name='vastaus' id='vastaus'></textarea><br>
<input type='submit' value='OK'></div>
<input type='hidden' name='alk_aika' value='$alk_aika'>
</div></form>");
			}
			pg_close();
			?>

		</article>
		<footer role="contentinfo">
			<p>&copy; K&auml;hk&ouml;nen, Saaristo, Sepp&auml;, TiKO 2014</p>
		</footer>
	</div>
</body>
</html>
