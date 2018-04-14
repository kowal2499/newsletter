<?php

namespace Newsletter\Core;

use Newsletter\Core\Router;
use Newsletter\Core\Request;

class App
{
    public function __construct()
    {
        $router = new Router();
        $response = $router->route(new Request());
        echo $response;
    }
}
