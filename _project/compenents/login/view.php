<?php
namespace PROJECT\components\login;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\View as BaseView;

class View extends BaseView {
    protected string $title = 'Login';

    public function __construct(array $request) {
        parent::__construct($request, __DIR__);
    }
}
