<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

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

require_once BASE_PATH . '/app/Helpers/functions.php';

class TestRunner
{
    private static int $passed = 0;
    private static int $failed = 0;

    public static function assert(bool $condition, string $testName): void
    {
        if ($condition) {
            self::$passed++;
            echo " [PASS] - {$testName}\n";
        } else {
            self::$failed++;
            echo " [FAIL] - {$testName}\n";
        }
    }

    public static function summary(): void
    {
        echo "\n==========================================\n";
        echo "TEST SUMMARY:\n";
        echo " Passed: " . self::$passed . "\n";
        echo " Failed: " . self::$failed . "\n";
        echo " Total:  " . (self::$passed + self::$failed) . "\n";
        echo "==========================================\n";

        if (self::$failed > 0) {
            exit(1);
        }
    }
}
