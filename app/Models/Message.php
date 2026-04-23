<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'user_id',
        'recipient_id',
        'body',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    public function user(): BelongsTo
    {
        return $this->sender();
    }

    public function scopeBetweenUsers(Builder $query, int $firstUserId, int $secondUserId): Builder
    {
        return $query
            ->where(function (Builder $q) use ($firstUserId, $secondUserId) {
                $q->where('user_id', $firstUserId)
                    ->where('recipient_id', $secondUserId);
            })
            ->orWhere(function (Builder $q) use ($firstUserId, $secondUserId) {
                $q->where('user_id', $secondUserId)
                    ->where('recipient_id', $firstUserId);
            });
    }
}
