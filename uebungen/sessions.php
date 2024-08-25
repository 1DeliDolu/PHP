<?php
# SESSIONS

// Problem: http ist ein verbindungslosen Protokoll; d. h. jeder Aufruf ist ein neuer Programmstart und alle Informationen, des vorherigen Aufrufs sind verloren
// dieses kann anhand von Sessions (Sitzungen) gelöst werden
// Sessions sind ähnlich Cookies, die angelegt werden können und entweder bis zum Schließen des Browsers oder nach Ablauf einer festgelegten Zeit (Default 1440 Sek.) verfallen
// die Verfallszeit wird mit jedem Aufruf erneuert
// eine Session besteht aus einem Browser-Cookie und einem Server-Cookie mit einer zufälligen Kennung einer definierten Länge
// im Server-Cookie können Daten in einem serialisiertem Array abgelegt werden
// die Kennung wird bei jedem neuen Aufruf vom Client an den Server übermittelt, sodass de Client durch den Server wiedererkannt wird

// Rechtlich: wie Cookies (funktionaler Cookie)

// Gefahr: durch Übernahme der Kennung von Dritten kann es zu dem Session-Hijacking kommen; um dies zuverhindern sollten zusätzliche Informatinoen in der Session zum User abgelegt werden (z. B. Browser, "IP")

// Einstellungen für die Session -> muss vor session_start() erfolgen oder mit session_start(options)
session_set_cookie_params([
    'lifetime'  => 15 * 60,     // 15 Minuten
    'domain'    => $_SERVER['SERVER_NAME'],
    'path'      => '/',
    'secure'    => false,
    'httponly'  => false,
    'samesite'  => 'Strict'
]);
// individuellen Speicherort festlegen -> muss vor session_start() erfolgen
session_save_path($_SERVER['DOCUMENT_ROOT'] . '/tmp');
// lege /tmp an, falls noch nicht existent
if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/tmp') || !is_dir($_SERVER['DOCUMENT_ROOT'] . '/tmp')){
    mkdir($_SERVER['DOCUMENT_ROOT'] . '/tmp', 0600);
}
// Name der Session ändern
session_name('SID');
// Session starten -> muss unbedingt am Anfang des Programms erfolgen
session_start();
// grundsätzliches Erneuern der Session-ID (erschwert das Session-Hijacking)
session_regenerate_id(delete_old_session: true);

// Zugriff auf Session-Daten (prüfen des Browsers)
if(array_key_exists('user', $_SESSION) && array_key_exists('browser', $_SESSION['user']) && $_SESSION['user']['browser'] != $_SERVER['HTTP_USER_AGENT']) {
    # lösche session
    // server-cookie
    session_destroy();
    // client-cookie
    setcookie(session_name(), '', time()-86400, '/');
    // leite auf startseite um
    header('Location: sessions.php');
    // beende script
    exit();
}else{
    // Daten in der Sitzung speichern
    $_SESSION['schema'] = 'light';
    $_SESSION['fontsize'] = 14;
    $_SESSION['user'] = [
        'login'     => false,
        'browser'   => $_SERVER['HTTP_USER_AGENT']
    ];
}


# weitere nützliche Funktionen
var_dump('Sessionname lesen', session_name() );
var_dump('Session-ID lesen', session_id() );
var_dump('Session-Params', session_get_cookie_params() );
var_dump('Session-Speicherort lesen', session_save_path() );

var_dump('Session-Array serialisieren (z.B. für Speicherung in DB)', session_encode() );
// session_decode(string):bool -> liest einen serialisierten String in die Session ein