<?php

declare(strict_types=1);

require_once __DIR__ . '/runner.php';

use App\Core\Auth;
use App\Models\User;

echo "\n--- Running Auth Test Suite ---\n";

// Test 1: User Find By Email
$admin = User::findByEmail('admin@crm.com');
TestRunner::assert($admin !== null && $admin['role'] === 'ADMIN', 'Find Admin user by email');

// Test 2: Valid Authentication Attempt
$loginSuccess = Auth::attempt('admin@crm.com', 'password');
TestRunner::assert($loginSuccess === true, 'Successful Auth::attempt with valid credentials');
TestRunner::assert(Auth::check() === true, 'Auth::check returns true after login');
TestRunner::assert(Auth::isAdmin() === true, 'Auth::isAdmin identifies admin role');

// Test 3: Invalid Authentication Attempt
$invalidLogin = Auth::attempt('admin@crm.com', 'wrongpassword');
TestRunner::assert($invalidLogin === false, 'Auth::attempt fails with invalid password');

// Test 4: Logout
Auth::logout();
TestRunner::assert(Auth::check() === false, 'Auth::check returns false after logout');

if (basename($_SERVER['PHP_SELF']) === 'AuthTest.php') {
    TestRunner::summary();
}
