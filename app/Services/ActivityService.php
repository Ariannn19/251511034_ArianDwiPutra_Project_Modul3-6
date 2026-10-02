<?php

namespace App\Services;

use App\Models\Activity;
use App\Exceptions\InvalidStatusTransitionException;

class ActivityService
{

    private const ALLOWED_TRANSITIONS = [
        'draft'     => ['draft', 'published', 'cancelled'],
        'published' => ['published', 'completed', 'cancelled'],
        'completed' => ['completed'],
        'cancelled' => ['cancelled'],
    ];

    /**
     * Membuat kegiatan baru.
     */
    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    /**
     * Memperbarui kegiatan dengan validasi transisi status dan kelengkapan data.
     */
    public function update(Activity $activity, array $data): Activity
    {
        $currentStatus = $activity->status;
        $nextStatus = $data['status'] ?? $currentStatus;

        // 1. Validasi alur transisi status
        $this->ensureValidTransition($currentStatus, $nextStatus);

        if ($nextStatus === 'published') {
            $description = $data['description'] ?? $activity->description;
            if (empty(trim((string) $description))) {
                throw new InvalidStatusTransitionException('Kegiatan tidak dapat dipublikasikan karena deskripsi belum diisi.');
            }
        }

        $activity->update($data);

        return $activity->refresh();
    }

    private function ensureValidTransition(string $current, string $next): void
    {
        $allowed = self::ALLOWED_TRANSITIONS[$current] ?? [];

        if (!in_array($next, $allowed, true)) {
            throw new InvalidStatusTransitionException("Perubahan status dari '{$current}' ke '{$next}' tidak diizinkan.");
        }
    }
}
