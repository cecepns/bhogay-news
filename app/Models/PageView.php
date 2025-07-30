<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class PageView extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'page_views';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'ip_address',
        'user_agent',
        'url',
        'page_type',
        'news_id',
        'viewed_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Get the news that owns the page view.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    /**
     * Scope a query to filter by page type.
     */
    public function scopeByPageType(Builder $query, string $pageType): void
    {
        $query->where('page_type', $pageType);
    }

    /**
     * Scope a query to filter by today's views.
     */
    public function scopeToday(Builder $query): void
    {
        $query->whereDate('viewed_at', today());
    }

    /**
     * Scope a query to get unique visitors.
     */
    public function scopeUniqueVisitors(Builder $query): void
    {
        $query->distinct('ip_address');
    }
}
