<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Request;

class AdminMiddleware
{
    public function handle(Request $request): void
    {
        if (!Auth::check() || !Auth::isAdmin()) {
            if ($request->isJson()) {
                json_response(['success' => false, 'error' => 'Forbidden. Admin privileges required.'], 403);
            } else {
                flash('error', 'Access denied. Administrator privileges required.');
                redirect('/dashboard');
            }
        }
    }
}
