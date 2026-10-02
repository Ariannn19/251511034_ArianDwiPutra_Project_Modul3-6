<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'category',
        'code',
        'title',
        'description',
        'activity_date',
        'status',
    ];

    protected $casts = [
        'activity_date' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Local Scope untuk pencarian berdasarkan title atau code.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        return $query->when($keyword, function ($q, $keyword) {
            $q->where(function ($sub) use ($keyword) {
                $sub->where('title', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            });
        });
    }

    /**
     * Local Scope untuk menggabungkan search, filter category_id, filter status, dan sort tanggal.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // 1. Search keyword (title atau code)
        $query->search($filters['search'] ?? null);

        // 2. Filter Kategori
        $query->when($filters['category_id'] ?? null, function ($q, $categoryId) {
            $q->where('category_id', $categoryId);
        });

        // 3. Filter Status
        $query->when($filters['status'] ?? null, function ($q, $status) {
            $q->where('status', $status);
        });

        // 4. Sort Waktu (terbaru / terlama berdasarkan activity_date)
        $query->when($filters['sort'] ?? null, function ($q, $sort) {
            if ($sort === 'oldest') {
                $q->oldest('activity_date');
            } else {
                $q->latest('activity_date');
            }
        }, function ($q) {
            $q->latest('activity_date');
        });

        return $query;
    }
}
