<?php
	$tyyppi = pg_fetch_result($vanha_teht, 0, 0);
	if ($tyyppi == 'select')
		echo '<p><label for="t1"><input type="radio" name="tyyppi" id="t1" value="select" required checked>SELECT</label></p>';
	else
		echo '<p><label for="t1"><input type="radio" name="tyyppi" id="t1" value="select" required>SELECT</label></p>';

	if ($tyyppi == 'insert')
		echo '<p><label for="t2"><input type="radio" name="tyyppi" id="t2" value="insert" checked>INSERT</label></p>';
	else
		echo '<p><label for="t2"><input type="radio" name="tyyppi" id="t2" value="insert">INSERT</label></p>';
				
	echo "</div>";
	echo "<div>";

	if ($tyyppi == 'delete')
		echo '<p><label for="t3"><input type="radio" name="tyyppi" id="t3" value="delete" checked>DELETE</label></p>';
	else
		echo '<p><label for="t3"><input type="radio" name="tyyppi" id="t3" value="delete">DELETE</label></p>';

	if ($tyyppi == 'update')
		echo '<p><label for="t4"><input type="radio" name="tyyppi" id="t4" value="update" checked>UPDATE</label></p>';
	else
		echo '<p><label for="t4"><input type="radio" name="tyyppi" id="t4" value="update">UPDATE</label></p>';
?>
