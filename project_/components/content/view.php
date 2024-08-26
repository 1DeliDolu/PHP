<?php
namespace PROJECT\components\content;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\classes\Session;
use PROJECT\components\base\View as BaseView;

class View extends BaseView {

    private Model $model;
    protected array $userStatistics = [];
    protected array $directory = [];
    public function __construct(array $request) {
        parent::__construct($request, __DIR__);
    }

    public function getUserStatistics():void {
        $this->model = new Model($this->request);
        $this->userStatistics = $this->model->getUserStatistics();        
    }

    public function getDirectory():void {
        $this->model = new Model($this->request);
        $this->directory = $this->model->getDirectory();
    }
}