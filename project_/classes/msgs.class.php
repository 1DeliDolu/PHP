<?php
namespace PROJECT\classes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\includes\MsgType;
class Msgs {
    private array $msgs = [];

    public function set(Exception $e, Msgtype $type = Msgtype::Danger): void {
        $this->msgs[] = [
            'type' => ($this->getType($e->getCode()))->value,
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTrace()
        ];
    }
    public function get(int|null $idx = null):array {
        return is_null($idx) ? $this->msgs : ($this->msgs[$idx] ?? [
            'type' => null,
            'message' => null,
            'code' => null,
            'file' => null,
            'line' => null,
            'trace' => null,
        ]);
    }
    
    private function getType(int $code):MsgType {
        $r = null;
        
        if( substr(dechex($code - (4096 * 1)), 3, 1) == 0)$r = MsgType::Danger;
        if( substr(dechex($code - (4096 * 2)), 3, 1) == 0)$r = MsgType::Success;
        if( substr(dechex($code - (4096 * 3)), 3, 1) == 0)$r = MsgType::Warning;
        if( substr(dechex($code - (4096 * 4)), 3, 1) == 0)$r = MsgType::Info;
        if( substr(dechex($code - (4096 * 5)), 3, 1) == 0)$r = MsgType::Primary;
        
        return $r;
    }
}