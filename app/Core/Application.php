<?php

namespace App\Core;

use App\Services\MaintenanceService;
use ReflectionClass;

final class Application
{
    public Router $router; public Request $request; private Config $config; private Database $db; private View $view;
    public function __construct(array $config)
    {
        $this->config = new Config($config); Session::start((int) $this->config->get('session_lifetime', 7200));
        $this->router = new Router(); $this->request = new Request(); $this->db = new Database($this->config); $this->view = new View();
    }
    public function config(): Config { return $this->config; } public function db(): Database { return $this->db; } public function view(): View { return $this->view; }
    public function call(string $class, string $method, array $params = []): mixed
    {
        $ref = new ReflectionClass($class); $controller = $ref->newInstance($this); return $controller->$method(...array_values($params));
    }
    public function run(): void
    {
        if ((new MaintenanceService($this))->enabled() && !str_starts_with($this->request->path(), '/' . $this->config->get('admin_path'))) { Response::status(503); echo $this->view->render('errors/maintenance'); return; }
        echo $this->router->dispatch($this->request, $this);
    }
}
