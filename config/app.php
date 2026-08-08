<?php

return [
    'name' => 'PERLINA',
    'env' => getenv('APP_ENV') ?: 'production',
    'debug' => (getenv('APP_DEBUG') ?: 'false') === 'true',
    'url' => rtrim(getenv('APP_URL') ?: 'http://localhost', '/'),
    'admin_path' => trim(getenv('ADMIN_PATH') ?: 'cmyonetim-x7p9', '/'),
    'session_lifetime' => 7200,
    'db' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_DATABASE') ?: 'perlina',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset' => 'utf8mb4',
    ],
    'uploads' => [
        'path' => __DIR__ . '/../storage/uploads',
        'max_size' => 5242880,
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'webp', 'svg'],
        'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'],
    ],
];
