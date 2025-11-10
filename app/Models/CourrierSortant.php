<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourrierSortant extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero_sortant',
        'date_sortant',
        'destinataire',
        'sujet',
        'fichier',
        'description'
    ];

    protected $casts = [
        'date_sortant' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->numero_sortant)) {
                $lastNum = self::withTrashed()->orderBy('numero_sortant', 'desc')->first();
                if ($lastNum) {
                    // Format: 01/2024, 02/2024, etc.
                    $parts = explode('/', $lastNum->numero_sortant);
                    $num = isset($parts[0]) ? (int)$parts[0] : 0;
                    $year = date('Y');
                    $model->numero_sortant = sprintf('%02d/%s', $num + 1, $year);
                } else {
                    $model->numero_sortant = '01/' . date('Y');
                }
            }
        });
    }
}

