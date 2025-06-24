<?php

namespace App\Core;

use App\Middleware\Middleware;

class Router
{
    protected static array $routes = [];

    protected static function add(string $method, string $uriPattern, string $controller): static
    {
        static::$routes[] = [
            'uri' => $uriPattern,
            'controller' => $controller,
            'method' => strtoupper($method),
            'middleware' => null
        ];
        return new static();
    }

    public static function get(string $uri, string $controller): static
    {
        return static::add("GET", $uri, $controller);
    }
    public static function post(string $uri, string $controller): static
    {
        return static::add("POST", $uri, $controller);
    }
    public static function delete(string $uri, string $controller): static
    {
        return static::add("DELETE", $uri, $controller);
    }
    public static function patch(string $uri, string $controller): static
    {
        return static::add("PATCH", $uri, $controller);
    }
    public static function put(string $uri, string $controller): static
    {
        return static::add("PUT", $uri, $controller);
    }

    public function only(array|string $middleware): static
    {
        static::$routes[array_key_last(static::$routes)]['middleware'] = (array) $middleware;
        return $this;
    }


    public static function route(string $uri, string $method): void
    {
        foreach (static::$routes as $route) {
            $pattern = "@^" . preg_replace("/\{[a-zA-Z_]+\}/", "([a-zA-Z0-9_-]+)", $route['uri']) . "$@";
            if (preg_match($pattern, $uri, $matches) && strtoupper($method) === $route['method']) {
                array_shift($matches);
                Middleware::resolve($route['middleware']);

                static::invokeController($route['controller'], $matches);
                return;
            }
        }

        static::abort();
    }

    protected static function invokeController(string $controllerString, array $params = []): mixed
    {
        if (!str_contains($controllerString, '@')) {
            $path = base_path("app/Controllers/" . $controllerString);
            if (!file_exists($path)) {
                throw new \Exception("Controller file $path not found");
            }

            return require $path;
        }

        [$controllerName, $method] = explode('@', $controllerString);
        $controllerClass = "App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller $controllerClass not found");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new \Exception("Method $method not found in $controllerClass");
        }

        return call_user_func_array([$controller, $method], $params);
    }

    public static function previousUrl(): string
    {
        return $_SERVER['HTTP_REFERER'] ?? '/';
    }

    protected static function abort(int $code = 404): void
    {
        http_response_code($code);
        require base_path("app/views/errors/{$code}.php");
        die();
    }
}
