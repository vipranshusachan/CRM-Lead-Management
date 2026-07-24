<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Activity
{
    public static function log(int $leadId, int $userId, string $action, array $metadata = []): int
    {
        $jsonMetadata = !empty($metadata) ? json_encode($metadata) : null;
        Database::execute(
            "INSERT INTO lead_activities (lead_id, user_id, action, metadata) VALUES (?, ?, ?, ?)",
            [$leadId, $userId, $action, $jsonMetadata]
        );
        return (int) Database::lastInsertId();
    }

    public static function getByLead(int $leadId): array
    {
        $sql = "SELECT a.*, u.name as user_name, u.role as user_role
                FROM lead_activities a
                JOIN users u ON a.user_id = u.id
                WHERE a.lead_id = ?
                ORDER BY a.created_at DESC";
        $results = Database::query($sql, [$leadId]);

        foreach ($results as &$row) {
            $row['metadata'] = !empty($row['metadata']) ? json_decode($row['metadata'], true) : [];
        }

        return $results;
    }

    public static function getRecent(int $limit = 10, ?int $userId = null): array
    {
        $params = [];
        $sql = "SELECT a.*, l.name as lead_name, u.name as user_name
                FROM lead_activities a
                JOIN leads l ON a.lead_id = l.id
                JOIN users u ON a.user_id = u.id";

        if ($userId !== null) {
            $sql .= " WHERE l.assigned_to = ?";
            $params[] = $userId;
        }

        $sql .= " ORDER BY a.created_at DESC LIMIT {$limit}";
        $results = Database::query($sql, $params);

        foreach ($results as &$row) {
            $row['metadata'] = !empty($row['metadata']) ? json_decode($row['metadata'], true) : [];
        }

        return $results;
    }
}
