<?php
# COOKIEs mit PHP erzeugen und auslesen

// Cookies sind kleinere Information, die entweder als Textdatei auf dem Client oder direkt im Browser des Clients abgelegt werden
// sie können lediglich einen Schlüsselnamen und einen Wert enthalten (Key-Value-Pair)
// sie haben eine begrenzte zeitliche Gültigkeit
// sie können auf bestimmte Domains und Pfade begrenzt sein
// sie können auf die verschlüsselte (https) Übertragung eingeschränkt werden
// sie können auf ausschließliche das http-Protokoll eingeschränkt werden

# Rechtliches zu Cookies
// da das Setzen eines Cookies einen Zugriff evtl. auf personenbezogene Daten des Bentuzers darstellt, ist die DSVGO sowie die Europäische Cookie-Richtlinie zu beachten; sie besagt, dass der User vor dem Setzen der Cookies, über jeden Cookie informiert werden muss! Dabei muss wiederum unterschieden werden zwischen technisch notwendigen und optionalen Cookies; Optionale müssen per default deaktiviert sein, notwendige muss der User akzeptieren

# Erzeugen von Cookies
setcookie('mein_erster_cookie', 'hat funktioniert :)', [
    'expires'   => time() + (7 * 24 * 60 * 60),
    'domain'    => $_SERVER['SERVER_NAME'],
    'path'      => '/',                     // Slash = für alle Pfade
    'secure'    => false,                   // true = nur verschlüsselte Übertragung
    'httponly'  => true,                    // true = nur http/https-Protokoll; AJAX ist nicht http
    'samesite'  => 'Strict'                 // None, Lax, Strict
    // Strict: der Cookie wird nur auf Anfragen von der gleichen Seite übermittelt
    // Lax: der Cookie wird nicht gesendet, wenn Anfragen von einer anderen Seite stammen und Inhalte von der betreffenden Seite quer geladen werden (z. B. Bilder, Frames, JS, CSS, etc.)
    // None: Keine Einschränkung
]);

# Zugriff auf übermittelte Cookies
var_dump( $_COOKIE );
var_dump( $_COOKIE['mein_erster_cookie'] ?? null );

# Cookie löschen
if(array_key_exists('mein_erster_cookie', $_COOKIE)){
    // Expires ist auf auf eine vergangene Zeit zu setzen
    setcookie('mein_erster_cookie', '', time() - 1000);
}


# Übung: erstelle eine Funktion zum Anlegen eines Cookies unter Beachtung der möglichen Optionen

enum SameSite:string {
    case Strict = 'Strict';
    case Lax    = 'Lax';
    case None   = 'None';
}
function createCookie(string $name, array|bool|float|int|string $value, int $days = 365, string $domain = null, string $path = '/', bool $secure = false, bool $httponly = false, SameSite $samesite = SameSite::Strict ):bool {
    try{
        // prüfe name auf länge
        if(!strlen($name))throw new Exception('Cookiename is missing!', 1);
        // wandle $value in string um, wenn != string
        if(is_array($value)){
            $value = serialize($value);
        }elseif($value === true || $value === false){
            $value = $value ? 'true' : 'false';
        }elseif(is_int($value) || is_float($value)){
            $value = (string)$value;
        }
        // erstelle array options
        $options = [
            'expires'   => time() + $days * 60 * 60 * 24,
            'domain'    => $domain ?? $_SERVER['SERVER_NAME'],
            'path'      => $path,
            'secure'    => $secure,
            'httponly'  => $httponly,
            'samesite'  => $samesite->value
        ];
        return setcookie($name, $value, $options);
    }catch(Exception $e){
        return false;
    }
}

var_dump( createCookie('', 'test_1') );
var_dump( createCookie('string', 'test_2', days: 10) );
var_dump( createCookie('int', 1, secure: true) );
var_dump( createCookie('float', 2.4564, samesite: SameSite::Lax) );
var_dump( createCookie('array', [2,2,8,'skfbvks']) );
var_dump( createCookie('bool', true) );

function deleteCookie(string $name):bool {
    try {
        if(!strlen($name))throw new Exception('Cookiename is missing!', 1);
        if(!array_key_exists($name, $_COOKIE))throw new Exception('Cookie is missing!', 2);
        return createCookie($name, '', days: -1);
    }catch(Exception $e){
        return false;
    }
}

var_dump( createCookie('Delete', 16) );
sleep(5);
var_dump( deleteCookie('Delete') );


function getCookie(string $name):array|bool|float|int|string|Exception {
    try {
        if(!strlen($name))throw new Exception('Cookiename is missing!', 1);
        if(!array_key_exists($name, $_COOKIE))throw new Exception('Cookie is missing!', 2);
        // hole wert
        $value = $_COOKIE[$name];
        // prüfe den wert und wandle in in den entsprechenden datetypen um; außer string
        if($value === 'true'){
            $value = true;
        }elseif($value === 'false'){
            $value = false;
        }elseif(preg_match('/^\d+$/', $value)){
            $value = (int)$value;
        }elseif(preg_match('/^\d*\.\d+$/', $value)){
            $value = (float)$value;
        }elseif(preg_match('/^a:\d+:{.*}$/', $value)){
            $value = unserialize($value);
        }
        return $value;
    }catch(Exception $e){
        return $e;
    }
}
var_dump( getCookie('string') );
var_dump( getCookie('float') );
var_dump( getCookie('array') );
var_dump( getCookie('bool') );
var_dump( getCookie('gibtsnicht') );