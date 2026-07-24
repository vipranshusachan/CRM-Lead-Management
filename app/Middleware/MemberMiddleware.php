<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Request;

class MemberMiddleware
{
    public function handle(Request $request): void
    {
        if (!Auth::check()) {
            if ($request->isJson()) {
                json_response(['success' => false, 'error' => 'Unauthenticated.'], 401);
            } else {
                flash('error', 'Please log in.');
                redirect('/login');
            }
        }
    }
}
