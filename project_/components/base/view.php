<?php
namespace PROJECT\components\base;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use Exception;
use PROJECT\classes\Msgs;
use PROJECT\includes\Msgs as Msg;   // alias, because Msgs already in use
use PROJECT\includes\MsgType;

abstract class View {
    protected Msgs $msgs;
    protected array $request = [];
    // path for html/php templates
    protected string|null $tmplpath = null;
    protected string|null $tmpl = null;
    protected string $html = '';
    public function __construct(array $request, string $componentPath) {
        global $msgs;
        $this->msgs = &$msgs;
        $this->request = $request;
        $this->setTmplPath($componentPath);
        $this->setTmpl();
    }
    public function show():string {
        $this->render();
        return $this->html;
    }
    protected function setTmplPath(string $componentPath):void {
        try{
            // join path
            $this->tmplpath = $componentPath . '/tmpl/';
            // check if path exists
            if(!file_exists($this->tmplpath)) {
                $this->msgs->set(new Exception( sprintf(MSG['view']['danger'][1], $this->tmplpath), MSG['view']['danger'][0] + 1), MsgType::Danger);
            }
        }catch(Exception $e){
            $this->tmplpath = null;
            $this->msgs->set($e, MsgType::Danger);
        }
    }
    protected function setTmpl():void {
        try {
            $tmpl = $this->request['template'] ?? 'default';
            if(file_exists($this->tmplpath . $tmpl. '.php')) {
                $this->tmpl = $tmpl;
            }elseif(file_exists($this->tmplpath . 'default.php')) {
                $this->tmpl = 'default';
            }else{
                throw new Exception( sprintf(MSG['view']['danger'][2], $this->tmpl), MSG['view']['danger'][0] + 2);
            }            
        }catch(Exception $e){
            $this->tmpl = null;
            $this->msgs->set($e, MsgType::Danger);
        }
    }
    protected function render():void {
        if(!is_null($this->tmplpath) && !is_null($this->tmpl)) {
            // stop all prints/outputs -> start "O"utput "B"uffering
            ob_start();
            // include template
            include $this->tmplpath . $this->tmpl. '.php';
            // get output
            $this->html = ob_get_clean();
        } else {
            $this->html = '';
        }
    }
}