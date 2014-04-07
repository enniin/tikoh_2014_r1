<?php
	$kuvaus = pg_fetch_result($vanha_teht, 0, 1);
	echo '<textarea name="kuvaus" maxlength="1000" required>'.$kuvaus.'</textarea>';
?>
