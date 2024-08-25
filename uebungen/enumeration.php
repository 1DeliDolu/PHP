<?php
# ENUMERATIONS
// sind vom Aufbau gesehen, Klassen sehr ähnlich
// sie bieten die Möglichkeit von Interfaces
// sie können Methoden mit eingeschränkter Sichtbarkeit beinhalten

// - Einsatz finden Sie um den Wertebereich von Datentypen einzugrenzen
// - in PHP können sie ausschließlich Int und String als Rückgabewert besitzen
// - Methoden können auch andere Rückgabewerte haben

// einfaches Enum ohne Rückgabe
enum Status {
    case Published;
    case Archived;
    case Deleted;
}
$state = Status::Deleted;

// Enumeration mit Rückgabewert (int und string sind zulässig)
enum MwSt:int {
    case Voll       = 19;
    case Ermaessigt = 7;
    case Ohne       = 0;
}
var_dump($tax = MwSt::Voll);
var_dump($tax->value);
var_dump(MwSt::Ermaessigt->value);

// Enumeration mit Methoden
enum Skat:int {
    case Diamond = 9;
    case Heart = 10;
    case Spades = 11;
    case Club = 12;
    public function hasColor():string {
        return match($this){
            self::Diamond   => 'yellow',
            self::Heart     => 'red',
            self::Spades    => 'green',
            self::Club      => 'brown'
            // default darf nicht angegeben werden, da es keine andere Option geben kann
        };
    }
}

var_dump( Skat::Heart->value );
var_dump( Skat::Heart->hasColor() );


// Enumeration mit Interfaces
# Interface: ist eine Vorlage von Methoden ohne Körper, die für Klassen und Enumeration verwendet werden können. Sie geben vor, welche Methoden die Klasse/Enum haben muss, aber nicht wie der Körper aussehen muss.

interface Engine {
    public function getGasType():string;
    public function getPower():int;
}
interface Vehicle {
    public function getSeats():int;
}

enum Pkw implements Engine, Vehicle {
    // cases...
    public function getGasType():string {
        return 'Diesel';
    }
    public function getPower():int {
        return 180;
    }
    public function getSeats():int {
        return 4;
    }

}

// Prüfen ob eine Variable eine Instanz einer bestimmten Enumeration ist
var_dump('Instanzprüfung', $state instanceof Status );
var_dump('Instanzprüfung', $state instanceof Skat );