<?php
declare(strict_types=1);

namespace App\Core;

final class Router
{
    private array $routes = [];
    public function get(string $path, callable|array $handler): void { $this->add('GET', $path, $handler); }
    public function post(string $path, callable|array $handler): void { $this->add('POST', $path, $handler); }
    private function add(string $method, string $path, callable|array $handler): void { $this->routes[] = compact('method', 'path', 'handler'); }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method) continue;
            $pattern = preg_replace('#\{([a-zA-Z_][a-zA-Z0-9_]*)\}#', '(?P<$1>[^/]+)', rtrim($route['path'], '/') ?: '/');
            if (preg_match('#^' . $pattern . '$#', rtrim($request->path, '/') ?: '/', $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];
                $result = is_array($handler) ? (new $handler[0]())->{$handler[1]}($request, ...array_values($params)) : $handler($request, ...array_values($params));
                return $result instanceof Response ? $result : Response::html((string) $result);
            }
        }
        return Response::html('<h1>404</h1><p>Sayfa bulunamadı.</p>', 404);
    }
}
