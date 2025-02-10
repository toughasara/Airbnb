<?php

class Router {
    

    private $routes = [];

    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        if (array_key_exists($uri, $this->routes)) {
            $controller = $this->routes[$uri]['controller'];
            $action = $this->routes[$uri]['action'];
            $controllerInstance = new $controller();
            $controllerInstance->$action();
        } else {
            echo "404 - Page not found";
        }
    }
}

$router = new Router();
$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/user', 'UserController', 'index');