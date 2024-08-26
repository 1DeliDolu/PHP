<?php
namespace PROJECT\components\base;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\classes\Msgs;
use PROJECT\includes\Msgs as Msg;   // alias, because Msgs already in use
use PROJECT\includes\MsgType;

abstract class Controller {
    protected Msgs $msgs;
    protected array $request = [];
    public function __construct(array $request) {
        global $msgs;
        $this->msgs = &$msgs;
        $this->request = $request;
    }
}