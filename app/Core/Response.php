<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    /**
     * Render HTML view
     */
    public function render(string $view, array $data = [], int $statusCode = 200): void
    {
        http_response_code($statusCode);
        view($view, $data);
        exit;
    }

    /**
     * Send JSON response
     */
    public function json(mixed $data, int $statusCode = 200): void
    {
        json_response($data, $statusCode);
    }

    /**
     * Redirect response
     */
    public function redirect(string $path): void
    {
        redirect($path);
    }
}
