<?php

	// Haetaan tehtävälistan perustietoja:
	$kysely = "SELECT tl_nimi, tl_kuvaus, tl_luontipvm, (select count(teht_id) from htsysteemi.sisaltyy_listaan where tl_nimi = '$listanimi') AS teht_lkm, etunimi, sukunimi FROM htsysteemi.t_lista AS tl INNER JOIN htsysteemi.kayttaja AS ka ON tl.kayt_id = ka.kayt_id WHERE tl_nimi = '$listanimi';";
	$tulos = pg_query($kysely);
				
	if (!$tulos)
	{
		echo "Virhe kyselyssä.\n";
		exit;
	}
	
	$rivi = pg_fetch_row($tulos);
	date_default_timezone_set('Europe/Helsinki');
	$pvm = date_create($rivi[2]);
	
	echo "<h1>$rivi[0]</h1>";
	echo "<p>$rivi[1] Tehtävien lukumäärä: $rivi[3].<br />Tekijä: $rivi[4] $rivi[5]<br />Luotu: ";
	echo date_format($pvm, 'd.m.Y');
	echo "</p>";
			
?>