<?php
namespace PROJECT\components\register;

defined("_PROJECT") or header("Location: /index.php");

use PROJECT\components\base\View as BaseView;

class View extends BaseView {
    protected string $title = 'Registrierung';

    public function __construct(array $request) {
        parent::__construct($request, __DIR__);
    }
}
