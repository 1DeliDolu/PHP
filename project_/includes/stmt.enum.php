<?php
namespace Project\includes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

/* 
stmt = "sqlstatement includes ?|datatype[s]";
s = string
i = integer
d = float
b = binary
*/
enum Stmt:string {
    case getUserDataByUsername  = "SELECT id, `password`, counter_fail_login, (banned_at + 30 * 60) - UNIX_TIMESTAMP() as banned_at FROM user WHERE username = ?|s";
    case getCountUserMail       = "SELECT COUNT(id) as CountUser FROM user WHERE username = ?|s";
    case addUser                = "INSERT INTO user (username, `password`) VALUES (?, ?)|ss";
    case setCounterFail         = "UPDATE user SET counter_fail_login = counter_fail_login + 1 WHERE id = ?|i";
    case setBannedFail          = "UPDATE user SET counter_fail_login = counter_fail_login + 1, banned_at = UNIX_TIMESTAMP() WHERE id = ?|i";
    case resetBannedFail        = "UPDATE user SET counter_fail_login = 0, banned_at = NULL WHERE id = ?|i";
    case addLog                 = "INSERT INTO protocol (user_id, create_at, ip, `url`, browser, `status`) VALUES (?, ?, ?, ?, ?, ?)|iisssi";
    case getUserStatistics      = "SELECT id, FROM_UNIXTIME(create_at, '%d.%m.%Y') as 'date', FROM_UNIXTIME(create_at, '%H:%i:%s') as 'time', ip, browser, `url`, `status` FROM protocol WHERE user_id = ? ORDER BY create_at DESC|i";
    public function getSQL():string {
        return $this->getSplit(0);
    }
    public function getParamTypes():string {
        return $this->getSplit(1);
    }
    private function getSplit(int $idx):string {
        return explode('|', $this->value)[$idx] ?? "";
    }
}