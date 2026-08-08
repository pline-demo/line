<?php
declare(strict_types=1);

use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Core\Application;

/** @var Application $app */
$adminPrefix = trim((string) $app->config('app.admin_route', 'cmyonetim-x7p9'), '/');

$app->get('/', fn() => $app->view('public.home', ['title' => 'PERLINA']));
$app->get('/' . $adminPrefix . '/login', [AuthController::class, 'showLogin']);
$app->post('/' . $adminPrefix . '/login', [AuthController::class, 'login']);
$app->post('/' . $adminPrefix . '/logout', [AuthController::class, 'logout']);
$app->get('/' . $adminPrefix, [DashboardController::class, 'index'], ['auth']);
$app->get('/' . $adminPrefix . '/dashboard', [DashboardController::class, 'index'], ['auth']);
