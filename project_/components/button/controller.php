<?php
namespace PROJECT\components\button;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\Controller as BaseController;
use PROJECT\components\button\View as ButtonView;
class Controller extends BaseController {

    private ButtonView $view;
    public function show() {
        $this->view = new ButtonView($this->request);
        return $this->view->show();
    }
}