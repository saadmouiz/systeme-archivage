<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditLock extends Model
{
    protected $fillable = [
        'lockable_type',
        'lockable_id',
        'user_id',
        'user_name',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isHeldBy(int $userId): bool
    {
        return (int) $this->user_id === $userId && !$this->isExpired();
    }
}
