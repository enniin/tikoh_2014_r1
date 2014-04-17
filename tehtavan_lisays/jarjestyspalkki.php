<?php
	echo '<form action="tehtavalista.php" method="post">';
		echo '<p>Järjestä lista:</p>';
		echo '<label for="t1"><input type="radio" name="luokitus" id="t1" value="teht_id">teht_id</label>';
		echo '<label for="t2"><input type="radio" name="luokitus" id="t2" value="tyyppi">tyyppi</label>';
		echo '<label for="t3"><input type="radio" name="luokitus" id="t3" value="luontipvm">luontipvm</label>';

		echo '<input type="hidden" name="tallenna" value="Jatka" />';
  		echo '<input type="submit" name="tehtavanlisays" value="Järjestä" />';
  	echo '</form>';
?>
