<?php
declare(strict_types=1);
namespace App\Middleware;
use App\Core\Response;
use App\Services\PermissionService;
final class PermissionMiddleware{public function __construct(private PermissionService $permissions){} public function handle(string $permission): ?Response{if(!$this->permissions->allows($permission)) return Response::forbidden(); return null;}}