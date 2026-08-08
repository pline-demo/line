<?php
declare(strict_types=1);

namespace App\Core;

final class Application
{
    private Router $router;

    public function __construct(private readonly string $root)
    {
        $this->router = new Router();
        Container::set('app', $this);
        Container::set('router', $this->router);
    }

    public function get(string $path, callable|array $handler): void
    {
        $this->router->get($path, $handler);
    }

    public function post(string $path, callable|array $handler): void
    {
        $this->router->post($path, $handler);
    }

    public function run(): void
    {
        $request = Request::capture();
        $response = $this->router->dispatch($request);
        $response->send();
    }
}
