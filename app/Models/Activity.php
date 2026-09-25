<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'activity_date',
        'category',
        'status',
        'completed_at',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'completed_at' => 'datetime',
    ];
}
