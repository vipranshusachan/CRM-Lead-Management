<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Note
{
    public static function create(int $leadId, int $userId, string $note): int
    {
        Database::execute(
            "INSERT INTO lead_notes (lead_id, user_id, note) VALUES (?, ?, ?)",
            [$leadId, $userId, $note]
        );
        return (int) Database::lastInsertId();
    }

    public static function getByLead(int $leadId): array
    {
        $sql = "SELECT n.*, u.name as author_name, u.email as author_email, u.role as author_role
                FROM lead_notes n
                JOIN users u ON n.user_id = u.id
                WHERE n.lead_id = ?
                ORDER BY n.created_at DESC";
        return Database::query($sql, [$leadId]);
    }

    public static function getLatest(int $limit = 5, ?int $userId = null): array
    {
        $params = [];
        $sql = "SELECT n.*, l.name as lead_name, u.name as author_name
                FROM lead_notes n
                JOIN leads l ON n.lead_id = l.id
                JOIN users u ON n.user_id = u.id";
        
        if ($userId !== null) {
            $sql .= " WHERE l.assigned_to = ?";
            $params[] = $userId;
        }

        $sql .= " ORDER BY n.created_at DESC LIMIT {$limit}";
        return Database::query($sql, $params);
    }
}
