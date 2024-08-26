<?php
namespace PROJECT\components\login;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\Controller as BaseController;

class Controller extends BaseController {
    private Model $model;
    private View $view;

    public function show() {
        $this->view = new View($this->request);
        return $this->view->show();
    }
    
    public function validateusername(): array {
        $this->model = new Model($this->request);
        return $this->model->validateusername();
    }

    public function validatepassword(): array {
        $this->model = new Model($this->request);
        return $this->model->validatepassword();
    }

    public function login(): array {
        $this->model = new Model($this->request);
        return $this->model->login();
    }
}
