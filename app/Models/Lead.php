<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class Lead
{
    public const STATUSES = [
        'New',
        'Contacted',
        'Qualified',
        'Proposal Sent',
        'Negotiation',
        'Won',
        'Lost'
    ];

    public static function all(?int $assignedUserOnly = null): array
    {
        $sql = "SELECT l.*, 
                       u_assigned.name as assigned_to_name,
                       u_creator.name as created_by_name
                FROM leads l
                LEFT JOIN users u_assigned ON l.assigned_to = u_assigned.id
                LEFT JOIN users u_creator ON l.created_by = u_creator.id";
        $params = [];
        if ($assignedUserOnly !== null) {
            $sql .= " WHERE l.assigned_to = ?";
            $params[] = $assignedUserOnly;
        }
        $sql .= " ORDER BY l.created_at DESC";
        return Database::query($sql, $params);
    }

    public static function find(int $id): ?array
    {
        $sql = "SELECT l.*, 
                       u_assigned.name as assigned_to_name, 
                       u_assigned.email as assigned_to_email,
                       u_creator.name as created_by_name
                FROM leads l
                LEFT JOIN users u_assigned ON l.assigned_to = u_assigned.id
                LEFT JOIN users u_creator ON l.created_by = u_creator.id
                WHERE l.id = ?";
        return Database::fetch($sql, [$id]);
    }

    public static function getFiltered(array $filters = [], ?int $assignedUserOnly = null): array
    {
        $sql = "SELECT l.*, 
                       u_assigned.name as assigned_to_name,
                       u_creator.name as created_by_name
                FROM leads l
                LEFT JOIN users u_assigned ON l.assigned_to = u_assigned.id
                LEFT JOIN users u_creator ON l.created_by = u_creator.id
                WHERE 1=1";
        $params = [];

        if ($assignedUserOnly !== null) {
            $sql .= " AND l.assigned_to = ?";
            $params[] = $assignedUserOnly;
        }

        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $sql .= " AND (l.name LIKE ? OR l.email LIKE ? OR l.company LIKE ? OR l.phone LIKE ?)";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($filters['status'])) {
            $sql .= " AND l.status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['assigned_to'])) {
            $sql .= " AND l.assigned_to = ?";
            $params[] = (int) $filters['assigned_to'];
        }

        if (!empty($filters['date'])) {
            $sql .= " AND DATE(l.created_at) = ?";
            $params[] = $filters['date'];
        }

        // Sorting
        $allowedSort = ['id', 'name', 'email', 'company', 'status', 'created_at'];
        $sort = in_array($filters['sort'] ?? '', $allowedSort, true) ? $filters['sort'] : 'created_at';
        $order = strtoupper($filters['order'] ?? '') === 'ASC' ? 'ASC' : 'DESC';

        $sql .= " ORDER BY l.{$sort} {$order}";

        // Pagination
        $page = max(1, (int) ($filters['page'] ?? 1));
        $limit = max(1, min(100, (int) ($filters['limit'] ?? 10)));
        $offset = ($page - 1) * $limit;

        // Count Total
        $countSql = "SELECT COUNT(*) as total FROM (" . $sql . ") as count_table";
        $totalResult = Database::fetch($countSql, $params);
        $total = (int) ($totalResult['total'] ?? 0);

        $sql .= " LIMIT {$limit} OFFSET {$offset}";
        $data = Database::query($sql, $params);

        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'last_page' => (int) ceil($total / $limit)
        ];
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO leads (name, email, phone, company, source, status, assigned_to, created_by)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        Database::execute($sql, [
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['source'] ?? 'Website',
            $data['status'] ?? 'New',
            !empty($data['assigned_to']) ? (int) $data['assigned_to'] : null,
            (int) $data['created_by']
        ]);

        return (int) Database::lastInsertId();
    }

    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE leads SET name = ?, email = ?, phone = ?, company = ?, source = ?, updated_at = NOW() WHERE id = ?";
        return Database::execute($sql, [
            $data['name'],
            $data['email'],
            $data['phone'] ?? null,
            $data['company'] ?? null,
            $data['source'] ?? null,
            $id
        ]);
    }

    public static function updateStatus(int $id, string $status): bool
    {
        return Database::execute("UPDATE leads SET status = ?, updated_at = NOW() WHERE id = ?", [$status, $id]);
    }

    public static function assign(int $id, ?int $userId): bool
    {
        return Database::execute("UPDATE leads SET assigned_to = ?, updated_at = NOW() WHERE id = ?", [$userId, $id]);
    }

    public static function delete(int $id): bool
    {
        return Database::execute("DELETE FROM leads WHERE id = ?", [$id]);
    }

    public static function getStats(?int $userId = null): array
    {
        $params = [];
        $where = "";
        if ($userId !== null) {
            $where = " WHERE assigned_to = ?";
            $params[] = $userId;
        }

        $total = (int) (Database::fetch("SELECT COUNT(*) as cnt FROM leads" . $where, $params)['cnt'] ?? 0);
        
        $myLeads = 0;
        if ($userId !== null) {
            $myLeads = $total;
        } else {
            $myLeads = (int) (Database::fetch("SELECT COUNT(*) as cnt FROM leads WHERE assigned_to IS NOT NULL")['cnt'] ?? 0);
        }

        $won = (int) (Database::fetch("SELECT COUNT(*) as cnt FROM leads" . ($where ? $where . " AND status = 'Won'" : " WHERE status = 'Won'"), $params)['cnt'] ?? 0);
        $lost = (int) (Database::fetch("SELECT COUNT(*) as cnt FROM leads" . ($where ? $where . " AND status = 'Lost'" : " WHERE status = 'Lost'"), $params)['cnt'] ?? 0);
        $newToday = (int) (Database::fetch("SELECT COUNT(*) as cnt FROM leads" . ($where ? $where . " AND DATE(created_at) = CURDATE()" : " WHERE DATE(created_at) = CURDATE()"), $params)['cnt'] ?? 0);

        // Status breakdown
        $statusCounts = Database::query("SELECT status, COUNT(*) as cnt FROM leads" . $where . " GROUP BY status", $params);
        $pipeline = [];
        foreach (self::STATUSES as $st) {
            $pipeline[$st] = 0;
        }
        foreach ($statusCounts as $row) {
            $pipeline[$row['status']] = (int) $row['cnt'];
        }

        return [
            'total' => $total,
            'my_leads' => $myLeads,
            'won' => $won,
            'lost' => $lost,
            'new_today' => $newToday,
            'pipeline' => $pipeline
        ];
    }
}
