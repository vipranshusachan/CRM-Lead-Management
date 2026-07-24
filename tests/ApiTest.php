<?php

declare(strict_types=1);

require_once __DIR__ . '/runner.php';

use App\Core\Auth;
use App\Models\User;

echo "\n--- Running REST API Test Suite ---\n";

// Test 1: User authentication check for API
$user = User::findByEmail('admin@crm.com');
TestRunner::assert($user !== null, 'API User existence check');

// Test 2: Role check
Auth::attempt('admin@crm.com', 'password');
TestRunner::assert(Auth::isAdmin() === true, 'Admin API authorization privilege verified');

// Test 3: Member Role check
Auth::attempt('sarah@crm.com', 'password');
TestRunner::assert(Auth::isMember() === true, 'Member API authorization privilege verified');

if (basename($_SERVER['PHP_SELF']) === 'ApiTest.php') {
    TestRunner::summary();
}
