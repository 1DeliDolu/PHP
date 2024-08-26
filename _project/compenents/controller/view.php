<?php
namespace PROJECT\components\home;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\View as BaseView;

class View extends BaseView {
    protected string $title = 'Startseite';

    public function __construct(array $request) {
        parent::__construct($request, __DIR__);
    }
}
