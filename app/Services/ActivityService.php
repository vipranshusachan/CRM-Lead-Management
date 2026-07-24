<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Activity;

class ActivityService
{
    public function log(int $leadId, int $userId, string $action, array $metadata = []): int
    {
        return Activity::log($leadId, $userId, $action, $metadata);
    }

    public function getLeadActivities(int $leadId): array
    {
        return Activity::getByLead($leadId);
    }

    public function getRecentActivities(int $limit = 10, ?int $userId = null): array
    {
        return Activity::getRecent($limit, $userId);
    }
}
