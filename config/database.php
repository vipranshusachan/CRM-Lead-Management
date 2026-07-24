<?php

// Environment variable reader with fallback
$env = function(string $key, string $default = '') {
    return $_ENV[$key] ?? getenv($key) ?: $default;
};

return [
    'host'     => $env('DB_HOST', '127.0.0.1'),
    'port'     => (int) $env('DB_PORT', '3306'),
    'database' => $env('DB_DATABASE', 'lead_crm'),
    'username' => $env('DB_USERNAME', 'root'),
    'password' => $env('DB_PASSWORD', ''),
    'charset'  => 'utf8mb4',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
];
