<?php
	$hakulause = "SELECT teht_id, tyyppi, kuvaus, luontipvm FROM htsysteemi.tehtava ORDER BY teht_id";
	$tulos = pg_query($hakulause);
	
	if (!$tulos) {
		echo "Tehtäviä ei löytynyt.";
		exit;
	}
		
	echo "<table>";
	echo "<tr>";
	echo"<th>teht_id</th>";
	echo"<th>tyyppi</th>";
	echo"<th>kuvaus</th>";
	echo"<th>luonti_pvm</th>";
	echo "</tr>";

	while ($rivi = pg_fetch_row($tulos)) {
		echo "<tr>";
		echo "<td>$rivi[0]</td>";
		echo "<td>$rivi[1]</td>";
		echo "<td>".substr($rivi[2], 0, 20)."</td>";
		echo "<td>$rivi[3]</td>";

		echo '<td><input type ="checkbox" value = "'.$rivi[0].'" name ="tehtava[]" />';
		echo "</tr>";
	}

	 echo "</table>";
?>
