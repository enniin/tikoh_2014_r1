<?php

function tarkista_sulkeet($mjono) {
 //Onko sulkeita?
 if(substr_count($mjono, "(") > 0) {
  //Lopusta lähtien viimeinen avonainen sulje tähän.
  $viimeinen = strrpos($mjono, "(");
  //Alusta lähtien ensimmäinen avonainen sulje tähän.
  $i = strpos($mjono, "(");
  //Silmukassa käydään läpi jokainen avonainen sulje.
  while($i <= $viimeinen && $i != false) {
   //Jos ei löydy jollekin sulkeelle paria, palautetaan false.
   if(strpos($mjono, ")", $i) === false) {
    return false;
   }
   //Etsitään seuraava avonainen sulje siitä kohtaa lähtien, missä ollaan.
   $i = strpos($mjono, "(", ($i+1));
  }
  //Jos kaikki on sujunut ongelmitta, palautetaan true.
  return true;
 }
 //Tai jos sulkeita ei ollut ollenkaan.
 else {
  return true;
 }
}

function tarkista_puolipiste($mjono) {
 if(substr($mjono, -1) == ";")
  return true;
 else
  return false;
}
?>
