<?php
namespace PROJECT\components\register;

defined("_PROJECT") or header("Location: " . $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/index.php");

use PROJECT\components\base\View as BaseView;
use PROJECT\components\button\Controller as Button;

class View extends BaseView {

    protected string $title = '';
    protected array $buttons = [];
    protected array $scripts = [];
    public function __construct(array $request) {
        // if modal is enabled
        if(array_key_exists('modal', $request) && $request['modal'] == 'true') {
            $request['template'] = ($request['template'] ?? 'default') . '.modal';
        }
        // get title
        $this->title = $request['title'] ?? MSG['modal']['defaulttitle'];
        // create buttons and js-scripts
        for($i = 0; $i < count($request['buttons']); $i++) {
            $btn = new Button($request['buttons'][$i]);
            $this->buttons[] = $btn->show();
        }
        // generate template
        parent::__construct($request, __DIR__);
    }

}