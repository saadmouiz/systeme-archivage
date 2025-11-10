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
                $lastNum = self::withTrashed()->orderBy('numero_arrive', 'desc')->first();
                $model->numero_arrive = $lastNum ? (int)$lastNum->numero_arrive + 1 : 1;
            }
        });
    }
}

