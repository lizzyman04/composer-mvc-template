<?php

namespace Core;

use Exception;
use Illuminate\Http\Request;

class Router
{
    public static function run($routes)
    {
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

        if ($url === null) {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        $url = rtrim($url, '/') === '' ? '/' : rtrim($url, '/');
        $route_found = false;

        $request = Request::capture();

        foreach ($routes as $route => $dataset) {
            $route_pattern = '#^' . preg_replace('/{(\w+)}/', '(?P<$1>[\w-]+)', $route) . '$#';

            if (preg_match($route_pattern, $url, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if ($route_found) {
                    throw new Exception("Ambiguous route match for URL: {$url}");
                }

                [$controller, $action] = explode('@', $dataset);

                if (class_exists($controller)) {
                    $controller_instance = new $controller();

                    if (method_exists($controller_instance, $action)) {
                        $reflection = new \ReflectionMethod($controller_instance, $action);
                        $parameters = $reflection->getParameters();

                        $args = [];
                        foreach ($parameters as $parameter) {
                            $name = $parameter->getName();
                            $type = $parameter->getType();

                            if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                                $className = $type->getName();
                                if (is_a($request, $className)) {
                                    $args[] = $request;
                                    continue;
                                }
                            }

                            $args[] = $params[$name] ?? null;
                        }

                        call_user_func_array([$controller_instance, $action], $args);
                    } else {
                        throw new Exception("Action $action not found in $controller");
                    }
                } else {
                    throw new Exception("Class $controller not found");
                }

                $route_found = true;
            }
        }

        if (!$route_found) {
            include('404.php');
            exit();
        }
    }
}