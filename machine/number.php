<?php
function numberToText($liczba) {
 
 $separator = ' ';
 $jednosci = array('', ' jeden', ' dwa', ' trzy', ' cztery', ' pięć', ' sześć', ' siedem', ' osiem', ' dziewięć');
 $nascie = array('', ' jedenaście', ' dwanaście', ' trzynaście', ' czternaście', ' piętnaście', ' szesnaście', ' siedemnaście', ' osiemnaście', ' dziewietnaście');
 $dziesiatki = array('', ' dziesieć', ' dwadzieścia', ' trzydzieści', ' czterdzieści', ' pięćdziesiąt', ' sześćdziesiąt', ' siedemdziesiąt', ' osiemdziesiąt', ' dziewięćdziesiąt');
 $setki  = array('', ' sto', ' dwieście', ' trzysta', ' czterysta', ' pięćset', ' sześćset', ' siedemset', ' osiemset', ' dziewięćset');
 $grupy = array(
 array('' ,'' ,''),
 array(' tysiąc' ,' tysiące' ,' tysięcy'),
 array(' milion' ,' miliony' ,' milionów'),
 array(' miliard',' miliardy',' miliardów'),
 array(' bilion' ,' biliony' ,' bilionów'),
 array(' biliard',' biliardy',' biliardów'),
 array(' trylion',' tryliony',' trylionów')
 );
  
 $wynik = ''; $znak = '';
 if ($liczba == 0)
 return 'zero';
 if ($liczba < 0) {
 $znak = 'minus';
 $liczba = -$liczba;
 }
 $g = 0;
 while ($liczba > 0) {
  
  
 $s = floor(($liczba % 1000)/100);
 $n = 0;
 $d = floor(($liczba % 100)/10);
 $j = floor($liczba % 10);
  
  
 if ($d == 1 && $j>0) {
 $n = $j;
 $d = $j = 0;
 }
  
 $k = 2;
 if ($j == 1 && $s+$d+$n == 0)
 $k = 0;
 if ($j == 2 || $j == 3 || $j == 4)
 $k = 1;
  
 if ($s+$d+$n+$j > 0)
 $wynik = $setki[$s].$dziesiatki[$d].$nascie[$n].$jednosci[$j].$grupy[$g][$k].$wynik;
  
 $g++;
 $liczba = floor($liczba/1000);
 }
 return trim($znak.$wynik);
  
 }