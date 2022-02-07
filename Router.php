<?php

namespace alexandermagera\phpmvc;

use alexandermagera\phpmvc\exception\NotFoundException;

class Router
{
    protected array $routes = [];

    public function addGetRoute($path, $callback)
    {
        $this->routes['GET'][strtolower($path)] = $callback;
    }

    public function addPostRoute($path, $callback)
    {
        $this->routes['POST'][strtolower($path)] = $callback;
    }

    public function resolve()
    {
        $path = strtolower(Request::getPath());
        $method = Request::method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        };
        if (is_array($callback)) {
            /** @var \alexandermagera\phpmvc\Controller  $controller */
            $controller=new $callback[0]();
            $controller->action=$callback[1];
            $callback[0]=Application::$app->controller = $controller;

            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
}
        }
        return call_user_func($callback);
    }
}