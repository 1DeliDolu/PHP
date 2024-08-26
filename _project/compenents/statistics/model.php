<?php
namespace PROJECT\components\statistics;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\Model as BaseModel;

class Model extends BaseModel {
    public function getLogins(int $userId): array {
        // Simulated database query for login logs
        return $this->db->query('SELECT * FROM logs WHERE type = "login" AND user_id = ?', [$userId]);
    }

    public function getLogouts(int $userId): array {
        // Simulated database query for logout logs
        return $this->db->query('SELECT * FROM logs WHERE type = "logout" AND user_id = ?', [$userId]);
    }
}
