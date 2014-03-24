<?php
include 'tarkistus.php';
if(!tarkasta_rooli())
 echo "Pääsy kielletty";

else
 echo "Salaista";

if(tarkasta_rooli() == "opettaja")
 echo "Tämä näkyy vain opettajille";

if(tarkasta_rooli() == "yllapitaja")
 echo "Ylläpitäjän juttuja";
?>

<form action="ulos.php" method="post">
            <input type="submit" value="Kirjaudu ulos">
</form>

