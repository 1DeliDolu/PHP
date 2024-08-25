<?php
# KONTROLLSTRUKTUREN

// Verzweigungen
// Einfach~
if(5 > 4){
    echo 'Das ist richtig. 5 ist größer als 4<br>';
}

// Zweifach~
if(5 > 4){
    echo 'Das ist richtig. 5 ist größer als 4<br>';
}else{
    echo 'Das ist falsch. 5 ist nicht größer als 4<br>';
}
// ternäre Schreibweise bedingung ? wahrwert : falschwert
$anrede = true;
echo $anrede == true ? 'Frau' : 'Herr';

// Mehrfach~
$anrede = 0; // 0 bis x
if($anrede === 0) {
    echo 'Herr<br>';
}elseif($anrede === 1) {
    echo 'Frau<br>';
}else if($anrede === 2) {
    echo 'Person<br>';
}else{
    echo 'Die ausgewählte Anrede ist uns nicht bekannt.<br>';
}
// Mehrfachauswahl
switch($anrede) {
    case 0:
        echo 'Herr<br>';
        // break;  // break ist in php optional
    case 1:
        echo 'Frau<br>';
        break;
    case 2:
        echo 'Person<br>';
        break;
    default:    // der default -zweig ist optional
        echo 'Die ausgewählte Anrede ist uns nicht bekannt.<br>';
}
// match als ersatz für switch-case
$name = 'Müller';
echo 'Sehr geehrte' . match($anrede){
    0 => 'r Herr',
    1 => ' Frau',
    2, 3, 4 => ' Person',
    default => 'r unbekannter'
} . ' ' . $name;



// Schleifen/Iterationen: werden so oft wiederholt, wie die Bedingung wahr ist

// kopfgesteuerte Schleifen: können zwischen 0 bis unendliche iterationen haben
// Bedingungsschleife
$drehdich = true;
$i = 2;
while($drehdich == true){
    $i **= 2;
    if($i > 1000){
        $drehdich = false;
    }
}
echo $i . '<br>';
// Zählschleife - for(Initialisierung Zählwert; Bedingung; Reinitialisierung) {...}
for($i = 0; $i < 26; $i++) {
    echo chr($i + 65) . ', ';
}
// Mengenschleifen
$lowercases = range('a', 'z');
foreach($lowercases as $key => $value){
    echo "$key: $value, ";
}
foreach($lowercases as $value){
    // die zahl hinter break/continue gibt an um wie viele äußere strukturen der abbruch erfolgen soll
    // überspringe den aktuellen durchlauf und fahre mit dem nächsten fort
    if($value == 'c' || $value == 'm'){
        continue 1;
    }
    // beende die schleife
    if($value == 'v') {
        break 1;
    }

    echo "$value, ";
}


// fußgesteuerte Bedingungsschleife: können zwischen 1 bis unendliche iterationen haben
$password = 'Pa$$w0rd';
$passwords = ['falsch', 'Pa$$w0rd', 'nochmal falsch'];
$counter = 0;
do {
    if($password == $passwords[$counter]){
        echo 'Passwort ist korrekt.<br>';
        break; // oder $counter = 3;
    }else{
        echo 'Passwort ist nicht korrekt.<br>';
    }
    $counter++;
} while($counter < 3);


/*
Übung: erstelle das kleine 1 x 1; mit Ausgabe der beiden Faktoren und dem Produkt, z. B. 3*7=21
(Begrenzung der Faktoren von jeweils 1 bis 4)
*/
$min = 1;
$max = 4;
for($i = $min; $i <= $max; $i++) {
    for($j = $min; $j <= $max; $j++){
        // prüfe auf gerade produkte
        if( !(($i*$j)%2) ){ // ($i*$j)%2 == 0
            echo "$i * $j = " . ($i * $j) . '<br>';
        }
        // printf("%d * %d = %d<br>", $i, $j, $i * $j);
    }
}


/*
Gib anhand der Wochentagsnummer, die Wochentagsbzeichnung aus - ohne Array!
*/
$day = intval(date('w'));   // von 0 Sonntag bis 6 Sonnabend
// var_dump($day);
echo match($day){
    0, '0'  => 'Sonntag',
    1, '1'  => 'Montag',
    2, '2'  => 'Dienstag',
    3, '3'  => 'Mittwoch',
    4, '4'  => 'Donnerstag',
    5, '5'  => 'Freitag',
    6, '6'  => 'Samstag',
    default => 'unbekannter Wochentag'
};