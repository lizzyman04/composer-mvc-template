<?php

namespace Core;

use Exception;
use Illuminate\Http\Request;

class Router
{
    public static function run(array $routes): void
    {
        $requestUri = $_SERVER['REQUEST_URI'] ?? null;
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);

        if (!$url && $requestUri) {
            $url = parse_url($requestUri, PHP_URL_PATH);
        }

        $url = $url ? rtrim($url, '/') : '/';
        $url = $url === '' ? '/' : $url;

        $route_found = false;
        $request = Request::capture();

        foreach ($routes as $route => $target) {
            $route_pattern = '#^' . preg_replace('/{(\w+)}/', '(?P<$1>[\w-]+)', $route) . '$#';

            if (preg_match($route_pattern, $url, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                if ($route_found) {
                    throw new Exception("Ambiguous route match for URL: {$url}");
                }

                [$controller, $action] = explode('@', $target);

                if (!class_exists($controller)) {
                    throw new Exception("Controller class '{$controller}' not found.");
                }

                $controllerInstance = new $controller();

                if (!method_exists($controllerInstance, $action)) {
                    throw new Exception("Method '{$action}' not found in controller '{$controller}'.");
                }

                $reflection = new \ReflectionMethod($controllerInstance, $action);
                $args = [];

                foreach ($reflection->getParameters() as $param) {
                    $name = $param->getName();
                    $type = $param->getType();

                    if ($type instanceof \ReflectionNamedType && !$type->isBuiltin()) {
                        if (is_a($request, $type->getName())) {
                            $args[] = $request;
                            continue;
                        }
                    }

                    $args[] = $params[$name] ?? null;
                }

                call_user_func_array([$controllerInstance, $action], $args);

                $route_found = true;
                break;
            }
        }

        if (!$route_found) {
            self::handleNotFound();
        }
    }

    private static function handleNotFound(): void
    {
        http_response_code(404);

        $controllerClass = defined('ROUTER_NOT_FOUND_CONTROLLER') ? ROUTER_NOT_FOUND_CONTROLLER : null;
        $method = defined('ROUTER_NOT_FOUND_METHOD') ? ROUTER_NOT_FOUND_METHOD : null;

        if ($controllerClass && $method && class_exists($controllerClass)) {
            $controller = new $controllerClass();

            if (method_exists($controller, $method)) {
                $controller->$method();
                return;
            }
        }

        echo "404 - Oops, it doesn't exist yet! Maybe in the near future.";
    }
}
