<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeneficiaireParcours extends Model
{
    protected $table = 'beneficiaire_parcours';

    protected $fillable = [
        'beneficiaire_id',
        'ecole_id',
        'filiere',
        'niveau',
        'annee_academique',
        'statut',
        'is_current',
        'notes',
        'started_at',
        'ended_at',
        'created_by',
    ];

    protected $casts = [
        'is_current' => 'boolean',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public const STATUTS_FIN = [
        'Validé' => 'Validé',
        'Réorienté' => 'Réorienté',
        'Abandon' => 'Abandon',
    ];

    public function beneficiaire()
    {
        return $this->belongsTo(Beneficiaire::class);
    }

    public function ecole()
    {
        return $this->belongsTo(ArchivePartenaire::class, 'ecole_id');
    }
}
