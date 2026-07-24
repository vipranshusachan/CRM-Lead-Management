<?php

/**
 * Helper Functions
 */

if (!function_exists('env')) {
    /**
     * Get environment variable with default fallback
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return null;
        }

        return $value;
    }
}

if (!function_exists('e')) {
    /**
     * Escape HTML special characters for XSS protection
     */
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('base_url')) {
    /**
     * Get base URL of the application
     */
    function base_url(string $path = ''): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $baseFolder = rtrim(dirname($scriptName), '/\\');
        $path = ltrim($path, '/');
        return $path ? $baseFolder . '/' . $path : ($baseFolder ?: '/');
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a specific path
     */
    function redirect(string $path): void
    {
        $url = str_starts_with($path, 'http://') || str_starts_with($path, 'https://')
            ? $path
            : base_url($path);
        
        header("Location: {$url}");
        exit;
    }
}

if (!function_exists('view')) {
    /**
     * Render a view template
     */
    function view(string $template, array $data = []): void
    {
        extract($data);
        $file = __DIR__ . '/../../views/' . str_replace('.', '/', $template) . '.php';

        if (!file_exists($file)) {
            throw new Exception("View template [{$template}] not found at {$file}");
        }

        require $file;
    }
}

if (!function_exists('json_response')) {
    /**
     * Return JSON response
     */
    function json_response(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get or generate CSRF token
     */
    function csrf_token(): string
    {
        return \App\Core\Session::csrfToken();
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate CSRF hidden input HTML
     */
    function csrf_field(): string
    {
        $token = csrf_token();
        return '<input type="hidden" name="_token" value="' . e($token) . '">';
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value from session
     */
    function old(string $key, mixed $default = ''): mixed
    {
        return \App\Core\Session::getOldInput($key, $default);
    }
}

if (!function_exists('flash')) {
    /**
     * Get or set flash message
     */
    function flash(string $key, mixed $message = null): mixed
    {
        if ($message !== null) {
            \App\Core\Session::setFlash($key, $message);
            return null;
        }
        return \App\Core\Session::getFlash($key);
    }
}
