<?php

$vastaus = "select (dlkfjgj testi) (jgadlkfgj) ";

//Tässä on joku vika.
function tarkista_sulkeet($mjono) {
 //Onko sulkeita?
 if(substr_count($mjono, "(") > 0) {
  //Lopusta lähtien viimeinen avonainen sulje tähän.
  $viimeinen = strrpos($mjono, "(");
  //Alusta lähtien ensimmäinen avonainen sulje tähän.
  $i = strpos($mjono, "(");
  //Silmukassa käydään läpi jokainen avonainen sulje.
  while($i <= $viimeinen) {
   echo("$i $viimeinen<br>");
   //Jos ei löydy jollekin sulkeelle paria, funktion pitäisi palauttaa false.
   if(strpos($mjono, ")", $i) === false) {
    return false;
   }
   //Etsitään seuraava avonainen sulje siitä kohtaa lähtien, missä ollaan.
   $i = strpos($mjono, "(", $i);
  }
  //Jos kaikki on sujunut ongelmitta, palautetaan true.
  return true;
 }
 //Tai jos sulkeita ei ollut ollenkaan.
 else {
  return true;
 }
}

if(tarkista_sulkeet($vastaus) == false)
 echo("false");
else
 echo("true");


?>
