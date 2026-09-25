<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        Activity::query()->insert([
            [
                'title' => 'Workshop Git Dasar',
                'description' => 'Latihan kolaborasi repository.',
                'activity_date' => '2026-10-05',
                'category' => 'Workshop',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Seminar Web Quality',
                'description' => 'Pengenalan maintainability dan testing.',
                'activity_date' => '2026-10-12',
                'category' => 'Seminar',
                'status' => 'Planned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Sesi Koding Bersama',
                'description' => 'Mengerjakan Task Laravel.',
                'activity_date' => '2026-10-15',
                'category' => 'Praktikum',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Evaluasi Arsitektur Web',
                'description' => 'Review SonarQube baseline.',
                'activity_date' => '2026-10-20',
                'category' => 'Review',
                'status' => 'Ongoing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Setup Proyek Awal',
                'description' => 'Inisialisasi repositori dan framework.',
                'activity_date' => '2026-09-21',
                'category' => 'Setup',
                'status' => 'Done',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
