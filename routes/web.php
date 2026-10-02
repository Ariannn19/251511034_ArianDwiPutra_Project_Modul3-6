<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('activities.index');
});

Route::get('/activities/trash', [ActivityController::class, 'trash'])->name('activities.trash');
Route::post('/activities/{id}/restore', [ActivityController::class, 'restore'])->name('activities.restore');

Route::resource('activities', ActivityController::class);
