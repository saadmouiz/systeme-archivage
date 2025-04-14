<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchiveProjet extends Model
{
    use SoftDeletes;

    protected $table = 'archives_projets';

    protected $fillable = [
        'titre',
        'reference',
        'description',
        'date_debut',
        'date_fin_prevue',
        'statut',
        'type_projet',
        'budget_total',
        'responsable',
        'localisation',
        'objectifs',
        'commentaires'
    ];

    protected $dates = [
        'date_debut',
        'date_fin_prevue',
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];

    protected $casts = [
        'budget_total' => 'float'
    ];

    // Relations
    public function fichiers()
    {
        return $this->morphMany(Fichier::class, 'documentable');
    }

    public function taches()
    {
        return $this->hasMany(TacheProjet::class, 'archive_projet_id');
    }

    public function partenaires()
    {
        return $this->belongsToMany(Partenaire::class, 'projet_partenaire', 'archive_projet_id', 'partenaire_id');
    }

    public function beneficiaires()
    {
        return $this->belongsToMany(Beneficiaire::class, 'projet_beneficiaire', 'archive_projet_id', 'beneficiaire_id');
    }
}