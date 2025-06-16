<?php

namespace Blog;

use App\CommonApp;
use Blog\Managers\AjaxManager;
use Blog\Managers\CptManager;

class App extends CommonApp
{
    public function initialize(): void
    {
        (new CptManager())->initialize();
        (new AjaxManager())->initialize();
    }
}
