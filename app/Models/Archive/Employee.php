<?php

namespace App\Models\Archive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pointage;

class Employee extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'prenom',
        'fonction',
        'type_contrat',
        'date_embauche',
        'date_fin_contrat',
        'actif',
        'photo',
        'notes'
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array
     */
    protected $casts = [
        'date_embauche' => 'date',
        'date_fin_contrat' => 'date',
        'actif' => 'boolean',
    ];

    /**
     * Règles de validation pour la création/modification d'un employé.
     * 
     * @return array
     */
    public static function rules($id = null)
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'fonction' => 'required|string|max:255',
            'type_contrat' => 'required|in:CDI,CDD,Stage,Autre',
            'date_embauche' => 'required|date',
            'date_fin_contrat' => 'nullable|date|after_or_equal:date_embauche',
            'actif' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Retourne le nom complet de l'employé.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    /**
     * Relation avec les pointages.
     */
    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }

    /**
     * Récupère les pointages d'un mois spécifique.
     * 
     * @param int $mois
     * @param int $annee
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPointagesMensuel($mois, $annee)
    {
        $debut = \Carbon\Carbon::createFromDate($annee, $mois, 1)->startOfMonth();
        $fin = \Carbon\Carbon::createFromDate($annee, $mois, 1)->endOfMonth();
        
        return $this->pointages()
            ->whereBetween('date', [$debut, $fin])
            ->orderBy('date')
            ->get();
    }

    /**
     * Calcule le nombre de jours travaillés dans un mois.
     * 
     * @param int $mois
     * @param int $annee
     * @return int
     */
    public function getJoursTravaillesMensuel($mois, $annee)
    {
        return $this->pointages()
            ->whereBetween('date', [
                \Carbon\Carbon::createFromDate($annee, $mois, 1)->startOfMonth(),
                \Carbon\Carbon::createFromDate($annee, $mois, 1)->endOfMonth()
            ])
            ->where('statut', 'present')
            ->count();
    }

    /**
     * Calcule le nombre de jours d'absence dans un mois.
     * 
     * @param int $mois
     * @param int $annee
     * @return int
     */
    public function getAbsencesMensuel($mois, $annee)
    {
        return $this->pointages()
            ->whereBetween('date', [
                \Carbon\Carbon::createFromDate($annee, $mois, 1)->startOfMonth(),
                \Carbon\Carbon::createFromDate($annee, $mois, 1)->endOfMonth()
            ])
            ->where('statut', 'absent')
            ->count();
    }

    /**
     * Récupère l'ancienneté de l'employé en années.
     *
     * @return int
     */
    public function getAncienneteAttribute()
    {
        return $this->date_embauche->diffInYears(now());
    }

    /**
     * Détermine si l'employé est en fin de contrat dans les 30 jours.
     *
     * @return bool
     */
    public function getFinContratProcheAttribute()
    {
        if (!$this->date_fin_contrat) {
            return false;
        }
        
        return $this->date_fin_contrat->diffInDays(now()) <= 30 && $this->date_fin_contrat->isFuture();
    }

    /**
     * Scope pour filtrer les employés actifs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActif($query)
    {
        return $query->where('actif', true);
    }

    /**
     * Scope pour filtrer par type de contrat.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeContratType($query, $type)
    {
        return $query->where('type_contrat', $type);
    }
}