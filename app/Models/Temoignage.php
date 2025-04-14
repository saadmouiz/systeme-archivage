<?php
// app/Models/Temoignage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    protected $fillable = [
        'evenement_id',
        'nom_temoin',
        'contenu',
        'est_approuve'
    ];

    protected $casts = [
        'est_approuve' => 'boolean'
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}