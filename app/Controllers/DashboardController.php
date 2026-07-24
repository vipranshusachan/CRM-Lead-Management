<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Note;

class DashboardController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function index(Request $request): void
    {
        $user = Auth::user();
        $restrictedUserId = Auth::isMember() ? (int) $user['id'] : null;

        $stats = Lead::getStats($restrictedUserId);
        $recentActivities = Activity::getRecent(6, $restrictedUserId);
        $latestNotes = Note::getLatest(5, $restrictedUserId);

        $this->response->render('dashboard.index', [
            'user' => $user,
            'stats' => $stats,
            'recentActivities' => $recentActivities,
            'latestNotes' => $latestNotes
        ]);
    }
}
