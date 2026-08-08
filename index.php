<?php

declare(strict_types=1);

use App\Core\Application;
use App\Core\ErrorHandler;

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/app.php';
ErrorHandler::register((bool) $config['debug']);

$app = new Application($config);
require __DIR__ . '/routes/web.php';
$app->run();
