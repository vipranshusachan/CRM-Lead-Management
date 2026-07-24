<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\LeadController;
use App\Controllers\UserController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

/** @var App\Core\Router $router */

// Guest Routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->post('/logout', [AuthController::class, 'logout']);

// Authenticated Routes
$router->group(['middleware' => [AuthMiddleware::class]], function ($router) {
    // Dashboard
    $router->get('/', [DashboardController::class, 'index']);
    $router->get('/dashboard', [DashboardController::class, 'index']);

    // Leads
    $router->get('/leads', [LeadController::class, 'index']);
    $router->get('/leads/create', [LeadController::class, 'create']);
    $router->post('/leads', [LeadController::class, 'store']);
    $router->get('/leads/{id}', [LeadController::class, 'show']);
    $router->get('/leads/{id}/edit', [LeadController::class, 'edit']);
    $router->post('/leads/{id}', [LeadController::class, 'update']);
    $router->post('/leads/{id}/status', [LeadController::class, 'updateStatus']);
    $router->post('/leads/{id}/notes', [LeadController::class, 'addNote']);

    // Admin Only Lead Routes
    $router->group(['middleware' => [AdminMiddleware::class]], function ($router) {
        $router->post('/leads/{id}/assign', [LeadController::class, 'assign']);
        $router->post('/leads/{id}/delete', [LeadController::class, 'destroy']);

        // User Management
        $router->get('/users', [UserController::class, 'index']);
        $router->get('/users/create', [UserController::class, 'create']);
        $router->post('/users', [UserController::class, 'store']);
        $router->get('/users/{id}/edit', [UserController::class, 'edit']);
        $router->post('/users/{id}', [UserController::class, 'update']);
        $router->post('/users/{id}/delete', [UserController::class, 'destroy']);
    });
});
