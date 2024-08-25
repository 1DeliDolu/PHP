<?php
# OBJEKTORIENTIERT in PHP programmieren

// Klassen
// - sind Baupläne für Objekte
// - sie können Attribute (Beschreibungen) und Methoden (Funktionen zum Verändern, Lesen der Attribute) besitzen
// - sie können verallgmeinert werden; daraus entstehen Vererbungen und eine Klassenhierarchie (Basisklasse und abgeleitet Klasse) -> in PHP kann nur von einer Klasse geerbt werden
// - für Klassen können Interfaces bereitgestellt werden; Interface: Vorlage für Methoden, die eine Klasse besitzen muss
// - Klassen können abstract sein; d.h. von ihnen können selbst keine Instanzen gebildet werden, sie dienen ausschließlich der Vererbung
// - Klassen können final sein; d.h. von ihnen können keine Vererbungen erfolgen
// - Attribute und Methoden können static sein; d.h. auf diese kann direkt ohne Instanz zugegriffen werden, vgl. mit Konstanten oder global gültigen Variablen
// - Attribute und Methoden können über Sichtbarkeitsregeln vor dem Zugriff von Außen geschützt werden (private, protected, public [default in PHP])
// - PHP bietet neben dem __construct & __destruct, viele weitere MAGISCHE METHODEN, die auf bestimmte Sachverhalte in einem Objekt reagieren


// dekaration einer klasse
// abstract kann für zu allgemeine klassen verwendet werden, von denen keinen instanz gebildet werden soll
abstract class Person {
    // attribute - sollten private oder bei vererbung maximal protected sein. NIEMALS public!!!
    private int $age;
    private string $firstname;
    private string $lastname;
    // methoden - können je nach bedarf eine der drei sichtbarkeitsregeln haben; außer magische methoden - immer public
    // __construct ist immer public void, deshalb fällt selbst dieser als angabe weg
    public function __construct(string $firstname = '', string $lastname = '', int $age = -1) {
        $this->setAge($age);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
    }
    protected function setAge(int $age):void {
        $this->age = $age;
    }
    public function setFirstname(string $firstname):void {
        $this->firstname = $firstname;
    }
    public function setLastname(string $lastname):void {
        $this->lastname = $lastname;
    }

    public function getAge():int {
        return $this->age;
    }
    public function getFirstname():string {
        return $this->firstname;
    }
    public function geLastname():string {
        return $this->lastname;
    }
    public function getName():string {
        return sprintf('%s %s', $this->firstname, $this->lastname);
    }

    // methoden die einen boolean zurückgeben, erhalten das prefix is statt get
    public function isAdult():bool {
        return $this->age >= 18;
    }

    // Destruktor, wird beim Beenden einer Instanz automatisch ausgeführt
    public function __destruct() {
        echo 'Die Person wurde zerstört!';
    }
}

// bilden einer instanz
$max = new Student(age: 39);
$max->setFirstname('Max');
$max->setLastname('Mustermann');

$maria = new Student('Maria', 'Muster', 20);
$uwe = new Student('Uwe', 'Muster', 2);

// direkter zugriff auf attribute
// $max->age = -59; -> fatal error da age private

var_dump($max, $maria, $maria->getName(), $maria->isAdult(), $uwe, $uwe->getName(), $uwe->isAdult());

// Vererbung von Klassen - class extends basisclass
// Student erbt von Person alles was nicht private ist
class Student extends Person {
    // AGGREGATION der Klasse Course
    private array $course = [];
    public function __construct(string $firstname = '', string $lastname = '', int $age = -1) {
        parent::__construct($firstname, $lastname, $age);
    }
    public function setCourse(string $course):void {
        $this->course[] = new Course($course);
    }
    public function setGrade(int $course, int|float $note):void {
        $this->course[$course]->setGrade($note);
    }
    public function getGrades(int $course):array {
        return $this->course[$course]->getGrade();
    }
}

interface iCourse {
    public function setGrade(int|float $note):void;
}

// interfaces nutzen; es sind mehrere Interfaces durch Komma getrennt möglich
final class Course implements iCourse {
    private string $coursename;
    private array $grades = [];
    public function __construct(string $course) {
        $this->coursename = $course;
    }
    public function setGrade(int|float $note):void {
        $this->grades[] = $note;
    }
    public function getGrade():array{
        return $this->grades;
    }
}

final class Math {
    public static function getArrayAVG(array $data):float {
        return count($data) ? (array_sum($data) / count($data)) : 0;
    }
}


$dora = new Student(firstname: 'Dora', lastname: 'Müller', age: 25);
$dora->setCourse('Mathe');
$dora->setGrade(0, 2);
$dora->setGrade(0, 3);
$dora->setCourse('Physik');
// zugriff auf statische methoden/eigenschaften einer klasse
var_dump($dora, Math::getArrayAVG( $dora->getGrades(0) ));