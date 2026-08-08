<?php

namespace App\Core;

final class View
{
    public function render(string $view, array $data = [], string $layout = 'public'): string
    {
        extract($data, EXTR_SKIP);
        ob_start(); require __DIR__ . '/../../resources/views/' . $view . '.php'; $content = ob_get_clean();
        ob_start(); require __DIR__ . '/../../resources/views/layouts/' . $layout . '.php'; return ob_get_clean();
    }
}
