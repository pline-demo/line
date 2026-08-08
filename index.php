<?php
declare(strict_types=1);

use App\Core\Application;
use App\Core\Config;
use App\Core\ErrorHandler;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

/**
 * PERLINA application front controller.
 * All public requests enter through this file and are bootstrapped here.
 */

const PERLINA_ROOT = __DIR__;

require PERLINA_ROOT . '/vendor/autoload.php';

Config::load(PERLINA_ROOT . '/config');

ErrorHandler::register(
    (bool) Config::get('app.debug', false),
    PERLINA_ROOT . '/storage/logs'
);

Session::start([
    'name' => Config::get('app.session_name', 'perlina_session'),
    'lifetime' => (int) Config::get('app.session_lifetime', 7200),
    'secure' => (bool) Config::get('app.session_secure', false),
    'httponly' => true,
    'samesite' => 'Lax',
]);

$app = new Application(PERLINA_ROOT);

require PERLINA_ROOT . '/routes/web.php';

try {
    $request = Request::capture();
    $response = $app->handle($request);

    if (!$response instanceof Response) {
        throw new RuntimeException('Application did not return a valid response.');
    }

    $response->send();
} catch (Throwable $exception) {
    ErrorHandler::handleException($exception);
}
