<?php

declare(strict_types=1);

/**
 * Lead Management CRM Front Controller
 */

define('BASE_PATH', dirname(__DIR__));

// PSR-4 Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Load Helper Functions
require_once BASE_PATH . '/app/Helpers/functions.php';

// Initialize Session
\App\Core\Session::start();

// Handle Request
try {
    $request = new \App\Core\Request();
    $router = new \App\Core\Router($request);

    // Register Routes
    require_once BASE_PATH . '/routes/web.php';
    require_once BASE_PATH . '/routes/api.php';

    // Dispatch Request
    $router->dispatch();
} catch (\Throwable $e) {
    $isApi = str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api') || 
             (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

    if ($isApi) {
        json_response([
            'success' => false,
            'error' => $e->getMessage(),
            'code' => $e->getCode() ?: 500
        ], $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 500);
    } else {
        http_response_code(500);
        if (file_exists(BASE_PATH . '/views/errors/500.php')) {
            view('errors.500', ['exception' => $e]);
        } else {
            echo "<h1>500 Internal Server Error</h1>";
            echo "<p>" . e($e->getMessage()) . "</p>";
        }
    }
}
