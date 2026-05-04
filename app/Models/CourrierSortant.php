<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

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
                // Année du courrier (alignée sur la date saisie, pas sur un tri texte erroné)
                $year = $model->date_sortant
                    ? Carbon::parse($model->date_sortant)->format('Y')
                    : date('Y');

                // Ne pas utiliser orderBy('numero_sortant','desc') : le tri texte met "99/2026" après "100/2026"
                // et régénère un numéro déjà existant → duplicate key.
                $maxNum = self::withTrashed()
                    ->where('numero_sortant', 'like', '%/' . $year)
                    ->get()
                    ->map(function ($row) {
                        $parts = explode('/', (string) $row->numero_sortant);

                        return isset($parts[0]) ? (int) $parts[0] : 0;
                    })
                    ->max() ?? 0;

                $model->numero_sortant = sprintf('%02d/%s', $maxNum + 1, $year);
            }
        });
    }
}

