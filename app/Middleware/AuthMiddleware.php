<?php
declare(strict_types=1);
namespace App\Middleware;
use App\Core\Response;
use App\Core\Session;
final class AuthMiddleware{public function handle(): ?Response{if(!Session::get('auth.user_id')) return Response::redirect('/'); return null;}}