<?php
namespace PROJECT\components\register;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\components\base\Model as Basemodel;
use PROJECT\includes\MsgType;
use PROJECT\includes\Stmt;
class Model extends BaseModel {
    public function validateusername():array {
        try {   
            $username = $this->request['username'];
            $isvalid = false;
            // check mail-syntax
            if(!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                throw new Exception(MSG['username']['danger'][1], MSG['username']['danger'][0] + 1);
            }
            // check if domain dns entry exists
            $parts = explode('@', $username);
            if(!checkdnsrr(array_pop($parts), 'MX')){
                throw new Exception(MSG['username']['danger'][2], MSG['username']['danger'][0] + 2);
            }
            // check if mail already registered
            if(!$this->db->query(Stmt::getCountUserMail, [trim($username)]))throw new Exception(MSG['db']['danger'][3], MSG['username']['danger'][0] + 3);
            if($this->db->getData()[0]['CountUser'] > 0){
                throw new Exception(MSG['username']['danger'][3], MSG['username']['danger'][0] + 3);
            }
            $isvalid = true;
        }catch (Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }finally {
            return [
                'isvalid'   => $isvalid,
                'field'    => $this->request['field']
            ];
        }
    }
    public function validatepassword():array {
        try{
            $isvalid = false;
            $errno = 0;
            $pw = $this->request['password'];
            // check len
            if(strlen($pw) < MIN_LENGTH || ( defined(MAX_LENGTH) && strlen($pw) > MAX_LENGTH ) ) {
                $errno |= 0b00001;
            }
            // check ucase
            if(!preg_match('/[A-Z]/', $pw)){
                $errno |= 0b00010;
            }
            // check lcase
            if(!preg_match('/[a-z]/', $pw)){
                $errno |= 0b00100;
            }            
            // check digit
            if(!preg_match('/\d/', $pw)){
                $errno |= 0b01000;
            }
            // check symbol
            if(!preg_match('/\W/', $pw)){
                $errno |= 0b10000;
            }            
            if(!$errno){
                $isvalid = true;
            }else{
                throw new Exception(MSG['password']['danger'][1], MSG['username']['danger'][0] + $errno);
            }            
        }catch(Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }finally {
            return [
                'isvalid' => $isvalid,
                'field' => $this->request['field']
            ];
        }
    }
    public function register():array{
        try{
            $success = false;
            $username = $this->request['username'];
            $password = $this->request['password'];
            // query to add user
            $this->db->query(Stmt::addUser, [$username, password_hash($password, PASSWORD_DEFAULT)]);
            // check result -> last created primary key must to be !== false
            $lastID = $this->db->getInsertId();
            // if pk -> success true and make msg
            if($lastID !== false){
                $success = true;
                $this->msgs->set(new Exception(sprintf(MSG['register']['success'][1], $lastID), MSG['register']['success'][0] + 1), MsgType::Success);
            }else{
                throw new Exception(MSG['register']['danger'][1], MSG['register']['danger'][0] + 1);
            }
        }catch(Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }finally {
            return [
                'success' => $success
            ];
        }
    }
}