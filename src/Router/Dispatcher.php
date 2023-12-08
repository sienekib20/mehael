<?php

namespace Sienekib\Mehael\Router;

use Sienekib\Mehael\Http\Request;
use Sienekib\Mehael\Http\Response;

trait Dispatcher
{
    public function dispatchRoute(object $route, Request $request, Response $response)
    {
        if ($route->middleware != null) {
            if (!str_contains($route->middleware, ':')) {
                echo 'O middleware mal formado';
                exit;
            }
            list($path, $middle) = explode(':', $route->middleware);
            $middleware = "App\\Http\\Middlewares\\" . ucfirst($path) . "\\" . ucfirst($middle);
            if (!class_exists($middleware)) {
                echo "Middleware `$route->middleware` não encontrado";
                exit;
            }
            call_user_func_array([new $middleware, 'handle'], []);
        }

        if (is_callable($callback = $route->action)) {
            return call_user_func($callback, $request);
        }

        if (is_array($callback)) {

            if (!class_exists($callback[0])) {
                echo "Controller `$callback[0]`  não encontrada";
                $response->setStatusCode(404);
                exit;
            }
            $callback[0] = new $callback[0]();
            $controller = get_parent_class($callback[0]);
            if ($controller == false) {
                echo 'A classe controller deve extender o Controller';
                exit;
            }
            $controller = get_parent_class($controller);
            
            $controller = (new $controller());
            if (!method_exists($callback[0], $callback[1])) {
                echo "Método `$callback[1]`  não encontrado";
                $response->setStatusCode(404);
                exit;
            }

            return call_user_func($callback, $request);
        }
    }
}
