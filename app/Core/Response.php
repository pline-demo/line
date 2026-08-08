<?php

namespace App\Core;

final class Response
{
    public static function redirect(string $url): never { header('Location: ' . $url, true, 302); exit; }
    public static function status(int $code): void { http_response_code($code); }
}
