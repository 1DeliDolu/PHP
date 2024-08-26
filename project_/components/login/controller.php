<?php
namespace PROJECT\components\login;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\Controller as BaseController;
class Controller extends BaseController {

    private View $view;
    private Model $model;
    public function show() {
        $this->view = new View($this->request);
        return $this->view->show();
    }
    public function verify():array {
        $this->model = new Model($this->request);
        return $this->model->verify();
    }
    public function logout():array {
        $this->model = new Model($this->request);
        return $this->model->logout();
    }
}