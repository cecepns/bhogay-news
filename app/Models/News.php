<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class News extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'thumbnail',
        'category_id',
        'views',
        'status',
    ];

    /**
     * Get the category that owns the news.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all page views for this news.
     */
    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    /**
     * Get the tags that belong to the news.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Scope a query to only include published news.
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('status', 'published');
    }

    /**
     * Scope a query to only include draft news.
     */
    public function scopeDraft(Builder $query): void
    {
        $query->where('status', 'draft');
    }

    /**
     * Scope a query to order by most viewed.
     */
    public function scopeMostViewed(Builder $query): void
    {
        $query->orderBy('views', 'desc');
    }

    /**
     * Scope a query to order by latest.
     */
    public function scopeLatest(Builder $query): void
    {
        $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope a query to filter by tag.
     */
    public function scopeWithTag(Builder $query, string $tagSlug): void
    {
        $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    /**
     * Scope a query to filter by multiple tags.
     */
    public function scopeWithTags(Builder $query, array $tagSlugs): void
    {
        $query->whereHas('tags', function ($q) use ($tagSlugs) {
            $q->whereIn('slug', $tagSlugs);
        });
    }

    /**
     * Increment the view count for this news.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Get the image URL for the news.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        
        return asset('images/blog-01.jpg');
    }

    /**
     * Get the published at date for the news.
     */
    public function getPublishedAtAttribute(): ?string
    {
        if ($this->status === 'published') {
            return $this->updated_at;
        }
        
        return null;
    }


}
