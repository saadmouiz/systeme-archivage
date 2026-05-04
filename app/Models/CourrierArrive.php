<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourrierArrive extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'numero_arrive',
        'date_arrive',
        'numero_document',
        'date_document',
        'expediteur',
        'pieces_jointes',
        'renvoi',
        'signature_recu',
        'fichier',
        'description'
    ];

    protected $casts = [
        'date_arrive' => 'date',
        'date_document' => 'date',
        'pieces_jointes' => 'boolean',
        'renvoi' => 'boolean',
        'signature_recu' => 'boolean'
    ];

    public function getPiecesJointesTextAttribute()
    {
        return $this->pieces_jointes ? 'Oui' : 'Non';
    }

    public function getRenvoiTextAttribute()
    {
        return $this->renvoi ? 'Oui' : 'Non';
    }

    public function getSignatureRecuTextAttribute()
    {
        return $this->signature_recu ? 'Reçu' : 'Non';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->numero_arrive)) {
                // Ne pas utiliser orderBy('numero_arrive','desc') sur une chaîne : le tri texte
                // met "9" après "10", donc le dernier enregistrement peut être 9 → +1 = 10 déjà pris.
                $maxNum = self::withTrashed()
                    ->pluck('numero_arrive')
                    ->filter(fn ($v) => $v !== null && $v !== '')
                    ->map(fn ($v) => is_numeric((string) $v) ? (int) $v : 0)
                    ->max() ?? 0;

                $model->numero_arrive = (string) ($maxNum + 1);
            }
        });
    }
}

