<?php
	$hakulause = "SELECT teht_id, tyyppi, kuvaus, luontipvm FROM htsysteemi.tehtava ORDER BY teht_id";
	$tulos = pg_query($hakulause);
	$tlnimi = $_SESSION['tlnimi'];
	
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

		$teht_id = $rivi[0];
		$listassa = pg_num_rows( pg_query("SELECT teht_id FROM htsysteemi.sisaltyy_listaan WHERE tl_nimi = '$tlnimi' AND teht_id = '$teht_id'") );
		
		if ($listassa > 0)
			echo '<td><input type ="checkbox" value = "'.$rivi[0].'" name ="tehtava[]" checked /></td>';
		else
			echo '<td><input type ="checkbox" value = "'.$rivi[0].'" name ="tehtava[]" /></td>';
		
		echo "</tr>";
	}

	 echo "</table>";
?>
