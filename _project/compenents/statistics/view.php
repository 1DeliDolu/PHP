<?php
namespace PROJECT\components\statistics;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\View as BaseView;

class View extends BaseView {
    protected string $title = 'Statistik';
    protected array $logins = [];
    protected array $logouts = [];

    public function __construct(array $request) {
        parent::__construct($request, __DIR__);
        $model = new Model($request);
        $this->logins = $model->getLogins($request['user_id']);
        $this->logouts = $model->getLogouts($request['user_id']);
    }
}
