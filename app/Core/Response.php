<?php
declare(strict_types=1);

namespace App\Core;

final class Response
{
    private array $headers = [];
    private int $status = 200;

    public function __construct(private string $content = '') {}
    public static function html(string $content, int $status = 200): self { $r = new self($content); $r->status = $status; return $r; }
    public static function redirect(string $url, int $status = 302): self { $r = new self(); $r->status = $status; $r->headers['Location'] = $url; return $r; }
    public function send(): void { http_response_code($this->status); foreach ($this->headers as $n => $v) header($n . ': ' . $v); echo $this->content; }
}
