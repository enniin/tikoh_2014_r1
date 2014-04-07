<?php
	  echo '<div>';
				
		$vastaus = pg_fetch_result($vanha_vast, 0, 1);
		echo '<label for="esimerkkivastaus2">1. Vastaus</label>';
		echo '<textarea name="esimerkkivastaus" id="esimerkkivastaus" maxlength="1000" required>'.$vastaus.'</textarea>';
		$_SESSION['v_vastaus1'] = $vastaus;

		$selitys = pg_fetch_result($vanha_vast, 0, 2);
		echo '<label for="selitys">1. Selitys</label>';
		echo '<textarea name="selitys" id="selitys" maxlength="1000">'.$selitys.'</textarea>';

		echo '</div>';
				
		echo '<div>';
					
		$vastaus_lkm = pg_num_rows($vanha_vast);
		$_SESSION['v_vastaus2'] = '0';
					
		echo '<label for="esimerkkivastaus2">2. Vastaus</label>';

		if ($vastaus_lkm > 1) {
			$vastaus = pg_fetch_result($vanha_vast, 1, 1);
			$_SESSION['v_vastaus2'] = $vastaus;
			echo '<textarea name="esimerkkivastaus2" id="esimerkkivastaus2" maxlength="1000">'.$vastaus.'</textarea>';
						
			$selitys = pg_fetch_result($vanha_vast, 1, 2);
			echo '<label for="selitys">2. Selitys</label>';
			echo '<textarea name="selitys2" id="selitys2" maxlength="1000">'.$selitys.'</textarea>';
		} else {
			echo '<textarea name="esimerkkivastaus2" id="esimerkkivastaus2" maxlength="1000"></textarea>';
			echo '<label for="selitys">2. Selitys</label>';
			echo '<textarea name="selitys2" id="selitys2" maxlength="1000"></textarea>';
		}
				
		echo '</div>';
				
  	echo '<div>';
					
		$_SESSION['v_vastaus3'] = '0';

		echo '<label for="esimerkkivastaus2">3. Vastaus</label>';

		if ($vastaus_lkm > 2) {
			$vastaus = pg_fetch_result($vanha_vast, 2, 1);
			$_SESSION['v_vastaus3'] = $vastaus;
			echo '<textarea name="esimerkkivastaus3" id="esimerkkivastaus3" maxlength="1000">'.$vastaus.'</textarea>';
						
			$selitys = pg_fetch_result($vanha_vast, 2, 2);
			echo '<label for="selitys">3. Selitys</label>';
			echo '<textarea name="selitys3" id="selitys3" maxlength="1000">'.$selitys.'</textarea>';
  	} else {
			echo '<textarea name="esimerkkivastaus3" id="esimerkkivastaus3" maxlength="1000"></textarea>';
			echo '<label for="selitys">3. Selitys</label>';
			echo '<textarea name="selitys3" id="selitys3" maxlength="1000"></textarea>';
		}
	echo '</div>';
?>
