<?php
namespace PROJECT\components\base;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\classes\Db;
use PROJECT\classes\Msgs;
use PROJECT\includes\Msgs as Msg;   // alias, because Msgs already in use
use PROJECT\includes\MsgType;
use PROJECT\includes\Stmt;
use PROJECT\includes\SameSite;
use PROJECT\classes\Session;

abstract class Model {
    protected Db $db;
    protected Msgs $msgs;
    protected Session $session;
    protected array $request = [];
    public function __construct(array $request) {
        global $msgs;
        global $session;
        $this->msgs = &$msgs;
        $this->session = &$session;
        $this->db = new Db();
        $this->request = $request;
    }
}