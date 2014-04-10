<?php
	include '../kirjautuminen/tarkistus.php';

	// Tarkistaa, että käyttäjällä on ainakin opettajan oikeudet.
	// Muussa tapauksessa virheilmoitus.
	if (tarkasta_rooli() == 'opiskelija') {
		echo "Sinulla ei ole valtuuksia toivottuun toimenpiteeseen.";
		echo "<a href = '../listojen_selausta/tehtava_listat.php'>Palaa etusivulle</a>";
		exit();
	}
?>
