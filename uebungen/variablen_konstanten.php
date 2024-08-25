<?php

// variablen
$ganzzahl = 123;
$fliesskommazahl = 123.4564;
$zeichenkette = 'Hallo Welt!';
$wahrheitswert = true;

$menge = array(1, 2, 3);
$objekt = new stdClass();

// var_dump gibt informationen zu einer variablen/konstanten aus
var_dump($ganzzahl, $fliesskommazahl, $zeichenkette, $wahrheitswert, $menge, $objekt);

// konstanten
define('MWST_VOLL', 19);
define('MWST_ERM', 7);

class Preise {
    // in objekten muss per const eine Konstante erzeugt werden
    const MWST_OHNE = 0;
}

var_dump(MWST_VOLL, MWST_ERM, Preise::MWST_OHNE);