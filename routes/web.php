<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\DB;
use App\Models\Activity;
use App\Models\Registration;

Route::get('/debug-rollback', function () {
    $act = Activity::where('status', 'published')->first();
    if (!$act) {
        return 'Tidak ada kegiatan published. Buat atau ubah status salah satu kegiatan menjadi published terlebih dahulu.';
    }

    $initialReg = Registration::count();
    $initialCount = $act->registered_count;
    $errorMessage = '';

    try {
        DB::transaction(function () use ($act) {
            $act->registrations()->create([
                'participant_name' => 'Peserta Uji Rollback',
                'email'            => 'rollback.test@example.com',
                'registered_at'    => now(),
            ]);

            // Simulasi error sistem sebelum counter dinaikkan
            throw new \RuntimeException('Simulasi kegagalan server sebelum registered_count dinaikkan.');
        });
    } catch (\Throwable $e) {
        $errorMessage = $e->getMessage();
    }

    $finalReg = Registration::count();
    $finalCount = $act->fresh()->registered_count;

    return response()->json([
        'status_transaksi' => 'ROLLBACK BERHASIL (Tidak Ada Data Parsial)',
        'pesan_error'      => $errorMessage,
        'tabel_registrations' => [
            'jumlah_sebelum_transaksi' => $initialReg,
            'jumlah_setelah_error'     => $finalReg,
            'keterangan'               => $initialReg === $finalReg ? 'AMAN: Data registrasi otomatis dibatalkan (0 data tertinggal).' : 'GAGAL: Terjadi kebocoran data.',
        ],
        'tabel_activities_counter' => [
            'counter_sebelum_transaksi' => $initialCount,
            'counter_setelah_error'     => $finalCount,
            'keterangan'                => $initialCount === $finalCount ? 'AMAN: Angka counter tidak bertambah.' : 'GAGAL',
        ]
    ]);
});

Route::post('/activities/{activity}/register', [ActivityController::class, 'register'])->name('activities.register');

Route::get('/activities/trash', [ActivityController::class, 'trash'])->name('activities.trash');
Route::post('/activities/{id}/restore', [ActivityController::class, 'restore'])->name('activities.restore');

Route::resource('activities', ActivityController::class);