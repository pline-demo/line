<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['_csrf'];
    }

    public static function validate(?string $token): void
    {
        $stored = $_SESSION['_csrf'] ?? '';
        if (!is_string($token) || !hash_equals($stored, $token)) {
            throw new RuntimeException('Invalid request token.');
        }
    }
}
