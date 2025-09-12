<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'cin',
        'heure_arrivee',
    ];

    protected $casts = [
        'heure_arrivee' => 'datetime'
    ];
}