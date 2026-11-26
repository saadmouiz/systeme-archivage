<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeCloturee extends Model
{
    protected $table = 'annees_cloturees';

    protected $fillable = [
        'annee',
        'module',
        'closed_by',
        'closed_by_name',
        'closed_at',
        'notes',
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'annee' => 'integer',
    ];

    public static function isClosed(int $annee, string $module = 'beneficiaires'): bool
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('annees_cloturees')) {
            return false;
        }

        return static::query()
            ->where('annee', $annee)
            ->whereIn('module', [$module, 'all'])
            ->exists();
    }
}
