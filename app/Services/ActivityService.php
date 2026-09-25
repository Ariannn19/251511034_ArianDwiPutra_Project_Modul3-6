<?php

namespace App\Services;

use App\Exceptions\InvalidStatusTransitionException;
use App\Models\Activity;

class ActivityService
{
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

        // 1. Status Done tidak boleh ke Planned ataupun Ongoing
        if ($currentStatus === 'Done' && in_array($newStatus, ['Planned', 'Ongoing'])) {
            throw new InvalidStatusTransitionException("Status yang sudah Selesai (Done) tidak boleh diubah kembali ke {$newStatus}.");
        }

        // 2. Status Planned harus melalui Ongoing sebelum Done 
        if ($currentStatus === 'Planned' && $newStatus === 'Done') {
            throw new InvalidStatusTransitionException('Status Rencana (Planned) harus melalui Sedang Berjalan (Ongoing) sebelum Selesai (Done).');
        }

        // 3. Status Ongoing tidak boleh mundur kembali ke Planned
        if ($currentStatus === 'Ongoing' && $newStatus === 'Planned') {
            throw new InvalidStatusTransitionException('Status Sedang Berjalan (Ongoing) tidak boleh diubah mundur ke Rencana (Planned).');
        }

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
}
