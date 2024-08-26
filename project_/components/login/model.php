<?php
namespace PROJECT\components\login;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\classes\Server;
use PROJECT\components\base\Model as BaseModel;
use PROJECT\includes\MsgType;
use PROJECT\includes\Stmt;


class Model extends BaseModel {
    public function verify():array {
        try {
            $success = false;
            $user_id = false;
            $status = 0;
            // get data from request
            $user = $this->request['username'] ?? '';
            $pass = $this->request['password'] ?? '';
            // get db-data
            $this->db->query(Stmt::getUserDataByUsername, [$user]);
            $result = $this->db->getData();
            if(count($result) != 1){
                throw new Exception(MSG['login']['danger'][1], MSG['login']['danger'][0] + 1);
            }
            // get user_id
            $user_id = $result[0]['id'];
            // if user banned?
            if(!is_null($result[0]['banned_at']) && $result[0]['banned_at'] > 0){
                $status = 1;
                throw new Exception(MSG['login']['danger'][2], MSG['login']['danger'][0] + 2);
            }
            // compare passwords if user found
            if(!password_verify($pass, $result[0]['password'])){
                // failed login 1 and 2 -> counter++
                if($result[0]['counter_fail_login'] < 2){
                    $status = 2;
                    $this->db->query(Stmt::setCounterFail, [$result[0]['id']]);
                    throw new Exception(MSG['login']['danger'][3], MSG['login']['danger'][0] + 3);
                }
                // failed login 3 -> counter++, banned_at
                else if($result[0]['counter_fail_login'] == 2){
                    $status = 3;
                    $this->db->query(Stmt::setBannedFail, [$result[0]['id']]);
                    throw new Exception(MSG['login']['danger'][4], MSG['login']['danger'][0] + 4);
                }
            }else{
                // reset counter and banned
                $this->db->query(Stmt::resetBannedFail, [$result[0]['id']]);
            }
            // set login into session
            $this->session->set('login', [
                'id'        => $result[0]['id'],
                'time'      => $_SERVER['REQUEST_TIME'],
                'browser'   => $_SERVER['HTTP_USER_AGENT'],
                'ip'        => $_SERVER['REMOTE_ADDR']
            ]);
            $status = 4;
            $success = true;
        }catch (Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }finally{
            if($user_id !== false){
                $this->addLog($user_id, $status);
            }
            return [
                'success' => $success,
            ];
        }
    }
    public function logout():array {
        try{
            $user_id = $this->session->get('login.id');
            $success = $this->session->clear();
            $status = 6 - intval($success);
        }catch(Exception $e){
            $this->msgs->set($e, MsgType::Danger);
        }finally{
            $this->addLog($user_id, $status);
            return [
                'success' => $success,
            ];
        }
    }
    
    private function addLog(int $user_id, int $status):void {
        try {
            // add log for succuess login (fail 1, banned 2, success 3), logout (success 4, fail 5) -> number for status
            $this->db->query(Stmt::addLog, [
                $user_id,
                $_SERVER['REQUEST_TIME'],
                $_SERVER['REMOTE_ADDR'],
                $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
                $_SERVER['HTTP_USER_AGENT'],
                $status
            ]);
        }catch(Exception $e){
            $this->msgs->set($e, MsgType::Danger);
        }
    }

    public function isServerAvailable():bool {
        try {
            $r = (new Server(DB_HOST, DB_PORT))->isAvailable();
        }catch(Exception $e){
            $this->msgs->set($e, MsgType::Danger);
        }finally{
            return $r;
        }
    }
}