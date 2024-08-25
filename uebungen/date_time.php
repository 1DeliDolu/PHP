<?php
# DATUM & UHRZEIT
// Problem bei der Verwendung von Datums- und Zeitangaben, sind die verschiedenen Zeitzonen, die weltweit verwendet werden
// Die durch PHP ermittelte Zeit, ist immer die des Servers
// PHP ist jedoch in der Lage die GMT+0 zurückzugeben
// Es ist darauf zu achten, dass oftmals eine genaue Zeit benötigt wird, diese sollte nicht als Datum/Zeit sondern als Timestamp (Integer in Sekunden seit dem 01.01.1970) gespeichert werden
// PHP kann bei Bedarf auch Zeitangaben in MIPS (Prozessortaktung) zurückgeben 


# Achtung: getdate() lässt keinen Rückschluss auf die Zeitzone zu
// aktuelle Zeit ermitteln
var_dump( getdate() );
// Zeit anhand eines Timestamps erzeugen
var_dump( getdate(1723184318) );
// direkter Zugriff auf einen Index des Arrays ohne Umwege
var_dump( getdate()[0] );

// Datum-/Zeit-/Zahlenformate auf landesspezifische Einstellungen festlegen
setlocale(LC_ALL, ['de_DE@euro', 'de_DE', 'de', 'ge']);

// Datum-/Zeit formatiert ausgeben
// https://www.php.net/manual/de/datetime.format.php
var_dump( date(format: 'd.m.Y H:i:s', timestamp: 1723184318) );
var_dump( date(format: 'j.n.y G:i:s', timestamp: 1723184318) );
var_dump( date(format: 'r') );
var_dump( 'Schaltjahr? 0|1', date(format: 'L') );
var_dump( 'Sekunden in der UNIX-Epoche:', date(format: 'U') );
var_dump( 'Zeitverschiebung in Sekunden :', date(format: 'Z') );
// seit PHP 8.1.0 als deprecated gekennzeichnet (sollte also nicht mehr verwendet werden)
var_dump( strftime(format: '%A, %d.%m.%Y %H:%M:%S', timestamp: 1723184318) );

// Zeitstempel seit 01.01.1970 00:00:00 GTM+-0 (Greenwich Mean Time)
var_dump ( time() );

// Zeitstempel anhand von einzelnen Zeitangaben erzeugen
var_dump( mktime(hour: 0, minute: 0, second: 0, month: 4, day: 25, year: 1995) );
var_dump( mktime(hour: 0, year: 1995, month: 4, day: 25) );
var_dump( date('d.m.Y', mktime(hour: 0, year: 1995, month: 4, day: 25)) );

// Zeit eines Scripts in Mikrosekunden messen
var_dump( microtime(true) );    // as float
var_dump( microtime(false) );   // as string
var_dump( microtime() );        // as string
$start = microtime(true);
sleep(1);
$end = microtime(true);
var_dump( $end - $start);
// NUR! für die Prozessdauermessung besser geeignet da genauer - hrtime(): High resolution time
var_dump( hrtime(true) );        // as number
var_dump( hrtime() );            // as array
$start = hrtime(true);
sleep(1);
$end = hrtime(true);
var_dump( $end - $start);


// Datum validieren
var_dump( checkdate(month: 2, day: 29, year: 2024) );
var_dump( checkdate(month: 2, day: 29, year: 2023) );

// Datum aus String ermitteln
var_dump( date_parse('2024-08-09 09:21:00') );
var_dump( date_parse('09.08.2024 09:21:00') );
var_dump( date_parse('09.08.2024') );
var_dump( date_parse_from_format('Y-m-d H:i:s', '2024-08-09 09:21:00') );

// Timestamp aus String ermitteln
var_dump( strtotime('2024-08-09 09:47:23') );
var_dump( strtotime('2024-08-09') );
var_dump( strtotime('09.08.2024 09:47:23') );
var_dump( strtotime('09.08.2024') );


# Class DateTime
$dt = new DateTime();
var_dump( $dt );
var_dump( $dt->format('d.m.Y') );