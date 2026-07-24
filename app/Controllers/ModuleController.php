<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Note;
use App\Models\User;

class ModuleController
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function pipeline(Request $request): void
    {
        $user = Auth::user();
        $restrictedUserId = Auth::isMember() ? (int) $user['id'] : null;

        $rawLeads = Lead::all($restrictedUserId);
        $statuses = Lead::STATUSES;
        $pipeline = [];

        foreach ($statuses as $status) {
            $pipeline[$status] = [];
        }

        foreach ($rawLeads as $lead) {
            $st = $lead['status'];
            if (isset($pipeline[$st])) {
                $pipeline[$st][] = $lead;
            }
        }

        $members = Auth::isAdmin() ? User::allMembers() : [];

        $this->response->render('pipeline.index', [
            'pipeline' => $pipeline,
            'statuses' => $statuses,
            'members' => $members
        ]);
    }

    public function activities(Request $request): void
    {
        $user = Auth::user();
        $restrictedUserId = Auth::isMember() ? (int) $user['id'] : null;
        $activities = Activity::getRecent(30, $restrictedUserId);

        $this->response->render('activities.index', [
            'activities' => $activities
        ]);
    }

    public function notes(Request $request): void
    {
        $user = Auth::user();
        $restrictedUserId = Auth::isMember() ? (int) $user['id'] : null;
        $notes = Note::getLatest(30, $restrictedUserId);

        $this->response->render('notes.index', [
            'notes' => $notes
        ]);
    }

    public function reports(Request $request): void
    {
        $user = Auth::user();
        $restrictedUserId = Auth::isMember() ? (int) $user['id'] : null;
        $stats = Lead::getStats($restrictedUserId);

        $this->response->render('reports.index', [
            'stats' => $stats
        ]);
    }

    public function settings(Request $request): void
    {
        $user = Auth::user();

        $this->response->render('settings.index', [
            'user' => $user
        ]);
    }
}
