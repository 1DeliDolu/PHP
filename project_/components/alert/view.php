<?php
namespace PROJECT\components\alert;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\View as BaseView;
use PROJECT\includes\AlertSymbol;

class View extends BaseView {

    protected String $msg = '';
    protected AlertSymbol $symbol;
    protected String $alertID = '';
    protected String $js = '';

    public function __construct(array $request) {
        $this->msg = $request['msg'];
        $this->setSymbol($request['template']);
        if(defined('ALERT_AUTO_HIDE')){
            $this->alertID = 'alert-' . hrtime(true);
            $this->js = "window.setTimeout(()=>{
                $('#" . $this->alertID . " .btn-close').trigger('click');
            }, " . (ALERT_AUTO_HIDE ?? 0) * 1000 .");";
        }
        parent::__construct($request, __DIR__);
    }

    private function setSymbol($type):void {
        $this->symbol = match($type){
            'danger'    => AlertSymbol::Danger,
            'info'      => AlertSymbol::Info,
            'success'   => AlertSymbol::Success,
            'warning'   => AlertSymbol::Warning,
            default     => AlertSymbol::Primary,
        };
    }
}