<?php
# STRINGS / Zeichenketten
// in PHP ist auch eine einzelnes Zeichen ein String
// notwendig ist es, durchweg den gleichen Zeichensatz zu verwenden

# AUSGABE von Strings
// einfache/direkte ausgabe
echo 'Einfache Ausgabe ohne zusätzliche Funktionen<br>';
print('Einfache Ausgabe ohne zusätzliche Funktionen<br>');
// direkte formatierte Ausgabe
// Beschreibung der Funktion und Platzhalter: https://www.php.net/manual/de/function.printf.php
printf('Der Preis für das Produkt %s beträgt %.2f €. Es ist noch %d mal auf Lager und hat die Artikelnummer %08d.<br>', 'Laptop', 1356.4678, 5 ,1014);
// formatierte Ausgabe an eine Variable
$str = sprintf('Der Preis für das Produkt %s beträgt %.2f €. Es ist noch %d mal auf Lager und hat die Artikelnummer %08d.<br>', 'Laptop', 1356.4678, 5 ,1014);
echo $str;

/*
Steuer-/Escapezeichen in Strings verwenden
Folgende Escapes müssen in " \n" stehen
\n  New line / Zeilenumbruch
\t  Tabstop
\s  Space/Whitespace/
\r  Return
\n\l    wie \n

der Backslash kann auch zur Entwertung der eigentlichen Bedeutung folgender Zeichen verwendet werden 
\'  wird benötigt, wenn ein String in '...\'...' eingeschlossen ist und dieses Zeichen darin wird
\"  wird benötigt, wenn ein String in "...\"..." eingeschlossen ist und dieses Zeichen darin wird
\$  wird benötigt, wenn ein String in "... \$text ..." und darin das $ vor einem Wort steht; es wird sonst als Variable verwendet
*/

echo 'BsN\'\n\'BsN' . "BsN\"\n\"BsN<br>";

// Zahlen formatiert ausgeben; die Zahl wird kaufmännisch gerundet
echo number_format(num: 74564676.65765465465, decimals: 2, decimal_separator: ',', thousands_separator: '.') . '&nbsp;€<br>';


// Suche in Strings
$mail = 'Max.Mustermann@gmx.de';
// strstr sucht case-sensistiv nach dem Vorkommen in einem String
var_dump( strstr($mail, 'muster') );
// stristr sucht case-insensitiv nach dem Vorkommen in einem String
var_dump( stristr($mail, 'muster') );
var_dump( stristr($mail, 'muster', false) );
var_dump( stristr($mail, 'muster', true) );
// Am Anfang, am Ende oder irgendwo prüfen; case-sensitiv
var_dump( str_starts_with($mail, '.') );
var_dump( str_ends_with($mail, '.de') );
var_dump( str_contains($mail, '@') );
// genaue Prüfung eines Strings mit regulären Ausdrücken/Regular Expression -> für das Testen von RegExp regex101.com
// RegEx sollten nur wenn unbedingt notwendig verwendet werden, da sie sehr systemlastig sind
var_dump( preg_match(pattern: '/^[a-z0-9]+(.[a-z]+)*@([a-z]{2,}.)+[a-z]{2,10}$/i', subject: $mail) );
var_dump( preg_match('/\d{5}/', '46546'));

// Leerzeichen, \n \r am Anfang und oder Ende löschen
var_dump( trim('                Test                ') );
var_dump( ltrim('                Test                ') );
var_dump( rtrim('                Test                ') );

// Teilzeichenketten extrahieren
var_dump( substr(string: $mail, offset: 4, length: 6) );
var_dump( substr(string: $mail, offset: 4) );
var_dump( substr(string: $mail, offset: -2) );
var_dump( substr(string: $mail, offset: -6, length: 3) );
var_dump( substr(string: $mail, offset: 4, length: -3) );

// Zeichenposition ermitteln
var_dump( strpos($mail, 'm') );
var_dump( strrpos($mail, 'm') );
var_dump( stripos($mail, 'm') );
var_dump( strripos($mail, 'm') );

// Stringumwandlung Groß-/Kleinbuchstaben
var_dump( strtoupper('mAx mUsTerMann') );
var_dump( strtolower('mAx mUsTerMann') );
var_dump( ucwords('max-mustermann') );
var_dump( ucwords('max mustermann') );
var_dump( ucfirst('mAx mUsTerMann') );

// html-Tags behandeln -> Sicherheitsrisiko bei Eingabefelder (siehe XSS/Cross-Site-Scripting)
var_dump( strip_tags('<a href="überraschungsvirus.com">Aktuelle <b onmouseover="alert(\'Hallo!\')">Sicherheitsupdates</b></a>', '<b>') );
echo strip_tags('<a href="virus.com">Aktuelle <b onmouseover="alert(\'Hallo!\')">Sicherheitsupdates</b></a>', '<b>');
var_dump( htmlentities('<a href="überraschungsvirus.com">Aktuelle <b script="alert(\'Hallo!\')">Sicherheitsupdates</b></a>') );
echo htmlentities('<a href="virus.com">Aktuelle <b script="alert(\'Hallo!\')">Sicherheitsupdates</b></a>');

$htmlentities = htmlentities('<a href="überraschungsvirus.com">Aktuelle <b script="alert(\'Hallo!\')">Sicherheitsupdates</b></a>');
var_dump( html_entity_decode($htmlentities) );
// weniger Ersetzungen als htmlentities (&, ", ', <, >)
var_dump( htmlspecialchars('<a href="überraschungsvirus.com">Aktuelle <b script="alert(\'Hallo!\')">Sicherheitsupdates</b></a>') );
var_dump( htmlspecialchars_decode($htmlentities) );

// Länge von Strings ermitteln
var_dump( strlen($mail) );

// ASCII-Code eines ASCII-Zeichen ermitteln
var_dump( ord('A') );
// ASCII-Code in ASCII-Zeichen umwandeln
var_dump( chr(65) );


# VERSCHLÜSSELUNG von Strings
var_dump( crc32('Pa$$w0rd') );  // 32 Bit
var_dump( sha1('Pa$$w0rd') );   // 20 Zeichen oder 40 Hex
var_dump( md5('Pa$$w0rd') );    // 32 Zeichen Hex

// für Passwort-Hashs sollte jedoch verwendet werden
var_dump( password_hash('Pa$$w0rd', PASSWORD_DEFAULT) );


# Zahlenumwandlung
var_dump( decbin(10) );
var_dump( dechex(10) );
var_dump( hexdec('fe') );
var_dump( bindec('101101110') );

var_dump( base_convert('fe', 16, 2) );
var_dump( base_convert('111111111111111101101110', 2, 36) );
