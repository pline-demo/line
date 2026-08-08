<?php

namespace App\Core;

final class Session
{
    public static function start(int $lifetime): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) return;
        ini_set('session.use_strict_mode', '1');
        session_set_cookie_params(['lifetime'=>0,'path'=>'/','httponly'=>true,'samesite'=>'Lax','secure'=>!empty($_SERVER['HTTPS'])]);
        session_start();
        if (isset($_SESSION['last_seen']) && time() - (int) $_SESSION['last_seen'] > $lifetime) self::destroy();
        $_SESSION['last_seen'] = time();
    }
    public static function regenerate(): void { session_regenerate_id(true); }
    public static function get(string $key, mixed $default = null): mixed { return $_SESSION[$key] ?? $default; }
    public static function put(string $key, mixed $value): void { $_SESSION[$key] = $value; }
    public static function flash(string $key, ?string $value = null): ?string { if ($value !== null) { $_SESSION['_flash'][$key] = $value; return null; } $v = $_SESSION['_flash'][$key] ?? null; unset($_SESSION['_flash'][$key]); return $v; }
    public static function destroy(): void { $_SESSION = []; if (session_status() === PHP_SESSION_ACTIVE) session_destroy(); }
}
