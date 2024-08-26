<?php
namespace PROJECT\components\statistics;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\Controller as BaseController;

class Controller extends BaseController {
    private View $view;

    public function show() {
        $this->view = new View($this->request);
        return $this->view->show();
    }
}
