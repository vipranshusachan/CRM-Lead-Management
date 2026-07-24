<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\AuthService;

class AuthController
{
    private AuthService $authService;
    private Response $response;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->response = new Response();
    }

    public function showLogin(Request $request): void
    {
        if (\App\Core\Auth::check()) {
            $this->response->redirect('/dashboard');
        }

        $this->response->render('auth.login');
    }

    public function login(Request $request): void
    {
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF token mismatch. Please try again.');
            $this->response->redirect('/login');
        }

        $credentials = [
            'email' => trim($request->input('email', '')),
            'password' => $request->input('password', '')
        ];

        $result = $this->authService->login($credentials);

        if (!$result['success']) {
            Session::setOldInput(['email' => $credentials['email']]);
            flash('error', $result['errors']['email'][0] ?? $result['message']);
            $this->response->redirect('/login');
        }

        flash('success', 'Welcome back, ' . e($result['user']['name']) . '!');
        $this->response->redirect('/dashboard');
    }

    public function logout(Request $request): void
    {
        $this->authService->logout();
        flash('success', 'You have been logged out successfully.');
        $this->response->redirect('/login');
    }

    public function apiLogin(Request $request): void
    {
        $credentials = [
            'email' => trim($request->input('email', '')),
            'password' => $request->input('password', '')
        ];

        $result = $this->authService->login($credentials);

        if (!$result['success']) {
            $this->response->json([
                'success' => false,
                'message' => $result['message'],
                'errors' => $result['errors']
            ], 401);
        }

        $this->response->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => [
                'id' => $result['user']['id'],
                'name' => $result['user']['name'],
                'email' => $result['user']['email'],
                'role' => $result['user']['role']
            ]
        ], 200);
    }
}
