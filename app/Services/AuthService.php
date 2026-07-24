<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Core\Validator;
use Exception;

class AuthService
{
    public function login(array $credentials): array
    {
        $validator = new Validator($credentials);
        if (!$validator->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ])) {
            return [
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ];
        }

        if (!Auth::attempt($credentials['email'], $credentials['password'])) {
            return [
                'success' => false,
                'errors' => ['email' => ['Invalid email or password credentials.']],
                'message' => 'Invalid credentials'
            ];
        }

        return [
            'success' => true,
            'user' => Auth::user(),
            'message' => 'Login successful'
        ];
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
