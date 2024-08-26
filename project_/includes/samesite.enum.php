<?php
// anhand namespaces lassen sich viele dateien zu packages zusammenfassen und per use namespace über einen definierten autoloader importieren
// namespaces müssen am anfang einer datei definiert werden
//  er beginnt mit einem einheitlichen prefix gefolgt von der ordnerstruktur der datei
namespace Project\includes;

// prüfe ob const _PROJECT existiert, wenn nicht leite um zur startseite
// dies verhindert den direkten aufruf der datei
defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

enum Samesite:string {
    case None = "None";
    case Lax = "Lax";
    case Strict = "Strict";
}