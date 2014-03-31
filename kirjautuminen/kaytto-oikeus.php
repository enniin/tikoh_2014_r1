<?php

// Ei näytetä enempää, jos kirjautuminen ei ole voimassa:
if (!tarkasta_rooli())
{
	header('Location: ../kirjautuminen/kirjautumisvirhe.php');
}
			
?>