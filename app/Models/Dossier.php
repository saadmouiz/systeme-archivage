<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $fillable = [
        'titre',
        'type_dossier',
        'description',
        'fichier',
        'statut'
    ];
    
    protected $casts = [
        'fichier' => 'array'
    ];
   
    
    const STATUTS = [
        'en_attente' => 'En attente',
        'confirme' => 'Confirmé',
        'refuse' => 'Refusé'
    ];

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}