<?php
namespace PROJECT\components\content;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\components\base\Model as BaseModel;
use PROJECT\includes\MsgType;
use PROJECT\includes\Stmt;

class Model extends BaseModel {

    public function getUserStatistics():array {
        try{
            $data = [];
            $this->db->query(Stmt::getUserStatistics, [$this->session->get('login.id')]);
            $data =  $this->db->getData();
        }catch(Exception $e){
            $this->msgs->set($e);
        }finally{
            return $data;
        }
    }

    public function getDirectory(String|null $dir = null):array {
        try{
            
            if(is_null($dir)){
                $dir = $_SERVER['DOCUMENT_ROOT'];
                $directory = ["<ul class=\"rootdir\">"];
            }
            if(!$handle = opendir($dir))throw new Exception();
            $files = [];
            while (false!== ($entry = readdir($handle))) {
                if ($entry!= "." && $entry!= "..") {
                    if(is_dir("{$dir}/{$entry}")){
                        $directory[] = "<li class=\"subdir\">{$entry}";
                        if ($entry != "tmp") {
                            $directory[] = "<ul>";
                            $directory[] = implode('', $this->getDirectory("{$dir}/{$entry}"));
                            $directory[] = "</ul>";
                        }else{
                            $directory[] = "<span class=\"smalltext\"> (ausgeblendet)</span>";
                        }
                        $directory[] = "</li>";
                    }elseif(is_file("{$dir}/{$entry}")){
                        $fileType = substr($entry, strrpos($entry, '.') + 1);
                        $files[] = "<li class=\"file {$fileType}\">{$entry}</li>";;
                    }
                }
            }
            $directory = array_merge($directory ?? [], $files);
            if($dir == $_SERVER['DOCUMENT_ROOT']){
                $directory[] = "</ul>";
            }
        }catch(Exception $e){
            $this->msgs->set($e);
        }finally{
            return $directory;
        }
    }
}