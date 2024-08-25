<?php
session_start();
# SUPERGLOBALE Variablen sind grundsätzlich überall nutzbar
// sie werden von PHP und teilweise dem Webserver (Daten) im Programm (fast) immer zur Verfügung gestellt
// einige Webserver können unter umständen verschiedene Informationen bereitstellen

// nur lesbar, Inhalte abhängig vom Webserver
var_dump('$_SERVER', $_SERVER);
// les-/ und schreibbar; GET-Formulardaten oder URL-Parameter
var_dump('$_GET', $_GET);
// les-/ und schreibbar; POST-Formulardaten
var_dump('$_POST', $_POST);
// lesbar; über eine Formular übertragende Dateien
var_dump('$_FILES', $_FILES);
// lesbar; für die Seite gültige Cookies des Browsers
var_dump('$_COOKIE', $_COOKIE);
// les- und schreibbar; alle in der Sitzung liegenden Daten (serverseitiges Cookie)
var_dump('$_SESSION', $_SESSION);
// les- und schreibbar; alle $_GET, $_POST und $_COOKIE Daten
var_dump('$_REQUEST', $_REQUEST);
// CLI-Umgebungsvariablen
var_dump('$_ENV', $_ENV);