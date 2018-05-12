<?php

namespace Newsletter\Core;

class App
{
    public function __construct()
    {
        $router = new \Newsletter\Core\Router();
        $response = $router->route(new \Newsletter\Core\Request());
    }
}
