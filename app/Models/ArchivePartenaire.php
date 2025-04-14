<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchivePartenaire extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nom',
        'type',
        'description',
        'date_debut_partenariat', // Notez que c'est date_debut_partenariat et non date_partenariat
        'contact_principal',
        'email',
        'telephone',
        'adresse',
        'fichier',
        'statut_partenariat', // Changement de statut à statut_partenariat
        'responsable',
        'contributions'
    ];

    protected $casts = [
        'date_partenariat' => 'date'
    ];
    public function getStatutColorAttribute()
    {
        return [
            'actif' => 'green',
            'en négociation' => 'yellow',
            'potentiel' => 'blue',
            'inactif' => 'red'
        ][$this->statut_partenariat] ?? 'gray';
    }
}