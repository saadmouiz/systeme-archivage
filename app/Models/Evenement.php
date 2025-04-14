<?php
// app/Models/Evenement.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evenement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'titre',
        'description',
        'type',
        'categorie',
        'date_debut',
        'date_fin',
        'lieu',
        'nombre_participants',
        'budget',
        'statut'
    ];

    protected $dates = [
        'date_debut',
        'date_fin'
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime'
    ];

    public function medias()
    {
        return $this->hasMany(EvenementMedia::class);
    }

    public function temoignages()
    {
        return $this->hasMany(Temoignage::class);
    }
}