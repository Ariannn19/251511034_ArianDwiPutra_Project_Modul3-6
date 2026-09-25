<?php

namespace App\Services;

use App\Exceptions\InvalidStatusTransitionException;
use App\Models\Activity;

class ActivityService
{
    private const ALLOWED_TRANSITIONS = [
        'Planned' => ['Planned', 'Ongoing'],
        'Ongoing' => ['Ongoing', 'Done'],
        'Done' => ['Done'],
    ];

    public function createActivity(array $data): Activity
    {
        if (($data['status'] ?? 'Planned') === 'Done') {
            $data['completed_at'] = now();
        }

        return Activity::query()->create($data);
    }

    public function updateActivity(Activity $activity, array $data): Activity
    {
        $currentStatus = $activity->status;
        $newStatus = $data['status'] ?? $currentStatus;

        $this->ensureValidTransition($currentStatus, $newStatus);

        if ($newStatus === 'Done' && $currentStatus !== 'Done') {
            $data['completed_at'] = now();
        } elseif ($newStatus !== 'Done') {
            $data['completed_at'] = null;
        }

        $activity->update($data);

        return $activity;
    }

    public function deleteActivity(Activity $activity): void
    {
        $activity->delete();
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::ALLOWED_TRANSITIONS[$current] ?? [];

        if (! in_array($next, $allowed, true)) {
            throw new InvalidStatusTransitionException("Perubahan status dari {$current} ke {$next} tidak diperbolehkan.");
        }
    }
}
