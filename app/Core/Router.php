<?php

namespace Newsletter\Core;

class Router
{
    private $routeMap;

    private static $regexPatters = [
        'number' => '\d+',
        'string' => '\w',
    ];

    public function __construct()
    {
        $json = file_get_contents(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR  . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'routes.json'
        );
        $this->routeMap = json_decode($json, true);
    }

    public function route(Request $request)
    {
        $path = $request->getPath();
        foreach ($this->routeMap as $route => $info) {
            $regexRoute = $this->getRegexRoute($route, $info);
            if (preg_match("@^/$regexRoute$@", $path)) {
                return $this->executeController(
                    $route,
                    $path,
                    $info,
                    $request
                );
            }
        }
        $errorController = new \Newsletter\Controllers\ErrorController($request);
        return $errorController->notFound();
    }

    private function getRegexRoute(string $route, array $info): string
    {
        if (isset($info['params'])) {
            foreach ($info['params'] as $name => $type) {
                $route = str_replace(
                    ':' . $name,
                    self::$regexPatters[$type],
                    $route
                );
            }
        }
        return $route;
    }

    private function extractParams(string $route, string $path): array
    {
        $params = [];
        $pathParts = explode('/', $path);
        $routeParts = explode('/', $route);
        foreach ($routeParts as $key => $routePart) {
            if (strpos($routePart, ':') === 0) {
                $name = substr($routePart, 1);
                $params[$name] = $pathParts[$key+1];
            }
        }
        return $params;
    }

    private function executeController(string $route, string $path, array $info, Request $request)
    {
        $controllerName = '\Newsletter\Controllers\\' . $info['controller'] . 'Controller';
        $controller = new $controllerName($request);
        // czy dla bieżącego kontrolera jest wymagany zalogowany użytkownik?
        if (isset($info['login']) && $info['login']) {
            if ($request->getCookies()->has('user')) {
                $customerId = $request->getCookies()->get('user');
                $controller->setUserId($customerId);
            } else {
                // przekieruj do strony logowania
                Tools::redirect('login');
                // $loginController = new \Newsletter\Controllers\UserController($request);
                // return $loginController->login();
            }
        }
        $params = $this->extractParams($route, $path);
        return call_user_func_array(
            [$controller, $info['method']],
            $params
        );
    }
}
