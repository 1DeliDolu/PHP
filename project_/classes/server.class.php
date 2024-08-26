<?php
namespace PROJECT\classes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\classes\Msgs;
use PROJECT\includes\MsgType;

class Server {
    protected string|null $host = null;
    protected int|null $port = null;
    private bool $is_available = false;
    private Msgs $msgs;

    public function __construct(string|null $host = null, int|null $port = null) {
        // make the global $msgs object known
        global $msgs;
        $this->msgs = &$msgs;

        try {
            if($host === null) throw new Exception(message: MSG['server']['danger'][1], code: MSG['server']['danger'][0] + 1);
            if($port === null) throw new Exception(message: MSG['server']['danger'][2], code: MSG['server']['danger'][0] + 2);
            $this->setHost($host);
            $this->setPort($port);
            $this->is_available = is_resource( @fsockopen($this->host, $this->port, timeout: 1) ) ? true : false;
            if( !$this->is_available ) throw new Exception(message: sprintf(MSG['server']['danger'][3], $this->host, $this->port), code: MSG['server']['danger'][0] + 3);
        }catch (Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }
    }
    public function isAvailable():bool {
        return $this->is_available;
    }
    private function setHost(string|null $host = null):void {
        $this->host = $host;
    }
    private function setPort(int|null $port = null):void {
        $this->port = $port;
    }
}