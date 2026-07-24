<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

class Auth
{
    private static ?array $userCache = null;

    /**
     * Attempt login with credentials
     */
    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        self::login($user);
        return true;
    }

    /**
     * Log in a user instance
     */
    public static function login(array $user): void
    {
        Session::regenerate(true);
        Session::set('user_id', (int) $user['id']);
        Session::set('user_role', $user['role']);
        self::$userCache = $user;
    }

    /**
     * Log out current user
     */
    public static function logout(): void
    {
        Session::remove('user_id');
        Session::remove('user_role');
        Session::destroy();
        self::$userCache = null;
    }

    /**
     * Get current authenticated user
     */
    public static function user(): ?array
    {
        if (self::$userCache !== null) {
            return self::$userCache;
        }

        $userId = Session::get('user_id');
        if (!$userId) {
            return null;
        }

        $user = User::find((int) $userId);
        if (!$user) {
            self::logout();
            return null;
        }

        self::$userCache = $user;
        return self::$userCache;
    }

    /**
     * Check if user is authenticated
     */
    public static function check(): bool
    {
        return self::user() !== null;
    }

    /**
     * Get current user ID
     */
    public static function id(): ?int
    {
        $user = self::user();
        return $user ? (int) $user['id'] : null;
    }

    /**
     * Check if user is Admin
     */
    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user && $user['role'] === 'ADMIN';
    }

    /**
     * Check if user is Member
     */
    public static function isMember(): bool
    {
        $user = self::user();
        return $user && $user['role'] === 'MEMBER';
    }
}
