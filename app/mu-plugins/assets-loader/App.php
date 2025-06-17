<?php

namespace AssetsLoader;

use App\CommonApp;
use AssetsLoader\Managers\CommonManager;

class App extends CommonApp
{
    public function initialize(): void
    {
        (new CommonManager())->initialize();
    }
}
