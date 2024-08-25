<?php
// die Angabe der Datentypen für Parameter und Rückgabe sind erst ab PHP 8 möglich und optional

// Prozeduren - haben keinen Rückgabewert
function printText():void {
    echo '<p>Hello World!</p>';
}
printText();
printText();
printText();
printText();

function printOwnText(string $text):void {
    echo "<p>$text</p>";
}
printOwnText('Hallo Welt!');
printOwnText(13);
// printOwnText();

// ...$var: es können beliebig viele Argumente übergeben werden, die in der Funktion in einem Array verwaltet werden
function getArrayToString(string $separator, string ...$texts):void {
    echo '<p>' . implode($separator, $texts) . '</p>';
}
getArrayToString(', ', ...range('a', 'z'));

# Funktionen - haben einen Rückgabewert und können in Ausdrücken verwendet werden
// int|float: es sind mehrere datentypen möglich
// $argument = 2: das Argument ist optional; wird es nicht übergeben wird 2 als Defaultwert verwendet
function getPower(int|float $basis, int|float|null $exponent = 2):int|float {
    if(is_null($exponent))$exponent = 2;
    return $basis ** $exponent;
}

echo getPower(4, 3) . '<br>';
echo getPower(4) . '<br>';
echo getPower(4, null) . '<br>';
echo getPower(exponent: 4, basis: 3) . '<br>';
echo getPower(4.3, .8) . '<br>';
echo getPower('.3', .8) . '<br>';


# AUFRUF per Call-by-Value (CBV) oder Call-by-Reference (CBR)
// es wird der Wert an eine nur intern gültige Variable übergeben
function callByValue(int $a):void {
    echo $a *= 2;
}
// es wird die Speicheradresse der außerhalb liegenden Variable übergeben und deren Wert in der Funktion ggf. verändert
function callByReference(int &$a):void {
    echo $a *= 2;
}

$b = 10;
var_dump($b);
callByValue($b);        // übergabe wert
var_dump($b);           // b unverändert
callByReference($b);    // übergabe reference/speicheradresse von b
var_dump($b);           // verändert

// $c bekommt die Reference von $b
$c = &$b;
echo $c .'<br>';


// Gültigkeitsbereiche von Variablen

function getSum():int|float {
    // hole lokale äußere Variable in den Gültigkeitsbereich der Funktion -> globale Variable
    global $numbers;
    // erzeuge globale Variable, die auch außerhalb der Funktion gültig ist
    global $sum;
    // $sum: lokale Variable
    $sum = array_sum($numbers);
    return $sum;
}
// $numbers: lokale Variable, steht nur im Hauptprogramm zur Verfügung - nicht in Funktionen!
$numbers = [12, 13, 4156, 46];
echo getSum() . '<br>';
echo $sum . '<br>';

// superglobale Variablen sind grundsätzlich überall gültig -> superglobals.php

# ANONYME FUNKTIONEN - werden einer Variablen zugewiesen; sind also variabel
$a = 3;
$b = 10;
if($a>$b){
    $anoynme_oder_variable_funktion = function($a, $b){return $a+$b;};
}else{
    $anoynme_oder_variable_funktion = function($a, $b){return $a*$b;};
}
echo $anoynme_oder_variable_funktion($a, $b) . '<br>';

# ARROW FUNKTIONEN - Kurzschreibweise der Anonymen Funktion; können jedoch nur eine Anweisung ausführen
if($a>$b){
    $arrow_funktion = fn($a, $b) => $a+$b;
}else{
    $arrow_funktion = fn($a, $b) => $a*$b;
}
echo $arrow_funktion($a, $b) . '<br>';

# Rekursiver Funktionsaufruf - eine Funktion, die sich selbst aufruft
$persons = array(
    [
        'name'  => "Max Muster",
        'age'   => 39
    ],
    [
        'name'  => "Maria Mustermann",
        'age'   => 35,
        'address' => [
            'street'    => "Bachweg 13",
            'zipcode'   => '97755',
            'town'      => 'Hammelburg'
        ]
    ]
);
// es sollen alle werte nacheinander ausgebeben werden, egal in welcher dimension sie liegen
// echo implode(', ', $persons) . '<br>'; -> error, da ein mehrdimensionales array nicht in einen string umgewandelt werden kann
function arrayToString($array, $maxDepth = null, $level = 0):string {
    $str = "";
    // durchlaufe gesamtes array
    foreach($array as $item){
        // prüfe ob wert array, dann übergebe wert an arrayToString und füge return an $str an
        if(is_array($item) && (is_null($maxDepth) || $level < $maxDepth)) {
            // rekursiver aufruf
            $str .= arrayToString($item, $maxDepth, $level+1);
        }
        // wenn kein array, dann füge ihn $str 
        elseif(!is_array($item)) {
            $str .= $item . ' ';
        }
    }
    return $str;
}
echo arrayToString($persons, 1) . '<br>';

# Übung zu Funktionen
// erstelle eine Funktion, der beliebig viele Integer oder Floats und eine Rechenoperation (Addition oder Multiplikation) übergeben werden. Sie soll entweder das Ergebnis oder eine Fehlermeldung bei falscher Rechenoperation oder fehlenden Zahlen zurückgeben

// der Aufruf der Funktion könnte bspw. so aussehen

echo getCalc('+', 12, 142, 4, 64, .165) . '<br>';
echo getCalc('-', 12, 142, 4, 64, .165) . '<br>';
echo getCalc('*', 12, 142, 4, 64, .165) . '<br>';
echo getCalc('/', 12, 142, 4, 64, .165) . '<br>';
echo getCalc('/', 12, 142, 4, 0, .165) . '<br>';


function getCalc(string $operator, int|float ...$numbers):int|float|string {
    // prüfe ob keine zahlen übergeben wurden
    if(!count($numbers)){ $operator = false;}
    // werte den operator aus 
    return match($operator){
        '+', 'add'  => array_sum($numbers),
        '-', 'sub'  => array_shift($numbers) - array_sum($numbers),
        '*', 'mul'  => array_product($numbers),
        '/', 'div'  => (function($numbers) {
            // extrahiere ersten wert
            $result = array_shift($numbers);
            // probiere
            try{
                // für jeden weiteren wert
                foreach($numbers as $number) {
                    // prüfe ob wert 0, dann werfe ausnahme
                    if($number == 0){
                        throw new Exception(message: 'Division durch 0!', code: 0x80002040);
                    }
                    // teile mit wert
                    $result /= $number;
                }
            }
            // fange ausnahme auf
            catch(Exception $e){
                // lege fehlermeldung auf ergebnis
                $result = $e->getMessage() . ' (0x' . dechex($e->getCode()) .')';
            }
            // führe in jedem fall aus (finally is optional)
            finally{
                return $result;
            }
        })($numbers),
        false       => 'Keine Zahlen zur Berechnung vorhanden!',
        default     => 'Falscher Operator'
    };
}