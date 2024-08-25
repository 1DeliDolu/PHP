<?php
# FILEHANDLING
// Datei können über zwei Wege geöffnet, bearbeitet und geschlossen werden
// Für den Zugriff müssen die entsprechenden Rechte für Ordner und Datei vorhanden sein
/* 
UNIX-Rechte
- werden über eine "16-Bit-Maske" gesetzt
- sie reichen von 0000 bis 0777
- erste Wertstelle: Sonderrechte
- zweite Wertstelle: Besitzer (Owner)
- dritte Wertstelle: Gruppe (Group)
- vierte Werstelle: Andere (Other)

- jede Stelle nutzt 3 Bit (zB. 7 - 111)
- 001 Ausführen (x: execute)
- 010 Schreiben (w: write)
- 100 Lesen (r: read)
*/
// Rechteanpassung für Dateien und Ordner
if(file_exists('index.php')){   // prüfe ob datei exisitiert
    chgrp('index.php', 'http');
    chown('index.php', 'http');
    chmod('index.php', 0755);
}

# Weg 1 (aufwändiger)
// 1. Datei öffnen - https://www.php.net/manual/de/function.fopen.php
$resource = @fopen(filename: 'counter.txt', mode: 'c+');
var_dump( $resource );
// prüfe ob sich datei hat öffnen lassen
if(is_resource ($resource)){
    // 2. Lese die aktuelle Zeile
    $zeile = fgets($resource);
    var_dump( $zeile );

    // wandle zeile (zahl) in Ganzzahl um und erhöhe wert um 1
    $counter = (int)$zeile + 1; // alternativ: intval($zeile)
    var_dump( $counter );

    // 3. setze Dateizeiger wieder an den Anfang der Datei
    rewind( $resource );

    // 4. Schreibe Inhalt in die Datei
    fwrite($resource, (string)$counter);

    // 5. Datei schließen
    fclose( $resource );
    var_dump( $resource );
}

# Weg 2 (einfacher)
// erzeuge log eintrag
// remoteip datum zeit http-status url
// http://uebungen.lh/filehandling.php
$url = sprintf('%s://%s%s', $_SERVER['REQUEST_SCHEME'], $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
$str = sprintf("%s\t%s\t%d\t%s\n", $_SERVER['REMOTE_ADDR'], date('Y-m-d H:i:s O', $_SERVER['REQUEST_TIME']), http_response_code(), $url);

var_dump($str);

// file_put_contents: fopen, fwrite, fclose
file_put_contents('access.log', $str, FILE_APPEND);

// file_get_contents: fopen, fread, fclose
$content = file_get_contents('access.log');
if($content){
    echo nl2br( $content );
}

# WEITERE FUNKTIONEN
// Speicherplatz in Bytes
var_dump( disk_free_space('C:') );
var_dump( disk_total_space('C:') );

// Übungen: berechne den belegten Speicherplatz, gebe den gesamten, belegten und freien Speicher in sinnvollen Einheiten aus
// Ermittle Daten
$total = disk_total_space('C:');
$free = disk_free_space('C:');
$used = $total - $free;
var_dump($total, $used, $free);
// Maßeinheiten für Dezimal und Binar
$units = [
    1000    => ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB', 'RB', 'QB'],
    1024    => ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB', 'RiB', 'QiB']
];
// eigener Datentyp, der die Umrechungsfaktoren einschränkt
enum SpaceSize:int {
    case Binary = 1024;
    case Decimal = 1000;
}
// Funktion zur Umrechnung (Speicherwert, eingegrenzter Faktor auf Binary und Decimal)
function getSpace(int $space, SpaceSize $faktor = SpaceSize::Binary):string {
    // mache units verfügbar
    global $units;
    // teile solange space > faktor oder die maximale Einheit erreicht wurde
    $i = 0;
    for(; $space > $faktor->value && $i < count($units[$faktor->value]); $i++){
        $space /= $faktor->value;
    }
    // gebe formatierte Größe zurück
    return sprintf("%s %s", number_format($space, 3, ',', '.'), $units[$faktor->value][$i] );
}

var_dump( getSpace($total, SpaceSize::Decimal) );
var_dump( getSpace($used, SpaceSize::Decimal) );
var_dump( getSpace($free, SpaceSize::Decimal) );