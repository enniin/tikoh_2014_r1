<!DOCTYPE HTML> 
<html lang="fi">

<head>
  <meta charset = "UTF-8" />
  <title>TikoHT - Kirjaudu sisään</title>

  <link rel="stylesheet" type="text/css" href="../css/basestyle.css" media="screen">
  <link rel="stylesheet" type="text/css" href="../css/printstyle.css" media="print">
  
</head>

<body>
	<div id="enter">

		<header>
			<h1>Kirjaudu järjestelmään</h1>
		</header>

		<!-- - - - Tagin <article> sisään sivun varsinainen HTML-sisältö. - - - -->
		
		<article>
		
		<?php
			if(isset($_GET["status"]))
			{
				echo '<p class="alert">Käyttäjänimi tai salasana väärin!</p>';
			}
		?>
			<form action="kirjautuminen.php" method="post">
			<table>
				<tr>
					<td><label for="kayt_tunnus">Käyttäjätunnus:</label></td>
            	<td><input type="text" name="kayt_tunnus" id="kayt_tunnus"></td>
            </tr>
            <tr>
            	<td><label for="salasana">Salasana:</label></td>
            	<td><input type="password" name="salasana" id="salasana"></td>
            </tr>
            <tr>
            	<td><input type="submit" value="Kirjaudu sisään"></td>
            </tr>
            </table>
</form>
		
		</article>

		<footer role="contentinfo">
			<p>&copy; Kähkönen, Saaristo, Seppä, TiKO 2014</p>
		</footer>

	</div>


</body>
</html>
