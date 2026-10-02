<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Registration;
use App\Exceptions\InvalidStatusTransitionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ActivityService
{
    private const ALLOWED_TRANSITIONS = [
        'draft'     => ['draft', 'published', 'cancelled'],
        'published' => ['published', 'completed', 'cancelled'],
        'completed' => ['completed'],
        'cancelled' => ['cancelled'],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $currentStatus = $activity->status;
        $nextStatus = $data['status'] ?? $currentStatus;

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

    /**
     * 
     *
     * @throws ValidationException
     */
    public function registerParticipant(Activity $activity, array $participantData): Registration
    {
        // IC-01: Pendaftaran hanya untuk activity berstatus published
        if ($activity->status !== 'published') {
            throw ValidationException::withMessages([
                'activity' => 'Pendaftaran hanya diperbolehkan untuk kegiatan berstatus published.'
            ]);
        }

        if ($activity->activity_date && $activity->activity_date->isPast()) {
            throw ValidationException::withMessages([
                'activity_date' => 'Pendaftaran ditolak karena waktu pelaksanaan kegiatan sudah lewat.'
            ]);
        }

        if ($activity->registered_count >= $activity->capacity) {
            throw ValidationException::withMessages([
                'capacity' => 'Pendaftaran ditolak karena kuota kapasitas sudah penuh.'
            ]);
        }

        return DB::transaction(function () use ($activity, $participantData) {
            $registration = $activity->registrations()->create([
                'participant_name' => $participantData['name'],
                'email'            => $participantData['email'],
                'registered_at'    => now(),
            ]);

            $activity->increment('registered_count');

            return $registration;
        });
    }
}
