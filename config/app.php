<?php
return [
    'name' => 'PERLINA',
    'env' => getenv('APP_ENV') ?: 'production',
    'debug' => filter_var(getenv('APP_DEBUG') ?: false, FILTER_VALIDATE_BOOL),
    'url' => rtrim(getenv('APP_URL') ?: '', '/'),
    'admin_route' => trim(getenv('ADMIN_ROUTE') ?: 'cmyonetim-x7p9', '/'),
];
