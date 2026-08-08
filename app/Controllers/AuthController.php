<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
final class AuthController{public function __construct(private AuthService $auth){} public function login(Request $request):Response{if(!Csrf::verify((string)$request->input('_token'))) return Response::status(419);$ok=$this->auth->attempt(trim((string)$request->input('identity')), (string)$request->input('password'));return $ok?Response::redirect('/'.trim((string)config('app.admin_route'),'/')):Response::redirect('/'.trim((string)config('app.admin_route'),'/').'?error=1');} public function logout(Request $request):Response{if(!Csrf::verify((string)$request->input('_token'))) return Response::status(419);$this->auth->logout();return Response::redirect('/');}}