<?php
define('_PROJECT', true);

$request = $_REQUEST;

if (isset($request['target'])) {
    $target = $request['target'];
    switch ($target) {
        case 'home':
            $controller = new \PROJECT\components\home\Controller($request);
            break;
        case 'statistics':
            $controller = new \PROJECT\components\statistics\Controller($request);
            break;
        case 'register':
            $controller = new \PROJECT\components\register\Controller($request);
            break;
        case 'login':
            $controller = new \PROJECT\components\login\Controller($request);
            break;
        default:
            // Handle default case or show an error
            break;
    }
    echo $controller->show();
}
