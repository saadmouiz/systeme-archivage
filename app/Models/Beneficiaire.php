<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiaire extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'reference',
        'nom',
        'prenom',
        'cin',
        'age',
        'genre',
        'status',
        'ass_eps',
        'niveau',
        'specialite',
        'type_intervention',
        'societe',
        'description',
        'fichier',  // Assurez-vous que ce champ est bien présent
        'ecole_id',
        'filiere',
        'ville',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    // Relation avec l'école
    public function ecole()
    {
        return $this->belongsTo(ArchivePartenaire::class, 'ecole_id');
    }

    // Accesseur pour le nom complet
    public function getNomCompletAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    // Nouvelle méthode pour obtenir l'URL de téléchargement
    public function getDownloadUrlAttribute()
    {
        return route('archives.beneficiaires.download', $this->id);
    }
}