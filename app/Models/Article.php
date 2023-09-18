<?php

namespace App\Models;

use App\Enum\ArticleStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Todo
 * - apply fulltext index for better search performance
 */

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'image', 'slug', 'status'];

    protected $casts = [
        'status' => ArticleStatus::class,
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Str::startsWith($value, 'http') ? $value : Storage::url($value),
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Query scope to filter by status
     * Note: if status not provided then it will apply the filter
     */
    public function scopeMatchByStatus(Builder $query, string $status = null): void
    {
        if (!$status) {
            return;
        }
        $query->where('status', $status);
    }

    /**
     * Query scope to filter by search term
     * Note: if status not provided then it will apply the filter
     */
    public function scopeMatchByTerm(Builder $query, string $term = null): void
    {
        if (!$term) {
            return;
        }

        $query->whereFullText(['title', 'body'], $term);
    }
}
