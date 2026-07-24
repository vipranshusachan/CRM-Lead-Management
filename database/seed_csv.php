<?php

define('BASE_PATH', dirname(__DIR__));
require_once BASE_PATH . '/app/Helpers/functions.php';

// PSR-4 Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $baseDir = BASE_PATH . '/app/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require $file;
});

$csvFile = BASE_PATH . '/geoleads_export_2025-12-07.csv';
if (!file_exists($csvFile)) {
    echo "CSV file not found\n";
    exit(1);
}

$handle = fopen($csvFile, 'r');
$header = fgetcsv($handle);
$count = 0;

while (($row = fgetcsv($handle)) !== false) {
    if (empty($row[0])) continue;
    
    $name = trim($row[0]);
    $phone = trim($row[1] ?? '');
    $email = trim($row[5] ?? '');
    
    if (empty($email)) {
        $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($name));
        $email = $cleanName . '@geoleads.com';
    }
    
    $company = $name;
    $source = 'GeoLeads Export';
    $status = 'New';
    
    $exists = \App\Core\Database::fetch("SELECT id FROM leads WHERE name = ?", [$name]);
    if (!$exists) {
        \App\Core\Database::execute(
            "INSERT INTO leads (name, email, phone, company, source, status, assigned_to, created_by, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 2, 1, NOW(), NOW())",
            [$name, $email, $phone, $company, $source, $status]
        );
        $leadId = \App\Core\Database::lastInsertId();
        
        $summary = trim($row[8] ?? '');
        $address = trim($row[6] ?? '');
        $noteText = "GeoLeads Info:\nAddress: {$address}\nSummary: {$summary}";
        
        \App\Core\Database::execute(
            "INSERT INTO lead_notes (lead_id, user_id, note, created_at) VALUES (?, 1, ?, NOW())",
            [(int)$leadId, $noteText]
        );
        
        \App\Core\Database::execute(
            "INSERT INTO lead_activities (lead_id, user_id, action, metadata, created_at) VALUES (?, 1, ?, ?, NOW())",
            [(int)$leadId, 'Lead Imported', json_encode(['source' => 'geoleads_export_2025-12-07.csv', 'rating' => $row[3] ?? '', 'address' => $address])]
        );
        
        $count++;
    }
}

fclose($handle);
echo "Successfully seeded {$count} leads from CSV into MySQL database.\n";
