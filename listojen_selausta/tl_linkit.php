<?php

	// Peruslinkit:
	echo '<p><br />';
	echo '<a class="napp" href="tehtava_listat.php"> Takaisin listaukseen </a>';
	echo '<a class="napp" href="../sessio/uusi_sessio.php"> Suorita tehtäväsarja </a>';
				
	// Muokkausmahdollisuus tekijälle ja ylläpitäjälle:
	$kayttaja = $_SESSION["kirjautunut"];
	$onadmin = $_SESSION["rooli"] == 'yllapitaja';
				
	$tulos = pg_query("SELECT kayt_id FROM htsysteemi.t_lista WHERE tl_nimi = '$listanimi';");
	
	if (!$tulos)
		exit;
		
	$rivi = pg_fetch_row($tulos);
	if($kayttaja == $rivi[0] || $onadmin)
	{
		echo '<a class="napp"> Muokkaa sarjaa </a>';
	}
				
	echo '</p>';
			
?>