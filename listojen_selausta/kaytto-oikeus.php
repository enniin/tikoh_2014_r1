<?php

// Ei näytetä enempää, jos kirjautuminen ei ole voimassa:
if (!tarkasta_rooli())
{
	echo 'Kirjautuminen vaaditaan!';
	echo '<a href="../kirjautuminen/kirjaudu.php"> Kirjaudu >></a>';
	exit;
}

// On kirjautunut, rakennetaan yläkulman palikka:
echo '<div id="signout">';
echo 'Käyttöoikeus: ', $_SESSION["rooli"];
echo '<br /><a href="../kirjautuminen/ulos.php">Kirjaudu ulos</a>';
echo '</div>';
				
?>