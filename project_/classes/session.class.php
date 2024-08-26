<?php
namespace PROJECT\classes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\includes\MsgType;
use PROJECT\includes\Samesite;

class Session {
    // where should the session be saved
    private string|null $savepath = null;
    // prevents access to the session data by other urls (Strict) -> https://blog.viadee.de/samesite-cookies-strict-oder-lax
    private Samesite $samesite = Samesite::Strict;
    // path for which den cookie is valid; / all directories
    private string $path = '/';
    // which protocols are allowed to access the cookie; only http (ajax not included!) or all 
    private bool $httponly = false;
    //  only secure connections (https)?
    private bool $secure = false;
    private int $lifetime = 0;
    private string $domain = '';
    private Msgs $msgs;

    public function __construct(string|null $savepath = null, Samesite $samesite = Samesite::Strict, string $path = '/', bool $httponly = false, bool $secure = false, int $lifetime = 0, string|null $domain = null) {    
        // make msgs global
        global $msgs;
        $this->msgs = &$msgs;
        // take over params into object
        $this->setSavepath($savepath);
        $this->samesite = $samesite;
        $this->path = $path;
        $this->httponly = $httponly;
        $this->secure = $secure;
        $this->lifetime = abs($lifetime);
        $this->domain = $domain ?? $_SERVER['SERVER_NAME'];
        // set cookie_params
        session_set_cookie_params([
            'lifetime'  => $this->lifetime,
            'path'      => $this->path,
            'secure'    => $this->secure,
            'httponly'  => $this->httponly,
            'samesite'  => $this->samesite->value,
            'domain'    => $this->domain
        ]);
        // set cookie path
        session_save_path($this->savepath);
        // start session
        session_start();
        // renew session_id
        session_regenerate_id(true);
    }
    
    /**
     * function get() read mixed value from $_SESSION
     * @param string $key key in $_SESSION (e. g. 'userid' -> $_SESSION['userid] or 'user.id' -> $_SESSION['user']['id']))
     */
    public function get(string $key):mixed {
        try{
            $tmp = &$_SESSION;
            // split string key
            $keys = explode('.', $key);
            // each keys as key
            foreach($keys as $key) {
                // check if key numerical
                if(is_numeric($key) && $key == intval($key)){
                    $key = intval($key);
                }
                // check if key exists in $_SESSION
                if(!array_key_exists($key, $tmp) && $key == 'login') {
                    throw new Exception(sprintf(MSG['login']['warning'][1], $key), MSG['login']['warning'][0] + 1);
                }
                if(!array_key_exists($key, $tmp) && $key != 'login') {
                    throw new Exception(sprintf(MSG['session']['danger'][1], $key), MSG['session']['danger'][0] + 1);
                }
                // renew reference
                $tmp = &$tmp[$key];
            }
            // if an object as a serialized string
            if(is_string($tmp) && substr((string)$tmp, 0, 2) == "O:") {
                $tmp = unserialize($tmp);
            }
            return $tmp;
        }catch(Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
            return null;
        }
    }
    /**
     * function set() save mixed value in $_SESSION
     * @param string $key key in $_SESSION (e. g. 'userid' -> $_SESSION['userid] or 'user.id.3.[]' -> $_SESSION['user']['id'][3][]))
     * @param mixed $value value to save
     */
    public function set(string $key, mixed $value):void {
        try{
            // set reference to $_SESSION
            $tmp = &$_SESSION;
            // split string key
            $keys = explode('.', $key);
            // each keys as key
            foreach($keys as $key) {
                # check if key exists in $_SESSION
                // if key [] array_push to an indicies array
                if($key == '[]'){
                    // create new array if not exists
                    if(!is_array($tmp)){
                        $tmp = [];
                    }
                    // get next index
                    $key = count($tmp);
                }
                // if key an integer
                elseif(is_numeric($key) && $key == intval($key)) {
                    $tmp[intval($key)] = [];
                    $key = intval($key);
                }
                // all other keys (words)
                elseif(!array_key_exists($key, $tmp)) {                    
                    $tmp[$key] = [];
                }
                // renew reference -> dimension x in $_SESSION
                $tmp = &$tmp[ $key ];
            }
            // save value in $_SESSION
            $tmp = match(gettype($value)){
                'object', 'resource', 'resource (closed)'   => serialize($value),
                'unknown type'                              => null,
                default                                     => $value
            };
        }catch(Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }
    }
    private function setSavepath(string|null $savepath): void {
        try {
            // if savepath is null, set ini-default
            if(is_null($savepath)) {
                $savepath = ini_get('session.save_path');
            } else {
                // if savepath is not null, check if path exists; z.B. param = /tmp -> path document_root/tmp
                // and create path has not worked
                if ( !file_exists($_SERVER['DOCUMENT_ROOT'] . str_replace('//', '/', ('/' . $savepath))) && !mkdir($_SERVER['DOCUMENT_ROOT'] . str_replace('//', '/', ('/' . $savepath)), 0644, true)) {
                    throw new Exception(MSG['session']['warning'][1], MSG['session']['warning'][0] + 1);
                }
                // set savepath into object
                $savepath = $_SERVER['DOCUMENT_ROOT'] . str_replace('//', '/', ('/' . $savepath));
            }
        }catch(Exception $e) {
            $savepath = ini_get('session.save_path');
            $this->msgs->set($e, MsgType::Warning);
        }finally{
            $this->savepath = $savepath;
        }
    }

    public function clear():bool {
        try {
            // destroy all registered data from a session
            $cleared = session_unset();
            if(!$cleared){
                throw new Exception();
            }
        }catch(Exception $e) {
            // destroy current session
            session_destroy();
            // start current session new
            $this->__construct($this->savepath, $this->samesite, $this->path, $this->httponly, $this->secure, $this->lifetime, $this->domain);
            // get session status
            /*
            session_status returns
            PHP_SESSION_DISABLED (0) if sessions are disabled.
            PHP_SESSION_NONE (1) if sessions are enabled, but none exists.
            PHP_SESSION_ACTIVE (2) if sessions are enabled, and one exists.
            */
            $cleared = session_status() === 2 ? true : false;
        }finally{
            return $cleared;
        }
    }
}