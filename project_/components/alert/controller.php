<?php
namespace PROJECT\components\alert;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\Controller as BaseController;
class Controller extends BaseController {

    private View $view;
    public function show() {
        $this->view = new View($this->request);
        return $this->view->show();
    }
}