<?php
defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

define("MSG", [
    "db"=> [
        "danger"    => [
            0       => 0x8001000,
            1       => "Es konnte keine Verbindung zum Datenbankserver hergestellt werden!",
            2       => "Es konnte keine Datenbank ausgewählt werden!",
            3       => "Die Abfrage konnte aus einem nicht bekannten Fehler ausgeführt werden!",
        ],
        "success"   => [
            0       => 0x8002000,
        ],
        "warning"   => [
            0       => 0x8003000,
        ],
        "info"      => [
            0       => 0x8004000,
            
        ],
        "primary"   => [
            0       => 0x8005000,
        ],
    ],
    "session"=> [
        "danger"    => [
            0       => 0x8011000,
            1   => "Es wurde kein passender Index \"%s\" in der Session gefunden!",
        ],
        "success"   => [
            0       => 0x8012000,
        ],
        "warning"   => [
            0       => 0x8013000,
        ],
        "info"      => [
            0       => 0x8014000,
        ],
        "primary"   => [
            0       => 0x8015000,
        ],
    ],
    "autoload"=> [
        "danger"    => [
            0       => 0x8021000,
        ],
        "success"   => [
            0       => 0x8022000,
        ],
        "warning"   => [
            0       => 0x8023000,
        ],
        "info"      => [
            0       => 0x8024000,
        ],
        "primary"   => [
            0       => 0x8025000,
        ],
    ],
    "server"=> [
        "danger"    => [
            0       => 0x8031000,
            1   => "Server: Es wurde kein Host angegeben!",
            2   => "Server: Es wurde kein Port angegeben!",
            3   => "Server: Der Server ist nicht erreichbar! (%s:%d)",
        ],
        "success"   => [
            0       => 0x8032000,
        ],
        "warning"   => [
            0       => 0x8033000,
        ],
        "info"      => [
            0       => 0x8034000,
        ],
        "primary"   => [
            0       => 0x8035000,
        ],
    ],
    "controller"=> [
        "danger"    => [
            0       => 0x8041000,
        ],
        "success"   => [
            0       => 0x8042000,
        ],
        "warning"   => [
            0       => 0x8043000,
        ],
        "info"      => [
            0       => 0x8044000,
        ],
        "primary"   => [
            0       => 0x8045000,
        ],
    ],
    "view"=> [
        "danger"    => [
            0       => 0x8051000,
            1       => "Der Templatepfad \"%s\" existiert nicht!",
            2       => "Das Template \"%s\" wurde nicht gefunden!",
        ],
        "success"   => [
            0       => 0x8052000,
        ],
        "warning"   => [
            0       => 0x8053000,
        ],
        "info"      => [
            0       => 0x8054000,
        ],
        "primary"   => [
            0       => 0x8055000,
        ],
    ],
    "model"=> [
        "danger"    => [
            0       => 0x8061000,
        ],
        "success"   => [
            0       => 0x8062000,
        ],
        "warning"   => [
            0       => 0x8063000,
        ],
        "info"      => [
            0       => 0x8064000,
        ],
        "primary"   => [
            0       => 0x8065000,
        ],
    ],
    "login"=> [
        "danger"    => [
            0       => 0x8071000,
            1       => "Ein Benutzer mit diesem Benutzernamen ist nicht bekannt!", 
            2       => "Das Benutzerkonto ist derzeit gesperrt!",
            3       => "Das Passwort stimmt nicht mit dem gespeicherten Kennwort überein!", 
            4       => "Das Kennwort wurde 3 mal falsch eingegeben und das Konto vorüvergehend gesperrt!",
        ],
        "success"   => [
            0       => 0x8072000,
        ],
        "warning"   => [
            0       => 0x8073000,
            1       => "Sie müssen sich erst anmelden bevor Sie diesen Dienst nutzen können.",
        ],
        "info"      => [
            0       => 0x8074000,
        ],
        "primary"   => [
            0       => 0x8075000,
        ],
    ],
    "register"=> [
        "danger"    => [
            0       => 0x8081000,
            1       => "Die Registrierung ist fehlgeschlagen!",
        ],
        "success"   => [
            0       => 0x8082000,
            1       => "Die Registrierung war erfolgreich! Sie können sich nun mit Ihrem Benutzername und Passwort anmelden! Ihre Benutzer-ID lautet: %d",
        ],
        "warning"   => [
            0       => 0x8083000,
        ],
        "info"      => [
            0       => 0x8084000,
        ],
        "primary"   => [
            0       => 0x8085000,
        ],
    ],
    "username"=> [
        "danger"    => [
            0       => 0x8091000,
            1       => "Die E-Mail-Adresse ist nicht gültig!",
            2       => "Die Domain der E-Mail-Adresse ist kein gültiger MX-Eintrag!",
            3       => "Der Benutzername ist bereits registriert!",
        ],
        "success"   => [
            0       => 0x8092000,
        ],
        "warning"   => [
            0       => 0x8093000,
        ],
        "info"      => [
            0       => 0x8094000,
        ],
        "primary"   => [
            0       => 0x8095000,
        ],
    ],
    "password"=> [
        "require"  => [
            'len_min'   => "Das Passwort muss mindestens %d Zeichen lang sein!",
            'len_minmax'=> "Das Passwort muss zwischen %d und %d Zeichen lang sein!",
            'ucase' => "Das Passwort muss mindestens 1 Großbuchstaben enthalten!",
            'lcase' => "Das Passwort muss mindestens 1 Kleinbuchstaben enthalten!",
            'digit' => "Das Passwort muss mindestens 1 Ziffer enthalten!",
            'symbol'=> "Das Passwort muss mindestens 1 Sonderzeichen enthalten!",
        ],
        "danger"    => [
            1       => "Das Passwort enthält Fehler!",
        ]
    ],
    "protocol" => [
        "status" => [
            1       => "Das Benutzerkonto war beim Anmeldeversuch vorübergehend gesperrt.",
            2       => "Das Kennwort wurde falsch eingegeben.",
            3       => "Das Benutzerkonto wurde nach 3 maliger Falscheingabe des Kennworts gesperrt.",
            4       => "Die Anmeldung war erfolgreich.",
            5       => "Die Abmeldung war erfolgreich.",
            6       => "Die Abmeldung war nicht erfolgreich.",
        ]
    ]
]);