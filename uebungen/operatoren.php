<?php
$z1 = 4;
$z2 = 8;
$z3 = '25,00 Euro';
$s1 = 'Hello';
$s2 = "World";

// Zeichenkettenverknüpfungsoperator (punkt)
echo $s1 . ' ' . $s2 . '<br>';

// Rechenoperatoren
echo ($z1 + $z2) . '<br>';
echo ($z1 + intval($z3)) . '<br>';
echo ($z1 - $z2) . '<br>';
echo ($z1 * $z2) . '<br>';
echo ($z1 / $z2) . '<br>';
echo ($z1 ** $z2) . ' Potenzierung<br>';
echo ($z1 % $z2) . ' Modulo<br>';

// Vergleichsoperatoren
echo ($z1 == $z2) . ' Gleich (nur Wert)<br>';
echo ($z1 === $z2) . ' Identisch (Wert und Datentyp)<br>';
echo ($z1 != $z2) . ' Ungleich (anderer Wert)<br>';
echo ($z1 !== $z2) . ' Unidentisch (anderer Wert oder Datentyp)<br>';

echo ($z1 < $z2) . ' kleiner als<br>';
echo ($z1 > $z2) . ' größer als<br>';
echo ($z1 <= $z2) . ' kleiner oder gleich (höchstens)<br>';
echo ($z1 >= $z2) . ' größer oder gleich (mindestens)<br>';

echo ($z1 <=> $z2) . ' Spaceship oder Raumschiff (-1: z2 > z1; 0: z1 == z2; +1: z1 > z2)<br>';

// Bitoperatoren
echo decbin($z1) . " ($z1 als Binärzahl)<br>";
echo decbin($z2) . ' (' . $z2 . 'als Binärzahl)<br>';

echo decbin($z1 & $z2) . " Bitweises UND<br>";
echo decbin($z1 | $z2) . " Bitweises ODER<br>";
echo decbin($z1 ^ $z2) . " Bitweises exklusives ODER<br>";

/*
4   0000 0100
12  0000 1100

&   0000 0100   -> 4
|   0000 1100   -> 12
^   0000 1000   -> 8
*/

echo decbin(~$z1) . " Invertierung der Bits<br>";
echo ~$z1 . " Invertierung der Bits<br>";
echo decbin(-5) . "<br>";

echo decbin( $z1 >> 1) . " Rechtsschieben um 1 Stellen (identisch mit 4/2)<br>";
echo decbin( $z1 << 1) . " Linkssschieben um 1 Stellen (identisch mit 4*2)<br>";

// Zuweisungsoperator
$z4 = 12;

// Inkrement & Dekrement
echo $z4++ . '<br>';    // post inkrement
echo ++$z4 . '<br>';    // pre inkrement
echo $z4-- . '<br>';    // post dekrement
echo --$z4 . '<br>';    // pre dekrement

// Berechnungszuweisungsoperatoren (+=, -=, *=, /=, **=, %=, &=, |=, ^=, <<=, >>=, .=)
$z1 += $z4; // $z1 = $z1 + $z4;
echo $z1 . '<br>';

// NULL-Koaleszenz-Operator (prüft ob die links stehende variable null ist und gibt im true-Fall den rechts stehenden Wert zurück)
$n1 = null;
$n2 = null;

echo $n1 ?? $n2 ?? $z4;

// Fehlerunterbindungsoperator @
echo $array[1];
echo @$array[1];

// logische operatoren
$bool = false;
echo !$bool . " Negierung (Not)<br>";
echo ($bool && !$bool) . " and<br>";
echo ($bool || !$bool) . " or<br>";
echo ($bool ^ !$bool) . " xor<br>";