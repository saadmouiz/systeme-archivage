<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'date',
        'heure_arrivee',
        'heure_sortie',
        'statut', // 'present', 'absent', 'retard', 'conge', etc.
        'commentaire'
    ];

    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'heure_arrivee' => 'datetime',
        'heure_sortie' => 'datetime',
    ];

    /**
     * Règles de validation pour la création/modification d'un pointage.
     * 
     * @return array
     */
    public static function rules()
    {
        return [
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'heure_arrivee' => 'nullable|date_format:H:i',
            'heure_sortie' => 'nullable|date_format:H:i|after:heure_arrivee',
            'statut' => 'required|in:present,absent,retard,conge,maladie',
            'commentaire' => 'nullable|string',
        ];
    }

    /**
     * Relation avec l'employé.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calcule la durée de travail en heures.
     *
     * @return float|null
     */
    public function getDureeTravailAttribute()
    {
        if (!$this->heure_arrivee || !$this->heure_sortie) {
            return null;
        }

        $arrivee = \Carbon\Carbon::parse($this->heure_arrivee);
        $sortie = \Carbon\Carbon::parse($this->heure_sortie);
        
        // Soustraire la pause déjeuner automatiquement si le temps de travail dépasse 6h
        $dureeTotale = $sortie->diffInMinutes($arrivee);
        if ($dureeTotale > 360) { // 6 heures en minutes
            $dureeTotale -= 60; // Soustraire 1 heure de pause
        }
        
        return round($dureeTotale / 60, 2); // Convertir en heures avec 2 décimales
    }

    /**
     * Scope pour filtrer par date.
     */
    public function scopeDateBetween($query, $debut, $fin)                         
    {
        return $query->whereBetween('date', [$debut, $fin]);
    }

    /**
     * Scope pour filtrer par statut.
     */
    public function scopeStatut($query, $statut)
    {
        return $query->where('statut', $statut);
    }
}