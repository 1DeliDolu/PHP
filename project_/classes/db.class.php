<?php
namespace PROJECT\classes;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use mysqli;
use mysqli_result;
use mysqli_stmt;
use PROJECT\classes\Msgs;
use PROJECT\classes\Server;
use PROJECT\includes\MsgType;
use PROJECT\includes\Stmt;

final class Db extends Server {
    private string|null $db = null;
    private string|null $db_user = null;
    private string|null $db_pass = null;
    private mysqli|false $dbc = false;
    private mysqli_stmt|false $mystmt;
    private mysqli_result|false $result;
    private array $data;
    private int $insert_id;
    private int $affected_rows;
    private Msgs $msgs;

    /**
     * function __construct() - create a new mysqli-connection instance and execute a sql statement
     * @param string|null $host=null hostname or IP address
     * @param int|null $port=null port number
     * @param string|null $db=null database name
     * @param int|null $user=null database user
     * @param string|null $pass=null password for database user
     * @param Stmt|null $stmt=null SQL-Statement
     * @param array|null $params=null parameters for SQL-Statement
     * @return void
     */
    public function __construct(string|null $host = null, int|null $port = null, string|null $db = null, string|null $user = null, string|null $pass = null, Stmt|null $stmt = null, array $params = []) {
        try {

            // make the global $msgs object known
            global $msgs;
            $this->msgs = &$msgs;
            // take over params into object
            // ini_get(setting) -> read setting from php.ini
            parent::__construct($host ?? DB_HOST ?? ini_get('mysql.default_host') ?? null, $port ?? DB_PORT ?? ini_get('mysql.default_port') ?? null);
            if($this->isAvailable()) {
                $this->setUser($user ?? DB_USER ?? ini_get('mysql.default_user') ?? null);
                $this->setPass($pass ?? DB_PASS ?? ini_get('mysql.default_password') ?? null);
                // make connection
                $this->connect();
                // set and select sb
                $this->setDb($db ?? DB_NAME ?? null);
                if(!is_null($stmt)){
                    $this->query($stmt, $params);
                }        
            }
        }catch(Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
        }
    }
    private function connect(): void {
        // all errors off
        $tmp = error_reporting();
        error_reporting(0);
        mysqli_report(MYSQLI_REPORT_OFF);
        try {
            // connect db-server
            $this->dbc = new mysqli(hostname: $this->host, username: $this->db_user, password: $this->db_pass, port: $this->port);
            // if connection failed
            if( $this->dbc->connect_errno ) {
                throw new Exception(MSG['db']['danger'][1], MSG['db']['danger'][0] + 1);
            }
        }catch(Exception $e) {
            $this->dbc = false;
            $this->msgs->set($e, MsgType::Danger);
        }finally{
            // error on
            error_reporting($tmp);
        }
    }
    /**
     * function setDb() - set a database
     * @param string|null $db=null database name
     * @return void
     */
    public function setDb(string|null $db):void {
        $this->db = $db;
        try{
            if($this->dbc !== false && !is_null($this->dbc)) {
                $this->dbc->select_db($db);
                if($this->dbc->errno) {
                    throw new Exception(MSG['db']['danger'][2], MSG['db']['danger'][0] + 2);
                }
            }
        }catch(Exception $e) {
            $this->dbc = false;
            $this->msgs->set($e, MsgType::Danger);
        }
    }
    /**
     * function query() - execute a sql statement
     * @param Stmt|null $stmt=null SQL-Statement
     * @param array|null $params=null parameters for SQL-Statement
     * @return void
     */
    public function query(Stmt $stmt, array $params = []):bool {
        try {
            // check db-connection
            if($this->dbc === false)throw new Exception(MSG['db']['danger'][1], MSG['db']['danger'][0] + 1);
            // create new mysqli_stmt object
            $this->mystmt = new mysqli_stmt($this->dbc, $stmt->getSQL());
            if($this->mystmt === false)throw new Exception(MSG['db']['danger'][3], MSG['db']['danger'][0] + 3);
            // if params given and types available
            if( strlen($stmt->getParamTypes()) && count($params)) {
                // if len params and types not equal
                if( strlen($stmt->getParamTypes()) != count($params)){
                    throw new Exception(MSG['db']['danger'][4], MSG['db']['danger'][0] + 4);
                }
                // bind params
                $this->mystmt->bind_param($stmt->getParamTypes(), ...$params);
            }
            // exec statement
            $this->mystmt->execute();
            // if errno
            if($this->mystmt->errno) throw new Exception($this->mystmt->error, $this->mystmt->errno);
            // get data (select) or infos (update/delete) or infos (insert)
            if( str_starts_with(strtolower($stmt->getSQL()), 'select') ){
                // get result
                $this->result = $this->mystmt->get_result();
                // result to data
                $this->data = $this->result->fetch_all(MYSQLI_ASSOC);
                // clean and destroy results
                $this->result->free_result();
            }else if( str_starts_with(strtolower($stmt->getSQL()), 'insert') ){
                // get insert_id
                $this->insert_id = $this->mystmt->insert_id;
            }else if( str_starts_with(strtolower($stmt->getSQL()), 'update') ||
                str_starts_with(strtolower($stmt->getSQL()), 'delete') ){
                // get affected_rows
                $this->affected_rows = $this->mystmt->affected_rows;
            }
            // clean and destroy results
            $this->mystmt->free_result();
            return true;
        }catch(Exception $e) {
            $this->msgs->set($e, MsgType::Danger);
            return false;
        }
    }
    /**
     * function getData() - get data from a select statement
     * @return array data as an associated array
     */
    public function getData():array {
        return $this->data ?? [];
    }
    /**
     * function getInsertId() - get insert_id from the last insert statement
     * @return int|false insert_id
     * */
    public function getInsertId():int|false {
        return $this->insert_id;
    }
    /**
     * function getAffectedRows() - get the affected_rows from the last update/delete statement
     * @return int|false affected_rows
     */
    public function getAffectedRows():int|false {
        return $this->affected_rows ?? false;
    }
    private function setUser(string|null $user):void {
        $this->db_user = $user;
    }
    private function setPass(string|null $pass):void {
        $this->db_pass = $pass;
    }
}