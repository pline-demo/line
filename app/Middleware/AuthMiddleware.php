<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

final class AuthMiddleware
{
    public function handle(Request $request, callable $next): Response
    {
        if (!Session::get('auth.user_id')) {
            return Response::redirect('/' . trim((string) config('app.admin_route', 'cmyonetim-x7p9'), '/') . '/login');
        }

        return $next($request);
    }
}
