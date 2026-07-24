<?php

use App\Controllers\AuthController;
use App\Controllers\LeadController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminMiddleware;

/** @var App\Core\Router $router */

// Public API Routes
$router->post('/api/login', [AuthController::class, 'apiLogin']);

// Authenticated API Routes
$router->group(['middleware' => [AuthMiddleware::class]], function ($router) {
    $router->get('/api/leads', [LeadController::class, 'apiIndex']);
    $router->get('/api/leads/{id}', [LeadController::class, 'apiShow']);
    $router->post('/api/leads', [LeadController::class, 'apiStore']);
    $router->put('/api/leads/{id}', [LeadController::class, 'apiUpdate']);
    $router->post('/api/leads/{id}/status', [LeadController::class, 'apiUpdateStatus']);
    $router->post('/api/leads/{id}/notes', [LeadController::class, 'apiAddNote']);
    $router->get('/api/leads/{id}/activities', [LeadController::class, 'apiActivities']);

    // Admin Only API Routes
    $router->group(['middleware' => [AdminMiddleware::class]], function ($router) {
        $router->delete('/api/leads/{id}', [LeadController::class, 'apiDestroy']);
        $router->post('/api/leads/{id}/assign', [LeadController::class, 'apiAssign']);
    });
});
