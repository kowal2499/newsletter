<?php

    use Newsletter\Core\Router;
    use Newsletter\Core\Request;
    
    require_once __DIR__ . '/vendor/autoload.php';

    $router = new Router();
    $response = $router->route(new Request());
    echo $response;
