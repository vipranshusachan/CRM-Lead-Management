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
        $allLeads = Lead::all($restrictedUserId);
        $members = Auth::isAdmin() ? User::allMembers() : [];

        // Sources breakdown
        $sources = [];
        foreach ($allLeads as $l) {
            $src = $l['source'] ?? 'Website';
            $sources[$src] = ($sources[$src] ?? 0) + 1;
        }

        // Member performance breakdown
        $memberStats = [];
        if (Auth::isAdmin()) {
            foreach ($members as $m) {
                $mLeads = array_filter($allLeads, fn($ld) => (int)($ld['assigned_to'] ?? 0) === (int)$m['id']);
                $mWon = array_filter($mLeads, fn($ld) => $ld['status'] === 'Won');
                $mLost = array_filter($mLeads, fn($ld) => $ld['status'] === 'Lost');
                $totalCount = count($mLeads);
                $wonCount = count($mWon);

                $memberStats[] = [
                    'id' => $m['id'],
                    'name' => $m['name'],
                    'email' => $m['email'],
                    'assigned_count' => $totalCount,
                    'won_count' => $wonCount,
                    'lost_count' => count($mLost),
                    'conversion_rate' => $totalCount > 0 ? round(($wonCount / $totalCount) * 100, 1) : 0
                ];
            }
        }

        $this->response->render('reports.index', [
            'stats' => $stats,
            'leads' => $allLeads,
            'sources' => $sources,
            'memberStats' => $memberStats
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
