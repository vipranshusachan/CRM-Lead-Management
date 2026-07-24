<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Note;
use App\Models\User;
use App\Services\LeadService;

class LeadController
{
    private LeadService $leadService;
    private Response $response;

    public function __construct()
    {
        $this->leadService = new LeadService();
        $this->response = new Response();
    }

    public function index(Request $request): void
    {
        $restrictedUserId = Auth::isMember() ? Auth::id() : null;
        $filters = [
            'search' => trim($request->input('search', '')),
            'status' => $request->input('status', ''),
            'assigned_to' => $request->input('assigned_to', ''),
            'date' => $request->input('date', ''),
            'page' => $request->input('page', 1),
            'limit' => $request->input('limit', 10),
            'sort' => $request->input('sort', 'created_at'),
            'order' => $request->input('order', 'desc')
        ];

        $leadsData = $this->leadService->getLeads($filters, $restrictedUserId);
        $members = Auth::isAdmin() ? User::allMembers() : [];

        $this->response->render('leads.index', [
            'leadsData' => $leadsData,
            'filters' => $filters,
            'members' => $members,
            'statuses' => Lead::STATUSES
        ]);
    }

    public function show(Request $request, string $id): void
    {
        $leadId = (int) $id;
        $restrictedUserId = Auth::isMember() ? Auth::id() : null;
        
        $lead = $this->leadService->getLead($leadId, $restrictedUserId);
        if (!$lead) {
            flash('error', 'Lead not found or access denied.');
            $this->response->redirect('/leads');
        }

        $notes = Note::getByLead($leadId);
        $activities = Activity::getByLead($leadId);
        $members = Auth::isAdmin() ? User::allMembers() : [];

        $this->response->render('leads.show', [
            'lead' => $lead,
            'notes' => $notes,
            'activities' => $activities,
            'members' => $members,
            'statuses' => Lead::STATUSES
        ]);
    }

    public function create(Request $request): void
    {
        if (Auth::isMember()) {
            flash('error', 'Members are not authorized to create new leads.');
            $this->response->redirect('/leads');
        }

        $members = User::allMembers();
        $this->response->render('leads.create', [
            'members' => $members,
            'statuses' => Lead::STATUSES
        ]);
    }

    public function store(Request $request): void
    {
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF validation failed.');
            $this->response->redirect('/leads/create');
        }

        $data = [
            'name' => trim($request->input('name', '')),
            'email' => trim($request->input('email', '')),
            'phone' => trim($request->input('phone', '')),
            'company' => trim($request->input('company', '')),
            'source' => trim($request->input('source', 'Website')),
            'status' => $request->input('status', 'New'),
            'assigned_to' => $request->input('assigned_to')
        ];

        $result = $this->leadService->createLead($data, Auth::id());

        if (!$result['success']) {
            Session::setOldInput($data);
            flash('errors', $result['errors']);
            $this->response->redirect('/leads/create');
        }

        flash('success', 'Lead created successfully!');
        $this->response->redirect('/leads/' . $result['id']);
    }

    public function edit(Request $request, string $id): void
    {
        $leadId = (int) $id;
        $restrictedUserId = Auth::isMember() ? Auth::id() : null;

        $lead = $this->leadService->getLead($leadId, $restrictedUserId);
        if (!$lead) {
            flash('error', 'Lead not found or access denied.');
            $this->response->redirect('/leads');
        }

        $members = Auth::isAdmin() ? User::allMembers() : [];
        $this->response->render('leads.edit', [
            'lead' => $lead,
            'members' => $members,
            'statuses' => Lead::STATUSES
        ]);
    }

    public function update(Request $request, string $id): void
    {
        $leadId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF token invalid.');
            $this->response->redirect("/leads/{$leadId}/edit");
        }

        $data = [
            'name' => trim($request->input('name', '')),
            'email' => trim($request->input('email', '')),
            'phone' => trim($request->input('phone', '')),
            'company' => trim($request->input('company', '')),
            'source' => trim($request->input('source', ''))
        ];

        $result = $this->leadService->updateLead($leadId, $data, Auth::id());

        if (!$result['success']) {
            Session::setOldInput($data);
            flash('errors', $result['errors'] ?? ['error' => [$result['error']]]);
            $this->response->redirect("/leads/{$leadId}/edit");
        }

        flash('success', 'Lead updated successfully!');
        $this->response->redirect("/leads/{$leadId}");
    }

    public function updateStatus(Request $request, string $id): void
    {
        $leadId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF token invalid.');
            $this->response->redirect("/leads/{$leadId}");
        }

        $status = $request->input('status', '');
        $result = $this->leadService->updateStatus($leadId, $status, Auth::id());

        if (!$result['success']) {
            flash('error', $result['error'] ?? 'Failed to update status.');
        } else {
            flash('success', "Status updated to '{$status}'");
        }

        $this->response->redirect("/leads/{$leadId}");
    }

    public function assign(Request $request, string $id): void
    {
        $leadId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF token invalid.');
            $this->response->redirect("/leads/{$leadId}");
        }

        $assignedTo = $request->input('assigned_to') !== '' ? (int) $request->input('assigned_to') : null;
        $result = $this->leadService->assignLead($leadId, $assignedTo, Auth::id());

        if (!$result['success']) {
            flash('error', $result['error'] ?? 'Failed to assign lead.');
        } else {
            flash('success', 'Lead reassigned successfully!');
        }

        $this->response->redirect("/leads/{$leadId}");
    }

    public function addNote(Request $request, string $id): void
    {
        $leadId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF token invalid.');
            $this->response->redirect("/leads/{$leadId}");
        }

        $note = trim($request->input('note', ''));
        $result = $this->leadService->addNote($leadId, $note, Auth::id());

        if (!$result['success']) {
            flash('error', 'Note message cannot be empty.');
        } else {
            flash('success', 'Note added!');
        }

        $this->response->redirect("/leads/{$leadId}");
    }

    public function destroy(Request $request, string $id): void
    {
        $leadId = (int) $id;
        if (!Session::verifyCsrf($request->input('_token'))) {
            flash('error', 'CSRF token invalid.');
            $this->response->redirect("/leads");
        }

        $result = $this->leadService->deleteLead($leadId, Auth::id());

        if (!$result['success']) {
            flash('error', $result['error']);
        } else {
            flash('success', $result['message']);
        }

        $this->response->redirect('/leads');
    }

    // ==========================================
    // REST API ENDPOINTS
    // ==========================================

    public function apiIndex(Request $request): void
    {
        $restrictedUserId = Auth::isMember() ? Auth::id() : null;
        $filters = [
            'search' => trim($request->input('search', '')),
            'status' => $request->input('status', ''),
            'assigned_to' => $request->input('assigned_to', ''),
            'date' => $request->input('date', ''),
            'page' => $request->input('page', 1),
            'limit' => $request->input('limit', 10)
        ];

        $leadsData = $this->leadService->getLeads($filters, $restrictedUserId);
        $this->response->json(array_merge(['success' => true], $leadsData), 200);
    }

    public function apiShow(Request $request, string $id): void
    {
        $restrictedUserId = Auth::isMember() ? Auth::id() : null;
        $lead = $this->leadService->getLead((int)$id, $restrictedUserId);

        if (!$lead) {
            $this->response->json(['success' => false, 'error' => 'Lead not found or access denied'], 404);
        }

        $notes = Note::getByLead((int)$id);
        $activities = Activity::getByLead((int)$id);

        $this->response->json([
            'success' => true,
            'lead' => $lead,
            'notes' => $notes,
            'activities' => $activities
        ], 200);
    }

    public function apiStore(Request $request): void
    {
        if (Auth::isMember()) {
            $this->response->json(['success' => false, 'error' => 'Forbidden. Members cannot create leads.'], 403);
        }

        $data = [
            'name' => trim($request->input('name', '')),
            'email' => trim($request->input('email', '')),
            'phone' => trim($request->input('phone', '')),
            'company' => trim($request->input('company', '')),
            'source' => trim($request->input('source', 'Website')),
            'status' => $request->input('status', 'New'),
            'assigned_to' => $request->input('assigned_to')
        ];

        $result = $this->leadService->createLead($data, Auth::id());

        if (!$result['success']) {
            $this->response->json(['success' => false, 'errors' => $result['errors']], 422);
        }

        $this->response->json(['success' => true, 'message' => 'Lead created', 'lead' => $result['lead']], 201);
    }

    public function apiUpdate(Request $request, string $id): void
    {
        $leadId = (int) $id;
        $data = [
            'name' => trim($request->input('name', '')),
            'email' => trim($request->input('email', '')),
            'phone' => trim($request->input('phone', '')),
            'company' => trim($request->input('company', '')),
            'source' => trim($request->input('source', ''))
        ];

        $result = $this->leadService->updateLead($leadId, $data, Auth::id());

        if (!$result['success']) {
            $statusCode = isset($result['errors']) ? 422 : 404;
            $this->response->json(['success' => false, 'errors' => $result['errors'] ?? $result['error']], $statusCode);
        }

        $this->response->json(['success' => true, 'message' => 'Lead updated', 'lead' => $result['lead']], 200);
    }

    public function apiUpdateStatus(Request $request, string $id): void
    {
        $status = $request->input('status', '');
        $result = $this->leadService->updateStatus((int)$id, $status, Auth::id());

        if (!$result['success']) {
            $this->response->json(['success' => false, 'error' => $result['error']], 400);
        }

        $this->response->json(['success' => true, 'message' => 'Status updated', 'lead' => $result['lead']], 200);
    }

    public function apiAssign(Request $request, string $id): void
    {
        $assignedTo = $request->input('assigned_to') !== null ? (int)$request->input('assigned_to') : null;
        $result = $this->leadService->assignLead((int)$id, $assignedTo, Auth::id());

        if (!$result['success']) {
            $this->response->json(['success' => false, 'error' => $result['error']], 400);
        }

        $this->response->json(['success' => true, 'message' => 'Lead assigned', 'lead' => $result['lead']], 200);
    }

    public function apiAddNote(Request $request, string $id): void
    {
        $note = trim($request->input('note', ''));
        $result = $this->leadService->addNote((int)$id, $note, Auth::id());

        if (!$result['success']) {
            $this->response->json(['success' => false, 'errors' => $result['errors']], 422);
        }

        $this->response->json(['success' => true, 'message' => 'Note added', 'note_id' => $result['note_id']], 201);
    }

    public function apiActivities(Request $request, string $id): void
    {
        $activities = Activity::getByLead((int)$id);
        $this->response->json(['success' => true, 'activities' => $activities], 200);
    }

    public function apiDestroy(Request $request, string $id): void
    {
        $result = $this->leadService->deleteLead((int)$id, Auth::id());

        if (!$result['success']) {
            $this->response->json(['success' => false, 'error' => $result['error']], 404);
        }

        $this->response->json(['success' => true, 'message' => $result['message']], 200);
    }
}
