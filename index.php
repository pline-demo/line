<?php
declare(strict_types=1);

use App\Core\Application;
use App\Core\Config;
use App\Core\ErrorHandler;

require __DIR__ . '/vendor/autoload.php';

$root = __DIR__;
Config::load($root . '/config');
ErrorHandler::register((bool) Config::get('app.debug', false), $root . '/storage/logs');

$app = new Application($root);
require $root . '/routes/web.php';

$app->run();
