<?php
namespace PROJECT\components\menu;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\components\base\Model as BaseModel;
use PROJECT\includes\MsgType;

class Model extends BaseModel {

    public function isLoggedIn():bool {
        try {
            $loggedin = false;
            // check if exist login in session
            if(!is_null($this->session->get('login'))) {
                // check login.id and browser and ip from user -> all true
                if($this->session->get('login.id') > 0 && $this->session->get('login.browser') == $_SERVER['HTTP_USER_AGENT'] && $this->session->get('login.ip') == $_SERVER['REMOTE_ADDR']) {
                    $loggedin = true;
                }
                // check login.id and browser and ip from user -> browser or ip false (prevents login sessionhijacking)
                else if($this->session->get('login.id') > 0 && ( $this->session->get('login.browser') != $_SERVER['HTTP_USER_AGENT'] || $this->session->get('login.ip') != $_SERVER['REMOTE_ADDR'] ) ){
                    throw new Exception(MSG['login']['danger'][3], MSG['login']['danger'][0] + 3);
                }
            }
        }catch(Exception $e) {
            // delete all data from session
            $this->session->clear();
            $this->msgs->set($e, MsgType::Danger);
        }finally{
            return $loggedin;
        }
    }

}