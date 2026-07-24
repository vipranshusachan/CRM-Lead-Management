<?php

declare(strict_types=1);

require_once __DIR__ . '/runner.php';

use App\Core\Auth;
use App\Models\Activity;
use App\Models\Lead;
use App\Models\Note;
use App\Services\LeadService;

echo "\n--- Running Lead CRUD & Lifecycle Test Suite ---\n";

// Login as Admin
Auth::attempt('admin@crm.com', 'password');
$adminId = Auth::id();

$leadService = new LeadService();

// Test 1: Create Lead
$createResult = $leadService->createLead([
    'name' => 'Unit Test Lead',
    'email' => 'testlead@example.com',
    'phone' => '+1 555-9999',
    'company' => 'Test Corp',
    'source' => 'Website',
    'status' => 'New'
], $adminId);

TestRunner::assert($createResult['success'] === true, 'Lead creation via LeadService succeeds');
$leadId = $createResult['id'];

// Test 2: Verify Activity Log for Creation
$activities = Activity::getByLead($leadId);
TestRunner::assert(count($activities) >= 1 && $activities[0]['action'] === 'Lead Created', 'Activity log created for lead creation');

// Test 3: Status Transition & Audit Trail
$statusResult = $leadService->updateStatus($leadId, 'Qualified', $adminId);
TestRunner::assert($statusResult['success'] === true && $statusResult['lead']['status'] === 'Qualified', 'Status transition to Qualified succeeds');

$activitiesUpdated = Activity::getByLead($leadId);
$hasStatusActivity = false;
foreach ($activitiesUpdated as $act) {
    if ($act['action'] === 'Status Changed') {
        $hasStatusActivity = true;
        break;
    }
}
TestRunner::assert($hasStatusActivity, 'Activity logged for status change');

// Test 4: Assign Lead
$assignResult = $leadService->assignLead($leadId, 2, $adminId);
TestRunner::assert($assignResult['success'] === true && (int)$assignResult['lead']['assigned_to'] === 2, 'Lead assignment to user 2 succeeds');

// Test 5: Add Note
$noteResult = $leadService->addNote($leadId, 'Automated test note content.', $adminId);
TestRunner::assert($noteResult['success'] === true, 'Note added to lead');
$notes = Note::getByLead($leadId);
TestRunner::assert(count($notes) === 1 && $notes[0]['note'] === 'Automated test note content.', 'Note verified in database');

// Test 6: Filtering & Pagination
$filtered = $leadService->getLeads(['search' => 'Unit Test Lead', 'page' => 1, 'limit' => 10]);
TestRunner::assert($filtered['total'] >= 1, 'Search filter returns newly created lead');

// Cleanup Test Lead
$leadService->deleteLead($leadId, $adminId);
TestRunner::assert(Lead::find($leadId) === null, 'Test lead cleaned up / deleted');

if (basename($_SERVER['PHP_SELF']) === 'LeadTest.php') {
    TestRunner::summary();
}
