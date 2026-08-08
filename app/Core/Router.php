<?php

namespace App\Core;

final class Router
{
    private array $routes = [];
    public function add(string $method, string $pattern, array|callable $handler): void { $this->routes[] = [$method, '#^' . preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_-]*)\}#', '(?P<$1>[^/]+)', rtrim($pattern, '/') ?: '/') . '$#', $handler]; }
    public function get(string $p, array|callable $h): void { $this->add('GET', $p, $h); }
    public function post(string $p, array|callable $h): void { $this->add('POST', $p, $h); }
    public function dispatch(Request $request, Application $app): string
    {
        foreach ($this->routes as [$method, $regex, $handler]) {
            if ($method === $request->method() && preg_match($regex, rtrim($request->path(), '/') ?: '/', $m)) {
                $params = array_filter($m, 'is_string', ARRAY_FILTER_USE_KEY);
                if (is_callable($handler)) return (string) $handler($request, $app, $params);
                return (string) $app->call($handler[0], $handler[1], $params);
            }
        }
        Response::status(404); return $app->view()->render('errors/404', [], 'public');
    }
}
