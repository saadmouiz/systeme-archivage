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
        'date_naissance',
        'genre',
        'situation_sociale',
        'situation_sociale_precision',
        'status',
        'ass_eps',
        'nom_association',
        'niveau',
        'specialite',
        'type_intervention',
        'societe',
        'niveau_scolarite',
        'services_offerts',
        'description',
        'fichier',  // Assurez-vous que ce champ est bien présent
        'ecole_id',
        'filiere',
        'annee_academique',
        'ville',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'date_naissance' => 'date',
    ];

    public const SITUATIONS_SOCIALES = [
        'precarite_economique' => 'Précarité économique (Difficultés financières)',
        'orphelin' => 'Orphelin(e) (Paternel, maternel ou absolu)',
        'monoparental_divorcee' => 'Foyer monoparental – Mère divorcée',
        'monoparental_veuve' => 'Foyer monoparental – Mère veuve',
        'monoparental_celibataire' => 'Foyer monoparental – Mère célibataire',
        'issu_eps' => 'Issu(e) d\'un Établissement de Protection Sociale (EPS) (Ancien pensionnaire)',
        'autre' => 'Autre situation de vulnérabilité',
    ];

    // Relation avec l'école
    public function ecole()
    {
        return $this->belongsTo(ArchivePartenaire::class, 'ecole_id');
    }

    public function parcours()
    {
        return $this->hasMany(BeneficiaireParcours::class)->orderByDesc('started_at')->orderByDesc('id');
    }

    public function parcoursActuel()
    {
        return $this->hasOne(BeneficiaireParcours::class)->where('is_current', true);
    }

    public function auditLogs()
    {
        return $this->morphMany(AuditLog::class, 'auditable')->latest();
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