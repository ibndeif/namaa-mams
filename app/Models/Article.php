<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;


/**
 * Todo
 * - apply fulltext index for better search performance
 */

class Article extends Model
{
    use HasFactory;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
        $query->where(function (Builder $q) use ($term) {
            $q
                ->where('title', 'LIKE', '%' . $term . '%')
                ->orWhere('body', 'LIKE', '%' . $term . '%');
        });
    }
}
