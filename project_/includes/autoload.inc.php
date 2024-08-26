<?php
defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

// register function to load classes, namespaces, interfaces, traits and enum -> $classname
spl_autoload_register(function(string $classname):void {
    try {
        // to lowercase
        $path = strtolower($classname);
        // split classname (namespace) -> 2 backslashs!!! 1 escaped 2
        $path = explode("\\", $path);
        // check namespace prefix
        if(array_shift($path) != "project") {
            throw new Exception("Class {$classname} belongs not to the App!", 502);
        }
        // add sub directories -> ..
        array_unshift($path, ...(array_fill(0, substr_count($_SERVER['SCRIPT_NAME'] , "/") - 1, "..")));
        // check if file exists and include file
        $path = implode("/", $path);
        if(file_exists($path . ".php")) {
            include_once $path . ".php";
        }elseif(file_exists($path . ".inc.php")){
            include_once $path . ".inc.php";
        }elseif(file_exists($path . ".enum.php")){
            include_once $path . ".enum.php";
        }elseif(file_exists($path . ".class.php")){
            include_once $path . ".class.php";
        }else{
            throw new Exception("Class {$classname} not found!", 501);
        }
    }catch(Exception $e) {
        header('HTTP/1.1 '. $e->getCode() . ' '. $e->getMessage(), true, $e->getCode());
        exit();
    }
});
// import required files
require_once implode('', array_fill(0, substr_count($_SERVER['SCRIPT_NAME'] , "/") - 1, "../")) . "config/config.php";
require_once implode('', array_fill(0, substr_count($_SERVER['SCRIPT_NAME'] , "/") - 1, "../")) . "includes/msgs.inc.php";

use PROJECT\classes\Msgs;
use PROJECT\classes\Session;
$msgs = new Msgs();
$session = new Session(savepath: SESSION_PATH ?? null);

// register exception_handler
set_exception_handler(function(Throwable $e) {
    global $msgs;
    $msgs->set(new Exception('An unhandled exception has occurred!', 0x80000000 + $e->getCode(), $e->getPrevious()), \PROJECT\includes\MsgType::Danger);
 });
 