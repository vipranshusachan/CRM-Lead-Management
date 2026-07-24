<?php

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/app/Helpers/functions.php';

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require $file;
});

$_SERVER['REQUEST_URI'] = '/PROJECT%20A/';
$_SERVER['SCRIPT_NAME'] = '/PROJECT A/public/index.php';
$_SERVER['REQUEST_METHOD'] = 'GET';

$request = new \App\Core\Request();
echo "Parsed URI for '/PROJECT%20A/': [" . $request->getUri() . "]\n";

$_SERVER['REQUEST_URI'] = '/PROJECT%20A/login';
$_SERVER['SCRIPT_NAME'] = '/PROJECT A/public/index.php';
$request2 = new \App\Core\Request();
echo "Parsed URI for '/PROJECT%20A/login': [" . $request2->getUri() . "]\n";
