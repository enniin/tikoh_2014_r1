<?php

echo '<div id="signout">';
echo 'Käyttöoikeus: ', $_SESSION["rooli"];
echo '<br /><a href="../kirjautuminen/ulos.php">Kirjaudu ulos</a>';
echo '</div>';

?>