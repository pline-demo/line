<?php
declare(strict_types=1);

namespace App\Core;

final class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $path,
        public readonly array $query,
        public readonly array $body,
        public readonly array $server,
    ) {}

    public static function capture(): self
    {
        $uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
        if ($base !== '' && $base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base)) ?: '/';
        }
        return new self(
            strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'),
            '/' . ltrim(urldecode($uri), '/'),
            $_GET,
            $_POST,
            $_SERVER,
        );
    }

    public function input(string $key, mixed $default = null): mixed { return $this->body[$key] ?? $this->query[$key] ?? $default; }
}
