<?php

namespace App\Core;

use Throwable;

final class ErrorHandler
{
    public static function register(bool $debug): void
    {
        set_exception_handler(function (Throwable $e) use ($debug) {
            http_response_code(500); error_log($e);
            if ($debug) { echo '<pre>' . htmlspecialchars((string) $e) . '</pre>'; return; }
            $content = '<section class="error"><h1>Beklenmeyen bir sorun oluştu</h1><p>Ekibimiz bilgilendirildi.</p></section>'; require __DIR__ . '/../../resources/views/layouts/public.php';
        });
    }
}
