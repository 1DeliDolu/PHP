<?php
namespace PROJECT\components\menu;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\View as BaseView;
use PROJECT\classes\Session;

class View extends BaseView {

    private Model $model;
    protected bool $login = false;
    public function __construct(array $request) {
        $this->model = new Model($this->request);
        $this->login = $this->model->isLoggedIn();
        parent::__construct($request, __DIR__);
    }
}