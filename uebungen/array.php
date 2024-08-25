<?php
// arrays sind mengen, gleichen oder unterschiedlichen datentyps unbestimmter größe

// deklaration
$arr_1 = array();
$arr_2 = [];
var_dump($arr_1, $arr_2);

// deklaration & initialisierung - indizierte arrays (indexbasiert von 0 bis n-1)
$arr_1 = array(1,2,3,4,5,6,7);
$arr_2 = [1,2,3,4,5,6,7];
var_dump($arr_1, $arr_2);

// deklaration & initialisierung - assoziative arrays (namensbasiert)
$person = [
    'vorname'   => "Max",
    'nachname'  => "Mustermann",
    'alter'     => 39
];
var_dump($person);

// zugriff auf werte eines arrays
echo $arr_1[5] . '<br>';
echo $person['vorname'] . '<br>';

// hinzufügen von werten an das ende des arrays
$arr_2[] = 12;
// oder über funktionsaufruf array_push
array_push($arr_2, 86, 546, 13);
array_push($arr_2, ...[89, 45, 65]);
$person['gehalt'] = 2985.95;
var_dump($arr_2, $person);

// hinzufügen von werten an den anfang eines arrays
array_unshift($arr_2, 46546);
array_unshift($arr_2, ...[123,465,748]);
var_dump($arr_2);

// löschen von elementen eines arrays
// erstes element
$erstes = array_shift($arr_1);
var_dump($erstes, $arr_1);
// letztes element
$letztes = array_pop($arr_1);
var_dump($letztes, $arr_1);
// zwischendrin
$mitte = array_splice($arr_1, offset: 1, length: 2, replacement: 'a');
var_dump($mitte, $arr_1);

// VORSICHT! Indexe werden nicht neu sortiert, sodass der zugriff mittels for zu Fehlern führen könnte
unset($arr_1[1], $arr_1[2]);
var_dump($arr_1);

// werte ersetzen
$arr_1[0] = 863486;
$person['nachname'] = 'Muster';
var_dump($arr_1, $person);

// arrays sortieren, reihenfolge ändern
sort($arr_2);       // aufsteigend
var_dump($arr_2);
rsort($arr_2);      // absteigend
var_dump($arr_2);
shuffle($arr_2);    // zufällig
var_dump($arr_2);

// länge eines arrays ermitteln
echo count($arr_2) . '<br>';
echo sizeof($arr_2) . '<br>';

// prüfen ob es sich um ein array handelt
if(is_array($person)){
    echo '$person ist ein Array<br>';
}else{
    echo '$person ist kein Array<br>';
}
// prüfen ob ein bestimmter key in einem array vorhanden ist
if(is_array($person) && array_key_exists('vorname', $person)){
    echo $person['vorname'] . '<br>';
}else{
    echo '$person besitzt keinen Schlüssel vorname<br>';
}

// prüfen ob ein bestimmter wert im array enthalten ist
echo in_array(needle: 456, haystack: $arr_2);       // booelan
echo array_search(needle: 456, haystack: $arr_2);   // index, wenn gefunden, sonst false

// mehrere arrays zusammenführen
$arr_1 = array_merge($arr_1, $arr_2);
var_dump($arr_1);

// array mit fortlaufenden werten erzeugen
$alphabet = range('A', 'Z');
var_dump($alphabet);

// array mit gleichen werten füllen
$samevalues = array_fill(start_index: 5, count: 10, value: 'Banana');
var_dump($samevalues);

// keys mit values tauschen
$person = @array_flip($person);
var_dump($person);
$person = array_flip($person);

// werte eines Arrays in String umwandeln (Zeichenkettenfunktion)
$string = implode(', ', $alphabet);
// alias join() $string = join(', ', $alphabet);
var_dump($string);

// werte eines Strings in Arrays zelegen (Zeichenkettenfunktion)
$alphabet_neu = explode(', ', $string);
var_dump($alphabet_neu);


# MEHRDIMENSIONALE ARRAYS
// die Tiefe ist unbegrenzt
// es muss i. d. R. die darüberliegende Dimension vorhanden sein

// bei Deklaration und Initialisierung
$persons = array(
    [
        'name'  => "Max Muster",
        'age'   => 39
    ],
    [
        'name'  => "Maria Mustermann",
        'age'   => 35
    ]
);
var_dump($persons);

// bei Deklaration und spätere Initialisierung
// 1. Dimension
$persons = [];
// Array der 2. Dimension in der 1. Dimension anlegen
$persons[] = [
    'name'  => "Max Muster",
    'age'   => 39
];
$persons[] = [
    'name'  => "Maria Mustermann",
    'age'   => 35
];
var_dump($persons);

// Zugriff auf mehrdimensional Arrays
var_dump($persons[1]['name']);

$persons[1]['address'] = [
    'street'    => "Bachweg 13",
    'zipcode'   => '97755',
    'town'      => 'Hammelburg'
];
var_dump($persons);



// Übung: Speichere alle Produkte des kleinen 1 x 1 in einem Array ab
$min = 1;
$max = 10;

$results = [];
for($i = $min; $i <= $max; $i++){
    $results[$i-1] = [];
    for($j = $min; $j <= $max; $j++) {
        $results[$i-1][$j-1] = $i * $j;
    }
}
var_dump($results);