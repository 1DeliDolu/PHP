<?php
namespace PROJECT\components\register;

defined("_PROJECT") or header("Location: /index.php");

use Exception;
use PROJECT\components\base\Model as BaseModel;
use PROJECT\includes\MsgType;
use PROJECT\includes\Stmt;

class Model extends BaseModel {
    public function validateusername(): array {
        try {
            $username = $this->request['username'];
            $isvalid = false;
            if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
                throw new Exception(MSG['username']['danger'][1], MSG['username']['danger'][0] + 1);
            }
            $parts = explode('@', $username);
            if (!checkdnsrr(array_pop($parts), 'MX')) {
                throw new Exception(MSG['username']['danger'][2], MSG['username']['danger'][0] + 2);
            }
            if (!$this->db->query(Stmt::getCountUserMail, [trim($username)])) {
                throw new Exception(MSG['db']['danger'][3], MSG['username']['danger'][0] + 3);
            }
            if ($this->db->getData()[0]['CountUser'] > 0) {
                throw new Exception(MSG['username']['danger'][3], MSG['username']['danger'][0] + 3);
            }
            $isvalid = true;
        } catch (Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        } finally {
            return [
                'isvalid' => $isvalid,
                'field' => $this->request['field']
            ];
        }
    }

    public function validatepassword(): array {
        try {
            $isvalid = false;
            $errno = 0;
            $pw = $this->request['password'];
            if (strlen($pw) < MIN_LENGTH || (defined(MAX_LENGTH) && strlen($pw) > MAX_LENGTH)) {
                $errno |= 0b00001;
            }
            if (!preg_match('/[A-Z]/', $pw)) {
                $errno |= 0b00010;
            }
            if (!preg_match('/[a-z]/', $pw)) {
                $errno |= 0b00100;
            }
            if (!preg_match('/\d/', $pw)) {
                $errno |= 0b01000;
            }
            if (!preg_match('/\W/', $pw)) {
                $errno |= 0b10000;
            }
            if (!$errno) {
                $isvalid = true;
            } else {
                throw new Exception(MSG['password']['danger'][1], MSG['username']['danger'][0] + $errno);
            }
        } catch (Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        } finally {
            return [
                'isvalid' => $isvalid,
                'field' => $this->request['field']
            ];
        }
    }

    public function register(): array {
        try {
            $isvalid = false;
            $user = new User(
                $this->request['username'],
                $this->request['password'],
                $this->request['first_name'],
                $this->request['last_name']
            );
            $user->hashpassword();
            if (!$this->db->query(Stmt::setUser, [
                $user->getUsername(),
                $user->getPassword(),
                $user->getFirstName(),
                $user->getLastName()
            ])) {
                throw new Exception(MSG['db']['danger'][1], MSG['username']['danger'][0] + 1);
            }
            $isvalid = true;
        } catch (Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        } finally {
            return [
                'isvalid' => $isvalid
            ];
        }
    }
}
