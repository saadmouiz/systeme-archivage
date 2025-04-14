<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchiveFinancier extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'titre',
        'type',
        'reference',
        'montant',
        'date_document',
        'description',
        'fichier',
        'annee_financiere',
        'statut'
    ];

    protected $casts = [
        'date_document' => 'date',
        'montant' => 'decimal:2',
        'annee_financiere' => 'integer'
    ];

    public function getStatutColorAttribute()
    {
        return [
            'payé' => 'green',
            'en attente' => 'yellow',
            'validé' => 'blue',
            'rejeté' => 'red'
        ][$this->statut] ?? 'gray';
    }

    public function getFormattedMontantAttribute()
    {
        return number_format($this->montant, 2, ',', ' ') . ' DH';
    }
}