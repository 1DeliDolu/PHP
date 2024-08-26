<?php
// set const _PROJECT
define("_PROJECT", true);
require_once("includes/autoload.inc.php");
$headers = apache_request_headers();
try {
    // check ajax-call
    if (!isset($headers['X-Requested-With']) || $headers['X-Requested-With']!== 'XMLHttpRequest')throw new Exception("Not an ajax-call!", 403);
    // read post data
    $data = (count($_POST) ? $_POST : json_decode(file_get_contents("php://input"), true)) ?? [];
    // check if is key component exist
    if(!array_key_exists('component', $data))throw new Exception("No component included!", 503);
    // get componentname and methodname
    $componentname  = strtolower(explode('.', $data['component'])[0] ?? null);
    $methodname     = strtolower(explode('.', $data['component'])[1] ?? null);
    // check if componentname and methodname null
    if(is_null($componentname) || is_null($methodname))throw new Exception("No component included!", 503);
    // use component -> create new instance
    $class = "PROJECT\\components\\{$componentname}\\Controller";
    $controller = new $class( $data['values'] ?? [] );
    // check if method exist
    if(!method_exists($controller, $methodname))throw new Exception("Method {$methodname} not implemented!", 501);
    // call method
    $response = $controller->{$methodname}();
    // return response
    echo json_encode([
        'data'  => $response,
        'msgs'  => $msgs->get()
    ]);
}catch(Exception $e) {
    header('HTTP/1.1 '. $e->getCode() .' '. $e->getMessage(), true, $e->getCode());
    exit();
};