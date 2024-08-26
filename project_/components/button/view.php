<?php
namespace PROJECT\components\button;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\View as BaseView;

class View extends BaseView {

    public function __construct(array $request) {
        parent::__construct($request, __DIR__);
    }
}