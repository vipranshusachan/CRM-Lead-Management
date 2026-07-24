<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Auth;
use App\Core\Validator;
use App\Models\Lead;
use App\Models\Note;
use App\Models\User;
use App\Services\ActivityService;

class LeadService
{
    private ActivityService $activityService;

    public function __construct()
    {
        $this->activityService = new ActivityService();
    }

    public function getLeads(array $filters = [], ?int $restrictedUserId = null): array
    {
        return Lead::getFiltered($filters, $restrictedUserId);
    }

    public function getLead(int $id, ?int $restrictedUserId = null): ?array
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return null;
        }

        if ($restrictedUserId !== null && (int)$lead['assigned_to'] !== $restrictedUserId) {
            return null;
        }

        return $lead;
    }

    public function createLead(array $data, int $creatorId): array
    {
        $validator = new Validator($data);
        $rules = [
            'name' => 'required|min:2|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'phone',
            'company' => 'max:191',
            'status' => 'in:' . implode(',', Lead::STATUSES)
        ];

        if (!$validator->validate($rules)) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $data['created_by'] = $creatorId;
        $leadId = Lead::create($data);

        $this->activityService->log($leadId, $creatorId, 'Lead Created', [
            'name' => $data['name'],
            'email' => $data['email'],
            'status' => $data['status'] ?? 'New'
        ]);

        if (!empty($data['assigned_to'])) {
            $assignedUser = User::find((int) $data['assigned_to']);
            $this->activityService->log($leadId, $creatorId, 'Lead Assigned', [
                'assigned_to_id' => $data['assigned_to'],
                'assigned_to_name' => $assignedUser['name'] ?? 'Unknown'
            ]);
        }

        return ['success' => true, 'id' => $leadId, 'lead' => Lead::find($leadId)];
    }

    public function updateLead(int $id, array $data, int $userId): array
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return ['success' => false, 'error' => 'Lead not found'];
        }

        $validator = new Validator($data);
        $rules = [
            'name' => 'required|min:2|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'phone',
            'company' => 'max:191'
        ];

        if (!$validator->validate($rules)) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        Lead::update($id, $data);

        $this->activityService->log($id, $userId, 'Lead Updated', [
            'updated_fields' => array_keys($data)
        ]);

        return ['success' => true, 'lead' => Lead::find($id)];
    }

    public function updateStatus(int $id, string $status, int $userId): array
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return ['success' => false, 'error' => 'Lead not found'];
        }

        if (!in_array($status, Lead::STATUSES, true)) {
            return ['success' => false, 'error' => 'Invalid status value'];
        }

        $oldStatus = $lead['status'];
        if ($oldStatus === $status) {
            return ['success' => true, 'lead' => $lead];
        }

        Lead::updateStatus($id, $status);

        $this->activityService->log($id, $userId, 'Status Changed', [
            'from' => $oldStatus,
            'to' => $status
        ]);

        return ['success' => true, 'lead' => Lead::find($id)];
    }

    public function assignLead(int $id, ?int $assignedToId, int $userId): array
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return ['success' => false, 'error' => 'Lead not found'];
        }

        $assignedUser = $assignedToId ? User::find($assignedToId) : null;
        if ($assignedToId && !$assignedUser) {
            return ['success' => false, 'error' => 'Assigned user does not exist'];
        }

        Lead::assign($id, $assignedToId);

        $this->activityService->log($id, $userId, 'Lead Assigned', [
            'assigned_to_id' => $assignedToId,
            'assigned_to_name' => $assignedUser['name'] ?? 'Unassigned'
        ]);

        return ['success' => true, 'lead' => Lead::find($id)];
    }

    public function addNote(int $id, string $noteText, int $userId): array
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return ['success' => false, 'error' => 'Lead not found'];
        }

        if (empty(trim($noteText))) {
            return ['success' => false, 'errors' => ['note' => ['Note text cannot be empty']]];
        }

        $noteId = Note::create($id, $userId, $noteText);

        $this->activityService->log($id, $userId, 'Note Added', [
            'note_id' => $noteId,
            'snippet' => substr($noteText, 0, 50)
        ]);

        return ['success' => true, 'note_id' => $noteId];
    }

    public function deleteLead(int $id, int $userId): array
    {
        $lead = Lead::find($id);
        if (!$lead) {
            return ['success' => false, 'error' => 'Lead not found'];
        }

        $leadName = $lead['name'];
        Lead::delete($id);

        return ['success' => true, 'message' => "Lead '{$leadName}' deleted successfully"];
    }
}
