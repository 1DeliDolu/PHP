<?php
# DATENBANKZUGRIFF mysql/mariadb

// beide müssen uber die php_mysqli-Bibliothek angesprochen werden
// die Funktionen/Methoden für den Zugriff können sowohl prozedural als auch objektorientiert verwendet werden

// Zugangsrechte zum DBMS in Apps: eine App nutzt grundsätzlich für alle User die gleichen Zugangsrechte; vgl. mit Gruppenrichtlinien

/*
Nutzbare Objekte:
mysqli          : Verbindung zum Server, Fehlermeldungen, etc.
mysqli_stmt     : Vorbereitung, Ausführung von SQL-Statements, Fehlermeldungen, etc.
mysqli_result   : Rückgabe von Ergebnissem
*/

// da grundsätzlich Fehler auftreten können...
try {
    // prüfung ob server erreichbar ist - nur notwendig, wenn DBMS auf anderem Server läuft
/*     if( @fsockopen('localhost', -1, timeout: 1) === false){
        throw new Exception('Der Server ist nicht erreichbar!', 1);
    }
 */
    // prüfung ob dbs erreichbar ist
    if( @fsockopen('localhost', 3306, timeout: 1) === false){
        throw new Exception('Der DB-Server ist nicht erreichbar!', 2);
    }
    // aufbau der verbindung zum dbs
    $dbc = new mysqli(hostname: 'localhost', username: 'root', password: null, port: 3306);
    var_dump($dbc);
    
    // auswahl der zu nutzenden datenbank
    $dbc->select_db('mysql');
    var_dump($dbc);

    // anlegen des sql-statementes
    $stmt = new mysqli_stmt($dbc, 'SELECT Host, User, `Password` FROM user WHERE Host = ?');

    // falls ? platzhalter in stms der dml/dql vorhanden sind, müssen diese durch werte ersetzt werden
    /*
    Datatypes für bind_param
    i   Integer
    d   Float
    s   String
    b   Binary (BLOB)
    zb.
    insert into table(name, vorname, age, salary) values (?, ?, ?, ?);
    $stmt->bind_param('ssid', ...[$name, $vorname, $age, $salary]);
    */
    $params = ['localhost'];
    $stmt->bind_param('s', ...$params);
    var_dump($stmt);
    
    // ausführen der abfrage
    $stmt->execute();
    var_dump($stmt);

    // je nach stmt, muss ab hier anders fortgefahren werden
    /* 
    insert -> prüfe ob erfolgreich und hole insert_id
    update, delete -> prüfe ob erfolgreich und hole affected_rows
    select -> prüfe ob erfolgreich und hole abfrageergebnisse
    */

    // für insert:          $last_pk = $stmt->insert_id;
    // für update, delete:  $affected_rows = $stmt->affected_rows;
    // für select und andere mengenabfragen
    // verfügbarmachen der ergebnisse -> erzeugt ein object des types mysqli_result
    $result = $stmt->get_result();
    var_dump( $result );

    // übernahme von binärdaten in ein lesbares array
    $data = $result->fetch_all(MYSQLI_BOTH); // modes: MYSQLI_BOTH, MYSQLI_ASSOC, MYSQLI_NUM
    var_dump($data);
    
    // verbindung schließen - das mysqli-object bleibt erhalten
    $dbc->close();
    var_dump($dbc);
}catch(Exception $e){
    var_dump($e);
}